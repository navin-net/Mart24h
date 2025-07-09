<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>One Piece Register with Video Background</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&display=swap" rel="stylesheet" />
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Pirata One', cursive;
            overflow: hidden;
            /* Prevents scrollbars if video overflows viewport */
        }

        #video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            /* Viewport width */
            height: 100vh;
            /* Viewport height */
            object-fit: cover;
            /* Ensures video covers the entire area */
            z-index: -1;
            /* Puts the video behind other content */
            filter: brightness(0.5);
            /* Darkens the video for better text contrast */
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
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm mb-1">Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-sm mb-1">Roles</label>
                    <select name="role_id" required
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" required id="password"
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required id="password_confirmation"
                        class="w-full px-4 py-2 rounded bg-gray-900 bg-opacity-50 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-2 rounded transition">
                    Register
                </button>
            </form>
        </div>
    @endauth

    {{-- JavaScript for password toggle --}}
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        }
    </script>
</body>

</html>