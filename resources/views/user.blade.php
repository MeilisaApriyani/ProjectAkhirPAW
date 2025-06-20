<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <style>
        .zoomable {
            width: 100px;
        }
        .zoomable:hover {
            transform: scale(3.5);
            transition: 0.3s ease;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
        <a class="navbar-brand ps-3" href="{{ route('user') }}">
        <img src="{{ asset('/img/logo1.jpg') }}" alt="Logo" style="max-width: 40px;">
            Sumber Elektronik
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fa-solid fa-bars-staggered"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav sb-sidenav-light">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('user') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes"></i></div>
                            Stok Barang
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
                    <h1 class="mt-4">Stok Barang</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            @foreach ($stocks as $stock)
                                @if ($stock->jumlah < 1)
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <strong>Perhatian!</strong> stok {{ $stock->namabarang }} sudah habis
                                    </div>
                                @elseif ($stock->jumlah <= 10)
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <strong>Waspada!</strong> stok {{ $stock->namabarang }} tinggal sedikit
                                    </div>
                                @endif
                            @endforeach

                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id Barang</th>
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Letak Barang</th>
                                        <th>Jumlah Stok</th>
                                        <th>Harga per Pcs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <td>{{ $stock->idbarang }}</td>
                                            <td>
                                                @if ($stock->image)
                                                    <img src="{{ asset('images/'.$stock->image) }}" class="zoomable">
                                                @else
                                                    No Photo
                                                @endif
                                            </td>
                                            <td>{{ $stock->namabarang }}</td>
                                            <td>{{ $stock->letakbarang }}</td>
                                            <td>{{ $stock->jumlah }}</td>
                                            <td>{{ $stock->harga }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    
</body>
</html>
