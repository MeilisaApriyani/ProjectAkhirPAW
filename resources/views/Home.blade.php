<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
    <a class="navbar-brand ps-3" href="{{ route('home') }}">
        <img src="{{ asset('/img/logo1.jpg') }}" alt="Logo" style="max-width: 40px;">
        Sumber Elektronik
    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fa-solid fa-bars-staggered"></i></button>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ url('home') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-house-chimney"></i></i></div>
                            Home
                    </a>
                    <a class="nav-link" href="{{ url('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes"></i></div>
                        Stock Barang
                    </a>
                    <a class="nav-link" href="{{ url('barang-masuk') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-truck"></i></div>
                        Barang Masuk
                    </a>
                    <a class="nav-link" href="{{ url('barang-keluar') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                        Barang Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Home</h1>
                <div class="row justify-content-center align-items-center">
                <div class="col-lg-0">
                <div class="card mb-4 w-100">
                    <div class="card-header bg-warning text-white">
                        <h3 class="text-center">Selamat Datang di Halaman Admin</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Anda berhasil masuk ke halaman admin. Gunakan menu di samping atau di bawah ini untuk mengelola data.</p>
                    </div>
                </div>
            </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">Stok Barang  <i class="fa-solid fa-cubes"></i></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ url('dashboard') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">Barang Masuk <i class="fa-solid fa-truck"></i></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ url('barang-masuk') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Barang Keluar <i class="fa-solid fa-store"></i></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ url('barang-keluar') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="container-fluid px-4"> 
            <h1 class="mt-4">Statistik Barang</h1>
                 <div class="card mb-4">
                    <div class="card-header">
                        <div class="form-group">
                            <label for="yearSelect">Pilih Tahun:</label>
                            <select id="yearSelect" class="form-control" onchange="fetchDataByYear()">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $year == $selected_year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Statistik Penjualan Barang Dibeli
                        </div>
                        
                        <div class="card-body"><canvas id="myChart" width="100%" height="50"></canvas></div>
                        
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function fetchDataByYear() {
        var year = document.getElementById('yearSelect').value;
        window.location.href = '{{ url("statistik") }}?year=' + year;
    }
</script>
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_map(function($month) {
                return $month > 0 ? date('F', mktime(0, 0, 0, $month, 1)) : '';
            }, range(1, 12))) !!},
            datasets: [{
                label: 'Jumlah Barang Keluar',
                data: {!! json_encode($jumlah_total_per_bulan) !!},
                backgroundColor: 'rgb(100, 200, 200)',
                borderColor: 'rgb(100, 200, 200)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            const index = tooltipItems[0].dataIndex;
                            return 'Bulan: ' + {!! json_encode(array_map(function($month) {
                                return $month > 0 ? date('F', mktime(0, 0, 0, $month, 1)) : '';
                            }, range(1, 12))) !!}[index];
                        },
                        
                    }
                }
            }
        }
    });
</script>

</body>
</html>