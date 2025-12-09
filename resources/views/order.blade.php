<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pesanan Saya - BeeKan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  <nav class="navbar navbar-expand-lg">
    <div class="container container-custom">
      <a class="navbar-brand" href="{{ url('/buyer') }}">BeeKan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse">
        <span class="navbar-toggler-icon" style="filter: invert(1)"></span>
      </button>

      <div class="collapse navbar-collapse" id="navCollapse">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="{{ url('/buyer') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link fw-bold text-white" href="#">Order</a></li> <li class="nav-item">
    <a href="{{ url('/flash-sale') }}" class="btn btn-sm btn-flash ms-lg-3">Flash Sale ⚡</a>
</li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="py-5">
    <div class="container" style="max-width: 700px;"> <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0">Orderan Kamu</h2>
            <button id="clearHistoryBtn" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus Riwayat</button>
        </div>

        <div id="orderListContainer" class="d-flex flex-column gap-3">
            </div>

    </div>
  </main>

</body>
</html>