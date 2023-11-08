function validateForm() {
  var driverId = document.getElementById('driver_id').value;
  var helperId = document.getElementById('helper_id').value;
  var truckId = document.getElementById('truck_id').value;

  if (driverId === '' || helperId === '' || truckId === '') {
      return false; // Prevent form submission
  }
}

// Enable/disable the button based on select values
var selectElements = document.querySelectorAll('select');
var submitButton = document.getElementById('submit-button');

selectElements.forEach(function(selectElement) {
  selectElement.addEventListener('change', function() {
      var driverId = document.getElementById('driver_id').value;
      var helperId = document.getElementById('helper_id').value;
      var truckId = document.getElementById('truck_id').value;

      if (driverId !== '' && helperId !== '' && truckId !== '') {
          submitButton.disabled = false; // Enable the button
      } else {
          submitButton.disabled = true; // Disable the button
      }
  });
});


var statusSelect = document.getElementById('status');
    var updateStatusButton = document.getElementById('updateStatusButton');

    statusSelect.addEventListener('change', function() {
        if (statusSelect.value === '2' || statusSelect.value === '3') {
            updateStatusButton.removeAttribute('disabled');
        } else {
            updateStatusButton.setAttribute('disabled', 'disabled');
        }
    });
    
    