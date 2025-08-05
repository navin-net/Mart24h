<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&display=swap" rel="stylesheet" />
    <style>
        body, html {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Pirata One', cursive;
            overflow: hidden; /* Prevents scrollbars if video overflows viewport */
        }
        #video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; /* Viewport width */
            height: 100vh; /* Viewport height */
            object-fit: cover; /* Ensures video covers the entire area */
            z-index: -1; /* Puts the video behind other content */
            filter: brightness(0.5); /* Darkens the video for better text contrast */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 text-white">
    @auth
        <script>
            window.location.href = "{{ route('dashboard') }}";
        </script>
    @else
        <video id="video-bg" autoplay muted loop playsinline>
            <source src="https://static.moewalls.com/videos/preview/2025/goth-anime-girl-preview.webm" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <div class="bg-black bg-opacity-70 p-8 rounded-xl shadow-2xl w-full max-w-md backdrop-blur-sm">
            <h2 class="text-4xl text-yellow-400 text-center mb-6">Welcome Back, Pirate!</h2>

            @if (session('error'))
                <div class="bg-red-500 bg-opacity-80 text-white p-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        required
                        autofocus
                        value="{{ old('login') }}"
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    />
                    @error('login')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 pr-10"
                        />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-400 hover:text-yellow-400" onclick="togglePasswordVisibility('password')">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eye-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                    </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="font-medium text-yellow-400 hover:text-yellow-300" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-2 rounded transition"
                >
                    Log In
                </button>
            </form>
        </div>
    @endauth

    {{-- JavaScript for password toggle --}}
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle eye icon paths
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m4.146-2.146A3 3 0 0112 9a3 3 0 013.873 4.558M9.027 7.227A9.977 9.977 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-2.146 3.026"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>
</html>