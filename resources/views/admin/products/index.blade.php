@extends('admin.master')
@section('title', __('messages.products_list'))
@section('content')
    <div class="container-fluid">
        <div class="pagetitle mb-4">
            <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
            <nav>
                <ol class="breadcrumb rounded-3 p-2">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                            @if (!$breadcrumb['active'])
                                <a href="{{ $breadcrumb['url'] }}"
                                    class="text-primary text-decoration-none">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-6">
                                    <h5 class="card-title mb-0 fw-semibold">{{ $heading }}</h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                            id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> {{ __('messages.actions') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3"
                                            aria-labelledby="actionDropdown">
                                            <li><a class="dropdown-item" href="#" id="addProductBtn">
                                                    <i class="bi bi-plus-circle me-2"></i>{{ __('messages.add') }}</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" id="exportProducts">
                                                    <i
                                                        class="bi bi-file-excel me-2"></i>{{ __('messages.export_to_excel') }}</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" id="bulkDeleteBtn" disabled>
                                                    <i class="bi bi-trash me-2"></i>{{ __('messages.delete') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div id="alertsContainer" class="mb-4">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table id="productsTable" class="table table-striped table-bordered rounded-3 align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>{{ __('messages.image') }}</th>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.sku') }}</th>
                                            <th>{{ __('messages.brand') }}</th>
                                            <th>{{ __('messages.category') }}</th>
                                            <th>{{ __('messages.subcategory') }}</th>
                                            <th>{{ __('messages.quality') }}</th>
                                            <th>{{ __('messages.stock_quantity') }}</th>
                                            <th>{{ __('messages.cost_price') }}</th>
                                            <th>{{ __('messages.selling_price') }}</th>
                                            <th>{{ __('messages.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title display-6 fw-bold" id="imageModalLabel">{{ __('messages.current_image') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="/placeholder.svg" alt="Product Image" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">{{ __('messages.delete_product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('messages.delete_confirmation') }}
                    </div>
                    <div class="modal-footer">
                        <form id="deleteProductForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">{{ __('messages.edit_product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modalError" class="alert alert-danger d-none" role="alert"></div>
                        <form id="editProductForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit_id">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_name" class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                    <div class="invalid-feedback" id="edit_name_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_sku" class="form-label">{{ __('messages.sku') }}</label>
                                    <input type="text" name="sku" id="edit_sku" class="form-control" required>
                                    <div class="invalid-feedback" id="edit_sku_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_brand_id" class="form-label">{{ __('messages.brand') }}</label>
                                    <select name="brand_id" id="edit_brand_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_brand') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_brand_id_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_category_id"
                                        class="form-label">{{ __('messages.category') }}</label>
                                    <select name="category_id" id="edit_category_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_category') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_category_id_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_subcategory_id"
                                        class="form-label">{{ __('messages.subcategory') }}</label>
                                    <select name="subcategory_id" id="edit_subcategory_id" class="form-select" required
                                        disabled>
                                        <option value="">{{ __('messages.select_subcategory') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_subcategory_id_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_quality_id" class="form-label">{{ __('messages.quality') }}</label>
                                    <select name="quality_id" id="edit_quality_id" class="form-select" required>
                                        <option value="">{{ __('messages.select_quality') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_quality_id_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_cost_price"
                                        class="form-label">{{ __('messages.cost_price') }}</label>
                                    <input type="number" name="cost_price" id="edit_cost_price" class="form-control"
                                        step="0.01" min="0" required>
                                    <div class="invalid-feedback" id="edit_cost_price_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_selling_price"
                                        class="form-label">{{ __('messages.selling_price') }}</label>
                                    <input type="number" name="selling_price" id="edit_selling_price"
                                        class="form-control" step="0.01" min="0" required>
                                    <div class="invalid-feedback" id="edit_selling_price_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_stock_quantity"
                                        class="form-label">{{ __('messages.stock_quantity') }}</label>
                                    <input type="number" name="stock_quantity" id="edit_stock_quantity"
                                        class="form-control" min="0" required>
                                    <div class="invalid-feedback" id="edit_stock_quantity_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_image" class="form-label">{{ __('messages.image') }}</label>
                                    <input type="file" name="image" id="edit_image" class="form-control"
                                        accept="image/jpeg,image/png,image/jpg">
                                    <div class="invalid-feedback" id="edit_image_error"></div>
                                    <img id="edit_image_preview" src="" alt="Preview"
                                        class="img-thumbnail mt-2 d-none" style="max-width: 100px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">{{ __('messages.description') }}</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="5"></textarea>
                                <div class="invalid-feedback" id="edit_description_error"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary"
                            id="saveEditBtn">{{ __('messages.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#productsTable').DataTable({
                dom: 'lBfrtip',
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, 50, -1],
                    [10, 20, 30, 50, "{{ __('messages.all') }}"]
                ],
                buttons: [],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                columns: [

                    {
                        data: 'image',
                        name: 'image',
                        render: function(data) {
                            const imagePath = data ? '{{ asset('') }}' + data :
                                '{{ asset('upload/image/noimage.png') }}';
                            return `<a href="#" class="image-popup" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="${imagePath}">
                                <img src="${imagePath}" width="50" class="img-thumbnail brand-image-thumbnail">
                            </a>`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'sku',
                        name: 'sku'
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'subcategory_name',
                        name: 'subcategory_name',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'quality_name',
                        name: 'quality_name',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'stock_quantity',
                        name: 'stock_quantity'
                    },
                    {
                        data: 'cost_price',
                        name: 'cost_price'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    paginate: {
                        previous: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>',
                        next: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>'
                    },
                    // info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    lengthMenu: '{{ __('messages.show') }} _MENU_{{ __('messages.entries') }}',
                    search: '{{ __('messages.search') }}',
                    emptyTable: "{{ __('messages.no_data_available') }}",
                    processing: "{{ __('messages.processing') }}",
                    zeroRecords: "{{ __('messages.no_matching_records') }}",
                    infoEmpty: "{{ __('messages.showing_0_to_0_of_0_entries') }}",
                    infoFiltered: "{{ __('messages.filtered_from_total_entries', ['total' => '_MAX_']) }}"
                }
            });

            // Update modal image src
            $('#productsTable').on('click', '.image-popup', function(e) {
                e.preventDefault();
                const imageSrc = $(this).data('image');
                $('#modalImage').attr('src', imageSrc);
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                $('#alertsContainer .alert').alert('close');
            }, 5000);

            // Edit product
            $('#productsTable').on('click', '.edit-product', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: '{{ route('products.index') }}/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.product.id);
                        $('#edit_name').val(response.product.name);
                        $('#edit_sku').val(response.product.sku);
                        $('#edit_cost_price').val(response.product.cost_price);
                        $('#edit_selling_price').val(response.product.selling_price);
                        $('#edit_stock_quantity').val(response.product.stock_quantity);
                        $('#edit_description').val(response.product.description);

                        $('#edit_brand_id').html(
                            '<option value="">{{ __('messages.select_brand') }}</option>');
                        $.each(response.brands, function(index, brand) {
                            $('#edit_brand_id').append('<option value="' + brand.id +
                                '">' + brand.name + '</option>');
                        });
                        $('#edit_brand_id').val(response.product.brand_id);

                        $('#edit_category_id').html(
                            '<option value="">{{ __('messages.select_category') }}</option>'
                            );
                        $.each(response.categories, function(index, category) {
                            $('#edit_category_id').append('<option value="' + category
                                .id + '">' + category.name + '</option>');
                        });
                        $('#edit_category_id').val(response.product.category_id);

                        $('#edit_subcategory_id').html(
                            '<option value="">{{ __('messages.select_subcategory') }}</option>'
                            );
                        $.each(response.subcategories, function(index, subcategory) {
                            $('#edit_subcategory_id').append('<option value="' +
                                subcategory.id + '">' + subcategory.name +
                                '</option>');
                        });
                        $('#edit_subcategory_id').val(response.product.subcategory_id).prop(
                            'disabled', response.subcategories.length === 0);

                        $('#edit_quality_id').html(
                            '<option value="">{{ __('messages.select_quality') }}</option>'
                            );
                        $.each(response.qualities, function(index, quality) {
                            $('#edit_quality_id').append('<option value="' + quality
                                .id + '">' + quality.name + '</option>');
                        });
                        $('#edit_quality_id').val(response.product.quality_id);

                        if (response.product.image) {
                            $('#edit_image_preview').attr('src', '{{ asset('') }}' +
                                response.product.image).removeClass('d-none');
                        } else {
                            $('#edit_image_preview').addClass('d-none');
                        }

                        $('#editProductModal').modal('show');
                    },
                    error: function(xhr) {
                        $('#alertsContainer').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">Failed to load product data. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                    }
                });
            });

            // Handle category change
            $('#edit_category_id').on('change', function() {
                let categoryId = $(this).val();
                let subcategorySelect = $('#edit_subcategory_id');

                subcategorySelect.prop('disabled', true).html(
                    '<option value="">{{ __('messages.select_subcategory') }}</option>');

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('products.subcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
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
                            $('#modalError').removeClass('d-none').text(
                                '{{ __('messages.subcategory_load_error') }}');
                        }
                    });
                }
            });

            // Save edited product
            $('#saveEditBtn').on('click', function() {
                let formData = new FormData($('#editProductForm')[0]);
                let btn = $(this).prop('disabled', true).html(
                    '<i class="bi bi-hourglass-split"></i> Saving...');

                $.ajax({
                    url: '{{ route('products.index') }}/' + $('#edit_id').val(),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        $('#editProductModal').modal('hide');
                        table.ajax.reload();
                        $('#alertsContainer').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                        setTimeout(function() {
                            $('#alertsContainer .alert').alert('close');
                        }, 5000);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html('{{ __('messages.save') }}');
                        $('#modalError').removeClass('d-none');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit_' + key + '_error').text(value[0]);
                                $('#edit_' + key).addClass('is-invalid');
                            });
                            $('#modalError').text('Please correct the errors below.');
                        } else if (xhr.status === 419) {
                            $('#modalError').text(
                                'CSRF token mismatch. Please refresh the page and try again.'
                                );
                        } else {
                            $('#modalError').text('Server error (' + xhr.status +
                                '). Please try again.');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('{{ __('messages.save') }}');
                    }
                });
            });

            // Delete product
            $(document).on('click', '.delete-product', function() {
                const productId = $(this).data('id');
                const deleteUrl = "{{ url('products') }}/" + productId;
                $('#deleteProductForm').attr('action', deleteUrl);
                $('#deleteProductModal').modal('show');
            });

            $('#deleteProductForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const action = form.attr('action');

                $.ajax({
                    url: action,
                    type: 'DELETE',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteProductModal').modal('hide');
                        table.ajax.reload();
                        const successAlert = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                        $('#alertsContainer').html(successAlert);
                        setTimeout(function() {
                            $('#alertsContainer .alert').alert('close');
                        }, 5000);
                    },
                    error: function(xhr) {
                        $('#deleteProductModal').modal('hide');
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error :
                            'Failed to delete the product. Please try again.';
                        const errorAlert = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${errorMessage}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                        $('#alertsContainer').html(errorAlert);
                        setTimeout(function() {
                            $('#alertsContainer .alert').alert('close');
                        }, 5000);
                    }
                });
            });
        });
    </script>
@endpush
