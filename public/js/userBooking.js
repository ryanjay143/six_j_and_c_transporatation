$(document).ready(function () {

    var today = moment().format('YYYY-MM-DD');
    var currentDate = moment();

    // Fetch today's bookings from your data source (modify this part according to your data retrieval method)
    $.ajax({
        url: gettodaysBookingdate, // Replace with your API endpoint
        type: 'GET',
        data: { date: today },
        dataType: 'json',
        success: function (response) {
            // Extract the pickup times from the response (modify this according to your API structure)
            var todayBookings = response.bookings;

            // Loop through the select options
            $('#pickUpTime option').each(function () {
                var optionValue = $(this).val();

                // Check if the pickup time is for today
                if (today === moment().format('YYYY-MM-DD')) {
                    // Check if the pickup time is in the past
                    var optionTime = moment(optionValue, 'HH:mm');
                    if (optionTime.isSameOrBefore(currentDate, 'minute')) {
                        // Disable the option if the pickup time has passed for today
                        $(this).prop('disabled', true);
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
    
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
            $('#transportationDate').val(date);

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
                var destination = $('#destination').val();
                var pickUpTime = $('#pickUpTime').val();
                var transportationTime = $('#transportationTime').val();
                var date = moment(start).format('YYYY-MM-DD');
                console.log(date)

                $.ajax({
                    url: addBooking,
                    type: "POST",
                    datatype: 'json',
                    data: {
                        origin, destination, date, pickUpTime, transportationTime
                    },
                    success: function (response) {
                        $('#clientBooking').modal('hide')
                        $('#calendar').fullCalendar('renderEvent', {
                            'id': response.id,
                            'title': response.status === 0 ? 'Booked' : 'Pre-booking',
                            'date': response.date,
                            'origin': response.origin,
                            'destination': response.destination,
                            'pickUpTime': response.pickUpTime,
                            'transportationTime': response.transportationTime
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
                            $('#pickUpTimeError').html(error.responseJSON.errors.pickUpTime);
                            $('#transportationTimeError').html(error.responseJSON.errors.transportationTime);
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
                        
                        // Format the pick-up time as 12-hour time (AM/PM)
                        const formattedPickUpTime = moment(event.pickUpTime, 'HH:mm').format('hh:mm A');
                        $('#pickUp_time').text('Pick-up time: ' + formattedPickUpTime);
                        
                        $('#booking_destination').text('Destination: ' + event.destination);
                        const formattedTransportationTime = moment(event.transportationTime, 'HH:mm').format('hh:mm A');
                        $('#transportation_time').text('Transportation time: ' + formattedTransportationTime);
                    } else {
                        $('#detailsModal').modal('show');
                        $('#booking_title').text(event.name);
                        $('#booking_date').text(moment(event.date).format('MMMM D, YYYY'));
                        $('#modal_booking_origin').text(event.bookingOrigin);
                        const formattedPickUpTime = moment(event.bookingPickUpTime, 'HH:mm').format('hh:mm A');
                        $('#modal_pickUp_time').text(formattedPickUpTime);
                        $('#modal_booking_destination').text(event.destination);
                        const formattedTransportationTime = moment(event.transportationTime, 'HH:mm').format('hh:mm A');
                        $('#modal_transportation_time').text(formattedTransportationTime);
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
        if (!addedEventIds.includes(event.id)) {
            calendar.fullCalendar('renderEvent', event);
            addedEventIds.push(event.id);
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
                        var formattedDate = moment(transportation.booking.date).format('YYYY-MM-DD');
                        var color = approved === 'Booked' ? 'green' : '';
    
                        var status = transportation.status;
                        var statusText = '';
    
                        if (status == 1) {
                            statusText = 'To be picked up';
                        } else if (status == 2) {
                            statusText = 'Picked up';
                        } else if (status == 3) {
                            statusText = 'Departure';
                        }  else if (status == 4) {
                            statusText = 'Delivery on the way';
                        } else if (status == 5 || status == 6 || status == 7) {
                            statusText = 'Delivered';
                        } else {
                            statusText = 'Unknown';
                        }
    
                        var event = {
                            id: transportation.id,
                            title: approved,
                            name: transportation.booking.user.name,
                            bookingOrigin: transportation.booking.origin,
                            destination: transportation.booking.destination,
                            date: formattedDate,
                            status: transportation.status,
                            color: color,
                            bookingPickUpTime: transportation.booking.pick_up_time,
                            transportationTime: transportation.booking.transportation_time,
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

