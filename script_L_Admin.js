document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('login-form');
  const captchaDisplay = document.getElementById('login-captcha');
  const captchaInput = document.getElementById('login-captcha-input');
  const refreshCaptchaBtn = document.getElementById('refresh-login-captcha');
  const loginError = document.getElementById('login-error');
  const loginSuccess = document.getElementById('login-success');
  const loaderOverlay = document.getElementById('loader-overlay');
  const popupModal = document.getElementById('popup-modal');
  const popupMessage = document.getElementById('popup-message');
  const verificationInputs = document.querySelectorAll('.verification-input input');
  const successCheckmark = document.querySelector('.success-checkmark');

  let currentEmail = '';
  let generatedCaptcha = '';

  // Handle verification code input
  verificationInputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
          if (e.target.value) {
              if (index < verificationInputs.length - 1) {
                  verificationInputs[index + 1].focus();
              }
          }
      });

      input.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && !e.target.value && index > 0) {
              verificationInputs[index - 1].focus();
          }
      });
  });

  function generateCaptcha() {
      const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      let captcha = '';
      for (let i = 0; i < 6; i++) {
          captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      generatedCaptcha = captcha;
      captchaDisplay.textContent = captcha;
  }

  refreshCaptchaBtn.addEventListener('click', generateCaptcha);
  generateCaptcha();

  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
          const targetId = btn.getAttribute('data-for');
          const input = document.getElementById(targetId);
          input.type = input.type === 'password' ? 'text' : 'password';
      });
  });

  loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      loginError.textContent = '';
      loginSuccess.textContent = '';

      const email = document.getElementById('login-email').value.trim();
      const password = document.getElementById('login-password').value.trim();
      const captchaInputVal = captchaInput.value.trim();
      if (captchaInputVal.toUpperCase() !== generatedCaptcha) {
          loginError.textContent = 'Invalid CAPTCHA';
          generateCaptcha();
          return;
      }

      loaderOverlay.style.display = 'flex';

      try {
          const response = await fetch('send_token_admin.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: new URLSearchParams({ email, password })
          });

          const result = await response.json();
          loaderOverlay.style.display = 'none';

          if (result.success) {
              currentEmail = email;
              popupModal.style.display = 'block';
              verificationInputs[0].focus();
          } else {
              loginError.textContent = result.message || 'Login failed';
          }
      } catch (err) {
          loaderOverlay.style.display = 'none';
          loginError.textContent = 'Error connecting to server';
      }
  });

  window.verifyToken = async () => {
      const token = Array.from(verificationInputs)
          .map(input => input.value)
          .join('');

      if (token.length !== 6) {
          popupMessage.textContent = 'Please enter all digits';
          popupMessage.style.color = '#e74c3c';
          return;
      }

      loaderOverlay.style.display = 'flex';

      try {
          const response = await fetch('verify_token_admin.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: new URLSearchParams({ email: currentEmail, token })
          });

          const result = await response.json();
          loaderOverlay.style.display = 'none';

          if (result.success) {
              successCheckmark.style.display = 'block';
              popupMessage.textContent = 'Verification successful!';
              popupMessage.style.color = '#2ecc71';
              setTimeout(() => {
                window.location.href = result.redirect;
            }, 1500);
          } else {
              popupMessage.textContent = result.message || 'Invalid code';
              popupMessage.style.color = '#e74c3c';
          }
      } catch (err) {
          loaderOverlay.style.display = 'none';
          popupMessage.textContent = 'Error verifying code';
          popupMessage.style.color = '#e74c3c';
      }
  };

  window.closePopup = () => {
      popupModal.style.display = 'none';
      verificationInputs.forEach(input => input.value = '');
      popupMessage.textContent = '';
      successCheckmark.style.display = 'none';
  };
});