
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                @if ($errors->any())
                                        <div class="alert alert-danger">
                                
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach
                                            
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('login.post') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="small mb-1" for="InputEmail">Email</label>
                                            <input class="form-control py-4" name="email" id="InputEmail" type="email" placeholder="Masukkan Email anda" required /> 
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="InputPassword">Password</label>
                                            <input class="form-control py-4" name="password" id="InputPassword" type="password" placeholder="Masukkan Password anda" required /> 
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-success" type="submit">Login</button>
                                            <a href="{{ route('register') }}" class="btn btn-link">Belum punya akun? Daftar disini</a>
                                            
                                        </div>
                                        


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
