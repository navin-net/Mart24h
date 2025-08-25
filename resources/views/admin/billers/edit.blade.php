@extends('admin.master')

@section('title', __('messages.edit_biller'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ __('messages.edit_biller') }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}"
                        class="text-primary text-decoration-none">{{ __('messages.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('billers.index') }}"
                        class="text-primary text-decoration-none">{{ __('messages.billers') }}</a>
                </li>
                <li class="breadcrumb-item active text-muted">{{ __('messages.edit') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">{{ __('messages.edit_biller') }}</h5>
                        <div id="alertsContainer" class="mb-4"></div>

                        <form id="billerForm" action="{{ route('billers.update', $biller->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- Name --}}
                                {{-- Name --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $biller->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $biller->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Warehouse --}}
                                <div class="col-md-6 mb-3">
                                    <label for="warehouse_id" class="form-label">{{ __('messages.warehouse') }}</label>
                                    <select name="warehouse_id" id="warehouse_id"
                                        class="form-select @error('warehouse_id') is-invalid @enderror" required>
                                        <option value="">{{ __('messages.select_warehouse') }}</option>
                                        @foreach ($warehouse as $w)
                                        <option value="{{ $w->id }}"
                                            {{ old('warehouse_id', $biller->warehouse_id) == $w->id ? 'selected' : '' }}>
                                            {{ $w->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">{{ __('messages.phone') }}</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $biller->phone) }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Address --}}
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">{{ __('messages.address') }}</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $biller->address) }}" required>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- City --}}
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ __('messages.city') }}</label>
                                    <input type="text" name="city" id="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city', $biller->city) }}" required>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Number of Houses --}}
                                <div class="col-md-6 mb-3">
                                    <label for="number_of_houses"
                                        class="form-label">{{ __('messages.number_of_houses') }}</label>
                                    <input type="text" name="number_of_houses" id="number_of_houses"
                                        class="form-control @error('number_of_houses') is-invalid @enderror"
                                        value="{{ old('number_of_houses', $biller->number_of_houses) }}" required>
                                    @error('number_of_houses')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Street --}}
                                <div class="col-md-6 mb-3">
                                    <label for="street" class="form-label">{{ __('messages.street') }}</label>
                                    <input type="text" name="street" id="street"
                                        class="form-control @error('street') is-invalid @enderror"
                                        value="{{ old('street', $biller->street) }}" required>
                                    @error('street')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Logo --}}
                                <div class="col-md-12 mb-3">
                                    <label for="logo" class="form-label">{{ __('messages.logo') }}</label>
                                    <input type="file" name="logo" id="logo"
                                        class="form-control @error('logo') is-invalid @enderror">
                                    @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Note --}}
                                <div class="col-md-12 mb-3">
                                    <label for="note" class="form-label">{{ __('messages.note') }}</label>
                                    <textarea name="note" id="note" rows="3"
                                        class="form-control rounded-3 @error('note') is-invalid @enderror"
                                        required>{{ old('note', $biller->note) }}</textarea>
                                    @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-primary btn-sm rounded-3">{{ __('messages.update') }}</button>
                                <a href="{{ route('billers.index') }}"
                                    class="btn btn-secondary btn-sm rounded-3">{{ __('messages.cancel') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>










    @endsection