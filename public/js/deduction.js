$(document).ready(function() {
    var max_fields = 10; // Maximum allowed input fields
    var wrapper = $("#input_fields_wrap"); // Input fields wrapper
    var add_button = $("#add_field"); // Add button ID

    var x = 1; // Initial field counter

    // Add input field on button click
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(`
            <div class="row ">
                <div class="form-outline col-md-4">
                    <input class="form-control form-control-sm" id="form12" type="text" name="name[]"/>
                    <label class="form-label" for="form12">Description</label>
                </div>
                <div class="form-outline col-md-4">
                    <input class="form-control form-control-sm" id="form12" type="number" name="email[]">
                    <label class="form-label" for="form12">Enter Deduction Price</label>
                </div>
                <div class="col mb-3">
                    <button type="button" class="btn btn-sm btn-danger remove_field">Remove</button>
                </div>
            </div>
            `);
        }
    });

    // Remove input field on button click
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
        x--;
    });
});


$('.update-status-button').click(function () {
    var button = $(this);
    var id = button.data('id');
    var updateStatusRoute = button.data('route');
   

    $.ajax({
        type: 'POST',
        url: updateStatusRoute,
        data: {
            _token: csrfToken, // Send the CSRF token in the request
        },
        success: function (data) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Paid Successfully',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
            // Update the UI as needed, for example:
            button.text(data.newStatus);
        },
        error: function (data) {
            alert('An error occurred');
        }
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

    var startDateInputCopy = document.querySelector('#start_date_input_copy input');
    var endDateInputCopy = document.querySelector('#end_date_input_copy input');

    // Set default values based on the day of the month
    if (currentDay <= 15) {
        // If the day is 1-15, set default values for the entire month
        startDateInputCopy.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-01';
        endDateInputCopy.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-15';
    } else {
        // If the day is 16-30 or 31, set default values for the entire month
        startDateInputCopy.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-16';

        // Set the end_date to the last day of the current month
        var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        endDateInputCopy.value = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + lastDay;
    }
});