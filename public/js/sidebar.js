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

});



// $(document).ready(function () {
//     $('#example').DataTable();
// });

// $(document).ready(function () {
//     $('#examples').DataTable();
// });

// $(document).ready(function () {
//     $('#examples1').DataTable();
// });
// $(document).ready(function () {
//     $('#examples2').DataTable();
// });
// $(document).ready(function () {
//     $('#table').DataTable();
// });