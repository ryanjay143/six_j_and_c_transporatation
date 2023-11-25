// Initialize arrays to store driver and helper names
var driverNames = [];
var helperNames = [];

// Iterate through table rows and collect driver and helper names
$("#transportationReports tbody tr").each(function () {
    var driverName = $(this).find("td:eq(1)").text(); // Assuming the driver name is in the second column (index 1)
    var helperName = $(this).find("td:eq(2)").text(); // Assuming the helper name is in the third column (index 2)

    driverNames.push(driverName);
    helperNames.push(helperName);
});

// Remove duplicates from the driver and helper names arrays (if needed)
var uniqueDriverNames = [...new Set(driverNames)];
var uniqueHelperNames = [...new Set(helperNames)];

// Add event listeners for driver and helper selections
$(document).ready(function () {
    var driverSelect = $("#driverSelect");
    var helperSelect = $("#helperSelect");
    

    driverSelect.on("change", filterTable);
    helperSelect.on("change", filterTable);

    function filterTable() {
        var selectedDriver = driverSelect.val();
        var selectedHelper = helperSelect.val();

        $("#transportationReports tbody tr").each(function () {
            var driverName = $(this).find("td:eq(1)").text(); // Assuming the driver name is in the second column (index 1)
            var helperName = $(this).find("td:eq(2)").text(); // Assuming the helper name is in the third column (index 2)

            var driverMatch = selectedDriver === "Select driver" || driverName === selectedDriver;
            var helperMatch = selectedHelper === "Select helper" || helperName === selectedHelper;

            if (driverMatch && helperMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});


$(document).ready(function() {
    $('#date').on('change', function() {
        var selectedDate = $(this).val();
        console.log(selectedDate)
        
        // Loop through each row in the table and hide/show based on the selected date
        $('#transportationReports tbody tr').each(function() {
            var deliveryDate = $(this).find('td:first-child').text(); // Assuming the date is in the first column
            
            if (deliveryDate === selectedDate) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
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
    $('input[name="deliveredDate"]').change(function () {
        // Submit the form when the input field is changed
        $('#filterFormDate').submit();
    });
});

