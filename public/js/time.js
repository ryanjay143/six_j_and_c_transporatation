// // Get the current time
// var now = new Date();
// var currentHour = now.getHours();

// // Add 1 hour to the current time for the allowance
// currentHour += 1;

// // Disable options for times that have already passed
// var selectElement = document.getElementById("pickUpTime");
// var options = selectElement.getElementsByTagName("option");

// for (var i = 1; i < options.length; i++) {
//     var optionValue = parseInt(options[i].value);
//     if (currentHour >= optionValue) {
//         options[i].disabled = true;
//     }
// }
