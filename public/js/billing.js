// Wait for the DOM to be ready
$(document).ready(function () {
    // Add an event listener to the select element and date inputs
    $('select[name="client_id"]').change(function () {
        // Automatically submit the form when the user selects a client or enters a date range
        $('#filterForm').submit();
    });
});


function calculateAmount(iteration) {
    const rows = document.querySelectorAll('tbody tr');
    let totalAmount = 0;
    let allRowsHaveValidPrice = true; // Variable to track if all rows have a valid price

    rows.forEach((row, index) => {
        const expTonsInput = row.querySelector('.exp-tons');
        const priceInput = row.querySelector('.price');
        const amountElement = row.querySelector('.amount');

        // Get the initial expTons value as a fallback in case the user has not entered a value yet
        let expTons = parseFloat(expTonsInput.value) || 0;
        const price = parseFloat(priceInput.value);

        // Check if the price is valid (not NaN and greater than 0)
        if (isNaN(price) || price <= 0) {
            allRowsHaveValidPrice = false;
        }

        const amount = expTons * price;
        amountElement.textContent = '₱ ' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); // Format amount with two decimal places and thousands separators

        totalAmount += amount;
    });

    // Display the total amount with commas as thousands separators and two decimal places
    document.getElementById('totalAmount').textContent = '₱ ' + totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    // Get the Save Billing button and enable/disable it based on whether all rows have a valid price and tons
    const saveBillingBtn = document.getElementById('saveBillingBtn');
    saveBillingBtn.disabled = !allRowsHaveValidPrice || rows.length === 0; // Disable the button when the tbody is empty
}

    document.addEventListener('DOMContentLoaded', function() {
        // Get the totalAmount and totalAmountCopy elements
        const totalAmountElement = document.getElementById('totalAmount');
        const totalAmountCopyElement = document.getElementById('totalAmountCopy');

        function formatTotalAmount() {
            const totalAmountElement = document.getElementById('totalAmount');
            const totalAmountCopyElement = document.getElementById('totalAmountCopy');
            const totalAmountValue = parseFloat(totalAmountElement.textContent.replace(/₱/g, '').replace(/,/g, '')); // Remove "₱" symbol and commas
            const formattedTotalAmount = totalAmountValue.toLocaleString();
            totalAmountElement.textContent = '₱ ' + formattedTotalAmount;
            totalAmountCopyElement.value = formattedTotalAmount;
        }

        // Call the function initially to format the total amount value
        formatTotalAmount();

        const observer = new MutationObserver(formatTotalAmount);
        observer.observe(totalAmountElement, { characterData: true, childList: true, subtree: true });
    });

    // Add event listener to each original price input field
    const originalPriceInputFields = document.querySelectorAll('.price');
    originalPriceInputFields.forEach((field) => {
        field.addEventListener('input', function() {
            const iteration = field.getAttribute('data-iteration');
            const copyPriceInputField = document.getElementById('priceCopy_' + iteration);
            copyPriceInputField.value = field.value;
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        // Get the totalAmount and totalAmountCopy elements
        const totalAmountElement = document.getElementById('totalAmount');
        const totalAmountCopyElement = document.getElementById('totalAmountCopy');

        // Function to update the value of totalAmountCopy to match totalAmount
        function updateTotalAmountCopy() {
            const totalAmountValue = totalAmountElement.textContent;
            const totalAmountValueWithoutCommas = totalAmountValue.replace(/,/g, ''); // Remove commas
            totalAmountCopyElement.value = totalAmountValueWithoutCommas;
        }

        // Call the function initially to set the value of totalAmountCopy
        updateTotalAmountCopy();

    
        const observer = new MutationObserver(updateTotalAmountCopy);
        observer.observe(totalAmountElement, { characterData: true, childList: true, subtree: true });
    });

  document.addEventListener('DOMContentLoaded', function() {
    const clientSelect = document.getElementById('clientSelect');
    const clientNameInput = document.getElementById('clientNameInput');

    // Function to update the input field with the selected client ID
    function updateClientIdInput() {
        clientNameInput.value = clientSelect.value;
    }

    // Add an event listener to the dropdown to update the input field when the selection changes
    clientSelect.addEventListener('change', function() {
        updateClientIdInput();
    });

    // Trigger the change event initially to set the input value based on the initial selection
    updateClientIdInput();
});

   

const originalInputTonsFields = document.querySelectorAll('.exp-tons');
originalInputTonsFields.forEach((field) => {
    field.addEventListener('input', function() {
        const iteration = field.getAttribute('data-iteration');
        const copyInputTonsField = document.getElementById('tonsCopy_' + iteration);
        copyInputTonsField.value = field.value;
    });
});

    

    document.addEventListener('DOMContentLoaded', function() {
        // Get the totalAmount and totalAmountCopy elements
        const totalAmountElement = document.getElementById('totalAmount');
        const totalAmountCopyElement = document.getElementById('totalAmountCopy');

        // Function to copy the value of totalAmount to totalAmountCopy
        function copyTotalAmount() {
            const totalAmountValue = totalAmountElement.textContent;
            const totalAmountValueWithoutPeso = totalAmountValue.replace(/₱/g, ''); // Remove the "₱" symbol
            totalAmountCopyElement.value = totalAmountValueWithoutPeso;
        }

        // Call the function initially to set the value of totalAmountCopy
        copyTotalAmount();

        const observer = new MutationObserver(copyTotalAmount);
        observer.observe(totalAmountElement, { characterData: true, childList: true, subtree: true });
    });
    
     
  // Calculate amount on page load
  calculateAmount();

  


  $(document).ready(function () {
    $('#billing').DataTable({

        pageLength: 30,
        // Disable the "Show [X] entries" dropdown
        lengthChange: false,
        
        // Disable the search bar
        searching: false
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var currentDate = new Date();
    var currentDay = currentDate.getDate();

    var startDateInput = document.querySelector('#start_date_input input');
    var endDateInput = document.querySelector('#end_date_input input');

    // Set default values based on the day of the month
    if (currentDay <= 15) {
        // If the day is 1-15, set default values for the entire month
        startDateInput.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-01';
        endDateInput.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-15';
    } else {
        // If the day is 16-30 or 31, set default values for the entire month
        startDateInput.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-16';

        // Set the end_date to the last day of the current month
        var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        endDateInput.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + lastDay;
    }
    // Show the hidden div elements
    document.getElementById('start_date_input').style.display = 'block';
    document.getElementById('end_date_input').style.display = 'block';
});




  