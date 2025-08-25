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
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('messages.add_user') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
