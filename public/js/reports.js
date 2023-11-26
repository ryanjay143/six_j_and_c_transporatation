$(document).ready(function () {
    // Initialize DataTable
    var table = $("#transportationReports").DataTable({
        searching: false,
        lengthChange: false,
        paging: false 
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Get references to the select elements
    var driverSelect = document.getElementById('driverSelect');
    var helperSelect = document.getElementById('helperSelect');
    var plateNumberSelect = document.getElementById('plateNumberSelect');
    
    // Get reference to the table body
    var tableBody = document.getElementById('transportationReports').getElementsByTagName('tbody')[0];
    
    // Attach event listeners to the select elements
    driverSelect.addEventListener('change', filterTable);
    helperSelect.addEventListener('change', filterTable);
    plateNumberSelect.addEventListener('change', filterTable);
    
    // Function to filter the table based on selected values
    function filterTable() {
        var selectedDriver = driverSelect.value;
        var selectedHelper = helperSelect.value;
        var selectedPlateNumber = plateNumberSelect.value;

        // Loop through each row in the table
        for (var i = 0, row; row = tableBody.rows[i]; i++) {
            var driverName = row.cells[1].innerText;
            var helperName = row.cells[2].innerText;
            var plateNumber = row.cells[4].innerText;

            // Check if the row should be displayed based on the selected filters
            var displayRow = (selectedDriver === 'Select driver' || driverName === selectedDriver) &&
                             (selectedHelper === 'Select helper' || helperName === selectedHelper) &&
                             (selectedPlateNumber === 'Select plate number' || plateNumber === selectedPlateNumber);

            // Show or hide the row accordingly
            row.style.display = displayRow ? '' : 'none';
        }
    }
});

$(document).ready(function () {
    // Initialize the DataTable
    var table = $('#paymentReports').DataTable({
        language: {
            search: "Search Invoice or OR number:"
        },
    });

    // Add custom CSS for the search input
    $('#paymentReports_filter input').css({
        'font-size': '14px',
        'border': '1px solid #847E7D'
    });

    // Calculate and display the formatted total payment amount
    calculateTotal();

    // Recalculate total on draw event (search, pagination, etc.)
    table.on('draw', function () {
        calculateTotal();
    });

    // Function to calculate the total payment amount
    function calculateTotal() {
        var total = 0;

        // Iterate through each row in the table body
        $('#paymentRows tr').each(function () {
            var amountString = $(this).find('td:last-child').text().trim().replace('₱', '').replace(',', '');
            var amount = parseFloat(amountString);

            // Check if the amount is a valid number
            if (!isNaN(amount)) {
                total += amount;
            }
        });

        // Format and update the total amount in the table footer with .00
        $('#totalPaymentAmount').text('₱ ' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }
});


$(document).ready(function () {
    // Initialize the DataTable
    var table = $('#billingReports').DataTable({
        language: {
            search: "Search Invoice Number:"
        },
        
    });

    // Add custom CSS for the search input
    $('#billingReports_filter input').css({
        'font-size': '14px', // Adjust the font size as needed
        'border': '1px solid #847E7D' // Set the border color to black
    });

    // Set custom placeholder for the search input
    $('#billingReports_filter input').attr('placeholder', 'INV-0-000000000000');
    $('#billingReports_filter label').css('font-size', '15px');

    // Function to update the total amount
    function updateTotalAmount() {
        var totalAmount = 0;

        // Iterate through the visible rows after search
        table.rows({ search: 'applied' }).every(function () {
            var data = this.data();
            var amount = parseFloat(data[4].replace(/[^\d.-]/g, '')); // Assuming the total amount is in the 5th column (index 4)

            totalAmount += amount;
        });

        // Format the total amount with commas and two decimal places
        var formattedTotalAmount = totalAmount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        // Update the content of the totalAmountCell with formatted currency
        $('#totalAmountCell').html('<strong>&#8369; ' + formattedTotalAmount + '</strong>');
    }

    // Call the updateTotalAmount function initially
    updateTotalAmount();

    // Listen for DataTable search events to recalculate the total amount after a search
    table.on('search', function () {
        updateTotalAmount();
    });

    // Listen for DataTable draw events to recalculate the total amount on every draw
    table.on('draw', function () {
        updateTotalAmount();
    });
});


// Wait for the DOM to be ready
$(document).ready(function () {
    // Select the input field with the name 'deliveredDate'
    $('select[name="helper_id"]').change(function () {
        // Submit the form when the input field is changed
        $('#filterFormDate').submit();
    });
});