<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BeeKan - Pilih Peran</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background: var(--muted-bg);">

  <div class="container text-center">
    <h1 class="fw-bold mb-2">Selamat Datang di BeeKan</h1>
    <p class="text-muted mb-5">Platform Kantin Digital Binus - Anti Antri, Langsung Pick-up!</p>

    <div class="row justify-content-center g-4">
      <div class="col-md-5 col-lg-4">
        <a href="{{ url('/login?role=buyer') }}" class="text-decoration-none text-dark">
            <div class="card p-5 role-card h-100">
                <div class="role-icon">😋</div>
                <h3 class="fw-bold">Saya Pembeli</h3>
                <p class="text-muted small">Mahasiswa/Dosen yang mau jajan tanpa antri.</p>
            </div>
        </a>
      </div>

      <div class="col-md-5 col-lg-4">
        <a href="{{ url('/login?role=seller') }}" class="text-decoration-none text-dark">
            <div class="card p-5 role-card h-100">
                <div class="role-icon">👨‍🍳</div>
                <h3 class="fw-bold">Saya Penjual</h3>
                <p class="text-muted small">Pemilik kantin yang ingin kelola pesanan & flash sale.</p>
            </div>
        </a>
      </div>
    </div>
  </div>

</body>
</html>