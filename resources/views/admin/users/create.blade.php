@extends('admin.master')

@section('title', __('messages.add_user'))

@section('content')
<div class="container-fluid">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                        @if (!$breadcrumb['active'])
                            <a href="{{ $breadcrumb['url'] }}" class="text-primary text-decoration-none">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Group --}}
                            <div class="col-md-6 mb-3">
                                <label for="group_id" class="form-label">{{ __('messages.group') }}</label>
                                <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror" required>
                                    <option value="">{{ __('messages.select_group') }}</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
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

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
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

                            {{-- Buttons --}}
                            <div class="mb-3 mt-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> {{ __('messages.submit') }}
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> {{ __('messages.cancel') }}
                                </a>
                            </div>
                        </div> {{-- .row --}}
                    </form>
                </div>
            </div>
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
