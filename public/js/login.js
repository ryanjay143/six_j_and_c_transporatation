document.addEventListener("DOMContentLoaded", function() {
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const submitButton = document.getElementById("submitButton");

  // Function to check if email and password have values and enable/disable submit button
  function checkInputs() {
    const email = emailInput.value;
    const password = passwordInput.value;

    // Enable/disable submit button based on input validation
    if (email.trim() !== "" && password.trim() !== "") {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }
  }

  // Function to check email input and apply success styling if needed
// Function to check email input and apply success styling if needed
// Function to check email input and apply success styling if needed
// Function to check email input and apply success styling if needed
// Function to check email input and apply success styling if needed


  // Attach event listener to password input
  passwordInput.addEventListener("input", checkInputs);
});


const passwordInput = document.getElementById('password');
const togglePasswordButton = document.getElementById('togglePassword');
const eyeIcon = togglePasswordButton.querySelector('.bi-eye-slash');
const eyeSlashIcon = togglePasswordButton.querySelector('.bi-eye');

// Function to enable or disable the toggle button
function enableDisableToggle() {
    if (passwordInput.value === '') {
        togglePasswordButton.disabled = true;
    } else {
        togglePasswordButton.disabled = false;
    }
}

// Initially disable the button if password is blank
enableDisableToggle();

// Add input event listener to enable/disable the button dynamically
passwordInput.addEventListener('input', enableDisableToggle);

togglePasswordButton.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        eyeIcon.style.display = 'block';
        eyeSlashIcon.style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('show_login_modal')) {
      $('#exampleModal').modal('show');
  }
});


// Add animation when scrolling down
window.addEventListener("scroll", () => {
  const elements = document.querySelectorAll(".animated");
  elements.forEach(element => {
      const position = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      if (position < windowHeight * 0.8) {
          element.classList.add("animate-scroll");
      }
  });
});


const typewriterElement = document.getElementById("typewriter");
  const textToType = 'Welcome to Six J And C';
  let currentText = "";
  let currentIndex = 0;

  function typeText() {
      if (currentIndex < textToType.length) {
          currentText += textToType[currentIndex];
          typewriterElement.textContent = currentText;
          currentIndex++;
          setTimeout(typeText, 100); // Adjust typing speed here
      }
  }

  // Trigger the typewriter effect when the page loads
  window.addEventListener("load", typeText);


  function isElementInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
  
  // Function to add the animation class when the card is in the viewport
  function animateCardOnScroll() {
      const card = document.querySelector('.card');
      if (isElementInViewport(card)) {
          card.classList.add('animated');
          window.removeEventListener('scroll', animateCardOnScroll);
      }
  }

  // Add a scroll event listener to trigger the animation
  window.addEventListener('scroll', animateCardOnScroll);

  