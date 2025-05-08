<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../picture/pie-chart.ico">
    <title>@yield('title', 'Login')</title>
    @include('layouts.styles')
    <style>
        /* Background image styling */
        body {
            background-size: cover;
            background-position: center;
            margin: 0; /* Ensure no default margins interfere */
        }
        .container-fluid {
            background: none; /* Remove any background to fully show body background */
        }
        .card {
            background-color: rgba(0, 0, 0, 0.3); /* Black with 30% opacity */
        }
        .card, .card-body, .card label, .card p {
            color: white; /* Set text color to white for labels and paragraphs */
        }
        .card input, .card button {
            color: black; /* Set input text and button text color to black */
        }
    </style>
    <script>
        window.onload = function () {
            const images = [
                '{{ asset('assets/backgrounds/backgroud1.jpg') }}',
                '{{ asset('assets/backgrounds/backgroud2.jpg') }}',
                '{{ asset('assets/backgrounds/backgroud3.jpg') }}'
            ];
            const randomIndex = Math.floor(Math.random() * images.length);
            document.body.style.backgroundImage = `url('${images[randomIndex]}')`;
            document.body.style.backgroundSize = 'cover';
            document.body.style.backgroundPosition = 'center';
        };
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                                </div>
                                <p class="text-center">
                                    {{ __('Transportation') }}
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
                                        <label for="login" class="form-label">{{ __('messages.username_or_email') }}</label>
                                        <input type="text" class="form-control" value="{{ old('login') }}" id="login" name="login" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">{{ __('messages.password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">{{ __('messages.login') }}</button>
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
