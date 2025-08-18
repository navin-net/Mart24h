@extends('admin.master')

@section('content')
<style>
/* ===========================================
   PRODUCT IMAGE GALLERY STYLES
   =========================================== */

/* Main product image container */
.main-image-container {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.main-image-container:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.main-image {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.main-image:hover {
    transform: scale(1.02);
}

/* ===========================================
   THUMBNAIL GALLERY STYLES
   =========================================== */

.thumbnail-row {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.thumbnail-container {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px;
    height: 100px;
    width: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.thumbnail-container:hover {
    border-color: #4a90e2;
    box-shadow: 0 2px 6px rgba(74, 144, 226, 0.3);
    transform: translateY(-2px);
}

.thumbnail-container.active {
    border-color: #4a90e2;
    background-color: #f8f9fa;
}

.thumbnail {
    max-height: 90%;
    max-width: 90%;
    object-fit: cover;
    border-radius: 3px;
}

/* Error/placeholder background */
.red-bg {
    background-color: #ff3b30;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* ===========================================
   PRODUCT INFORMATION STYLES
   =========================================== */

/* Fixed the missing class name */
.product-label,
.info-label {
    color: #555;
    font-weight: 500;
    padding-top: 8px;
    margin-bottom: 4px;
    font-size: 14px;
}

.value-box {
    background-color: #f5f5f5;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    color: #333;
    word-break: break-all;
}

.value-box:hover {
    background-color: #eeeeee;
}

/* ===========================================
   BARCODE & QR CODE STYLES
   =========================================== */

.barcode,
.qrcode {
    height: 60px;
    width: auto;
    margin: 8px 0;
    padding: 4px;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.barcode-container,
.qrcode-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 6px;
    margin: 10px 0;
}

/* ===========================================
   WAREHOUSE SECTION STYLES
   =========================================== */

.warehouse-title {
    font-weight: 600;
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
    border-bottom: 2px solid #4a90e2;
    padding-bottom: 8px;
}

.warehouse-header {
    background: linear-gradient(135deg, #4a90e2, #357abd);
    color: white;
    padding: 12px 15px;
    border-radius: 6px 6px 0 0;
    font-weight: 500;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* ===========================================
   ACTION BUTTONS STYLES
   =========================================== */

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 15px;
}

.action-buttons .btn {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 80px;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.action-buttons .btn:active {
    transform: translateY(0);
}

/* Button color variants */
.btn-primary {
    background: linear-gradient(135deg, #4a90e2, #357abd);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #357abd, #2a5d8f);
}

.btn-info {
    background: linear-gradient(135deg, #5bc0de, #31b0d5);
    color: white;
}

.btn-info:hover {
    background: linear-gradient(135deg, #31b0d5, #2390b0);
}

.btn-warning {
    background: linear-gradient(135deg, #f0ad4e, #ec971f);
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ec971f, #d58512);
}

.btn-danger {
    background: linear-gradient(135deg, #d9534f, #c9302c);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c9302c, #a02622);
}

/* ===========================================
   RESPONSIVE DESIGN
   =========================================== */

/* Tablet styles */
@media (max-width: 992px) {
    .main-image-container {
        height: 250px;
        padding: 12px;
    }
    
    .thumbnail-container {
        width: 80px;
        height: 80px;
    }
    
    .warehouse-title {
        font-size: 16px;
    }
}

/* Mobile styles */
@media (max-width: 768px) {
    .main-image-container {
        height: 200px;
        padding: 10px;
    }
    
    .thumbnail-row {
        justify-content: center;
    }
    
    .thumbnail-container {
        width: 70px;
        height: 70px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 8px;
    }
    
    .action-buttons .btn {
        width: 100%;
        margin: 0;
    }
    
    .warehouse-title {
        font-size: 14px;
        text-align: center;
    }
    
    .value-box {
        font-size: 12px;
        padding: 8px 10px;
    }
}

/* Small mobile styles */
@media (max-width: 480px) {
    .main-image-container {
        height: 180px;
        margin: 0 5px;
    }
    
    .thumbnail-container {
        width: 60px;
        height: 60px;
    }
    
    .barcode,
    .qrcode {
        height: 50px;
    }
}

/* ===========================================
   ACCESSIBILITY & FOCUS STATES
   =========================================== */

.thumbnail-container:focus,
.btn:focus {
    outline: 2px solid #4a90e2;
    outline-offset: 2px;
}

.main-image:focus {
    outline: 2px solid #4a90e2;
    outline-offset: 4px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .thumbnail-container {
        border-width: 2px;
    }
    
    .main-image-container {
        border-width: 2px;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .thumbnail-container,
    .main-image,
    .btn {
        transition: none;
    }
}
</style>

<div class="container my-5">
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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="main-image-container mb-3">
                        <img src="{{ asset($product->image) }}" alt="No Image Available" class="img-fluid main-image">
                    </div>
                    <div class="row thumbnail-row">
                        @foreach ($images as $image)
                        <div class="col-6">
                            <div class="thumbnail-container">
                                <img src="{{ asset($image) }}" alt="No Image Available" class="img-fluid thumbnail">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-details">
                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end ">Barcode & QRcode</div>
                            <div class="col-md-8">
                                <div class="d-flex">
                                    <img src="barcode.png" alt="Barcode" class="barcode me-2">
                                    <img src="qrcode.png" alt="QR Code" class="qrcode">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Type</div>
                            <div class="col-md-8">
                                <div >Standard</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Name</div>
                            <div class="col-md-8">
                                <div >213</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Code</div>
                            <div class="col-md-8">
                                <div >78407874</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Brand</div>
                            <div class="col-md-8">
                                <div >123</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Category</div>
                            <div class="col-md-8">
                                <div >Category 1</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Unit</div>
                            <div class="col-md-8">
                                <div >321 (321)</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Cost</div>
                            <div class="col-md-8">
                                <div >231.00</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Price</div>
                            <div class="col-md-8">
                                <div >231,213.00</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Tax Rate</div>
                            <div class="col-md-8">
                                <div >No Tax</div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 text-md-end ">Tax Method</div>
                            <div class="col-md-8">
                                <div >Exclusive</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="d-flex action-buttons">
                <button class="btn btn-primary flex-grow-1">
                    <i class="bi bi-printer"></i> Print Barcode/
                </button>
                <button class="btn btn-info flex-grow-1">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </button>
                <button class="btn btn-warning flex-grow-1">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
                <button class="btn btn-danger flex-grow-1">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
      // Generate placeholder images for demo
document.addEventListener('DOMContentLoaded', function() {
    // Create no-image placeholder
    createNoImagePlaceholder();
    
    // Create barcode and QR code
    createBarcode();
    createQRCode();
    
    // Create logo
    createLogo();
});

function createNoImagePlaceholder() {
    const canvas = document.createElement('canvas');
    canvas.width = 300;
    canvas.height = 300;
    const ctx = canvas.getContext('2d');
    
    // Draw circle
    ctx.beginPath();
    ctx.arc(150, 150, 120, 0, Math.PI * 2);
    ctx.strokeStyle = '#aaa';
    ctx.lineWidth = 10;
    ctx.stroke();
    
    // Draw camera icon
    ctx.beginPath();
    ctx.rect(100, 120, 100, 70);
    ctx.fillStyle = '#555';
    ctx.fill();
    
    // Draw lens
    ctx.beginPath();
    ctx.arc(150, 155, 25, 0, Math.PI * 2);
    ctx.fillStyle = '#777';
    ctx.fill();
    ctx.beginPath();
    ctx.arc(150, 155, 15, 0, Math.PI * 2);
    ctx.fillStyle = '#555';
    ctx.fill();
    
    // Draw flash
    ctx.beginPath();
    ctx.arc(180, 130, 5, 0, Math.PI * 2);
    ctx.fillStyle = '#fff';
    ctx.fill();
    
    // Draw diagonal line
    ctx.beginPath();
    ctx.moveTo(80, 80);
    ctx.lineTo(220, 220);
    ctx.strokeStyle = '#aaa';
    ctx.lineWidth = 10;
    ctx.stroke();
    
    const dataUrl = canvas.toDataURL();
    document.querySelectorAll('img[src="no-image.png"]').forEach(img => {
        img.src = dataUrl;
    });
}

function createBarcode() {
    const canvas = document.createElement('canvas');
    canvas.width = 200;
    canvas.height = 80;
    const ctx = canvas.getContext('2d');
    
    ctx.fillStyle = '#fff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw barcode lines
    ctx.fillStyle = '#000';
    for (let i = 0; i < 30; i++) {
        const x = 10 + i * 6;
        const height = 20 + Math.random() * 40;
        const width = 2 + Math.random() * 2;
        ctx.fillRect(x, 10, width, height);
    }
    
    const dataUrl = canvas.toDataURL();
    document.querySelectorAll('img[src="barcode.png"]').forEach(img => {
        img.src = dataUrl;
    });
}

function createQRCode() {
    const canvas = document.createElement('canvas');
    canvas.width = 80;
    canvas.height = 80;
    const ctx = canvas.getContext('2d');
    
    ctx.fillStyle = '#fff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw QR code pattern
    ctx.fillStyle = '#000';
    const blockSize = 8;
    
    // Corner squares
    ctx.fillRect(10, 10, 20, 20);
    ctx.fillRect(50, 10, 20, 20);
    ctx.fillRect(10, 50, 20, 20);
    
    // Inner white squares for corners
    ctx.fillStyle = '#fff';
    ctx.fillRect(15, 15, 10, 10);
    ctx.fillRect(55, 15, 10, 10);
    ctx.fillRect(15, 55, 10, 10);
    
    // Random QR code pattern
    ctx.fillStyle = '#000';
    for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 6; j++) {
            if (Math.random() > 0.5) {
                ctx.fillRect(10 + i * blockSize, 10 + j * blockSize, blockSize, blockSize);
            }
        }
    }
    
    const dataUrl = canvas.toDataURL();
    document.querySelectorAll('img[src="qrcode.png"]').forEach(img => {
        img.src = dataUrl;
    });
}

function createLogo() {
    const canvas = document.createElement('canvas');
    canvas.width = 100;
    canvas.height = 100;
    const ctx = canvas.getContext('2d');
    
    // Draw logo on red background
    ctx.fillStyle = '#ff3b30';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw geometric shape (similar to Laravel logo)
    ctx.strokeStyle = '#fff';
    ctx.lineWidth = 3;
    
    // Draw cube-like shape
    ctx.beginPath();
    ctx.moveTo(30, 60);
    ctx.lineTo(50, 70);
    ctx.lineTo(70, 60);
    ctx.lineTo(50, 50);
    ctx.closePath();
    ctx.stroke();
    
    // Draw left extension
    ctx.beginPath();
    ctx.moveTo(30, 60);
    ctx.lineTo(30, 40);
    ctx.lineTo(50, 30);
    ctx.lineTo(50, 50);
    ctx.stroke();
    
    // Draw right extension
    ctx.beginPath();
    ctx.moveTo(50, 50);
    ctx.lineTo(70, 40);
    ctx.lineTo(70, 60);
    ctx.stroke();
    
    const dataUrl = canvas.toDataURL();
    document.querySelectorAll('img[src="logo.png"]').forEach(img => {
        img.src = dataUrl;
    });
}
</script>
@endpush