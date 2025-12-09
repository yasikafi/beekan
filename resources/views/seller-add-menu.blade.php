<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tambah Menu - BeeKan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(135deg, var(--brand-orange), #FF6B6B);">
    <div class="container container-custom">
      <a class="navbar-brand text-white d-flex align-items-center gap-2" href="{{ url('/seller') }}">
        <span style="font-size: 1.2rem;">&larr;</span> Kembali ke Dashboard
      </a>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <h3 class="fw-bold mb-4 text-center">🍳 Tambah Menu Baru</h3>
                
                <form action="{{ url('/seller/add-menu/store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Makanan</label>
                        <input type="text" name="name" class="form-control py-2" placeholder="Contoh: Nasi Gila" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control py-2" placeholder="15000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok Awal</label>
                            <input type="number" name="stock" class="form-control py-2" value="50" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Pedas manis gurih..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Tema Warna Kartu</label>
                        <select name="image_color" class="form-select py-2">
                            <option value="linear-gradient(135deg, #ffeaa7, #fab1a0)">Kuning - Oren (Hangat)</option>
                            <option value="linear-gradient(135deg, #81ecec, #74b9ff)">Biru Langit (Segar)</option>
                            <option value="linear-gradient(135deg, #55efc4, #00b894)">Hijau Mint (Sehat)</option>
                            <option value="linear-gradient(135deg, #a29bfe, #6c5ce7)">Ungu (Manis)</option>
                            <option value="linear-gradient(135deg, #ff7675, #d63031)">Merah (Pedas)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">
                        SIMPAN MENU
                    </button>
                </form>
            </div>
        </div>
    </div>
  </div>

</body>
</html>