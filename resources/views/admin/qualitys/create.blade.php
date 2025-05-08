@extends('admin.master')
@section('title', __('messages.add_qualitys'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ __('messages.add_qualitys') }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-primary text-decoration-none">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-primary text-decoration-none">{{ __('messages.settings') }}</a></li>
                <li class="breadcrumb-item active text-muted">{{ __('messages.qualitys') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('qualitys.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-medium">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label fw-medium">{{ __('messages.description') }}</label>
                                    <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('qualitys.index') }}" class="btn btn-secondary btn-sm rounded-3">{{ __('messages.cancel') }}</a>
                                <button type="submit" class="btn btn-primary btn-sm rounded-3">{{ __('messages.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
