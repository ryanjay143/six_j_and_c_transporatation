document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetInputId = this.getAttribute('data-target');
            const inputElement = document.getElementById(targetInputId);
            const iconElement = this.querySelector('i');

            if (inputElement && iconElement) {
                if (inputElement.type === 'password') {
                    inputElement.type = 'text';
                    iconElement.classList.remove('bi-eye-slash-fill');
                    iconElement.classList.add('bi-eye');
                } else {
                    inputElement.type = 'password';
                    iconElement.classList.remove('bi-eye');
                    iconElement.classList.add('bi-eye-slash-fill');
                }
            }
        });
    });
});

$(document).ready(function() {
    // Initialize the DataTables for each modal when it's shown
    $('.cashAdvanceModal').on('shown.bs.modal', function () {
        var modal = $(this);
        var modalId = modal.data('modal-id');
        var tableId = 'cashAdvanceDetails_' + modalId;
        $('#' + tableId).DataTable();
    });
});

$(document).ready(function() {
    // Initialize the DataTables for each modal when it's shown
    $('.DamageModal').on('shown.bs.modal', function () {
        var modal = $(this);
        var modalId = modal.data('modal-id');
        var tableId = 'damageDetails_' + modalId;
        $('#' + tableId).DataTable();
    });
});


function confirmDisable(employeeId, rowId) {
    Swal.fire({
        title: 'Are you sure want to disabled this employee?',
        showCancelButton: true,
        confirmButtonText: 'Yes, disable',
        cancelButtonText: 'Cancel',
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            // Replace :employeeId with the actual employeeId
            var url = disableDriver.replace(':employeeId', employeeId);

            // AJAX request using the generated URL
            $.ajax({
                url: url,
                method: 'GET', // Use the appropriate HTTP method
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Disabled!', 'The employee has been disabled.', 'success');

                        // Update the status in the table row
                        var statusCell = document.querySelector(`#${rowId} .status-cell`);
                        statusCell.innerHTML = '<span class="badge text-bg-danger">Inactive</span>';

                        // Disable the "Disable" button
                        var disableButton = document.querySelector(`#${rowId} .btn-outline-danger`);
                        disableButton.disabled = true;

                        // Enable the "Enable" button
                        var enableButton = document.querySelector(`#${rowId} .btn-outline-success`);
                        enableButton.disabled = false;

                        // Update the status in the table row
                        var statusCell = document.querySelector(`#${rowId} .status-cell`);
                        statusCell.innerHTML = '<span class="badge text-bg-danger">Inactive</span>';

                        // Reorganize the rows based on status
                        reorganizeRows();
                    } else {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        }
    });
}

function confirmEnable(employeeId, rowId) {
    Swal.fire({
        title: 'Are you sure you want to enable this employee?',
        showCancelButton: true,
        confirmButtonText: 'Yes, enable',
        cancelButtonText: 'Cancel',
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            // Replace :employeeId with the actual employeeId
            var url = enableDriver.replace(':employeeId', employeeId);

            // AJAX request using the generated URL
            $.ajax({
                url: url,
                method: 'GET', // Use the appropriate HTTP method
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Enabled!', 'The employee has been enabled.', 'success');

                        // Update the status in the table row
                        var statusCell = document.querySelector(`#${rowId} .status-cell`);
                        statusCell.innerHTML = '<span class="badge text-bg-success">Active</span>';

                        // Disable the "Enable" button
                        var enableButton = document.querySelector(`#${rowId} .btn-outline-success`);
                        enableButton.disabled = true;

                        // Enable the "Disable" button
                        var disableButton = document.querySelector(`#${rowId} .btn-outline-danger`);
                        disableButton.disabled = false;

                       // Update the status in the table row
                        var statusCell = document.querySelector(`#${rowId} .status-cell`);
                        statusCell.innerHTML = '<span class="badge text-bg-success">Active</span>';

                        // Reorganize the rows based on status
                        reorganizeRows();
                    } else {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        }
    });
}

function reorganizeRows() {
    var tableBody = document.querySelector('table tbody');
    var rows = Array.from(tableBody.children);

    // Separate active and inactive rows
    var activeRows = [];
    var inactiveRows = [];

    rows.forEach((row) => {
        var statusCell = row.querySelector('.status-cell .badge');
        if (statusCell.textContent === 'Active') {
            activeRows.push(row);
        } else {
            inactiveRows.push(row);
        }
    });

    // Combine active and inactive rows with active rows first
    var sortedRows = activeRows.concat(inactiveRows);

    // Append the sorted rows back to the table
    tableBody.innerHTML = ''; // Clear the current table
    sortedRows.forEach((row) => {
        tableBody.appendChild(row);
    });
}


$(document).ready(function() {
    $('#profile_photo_input').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#old_photo').html('<img src="' + e.target.result + '" alt="New Profile Photo" style="max-width: 200px; max-height: 200px;">');
            };
            reader.readAsDataURL(file);
        }
    });
});

$(document).ready(function () {
    $('#dashboardforDriver').DataTable();
});

$(document).ready(function () {
    $('#datatable1').DataTable();
});

$(document).ready(function () {
    $('#datatable2').DataTable();
});


