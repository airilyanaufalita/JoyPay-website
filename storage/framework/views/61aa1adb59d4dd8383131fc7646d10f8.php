<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - JoyPay</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/login-register.css')); ?>">
</head>
<body>
    <div class="register-form">
        <div class="left-panel">
            <div class="brand-content">
                <h1>Arisan Barokah</h1>
                <p>Platform arisan digital terpercaya sejak 2020</p>
                
                <div class="features">
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/>
                            <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/>
                            <path d="M3 12h6m6 0h6"/>
                        </svg>
                        <span>Keamanan terjamin</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span>Komunitas terpercaya</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                        <span>Mudah digunakan</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 1v6m0 6v6"/>
                            <path d="M21 12h-6m-6 0H3"/>
                        </svg>
                        <span>Otomatis & praktis</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-panel">
            <h2>Daftar Sekarang</h2>

            <?php if(session('error')): ?>
                <div class="alert alert-error"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('register')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" placeholder="Nama Lengkap" value="<?php echo e(old('name')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group full-width">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group full-width">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address" placeholder="Alamat Lengkap" value="<?php echo e(old('address')); ?>">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label for="phone">Nomor HP</label>
                        <input type="tel" id="phone" name="phone" placeholder="Nomor HP" value="<?php echo e(old('phone')); ?>">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label for="emergency_phone">Nomor Darurat</label>
                        <input type="tel" id="emergency_phone" name="emergency_phone" placeholder="Nomor Darurat" value="<?php echo e(old('emergency_phone')); ?>">
                        <?php $__errorArgs = ['emergency_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label for="social_media">Media Sosial</label>
                        <input type="text" id="social_media" name="social_media" placeholder="Media Sosial" value="<?php echo e(old('social_media')); ?>">
                        <?php $__errorArgs = ['social_media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Bank Selection and Account Number -->
                    <div class="bank-account-group">
                        <div class="input-group">
                            <label for="bank">Bank</label>
                            <div class="custom-select">
                                <div class="bank-icon" id="bankIcon"></div>
                                <select id="bank" name="bank" required>
                                    <option value="">Pilih Bank</option>
                                    <option value="bca" <?php echo e(old('bank') == 'bca' ? 'selected' : ''); ?>>Bank BCA</option>
                                    <option value="mandiri" <?php echo e(old('bank') == 'mandiri' ? 'selected' : ''); ?>>Bank Mandiri</option>
                                    <option value="bni" <?php echo e(old('bank') == 'bni' ? 'selected' : ''); ?>>Bank BNI</option>
                                    <option value="bri" <?php echo e(old('bank') == 'bri' ? 'selected' : ''); ?>>Bank BRI</option>
                                    <option value="danamon" <?php echo e(old('bank') == 'danamon' ? 'selected' : ''); ?>>Bank Danamon</option>
                                    <option value="cimb" <?php echo e(old('bank') == 'cimb' ? 'selected' : ''); ?>>CIMB Niaga</option>
                                    <option value="bsi" <?php echo e(old('bank') == 'bsi' ? 'selected' : ''); ?>>Bank Syariah Indonesia</option>
                                    <option value="btn" <?php echo e(old('bank') == 'btn' ? 'selected' : ''); ?>>Bank BTN</option>
                                    <option value="permata" <?php echo e(old('bank') == 'permata' ? 'selected' : ''); ?>>Bank Permata</option>
                                    <option value="mega" <?php echo e(old('bank') == 'mega' ? 'selected' : ''); ?>>Bank Mega</option>
                                    <option value="bukopin" <?php echo e(old('bank') == 'bukopin' ? 'selected' : ''); ?>>Bank Bukopin</option>
                                    <option value="panin" <?php echo e(old('bank') == 'panin' ? 'selected' : ''); ?>>Panin Bank</option>
                                </select>
                                <?php $__errorArgs = ['bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="account_number">Nomor Rekening</label>
                            <input type="text" id="account_number" name="account_number" placeholder="Nomor Rekening" value="<?php echo e(old('account_number')); ?>" required>
                            <?php $__errorArgs = ['account_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirm Password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Daftar Sekarang</button>
            </form>
            
            <div class="privacy-notice">
                <a href="<?php echo e(route('login')); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7fb069" stroke-width="2">
                    </svg>
                    Sudah punya akun? Login sekarang
                </a>
            </div>
        </div>
    </div>

    <script>
        // JavaScript untuk mengubah ikon bank saat dipilih
        document.getElementById('bank').addEventListener('change', function() {
            const bankIcon = document.getElementById('bankIcon');
            const selectedBank = this.value;
            
            // Reset all classes
            bankIcon.className = 'bank-icon';
            
            // Add new class based on selection
            if (selectedBank) {
                bankIcon.classList.add(selectedBank);
            }
        });

        // Set initial icon if there's a pre-selected value (for old() values)
        document.addEventListener('DOMContentLoaded', function() {
            const bankSelect = document.getElementById('bank');
            const bankIcon = document.getElementById('bankIcon');
            const selectedBank = bankSelect.value;
            
            if (selectedBank) {
                bankIcon.className = 'bank-icon ' + selectedBank;
            }
        });

        // Validasi nomor rekening berdasarkan bank
        document.getElementById('account_number').addEventListener('input', function() {
            const bank = document.getElementById('bank').value;
            const accountNumber = this.value;
            
            // Remove non-numeric characters
            this.value = accountNumber.replace(/\D/g, '');
            
            // Basic validation based on bank
            let isValid = true;
            let message = '';
            
            if (bank && accountNumber) {
                switch(bank) {
                    case 'bca':
                        isValid = /^\d{10}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening BCA harus 10 digit';
                        break;
                    case 'mandiri':
                        isValid = /^\d{13}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening Mandiri harus 13 digit';
                        break;
                    case 'bni':
                        isValid = /^\d{10}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening BNI harus 10 digit';
                        break;
                    case 'bri':
                        isValid = /^\d{15}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening BRI harus 15 digit';
                        break;
                    case 'danamon':
                        isValid = /^\d{10}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening Danamon harus 10 digit';
                        break;
                    case 'cimb':
                        isValid = /^\d{13}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening CIMB harus 13 digit';
                        break;
                    case 'bsi':
                        isValid = /^\d{10}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening BSI harus 10 digit';
                        break;
                    case 'btn':
                        isValid = /^\d{13}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening BTN harus 13 digit';
                        break;
                    default:
                        isValid = /^\d{8,16}$/.test(accountNumber);
                        message = isValid ? '' : 'Nomor rekening harus 8-16 digit';
                }
                
                // Show/hide validation message
                let errorDiv = this.parentNode.querySelector('.error-message.validation');
                if (message) {
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message validation';
                        this.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.textContent = message;
                    this.style.borderColor = '#e74c3c';
                } else {
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                    this.style.borderColor = '#7fb069';
                }
            }
        });

        // Format nomor rekening dengan spasi untuk keterbacaan
        document.getElementById('account_number').addEventListener('blur', function() {
            const bank = document.getElementById('bank').value;
            let accountNumber = this.value.replace(/\s/g, '');
            
            if (accountNumber && bank) {
                // Format berdasarkan bank
                switch(bank) {
                    case 'bca':
                        // Format: XXXX XXXX XX
                        if (accountNumber.length === 10) {
                            accountNumber = accountNumber.replace(/(\d{4})(\d{4})(\d{2})/, '$1 $2 $3');
                        }
                        break;
                    case 'mandiri':
                        // Format: XXX XXXX XXXX XXX
                        if (accountNumber.length === 13) {
                            accountNumber = accountNumber.replace(/(\d{3})(\d{4})(\d{4})(\d{2})/, '$1 $2 $3 $4');
                        }
                        break;
                    case 'bni':
                        // Format: XXXX XXXX XX
                        if (accountNumber.length === 10) {
                            accountNumber = accountNumber.replace(/(\d{4})(\d{4})(\d{2})/, '$1 $2 $3');
                        }
                        break;
                    case 'bri':
                        // Format: XXXX XXXX XXXX XXX
                        if (accountNumber.length === 15) {
                            accountNumber = accountNumber.replace(/(\d{4})(\d{4})(\d{4})(\d{3})/, '$1 $2 $3 $4');
                        }
                        break;
                }
                this.value = accountNumber;
            }
        });

        // Remove formatting when focusing for easier editing
        document.getElementById('account_number').addEventListener('focus', function() {
            this.value = this.value.replace(/\s/g, '');
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\joypayy\resources\views/auth/register.blade.php ENDPATH**/ ?>