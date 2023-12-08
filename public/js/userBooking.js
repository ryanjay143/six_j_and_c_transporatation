$(document).ready(function () {

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#calendar').fullCalendar({
        height: 473,
        defaultView: 'month',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaDay,agendaWeek'
        },

        views: {
            agendaDay: {
                type: 'agendaDay',
                buttonText: 'today',
                slotLabelInterval: { days: 0 }, 
                slotDuration: { days: 31 },
                allDaySlot: true,
                allDayText: 'Todays booking' 
            }
        },
        events: bookingEvents,
        selectable: true,
        selectHelper: true,

       

        viewRender: function (view, element) {
            // Check if the view is month view (you can adjust this condition based on your needs)
            if (view.name === 'month') {
                // Fetch transportation data for the new month
                fetchTransportationData(view.start, view.end);
            }
        },

        dayRender: function (date, cell) {
            const today = moment().startOf('day'); // Start of today
            const selectedDate = moment(date).startOf('day'); // Start of the selected date
        
            if (selectedDate.isSameOrBefore(today)) {
                // Add the 'past-day' class to the cell for past dates or today
                cell.addClass('past-day');
            }
        },
       
        
        select: function (start, end, allDays) {
            const today = moment();
            const selectedDate = moment(start);
           

            if (start.isBefore(moment(), 'day')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date',
                    text: 'You cannot book events in the past.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (start.day() === 0) {
                // Display an error message using a popup
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Book on Sunday',
                    text: 'Sorry, you cannot book for transportation on Sundays.',
                    confirmButtonText: 'OK'
                });
                return; // Exit the function, preventing further execution
            }
            
            var formattedDate = start.format('YYYY-MM-DD');

            var date = start.format('MMMM D, YYYY');
            $('#pickUpDate').val(date);

            $.ajax({
                url: checkFullyBookedURL,
                type: "GET",
                data: { date: formattedDate },
                dataType: "json",
                success: function (response) {
                    if (response.fullyBooked) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry, fully booked',
                            text: 'All trucks are already assigned for this date.',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then((result) => {
                            $('#clientBooking').modal('hide');
                        });
                
                        var highlightedDate = start.format('YYYY-MM-DD');
                        if (highlightedDate) {
                            var dayElement = $('.fc-day[data-date="' + highlightedDate + '"]');
                            
                            // Add a class to style the background as red
                            dayElement.addClass('red-background');
                            
                            // Add a label to indicate it's fully booked
                            dayElement.find('.fc-day-number').text('Fully booked');
                        }
                    }
                },
                
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

            // Check if a booking already exists for the selected day
            // const events = $('#calendar').fullCalendar('clientEvents');

            // for (const event of events) {
            //     if (event.date === selectedDate.format('YYYY-MM-DD')) {
            //         bookingExistsForSelectedDay = true;
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Booking Already Exists',
            //             text: 'Your booking already exists for this day.',
            //             confirmButtonText: 'OK'
            //         });
            //         return;
            //     }
            // }

            // If no booking exists and it's not a past date, show the booking modal
            $('#clientBooking').modal('toggle');

            // Unbind the click event for #saveBtn to prevent multiple bindings
            $('#saveBtn').off('click').on('click', function () {
                var origin = $('#origin').val();
                console.log(origin)
                var destination = $('#destination').val();
                console.log(destination)
                var transportationDate = $('#transportationDate').val();
                console.log(transportationDate)
                var date = moment(start).format('YYYY-MM-DD');
                console.log(date)

                $.ajax({
                    url: addBooking,
                    type: "POST",
                    datatype: 'json',
                    data: {
                        origin, destination, date, transportationDate
                    },
                    success: function (response) {
                        $('#clientBooking').modal('hide')
                        $('#calendar').fullCalendar('renderEvent', {
                            'id': response.id,
                            'title': response.status === 0 ? 'Booked' : 'Pre-booking',
                            'date': response.pickUp_date,
                            'origin': response.origin,
                            'destination': response.destination,
                            'transportationDate': response.transportationDate
                        });

                        location.reload();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Booking Success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function (error) {
                        if (error.responseJSON.errors) {
                            $('#originError').html(error.responseJSON.errors.origin);
                            $('#destinationError').html(error.responseJSON.errors.destination);
                            $('#transportationDateError').html(error.responseJSON.errors.transportationDate);
                        }
                    }

                })

            });
        },
        eventClick: function (event) {

            $.ajax({
                url: getDetailsUrl.replace(':id', event._id),
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (event.status === 0) {
                        $('#userModal').modal('show');
                        $('#booking_id').text('Booking ID: ' + event.id);
                        $('#modal_booking_date').text('Transportation date: ' + moment(event.start).format('MMMM D, YYYY'));
                        $('#booking_origin').text('Origin: ' + event.origin);
                        
                       
                        $('#booking_destination').text('Destination: ' + event.destination);
                        const formattedTransportationDate = moment(event.transportationDate).format('MMMM D, YYYY');
                        $('#transportationDate').text('Transportation date: ' + formattedTransportationDate);
                    } else {
                        $('#detailsModal').modal('show');
                        $('#booking_title').text(event.name);
                        $('#booking_date').text(moment(event.date).format('MMMM D, YYYY'));
                        $('#modal_booking_origin').text(event.bookingOrigin);
                        $('#modal_booking_destination').text(event.destination);
                        const formattedTransportationDate = moment(event.transportationDate).format('MMMM D, YYYY');
                        $('#modal_transportationDate').text(formattedTransportationDate);
                        $('#modal_driver').text(event.driverName);
                        $('#modal_helper').text(event.helperName);
                        $('#modal_truck').text(event.truck);
                        $('#modal_booking_status').text(event.bookingStatus);
                        $('#modal_booking_transportation_status').text(event.transportationStatus);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    })

    var calendar = $('#calendar');
    var addedEventIds = [];

    function renderEvent(event) {
        const existingEvent = calendar.fullCalendar('clientEvents', event.id);
    
        if (existingEvent.length === 0) {
            calendar.fullCalendar('renderEvent', event);
        }
    }
    

    function fetchTransportationData(startDate, endDate) {
        $.ajax({
            url: getTransportationClientURL,
            method: 'GET',
            data: {
                startDate: startDate.format('YYYY-MM-DD'),
                endDate: endDate.format('YYYY-MM-DD'),
            },
            success: function (events) {
                if (events.success) {
                    events.transportations.forEach(function (transportation) {
                        var driver = transportation.employee.user.name + ' ' + transportation.employee.user.lname;
                        var helper = transportation.helper.user.name + ' ' + transportation.helper.user.lname;
                        var approved = transportation.booking && transportation.booking.status === 1 ? 'Booked' : 'N/A';
                        var bookedStatus = transportation.booking && transportation.booking.status === 1 ? 'Booked' : 'N/A';
                        var formattedDate = moment(transportation.booking.pickUp_date).format('YYYY-MM-DD');
                        var color = approved === 'Booked' ? 'green' : '';
    
                        var status = transportation.status;
                        var statusText = '';
    
                        if (status == 1) {
                            statusText = 'To be pick-up';
                        } else if (status == 2) {
                            statusText = 'Picked up';
                        } else if (status == 3) {
                            statusText = 'Departed';
                        }  else if (status == 4) {
                            statusText = 'In transit';
                        } else if (status == 5 || status == 6 || status == 7) {
                            statusText = 'Delivered';
                        } else {
                            statusText = 'Unknown';
                        }
    
                        var eventDate = moment(transportation.booking.pickUp_date).format('YYYY-MM-DD');
                        var event = {
                            id: transportation.id,
                            title: approved,
                            name: transportation.booking.user.name,
                            bookingOrigin: transportation.booking.origin,
                            destination: transportation.booking.destination,
                            date: eventDate, // Use the modified date without time
                            status: transportation.status,
                            color: color,
                            transportationDate: transportation.booking.transportation_date,
                            driverName: driver,
                            helperName: helper,
                            bookingStatus: bookedStatus,
                            transportationStatus: statusText,
                            truck: transportation.truck.truck_type + ' - ' + transportation.truck.plate_number
                        };

    
                        var existingEvent = calendar.fullCalendar('clientEvents', transportation.id);
                        if (existingEvent.length === 0) {
                            renderEvent(event);
                        }
                    });
                }
            },
            error: function (error) {
                console.error(error);
            },
        });
    }

    

    
});

function updateOriginReadOnly() {
    var originInput = document.getElementById("origin");
    var destinationInput = document.getElementById("destination");
    var transportationDateInput = document.getElementById("transportationDate");

    originInput.readOnly = false; // Enable origin input
    destinationInput.ariaDisabled = true; // Make destination input readonly
    transportationDateInput.readOnly = true; // Make transportationDate input readonly
}

document.getElementById("destination").addEventListener("change", function() {
    var originInput = document.getElementById("origin");
    var destinationInput = document.getElementById("destination");
    var transportationDateInput = document.getElementById("transportationDate");

    originInput.readOnly = false; // Enable origin input
    destinationInput.readOnly = false; // Enable destination input
    transportationDateInput.readOnly = false; // Enable transportationDate input
});

// Call the function initially to set the initial state
updateOriginReadOnly();

 // Get the current date in the format required by the min attribute
 var currentDate = new Date().toISOString().split('T')[0];

 // Set the min attribute of the input element to the current date
 document.getElementById('transportationDate').min = currentDate;

 function updateDestinationReadOnly() {
    var originSelect = document.getElementById('origin');
    var destinationSelect = document.getElementById('destination');

    // Check if a valid origin is selected
    if (originSelect.value !== "" && originSelect.value !== "Select Origin") {
        // Enable the destination select
        destinationSelect.disabled = false;
    } else {
        // If no valid origin is selected, disable the destination select
        destinationSelect.disabled = true;
    }
}

function updateTransportationDate() {
    // Get the value of the pick-up date input
    var pickUpDateValue = document.getElementById("pickUpDate").value;

    // Set the value of the transportation date input to the pick-up date value
    document.getElementById("transportationDate").value = pickUpDateValue;
}