<div class="receipt">
    <h4>Receipt</h4>
    <small>Transaction ID: {{ $sale->id }}</small>
    <small>Date: {{ $sale->date->format('Y-m-d H:i:s') }}</small>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div class="totals">
        <div class="d-flex justify-content-between">
            <span>Subtotal:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Tax (8%):</span>
            <span>${{ number_format($tax, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Total:</span>
            <span>${{ number_format($total, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Payment Method:</span>
            <span>{{ ucfirst($payment_method) }}</span>
        </div>
    </div>
    <hr>
    <div class="footer">
        Thank you for your purchase!
    </div>
</div>