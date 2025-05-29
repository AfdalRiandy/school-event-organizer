<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Event Management System</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <style>
        .bg-login-image {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding-top: 50px;
        }
        
        .logo-wrapper {
            text-align: center;
            padding: 20px;
            z-index: 2;
        }
        
        .logo-wrapper img {
            max-width: 50%;
            height: auto;
        }
        
        .logo-title {
            color: #fff;
            margin-top: 15px;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .logo-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1rem;
            margin-top: 5px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .pattern-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.8;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .btn-user {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .p-5 {
            padding: 2.5rem !important;
        }
        
        @media (max-width: 991.98px) {
            .bg-login-image {
                min-height: 200px;
            }
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="pattern-overlay"></div>
                                <div class="logo-wrapper">
                                    <!-- Replace with your actual logo -->
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" onerror="this.src='{{ asset('assets/img/undraw_rocket.svg') }}'; this.style.maxWidth='60%';">
                                    <h1 class="logo-title">Event Management</h1>
                                    <p class="logo-subtitle">Manage all your school events in one place</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control form-control-user border-left-0 @error('credential') is-invalid @enderror"
                                                    id="credential" name="credential" 
                                                    placeholder="Enter Email / NIS / NIP" value="{{ old('credential') }}" required autofocus>
                                            </div>
                                            @error('credential')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control form-control-user border-left-0 @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Password" required>
                                            </div>
                                            @error('password')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                                                <label class="custom-control-label" for="remember_me">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create a Student Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>