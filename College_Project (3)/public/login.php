<?php include '../Backend/db.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Smart Gym</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-dark: #0f0f13;
            --bg-card: #1a1a24;
            --bg-input: #23232f;
            --text-primary: #ffffff;
            --text-secondary: #a0a0b0;
            --accent: #f74a06ff;
            --accent-hover: #ff8533;
            --border: #2a2a36;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            --error: #ff4444;
            --success: #00c851;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 107, 43, 0.05) 0%, transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(255, 107, 43, 0.05) 0%, transparent 30%);
            pointer-events: none;
        }

        .login-container {
            background: var(--bg-card);
            width: 100%;
            max-width: 400px;
            padding: 2.8rem 2.5rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h2 {
            color: var(--text-primary);
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .login-container input {
            width: 100%;
            padding: 0.9rem 1rem;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .login-container input:hover {
            border-color: var(--accent);
        }

        .login-container input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 107, 43, 0.1);
        }

        .login-container input.error {
            border-color: var(--error);
        }

        .login-container input.valid {
            border-color: var(--success);
        }

        .login-container input::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            padding-right: 2.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
            font-size: 1.1rem;
        }

        .password-toggle:hover {
            color: var(--accent);
        }

        .validation-message {
            font-size: 0.75rem;
            margin-top: 0.3rem;
            margin-left: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .validation-message.error-message {
            color: var(--error);
        }

        .validation-message.success-message {
            color: var(--success);
        }

        .validation-message i {
            font-size: 0.7rem;
        }

        .password-requirements {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            padding: 0.8rem;
            margin-top: 0.3rem;
            font-size: 0.7rem;
        }

        .password-requirements p {
            color: var(--text-secondary);
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.3rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .requirement i {
            font-size: 0.65rem;
            width: 16px;
        }

        .requirement.met {
            color: var(--success);
        }

        .requirement.not-met {
            color: var(--error);
        }

        .primary-btn {
            width: 100%;
            padding: 0.9rem;
            background: var(--accent);
            color: var(--text-primary);
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0.5rem 0 1rem;
            position: relative;
            overflow: hidden;
        }

        .primary-btn:hover:not(:disabled) {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 43, 0.3);
        }

        .primary-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .primary-btn:active {
            transform: translateY(0);
        }

        .primary-btn i {
            margin-right: 0.5rem;
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .login-container a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .login-container a:hover {
            color: var(--accent);
        }

        .login-container a i {
            margin-right: 0.3rem;
            font-size: 0.8rem;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            cursor: pointer;
        }

        .primary-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .primary-btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 0.8rem 1rem;
            background: rgba(255, 107, 43, 0.1);
            border-left: 3px solid var(--accent);
            color: var(--accent);
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert i {
            font-size: 1rem;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(255, 107, 43, 0.1);
            color: var(--accent);
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 107, 43, 0.2);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
            }

            .login-container h2 {
                font-size: 1.8rem;
            }

            .links {
                flex-direction: column;
                gap: 0.8rem;
                align-items: center;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-hover);
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Smart Gym</h2>
    
    <?php
    // Check if there's an error message from the backend
    if (isset($_GET['error'])) {
        $error_msg = $_GET['error'];
        echo '<div class="alert" id="alert" style="display: flex;">
                <i class="fas fa-exclamation-circle"></i>
                <span>' . htmlspecialchars($error_msg) . '</span>
              </div>';
    } else {
        echo '<div class="alert" id="alert" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="alertMessage">Invalid credentials</span>
              </div>';
    }
    ?>

    <!-- Form action pointing to backend login processor -->
    <form action="../Backend/login.php" method="POST" id="loginForm">
        <input type="hidden" name="role" value="admin">
        
        <div class="admin-badge">
            <i class="fas fa-shield-alt"></i> Administrator Access
        </div>

        <div class="input-group">
            <input type="text" name="username" id="username" placeholder="Email or Username" required autocomplete="off">
            <div class="validation-message" id="usernameValidation"></div>
        </div>

        <div class="input-group">
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePassword()"></i>
            </div>
            <div class="validation-message" id="passwordValidation"></div>
            <div class="password-requirements" id="passwordRequirements">
                <p><i class="fas fa-shield-alt"></i> Password must contain:</p>
                <div class="requirement" id="reqLength">
                    <i class="fas fa-circle"></i> At least 6 characters
                </div>
                <div class="requirement" id="reqLetter">
                    <i class="fas fa-circle"></i> At least 1 letter (A-Z or a-z)
                </div>
                <div class="requirement" id="reqNumber">
                    <i class="fas fa-circle"></i> At least 1 number (0-9)
                </div>
            </div>
        </div>

        <button type="submit" class="primary-btn" id="loginBtn" disabled>
            <i class="fas fa-sign-in-alt"></i> Login as Admin
        </button>

        <div class="links">
            <a href="signup.php"><i class="fas fa-user-plus"></i> Create Account</a>
            <a href="forgot_password.php"><i class="fas fa-key"></i> Forgot Password</a>
        </div>

        <!-- Back button - goes to home page (index.php in root) -->
        <a href="../index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </form>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Email validation function
    function validateEmail(email) {
        if (!email.includes('@')) {
            return {
                isValid: false,
                message: 'Email must contain "@" symbol'
            };
        }
        
        const atIndex = email.indexOf('@');
        if (atIndex === 0) {
            return {
                isValid: false,
                message: 'Please enter email address before "@"'
            };
        }
        
        const domain = email.substring(atIndex + 1);
        if (domain.length === 0) {
            return {
                isValid: false,
                message: 'Please enter domain name after "@"'
            };
        }
        
        if (!domain.includes('.')) {
            return {
                isValid: false,
                message: 'Domain must contain "." (e.g., gmail.com)'
            };
        }
        
        const lastDotIndex = domain.lastIndexOf('.');
        const tld = domain.substring(lastDotIndex + 1);
        if (tld.length < 2) {
            return {
                isValid: false,
                message: 'Please enter a valid domain extension (e.g., .com, .in)'
            };
        }
        
        const localPart = email.substring(0, atIndex);
        const validLocalRegex = /^[a-zA-Z0-9._-]+$/;
        if (!validLocalRegex.test(localPart)) {
            return {
                isValid: false,
                message: 'Email can only contain letters, numbers, dots, underscores, and hyphens'
            };
        }
        
        const validDomainRegex = /^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!validDomainRegex.test(domain)) {
            return {
                isValid: false,
                message: 'Please enter a valid domain name'
            };
        }
        
        return {
            isValid: true,
            message: 'Valid email format'
        };
    }

    // Password validation function
    function validatePassword(password) {
        const hasMinLength = password.length >= 6;
        const hasLetter = /[a-zA-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        
        return {
            isValid: hasMinLength && hasLetter && hasNumber,
            hasMinLength: hasMinLength,
            hasLetter: hasLetter,
            hasNumber: hasNumber
        };
    }

    // Update password requirements display
    function updatePasswordRequirements(password) {
        const validation = validatePassword(password);
        
        const reqLength = document.getElementById('reqLength');
        const reqLetter = document.getElementById('reqLetter');
        const reqNumber = document.getElementById('reqNumber');
        
        reqLength.classList.remove('met', 'not-met');
        reqLetter.classList.remove('met', 'not-met');
        reqNumber.classList.remove('met', 'not-met');
        
        if (validation.hasMinLength) {
            reqLength.classList.add('met');
            reqLength.innerHTML = '<i class="fas fa-check-circle"></i> At least 6 characters';
        } else {
            reqLength.classList.add('not-met');
            reqLength.innerHTML = '<i class="fas fa-times-circle"></i> At least 6 characters';
        }
        
        if (validation.hasLetter) {
            reqLetter.classList.add('met');
            reqLetter.innerHTML = '<i class="fas fa-check-circle"></i> At least 1 letter (A-Z or a-z)';
        } else {
            reqLetter.classList.add('not-met');
            reqLetter.innerHTML = '<i class="fas fa-times-circle"></i> At least 1 letter (A-Z or a-z)';
        }
        
        if (validation.hasNumber) {
            reqNumber.classList.add('met');
            reqNumber.innerHTML = '<i class="fas fa-check-circle"></i> At least 1 number (0-9)';
        } else {
            reqNumber.classList.add('not-met');
            reqNumber.innerHTML = '<i class="fas fa-times-circle"></i> At least 1 number (0-9)';
        }
        
        return validation;
    }

    // Real-time username/email validation
    function validateUsernameInput() {
        const usernameInput = document.getElementById('username');
        const username = usernameInput.value.trim();
        const validationDiv = document.getElementById('usernameValidation');
        
        if (username === '') {
            usernameInput.classList.remove('error', 'valid');
            validationDiv.innerHTML = '';
            validationDiv.className = 'validation-message';
            return false;
        }
        
        const result = validateEmail(username);
        
        if (result.isValid) {
            usernameInput.classList.remove('error');
            usernameInput.classList.add('valid');
            validationDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${result.message}`;
            validationDiv.className = 'validation-message success-message';
            return true;
        } else {
            usernameInput.classList.remove('valid');
            usernameInput.classList.add('error');
            validationDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${result.message}`;
            validationDiv.className = 'validation-message error-message';
            return false;
        }
    }

    // Real-time password validation
    let passwordValidation = { isValid: false };
    
    function validatePasswordInput() {
        const passwordInput = document.getElementById('password');
        const password = passwordInput.value;
        const validationDiv = document.getElementById('passwordValidation');
        
        if (password === '') {
            passwordInput.classList.remove('error', 'valid');
            validationDiv.innerHTML = '';
            validationDiv.className = 'validation-message';
            document.getElementById('passwordRequirements').style.display = 'block';
            return false;
        }
        
        const validation = validatePassword(password);
        passwordValidation = validation;
        
        if (validation.isValid) {
            passwordInput.classList.remove('error');
            passwordInput.classList.add('valid');
            validationDiv.innerHTML = `<i class="fas fa-check-circle"></i> Password meets requirements`;
            validationDiv.className = 'validation-message success-message';
            document.getElementById('passwordRequirements').style.display = 'none';
            return true;
        } else {
            passwordInput.classList.remove('valid');
            passwordInput.classList.add('error');
            validationDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> Please check password requirements below`;
            validationDiv.className = 'validation-message error-message';
            document.getElementById('passwordRequirements').style.display = 'block';
            return false;
        }
    }

    // Update submit button state
    function updateSubmitButton() {
        const emailValid = validateUsernameInput();
        const passwordValid = validatePasswordInput();
        const loginBtn = document.getElementById('loginBtn');
        
        if (emailValid && passwordValid) {
            loginBtn.disabled = false;
        } else {
            loginBtn.disabled = true;
        }
    }

    // Show alert message
    function showAlert(message) {
        const alert = document.getElementById('alert');
        const alertMessage = document.getElementById('alertMessage');
        
        alertMessage.textContent = message;
        alert.style.display = 'flex';
        
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }

    // Form submission with final validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const loginBtn = document.getElementById('loginBtn');
        
        // Final validation before submission
        const emailValidation = validateEmail(username);
        const passwordValidationResult = validatePassword(password);
        
        if (!emailValidation.isValid) {
            e.preventDefault();
            showAlert(emailValidation.message);
            return false;
        }
        
        if (!passwordValidationResult.isValid) {
            e.preventDefault();
            showAlert('Please ensure password meets all requirements: at least 6 characters, 1 letter, and 1 number');
            return false;
        }
        
        // Show loading state
        loginBtn.innerHTML = '<i class="fas fa-spinner"></i> Authenticating...';
        loginBtn.classList.add('loading');
        loginBtn.disabled = true;
    });

    // Add event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        
        usernameInput.addEventListener('input', function() {
            validateUsernameInput();
            updateSubmitButton();
        });
        
        passwordInput.addEventListener('input', function() {
            updatePasswordRequirements(this.value);
            validatePasswordInput();
            updateSubmitButton();
        });
        
        usernameInput.focus();
        updateSubmitButton();
        
        const style = document.createElement('style');
        style.textContent = `
            .requirement.met i, .requirement.met {
                color: #00c851;
            }
            .requirement.not-met i, .requirement.not-met {
                color: #ff4444;
            }
            .requirement i {
                font-size: 0.65rem;
                width: 16px;
            }
        `;
        document.head.appendChild(style);
    });

    console.log('%c👑 Admin Login | Smart Gym', 'color: #ff6b2b; font-size: 14px; font-weight: bold;');
    console.log('%cOrange Theme | Admin Only | With Email & Password Validation', 'color: #a0a0b0; font-size: 12px;');
</script>

</body>
</html>