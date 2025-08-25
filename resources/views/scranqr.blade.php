<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABA Scan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        .status-bar {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1000;
        }

        .status-left {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-right {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .header {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 16px;
            text-align: center;
            position: relative;
            z-index: 1000;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .close-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .camera-container {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }

        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .scan-frame {
            width: 250px;
            height: 250px;
            position: relative;
        }

        .scan-corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid white;
        }

        .scan-corner.top-left {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-radius: 8px 0 0 0;
        }

        .scan-corner.top-right {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-radius: 0 8px 0 0;
        }

        .scan-corner.bottom-left {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 8px;
        }

        .scan-corner.bottom-right {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-radius: 0 0 8px 0;
        }

        .controls {
            background: rgba(0, 0, 0, 0.9);
            padding: 20px;
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .control-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 25px;
            padding: 12px 24px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background 0.3s;
            min-width: 140px;
            justify-content: center;
        }

        .control-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .control-btn.active {
            background: rgba(255, 255, 255, 0.4);
        }

        .payment-logos {
            background: rgba(0, 0, 0, 0.9);
            padding: 12px;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .payment-logo {
            width: 40px;
            height: 25px;
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #333;
        }

        .result-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .result-content {
            background: white;
            padding: 24px;
            border-radius: 12px;
            max-width: 90%;
            text-align: center;
        }

        .result-url {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin: 16px 0;
            word-break: break-all;
            font-family: monospace;
        }

        #file-input {
            display: none;
        }

        .app-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #camera-error {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Status Bar -->
        <div class="status-bar">
            <div class="status-left">
                <i class="fas fa-signal"></i>
                <span>Metfone</span>
                <i class="fas fa-wifi"></i>
            </div>
            <div>1:38 PM</div>
            <div class="status-right">
                <span style="color: #00ff00;">●</span>
                <i class="fas fa-battery-quarter"></i>
                <span>29%</span>
            </div>
        </div>

        <!-- Header -->
        <div class="header">
            <h1>ABA<sup style="color: #ff4444;">*</sup> Scan</h1>
            <button class="close-btn" onclick="closeApp()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Camera Container -->
        <div class="camera-container">
            <video id="video" autoplay muted playsinline></video>
            <canvas id="canvas" style="display: none;"></canvas>
            
            <div class="scan-overlay">
                <div class="scan-frame">
                    <div class="scan-corner top-left"></div>
                    <div class="scan-corner top-right"></div>
                    <div class="scan-corner bottom-left"></div>
                    <div class="scan-corner bottom-right"></div>
                </div>
            </div>
            <div id="camera-error"></div>
        </div>

        <!-- Controls -->
        <div class="controls">
            <button class="control-btn" id="flash-btn" onclick="toggleFlash()">
                <i class="fas fa-flashlight"></i>
                Flash
            </button>
            <button class="control-btn" onclick="uploadQR()">
                <i class="fas fa-qrcode"></i>
                Upload QR
            </button>
        </div>

        <!-- Payment Logos -->
        <div class="payment-logos">
            <div class="payment-logo" style="background: #00a86b;">E</div>
            <div class="payment-logo" style="background: #1e88e5;">CASH</div>
            <div class="payment-logo" style="background: #4caf50;">PAY</div>
            <div class="payment-logo" style="background: #ff5722;">KHOR</div>
            <div class="payment-logo" style="background: #ff9800;">W</div>
            <div class="payment-logo" style="background: #2196f3;">CB</div>
            <div class="payment-logo" style="background: #607d8b;">🔍</div>
            <div class="payment-logo" style="background: #f44336;">V</div>
            <div class="payment-logo" style="background: #1565c0;">VISA</div>
            <div class="payment-logo" style="background: linear-gradient(45deg, #ff5722, #ff9800);">MC</div>
        </div>
    </div>

    <!-- Result Modal -->
    <div class="result-modal" id="result-modal">
        <div class="result-content">
            <h4>QR Code Detected!</h4>
            <div class="result-url" id="result-url"></div>
            <div>
                <button class="btn btn-primary me-2" onclick="openUrl()">Open URL</button>
                <button class="btn btn-secondary" onclick="closeResult()">Close</button>
            </div>
        </div>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="file-input" accept="image/*" onchange="handleFileUpload(event)">

    <!-- QR Code Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let video;
        let canvas;
        let context;
        let scanning = false;
        let stream;
        let flashOn = false;
        let detectedUrl = '';

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            context = canvas.getContext('2d');
            
            checkCameraSupport();
        });

        function checkCameraSupport() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showCameraError('Camera not supported on this device or browser');
                return;
            }

            // Check if we're on HTTPS or localhost
            const isSecure = location.protocol === 'https:' || 
                           location.hostname === 'localhost' || 
                           location.hostname === '127.0.0.1' ||
                           location.hostname.startsWith('192.168.') ||
                           location.hostname.startsWith('10.') ||
                           location.hostname.startsWith('172.');

            if (!isSecure) {
                showCameraError('Camera access requires HTTPS. Please use HTTPS or localhost.');
                return;
            }

            startCamera();
        }

        async function startCamera() {
            try {
                // First, check permissions
                const permissionStatus = await navigator.permissions.query({ name: 'camera' });
                
                if (permissionStatus.state === 'denied') {
                    showCameraError('Camera permission denied. Please enable camera access in your browser settings.');
                    return;
                }

                const constraints = {
                    video: {
                        facingMode: 'environment', // Use back camera
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                };

                stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                
                video.addEventListener('loadedmetadata', () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    scanning = true;
                    scanQRCode();
                    hideCameraError();
                });

                video.addEventListener('error', (e) => {
                    console.error('Video error:', e);
                    showCameraError('Error loading camera stream');
                });

            } catch (error) {
                console.error('Error accessing camera:', error);
                let errorMessage = 'Unable to access camera. ';
                
                if (error.name === 'NotAllowedError') {
                    errorMessage += 'Please allow camera permissions and refresh the page.';
                } else if (error.name === 'NotFoundError') {
                    errorMessage += 'No camera found on this device.';
                } else if (error.name === 'NotSupportedError') {
                    errorMessage += 'Camera not supported on this device.';
                } else if (error.name === 'NotReadableError') {
                    errorMessage += 'Camera is being used by another application.';
                } else {
                    errorMessage += 'Please check camera permissions and try again.';
                }
                
                showCameraError(errorMessage);
            }
        }

        function showCameraError(message) {
            // Create error overlay if it doesn't exist
            let errorOverlay = document.getElementById('camera-error');
            if (!errorOverlay) {
                errorOverlay = document.createElement('div');
                errorOverlay.id = 'camera-error';
                errorOverlay.style.cssText = `
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.9);
                    color: white;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    padding: 20px;
                    z-index: 100;
                `;
                document.querySelector('.camera-container').appendChild(errorOverlay);
            }
            
            errorOverlay.innerHTML = `
                <i class="fas fa-camera-slash" style="font-size: 48px; margin-bottom: 16px; color: #ff4444;"></i>
                <h4 style="margin-bottom: 16px;">Camera Access Required</h4>
                <p style="margin-bottom: 20px; max-width: 300px;">${message}</p>
                <button class="btn btn-primary" onclick="retryCamera()" style="margin-right: 10px;">
                    <i class="fas fa-redo"></i> Try Again
                </button>
                <button class="btn btn-secondary" onclick="uploadQR()">
                    <i class="fas fa-upload"></i> Upload Image Instead
                </button>
            `;
            errorOverlay.style.display = 'flex';
        }

        function hideCameraError() {
            const errorOverlay = document.getElementById('camera-error');
            if (errorOverlay) {
                errorOverlay.style.display = 'none';
            }
        }

        function retryCamera() {
            hideCameraError();
            checkCameraSupport();
        }

        // Scan QR code continuously
        function scanQRCode() {
            if (!scanning) return;

            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    detectedUrl = code.data;
                    showResult(detectedUrl);
                    return;
                }
            }

            requestAnimationFrame(scanQRCode);
        }

        // Toggle flash
        async function toggleFlash() {
            if (!stream) {
                alert('Camera not available');
                return;
            }

            const track = stream.getVideoTracks()[0];
            const capabilities = track.getCapabilities();

            if (capabilities.torch) {
                try {
                    await track.applyConstraints({
                        advanced: [{ torch: !flashOn }]
                    });
                    flashOn = !flashOn;
                    
                    const flashBtn = document.getElementById('flash-btn');
                    if (flashOn) {
                        flashBtn.classList.add('active');
                    } else {
                        flashBtn.classList.remove('active');
                    }
                } catch (error) {
                    console.error('Error toggling flash:', error);
                    alert('Unable to control flash');
                }
            } else {
                alert('Flash not supported on this device');
            }
        }

        // Upload QR from file
        function uploadQR() {
            document.getElementById('file-input').click();
        }

        // Handle file upload
        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    // Create a temporary canvas to process the image
                    const tempCanvas = document.createElement('canvas');
                    const tempContext = tempCanvas.getContext('2d');
                    
                    tempCanvas.width = img.width;
                    tempCanvas.height = img.height;
                    tempContext.drawImage(img, 0, 0);
                    
                    const imageData = tempContext.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height);
                    
                    if (code) {
                        detectedUrl = code.data;
                        showResult(detectedUrl);
                    } else {
                        alert('No QR code found in the uploaded image');
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Show result modal
        function showResult(url) {
            document.getElementById('result-url').textContent = url;
            document.getElementById('result-modal').style.display = 'flex';
            scanning = false;
        }

        function openUrl() {
            if (detectedUrl) {
                // Check if it's a valid URL
                try {
                    let url = detectedUrl;
                    
                    // If it looks like a URL but doesn't have protocol, add https
                    if (detectedUrl.includes('.') && !detectedUrl.startsWith('http')) {
                        url = 'https://' + detectedUrl;
                    }
                    
                    // Try to create URL object to validate
                    new URL(url);
                    window.open(url, '_blank');
                } catch (error) {
                    // If not a valid URL, copy to clipboard and show the content
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(detectedUrl).then(() => {
                            alert('QR Code content copied to clipboard:\n\n' + detectedUrl);
                        }).catch(() => {
                            alert('QR Code content:\n\n' + detectedUrl);
                        });
                    } else {
                        alert('QR Code content:\n\n' + detectedUrl);
                    }
                }
            }
            closeResult();
        }

        // Close result modal
        function closeResult() {
            document.getElementById('result-modal').style.display = 'none';
            scanning = true;
            scanQRCode();
        }

        // Close app
        function closeApp() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            // In a real app, this would close the app
            alert('App would close here');
        }

        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                scanning = false;
            } else if (!document.getElementById('result-modal').style.display === 'flex') {
                scanning = true;
                scanQRCode();
            }
        });
    </script>
</body>
</html>
