@extends('admin.master')
@section('title', __('messages.purchases_list'))

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
                                    <h5 class="card-title mb-0 fw-semibold">{{ __('messages.purchases_list') }}</h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                            id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> {{ __('messages.actions') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3"
                                            aria-labelledby="actionDropdown">
                                            <li><a class="dropdown-item" href="{{ route('purchases.create') }}">
                                                    <i class="bi bi-plus-circle me-2"></i>{{ __('messages.add') }}</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" id="exportPurchases">
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
                                <table class="table table-striped table-bordered rounded-3 align-middle"
                                    id="purchasesTable">
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
        <div class="modal fade" id="showPurchaseModal" tabindex="-1" aria-labelledby="showPurchaseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="showPurchaseModalLabel">
                            {{ __('messages.purchase_details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>{{ __('messages.id') }}:</strong> <span id="show-id"></span></p>
                        <p><strong>{{ __('messages.total_amount') }}:</strong> <span id="show-total_amount"></span></p>
                        <p><strong>{{ __('messages.date') }}:</strong> <span id="show-date"></span></p>
                        <h5>{{ __('messages.items') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.product') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.cost_price') }}</th>
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
        <div class="modal fade" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="editPurchaseModalLabel">
                            {{ __('messages.edit_purchase') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="edit-error-alert" class="d-none"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <form id="edit-purchase-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit-id">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="edit-total_amount"
                                        class="form-label fw-medium">{{ __('messages.total_amount') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_amount" id="edit-total_amount"
                                        class="form-control rounded-3" readonly required>
                                    <div class="invalid-feedback" id="total_amount-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-date" class="form-label fw-medium">{{ __('messages.date') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" name="date" id="edit-date" class="form-control rounded-3"
                                        required>
                                    <div class="invalid-feedback" id="date-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-status" class="form-label fw-medium">{{ __('messages.status') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="edit-status" class="form-select rounded-3" required>
                                        <option value="pending">{{ __('messages.pending') }}</option>
                                        <option value="completed">{{ __('messages.completed') }}</option>
                                        <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="status-error"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5>{{ __('messages.items') }}</h5>
                                <div class="position-relative mb-3">
                                    <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control edit-product-search rounded-3" placeholder="{{ __('messages.search_product') }}" autocomplete="off">
                                    <div class="edit-suggestions border position-absolute bg-white w-100 rounded-3 shadow-sm" style="display: none; z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                                </div>
                                <table class="table table-bordered table-hover" id="edit-itemsTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.product') }}</th>
                                            <th>{{ __('messages.quantity') }}</th>
                                            <th>{{ __('messages.cost_price') }}</th>
                                            <th>{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit-itemsBody"></tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm rounded-3">{{ __('messages.update') }}</button>
                                <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
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
        $(document).ready(function() {
            var table = $('#purchasesTable').DataTable({
                dom: 'lBfrtip',
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, 50, -1],
                    ["{{ __('messages.10') }}", "{{ __('messages.20') }}", "{{ __('messages.30') }}",
                        "{{ __('messages.50') }}", "{{ __('messages.all') }}"
                    ]
                ],
                buttons: [],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchases.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `<input type="checkbox" class="purchaseCheckbox" value="${data}">`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'total_amount',
                        name: 'purchases.total_amount',
                        render: $.fn.dataTable.render.number(',', '.', 2)
                    },
                    {
                        data: 'date',
                        name: 'purchases.date'
                    },
                    {
                        data: 'item_count',
                        name: 'item_count',
                        searchable: false
                    },
                    {
                        data: 'total_quantity',
                        name: 'total_quantity',
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
                    lengthMenu: '{{ __('messages.show') }} _MENU_{{ __('messages.entries') }}',
                    search: '{{ __('messages.search') }}',
                    emptyTable: "{{ __('messages.no_data_available') }}",
                    processing: "{{ __('messages.processing') }}",
                    zeroRecords: "{{ __('messages.no_matching_records') }}",
                    infoEmpty: "{{ __('messages.showing_0_to_0_of_0_entries') }}",
                    infoFiltered: "{{ __('messages.filtered_from_total_entries', ['total' => '_MAX_']) }}"
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.show-purchase', function() {
                const id = $(this).data('id');
                console.log('Fetching purchase with ID:', id);
                $.ajax({
                    url: '{{ route('purchases.show', ['purchase' => ':id']) }}'.replace(':id', id),
                    method: 'GET',
                    success: function(response) {
                        console.log('Show Response:', response);
                        if (response.error) {
                            $('#alertsContainer').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${response.error}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                            return;
                        }
                        const purchase = response.purchase;
                        $('#show-id').text(purchase.id || 'N/A');
                        $('#show-total_amount').text((purchase.total_amount || 0).toFixed(2));
                        $('#show-date').text(purchase.date || 'N/A');
                        let itemsHtml = '';
                        (purchase.items || []).forEach(item => {
                            itemsHtml += `
                                <tr>
                                    <td>${item.product?.name || 'N/A'} (code: ${item.product?.code || 'N/A'})</td>
                                    <td>${item.quantity || 0}</td>
                                    <td>${(item.cost_price || 0).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        $('#show-items').html(itemsHtml || '<tr><td colspan="3">No items</td></tr>');
                        $('#showPurchaseModal').modal('show');
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to load purchase details. Please try again.';
                        if (xhr.status === 404) errorMsg = 'Purchase not found.';
                        else if (xhr.status === 500) errorMsg = 'Server error occurred.';
                        $('#alertsContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${errorMsg}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        console.log('Error Details:', xhr.status, xhr.responseText);
                    }
                });
            });

            let editItemIndex = 0;
            const products = @json($products);
            const STORAGE_KEY = 'edit_purchase_form_items';

            // Load items from localStorage
            function loadEditFromStorage() {
                try {
                    const savedItems = localStorage.getItem(STORAGE_KEY);
                    if (savedItems) {
                        const items = JSON.parse(savedItems);
                        items.forEach(item => {
                            addEditProductToTable(item.id, item.name, item.cost_price, item.quantity);
                        });
                        updateEditTotalAmount();

                        if (items.length > 0) {
                            $('#edit-error-alert').html(`
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <i class="bi bi-info-circle"></i> Restored ${items.length} item(s) from your previous edit session.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `).removeClass('d-none');
                            setTimeout(() => $('#edit-error-alert .alert-info').fadeOut(), 5000);
                        }
                    }
                } catch (error) {
                    console.error('Error loading from localStorage:', error);
                    localStorage.removeItem(STORAGE_KEY);
                }
            }

            // Save items to localStorage
            function saveEditToStorage() {
                try {
                    const items = [];
                    $('#edit-itemsBody .item-row').each(function() {
                        const row = $(this);
                        items.push({
                            id: row.find('input[name*="[product_id]"]').val(),
                            name: row.find('.fw-medium').text().trim(),
                            cost_price: parseFloat(row.find('input[name*="[cost_price]"]').val()) || 0,
                            quantity: parseInt(row.find('input[name*="[quantity]"]').val()) || 1
                        });
                    });
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
                } catch (error) {
                    console.error('Error saving to localStorage:', error);
                }
            }

            // Clear localStorage
            function clearEditStorage() {
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (error) {
                    console.error('Error clearing localStorage:', error);
                }
            }

            // Display no products message
            function showEditNoProductsMessage(container, message = '{{ __('messages.no_products_available') }}') {
                container.html(`
                    <div class="px-3 py-2 text-muted">${message}</div>
                `).show();
            }

            // Render product suggestions
            function renderEditSuggestions(matches, container) {
                if (matches.length === 0) {
                    showEditNoProductsMessage(container, '{{ __('messages.no_products_found') }}');
                    return;
                }

                let html = '';
                matches.forEach(p => {
                    const existingRow = $(`#edit-itemsBody input[name^="items["][name$="][product_id]"]`).filter(function() {
                        return $(this).val() == p.id;
                    }).closest('.item-row');

                    const isSelected = existingRow.length > 0;
                    const currentQty = isSelected ? existingRow.find('.quantity').val() : 0;

                    html += `
                        <div class="card suggestion-item cursor-pointer ${isSelected ? 'border-primary border-2' : ''}"
                            data-id="${p.id}"
                            data-name="${p.name}"
                            data-cost_price="${p.cost_price || 0}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 fw-semibold">${p.name}</h6>
                                        <p class="card-subtitle text-muted small mb-0">code: ${p.code}</p>
                                    </div>
                                    ${isSelected ? `
                                        <div class="text-end">
                                            <small class="text-primary fw-medium">In cart: ${currentQty}</small>
                                            <div><small class="text-muted">Click to add +1</small></div>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.html(html).show();
            }

            // Initialize product search
            function initEditProductSearch() {
                const input = $('.edit-product-search');
                const suggestionsDiv = $('.edit-suggestions');

                if (!products || products.length === 0) {
                    input.on('focus', () => showEditNoProductsMessage(suggestionsDiv));
                    return;
                }

                input.on('focus', () => renderEditSuggestions(products, suggestionsDiv));

                input.on('keyup', function() {
                    const keyword = $(this).val().toLowerCase().trim();
                    suggestionsDiv.empty().hide();

                    if (keyword.length === 0) {
                        renderEditSuggestions(products, suggestionsDiv);
                        return;
                    }

                    if (keyword.length < 2) return;

                    const matches = products.filter(p => p.name && p.name.toLowerCase().includes(keyword));
                    renderEditSuggestions(matches, suggestionsDiv);
                });

                suggestionsDiv.on('click', '.suggestion-item', function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    const cost_price = $(this).data('cost_price');

                    const existingRow = $(`#edit-itemsBody input[name^="items["][name$="][product_id]"]`).filter(function() {
                        return $(this).val() == id;
                    }).closest('.item-row');

                    if (existingRow.length > 0) {
                        const quantityInput = existingRow.find('.quantity');
                        const currentQuantity = parseInt(quantityInput.val()) || 0;
                        const newQuantity = currentQuantity + 1;

                        quantityInput.val(newQuantity);
                        quantityInput.trigger('input');

                        input.val('');
                        suggestionsDiv.hide();
                        saveEditToStorage();

                        $('#edit-error-alert').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> Quantity increased for "${name}". New quantity: ${newQuantity}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `).removeClass('d-none');
                        setTimeout(() => $('#edit-error-alert .alert-success').fadeOut(), 3000);
                        return;
                    }

                    addEditProductToTable(id, name, cost_price);
                    input.val('');
                    suggestionsDiv.hide();
                    saveEditToStorage();
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.edit-product-search, .edit-suggestions').length) {
                        suggestionsDiv.hide();
                    }
                });
            }

            // Add product to table
            function addEditProductToTable(id, name, cost_price, quantity = 1) {
                const newRow = `
                    <tr class="item-row" data-product-id="${id}">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="fw-medium">${name}</div>
                            </div>
                            <input type="hidden" name="items[${editItemIndex}][product_id]" value="${id}">
                        </td>
                        <td>
                            <input type="number" name="items[${editItemIndex}][quantity]" class="form-control quantity" value="${quantity}" min="1" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[${editItemIndex}][cost_price]" class="form-control cost_price" value="${cost_price}" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="bi bi-trash"></i> {{ __('messages.remove') }}
                            </button>
                        </td>
                    </tr>`;
                $('#edit-itemsBody').append(newRow);
                editItemIndex++;
                updateEditTotalAmount();

                $('#edit-error-alert').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-plus-circle"></i> "${name}" added to cart successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `).removeClass('d-none');
                setTimeout(() => $('#edit-error-alert .alert-success').fadeOut(), 3000);
            }

            // Update total amount
            function updateEditTotalAmount() {
                let total = 0;
                $('#edit-itemsBody .item-row').each(function() {
                    const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                    const price = parseFloat($(this).find('.cost_price').val()) || 0;
                    total += quantity * price;
                });
                $('#edit-total_amount').val(total.toFixed(2));
            }

            // Update total on quantity or price change
            $(document).on('input', '#edit-itemsBody .quantity, #edit-itemsBody .cost_price', function() {
                updateEditTotalAmount();
                saveEditToStorage();
            });

            // Remove item
            $(document).on('click', '#edit-itemsBody .remove-item', function() {
                const productName = $(this).closest('.item-row').find('.fw-medium').text();
                $(this).closest('.item-row').remove();
                updateEditTotalAmount();
                saveEditToStorage();

                $('#edit-error-alert').html(`
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle"></i> "${productName}" removed from cart.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `).removeClass('d-none');
                setTimeout(() => $('#edit-error-alert .alert-info').fadeOut(), 3000);
            });

            $(document).on('click', '.edit-purchase', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: '{{ route('purchases.edit', ['purchase' => ':id']) }}'.replace(':id', id),
                    method: 'GET',
                    success: function(response) {
                        const purchase = response.purchase;
                        $('#edit-id').val(purchase.id);
                        $('#edit-total_amount').val(purchase.total_amount).removeClass('is-invalid');
                        $('#edit-date').val(purchase.date).removeClass('is-invalid');
                        $('#edit-status').val(purchase.status || 'pending').removeClass('is-invalid');
                        $('#edit-itemsBody').empty();
                        editItemIndex = 0;
                        purchase.items.forEach(item => {
                            addEditProductToTable(
                                item.product_id,
                                item.product?.name || 'N/A',
                                item.cost_price,
                                item.quantity
                            );
                        });
                        updateEditTotalAmount();
                        clearEditStorage();
                        saveEditToStorage();
                        initEditProductSearch();
                        $('#editPurchaseModal').modal('show');
                    },
                    error: function(xhr) {
                        $('#alertsContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to load purchase for editing. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            });

            $('#edit-purchase-form').on('submit', function(e) {
                e.preventDefault();
                if ($('#edit-itemsBody .item-row').length === 0) {
                    $('#edit-error-alert').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ __('messages.please_add_at_least_one_item') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `).removeClass('d-none');
                    return;
                }

                const id = $('#edit-id').val();
                $.ajax({
                    url: '{{ route('purchases.update', ['purchase' => ':id']) }}'.replace(':id', id),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        clearEditStorage();
                        $('#editPurchaseModal').modal('hide');
                        table.ajax.reload();
                        $('#alertsContainer').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('messages.purchase_updated_successfully') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
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

            $(document).on('click', '.delete-purchase', function() {
                const purchaseId = $(this).data('id');
                $('#deleteForm').attr('action', '{{ route('purchases.destroy', ['purchase' => ':id']) }}'.replace(':id', purchaseId));
                $('#deleteModal').modal('show');
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                const action = $(this).attr('action');
                $.ajax({
                    url: action,
                    type: 'DELETE',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        $('#alertsContainer').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('messages.purchase_deleted_successfully') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        $('#alertsContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to delete the purchase. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            });

            $('#bulkDeleteBtn').on('click', function() {
                const selectedIds = $('.purchaseCheckbox:checked').map(function() {
                    return $(this).val();
                }).get();
                if (selectedIds.length === 0) {
                    $('#alertsContainer').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ __('messages.please_select_someone_columns_first_if_you_want_to_export') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    return;
                }
                $('#bulkDeleteModal').modal('show');
                $('#confirmBulkDelete').off('click').on('click', function() {
                    $.ajax({
                        url: "{{ route('purchases.bulkDelete') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedIds
                        },
                        success: function(response) {
                            $('#bulkDeleteModal').modal('hide');
                            table.ajax.reload();
                            $('#selectAll').prop('checked', false);
                            $('#bulkDeleteBtn').prop('disabled', true);
                            $('#alertsContainer').html(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ __('messages.selected_purchases_deleted_successfully') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        },
                        error: function(xhr) {
                            $('#alertsContainer').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Failed to delete selected purchases. Please try again.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        }
                    });
                });
            });

            $('#selectAll').on('click', function() {
                $('.purchaseCheckbox').prop('checked', $(this).prop('checked'));
                toggleBulkDeleteButton();
            });
            $(document).on('change', '.purchaseCheckbox', function() {
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                $('#bulkDeleteBtn').prop('disabled', $('.purchaseCheckbox:checked').length === 0);
            }

            $('#exportPurchases').on('click', function() {
                var selectedIds = $('.purchaseCheckbox:checked').map(function() {
                    return $(this).val();
                }).get();
                var url = "{{ route('purchases.export') }}";
                if (selectedIds.length > 0) url += '?ids=' + selectedIds.join(',');
                else $('#alertsContainer').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('messages.please_select_someone_columns_first_if_you_want_to_export') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                if (selectedIds.length > 0) window.location.href = url;
            });
        });
    </script>
@endpush