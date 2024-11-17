<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title> <!-- Use the title section or default value -->
    @include('layouts.styles')
</head>

<body>
    {{-- @include('layouts.header') --}}
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('layouts.slider')
        <div class="body-wrapper">
            @include('layouts.header')
            <div class="container-fluid">
            @yield('content')
            </div>
        </div>
    </div>



    @include('layouts.footer')
</body>

</html>
