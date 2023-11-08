import flatpickr from 'flatpickr'; // Import flatpickr using ES modules syntax
import 'flatpickr/dist/flatpickr.min.css'; // Import flatpickr CSS using ES modules syntax

document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d" // Customize the date format as per your needs
    });
});
