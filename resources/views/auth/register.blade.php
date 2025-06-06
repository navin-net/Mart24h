<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>One Piece Login with Video Background</title>
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

    <video id="video-bg" autoplay muted loop playsinline>
        <source src="https://static.moewalls.com/videos/preview/2025/goth-anime-girl-preview.webm" type="video/mp4" />
        Your browser does not support the video tag.
    </video>

    <div class="bg-black bg-opacity-70 p-8 rounded-xl shadow-2xl w-full max-w-md backdrop-blur-sm">
        <h2 class="text-4xl text-yellow-400 text-center mb-6">Welcome Back, Pirate!</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    autofocus
                    class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"
                />
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
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="form-checkbox h-4 w-4 text-yellow-400 transition duration-150 ease-in-out bg-gray-900 border-gray-700 rounded focus:ring-yellow-400">
                    <label for="remember" class="ml-2 block text-gray-300">Remember me</label>
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

    {{-- JavaScript for password toggle --}}
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // If you wanted to change the SVG icon, you'd add logic here
            // e.g., targeting a specific ID for the SVG path and changing its d attribute.
        }
    </script>
</body>
</html>