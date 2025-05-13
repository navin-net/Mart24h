@extends('admin.master')
@section('title', __('messages.add_products'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $heading }}</h3>
                    </div>
                    <div class="card-body">
                        <div id="formError" class="alert alert-danger d-none" role="alert"></div>
                        <form id="createProductForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sku" class="form-label">{{ __('messages.sku') }}</label>
                                    <input type="text" name="sku" id="sku" class="form-control" required>
                                    <div class="invalid-feedback" id="sku_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="brand_id" class="form-label">{{ __('messages.brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_brand') }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="brand_id_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">{{ __('messages.category') }}</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="category_id_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="subcategory_id" class="form-label">{{ __('messages.subcategory') }}</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-select" required disabled>
                                        <option value="">{{ __('messages.select_subcategory') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="subcategory_id_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quality_id" class="form-label">{{ __('messages.quality') }}</label>
                                    <select name="quality_id" id="quality_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_quality') }}</option>
                                        @foreach ($qualities as $quality)
                                            <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="quality_id_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cost_price" class="form-label">{{ __('messages.cost_price') }}</label>
                                    <input type="number" name="cost_price" id="cost_price" class="form-control"
                                        step="0.01" min="0" required>
                                    <div class="invalid-feedback" id="cost_price_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="selling_price"
                                        class="form-label">{{ __('messages.selling_price') }}</label>
                                    <input type="number" name="selling_price" id="selling_price" class="form-control"
                                        step="0.01" min="0" required>
                                    <div class="invalid-feedback" id="selling_price_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3 d-none">
                                    <label for="stock_quantity"
                                        class="form-label">{{ __('messages.stock_quantity') }}</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                        min="0" value="0" required>
                                    <div class="invalid-feedback" id="stock_quantity_error"></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">{{ __('messages.image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        accept="image/jpeg,image/png,image/jpg">
                                    <div class="invalid-feedback" id="image_error"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                                <div class="invalid-feedback" id="description_error"></div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-save"></i> {{ __('messages.submit') }}
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> {{ __('messages.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Ensure CSRF token is fresh
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle category change to fetch subcategories
            $('#category_id').on('change', function() {
                let categoryId = $(this).val();
                let subcategorySelect = $('#subcategory_id');

                subcategorySelect.prop('disabled', true).html(
                    '<option value="">{{ __('messages.select_subcategory') }}</option>');

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('products.subcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        beforeSend: function() {
                            subcategorySelect.append('<option value="">Loading...</option>');
                        },
                        success: function(data) {
                            subcategorySelect.html(
                                '<option value="">{{ __('messages.select_subcategory') }}</option>'
                                );
                            if (data.length > 0) {
                                $.each(data, function(index, subcategory) {
                                    subcategorySelect.append('<option value="' +
                                        subcategory.id + '">' + subcategory.name +
                                        '</option>');
                                });
                                subcategorySelect.prop('disabled', false);
                            } else {
                                subcategorySelect.append(
                                    '<option value="">{{ __('messages.no_subcategories') }}</option>'
                                    );
                            }
                        },
                        error: function(xhr) {
                            console.error('Subcategory AJAX error:', xhr.status, xhr
                                .responseText);
                            $('#formError').removeClass('d-none').text(
                                '{{ __('messages.subcategory_load_error') }}');
                        }
                    });
                }
            });

            // Handle form submission
            $('#createProductForm').on('submit', function(e) {
                e.preventDefault();
                $('#formError').addClass('d-none').text('');
                $('.invalid-feedback').text('');
                $('.form-control, .form-select').removeClass('is-invalid');

                let formData = new FormData(this);
                console.log('Form data:', Object.fromEntries(formData)); // Debug form data

                let submitBtn = $('#submitBtn').prop('disabled', true).html(
                    '<i class="bi bi-hourglass-split"></i> Saving...');

                $.ajax({
                    url: '{{ route('products.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Success response:', response);
                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="bi bi-save"></i> {{ __('messages.submit') }}');
                        console.error('Form submission error:', xhr.status, xhr.responseText);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '_error').text(value[0]);
                                $('#' + key).addClass('is-invalid');
                            });
                            $('#formError').removeClass('d-none').text(
                                'Please correct the errors below.');
                        } else if (xhr.status === 419) {
                            $('#formError').removeClass('d-none').text(
                                'CSRF token mismatch. Please refresh the page and try again.'
                                );
                        } else if (xhr.status === 401 || xhr.status === 403) {
                            $('#formError').removeClass('d-none').text(
                                '{{ __('messages.unauthorized') }}');
                        } else {
                            $('#formError').removeClass('d-none').text('Server error (' + xhr
                                .status + '). Please check the console and try again.');
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(
                            '<i class="bi bi-save"></i> {{ __('messages.submit') }}');
                    }
                });
            });
        });
    </script>
@endpush
