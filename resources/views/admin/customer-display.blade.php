<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Display - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #333333;
            --secondary-color: #666666;
            --border-color: #dddddd;
            --background-color: #f8f9fa;
            --text-color: #333333;
            --header-bg: #ffffff;
            --total-bg: #333333;
            --total-text: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .customer-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .customer-header {
            background: var(--header-bg);
            padding: 20px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .customer-header h1 {
            font-size: 2rem;
            font-weight: normal;
            color: var(--primary-color);
            margin: 0;
        }

        .store-info {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .connection-status {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #28a745;
        }

        .status-dot.disconnected {
            background: #dc3545;
        }

        .customer-content {
            flex: 1;
            display: flex;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .order-section {
            flex: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }

        .items-table th {
            background: var(--header-bg);
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--primary-color);
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .items-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .summary-section {
            margin-top: auto;
            padding: 20px;
            border-top: 2px solid var(--border-color);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 1rem;
        }

        .total-payable {
            background: var(--total-bg);
            color: var(--total-text);
            padding: 15px 20px;
            margin: 10px -20px -20px -20px;
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .welcome-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: var(--secondary-color);
        }

        .welcome-screen h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .promotional-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-left: 1px solid var(--border-color);
        }

        .promo-content h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .promo-content p {
            font-size: 1.1rem;
            color: var(--secondary-color);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .promo-footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .payment-processing, .payment-success {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 40px;
        }

        .payment-processing.active, .payment-success.active {
            display: flex;
        }

        .processing-icon, .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .processing-text, .success-text {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .processing-details, .success-details {
            font-size: 1rem;
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .customer-content { flex-direction: column; }
            .promotional-section { border-left: none; border-top: 1px solid var(--border-color); padding: 20px; }
            .items-table th, .items-table td { padding: 8px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>
    <div class="customer-container">
        <!-- Header Section -->
        <div class="customer-header">
            <div class="store-info">
                <small>POS System Store<br>123 Business Ave, City</small>
            </div>
            <h1>Customer Display</h1>
            <div class="connection-status">
                <div class="status-dot" id="connectionDot"></div>
                <span id="connectionText">Disconnected</span>
            </div>
        </div>

        <!-- Content Area -->
        <div class="customer-content">
            <!-- Order Section -->
            <div class="order-section">
                <!-- Welcome Screen -->
                <div class="welcome-screen" id="welcomeScreen">
                    <h2>Welcome!</h2>
                    <p>Your items will appear here as they are scanned</p>
                </div>

                <!-- Order Table -->
                <div id="orderTable" style="display: none; height: 100%; display: flex; flex-direction: column;">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be inserted here -->
                        </tbody>
                    </table>
                    <div class="summary-section">
                        <div class="summary-row">
                            <span>Items</span>
                            <span id="itemsTotal">0</span>
                        </div>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summarySubtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Order Tax</span>
                            <span id="summaryTax">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount</span>
                            <span id="summaryDiscount">$0.00</span>
                        </div>
                        <div class="total-payable">
                            <span>Total Payable</span>
                            <span id="totalPayable">$0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Processing Screen -->
                <div class="payment-processing" id="paymentProcessing">
                    <div class="processing-icon">⏳</div>
                    <div class="processing-text">Processing Payment...</div>
                    <div class="processing-details" id="paymentDetails">
                        Please wait while we process your payment
                    </div>
                </div>

                <!-- Payment Success Screen -->
                <div class="payment-success" id="paymentSuccess">
                    <div class="success-icon">✅</div>
                    <div class="success-text">Payment Successful!</div>
                    <div class="success-details" id="successDetails">
                        Thank you for your purchase
                    </div>
                </div>
            </div>

            <!-- Promotional Section -->
            <div class="promotional-section">
                <div class="promo-content">
                    <h2>POS System</h2>
                    <p>Advanced point of sale solution for small and medium businesses to manage inventory, sales, expenses, customers and operations.</p>
                    <p id="promoMessage">Thank you for choosing our store!</p>
                </div>
                <div class="promo-footer">
                    <small>Powered by POS System</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Mode Indicator -->
    <div class="test-mode" id="testMode" style="display: none;">
        <i class="bi bi-gear"></i> TEST MODE
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentCart = [];
        let isConnected = false;
        let promoMessages = [
            "Thank you for choosing our store!",
            "Fresh products daily!",
            "Ask about our loyalty program!",
            "Follow us on social media!",
            "We appreciate your business!"
        ];
        let currentPromoIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            updateDateTime();
            setInterval(updateDateTime, 1000);
            startPromoRotation();
            checkConnection();
            setInterval(checkConnection, 5000);
            window.addEventListener('storage', handleStorageChange);
            window.addEventListener('message', handleMessage);
            setInterval(sendHeartbeat, 2000);
            loadInitialData();
        });

        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDateTime')?.textContent = 
                now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
        }

        function startPromoRotation() {
            setInterval(() => {
                if (currentCart.length === 0) {
                    currentPromoIndex = (currentPromoIndex + 1) % promoMessages.length;
                    document.getElementById('promoMessage').textContent = promoMessages[currentPromoIndex];
                }
            }, 3000);
        }

        function sendHeartbeat() {
            localStorage.setItem('customerDisplayHeartbeat', Date.now().toString());
        }

        function checkConnection() {
            const lastUpdate = localStorage.getItem('posCustomerData');
            if (lastUpdate) {
                try {
                    const data = JSON.parse(lastUpdate);
                    const timeDiff = Date.now() - data.timestamp;
                    setConnectionStatus(timeDiff < 10000);
                } catch (e) {
                    console.error('Error parsing connection data:', e);
                    setConnectionStatus(false);
                }
            } else {
                setConnectionStatus(false);
            }
        }

        function setConnectionStatus(connected) {
            isConnected = connected;
            const dot = document.getElementById('connectionDot');
            const text = document.getElementById('connectionText');
            if (connected) {
                dot.classList.remove('disconnected');
                text.textContent = 'Connected';
            } else {
                dot.classList.add('disconnected');
                text.textContent = 'Disconnected';
            }
        }

        function loadInitialData() {
            const savedData = localStorage.getItem('posCustomerData');
            console.log('Initial data load attempt:', savedData);
            if (savedData) {
                try {
                    const data = JSON.parse(savedData);
                    handleDataUpdate(data);
                } catch (e) {
                    console.error('Failed to parse initial data:', e);
                }
            }
        }

        function handleStorageChange(e) {
            if (e.key === 'posCustomerData' && e.newValue) {
                console.log('Storage change detected:', e.newValue);
                try {
                    const data = JSON.parse(e.newValue);
                    handleDataUpdate(data);
                } catch (e) {
                    console.error('Failed to parse storage data:', e);
                }
            }
        }

        function handleMessage(e) {
            if (e.data && e.data.cart !== undefined && e.origin === 'http://127.0.0.1:8000') {
                console.log('Message received:', e.data);
                try {
                    handleDataUpdate(e.data);
                } catch (e) {
                    console.error('Failed to handle message data:', e);
                }
            } else {
                console.warn('Message ignored, invalid origin or data:', e.origin, e.data);
            }
        }

        function handleDataUpdate(data) {
            currentCart = data.cart || [];
            switch (data.action) {
                case 'test':
                    showTestMode();
                    setTimeout(() => updateDisplay(data.cart), 2000);
                    break;
                case 'reset':
                    resetDisplay();
                    break;
                case 'payment_processing':
                    showPaymentProcessing(data.paymentMethod, parseFloat(data.total));
                    break;
                case 'payment_success':
                    showPaymentSuccess(data.transaction);
                    break;
                default:
                    updateDisplay(data.cart);
                    break;
            }
        }

        function showTestMode() {
            const testMode = document.getElementById('testMode');
            testMode.style.display = 'block';
            setTimeout(() => testMode.style.display = 'none', 2000);
        }

        function resetDisplay() {
            currentCart = [];
            showWelcomeScreen();
        }

        function updateDisplay(cart) {
            currentCart = cart || [];
            if (cart && cart.length === 0) {
                showWelcomeScreen();
            } else if (cart) {
                showOrderContent(cart);
            }
        }

        function showOrderContent(cart) {
            document.getElementById('welcomeScreen').style.display = 'none';
            document.getElementById('orderTable').style.display = 'flex';
            document.getElementById('paymentProcessing').classList.remove('active');
            document.getElementById('paymentSuccess').classList.remove('active');
            renderItemsTable(cart);
            updateSummary(cart);
        }

        function showWelcomeScreen() {
            document.getElementById('welcomeScreen').style.display = 'flex';
            document.getElementById('orderTable').style.display = 'none';
            document.getElementById('paymentProcessing').classList.remove('active');
            document.getElementById('paymentSuccess').classList.remove('active');
        }

        function renderItemsTable(cart) {
            const tbody = document.getElementById('itemsTableBody');
            if (cart) {
                tbody.innerHTML = cart.map(item => `
                    <tr>
                        <td>${item.name || 'N/A'}</td>
                        <td>$${item.price?.toFixed(2) || '0.00'}</td>
                        <td>${item.quantity || 0}</td>
                        <td>$${(item.price * item.quantity || 0).toFixed(2)}</td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="4">No items</td></tr>';
            }
        }

        function updateSummary(cart) {
            if (cart) {
                const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity || 0), 0);
                const tax = subtotal * 0.08;
                const total = subtotal + tax;
                const itemCount = cart.reduce((count, item) => count + (item.quantity || 0), 0);

                document.getElementById('itemsTotal').textContent = itemCount;
                document.getElementById('summarySubtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('summaryTax').textContent = `$${tax.toFixed(2)}`;
                document.getElementById('summaryDiscount').textContent = `$0.00`;
                document.getElementById('totalPayable').textContent = `$${total.toFixed(2)}`;
            } else {
                document.getElementById('itemsTotal').textContent = '0';
                document.getElementById('summarySubtotal').textContent = '$0.00';
                document.getElementById('summaryTax').textContent = '$0.00';
                document.getElementById('summaryDiscount').textContent = '$0.00';
                document.getElementById('totalPayable').textContent = '$0.00';
            }
        }

        function showPaymentProcessing(method, total) {
            document.getElementById('welcomeScreen').style.display = 'none';
            document.getElementById('orderTable').style.display = 'none';
            document.getElementById('paymentProcessing').classList.add('active');
            document.getElementById('paymentSuccess').classList.remove('active');
            document.getElementById('paymentDetails').innerHTML = `
                Processing ${method?.toUpperCase() || 'N/A'} payment<br>
                Amount: $${total?.toFixed(2) || '0.00'}
            `;
        }

        function showPaymentSuccess(transaction) {
            document.getElementById('welcomeScreen').style.display = 'none';
            document.getElementById('orderTable').style.display = 'none';
            document.getElementById('paymentProcessing').classList.remove('active');
            document.getElementById('paymentSuccess').classList.add('active');
            document.getElementById('successDetails').innerHTML = `
                Order #${transaction.id || 'N/A'}<br>
                Total: $${transaction.total?.toFixed(2) || '0.00'}<br>
                Payment: ${transaction.paymentMethod?.toUpperCase() || 'N/A'}
            `;
            setTimeout(() => showWelcomeScreen(), 5000);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F5') {
                e.preventDefault();
                location.reload();
            }
        });
    </script>
</body>
</html>