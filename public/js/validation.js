// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
  
        form.classList.add('was-validated')
      }, false)
    })
  })()



  // Get the input elements
const emailInput = document.getElementById('email');
const copyEmailInput = document.getElementById('copyEmail');

// Add an event listener to the email input to update the copy input value
emailInput.addEventListener('input', function () {
    const inputValue = this.value;
    const domainIndex = inputValue.lastIndexOf('@');

    if (domainIndex !== -1) {
        const username = inputValue.substring(0, domainIndex);
        if (username !== '') {
            copyEmailInput.value = username;
            return;
        }
    }

    copyEmailInput.value = inputValue;
});

const passwordInput = document.getElementById('copyEmail');
const togglePasswordButton = document.getElementById('togglePassword');

togglePasswordButton.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});
