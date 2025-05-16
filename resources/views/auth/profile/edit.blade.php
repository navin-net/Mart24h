<div class="container">
    <h2>Edit Profile for {{ $user->name }}</h2>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
        @csrf

        <!-- Show current image -->
        @if ($user->profile && $user->profile->image)
            <div>
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $user->profile->image) }}" width="120">
            </div>
        @endif

        <div>
            <label>Upload New Image:</label>
            <input type="file" name="image">
            @error('image') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Date of Birth:</label>
            <input type="date" name="dob" value="{{ old('dob', $user->profile->dob ?? '') }}">
            @error('dob') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <!-- Password Section -->
        <div>
            <label>Old Password:</label>
            <input type="password" name="old_password" placeholder="Enter current password">
            @error('old_password') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>New Password:</label>
            <input type="password" name="new_password" placeholder="Enter new password">
            @error('new_password') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Confirm New Password:</label>
            <input type="password" name="new_password_confirmation" placeholder="Confirm new password">
        </div>

        <div>
            <button type="submit">Save Profile</button>
        </div>
    </form>
</div>
