<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Penjual - BeeKan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #f8f9fa;">

  <nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(135deg, var(--brand-orange), #FF6B6B);">
    <div class="container container-custom">
      <a class="navbar-brand text-white d-flex align-items-center gap-2" href="#">
        BeeKan 
        <span class="badge bg-white text-danger px-2 py-1 rounded-1" style="font-size: 0.7rem; font-weight: 800;">SELLER</span>
      </a>
      
      <div class="ms-auto">
        <form action="{{ url('/logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-3">Keluar</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container container-custom py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Halo, {{ Auth::user()->shop_name }}!</h2>
            <p class="text-muted">Kelola pesanan masuk dan atur stokmu.</p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ url('/seller/add-menu') }}" class="btn btn-primary fw-bold px-4 py-2 shadow-sm text-decoration-none rounded-pill" style="background: var(--brand-blue); border:none;">
                + Tambah Menu
            </a>
            <a href="{{ url('/seller/create-flash') }}" class="btn btn-flash fw-bold px-4 py-2 shadow-sm text-decoration-none">
                ⚡ Flash Sale
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="text-muted small fw-bold">ORDER MASUK</h5>
                <h2 class="fw-bold m-0">{{ $stats['masuk'] }} <span class="fs-6 text-muted fw-normal">Pesanan</span></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-color: #2ecc71;">
                <h5 class="text-muted small fw-bold">SELESAI</h5>
                <h2 class="fw-bold m-0">{{ $stats['selesai'] }} <span class="fs-6 text-muted fw-normal">Porsi</span></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-color: #3498db;">
                <h5 class="text-muted small fw-bold">TOTAL PENDAPATAN</h5>
                <h2 class="fw-bold m-0">Rp {{ number_format($stats['pendapatan']) }}</h2>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold m-0">📋 Antrian Pesanan (Live)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Order</th>
                        <th>Pemesan</th>
                        <th>Menu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#BK-{{ $order->id }}</td>
                        <td>Pelanggan #{{ $order->user_id }}</td> 
                        <td>
                            <div class="fw-bold">{{ $order->menu_name }}</div>
                            <div class="text-muted small">Qty: {{ $order->qty }} | Total: Rp {{ number_format($order->total_price) }}</div>
                        </td>
                        <td>
                            @if($order->status == 'Menunggu Konfirmasi')
                                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                            @elseif($order->status == 'Sedang Dimasak')
                                <span class="badge bg-info text-white">{{ $order->status }}</span>
                            @elseif($order->status == 'Siap Pickup')
                                <span class="badge bg-success">{{ $order->status }}</span>
                            @elseif($order->status == 'Ditolak')
                                <span class="badge bg-danger">{{ $order->status }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            @if($order->status == 'Menunggu Konfirmasi')
                                <form action="{{ url('/seller/order/'.$order->id.'/update') }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Sedang Dimasak">
                                    <button class="btn btn-sm btn-primary">Terima</button>
                                </form>
                                <form action="{{ url('/seller/order/'.$order->id.'/update') }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Ditolak">
                                    <button class="btn btn-sm btn-outline-danger">Tolak</button>
                                </form>
                            @elseif($order->status == 'Sedang Dimasak')
                                <form action="{{ url('/seller/order/'.$order->id.'/update') }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Siap Pickup">
                                    <button class="btn btn-sm btn-success">Pesanan Siap</button>
                                </form>
                            @elseif($order->status == 'Siap Pickup')
                                <form action="{{ url('/seller/order/'.$order->id.'/update') }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Selesai">
                                    <button class="btn btn-sm btn-secondary">Selesaikan</button>
                                </form>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Belum ada pesanan masuk, santuy dulu Cess! ☕
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

  </div>
</body>
</html>