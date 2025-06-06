@extends('admin.master')

@section('title', __('messages.add_sale'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ __('messages.add_sale') }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">{{ __('messages.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('sales.index') }}" class="text-primary text-decoration-none">{{ __('messages.sales') }}</a>
                </li>
                <li class="breadcrumb-item active text-muted">{{ __('messages.create') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">{{ __('messages.add_new_sale') }}</h5>
                        <div id="alertsContainer" class="mb-4"></div>

                        <form id="saleForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="total_amount" class="form-label fw-medium">{{ __('messages.total_amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control rounded-3" readonly required>
                                    <div class="invalid-feedback" id="total_amount-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-medium">{{ __('messages.status') }} <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select rounded-3" required>
                                        <option value="pending">{{ __('messages.pending') }}</option>
                                        <option value="completed">{{ __('messages.completed') }}</option>
                                        <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                    </select>
                                    <div class="invalid-feedback" id="status-error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="date" class="form-label fw-medium">{{ __('messages.date') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                                    <div class="invalid-feedback" id="date-error"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h5>{{ __('messages.items') }}</h5>
                                <div class="position-relative mb-3">
                                    <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control product-search rounded-3" placeholder="{{ __('messages.search_product') }}" autocomplete="off">
                                    <div class="suggestions border position-absolute bg-white w-100 rounded-3 shadow-sm" style="display: none; z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                                </div>
                                <table class="table table-bordered table-hover" id="itemsTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.product') }}</th>
                                            <th>{{ __('messages.quantity') }}</th>
                                            <th>{{ __('messages.sale_price') }}</th>
                                            <th>{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody"></tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm rounded-3">{{ __('messages.submit') }}</button>
                                <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm rounded-3">{{ __('messages.cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Submission Confirmation Modal -->
    <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmSubmitModalLabel">{{ __('messages.confirm_submission') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="stockIssues"></div>
                    <p id="confirmMessage">{{ __('messages.confirm_sale_submission') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('messages.no') }}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="confirmSubmitBtn">{{ __('messages.yes') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Confirmation Modal -->
    <div class="modal fade" id="confirmAddProductModal" tabindex="-1" aria-labelledby="confirmAddProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmAddProductModalLabel">{{ __('messages.confirm_add_product') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="addProductMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('messages.no') }}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="confirmAddProductBtn">{{ __('messages.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    let itemIndex = 0;
    const products = @json($products);
    let pendingProduct = null; // Store product data temporarily for confirmation

    // Product search and suggestions
    function initProductSearch() {
        const input = $('.product-search');
        const suggestionsDiv = $('.suggestions');

        input.on('keyup', function () {
            const keyword = $(this).val().toLowerCase().trim();
            if (keyword.length < 2) {
                suggestionsDiv.hide();
                return;
            }
            const matches = products.filter(p => p.name && p.name.toLowerCase().includes(keyword));
            if (matches.length === 0) {
                suggestionsDiv.hide();
                return;
            }

            let html = '';
            matches.forEach(p => {
                html += `<div class="suggestion-item px-3 py-2 cursor-pointer" data-id="${p.id}" data-name="${p.name}" data-price="${p.selling_price}" data-stock="${p.stock_quantity}">
                    ${p.name} (SKU: ${p.sku}, Stock: ${p.stock_quantity})
                </div>`;
            });
            suggestionsDiv.html(html).show();
        });

        suggestionsDiv.on('click', '.suggestion-item', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const stock = parseInt($(this).data('stock')) || 0;

            // Prevent adding duplicate products
            if ($(`#itemsBody [name="items[]\\[product_id\\]"][value="${id}"]`).length > 0) {
                $('#alertsContainer').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        The product "${name}" is already added to the sale.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                input.val('');
                suggestionsDiv.hide();
                return;
            }

            // If stock is 0, show confirmation modal
            if (stock <= 0) {
                pendingProduct = { id, name, price, stock };
                $('#addProductMessage').text(`The product "${name}" is out of stock. Do you want to add it anyway?`);
                const modal = new bootstrap.Modal(document.getElementById('confirmAddProductModal'));
                modal.show();
                return;
            }

            // Add product directly if stock is available
            addProductToTable(id, name, price, stock);
            input.val('');
            suggestionsDiv.hide();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.product-search, .suggestions').length) {
                suggestionsDiv.hide();
            }
        });
    }

    // Function to add product to table
    function addProductToTable(id, name, price, stock) {
        const newRow = `
            <tr class="item-row" data-product-id="${id}">
                <td>
                    ${name}
                    <input type="hidden" name="items[${itemIndex}][product_id]" value="${id}">
                    <input type="hidden" class="stock-quantity" value="${stock}">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${itemIndex}][sale_price]" class="form-control sale_price" value="${price}" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">{{ __('messages.remove') }}</button>
                </td>
            </tr>`;
        $('#itemsBody').append(newRow);
        itemIndex++;
        updateTotalAmount();
    }

    // Handle confirm add product button click
    $('#confirmAddProductBtn').on('click', function () {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmAddProductModal'));
        modal.hide();

        if (pendingProduct) {
            addProductToTable(pendingProduct.id, pendingProduct.name, pendingProduct.price, pendingProduct.stock);
            $('.product-search').val('');
            $('.suggestions').hide();
            pendingProduct = null;
        }
    });

    // Remove item
    $(document).on('click', '.remove-item', function () {
        $(this).closest('.item-row').remove();
        updateTotalAmount();
    });

    // Update total amount
    function updateTotalAmount() {
        let total = 0;
        $('#itemsBody .item-row').each(function () {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const price = parseFloat($(this).find('.sale_price').val()) || 0;
            total += quantity * price;
        });
        $('#total_amount').val(total.toFixed(2));
    }

    // Update total and validate stock on quantity or price change
    $(document).on('input', '.quantity, .sale_price', function () {
        const row = $(this).closest('.item-row');
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const stock = parseInt(row.find('.stock-quantity').val()) || 0;
        const productName = row.find('td:first').text().trim();

        if (quantity > stock && stock > 0) {
            row.find('.quantity').addClass('is-invalid');
            $('#alertsContainer').html(`
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    The quantity for "${productName}" exceeds available stock (${stock}). You can still proceed with the sale if confirmed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
        } else {
            row.find('.quantity').removeClass('is-invalid');
            $('#alertsContainer').html('');
        }
        updateTotalAmount();
    });

    // Initialize product search
    initProductSearch();

    // Form submission with confirmation
    $('#saleForm').on('submit', function (e) {
        e.preventDefault();
        if ($('#itemsBody .item-row').length === 0) {
            $('#alertsContainer').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ __('messages.please_add_at_least_one_item') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            return;
        }

        // Check for stock issues
        let stockIssuesHtml = '';
        $('#itemsBody .item-row').each(function () {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const stock = parseInt($(this).find('.stock-quantity').val()) || 0;
            const productName = $(this).find('td:first').text().trim();

            if (quantity > stock && stock >= 0) {
                $(this).find('.quantity').addClass('is-invalid');
                stockIssuesHtml += `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        The quantity for "${productName}" exceeds available stock (${stock}).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            }
        });

        // Update modal content
        $('#stockIssues').html(stockIssuesHtml);
        if (stockIssuesHtml) {
            $('#confirmMessage').text('{{ __('messages.stock_issues_detected') }}');
        } else {
            $('#confirmMessage').text('{{ __('messages.confirm_sale_submission') }}');
        }

        // Show the confirmation modal
        const modal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
        modal.show();
    });

    // Handle confirm submit button click
    $('#confirmSubmitBtn').on('click', function () {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmSubmitModal'));
        modal.hide();

        $.ajax({
            url: '{{ route("sales.store") }}',
            type: 'POST',
            data: $('#saleForm').serialize(),
            success: function (response) {
                $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                window.location.href = response.redirect;
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors || {};
                $('.invalid-feedback').text('').hide();
                $('.form-control, .form-select').removeClass('is-invalid');
                for (let key in errors) {
                    const errorKey = key.replace(/\./g, '\\.').replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                    $(`#${errorKey}-error`).text(errors[key][0]).show();
                    $(`[name="${key}"]`).addClass('is-invalid');
                }
                $('#alertsContainer').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('messages.please_fix_errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    });
});
</script>
@endpush
