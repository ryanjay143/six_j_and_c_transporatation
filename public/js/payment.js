// Get all elements with class names
var paymentSelects = document.querySelectorAll(".paymentSelect");
var chiqueInputs = document.querySelectorAll(".chique_input");
var referenceInputs = document.querySelectorAll(".reference_input");
var totalAmountInputs = document.querySelectorAll(".total_amount");
var cashAmountInputs = document.querySelectorAll(".cash_amount");


paymentSelects.forEach(function (paymentSelect, index) {
    paymentSelect.addEventListener("change", function () {
        var parentDiv = this.closest(".payment-row");
        var paymentDetails = parentDiv.querySelector(".payment-details");
        var chiqueNumber = parentDiv.querySelector(".chique-number");
        var referenceNumber = parentDiv.querySelector(".reference-number");
        var cash = parentDiv.querySelector(".cash");
        var selectedValue = this.value;

        if (selectedValue === "Cash") {
            chiqueNumber.style.display = "none";
            referenceNumber.style.display = "none";
            cash.style.display = "none";

            // Remove the 'required' attribute from Chique and Bank Transfer inputs
            chiqueNumber.querySelector("input").removeAttribute("required");
            referenceNumber.querySelector("input").removeAttribute("required");
        } else if (selectedValue === "Bank Transfer") {
            chiqueNumber.style.display = "none";
            referenceNumber.style.display = "block";
            cash.style.display = "none";

            // Add the 'required' attribute to the Bank Transfer input
            referenceNumber.querySelector("input").setAttribute("required", "required");

            // Remove the 'required' attribute from the Chique input
            chiqueNumber.querySelector("input").removeAttribute("required");
        } else if (selectedValue === "Cheque") {
            chiqueNumber.style.display = "block";
            referenceNumber.style.display = "none";
            cash.style.display = "none";

            // Add the 'required' attribute to the Chique input
            chiqueNumber.querySelector("input").setAttribute("required", "required");

            // Remove the 'required' attribute from the Bank Transfer input
            referenceNumber.querySelector("input").removeAttribute("required");
        } else {
            chiqueNumber.style.display = "none";
            referenceNumber.style.display = "none";
            cash.style.display = "none";

            // Remove the 'required' attribute from both Chique and Bank Transfer inputs
            chiqueNumber.querySelector("input").removeAttribute("required");
            referenceNumber.querySelector("input").removeAttribute("required");
        }

        paymentDetails.style.display = "block";
       
    });
});

// Add event listeners to all cashAmountInput elements
cashAmountInputs.forEach(function (cashAmountInput) {
    cashAmountInput.addEventListener("input", function () {
        // Remove any non-numeric characters
        this.value = this.value.replace(/[^\d.]/g, "");
    });
});



// Add a click event listener to the delete button
$('.delete-button').click(function () {
    // Get the billing ID from the data-id attribute
    const billingId = $(this).data('id');

    // Get the delete URL from the data-delete-url attribute
    const deleteUrl = $(this).data('delete-url');

    // Set the billing ID in the modal's Delete button for reference
    $('#confirmDelete').data('billing-id', billingId);

    // Show the delete confirmation modal
    $('#deleteConfirmationModal').modal('show');

    // Add a click event listener to the modal's Delete button
    $('#confirmDelete').click(function () {
        // Get the billing ID from the modal's Delete button
        const billingId = $(this).data('billing-id');

        // Get the CSRF token from the meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {
                _token: csrfToken, // Include the CSRF token
            },
            success: function (response) {
                if (response.success) {
                    console.log('Billing deleted successfully.');

                    location.reload();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Billing deleted successfully.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.error('Error deleting billing.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
            },
        });

        // Close the modal
        $('#deleteConfirmationModal').modal('hide');
    });
});

// Get all payment select elements and submit buttons
var paymentSelects = document.querySelectorAll(".paymentSelect");
var submitButtons = document.querySelectorAll(".btn-success");

// Add event listeners to each payment select element
paymentSelects.forEach(function (paymentSelect, index) {
    paymentSelect.addEventListener("change", function () {
        // Get the corresponding submit button for this row
        var submitButton = submitButtons[index];

        // Check if a payment method other than "Select payment method" is selected
        if (paymentSelect.value !== "Select payment method") {
            // Enable the corresponding submit button
            submitButton.disabled = false;
        } else {
            // Disable the corresponding submit button
            submitButton.disabled = true;
        }
    });
});

function calculateTotal() {
    let total = 0;
    const paymentRows = document.querySelectorAll("#paymentRows tr");

    paymentRows.forEach(row => {
        const amountCell = row.querySelector("td:last-child");
        if (amountCell) {
            const amountText = amountCell.textContent.trim();
            const amountValue = parseFloat(amountText.replace("₱", "").replace(/,/g, ""));
            if (!isNaN(amountValue)) {
                total += amountValue;
            }
        }
    });

    const totalAmountCell = document.getElementById("totalAmount");
    if (totalAmountCell) {
        // Format the total using toLocaleString()
        totalAmountCell.textContent = `${total.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`;
    }
}

// Call the calculateTotal function to calculate the initial total
calculateTotal();


$(document).ready(function () {
    // Add an event listener to the select element and date inputs
    $('select[name="client_id"]').change(function () {
        // Automatically submit the form when the user selects a client or enters a date range
        $('#filterForm').submit();
    });
});








