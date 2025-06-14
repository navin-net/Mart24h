@extends('admin.master')

@section('title', __('messages.add_sale'))

@section('content')
    <div class="container-fluid py-4">
        <div class="pagetitle mb-4">
            <h1 class="display-6 fw-bold">{{ __('messages.add_sale') }}</h1>
            <nav>
                <ol class="breadcrumb rounded-3 p-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"
                            class="text-primary text-decoration-none">{{ __('messages.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('sales.index') }}"
                            class="text-primary text-decoration-none">{{ __('messages.sales') }}</a>
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
                                        <label for="total_amount"
                                            class="form-label fw-medium">{{ __('messages.total_amount') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="total_amount" id="total_amount"
                                            class="form-control rounded-3" readonly required>
                                        <div class="invalid-feedback" id="total_amount-error"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label fw-medium">{{ __('messages.status') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select rounded-3" required>
                                            <option value="pending">{{ __('messages.pending') }}</option>
                                            <option value="completed">{{ __('messages.completed') }}</option>
                                            <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                        </select>
                                        <div class="invalid-feedback" id="status-error"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label for="date" class="form-label fw-medium">
                                            {{ __('messages.date') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" name="date" id="date"
                                            class="form-control rounded-3" required>
                                        <div class="invalid-feedback" id="date-error"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5>{{ __('messages.items') }}</h5>
                                    <div class="position-relative mb-3">
                                        <label class="form-label fw-medium">{{ __('messages.product') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control product-search rounded-3"
                                            placeholder="{{ __('messages.search_product') }}" autocomplete="off">
                                        <div class="suggestions border position-absolute bg-white w-100 rounded-3 shadow-sm"
                                            style="display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                        </div>
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
                                    <button type="submit"
                                        class="btn btn-primary btn-sm rounded-3">{{ __('messages.submit') }}</button>
                                    <a href="{{ route('sales.index') }}"
                                        class="btn btn-secondary btn-sm rounded-3">{{ __('messages.cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Submission Confirmation Modal -->
        <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel"
            aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">{{ __('messages.no') }}</button>
                        <button type="button" class="btn btn-primary btn-sm"
                            id="confirmSubmitBtn">{{ __('messages.yes') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Product Confirmation Modal -->
        <div class="modal fade" id="confirmAddProductModal" tabindex="-1" aria-labelledby="confirmAddProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmAddProductModalLabel">{{ __('messages.confirm_add_product') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="addProductMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">{{ __('messages.no') }}</button>
                        <button type="button" class="btn btn-primary btn-sm"
                            id="confirmAddProductBtn">{{ __('messages.yes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let itemIndex = 0;
    const products = @json($products);
    let pendingProduct = null;
    const STORAGE_KEY = 'sale_form_items';

    // Load items from localStorage on page load
    function loadFromStorage() {
        try {
            const savedItems = localStorage.getItem(STORAGE_KEY);
            if (savedItems) {
                const items = JSON.parse(savedItems);
                items.forEach(item => {
                    addProductToTable(item.id, item.name, item.price, item.stock, item.quantity, item.sale_price);
                });
                updateTotalAmount();

                // Show notification about restored items
                if (items.length > 0) {
                    $('#alertsContainer').html(`
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="bi bi-info-circle"></i> Restored ${items.length} item(s) from your previous session.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);

                    setTimeout(function() {
                        $('#alertsContainer .alert-info').fadeOut();
                    }, 5000);
                }
            }
        } catch (error) {
            console.error('Error loading from localStorage:', error);
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    // Save current items to localStorage
    function saveToStorage() {
        try {
            const items = [];
            $('#itemsBody .item-row').each(function() {
                const row = $(this);
                const item = {
                    id: row.find('input[name*="[product_id]"]').val(),
                    name: row.find('.fw-medium').text().trim(),
                    price: parseFloat(row.find('input[name*="[sale_price]"]').val()) || 0,
                    stock: parseInt(row.find('.stock-quantity').val()) || 0,
                    quantity: parseInt(row.find('input[name*="[quantity]"]').val()) || 1,
                    sale_price: parseFloat(row.find('input[name*="[sale_price]"]').val()) || 0
                };
                items.push(item);
            });

            localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
        } catch (error) {
            console.error('Error saving to localStorage:', error);
        }
    }

    // Clear localStorage
    function clearStorage() {
        try {
            localStorage.removeItem(STORAGE_KEY);
        } catch (error) {
            console.error('Error clearing localStorage:', error);
        }
    }

    // Function to display no products available message
    function showNoProductsMessage(container, message = '{{ __('messages.no_products_available') }}') {
        container.html(`
            <div class="px-3 py-2 text-muted">${message}</div>
        `).show();
    }

    // Function to render product suggestions
    function renderSuggestions(matches, container) {
        if (matches.length === 0) {
            showNoProductsMessage(container, '{{ __('messages.no_products_found') }}');
            return;
        }

        let html = '';
        matches.forEach(p => {
            const existingRow = $(
                `#itemsBody [name="items[${itemIndex}][product_id]"], #itemsBody [name^="items["][name$="][product_id]"]`
            ).filter(function() {
                return $(this).val() == p.id;
            }).closest('.item-row');

            const isSelected = existingRow.length > 0;
            const currentQty = isSelected ? existingRow.find('.quantity').val() : 0;

            html += `
                <div class="card suggestion-item cursor-pointer ${isSelected ? 'border-primary border-2' : ''}"
                    data-id="${p.id}"
                    data-name="${p.name}"
                    data-price="${p.selling_price}"
                    data-stock="${p.stock_quantity}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title mb-1 fw-semibold">${p.name}</h6>
                                <p class="card-subtitle text-muted small mb-0">SKU: ${p.sku}</p>
                                <p class="text-muted small mb-0">Stock: ${p.stock_quantity}</p>
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

    // Product search and suggestions
    function initProductSearch() {
        const input = $('.product-search');
        const suggestionsDiv = $('.suggestions');

        if (!products || products.length === 0) {
            input.on('focus', function() {
                showNoProductsMessage(suggestionsDiv);
            });
            return;
        }

        input.on('focus', function() {
            renderSuggestions(products, suggestionsDiv);
        });

        input.on('keyup', function() {
            const keyword = $(this).val().toLowerCase().trim();
            suggestionsDiv.empty().hide();

            if (keyword.length === 0) {
                renderSuggestions(products, suggestionsDiv);
                return;
            }

            if (keyword.length < 2) {
                return;
            }

            const matches = products.filter(p => p.name && p.name.toLowerCase().includes(keyword));
            renderSuggestions(matches, suggestionsDiv);
        });

        suggestionsDiv.on('click', '.suggestion-item', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const stock = parseInt($(this).data('stock')) || 0;

            const existingRow = $(`#itemsBody input[name^="items["][name$="][product_id]"]`).filter(
                function() {
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

                // Save to localStorage after updating quantity
                saveToStorage();

                $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> Quantity increased for "${name}". New quantity: ${newQuantity}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                setTimeout(function() {
                    $('#alertsContainer .alert-success').fadeOut();
                }, 3000);

                return;
            }

            if (stock <= 0) {
                pendingProduct = { id, name, price, stock };
                $('#addProductMessage').text(
                    `The product "${name}" is out of stock. Do you want to add it anyway?`);
                const modal = new bootstrap.Modal(document.getElementById('confirmAddProductModal'));
                modal.show();
                return;
            }

            addProductToTable(id, name, price, stock);
            input.val('');
            suggestionsDiv.hide();

            // Save to localStorage after adding new product
            saveToStorage();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.product-search, .suggestions').length) {
                suggestionsDiv.hide();
            }
        });
    }

    // Modified function to add product to table with optional quantity and sale_price
    function addProductToTable(id, name, price, stock, quantity = 1, sale_price = null) {
        const finalSalePrice = sale_price || price;
        const newRow = `
            <tr class="item-row" data-product-id="${id}">
                <td>
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="fw-medium">${name}</div>
                            <small class="text-muted">Stock: ${stock}</small>
                        </div>
                    </div>
                    <input type="hidden" name="items[${itemIndex}][product_id]" value="${id}">
                    <input type="hidden" class="stock-quantity" value="${stock}">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" value="${quantity}" min="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${itemIndex}][sale_price]" class="form-control sale_price" value="${finalSalePrice}" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="bi bi-trash"></i> {{ __('messages.remove') }}
                    </button>
                </td>
            </tr>`;
        $('#itemsBody').append(newRow);
        itemIndex++;
        updateTotalAmount();

        // Only show success message for new products (not when loading from storage)
        if (sale_price === null) {
            $('#alertsContainer').html(`
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-plus-circle"></i> "${name}" added to cart successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);

            setTimeout(function() {
                $('#alertsContainer .alert-success').fadeOut();
            }, 3000);
        }
    }

    // Handle confirm add product button click
    $('#confirmAddProductBtn').on('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmAddProductModal'));
        modal.hide();

        if (pendingProduct) {
            addProductToTable(pendingProduct.id, pendingProduct.name, pendingProduct.price, pendingProduct.stock);
            $('.product-search').val('');
            $('.suggestions').hide();

            // Save to localStorage after adding product
            saveToStorage();

            pendingProduct = null;
        }
    });

    // Remove item with localStorage update
    $(document).on('click', '.remove-item', function() {
        const productName = $(this).closest('.item-row').find('td:first .fw-medium').text();
        $(this).closest('.item-row').remove();
        updateTotalAmount();

        // Save to localStorage after removing item
        saveToStorage();

        $('#alertsContainer').html(`
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle"></i> "${productName}" removed from cart.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

        setTimeout(function() {
            $('#alertsContainer .alert-info').fadeOut();
        }, 3000);
    });

    // Update total amount
    function updateTotalAmount() {
        let total = 0;
        $('#itemsBody .item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const price = parseFloat($(this).find('.sale_price').val()) || 0;
            total += quantity * price;
        });
        $('#total_amount').val(total.toFixed(2));
    }

    // Update total and validate stock on quantity or price change with localStorage save
    $(document).on('input', '.quantity, .sale_price', function() {
        const row = $(this).closest('.item-row');
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const stock = parseInt(row.find('.stock-quantity').val()) || 0;
        const productName = row.find('.fw-medium').text().trim();

        if (quantity > stock && stock > 0) {
            row.find('.quantity').addClass('is-invalid');
            $('#alertsContainer').html(`
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> The quantity for "${productName}" exceeds available stock (${stock}). You can still proceed with the sale if confirmed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
        } else {
            row.find('.quantity').removeClass('is-invalid');
            if ($('#alertsContainer .alert-warning').length > 0) {
                $('#alertsContainer').html('');
            }
        }

        updateTotalAmount();

        // Save to localStorage after quantity/price change
        saveToStorage();
    });

    // Add clear cart functionality
    function addClearCartButton() {
        const clearButton = `
            <button type="button" id="clearCartBtn" class="btn btn-outline-danger btn-sm ms-2" title="Clear all items from cart">
                <i class="bi bi-trash"></i> Clear Cart
            </button>
        `;

        // Add the button next to the items header
        if ($('#clearCartBtn').length === 0) {
            $('h5:contains("{{ __('messages.items') }}")').after(clearButton);
        }
    }

    // Handle clear cart button click
    $(document).on('click', '#clearCartBtn', function() {
        if ($('#itemsBody .item-row').length === 0) {
            $('#alertsContainer').html(`
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle"></i> Cart is already empty.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            return;
        }

        if (confirm('Are you sure you want to clear all items from the cart?')) {
            $('#itemsBody').empty();
            updateTotalAmount();
            clearStorage();

            $('#alertsContainer').html(`
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle"></i> Cart cleared successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);

            setTimeout(function() {
                $('#alertsContainer .alert-info').fadeOut();
            }, 3000);
        }
    });

    // Initialize product search
    initProductSearch();

    // Load saved items from localStorage
    loadFromStorage();

    // Add clear cart button
    addClearCartButton();

    // Form submission with confirmation
    $('#saleForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#itemsBody .item-row').length === 0) {
            $('#alertsContainer').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ __('messages.please_add_at_least_one_item') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            return;
        }

        let stockIssuesHtml = '';
        $('#itemsBody .item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const stock = parseInt($(this).find('.stock-quantity').val()) || 0;
            const productName = $(this).find('.fw-medium').text().trim();

            if (quantity > stock && stock >= 0) {
                $(this).find('.quantity').addClass('is-invalid');
                stockIssuesHtml += `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> The quantity for "${productName}" exceeds available stock (${stock}).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            }
        });

        $('#stockIssues').html(stockIssuesHtml);
        if (stockIssuesHtml) {
            $('#confirmMessage').text('{{ __('messages.stock_issues_detected') }}');
        } else {
            $('#confirmMessage').text('{{ __('messages.confirm_sale_submission') }}');
        }

        const modal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
        modal.show();
    });

    // Handle confirm submit button click
    $('#confirmSubmitBtn').on('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmSubmitModal'));
        modal.hide();

        $(this).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
        );

        $.ajax({
            url: '{{ route('sales.store') }}',
            type: 'POST',
            data: $('#saleForm').serialize(),
            success: function(response) {
                // Clear localStorage on successful submission
                clearStorage();

                $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                window.location.href = response.redirect;
            },
            error: function(xhr) {
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
                        <i class="bi bi-exclamation-circle"></i> {{ __('messages.please_fix_errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                $('#confirmSubmitBtn').prop('disabled', false).html('{{ __('messages.yes') }}');
            }
        });
    });

    // Optional: Clear localStorage when user navigates away or closes the page
    // Uncomment if you want to clear storage when leaving the page
    /*
    $(window).on('beforeunload', function() {
        clearStorage();
    });
    */
});
</script>
@endpush
