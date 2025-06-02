@extends('admin.master')

@section('title', __('messages.sales_list'))

@section('content')
    <div class="container-fluid py-4">
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
                                    <h5 class="card-title mb-0 fw-semibold">{{ __('messages.sales_list') }}</h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                            id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> {{ __('messages.actions') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3"
                                            aria-labelledby="actionDropdown">
                                            <li><a class="dropdown-item" href="{{ route('sales.create') }}">
                                                    <i class="bi bi-plus-circle me-2"></i>{{ __('messages.add') }}</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" id="exportSales">
                                                    <i class="bi bi-file-excel me-2"></i>{{ __('messages.export_to_excel') }}</a>
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
                                <table class="table table-striped table-bordered rounded-3 align-middle"
                                    id="salesTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                            <th>{{ __('messages.total_amount') }}</th>
                                            <th>{{ __('messages.date') }}</th>
                                            <th>{{ __('messages.item_count') }}</th>
                                            <th>{{ __('messages.total_quantity') }}</th>
                                            <th scope="col" class="py-3 text-center" width="120">
                                                {{ __('messages.actions') }}</th>
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

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="deleteModalLabel">{{ __('messages.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('messages.delete_confirm') }}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm rounded-3">{{ __('messages.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Delete Confirmation Modal -->
        <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="bulkDeleteModalLabel">
                            {{ __('messages.confirm_bulk_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('messages.delete_confirm') }}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-3"
                            id="confirmBulkDelete">{{ __('messages.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show Modal -->
        <div class="modal fade" id="showSaleModal" tabindex="-1" aria-labelledby="showSaleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="showSaleModalLabel">
                            {{ __('messages.sale_details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>{{ __('messages.id') }}:</strong> <span id="show-id"></span></p>
                        <p><strong>{{ __('messages.total_amount') }}:</strong> <span id="show-total_amount"></span></p>
                        <p><strong>{{ __('messages.status') }}:</strong> <span id="show-status"></span></p>
                        <p><strong>{{ __('messages.date') }}:</strong> <span id="show-date"></span></p>
                        <h5>{{ __('messages.items') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.product') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.sale_price') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="show-items"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editSaleModal" tabindex="-1" aria-labelledby="editSaleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="editSaleModalLabel">
                            {{ __('messages.edit_sale') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="edit-error-alert" class="alert alert-danger alert-dismissible fade show d-none"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <form id="edit-sale-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit-id">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="edit-total_amount"
                                        class="form-label fw-medium">{{ __('messages.total_amount') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_amount" id="edit-total_amount"
                                        class="form-control rounded-3" required>
                                    <div class="invalid-feedback" id="total_amount-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-status"
                                        class="form-label fw-medium">{{ __('messages.status') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="status" id="edit-status" class="form-control rounded-3"
                                        required>
                                    <div class="invalid-feedback" id="status-error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="edit-date" class="form-label fw-medium">{{ __('messages.date') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="date" id="edit-date" class="form-control rounded-3"
                                        required>
                                    <div class="invalid-feedback" id="date-error"></div>
                                </div>
                            </div>
                            <div id="edit-items"></div>
                            <button type="button" onclick="addEditItem()"
                                class="btn btn-secondary btn-sm rounded-3 mb-3">{{ __('messages.add_another_item') }}</button>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary btn-sm rounded-3"
                                    data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                <button type="submit"
                                    class="btn btn-primary btn-sm rounded-3">{{ __('messages.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .action-btn {
            margin: 0 3px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#salesTable').DataTable({
                dom: 'lBfrtip',
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, 50, -1],
                    ["{{ __('messages.10') }}", "{{ __('messages.20') }}", "{{ __('messages.30') }}",
                        "{{ __('messages.50') }}", "{{ __('messages.all') }}"]
                ],
                buttons: [],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('sales.getData') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        render: function (data) {
                            return `<input type="checkbox" class="saleCheckbox" value="${data}">`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: $.fn.dataTable.render.number(',', '.', 2)
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'items_count',
                        name: 'items_count',
                        searchable: false
                    },
                    {
                        data: 'items_sum_quantity',
                        name: 'items_sum_quantity',
                        searchable: false
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
                    lengthMenu: '{{ __('messages.show') }} _MENU_ {{ __('messages.entries') }}',
                    search: '{{ __('messages.search') }}',
                    emptyTable: "{{ __('messages.no_data_available') }}",
                    processing: "{{ __('messages.processing') }}",
                    zeroRecords: "{{ __('messages.no_matching_records') }}",
                    infoEmpty: "{{ __('messages.showing_0_to_0_of_0_entries') }}",
                    infoFiltered: "{{ __('messages.filtered_from_total_entries', ['total' => '_MAX_']) }}"
                }
            });

            $(document).on('click', '.show-sale', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: '{{ route('sales.show', ['id' => ':id']) }}'.replace(':id', id),
                    method: 'GET',
                    success: function (response) {
                        if (response.error) {
                            $('#alertsContainer').html(
                                `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${response.error}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            );
                            return;
                        }
                        const sale = response.sale;
                        $('#show-id').text(sale.id || 'N/A');
                        $('#show-total_amount').text((sale.total_amount || 0).toFixed(2));
                        $('#show-status').text(sale.status || 'N/A');
                        $('#show-date').text(sale.date || 'N/A');
                        let itemsHtml = '';
                        (sale.items || []).forEach(item => {
                            itemsHtml += `
                                <tr>
                                    <td>${item.product?.name || 'N/A'} (SKU: ${item.product?.sku || 'N/A'})</td>
                                    <td>${item.quantity || 0}</td>
                                    <td>${(item.sale_price || 0).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        $('#show-items').html(itemsHtml || '<tr><td colspan="3">No items</td></tr>');
                        $('#showSaleModal').modal('show');
                    },
                    error: function (xhr) {
                        let errorMsg = 'Failed to load sale details. Please try again.';
                        if (xhr.status === 404) errorMsg = 'Sale not found.';
                        else if (xhr.status === 500) errorMsg = 'Server error occurred.';
                        $('#alertsContainer').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${errorMsg}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    }
                });
            });

            let editItemCount = 0;
            $(document).on('click', '.edit-sale', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: '{{ route('sales.edit', ['sale' => ':id']) }}'.replace(':id', id),
                    method: 'GET',
                    success: function (response) {
                        const sale = response.sale;
                        const products = response.products;
                        $('#edit-id').val(sale.id);
                        $('#edit-total_amount').val(sale.total_amount).removeClass('is-invalid');
                        $('#edit-status').val(sale.status).removeClass('is-invalid');
                        $('#edit-date').val(sale.date).removeClass('is-invalid');
                        let itemsHtml = '';
                        editItemCount = sale.items.length;
                        sale.items.forEach((item, index) => {
                            itemsHtml += `
                                <div class="item mb-3">
                                    <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                                    <select name="items[${index}][product_id]" class="form-control rounded-3" required>
                                        <option value="">{{ __('messages.select_product') }}</option>
                                        ${products.map(p => `<option value="${p.id}" ${item.product_id == p.id ? 'selected' : ''}>${p.name} (SKU: ${p.sku})</option>`).join('')}
                                    </select>
                                    <div class="invalid-feedback" id="items[${index}][product_id]-error"></div>
                                    <label class="form-label fw-medium mt-2">{{ __('messages.quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="items[${index}][quantity]" value="${item.quantity}" placeholder="{{ __('messages.quantity') }}" class="form-control rounded-3 mt-2" required>
                                    <div class="invalid-feedback" id="items[${index}][quantity]-error"></div>
                                    <label class="form-label fw-medium mt-2">{{ __('messages.sale_price') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="items[${index}][sale_price]" value="${item.sale_price}" placeholder="{{ __('messages.sale_price') }}" class="form-control rounded-3 mt-2" required>
                                    <div class="invalid-feedback" id="items[${index}][sale_price]-error"></div>
                                </div>
                            `;
                        });
                        $('#edit-items').html(itemsHtml);
                        $('#editSaleModal').modal('show');
                    },
                    error: function (xhr) {
                        $('#alertsContainer').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to load sale for editing. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    }
                });
            });

            window.addEditItem = function () {
                const products = @json($products);
                const itemsDiv = $('#edit-items');
                const newItem = `
                    <div class="item mb-3">
                        <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                        <select name="items[${editItemCount}][product_id]" class="form-control rounded-3" required>
                            <option value="">{{ __('messages.select_product') }}</option>
                            ${products.map(p => `<option value="${p.id}">${p.name} (SKU: ${p.sku})</option>`).join('')}
                        </select>
                        <div class="invalid-feedback" id="items[${editItemCount}][product_id]-error"></div>
                        <label class="form-label fw-medium mt-2">{{ __('messages.quantity') }} <span class="text-danger">*</span></label>
                        <input type="number" name="items[${editItemCount}][quantity]" placeholder="{{ __('messages.quantity') }}" class="form-control rounded-3 mt-2" required>
                        <div class="invalid-feedback" id="items[${editItemCount}][quantity]-error"></div>
                        <label class="form-label fw-medium mt-2">{{ __('messages.sale_price') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="items[${editItemCount}][sale_price]" placeholder="{{ __('messages.sale_price') }}" class="form-control rounded-3 mt-2" required>
                        <div class="invalid-feedback" id="items[${editItemCount}][sale_price]-error"></div>
                    </div>
                `;
                itemsDiv.append(newItem);
                editItemCount++;
            };

            $('#edit-sale-form').on('submit', function (e) {
                e.preventDefault();
                const id = $('#edit-id').val();
                $.ajax({
                    url: '{{ route('sales.update', ['sale' => ':id']) }}'.replace(':id', id),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#editSaleModal').modal('hide');
                        table.ajax.reload();
                        $('#alertsContainer').html(
                            `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('messages.sale_updated_successfully') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors || {};
                        $('.invalid-feedback').text('').hide();
                        $('.form-control').removeClass('is-invalid');
                        for (let key in errors) {
                            const errorField = key.replace(/\./g, '\\.').replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                            $(`#${errorField}-error`).text(errors[key][0]).show();
                            $(`[name="${key}"]`).addClass('is-invalid');
                        }
                        $('#edit-error-alert').html('Please fix the following errors:').removeClass('d-none');
                    }
                });
            });

            $(document).on('click', '.delete-sale', function () {
                const saleId = $(this).data('id');
                $('#deleteForm').attr('action', '{{ route('sales.destroy', ['sale' => ':id']) }}'.replace(':id', saleId));
                $('#deleteModal').modal('show');
            });

            $('#deleteForm').on('submit', function (e) {
                e.preventDefault();
                const action = $(this).attr('action');
                $.ajax({
                    url: action,
                    type: 'DELETE',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        $('#alertsContainer').html(
                            `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('messages.sale_deleted_successfully') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    },
                    error: function (xhr) {
                        $('#alertsContainer').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to delete the sale. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    }
                });
            });

            $('#bulkDeleteBtn').on('click', function () {
                const selectedIds = $('.saleCheckbox:checked').map(function () {
                    return $(this).val();
                }).get();
                if (selectedIds.length === 0) {
                    $('#alertsContainer').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ __('messages.please_select_someone_columns_first_if_you_want_to_export') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    );
                    return;
                }
                $('#bulkDeleteModal').modal('show');
                $('#confirmBulkDelete').off('click').on('click', function () {
                    $.ajax({
                        url: "{{ route('sales.bulkDelete') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedIds
                        },
                        success: function (response) {
                            $('#bulkDeleteModal').modal('hide');
                            table.ajax.reload();
                            $('#selectAll').prop('checked', false);
                            $('#bulkDeleteBtn').prop('disabled', true);
                            $('#alertsContainer').html(
                                `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ __('messages.selected_sales_deleted_successfully') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            );
                        },
                        error: function (xhr) {
                            $('#alertsContainer').html(
                                `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Failed to delete selected sales. Please try again.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            );
                        }
                    });
                });
            });

            $('#selectAll').on('click', function () {
                $('.saleCheckbox').prop('checked', $(this).prop('checked'));
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.saleCheckbox', function () {
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                $('#bulkDeleteBtn').prop('disabled', $('.saleCheckbox:checked').length === 0);
            }

            $('#exportSales').on('click', function () {
                var selectedIds = $('.saleCheckbox:checked').map(function () {
                    return $(this).val();
                }).get();
                var url = "{{ route('sales.export') }}";
                if (selectedIds.length > 0) url += '?ids=' + selectedIds.join(',');
                else $('#alertsContainer').html(
                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('messages.please_select_someone_columns_first_if_you_want_to_export') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                );
                if (selectedIds.length > 0) window.location.href = url;
            });
        });
    </script>
@endpush
