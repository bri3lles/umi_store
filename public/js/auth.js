document.addEventListener('DOMContentLoaded', function () {
  const showPassCheckbox = document.getElementById('show-pass');
  const passwordInput = document.getElementById('password');

  if (showPassCheckbox && passwordInput) {
    showPassCheckbox.addEventListener('change', function () {
      if (this.checked) {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  }
});