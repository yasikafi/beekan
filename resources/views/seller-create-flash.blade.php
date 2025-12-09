<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Buat Flash Sale - BeeKan Seller</title>
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
            
            <div class="text-center mb-4">
                <span style="font-size: 4rem;">⚡</span>
                <h2 class="fw-bold mt-2">Buat Flash Sale</h2>
                <p class="text-muted">Bikin mahasiswa rebutan menu andalanmu!</p>
            </div>

            <div class="card border-0 shadow-lg rounded-4 p-4">
                <form action="{{ url('/seller/create-flash/store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Menu yang Mau Didiskon</label>
                        <select name="product_id" class="form-select py-3 bg-light border-0 fw-bold" required>
                            <option value="" selected disabled>-- Pilih Menu --</option>
                            
                            @foreach($myMenu as $menu)
                                <option value="{{ $menu->id }}">
                                    {{ $menu->name }} (Harga Asli: Rp {{ number_format($menu->price) }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-danger">Harga Flash Sale (Rp)</label>
                            <input type="number" name="price" class="form-control py-3 border-danger" placeholder="Contoh: 10000" required>
                            <div class="form-text text-danger">*Harus lebih murah dari harga asli</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Kuota Stok</label>
                            <input type="number" name="stock" class="form-control py-3" placeholder="Contoh: 20" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-flash w-100 py-3 fw-bold fs-5 shadow-sm mt-2">
                        TERBITKAN SEKARANG 🚀
                    </button>
                </form>
            </div>

        </div>
    </div>
  </div>

</body>
</html>