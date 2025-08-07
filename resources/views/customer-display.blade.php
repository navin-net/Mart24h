<!-- resources/views/admin/customer-display.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #333;
            padding: 20px;
        }
        .cart-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .totals {
            font-weight: bold;
            font-size: 1.2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .display-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .empty-cart {
            text-align: center;
            color: #666;
            padding: 50px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="display-header">Current Order</h2>
        <div id="customerCartItems" class="mb-3">
            <div class="empty-cart">No items in cart</div>
        </div>
        <div class="totals">
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span id="customerSubtotal">$0.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax (8%):</span>
                <span id="customerTax">$0.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span>Total:</span>
                <span id="customerTotal">$0.00</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="{{ asset('js/pusher.min.js') }}"></script> <!-- Include Pusher or your broadcasting client -->
    <script>
        // Initialize Pusher (adjust with your Pusher key or Laravel WebSockets config)
        Pusher.logToConsole = true; // For debugging
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        const channel = pusher.subscribe('public-cart-channel');
        channel.bind('App\\Events\\CartUpdated', function(data) {
            updateCustomerDisplay(data.cart, data.subtotal, data.tax, data.total);
        });

        function updateCustomerDisplay(cart, subtotal, tax, total) {
            const cartItems = $('#customerCartItems');
            cartItems.empty();
            if (!cart || cart.length === 0) {
                cartItems.html('<div class="empty-cart">No items in cart</div>');
                $('#customerSubtotal').text('$0.00');
                $('#customerTax').text('$0.00');
                $('#customerTotal').text('$0.00');
                return;
            }

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                cartItems.append(`
                    <div class="cart-item d-flex justify-content-between">
                        <div>
                            <h5>${item.name}</h5>
                            <p class="mb-0">$${item.price.toFixed(2)} x ${item.quantity}</p>
                        </div>
                        <div>$${itemTotal.toFixed(2)}</div>
                    </div>
                `);
            });

            $('#customerSubtotal').text(`$${subtotal.toFixed(2)}`);
            $('#customerTax').text(`$${tax.toFixed(2)}`);
            $('#customerTotal').text(`$${total.toFixed(2)}`);
        }
    </script>
</body>
</html>