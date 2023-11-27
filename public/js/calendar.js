$(document).ready(function() {

    var today = moment().format('YYYY-MM-DD');
    // var currentDate = moment();

    // Helper function to render an event on the calendar
    // function renderEvent(event) {
    //     if (!addedEventIds.includes(event.id)) {
    //         calendar.fullCalendar('renderEvent', event);
    //         addedEventIds.push(event.id);
    //     }
    // }

    // var calendar = $('#calendar');
    // var addedEventIds = []; // Array to track added event IDs

    // // Function to disable past pickup times
    // function disablePastPickupTimes() {
    //     if (today === moment().format('YYYY-MM-DD')) {
    //         $('#pickUpTime option').each(function() {
    //             var optionValue = $(this).val();
    //             var optionTime = moment(optionValue, 'HH:mm');
                
    //             if (optionTime.isSameOrBefore(currentDate, 'minute')) {
    //                 $(this).prop('disabled', true);
    //             }
    //         });
    //     }
    // }

    // Fetch today's bookings and disable past pickup times
    // $.ajax({
    //     url: gettodaysBookingdate,
    //     type: 'GET',
    //     data: { date: today },
    //     dataType: 'json',
    //     success: function(response) {
    //         var todayBookings = response.bookings;
    //         disablePastPickupTimes();

    //         // Check if all pickup times are disabled
    //         if ($('#pickUpTime option:enabled').length === 0) {
    //             // Display an alert if all pickup times are disabled
    //             alert('All pickup times are disabled for today.');
    //         }
    //     },
    //     error: function(xhr, status, error) {
    //         console.error(error);
    //     }
    // });

    
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   

    $('#calendar').fullCalendar({
        height: 500,
        defaultView: 'month',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaDay,month,agendaWeek'
        },

        views: {
            agendaDay: {
                type: 'agendaDay',
                buttonText: 'today', // Customize the button text for agendaDay view
                slotLabelInterval: { days: 0 }, // Display slot labels every day
                slotDuration: { days: 31 }, // Set the slot duration to 1 day
                allDaySlot: true, // Enable the "all-day" slot
                allDayText: 'Todays booking' // Set the custom label for the "all-day" slot
            }
        },

       
       
        events: bookingEvents,
        selectable: true,
        selectHelper: true,

        dayRender: function (date, cell) {
            const today = moment().startOf('day'); // Start of today
            const selectedDate = moment(date).startOf('day'); // Start of the selected date
        
            if (selectedDate.isSameOrBefore(today)) {
                // Add the 'past-day' class to the cell for past dates or today
                cell.addClass('past-day');
            }
        },

        
        
        select: function(start, end, allDays) {

           
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
                success: function(response) {
                    if (response.fullyBooked) {
                       
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry, fully booked',
                            text: 'All trucks are already assigned for this date.',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false 
                        }).then((result) => {
                            $('#bookingModal').modal('hide'); // Hide the modal regardless of button click
                        });
                    }
                },
                
                error: function(xhr, status, error) {
                    // Handle the error, show an alert or message if needed
                    console.error(error);
                }
            });

            $.ajax({
                url: getAssignedCompaniesURL,
                type: "GET",
                data: { date: formattedDate},
                dataType: "json",
                success: function(response) {
                    var assignedCompanies = response.assignedCompanies;
                
                    // Reset the text for all options in the dropdown
                    $('#company_name option').each(function() {
                        var option = $(this);
                        option.text(option.text().replace(' (Assigned)', ''));
                    });
                
                    // Disable the options for the assigned companies
                    assignedCompanies.forEach(function(company) {
                        var option = $('#company_name option[value="' + company.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Assigned)');
                    });
                
                    // Check if the selected options are hidden
                    if ($('#company_name option:selected').is(true)) {
                        // Reset the selected option to the default "Select Company" option
                        $('#company_name').val('').trigger('change');
                    }
                
                    // // Show the booking modal if the options are available for the date
                    // $('#bookingModal').modal('toggle');
                },
                error: function(xhr, status, error) {
                    // Handle the error, show an alert or message if needed
                    console.error(error);
                }
                
            });

            $.ajax({
                url: getAssignedTruckURL,
                type: "GET",
                data: { date: formattedDate},
                dataType: "json",
                success: function(response) {
                    var assignedTruck1 = response.assignedTruck1;
                    var assignedTruck2 = response.assignedTruck2;
                
                    // Reset the text for all options in the dropdown
                    $('#truck_id option').each(function() {
                        var option = $(this);
                        option.text(option.text().replace(' (Assigned)', ''));
                    });
                
                    // Disable the options for the assigned trucks
                    assignedTruck1.forEach(function(truck) {
                        var option = $('#truck_id option[value="' + truck.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Assigned)');
                    });

                    // assignedTruck2.forEach(function(truck) {
                    //     var option = $('#truck_id option[value="' + truck.id + '"]');
                    //     option.prop('disabled', true);
                    //     option.text(option.text() + ' (Not Available)');
                    // });
                
                    // Check if the selected options are hidden
                    if ($('#truck_id option:selected').is(true)) {
                        
                        $('#truck_id').val('').trigger('change');
                    }
                    $('#bookingModal').modal('toggle');
                },
                error: function(xhr, status, error) {
                    // Handle the error, show an alert or message if needed
                    console.error(error);
                }
                
            });

            // $.ajax({
            //     url: getAssignedTruckURL,
            //     type: "GET",
            //     data: { date: formattedDate },
            //     dataType: "json",
            //     success: function (response) {
            //         var assignedTruck1 = response.assignedTruck1;
            //         var assignedTruck2 = response.assignedTruck2;
            
            //         // Reset the text and enable all options in the dropdown
            //         $('#truck_id option').each(function () {
            //             var option = $(this);
            //             option.text(option.text().replace(' (Assigned)', '').replace(' (Not Available)', ''));
                       
            //         });
            
            //         // Disable the options for the assigned trucks
            //         assignedTruck1.forEach(function (truck) {
            //             var option = $('#truck_id option[value="' + truck.id + '"]');
            //             option.prop('disabled', true);
            //             option.text(option.text() + ' (Assigned)');
            //         });
            
            //         // Check if the selected options are hidden
            //         if ($('#truck_id option:selected').is(true)) {
                        
            //             $('#truck_id').val('').trigger('change');
            //         }
            
                   
            //     },
            //     error: function (xhr, status, error) {
            //         // Handle the error, show an alert or message if needed
            //         console.error(error);
                    
            //     }
            // });
            

            
            $.ajax({
                url: getAssignedDriverURL,
                type: "GET",
                data: { date: formattedDate },
                dataType: "json",
                success: function(response) {
                    var assignedDriver = response.assignedDriver;
                    var assignedDriver2 = response.assignedDriver2;
                
                    // Reset the text for all options in the dropdown
                    $('#driver_id option').each(function() {
                        var option = $(this);
                        option.text(option.text().replace(' (Assigned)', ''));
                    });
                
                    // Disable the options for the assigned drivers
                    assignedDriver.forEach(function(driver) {
                        var option = $('#driver_id option[value="' + driver.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Assigned)');
                    });

                    // Disable the options for the assigned drivers
                    assignedDriver2.forEach(function(driver) {
                        var option = $('#driver_id option[value="' + driver.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Not Available)');
                    });
                
                    // Check if the selected options are hidden
                    if ($('#driver_id option:selected').is(true)) {
                        // Reset the selected option to the default "Select Driver" option
                        $('#driver_id').val('').trigger('change');
                    }
                    
                },
                error: function(xhr, status, error) {
                    // Handle the error, show an alert or message if needed
                    console.error(error);
                }
                
            });    

            $.ajax({
                url: getAssignedHelperURL,
                type: "GET",
                data: { date: formattedDate },
                dataType: "json",
                success: function(response) {
                    var assignedHelper = response.assignedHelper;
                    var Helper1 = response.assignedHelper1;
                
                    // Reset the text for all options in the dropdown
                    $('#helper_id option').each(function() {
                        var option = $(this);
                        option.text(option.text().replace(' (Assigned)', ''));
                    });
                
                    // Disable the options for the assigned helpers
                    assignedHelper.forEach(function(helper) {
                        var option = $('#helper_id option[value="' + helper.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Assigned)');
                    });

                     // Disable the options for the assigned helpers
                     Helper1.forEach(function(helper) {
                        var option = $('#helper_id option[value="' + helper.id + '"]');
                        option.prop('disabled', true);
                        option.text(option.text() + ' (Not Available)');
                    });
                
                    // Check if the selected options are hidden
                    if ($('#helper_id option:selected').is(true)) {
                        // Reset the selected option to the default "Select Helper" option
                        $('#helper_id').val('').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error, show an alert or message if needed
                    console.error(error);
                   
                }
                
                
            });
            
          

            $('#saveBtn').off('click').on('click', function () {

                // var now = moment();
                // var currentTime = now.format('HH:mm');
                // var isAllowedTime = moment(currentTime, 'HH:mm').isBetween('08:00', '18:00', 'HH:mm', '[]'); 

                // if (!isAllowedTime) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Invalid Booking Time',
                //         text: 'You can only book between 8 AM and 6 PM.',
                //         confirmButtonText: 'OK'
                //     });
                //     return;
                // }

                var company_name = $('#company_name').val();
                console.log({ UserId: company_name });
                var origin = $('#origin').val();
                console.log({ origin: origin})
                var driver = $('#driver_id').val();
                console.log({ driverId: driver})
                var helper = $('#helper_id').val();
                console.log({ helperId: helper})
                var truck = $('#truck_id').val();
                console.log({ truckId: truck})
                var destination = $('#destination').val();
                console.log({ destination: destination})
                var date = moment(start).format('YYYY-MM-DD');
                console.log({ pickUpDate: date})
                var transportationDate = $('#trasportationDate').val();
                console.log({ transportationDate: transportationDate })

                $.ajax({
                    url: bookingForClientURL,
                    type: "POST",
                    dataType: "json",
                    data: {
                        company_name,
                        origin,
                        destination,
                        transportationDate,
                        date,
                        driver,
                        helper,
                        truck
                    },
                    success: function(response) {
                        $('#bookingModal').modal('hide');
                        
                        $('#calendar').fullCalendar('renderEvent', {
                            'company': response.title,
                            'start': date,
                            'color': response.color 
                        });

                        location.reload();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Booking Success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            for (var key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Please try again later.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
            
            
        },

        editable: true,
        eventDrop: function(event, delta, revertFunc) {
            // Check if the event has a past date
            if (moment(event.start).isBefore(moment(), 'day')) {
                // Revert the event to its original position
                revertFunc();
                return;
            }

            var id = event.id;
            var transportation_date = moment(event.start).format('YYYY-MM-DD');

            $.ajax({
                url: getCalendarUpdateURL + '/' + id,
                type: "PATCH",
                dataType: "json",
                data: { transportation_date: transportation_date },
                success: function(response) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Booking Updated',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
            
        },

        
        eventClick: function(event) {
            // Format the date using moment.js to "month day, year" format
            var formattedDate = moment(event.start).format('YYYY-MM-DD');

           
            if (event.status === 0) {
                // Show the assign modal for events with status 0
                $('#assignModal').modal('show');
                // Populate the assign modal with event details
                $('#modal_booking_id').text(event.id);
                $('#modal_booking_date').text(formattedDate);
                $('#modal_booking_title').text(event.title);
                $('#modal_booking_origin').text(event.origin);
                $('#modal_booking_destination').text(event.destination);
                $('#modal_booking_pickUpTime').text(event.pickUpTime);
                $('#modal_booking_transportation_time').text(event.transportationTime);
                $('#modal_booking_status').text(event.status);

                // Get the selected date in the "YYYY-MM-DD" format
                var date = event.start.format('YYYY-MM-DD');
                var tDate = event.start.format('MMMM D, YYYY');
               
                $('#date').val(tDate);

                $.ajax({
                    url: getAssignedDriverForClientURL,
                    type: "GET",
                    data: { date: date },
                    dataType: "json",
                    success: function(response) {
                        var assignedDriverForClients = response.assignedDriverForClients;
                    
                        // Reset the text for all options in the dropdown
                        $('#driver option').each(function() {
                            var option = $(this);
                            option.text(option.text().replace(' (Assigned)', ''));
                        });
                    
                        // Disable the options for the assigned drivers
                        assignedDriverForClients.forEach(function(drivers) {
                            var option = $('#driver option[value="' + drivers.id + '"]');
                            option.prop('disabled', true);
                            option.text(option.text() + ' (Assigned)');
                        });
                    
                        // Check if the selected options are hidden
                        if ($('#driver option:selected').is(true)) {
                            // Reset the selected option to the default "Select Driver" option
                            $('#driver').val('').trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error, show an alert or message if needed
                        console.error(error);
                    }
                    
                });  

                $.ajax({
                    url: getAssignedHelperURL,
                    type: "GET",
                    data: { date: date },
                    dataType: "json",
                    success: function(response) {
                        var assignedHelper = response.assignedHelper;
            
                        // Hide the options for the assigned companies
                        assignedHelper.forEach(function(helpers) {
                            var option = $('#helper option[value="' + helpers.id + '"]');
                            option.prop('disabled', true);
                            option.text(option.text() + ' (Assigned)');
                        });
                                          
            
                        // Check if the selected options are hidden
                        if ($('#helper option:selected').is(true)) {
                            // Reset the selected option to the default "Select Company" option
                            $('#helper').val('').trigger('change');
                        }
            
                    },
                    error: function(xhr, status, error) {
                        // Handle the error, show an alert or message if needed
                        console.error(error);
                        $('#bookingModal').modal('toggle');
                    }
                    
                });

                

                $('#saveBtn1').off('click').on('click', function () { 
                    var booking_id = $('#booking_id').val();
                    console.log(booking_id)
                    var driver = $('#driver').val();
                    console.log(driver)
                    var helper = $('#helper').val();
                    console.log(helper)
                    var truck = $('#truck').val();
                    console.log(truck)

                    $.ajax({
                        url: getAssignedTruck,
                        type: "GET",
                        data: { date: formattedDate },
                        dataType: "json",
                        success: function (response) {
                            var assignedTruck1 = response.assignedTruck1;
                            var assignedTruck2 = response.assignedTruck2;
                    
                            // Reset the text and enable all options in the dropdown
                            $('#truck option').each(function () {
                                var option = $(this);
                                option.text(option.text().replace(' (Assigned)', '').replace(' (Not Available)', ''));
                               
                            });
                    
                            // Disable the options for the assigned trucks
                            assignedTruck1.forEach(function (truck) {
                                var option = $('#truck option[value="' + truck.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Assigned)');
                            });
                    
                            assignedTruck2.forEach(function (truck) {
                                var option = $('#truck option[value="' + truck.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Not Available)');
                            });
                    
                            // Check if the selected options are hidden
                            if ($('#truck option:selected').is(true)) {
                                
                                $('#truck').val('').trigger('change');
                            }
                    
                           
                        },
                        error: function (xhr, status, error) {
                            // Handle the error, show an alert or message if needed
                            console.error(error);
                            
                        }
                    });
                    
        
                    
                    $.ajax({
                        url: getAssignedDriverURL,
                        type: "GET",
                        data: { date: formattedDate },
                        dataType: "json",
                        success: function(response) {
                            var assignedDriver = response.assignedDriver;
                            var assignedDriver2 = response.assignedDriver2;
                        
                            // Reset the text for all options in the dropdown
                            $('#driver option').each(function() {
                                var option = $(this);
                                option.text(option.text().replace(' (Assigned)', ''));
                            });
                        
                            // Disable the options for the assigned drivers
                            assignedDriver.forEach(function(driver) {
                                var option = $('#driver option[value="' + driver.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Assigned)');
                            });
        
                            // Disable the options for the assigned drivers
                            assignedDriver2.forEach(function(driver) {
                                var option = $('#driver option[value="' + driver.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Not Available)');
                            });
                        
                            // Check if the selected options are hidden
                            if ($('#driver option:selected').is(true)) {
                                // Reset the selected option to the default "Select Driver" option
                                $('#driver').val('').trigger('change');
                            }
                            
                        },
                        error: function(xhr, status, error) {
                            // Handle the error, show an alert or message if needed
                            console.error(error);
                        }
                        
                    });    
        
                    $.ajax({
                        url: getAssignedHelperURL,
                        type: "GET",
                        data: { date: formattedDate },
                        dataType: "json",
                        success: function(response) {
                            var assignedHelper = response.assignedHelper;
                            var Helper1 = response.assignedHelper1;
                        
                            // Reset the text for all options in the dropdown
                            $('#helper option').each(function() {
                                var option = $(this);
                                option.text(option.text().replace(' (Assigned)', ''));
                            });
                        
                            // Disable the options for the assigned helpers
                            assignedHelper.forEach(function(helper) {
                                var option = $('#helper option[value="' + helper.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Assigned)');
                            });
        
                             // Disable the options for the assigned helpers
                             Helper1.forEach(function(helper) {
                                var option = $('#helper option[value="' + helper.id + '"]');
                                option.prop('disabled', true);
                                option.text(option.text() + ' (Not Available)');
                            });
                        
                            // Check if the selected options are hidden
                            if ($('#helper option:selected').is(true)) {
                                // Reset the selected option to the default "Select Helper" option
                                $('#helper').val('').trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle the error, show an alert or message if needed
                            console.error(error);
                           
                        }
                    });


                    $.ajax({
                        url: bookingFromClient,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            booking_id: booking_id,
                            driver: driver,
                            helper: helper,
                            truck: truck
                        },
                        success: function(response) {
                            $('#assignModal').modal('hide');
                            
                            $('#calendar').fullCalendar('renderEvent', {
                                'title': response.title,
                                'start': date,
                                'color': response.color 
                            });

                            location.reload();

                            
                           
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Booking Updated',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Please Complete Input for driver, helper, and truck',
                              })
                        }
                    });

                    
                });

                document.getElementById("booking_id").value = event.id;
                document.getElementById("modal_booking_title").value = event.title;
                document.getElementById("modal_booking_origin").value = event.origin;
                document.getElementById("modal_booking_destination").value = event.destination;
                const formattedTransportationDate = moment(event.transportationDate).format('MMMM D, YYYY');
                document.getElementById("modal_booking_transportation_date").value = formattedTransportationDate;
                var statusInput = document.getElementById("modal_booking_status");

                // Set the initial value based on the status variable
                var status = 0; // You can change this value as needed
                if (status === 0) {
                    statusInput.value = "Pre Booking";
                }
                
            } else {
                // Show the default modal for other events
                $('#eventDetailsModal').modal('show');
                $('#modal_date').text(moment(event.start).format('MMMM D, YYYY'));
                $('#modal_company_name').text(event.title);
                $('#modal_company_id').text(event.id);
                $('#modal_origin').text(event.origin);
                const formattedtransportationDate= moment(`${event.date} ${event.transportationTime}`, 'YYYY-MM-DD').format('MMMM D, YYYY');
                $('#modal_transportationDate').text(formattedtransportationDate);
                
                
                $('#modal_destination').text(event.destination);
                $('#modal_driver').text(event.driver);
                $('#modal_helper').text(event.helper);
                $('#modal_truck').text(event.truck);

                // Define a mapping of status values to their corresponding labels
                const bookingStatus = {
                    1: 'Approved',
                    2: 'Approved',
                    3: 'Approved',
                    4: 'Approved',
                    5: 'Approved',
                    6: 'Approved',
                    7: 'Approved',
                };

                const perishablesStatusLabels = {
                    1: 'To be pick-up',
                    2: 'Picked-up',
                    3: 'Departure',
                    4: 'Delivery on the way',
                    5: 'Delivered',
                    6: 'Delivered',
                    7: 'Delivered',
                }
                // Get the corresponding label from the mapping
                const bookingStatus1 = bookingStatus[event.status];

                // Get the corresponding label from the mapping
                const pershablestatusLabel = perishablesStatusLabels[event.status];

                $('#modal_status').text(bookingStatus1);
                $('#modal_status_perishable').text(pershablestatusLabel);
                // Populate other event details as needed
                }

                
                
            },
            

        });
        
    });

    

    var calendar = $('#calendar');
    var addedEventIds = []; // Array to track added event IDs

    // Function to render an event on the calendar
    function renderEvent(event) {
        if (!addedEventIds.includes(event.id)) {
            calendar.fullCalendar('renderEvent', event);
            addedEventIds.push(event.id);
        }
    }

    $.ajax({
        url: getBookingsClientURL,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Loop through the fetched bookings and render events
                response.bookings.forEach(function(booking) {
                    var formattedDate = moment(booking.date).format('YYYY-MM-DD'); // Format without time
                    var event = {
                        id: booking.id,
                        title: booking.user.name,
                        origin: booking.origin,
                        destination: booking.destination,
                        start: formattedDate,
                        status: booking.status,
                        color: booking.color // Use the color information from the booking, if available
                    };
                    // Check if the event with the same ID is already on the calendar
                    var existingEvent = calendar.fullCalendar('clientEvents', booking.id);
                    if (existingEvent.length === 0) {
                        renderEvent(event); // Render the event
                    }
                });
            }
        },
    });

     // Get the current date in the format required by the min attribute
     var currentDate = new Date().toISOString().split('T')[0];

     // Set the min attribute of the input element to the current date
     document.getElementById('trasportationDate').min = currentDate;
  