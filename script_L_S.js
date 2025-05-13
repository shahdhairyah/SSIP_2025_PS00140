
//script_L_S.js
document.addEventListener('DOMContentLoaded', function() {
  // Initialize phone input
  const phoneInput = window.intlTelInput(document.querySelector("#phone"), {
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    separateDialCode: true,
    initialCountry: "in",
    preferredCountries: ["us", "in", "ca", "au"],
    formatOnDisplay: true,
    autoPlaceholder: "aggressive"
  });

  // Tab Navigation
  const tabLinks = document.querySelectorAll('.tab-link');
  const formSections = document.querySelectorAll('.form-section');

  tabLinks.forEach(tab => {
    tab.addEventListener('click', () => {
      const targetId = tab.getAttribute('data-tab');
      
      // Remove active class from all tabs and sections
      tabLinks.forEach(t => t.classList.remove('active'));
      formSections.forEach(section => section.classList.remove('active'));
      
      // Add active class to clicked tab and corresponding section
      tab.classList.add('active');
      document.getElementById(targetId).classList.add('active');
    });
  });

  // Switch form links
  const switchLinks = document.querySelectorAll('[data-switch]');
  switchLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('data-switch');
      
      // Find and click the corresponding tab
      document.querySelector(`[data-tab="${targetId}"]`).click();
    });
  });

  // Toggle password visibility
  const toggleButtons = document.querySelectorAll('.toggle-password');
  toggleButtons.forEach(button => {
    button.addEventListener('click', () => {
      const inputId = button.getAttribute('data-for');
      const passwordInput = document.getElementById(inputId);
      const toggleIcon = button.querySelector('.toggle-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.textContent = '🙈';
      } else {
        passwordInput.type = 'password';
        toggleIcon.textContent = '👁️';
      }
    });
  });

  // Password strength checker
  const passwordInput = document.getElementById('password');
  const strengthBar = document.getElementById('strength-bar');
  const strengthText = document.getElementById('strength-text');

  if (passwordInput) {
    passwordInput.addEventListener('input', () => {
      const password = passwordInput.value;
      let strength = 0;
      
      // Clear if password is empty
      if (password.length === 0) {
        strengthBar.style.width = '0%';
        strengthBar.style.backgroundColor = '';
        strengthText.textContent = '';
        return;
      }
      
      // Increase strength for different conditions
      if (password.length >= 8) strength += 1;
      if (/[A-Z]/.test(password)) strength += 1;
      if (/[a-z]/.test(password)) strength += 1;
      if (/[0-9]/.test(password)) strength += 1;
      if (/[^A-Za-z0-9]/.test(password)) strength += 1;
      
      // Update bar width
      const strengthPercentage = (strength / 5) * 100;
      strengthBar.style.width = strengthPercentage + '%';
      
      // Change bar color & text based on strength
      if (strength <= 1) {
        strengthBar.style.backgroundColor = '#ff4d4d';
        strengthText.textContent = 'Weak';
        strengthText.style.color = '#ff4d4d';
      } else if (strength === 2) {
        strengthBar.style.backgroundColor = '#ffa64d';
        strengthText.textContent = 'Fair';
        strengthText.style.color = '#ffa64d';
      } else if (strength === 3) {
        strengthBar.style.backgroundColor = '#ffff4d';
        strengthText.textContent = 'Good';
        strengthText.style.color = '#9e9e00';
      } else if (strength === 4) {
        strengthBar.style.backgroundColor = '#4dff4d';
        strengthText.textContent = 'Strong';
        strengthText.style.color = '#00a000';
      } else if (strength === 5) {
        strengthBar.style.backgroundColor = '#00cc00';
        strengthText.textContent = 'Very Strong';
        strengthText.style.color = '#008000';
      }
    });
  }

  // Check if passwords match
  const confirmPasswordInput = document.getElementById('confirm-password');
  const passwordMatchText = document.getElementById('password-match-text');

  if (confirmPasswordInput && passwordInput) {
    const checkPasswordMatch = () => {
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;
      
      if (confirmPassword.length === 0) {
        passwordMatchText.textContent = '';
        return;
      }
      
      if (password === confirmPassword) {
        passwordMatchText.textContent = 'Passwords match';
        passwordMatchText.style.color = '#00cc00';
        return true;
      } else {
        passwordMatchText.textContent = 'Passwords do not match';
        passwordMatchText.style.color = '#ff4d4d';
        return false;
      }
    };

    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    passwordInput.addEventListener('input', () => {
      if (confirmPasswordInput.value.length > 0) {
        checkPasswordMatch();
      }
    });
  }

  // Form validation
  const loginForm = document.getElementById('login-form');
  const signupForm = document.getElementById('signup-form');

  // Login form validation
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
  
      let isValid = true;
  
      // Reset error messages
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      document.getElementById('login-error').textContent = '';
      document.getElementById('login-success').textContent = '';
  
      // Validate email
      const email = document.getElementById('login-email').value;
      const password = document.getElementById('login-password').value;
  
      if (!email) {
        document.getElementById('login-email-error').textContent = 'Email is required';
        isValid = false;
      } else if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById('login-email-error').textContent = 'Please enter a valid email address';
        isValid = false;
      }
  
      if (!password) {
        document.getElementById('login-password-error').textContent = 'Password is required';
        isValid = false;
      }
  
      if (!isValid) {
        document.getElementById('login-error').textContent = 'Please fix the errors above';
        return;
      }
  
      // ✅ Call sendVerificationCode with correct values
      await sendVerificationCode(email, password);
    });
  }
  
  // Signup form validation
  // Signup form validation
  if (signupForm) {
    signupForm.addEventListener('submit', async (e) => {
      e.preventDefault();
  
      let isValid = true;
  
      // Reset error messages
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      document.getElementById('signup-error').textContent = '';
      document.getElementById('signup-message').textContent = '';
  
      // Get form fields
      const fullname = document.getElementById('fullname').value.trim();
      const phoneValid = phoneInput.isValidNumber();
      const email = document.getElementById('email').value.trim(); // <-- Corrected ID
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
  
      // Validate full name
      if (!fullname) {
        document.getElementById('fullname-error').textContent = 'Full name is required';
        isValid = false;
      }
  
      // Validate phone
      if (!phoneValid) {
        document.getElementById('phone-error').textContent = 'Please enter a valid phone number';
        isValid = false;
      }
  
      // Validate email
      if (!email) {
        document.getElementById('email-error').textContent = 'Email is required';
        isValid = false;
      } else if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById('email-error').textContent = 'Please enter a valid email address';
        isValid = false;
      }
  
      // Validate password match
      if (password !== confirmPassword) {
        document.getElementById('password-match-text').textContent = 'Passwords do not match';
        isValid = false;
      }
  
      // If invalid, stop here
      if (!isValid) {
        document.getElementById('signup-error').textContent = 'Please fix the errors above';
        return;
      }
  
      // If valid, submit form data
      const formData = new FormData(signupForm);
      try {
        const response = await fetch('signup.php', { method: 'POST', body: formData });
        const text = await response.text();
  
        try {
          const result = JSON.parse(text);
          const signupMessage = document.getElementById('signup-message');
          if (signupMessage) signupMessage.textContent = result.message;
  
          if (result.success) {
            // Send OTP after successful signup
            await sendVerificationCode(email, password); // <-- PASSES email + password
          }
        } catch (jsonError) {
          console.error('Invalid JSON:', text);
          document.getElementById('signup-message').textContent = 'Unexpected server response.';
        }
  
      } catch (error) {
        console.error('Signup Error:', error);
        document.getElementById('signup-message').textContent = 'An error occurred during signup.';
      }
    });
  }

  
  // Function to send verification code
  async function sendVerificationCode(email,password) {
    showLoader();
    try {
      const response = await fetch('send_token.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
      });
      
      let data;
      try {
        data = await response.json();
      } catch (e) {
        throw new Error('Invalid server response');
      }

      if (data.success) {
        hideLoader();
        openPopup();
        document.getElementById('popup-email').value = email;
      } else {
        throw new Error(data.message || 'Failed to send verification code');
      }
    } catch (error) {
      console.error('Error:', error);
      alert(error.message || 'Failed to send verification code');
    }
  }

  // Function to verify token
  async function verifyToken() {
    const token = document.getElementById('popup-token').value;
    const email = document.getElementById('popup-email').value;
    const messageElement = document.getElementById('popup-message');
    console.log("email", email);
    console.log("token", token);
    if (!token || token.length !== 6) {
        messageElement.textContent = 'Please enter a valid 6-digit code';
        messageElement.style.color = '#ff4d4d';
        return;
    }
    
    try {
        const response = await fetch('verify_token.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${encodeURIComponent(email)}&token=${encodeURIComponent(token)}`
        });

        if (!response.ok) {
            throw new Error(`Server Error: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();

        if (data.success) {
            messageElement.textContent = 'Verification successful!';
            messageElement.style.color = '#00cc00';

            if (data.redirect) {
                setTimeout(() => {
                    closePopup();
                    window.location.href = data.redirect;
                }, 1500);
            }
        } else {
            throw new Error(data.message || 'Verification failed');
        }
    } catch (error) {
        console.error('Error:', error);
        messageElement.textContent = error.message || 'An error occurred during verification';
        messageElement.style.color = '#ff4d4d';
        document.getElementById('popup-token').style.borderColor = '#ff4d4d';
    }
}


  // Add input validation for verification code
  document.getElementById('popup-token').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    
    // Clear error styling when user starts typing
    this.style.borderColor = '';
    document.getElementById('popup-message').textContent = '';
  });

  // Make functions globally available
  window.verifyToken = verifyToken;
  window.openPopup = function() {
    document.getElementById('popup-modal').style.display = 'block';
    document.getElementById('popup-message').textContent = '';
    document.getElementById('popup-token').value = '';
    document.getElementById('popup-email').value = '';
};

window.closePopup = function() {
    document.getElementById('popup-modal').style.display = 'none';
};
});
