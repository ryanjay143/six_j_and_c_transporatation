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


// Function to print the table
document.getElementById("printButton").addEventListener("click", function () {
    printJS({
        printable: "billingReports", // The ID of the table to print
        type: "html",
        header: "Billing Reports",
    });
});

// Function to generate a PDF
window.addEventListener('load', function () {
    const doc = new jsPDF();
    doc.text("Billing Reports", 10, 10);
    doc.autoTable({ html: "#billingReports" });
    doc.save("billing_reports.pdf");
});


