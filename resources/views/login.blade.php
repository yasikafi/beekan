<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Masuk - BeeKan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-bg d-flex align-items-center justify-content-center vh-100">

  <div class="login-container w-100">
    <div class="text-center mb-4">
      <h2 class="fw-bold text-dark">Halo, Cess! 👋</h2>
      <p class="text-muted">Silakan masuk ke akun Binusmu</p>
    </div>

    <form action="{{ url('/login-process') }}" method="POST">
      @csrf @if($errors->any())
        <div class="alert alert-danger p-2 small text-center mb-3 rounded-3">
            {{ $errors->first() }}
        </div>
      @endif

      <div class="mb-3">
        <label class="form-label fw-bold small">Email Binus</label>
        <input type="email" name="email" class="form-control py-2" placeholder="nama@binus.ac.id" required>
      </div>
      
      <div class="mb-4">
        <label class="form-label fw-bold small">Password</label>
        <input type="password" name="password" class="form-control py-2" placeholder="••••••••" required>
      </div>
      
      <button type="submit" class="btn btn-primary fullwidth py-2 fw-bold" style="background: var(--brand-orange); border:none;">
        MASUK SEKARANG
      </button>

      <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="text-muted small text-decoration-none">← Kembali ke menu awal</a>
      </div>
    </form>
  </div>

</body>
</html>