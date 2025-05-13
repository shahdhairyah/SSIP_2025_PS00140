<?php
session_start();
if (isset($_SESSION['user_email_admin']) && isset($_SESSION['redirect'])) {
  header("Location: " . $_SESSION['redirect']);
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style_L_admin.css">
    <style>
        /* Modern CSS Reset */
  *, *::before, *::after {
      box-sizing: border-box;
    }
    
    body, h1, h2, h3, h4, p, figure, blockquote, dl, dd {
      margin: 0;
    }
    
    body {
      min-height: 100vh;
      scroll-behavior: smooth;
      text-rendering: optimizeSpeed;
      line-height: 1.5;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      background: linear-gradient(135deg, #6e8efb, #a777e3);
      color: #333;
    }
    
    /* Container Styles */
    .container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    
    .form-container {
      background-color: white;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
      overflow: hidden;
      animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    /* Tab Navigation */
    .tab-container {
      display: flex;
      border-bottom: 1px solid #eee;
    }
    
    .tab-link {
      flex: 1;
      padding: 1rem;
      text-align: center;
      background: none;
      border: none;
      font-size: 1rem;
      font-weight: 600;
      color: #777;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .tab-link:hover {
      background-color: #f9f9f9;
      color: #555;
    }
    
    .tab-link.active {
      color: #6e8efb;
    }
    
    .tab-link.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 3px;
      background-color: #6e8efb;
      animation: slideIn 0.3s ease-in-out;
    }
    
    @keyframes slideIn {
      from { transform: scaleX(0); }
      to { transform: scaleX(1); }
    }
    
    /* Form Wrapper */
    .form-wrapper {
      padding: 2rem;
    }
    
    .form-section {
      display: none;
      animation: fadeIn 0.5s ease-in-out;
    }
    
    .form-section.active {
      display: block;
    }
    
    h2 {
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
      color: #333;
      text-align: center;
    }
    
    /* Input Styles */
    .input-container {
      margin-bottom: 1.25rem;
    }
    
    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #555;
    }
    
    .input-wrapper, .password-wrapper, .select-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .input-wrapper:focus-within, 
    .password-wrapper:focus-within, 
    .select-wrapper:focus-within {
      border-color: #6e8efb;
      box-shadow: 0 0 0 2px rgba(110, 142, 251, 0.1);
    }
    
    .icon {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 0.75rem;
      color: #777;
    }
    
    input, select {
      flex: 1;
      padding: 0.75rem;
      border: none;
      outline: none;
      font-size: 1rem;
      background: transparent;
    }
    
    select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23777' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 1rem;
      padding-right: 2.5rem;
    }
    
    .toggle-password {
      background: none;
      border: none;
      padding: 0.5rem 0.75rem;
      cursor: pointer;
      color: #777;
      transition: color 0.3s ease;
    }
    
    .toggle-password:hover {
      color: #6e8efb;
    }
    
    /* Password Strength Meter */
    .strength-meter {
      height: 4px;
      background-color: #eee;
      border-radius: 2px;
      margin-top: 0.5rem;
      overflow: hidden;
    }
    
    .strength-bar {
      height: 100%;
      width: 0;
      transition: width 0.3s ease, background-color 0.3s ease;
    }
    
    .strength-text, .match-text {
      font-size: 0.8rem;
      margin-top: 0.25rem;
      transition: color 0.3s ease;
    }
    
    /* Form Footer */
    .form-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.25rem;
    }
    
    .remember-me {
      display: flex;
      align-items: center;
    }
    
    .remember-me input {
      margin-right: 0.5rem;
    }
    
    .forgot-password {
      color: #6e8efb;
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s ease;
    }
    
    .forgot-password:hover {
      color: #a777e3;
      text-decoration: underline;
    }
    
    /* Terms Container */
    .terms-container {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1.25rem;
    }
    
    .terms-container input {
      margin-right: 0.5rem;
      margin-top: 0.25rem;
    }
    
    .terms-container a {
      color: #6e8efb;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .terms-container a:hover {
      color: #a777e3;
      text-decoration: underline;
    }
    
    /* Button Styles */
    .form-button {
      width: 100%;
      padding: 0.875rem;
      background: linear-gradient(135deg, #6e8efb, #a777e3);
      color: white;
      border: none;
      border-radius: 0.5rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 1rem;
    }
    
    .form-button:hover {
      background: linear-gradient(135deg, #5d7df9, #9666e0);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(110, 142, 251, 0.3);
    }
    
    .form-button:active {
      transform: translateY(0);
    }
    
    /* Switch Form Text */
    .switch-form {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
      color: #777;
    }
    
    .switch-form a {
      color: #6e8efb;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    
    .switch-form a:hover {
      color: #a777e3;
      text-decoration: underline;
    }
    
    /* Error and Success Messages */
    .error-message, .success-message {
      font-size: 0.85rem;
      margin-top: 0.25rem;
      transition: all 0.3s ease;
    }
    
    .error-message {
      color: #e74c3c;
    }
    
    .success-message {
      color: #2ecc71;
    }
    
    .message-container {
      min-height: 1.5rem;
      margin-bottom: 0.5rem;
    }
    
    /* CAPTCHA Styles */
    .captcha-container {
      margin-bottom: 1.25rem;
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      align-items: center;
    }
    
    .captcha {
      flex: 1;
      min-width: 150px;
      height: 50px;
      background-color: #f5f5f5;
      border-radius: 0.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Courier New', monospace;
      font-size: 1.25rem;
      font-weight: bold;
      letter-spacing: 0.25rem;
      color: #333;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
      position: relative;
      overflow: hidden;
    }
    
    .captcha::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, 
        rgba(255,255,255,0.1) 25%, 
        transparent 25%, 
        transparent 50%, 
        rgba(255,255,255,0.1) 50%, 
        rgba(255,255,255,0.1) 75%, 
        transparent 75%, 
        transparent);
      background-size: 4px 4px;
    }
    
    .refresh-captcha {
      background: none;
      border: none;
      font-size: 1.25rem;
      cursor: pointer;
      color: #777;
      transition: color 0.3s ease;
      padding: 0.25rem;
    }
    
    .refresh-captcha:hover {
      color: #6e8efb;
    }
    
    #login-captcha-input, #signup-captcha-input {
      flex: 1;
      min-width: 100px;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    
    #login-captcha-input:focus, #signup-captcha-input:focus {
      border-color: #6e8efb;
      box-shadow: 0 0 0 2px rgba(110, 142, 251, 0.1);
      outline: none;
    }
    
    /* Phone Input Styles */
    .iti {
      width: 100%;
    }
    
    .iti__flag-container {
      z-index: 2;
    }
    
    /* Fix for phone input with intl-tel-input */
    #phone {
      width: 100%;
    }
    
    .input-wrapper .iti {
      flex: 1;
      display: flex;
    }
    
    /* Responsive Styles */
    @media (max-width: 576px) {
      .form-wrapper {
        padding: 1.5rem;
      }
      
      .form-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }
      
      .captcha-container {
        flex-direction: column;
        align-items: stretch;
      }
      
      .captcha {
        width: 100%;
      }
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="tab-container">
                <button class="tab-link active">Admin Login & Departments HOD</button>
            </div>
            
            <div class="form-wrapper">
                <div id="login-section" class="form-section active">
                    <h2>Admin & HODs Login</h2>
                    <form action="login_admin.php" method="POST" id="login-form">
                        <div class="input-container">
                            <label for="login-email">Email</label>
                            <div class="input-wrapper">
                                <span class="icon">📧</span>
                                <input type="email" id="login-email" name="login-email" placeholder="Enter your email" required>
                            </div>
                            <span class="error-message" id="login-email-error"></span>
                        </div>
                    
                        <div class="input-container">
                            <label for="login-password">Password</label>
                            <div class="password-wrapper">
                                <span class="icon">🔒</span>
                                <input type="password" id="login-password" name="login-password" placeholder="Enter your password" required>
                                <button type="button" class="toggle-password" data-for="login-password">
                                    <span class="toggle-icon">👁️</span>
                                </button>
                            </div>
                            <span class="error-message" id="login-password-error"></span>
                        </div>
                        
                        <div class="form-footer">
                            <div class="remember-me">
                                <input type="checkbox" id="remember-me">
                                <label for="remember-me">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                        
                        <div class="captcha-container">
                            <div class="captcha" id="login-captcha"></div>
                            <button type="button" class="refresh-captcha" id="refresh-login-captcha">🔄</button>
                            <input type="text" id="login-captcha-input" placeholder="Enter CAPTCHA" required>
                            <span class="error-message" id="login-captcha-error"></span>
                        </div>
                        
                        <div class="message-container">
                            <div class="error-message" id="login-error"></div>
                            <div class="success-message" id="login-success"></div>
                        </div>
                        
                        <button type="submit" class="form-button">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader -->
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader">
            <div class="loader-cube">
                <div class="loader-face"></div>
                <div class="loader-face"></div>
                <div class="loader-face"></div>
                <div class="loader-face"></div>
                <div class="loader-face"></div>
                <div class="loader-face"></div>
            </div>
            <div class="loader-text">Verifying...</div>
        </div>
    </div>

    <!-- Verification Popup -->
    <div id="popup-modal" class="popup">
        <div class="popup-content">
            <h2>Email Verification</h2>
            <p>Please enter the verification code sent to your email</p>
            
            <div class="verification-input">
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </div>

            <div class="success-checkmark">✓</div>
            <p id="popup-message" class="verification-message"></p>
            
            <div class="popup-buttons">
                <button class="verify-button" onclick="verifyToken()">Verify</button>
                <button class="close-button" onclick="closePopup()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="script_L_Admin.js"></script>
</body>
</html>