window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
    

    $(document).ready(function () {
        var table = $('#payroll').DataTable();
    
        // Destroy the DataTable instance before reinitializing
        if ($.fn.DataTable.isDataTable('#payroll')) {
            table.destroy();
        }
    
        // Reinitialize the DataTable
        $('#payroll').DataTable({
            "pageLength": 25
            // Add other DataTable options here if needed
        });

        $('#payment').DataTable({
            "pageLength": 25
            // Add other DataTable options here if needed
        });
    });

    $(document).ready(function () {
        $('#example').DataTable();
    });

    $(document).ready(function () {
        $('#examples').DataTable();
    });
    
    $(document).ready(function () {
        $('#examples1').DataTable();
    });
    $(document).ready(function () {
        $('#examples2').DataTable();
    });
    $(document).ready(function () {
        $('#table').DataTable();
    });


});


function setMinDate() {
    // Get the input element by its ID
    const dateInput = document.getElementById('floatingInput');

    // Check if the element is found
    if (dateInput) {
        // Get the current date in the "yyyy-MM-dd" format
        const currentDate = new Date().toISOString().split('T')[0];

        // Set the min attribute of the input to the current date
        dateInput.setAttribute('min', currentDate);
    }
}

// Call the function initially to set the minimum date on page load
setMinDate();

lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'showImageNumberLabel': false, // Hide the image number label
    'alwaysShowNavOnTouchDevices': true, // Show navigation arrows on touch devices
    'disableScrolling': false // Allow scrolling while lightbox is open
});

// JavaScript (you need to include this in your HTML, typically at the end of the body tag)
document.addEventListener('DOMContentLoaded', function () {
    const lightbox = new SimpleLightbox('.zoomable-image');
});





function printForm() {
    var printContent = document.getElementById("printableForm").innerHTML;
    var originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();

    document.body.innerHTML = originalContent;
}



function generatePDF() {
    var doc = new jsPDF();

    var printableForm = document.getElementById("printableForm");

    // Set PDF properties
    doc.setProperties({
        title: 'Form PDF',
    });

    // Convert the printableForm content to HTML
    var htmlContent = printableForm.innerHTML;

    // Generate PDF from HTML content
    doc.fromHTML(htmlContent, 15, 15, {
        width: 170,
        callback: function (doc) {
            // Save the PDF
            doc.save('form.pdf');
        },
    });
}

// Function to print the table
document.getElementById("printButton").addEventListener("click", function () {
    printJS({
        printable: "billingReports",
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