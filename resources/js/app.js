import * as bootstrap from 'bootstrap';

// ==========================================
// 1. DATA MASTER
// ==========================================


const vendors = window.dbMenu || {};

// Data Flash Sale Default (Bawaan Pabrik)
const defaultFlashSales = [
    { 
        id: 101, vendor: "Cerita Kopi", name: "Es Kopi Susu Gula Aren", 
        originalPrice: 18000, price: 9000, stock: 12, totalStock: 100, 
        imgColor: "linear-gradient(135deg, #fdcb6e, #e17055)", desc: "Seger banget diskon 50%!"
    },
    { 
        id: 102, vendor: "Good Waffle", name: "Waffle Hemat", 
        originalPrice: 25000, price: 12000, stock: 3, totalStock: 20, 
        imgColor: "linear-gradient(135deg, #6c5ce7, #a29bfe)", desc: "Waffle plain enak murah meriah."
    }
];

// Helper Rupiah
const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

// ==========================================
// 2. LOGIKA APLIKASI
// ==========================================
const initApp = () => {

    // --- A. HALAMAN SELLER: BUAT FLASH SALE (BARU!) ---
    const createFlashForm = document.getElementById('createFlashForm');
    const menuSelect = document.getElementById('menuSelect');

    if (createFlashForm && menuSelect) {
        // 1. Isi Dropdown Menu (Ambil punya Bakmie Nikmat aja buat demo)
        const myMenu = vendors["Bakmie Nikmat"];
        myMenu.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.name} - ${formatRupiah(item.price)}`;
            menuSelect.appendChild(option);
        });

        // 2. Handle Submit Form
        createFlashForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const selectedId = parseInt(menuSelect.value);
            const flashPrice = parseInt(document.getElementById('flashPrice').value);
            const flashStock = parseInt(document.getElementById('flashStock').value);
            
            // Cari data asli menu yg dipilih
            const originalItem = myMenu.find(i => i.id === selectedId);

            if (!originalItem) return;

            // Validasi harga
            if (flashPrice >= originalItem.price) {
                alert("Harga Flash Sale harus lebih murah dari harga asli dong, Cess! 😅");
                return;
            }

            // Bikin Objek Flash Sale Baru
            const newItem = {
                id: Date.now(), // ID Unik
                vendor: "Bakmie Nikmat", // Hardcode karena kita login sbg Bakmie Nikmat
                name: originalItem.name,
                originalPrice: originalItem.price,
                price: flashPrice,
                stock: flashStock,
                totalStock: flashStock, // Buat progress bar
                imgColor: originalItem.imgColor,
                desc: originalItem.desc
            };

            // SIMPAN KE LOCAL STORAGE
            // Ambil data lama, gabung sama yg baru
            const currentSales = JSON.parse(localStorage.getItem('beekan_flash_sales')) || defaultFlashSales;
            currentSales.unshift(newItem); // Taruh paling atas
            localStorage.setItem('beekan_flash_sales', JSON.stringify(currentSales));

            alert("BERHASIL! Flash Sale sudah terbit. Yuk cek di halaman Pembeli.");
            window.location.href = '/seller'; // Balik ke dashboard
        });
    }


    // --- B. HALAMAN BUYER: TAMPILKAN FLASH SALE ---
    const flashContainer = document.getElementById('flashSaleContainer');
    if (flashContainer) {
        // Ambil data dari LocalStorage (kalau kosong pake default)
        const flashItems = JSON.parse(localStorage.getItem('beekan_flash_sales')) || defaultFlashSales;
        
        flashContainer.innerHTML = flashItems.map(item => {
            const stockPercent = (item.stock / item.totalStock) * 100;
            const discountPercent = Math.round(((item.originalPrice - item.price) / item.originalPrice) * 100);

            return `
            <div class="col-md-4">
                <div class="card flash-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="discount-badge">-${discountPercent}%</div>
                    <div class="card-img-top" style="background: ${item.imgColor}; height: 180px; display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:4rem;">⚡</span>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-1">${item.name}</h5>
                        <p class="text-muted small mb-2">${item.vendor}</p>
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                            <span class="price-old">${formatRupiah(item.originalPrice)}</span>
                            <span class="price-new">${formatRupiah(item.price)}</span>
                        </div>
                        <div class="text-start mb-3 px-2">
                            <div class="d-flex justify-content-between">
                                <span class="stock-label">🔥 Segera Habis!</span>
                                <span class="stock-label text-dark">Sisa: ${item.stock}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-flash progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ${stockPercent}%"></div>
                            </div>
                        </div>
                        <button class="btn btn-danger w-100 rounded-pill fw-bold py-2 btn-flash-buy" onclick="buyFlashSale(${item.id})">AMBIL SEKARANG ⚡</button>
                    </div>
                </div>
            </div>`;
        }).join('');

        // Timer Mundur
        let time = 7200; 
        const timerEl = document.getElementById('countdownTimer');
        if(timerEl) setInterval(() => {
             if(time > 0) { time--; timerEl.textContent = new Date(time * 1000).toISOString().substr(11, 8).replace(/:/g, ' : '); }
        }, 1000);
    }

    // Function Global: Beli Flash Sale (Buyer)
    window.buyFlashSale = function(id, vendor, name, price, color) {
    const newOrder = {
        id: Date.now(),
        vendor: vendor,
        item: name + " (⚡FLASH SALE)",
        price: price,
        qty: 1,
        total: price,
        imgColor: color,
        status: 'Menunggu Konfirmasi'
    };

    // Simpan ke LocalStorage & Database (Pake fungsi saveOrder yg udah ada logic-nya)
    // Tapi karena saveOrder pake variabel global modal, kita fetch manual aja disini biar cepet:
    
    // 1. Save Local
    const orders = JSON.parse(localStorage.getItem('beekan_orders')) || [];
    orders.unshift(newOrder);
    localStorage.setItem('beekan_orders', JSON.stringify(orders));

    // 2. Save DB
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/order/save', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
        body: JSON.stringify(newOrder)
    });

    alert(`HOKI PARAH! Kamu dapet ${name}! Cek Orderanmu.`);
    window.location.href = '/order';
};

    // --- C. LOGIKA LAINNYA (Modal Menu, Order List, dll) TETAP JALAN ---
    // (Kode ini persis sama kayak sebelumnya, cuma dirapikan biar gak kepanjangan)
    const modalEl = document.getElementById('vendorModal');
    if (modalEl) { 
        const bsModal = new bootstrap.Modal(modalEl);
        const modalTitle = document.getElementById('vendorModalLabel');
        const modalBody = document.getElementById('vendorModalBody');
        const modalFooter = document.getElementById('vendorModalFooter');
        
        let currentVendorName = '', currentMenuItem = null, currentQuantity = 1;

        window.showMenuList = function(vendorName) {
            currentVendorName = vendorName;
            modalTitle.textContent = vendorName + ' — Menu';
            const items = vendors[vendorName] || [];
            let html = '<div class="list-group list-group-flush">';
            items.forEach(item => {
                html += `<div class="list-group-item d-flex justify-content-between align-items-center py-3 px-0 border-bottom-dashed"><div><h6 class="mb-1 fw-bold">${item.name}</h6><small class="text-muted">${formatRupiah(item.price)}</small></div><button class="btn btn-sm btn-outline-primary px-3" onclick="showOrderDetail(${item.id})">Pilih</button></div>`;
            });
            html += '</div>'; modalBody.innerHTML = html; modalFooter.innerHTML = '<button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>'; bsModal.show();
        };

        window.showOrderDetail = function(itemId) {
            const item = vendors[currentVendorName].find(i => i.id === itemId);
            currentMenuItem = item; currentQuantity = 1; modalTitle.textContent = 'Order Detail';
            modalBody.innerHTML = `<div class="row"><div class="col-md-5 mb-3 mb-md-0"><div class="detail-img-container rounded-4" style="background:${item.imgColor}"><span>🍽️</span></div></div><div class="col-md-7"><h5 class="fw-bold mb-1">${currentVendorName}</h5><h3 class="fw-bold mb-3 text-brand-orange">${item.name}</h3><div class="p-3 bg-light rounded-3 border"><small class="fw-bold text-muted d-block mb-1">Deskripsi</small><p class="mb-0 small">${item.desc}</p></div></div></div>`;
            modalFooter.innerHTML = `<div class="d-flex justify-content-between align-items-center w-100"><div class="quantity-control d-flex align-items-center bg-light rounded-pill p-1 border"><button class="btn btn-sm btn-icon btn-minus rounded-circle" onclick="changeQty(-1)">-</button><span class="qty-display fw-bold mx-3">1</span><button class="btn btn-sm btn-icon btn-plus btn-primary rounded-circle" onclick="changeQty(1)">+</button></div><button class="btn btn-primary btn-pesan fw-bold px-4 py-2 rounded-pill" onclick="saveOrder()">Pesan - <span id="totalPrice">${formatRupiah(item.price)}</span></button></div>`;
        };

        window.changeQty = function(d) { let n = currentQuantity + d; if (n >= 1) { currentQuantity = n; document.querySelector('.qty-display').textContent = n; document.getElementById('totalPrice').textContent = formatRupiah(currentMenuItem.price * n); } };

        window.saveOrder = function() {
            // A. Siapkan Data
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

            // B. Simpan ke LocalStorage (Biar tampilan Buyer tetep mulus)
            const orders = JSON.parse(localStorage.getItem('beekan_orders')) || [];
            orders.unshift(newOrder);
            localStorage.setItem('beekan_orders', JSON.stringify(orders));

            // C. KIRIM KE DATABASE (JALUR BELAKANG) 🔥
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/order/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(newOrder) // Kirim data
            })
            .then(response => {
                if(response.ok) {
                    console.log("Sukses masuk database!");
                } else {
                    console.log("Gagal masuk database, tapi ada di local.");
                }
            })
            .catch(error => console.error('Error:', error));

            // D. Tutup Modal & Kasih Notif
            bsModal.hide();
            alert('Mantap! Pesanan berhasil dibuat dan dikirim ke Penjual!');
        };
        
        document.querySelectorAll('.lihat-menu').forEach(btn => btn.addEventListener('click', () => showMenuList(btn.dataset.vendor)));
    }

    const orderContainer = document.getElementById('orderListContainer');
    if (orderContainer) {
        function renderOrders() {
            const ord = JSON.parse(localStorage.getItem('beekan_orders')) || [];
            if (ord.length === 0) { orderContainer.innerHTML = '<div class="text-center py-5"><h1 style="font-size: 5rem;">🥡</h1><h4 class="fw-bold mt-3">Belum ada pesanan</h4><a href="/buyer" class="btn btn-primary rounded-pill px-4 mt-2">Cari Makan</a></div>'; return; }
            orderContainer.innerHTML = ord.map(o => `<div class="order-card"><div class="order-img-box" style="background: ${o.imgColor}"><span>🍽️</span></div><div class="order-info"><div class="toko-name">${o.vendor}</div><div class="menu-name">${o.item} <span class="text-muted fw-normal fs-6">x${o.qty}</span></div><div class="menu-price">${formatRupiah(o.total)}</div><span class="badge bg-info bg-opacity-10 text-info mt-2 px-2 py-1 rounded-pill" style="font-size:0.7rem;">${o.status}</span></div><div class="arrow-icon">&rsaquo;</div></div>`).join('');
        }
        renderOrders();
        const clr = document.getElementById('clearHistoryBtn'); if(clr) clr.addEventListener('click', () => { if(confirm('Hapus semua?')) { localStorage.removeItem('beekan_orders'); renderOrders(); } });
    }
};

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initApp); else initApp();