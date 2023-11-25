
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
        $('#damageDatatables').DataTable();
    });
    $(document).ready(function () {
        $('#table').DataTable();
    });
    
   
    $(document).ready(function() {
        $('.datatable').DataTable();
    });

    $(document).ready(function() {
        $('.payroll').DataTable();
    });

    $(document).ready(function() {
        $('.damageDatatable').DataTable();
    });

    $(document).ready(function () {
        // Initialize the DataTable
        var table = $('#transportationReports').DataTable({
            "searching": false, // Hide the default search box
            "lengthChange": false, // Hide the show entries dropdown
        });
    });

    $(document).ready(function () {
        // Initialize the DataTable
        var table = $('#payrollReports').DataTable({
            "searching": false, // Hide the default search box
            "lengthChange": false, // Hide the show entries dropdown
        });
    });

    
    
    

    $(document).ready(function () {
        // Initialize the DataTable
        var table = $('#paymentReports').DataTable({
            "searching": false, // Hide the default search box
            "lengthChange": false, // Hide the show entries dropdown
        });
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

function displaySelectedPhoto(input) {
    const photoPreview = document.getElementById('photoPreview');
    photoPreview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            photoPreview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function displaySelectedPhotoHelper(input) {
    const photoPreviewHelper = document.getElementById('photoPreviewHelper');
    photoPreviewHelper.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            photoPreviewHelper.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}







