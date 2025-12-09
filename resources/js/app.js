import * as bootstrap from 'bootstrap';

// ==========================================
// 1. DATA MASTER
// ==========================================

// Ambil data menu dari Database (lewat variabel window yang disuntik di View)
const vendors = window.dbMenu || {};

// Helper Rupiah
const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

// ==========================================
// 2. LOGIKA APLIKASI
// ==========================================
const initApp = () => {

    // --- A. GLOBAL FUNCTION: BELI FLASH SALE (VERSI DATABASE) ---
    // Dipanggil langsung dari tombol "Ambil Sekarang" di file Blade Flash Sale
    // Menerima data lengkap dari HTML
    window.buyFlashSale = function(id, vendor, name, price, color) {
        
        // 1. Siapkan Data Order
        const newOrder = {
            id: Date.now(),
            vendor: vendor,
            item: name + " (⚡FLASH SALE)",
            price: price,
            qty: 1, // Flash sale cuma boleh 1
            total: price,
            imgColor: color,
            status: 'Menunggu Konfirmasi'
        };

        // 2. Simpan ke LocalStorage (Biar lgsg muncul di list HP Pembeli)
        const orders = JSON.parse(localStorage.getItem('beekan_orders')) || [];
        orders.unshift(newOrder);
        localStorage.setItem('beekan_orders', JSON.stringify(orders));

        // 3. KIRIM KE DATABASE (PENTING!)
        // Ambil token keamanan dari <head>
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfTokenMeta) {
            const csrfToken = csrfTokenMeta.getAttribute('content');
            
            fetch('/order/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(newOrder)
            })
            .then(res => console.log("Flash sale saved to DB"))
            .catch(err => console.error("Error saving DB:", err));
        }

        // 4. Notifikasi & Redirect
        alert(`HOKI PARAH! Kamu dapet ${name}! Cek Orderanmu.`);
        window.location.href = '/order';
    };

    // --- B. TIMER MUNDUR (Jalan di halaman Flash Sale) ---
    const timerEl = document.getElementById('countdownTimer');
    if(timerEl) {
        let time = 7200; // 2 Jam
        setInterval(() => {
             if(time > 0) { 
                 time--; 
                 timerEl.textContent = new Date(time * 1000).toISOString().substr(11, 8).replace(/:/g, ' : '); 
             }
        }, 1000);
    }

    // --- C. LOGIKA MODAL MENU (REGULER - TETAP DIPERTAHANKAN) ---
    const modalEl = document.getElementById('vendorModal');
    if (modalEl) { 
        const bsModal = new bootstrap.Modal(modalEl);
        const modalTitle = document.getElementById('vendorModalLabel');
        const modalBody = document.getElementById('vendorModalBody');
        const modalFooter = document.getElementById('vendorModalFooter');
        
        let currentVendorName = '', currentMenuItem = null, currentQuantity = 1;

        // Tampilkan List Menu Toko
        window.showMenuList = function(vendorName) {
            currentVendorName = vendorName;
            modalTitle.textContent = vendorName + ' — Menu';
            const items = vendors[vendorName] || [];
            
            if(items.length === 0) {
                modalBody.innerHTML = '<p class="text-center text-muted py-3">Menu belum tersedia.</p>';
                modalFooter.innerHTML = '<button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>';
            } else {
                let html = '<div class="list-group list-group-flush">';
                items.forEach(item => {
                    html += `<div class="list-group-item d-flex justify-content-between align-items-center py-3 px-0 border-bottom-dashed">
                                <div><h6 class="mb-1 fw-bold">${item.name}</h6><small class="text-muted">${formatRupiah(item.price)}</small></div>
                                <button class="btn btn-sm btn-outline-primary px-3" onclick="showOrderDetail(${item.id})">Pilih</button>
                             </div>`;
                });
                html += '</div>'; 
                modalBody.innerHTML = html; 
                modalFooter.innerHTML = '<button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>'; 
            }
            bsModal.show();
        };

        // Tampilkan Detail Order (Pop-up)
        window.showOrderDetail = function(itemId) {
            const item = vendors[currentVendorName].find(i => i.id === itemId);
            currentMenuItem = item; currentQuantity = 1; modalTitle.textContent = 'Order Detail';
            
            modalBody.innerHTML = `<div class="row">
                <div class="col-md-5 mb-3 mb-md-0"><div class="detail-img-container rounded-4" style="background:${item.imgColor}"><span>🍽️</span></div></div>
                <div class="col-md-7"><h5 class="fw-bold mb-1">${currentVendorName}</h5><h3 class="fw-bold mb-3 text-brand-orange">${item.name}</h3>
                <div class="p-3 bg-light rounded-3 border"><small class="fw-bold text-muted d-block mb-1">Deskripsi</small><p class="mb-0 small">${item.desc}</p></div></div>
            </div>`;
            
            modalFooter.innerHTML = `<div class="d-flex justify-content-between align-items-center w-100">
                <div class="quantity-control d-flex align-items-center bg-light rounded-pill p-1 border">
                    <button class="btn btn-sm btn-icon btn-minus rounded-circle" onclick="changeQty(-1)">-</button>
                    <span class="qty-display fw-bold mx-3">1</span>
                    <button class="btn btn-sm btn-icon btn-plus btn-primary rounded-circle" onclick="changeQty(1)">+</button>
                </div>
                <button class="btn btn-primary btn-pesan fw-bold px-4 py-2 rounded-pill" onclick="saveOrder()">
                    Pesan - <span id="totalPrice">${formatRupiah(item.price)}</span>
                </button>
            </div>`;
        };

        // Logic Ubah Jumlah (+/-)
        window.changeQty = function(d) { 
            let n = currentQuantity + d; 
            if (n >= 1) { 
                currentQuantity = n; 
                document.querySelector('.qty-display').textContent = n; 
                document.getElementById('totalPrice').textContent = formatRupiah(currentMenuItem.price * n); 
            } 
        };

        // Simpan Order Reguler
        window.saveOrder = function() {
            const newOrder = {
                id: Date.now(),
                vendor: currentVendorName,
                item: currentMenuItem.name,
                price: currentMenuItem.price,
                qty: currentQuantity,
                total: currentMenuItem.price * currentQuantity,
                imgColor: currentMenuItem.imgColor,
                status: 'Menunggu Konfirmasi'
            };

            // Save Local
            const orders = JSON.parse(localStorage.getItem('beekan_orders')) || [];
            orders.unshift(newOrder);
            localStorage.setItem('beekan_orders', JSON.stringify(orders));

            // Save DB
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfTokenMeta) {
                const csrfToken = csrfTokenMeta.getAttribute('content');
                fetch('/order/save', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(newOrder)
                });
            }

            bsModal.hide();
            alert('Mantap! Pesanan berhasil dibuat.');
        };
        
        // Listener Tombol "Lihat Menu"
        document.querySelectorAll('.lihat-menu').forEach(btn => btn.addEventListener('click', () => showMenuList(btn.dataset.vendor)));
    }

    // --- D. HALAMAN ORDER LIST (RIWAYAT PESANAN) ---
    const orderContainer = document.getElementById('orderListContainer');
    if (orderContainer) {
        function renderOrders() {
            const ord = JSON.parse(localStorage.getItem('beekan_orders')) || [];
            if (ord.length === 0) { 
                orderContainer.innerHTML = '<div class="text-center py-5"><h1 style="font-size: 5rem;">🥡</h1><h4 class="fw-bold mt-3">Belum ada pesanan</h4><a href="/buyer" class="btn btn-primary rounded-pill px-4 mt-2">Cari Makan</a></div>'; 
                return; 
            }
            orderContainer.innerHTML = ord.map(o => `
                <div class="order-card">
                    <div class="order-img-box" style="background: ${o.imgColor}"><span>🍽️</span></div>
                    <div class="order-info">
                        <div class="toko-name">${o.vendor}</div>
                        <div class="menu-name">${o.item} <span class="text-muted fw-normal fs-6">x${o.qty}</span></div>
                        <div class="menu-price">${formatRupiah(o.total)}</div>
                        <span class="badge bg-info bg-opacity-10 text-info mt-2 px-2 py-1 rounded-pill" style="font-size:0.7rem;">${o.status}</span>
                    </div>
                    <div class="arrow-icon">&rsaquo;</div>
                </div>`).join('');
        }
        renderOrders();
        
        const clr = document.getElementById('clearHistoryBtn'); 
        if(clr) clr.addEventListener('click', () => { 
            if(confirm('Hapus semua?')) { 
                localStorage.removeItem('beekan_orders'); 
                renderOrders(); 
            } 
        });
    }
};

// Jalankan App
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initApp); else initApp();