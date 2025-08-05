@extends('shop.layouts.app')
@section('title','Checkout')
@section('content')

<style>
    .checkout-step {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .checkout-step.active {
        border-left: 4px solid #198754;
        background-color: #f8f9fa;
    }
    
    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
    }
    
    .step-number.completed {
        background-color: #198754;
        color: white;
    }
    
    .step-number.active {
        background-color: #0d6efd;
        color: white;
    }
    
    .step-number.pending {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    .order-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        position: sticky;
        top: 20px;
    }
    
    .payment-method {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-method:hover {
        border-color: #0d6efd;
    }
    
    .payment-method.selected {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        opacity: .65;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }
    
    .security-badge {
        background: linear-gradient(135deg, #198754, #20c997);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-align: center;
    }
</style>

<div class="container my-5">
    <!-- Checkout Header -->
    <!-- <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('shop.products') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.cart') }}">Cart</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </nav>
            <h2 class="mb-0"><i class="fas fa-credit-card"></i> Secure Checkout</h2>
        </div>
    </div> -->

    <!-- Checkout Steps -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="step-number completed">1</div>
                    <span class="text-success">Cart</span>
                </div>
                <div class="flex-grow-1 mx-3">
                    <hr class="border-success">
                </div>
                <div class="d-flex align-items-center">
                    <div class="step-number active">2</div>
                    <span class="fw-bold">Checkout</span>
                </div>
                <div class="flex-grow-1 mx-3">
                    <hr class="border-secondary">
                </div>
                <div class="d-flex align-items-center">
                    <div class="step-number pending">3</div>
                    <span class="text-muted">Confirmation</span>
                </div>
            </div>
        </div>
    </div>

    <form id="checkout-form" action="{{ route('shop.checkout') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <!-- Step 1: Contact Information -->
                <div class="checkout-step active p-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-user"></i> Contact Information
                    </h5>
                    
                    @guest
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Already have an account? <a href="{{ route('login') }}">Sign in</a> for faster checkout.
                    </div>
                    @endguest

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="Email" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                <label for="email">Email Address *</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" placeholder="Phone" 
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                <label for="phone">Phone Number *</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" value="1">
                        <label class="form-check-label" for="newsletter">
                            Subscribe to our newsletter for exclusive offers
                        </label>
                    </div>
                </div>

                <!-- Step 2: Shipping Address -->
                <div class="checkout-step p-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-shipping-fast"></i> Shipping Address
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" placeholder="First Name" 
                                       value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                                <label for="first_name">First Name *</label>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" placeholder="Last Name" 
                                       value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                                <label for="last_name">Last Name *</label>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" placeholder="Address" 
                                   value="{{ old('address') }}" required>
                            <label for="address">Street Address *</label>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address2" name="address2" 
                                   placeholder="Apartment, suite, etc." value="{{ old('address2') }}">
                            <label for="address2">Apartment, suite, etc. (optional)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" placeholder="City" 
                                       value="{{ old('city') }}" required>
                                <label for="city">City *</label>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <select class="form-select @error('state') is-invalid @enderror" 
                                        id="state" name="state" required>
                                    <option value="">Choose...</option>
                                    <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>Alabama</option>
                                    <option value="AK" {{ old('state') == 'AK' ? 'selected' : '' }}>Alaska</option>
                                    <option value="AZ" {{ old('state') == 'AZ' ? 'selected' : '' }}>Arizona</option>
                                    <option value="CA" {{ old('state') == 'CA' ? 'selected' : '' }}>California</option>
                                    <option value="FL" {{ old('state') == 'FL' ? 'selected' : '' }}>Florida</option>
                                    <option value="NY" {{ old('state') == 'NY' ? 'selected' : '' }}>New York</option>
                                    <option value="TX" {{ old('state') == 'TX' ? 'selected' : '' }}>Texas</option>
                                    <!-- Add more states as needed -->
                                </select>
                                <label for="state">State *</label>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                       id="zip" name="zip" placeholder="ZIP" 
                                       value="{{ old('zip') }}" required>
                                <label for="zip">ZIP Code *</label>
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="save_address" name="save_address" value="1">
                        <label class="form-check-label" for="save_address">
                            Save this address for future orders
                        </label>
                    </div>
                </div>

                <!-- Step 3: Billing Address -->
                <div class="checkout-step p-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-file-invoice"></i> Billing Address
                    </h5>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="same_as_shipping" 
                               name="same_as_shipping" value="1" checked onchange="toggleBillingAddress()">
                        <label class="form-check-label" for="same_as_shipping">
                            Same as shipping address
                        </label>
                    </div>

                    <div id="billing-address" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="billing_first_name" 
                                           name="billing_first_name" placeholder="First Name">
                                    <label for="billing_first_name">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="billing_last_name" 
                                           name="billing_last_name" placeholder="Last Name">
                                    <label for="billing_last_name">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <!-- Add more billing fields as needed -->
                    </div>
                </div>

                <!-- Step 4: Payment Method -->
                <div class="checkout-step p-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-credit-card"></i> Payment Method
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="payment-method selected" onclick="selectPaymentMethod('card')">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="card" id="payment_card" checked>
                                    <label for="payment_card" class="ms-2 mb-0">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Credit/Debit Card
                                    </label>
                                </div>
                                <small class="text-muted">Visa, Mastercard, American Express</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="payment-method" onclick="selectPaymentMethod('paypal')">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="paypal" id="payment_paypal">
                                    <label for="payment_paypal" class="ms-2 mb-0">
                                        <i class="fab fa-paypal me-2"></i>
                                        PayPal
                                    </label>
                                </div>
                                <small class="text-muted">Pay with your PayPal account</small>
                            </div>
                        </div>
                    </div>

                    <!-- Credit Card Form -->
                    <div id="card-details" class="mt-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_number" 
                                           name="card_number" placeholder="Card Number" 
                                           maxlength="19" onkeyup="formatCardNumber(this)">
                                    <label for="card_number">Card Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_name" 
                                           name="card_name" placeholder="Cardholder Name">
                                    <label for="card_name">Cardholder Name</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_expiry" 
                                           name="card_expiry" placeholder="MM/YY" 
                                           maxlength="5" onkeyup="formatExpiry(this)">
                                    <label for="card_expiry">MM/YY</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_cvv" 
                                           name="card_cvv" placeholder="CVV" maxlength="4">
                                    <label for="card_cvv">CVV</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PayPal Message -->
                    <div id="paypal-message" class="d-none">
                        <div class="alert alert-info">
                            <i class="fab fa-paypal"></i>
                            You will be redirected to PayPal to complete your payment.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary p-4">
                    <h5 class="mb-3">Order Summary</h5>
                    
                    <!-- Cart Items -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" 
                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <small class="fw-bold">Wireless Headphones</small>
                                    <br><small class="text-muted">Qty: 2</small>
                                </div>
                            </div>
                            <span class="fw-bold">${{ number_format(159.98, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" 
                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <small class="fw-bold">Smartphone Case</small>
                                    <br><small class="text-muted">Qty: 1</small>
                                </div>
                            </div>
                            <span class="fw-bold">${{ number_format(24.99, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Product" 
                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <small class="fw-bold">USB-C Cable</small>
                                    <br><small class="text-muted">Qty: 3</small>
                                </div>
                            </div>
                            <span class="fw-bold">${{ number_format(38.97, 2) }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Pricing Breakdown -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (6 items):</span>
                        <span>${{ number_format(223.94, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span class="text-success">Free</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>${{ number_format(17.92, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-success">Discount:</span>
                        <span class="text-success">-${{ number_format(20.00, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-success fs-5">${{ number_format(221.86, 2) }}</strong>
                    </div>
                    
                    <!-- Security Badge -->
                    <div class="security-badge mb-3">
                        <i class="fas fa-shield-alt"></i>
                        <small>256-bit SSL Encryption</small>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="submit" class="btn btn-success w-100 btn-lg mb-2" id="place-order-btn">
                        <i class="fas fa-lock"></i> Place Order
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">
                            By placing your order, you agree to our 
                            <a href="#">Terms of Service</a> and 
                            <a href="#">Privacy Policy</a>
                        </small>
                    </div>
                    
                    <!-- Return Policy -->
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-undo"></i> 30-day return policy<br>
                            <i class="fas fa-shipping-fast"></i> Free shipping on orders over $50
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Toggle billing address visibility
    function toggleBillingAddress() {
        const checkbox = document.getElementById('same_as_shipping');
        const billingAddress = document.getElementById('billing-address');
        
        if (checkbox.checked) {
            billingAddress.classList.add('d-none');
        } else {
            billingAddress.classList.remove('d-none');
        }
    }

    // Select payment method
    function selectPaymentMethod(method) {
        // Remove selected class from all payment methods
        document.querySelectorAll('.payment-method').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selected class to clicked method
        event.currentTarget.classList.add('selected');
        
        // Show/hide payment details
        const cardDetails = document.getElementById('card-details');
        const paypalMessage = document.getElementById('paypal-message');
        
        if (method === 'card') {
            cardDetails.classList.remove('d-none');
            paypalMessage.classList.add('d-none');
        } else {
            cardDetails.classList.add('d-none');
            paypalMessage.classList.remove('d-none');
        }
    }

    // Format card number
    function formatCardNumber(input) {
        let value = input.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        input.value = formattedValue;
    }

    // Format expiry date
    function formatExpiry(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        input.value = value;
    }

    // Form submission
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('place-order-btn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        submitBtn.disabled = true;
        
        // Simulate processing
        setTimeout(() => {
            // In real implementation, submit the form
            alert('Order placed successfully! Redirecting to confirmation page...');
            
            // Reset button for demo
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const inputs = form.querySelectorAll('input[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
    });
</script>

@endsection