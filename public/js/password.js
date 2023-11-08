



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

 // Get the last name input element
const lastNameInput = document.getElementById('lname');

// Get the target input element where you want to populate the last name
const targetInput = document.getElementById('copyEmail');

// Add event listener to the last name input to update the target input
lastNameInput.addEventListener('input', function () {
    const lastNameValue = lastNameInput.value;
    targetInput.value = lastNameValue;
});






