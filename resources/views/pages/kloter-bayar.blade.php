<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kloter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            min-height: 100vh;
            color: #1e293b;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 12px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #f8fafc;
            border-color: #10b981;
            color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            text-align: center;
        }

        .payment-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .kloter-name {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 20px;
        }

        .payment-amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: #10b981;
            margin-bottom: 8px;
        }

        .payment-breakdown {
            display: flex;
            justify-content: center;
            gap: 24px;
            font-size: 0.95rem;
            color: #64748b;
        }

        .payment-form {
            background: white;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #10b981;
        }

        .bank-info {
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .bank-details {
            display: grid;
            gap: 16px;
        }

        .bank-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .bank-item:last-child {
            border-bottom: none;
        }

        .bank-label {
            font-weight: 500;
            color: #065f46;
        }

        .bank-value {
            font-weight: 700;
            color: #047857;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .copy-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: 12px;
        }

        .copy-btn:hover {
            background: #059669;
            transform: scale(1.05);
        }

        .copy-btn.copied {
            background: #059669;
            transform: scale(0.95);
        }

        .important-note {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .important-note .note-title {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .important-note .note-text {
            color: #92400e;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            background: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .upload-area:hover {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .upload-area.dragover {
            border-color: #10b981;
            background: #ecfdf5;
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 16px;
        }

        .upload-area:hover .upload-icon,
        .upload-area.dragover .upload-icon {
            color: #10b981;
        }

        .upload-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .upload-subtext {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .uploaded-file {
            display: none;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
        }

        .uploaded-file.show {
            display: block;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-icon {
            font-size: 1.5rem;
            color: #10b981;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #065f46;
            margin-bottom: 4px;
        }

        .file-size {
            font-size: 0.85rem;
            color: #047857;
        }

        .remove-file {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .remove-file:hover {
            background: #dc2626;
        }

        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 12px;
            display: block;
        }

        .form-notes {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
        }

        .notes-title {
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notes-list {
            list-style: none;
            padding: 0;
        }

        .notes-list li {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 6px;
            padding-left: 20px;
            position: relative;
        }

        .notes-list li:before {
            content: '•';
            color: #10b981;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .submit-section {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-group {
            display: flex;
            gap: 16px;
        }

        .btn {
            flex: 1;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-cancel {
            background: #f8fafc;
            color: #475569;
            border: 2px solid #e2e8f0;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: 2px solid transparent;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #10b981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .loading-subtext {
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* Success Popup */
        .success-popup {
            background: white;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }

        .popup-header {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 40px 30px;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: successPulse 2s ease-in-out infinite;
        }

        .success-icon i {
            font-size: 2.5rem;
        }

        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .popup-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .popup-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .popup-content {
            padding: 30px;
            text-align: center;
        }

        .popup-content p {
            color: #374151;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .upload-status {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .upload-status.success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .upload-status.error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .payment-header,
            .payment-form {
                padding: 20px;
            }

            .payment-title {
                font-size: 1.5rem;
            }

            .payment-amount {
                font-size: 2rem;
            }

            .payment-breakdown {
                flex-direction: column;
                gap: 8px;
            }

            .btn-group {
                flex-direction: column;
            }

            .bank-details {
                font-size: 0.9rem;
            }

            .bank-value {
                font-size: 0.85rem;
            }

            .bank-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="#" class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="payment-header">
            <h1 class="payment-title">Pembayaran Kloter</h1>
            <p class="kloter-name">Arisan Berkah Bulanan - Slot 10</p>
            
            <div class="payment-amount">Rp 56.667</div>
            <div class="payment-breakdown">
                <span>Kontribusi: Rp 46.667</span>
                <span>Admin Fee: Rp 10.000</span>
            </div>
        </div>

        <form class="payment-form" id="paymentForm">
            <!-- Bank Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-university"></i>
                    Informasi Transfer
                </h2>
                
                <div class="bank-info">
                    <div class="bank-details">
                        <div class="bank-item">
                            <span class="bank-label">Bank:</span>
                            <div class="bank-value">
                                BCA (Bank Central Asia)
                                <button type="button" class="copy-btn" onclick="copyToClipboard('BCA', this)">Salin</button>
                            </div>
                        </div>
                        <div class="bank-item">
                            <span class="bank-label">No. Rekening:</span>
                            <div class="bank-value">
                                1234567890
                                <button type="button" class="copy-btn" onclick="copyToClipboard('1234567890', this)">Salin</button>
                            </div>
                        </div>
                        <div class="bank-item">
                            <span class="bank-label">Atas Nama:</span>
                            <div class="bank-value">
                                Admin Kloter Berkah
                                <button type="button" class="copy-btn" onclick="copyToClipboard('Admin Kloter Berkah', this)">Salin</button>
                            </div>
                        </div>
                        <div class="bank-item">
                            <span class="bank-label">Nominal Transfer:</span>
                            <div class="bank-value">
                                Rp 56.667
                                <button type="button" class="copy-btn" onclick="copyToClipboard('56667', this)">Salin</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="important-note">
                    <div class="note-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Penting!
                    </div>
                    <div class="note-text">
                        Pastikan nominal transfer sesuai dengan jumlah yang tertera. Transfer dengan nominal yang berbeda akan memperlambat proses verifikasi.
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Transfer Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-receipt"></i>
                    Upload Bukti Transfer
                </h2>

                <div class="form-group">
                    <label class="form-label" for="senderName">Nama Pengirim *</label>
                    <input type="text" id="senderName" class="form-input" placeholder="Masukkan nama sesuai rekening pengirim" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="transferDate">Tanggal Transfer *</label>
                    <input type="datetime-local" id="transferDate" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Screenshot Bukti Transfer *</label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Klik untuk upload bukti transfer</div>
                        <div class="upload-subtext">Atau drag & drop file disini</div>
                        <input type="file" id="fileInput" class="file-input" accept="image/jpeg,image/jpg,image/png" multiple="false">
                    </div>
                    
                    <div class="upload-status" id="uploadStatus" style="display: none;"></div>
                    
                    <div class="uploaded-file" id="uploadedFile">
                        <div class="file-info">
                            <div class="file-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="file-details">
                                <div class="file-name" id="fileName"></div>
                                <div class="file-size" id="fileSize"></div>
                            </div>
                            <button type="button" class="remove-file" onclick="removeFile()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <img class="preview-image" id="previewImage" alt="Preview" style="display: none;">
                    </div>
                </div>

                <div class="form-notes">
                    <div class="notes-title">
                        <i class="fas fa-info-circle"></i>
                        Catatan Upload:
                    </div>
                    <ul class="notes-list">
                        <li>Format file yang diterima: JPG, PNG, JPEG</li>
                        <li>Ukuran maksimal file: 5MB</li>
                        <li>Pastikan bukti transfer terlihat jelas dan tidak blur</li>
                        <li>Screenshot harus menampilkan nominal, tanggal, dan tujuan transfer</li>
                    </ul>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <div class="btn-group">
                    <button type="button" class="btn btn-cancel" onclick="window.history.back()">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="button" class="btn btn-submit" id="submitBtn" onclick="submitPayment()" disabled>
                        <i class="fas fa-paper-plane"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content" id="loadingContent">
            <div class="loading-spinner"></div>
            <div class="loading-text">Mengirim bukti pembayaran...</div>
            <div class="loading-subtext">Mohon tunggu sebentar</div>
        </div>
    </div>

    <script>
        // State management
        let uploadedFile = null;
        let fileData = null;

        // Copy to clipboard function
        function copyToClipboard(text, button) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopyFeedback(button);
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                    fallbackCopyToClipboard(text, button);
                });
            } else {
                fallbackCopyToClipboard(text, button);
            }
        }

        // Fallback copy method
        function fallbackCopyToClipboard(text, button) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                showCopyFeedback(button);
            } catch (err) {
                console.error('Fallback copy failed: ', err);
                alert('Gagal menyalin ke clipboard');
            }
            
            document.body.removeChild(textArea);
        }

        // Show copy feedback
        function showCopyFeedback(button) {
            const originalText = button.textContent;
            button.textContent = 'Tersalin!';
            button.classList.add('copied');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('copied');
            }, 2000);
        }

        // Show upload status
        function showUploadStatus(message, type) {
            const statusElement = document.getElementById('uploadStatus');
            statusElement.textContent = message;
            statusElement.className = `upload-status ${type}`;
            statusElement.style.display = 'block';
            
            setTimeout(() => {
                statusElement.style.display = 'none';
            }, 3000);
        }

        // Handle file upload
        function handleFileUpload(files) {
            if (!files || files.length === 0) return;
            
            const file = files[0];
            
            // Reset previous state
            removeFile();
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const fileType = file.type.toLowerCase();
            
            if (!validTypes.includes(fileType)) {
                showUploadStatus('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.', 'error');
                return;
            }

            // Validate file size (5MB)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                showUploadStatus('Ukuran file terlalu besar. Maksimal 5MB.', 'error');
                return;
            }

            // Store file references
            uploadedFile = file;
            
            // Display file info
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = formatFileSize(file.size);
            document.getElementById('uploadedFile').classList.add('show');

            // Create and display preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                fileData = e.target.result; // Store base64 data
            };
            
            reader.onerror = function() {
                showUploadStatus('Gagal membaca file. Coba file lain.', 'error');
                removeFile();
            };
            
            reader.readAsDataURL(file);
            
            showUploadStatus('File berhasil diupload!', 'success');
            checkFormValidity();
        }

        // Remove uploaded file
        function removeFile() {
            uploadedFile = null;
            fileData = null;
            
            const uploadedFileElement = document.getElementById('uploadedFile');
            const previewImage = document.getElementById('previewImage');
            const fileInput = document.getElementById('fileInput');
            
            uploadedFileElement.classList.remove('show');
            previewImage.style.display = 'none';
            previewImage.src = '';
            fileInput.value = '';
            
            checkFormValidity();
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Check form validity
        function checkFormValidity() {
            const senderName = document.getElementById('senderName').value.trim();
            const transferDate = document.getElementById('transferDate').value;
            const hasFile = uploadedFile !== null;
            
            const submitBtn = document.getElementById('submitBtn');
            const isValid = senderName && transferDate && hasFile;
            
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }

        // Get form data for submission
        function getFormData() {
            return {
                senderName: document.getElementById('senderName').value.trim(),
                transferDate: document.getElementById('transferDate').value,
                fileName: uploadedFile ? uploadedFile.name : null,
                fileSize: uploadedFile ? uploadedFile.size : null,
                fileType: uploadedFile ? uploadedFile.type : null,
                fileData: fileData,
                kloterName: 'Arisan Berkah Bulanan - Slot 10',
                amount: 'Rp 56.667',
                contribution: 'Rp 46.667',
                adminFee: 'Rp 10.000'
            };
        }

        // Submit payment
        function submitPayment() {
            if (!uploadedFile) {
                alert('Mohon upload bukti transfer terlebih dahulu.');
                return;
            }
            
            const senderName = document.getElementById('senderName').value.trim();
            const transferDate = document.getElementById('transferDate').value;
            
            if (!senderName || !transferDate) {
                alert('Mohon lengkapi semua data yang diperlukan.');
                return;
            }

            // Get all form data
            const formData = getFormData();
            
            // Store data in session for demo purposes
            try {
                const paymentData = JSON.stringify({
                    ...formData,
                    submittedAt: new Date().toISOString(),
                    status: 'pending_verification'
                });
                console.log('Payment Data:', paymentData);
                
                // Show loading
                const loadingOverlay = document.getElementById('loadingOverlay');
                const loadingContent = document.getElementById('loadingContent');
                
                loadingOverlay.classList.add('show');

                // Simulate processing time
                setTimeout(() => {
                    loadingContent.innerHTML = `
                        <div class="loading-spinner"></div>
                        <div class="loading-text">Menunggu admin memverifikasi...</div>
                        <div class="loading-subtext">Proses verifikasi sedang berlangsung</div>
                    `;
                }, 2000);

                setTimeout(() => {
                    showSuccessPopup();
                }, 5000);
                
            } catch (error) {
                console.error('Error submitting payment:', error);
                alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
            }
        }

        // Show success popup
        function showSuccessPopup() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.innerHTML = `
                <div class="success-popup">
                    <div class="popup-header">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Pembayaran Berhasil!</h2>
                        <p>Bukti transfer telah dikirim dan menunggu verifikasi</p>
                    </div>
                    
                    <div class="popup-content">
                        <p>
                            Terima kasih! Bukti pembayaran Anda untuk <strong>Arisan Berkah Bulanan</strong> 
                            sebesar <strong>Rp 56.667</strong> telah berhasil dikirim.
                        </p>
                        <p>
                            Admin akan memverifikasi pembayaran Anda dalam waktu 1x24 jam. 
                            Status pembayaran akan diperbarui di dashboard kloter.
                        </p>
                        <button class="btn-primary" onclick="closePopupAndRedirect()">
                            <i class="fas fa-home" href="{{ route('kloter.user') }}"></i>
                            Kembali
                        </button>
                    </div>
                </div>
            `;
        }

        // Close popup and redirect
        function closePopupAndRedirect() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.classList.remove('show');
            
            setTimeout(() => {
                console.log('Redirecting to my kloter page...');
                alert('Pembayaran berhasil dikirim! Status akan diperbarui setelah admin memverifikasi.');
                // window.location.href = '/kloter/my-kloter';
            }, 300);
        }

        // Event listeners setup
        function setupEventListeners() {
            // Form input validation
            const senderNameInput = document.getElementById('senderName');
            const transferDateInput = document.getElementById('transferDate');
            
            senderNameInput.addEventListener('input', checkFormValidity);
            senderNameInput.addEventListener('blur', checkFormValidity);
            transferDateInput.addEventListener('change', checkFormValidity);

            // File input handling
            const fileInput = document.getElementById('fileInput');
            const uploadArea = document.getElementById('uploadArea');

            // File input change event
            fileInput.addEventListener('change', function(e) {
                handleFileUpload(e.target.files);
            });

            // Click to upload
            uploadArea.addEventListener('click', function(e) {
                if (e.target !== fileInput) {
                    fileInput.click();
                }
            });

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFileUpload(files);
                }
            });

            // Prevent default drag behaviors on document
            document.addEventListener('dragover', function(e) {
                e.preventDefault();
            });
            
            document.addEventListener('drop', function(e) {
                e.preventDefault();
            });
        }

        // Set current date and time as default
        function setDefaultDateTime() {
            const now = new Date();
            const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                .toISOString()
                .slice(0, 16);
            document.getElementById('transferDate').value = localDateTime;
        }

        // Initialize application
        function initializeApp() {
            setupEventListeners();
            setDefaultDateTime();
            checkFormValidity();
            
            console.log('Payment form initialized successfully');
            console.log('Upload functionality ready');
        }

        // Run initialization when DOM is loaded
        document.addEventListener('DOMContentLoaded', initializeApp);

        // Additional debugging functions
        window.debugFileUpload = function() {
            console.log('Current uploaded file:', uploadedFile);
            console.log('File data available:', !!fileData);
            console.log('Form validity:', {
                senderName: !!document.getElementById('senderName').value.trim(),
                transferDate: !!document.getElementById('transferDate').value,
                hasFile: !!uploadedFile
            });
        };
    </script>
</body>
</html>