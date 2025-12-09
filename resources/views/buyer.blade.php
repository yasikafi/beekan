<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BeeKan - Kantin Favorit</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <script>
      window.dbMenu = @json($menuData);
  </script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container container-custom">
      <a class="navbar-brand" href="#">BeeKan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse">
        <span class="navbar-toggler-icon" style="filter: invert(1)"></span>
      </button>

      <div class="collapse navbar-collapse" id="navCollapse">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
          
          <li class="nav-item">
              <a class="nav-link position-relative" href="{{ url('/order') }}">
                  Order
                  <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="display:none;" id="navBadge"></span>
              </a>
          </li>
          
          <li class="nav-item">
    <a href="{{ url('/flash-sale') }}" class="btn btn-sm btn-flash ms-lg-3">Flash Sale ⚡</a>

          <li class="nav-item ms-lg-3">
    <form action="{{ url('/logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
            Keluar
        </button>
    </form>
</li>
</li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="hero">
    <div class="container container-custom">
      <h1>Selamat Datang di BeeKan</h1>
      <p>Pilih kantin favoritmu dan nikmati hidangan lezat setiap hari!</p>
    </div>
  </header>

  <main class="mb-5">
    <div class="container container-custom">
      <div class="row g-4">
        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Bakmie Nikmat</h3></div>
            <div class="card-body">
              <div class="vendor-title">Bakmie Nikmat</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Bakmie Nikmat">Lihat Menu</button>
            </div>
          </div>
        </div>

        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Rasa Nusantara</h3></div>
            <div class="card-body">
              <div class="vendor-title">Rasa Nusantara</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Rasa Nusantara">Lihat Menu</button>
            </div>
          </div>
        </div>

        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Cerita Kopi</h3></div>
            <div class="card-body">
              <div class="vendor-title">Cerita Kopi</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Cerita Kopi">Lihat Menu</button>
            </div>
          </div>
        </div>

        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Good Waffle</h3></div>
            <div class="card-body">
              <div class="vendor-title">Good Waffle</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Good Waffle">Lihat Menu</button>
            </div>
          </div>
        </div>

        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Selera Anda</h3></div>
            <div class="card-body">
              <div class="vendor-title">Selera Anda</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Selera Anda">Lihat Menu</button>
            </div>
          </div>
        </div>

        <div class="col-md-4 vendor-card">
          <div class="card">
            <div class="card-img-top"><h3>Chicken Oriental</h3></div>
            <div class="card-body">
              <div class="vendor-title">Chicken Oriental</div>
            </div>
            <div class="card-footer px-3">
              <button class="btn btn-primary fullwidth lihat-menu" data-vendor="Chicken Oriental">Lihat Menu</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="vendorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
        <div class="modal-header border-0 pb-0 pt-4 px-4">
          <h5 class="modal-title fs-4" id="vendorModalLabel">Menu</h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body p-4" id="vendorModalBody">
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
        <div class="modal-footer pt-0 px-4 pb-4" id="vendorModalFooter"></div>
      </div>
    </div>
  </div>

</body>
</html>