 // Show SweetAlert2 alert
 Swal.fire({
    icon: 'warning',
    title: 'You must log in first!',
    text: 'Please log in to continue.',
}).then(function(result) {
    // Show the login modal after the alert is closed
    $('#exampleModal').modal('show');
});