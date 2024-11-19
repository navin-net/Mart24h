<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../picture/pie-chart.ico">
    <title>@yield('title', 'Default Title')</title> <!-- Use the title section or default value -->

    @include('themes.sub_themes.style')
</head>
<body>
    @include('themes.sub_themes.header')

    @yield('content')

    @include('themes.sub_themes.footer')
</body>

</html>
