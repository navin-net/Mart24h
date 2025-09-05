@extends('admin.master')

@section('title', __('messages.add_users'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ __('messages.add_user_to_biller') }}: {{ $biller->name }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('billers.users.store', $biller->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div> -->
                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- <button type="submit" class="btn btn-primary">{{ __('messages.add_user') }}</button> -->
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>
                    {{ __('messages.add_user') }}</button>
                <a href="{{ route('billers.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i>
                    {{ __('messages.cancel') }}</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.closest('.input-group').querySelector('input');
        const icon = this.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
});
</script>
@endpush