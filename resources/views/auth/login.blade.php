<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../picture/pie-chart.ico">
    <title>@yield('title', 'Login')</title> <!-- Use the title section or default value -->
    @include('layouts.styles')
    <style>
        /* Background image styling */
        body {
            background-size: cover;
            background-position: center;
        }

    </style>
    <script>
        // JavaScript to select a random background image from Unsplash
        window.onload = function() {
            const images = [
                '',
                '../assets/images/backgrounds/backgroud1.jpg',
                '../assets/images/backgrounds/backgroud2.jpg',
                '../assets/images/backgrounds/backgroud3.jpg'
            ];
            const randomIndex = Math.floor(Math.random() * images.length);
            document.body.style.backgroundImage = `url('${images[randomIndex]}')`;
        };
    </script>
</head>

<body>

    <div class="container-fluid">
        <div class="position-relative overflow-hidden  min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div  class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                                </div>
                                <p class="text-center">
                                    {{ __('Mart 24h') }}
                                </p>
                                @if ($errors->any())
                                <div style="color: red;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="email" class="form-control" value="{{ old('email') }}" id="email" aria-describedby="emailHelp" name="email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password"  name="password" required>
                                    </div>
                                    {{-- <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remember this Device
                                            </label>
                                        </div>
                                        <a class="text-primary fw-bold" href="./index.html">Forgot Password?</a>
                                    </div> --}}
                                    {{-- <a href="./index.html" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</a> --}}
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                                </form>
                                    <div class="d-flex align-items-center justify-content-center">
                                        {{-- <p class="fs-4 mb-0 fw-bold">New to Modernize?</p> --}}
                                        {{-- <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a> --}}
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

</body>

</html>
