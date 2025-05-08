<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Locale</title>
    <script>
        const currentLocale = "{{ Session::get('locale', config('app.locale')) }}";
        console.log("Current Locale:", currentLocale);
    </script>
</head>
<body>
    {{-- <a href="{{ route('language.switch', 'en') }}">English</a>
    <a href="{{ route('language.switch', 'fr') }}">Français</a> --}}
    {{-- <form action="{{ route('language.switch') }}" method="POST">
        @csrf
        <select name="language" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="km" {{ app()->getLocale() == 'km' ? 'selected' : '' }}>Khmer</option>
        </select>
    </form> --}}
    <a href="{{ route('language.switch', ['language' => 'en']) }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
        English
    </a>
    <a href="{{ route('language.switch', ['language' => 'km']) }}" class="{{ app()->getLocale() == 'km' ? 'active' : '' }}">
        Khmer
    </a>

    <h1>{{ __('messages.welcome') }}</h1>
  <div>  {{ __('messages.welcome_mart24h_users') }}</div>

</body>
</html>
