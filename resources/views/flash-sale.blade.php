<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>⚡ FLASH SALE - BeeKan</title>
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flash-sale-page">

  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container container-custom">
      <a class="navbar-brand" href="{{ url('/buyer') }}">BeeKan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse">
        <span class="navbar-toggler-icon" style="filter: invert(1)"></span>
      </button>

      <div class="collapse navbar-collapse" id="navCollapse">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="{{ url('/buyer') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/order') }}">Order</a></li>
          <li class="nav-item"><a href="#" class="btn btn-sm btn-flash ms-lg-3 active-flash">Flash Sale ⚡</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="flash-hero text-center text-white py-5">
    <div class="container">
        <div class="mb-3 flash-icon-container">
            <span class="giant-lightning">⚡</span>
        </div>
        <h1 class="fw-bold display-4 text-uppercase fst-italic">Flash Sale Serbu!</h1>
        <p class="fs-5 mb-4 opacity-75">Diskon gila-gilaan, stok sisa dikit doang!</p>
        
        <div class="d-inline-flex gap-3 align-items-center bg-white text-danger px-4 py-2 rounded-pill shadow fw-bold fs-4">
            <span>Berakhir dalam:</span>
            <span id="countdownTimer">02 : 15 : 40</span>
        </div>
    </div>
  </header>

  <main class="py-5">
    <div class="container container-custom">
        <div id="flashSaleContainer" class="row g-4">
            
            @forelse($flashItems as $item)
                @php
                    // Hitung Diskon Pake PHP
                    $original = $item->product->price;
                    $discount = $item->discount_price;
                    // Rumus Persentase Diskon
                    $persen = round((($original - $discount) / $original) * 100);
                @endphp
                
                <div class="col-md-4">
                    <div class="card flash-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="discount-badge">-{{ $persen }}%</div>
                        
                        <div class="card-img-top" style="background: {{ $item->product->image_color }}; height: 180px; display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:4rem;">⚡</span>
                        </div>
    
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-1">{{ $item->product->name }}</h5>
                            <p class="text-muted small mb-2">{{ $item->product->seller->shop_name }}</p>
    
                            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                <span class="price-old">Rp {{ number_format($original) }}</span>
                                <span class="price-new">Rp {{ number_format($discount) }}</span>
                            </div>
    
                            <div class="text-start mb-3 px-2">
                                <div class="d-flex justify-content-between">
                                    <span class="stock-label">🔥 Segera Habis!</span>
                                    <span class="stock-label text-dark">Sisa: {{ $item->stock }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: {{ ($item->stock / 50) * 100 }}%"></div>
                                </div>
                            </div>
    
                            <button class="btn btn-danger w-100 rounded-pill fw-bold py-2" 
                                onclick="buyFlashSale({{ $item->id }}, '{{ $item->product->seller->shop_name }}', '{{ $item->product->name }}', {{ $discount }}, '{{ $item->product->image_color }}')">
                                AMBIL SEKARANG ⚡
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center w-100 py-5 text-muted">
                    <h3 style="font-size: 3rem;">⏳</h3>
                    <p>Belum ada Flash Sale saat ini. Tunggu bentar lagi ya!</p>
                </div>
            @endforelse

        </div>
    </div>
  </main>

</body>
</html>