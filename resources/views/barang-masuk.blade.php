<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-house-chimney"></i></div>
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
                <h1 class="mt-4">Barang Masuk</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang Masuk
                        </button>
                    </div>
                    <div class="card-body">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Image</th>
                                    <th>Nama Barang</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Jumlah Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangMasuk as $barang)
                                    <tr>
                                        <td>{{ $barang->tanggalMasuk }}</td>
                                        <td>
                                            @if ($barang->image)
                                                <img src="{{ asset('images/' . $barang->image) }}" class="zoomable" width="50px">
                                            @else
                                                No Photo
                                            @endif
                                        </td>  
                                        <td>{{ $barang->namabarang }}</td>
                                        <td>{{ $barang->penanggungjawab }}</td>
                                        <td>{{ $barang->jumlahmasuk }}</td> 
                                                           
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $barang->idmasuk }}">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $barang->idmasuk }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade" id="edit{{ $barang->idmasuk }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="{{ route('barang.masuk.update', $barang->idmasuk) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="idmasuk" value="{{ $barang->idmasuk }}">
                                                        <div class="mb-3">
                                                            <label for="idbarang" class="form-label">Nama Barang</label>
                                                            <select name="idbarang" id="idbarang" class="form-control" required>
                                                                @foreach($stocks as $stock)
                                                                <option value="{{ $stock->idbarang }}" {{ $barang->idbarang == $stock->idbarang ? 'selected' : '' }}> {{ $stock->namabarang }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlahmasuk" class="form-label">Jumlah Masuk</label>
                                                            <input type="number" class="form-control" name="jumlahmasuk" required value="{{ old('jumlahmasuk') }}" min="1">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
                                                            <input type="text" class="form-control" name="penanggungjawab" value="{{ $barang->penanggungjawab }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="delete{{ $barang->idmasuk }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('barang.masuk.delete', $barang->idmasuk) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Apakah anda ingin menghapus {{ $barang->namabarang }}?
                                                        <input type="hidden" name="idmasuk" value="{{ $barang->idmasuk }}">
                                                        <br>
                                                        <br>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('barang.masuk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idbarang" class="form-label">Nama Barang</label>
                        <select name="idbarang" id="idbarang" class="form-control" required>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->idbarang }}"> {{ $stock->namabarang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
                        <input type="text" class="form-control" name="penanggungjawab" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahmasuk" class="form-label">Jumlah Masuk</label>
                        <input type="number" class="form-control" name="jumlahmasuk" required value="{{ old('jumlahmasuk') }}" min="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable('#dataTable');
    });
    var form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        var jumlah = form.querySelector('input[name="jumlahmasuk"]');
        var valid = true;

        if (jumlah.value <= 0) {
            alert('Jumlah tidak boleh 0 atau negatif');
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); 
        }
    });
</script>
</body>
</html>
