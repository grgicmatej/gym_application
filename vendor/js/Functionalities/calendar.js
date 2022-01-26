// event calendar start
$('.eventCalendar').on('click', function () {
    $.ajax({
        method: "POST",
        url: urlAddress + 'Calendar/checkCalendar/',
        success: function (response) {

            response = JSON.parse(response)

            var events = [];
            for(var i =0; i < response.length; i++)
            {events.push( {
                title: response[i]["Event_Contact_Name"],
                start: new Date(response[i]["EventYearStart"], (response[i]["EventMonthStart"]-1), response[i]["EventDayStart"], response[i]["EventHourStart"], 0, 0),
                end: new Date(response[i]["EventYearEnd"], (response[i]["EventMonthEnd"]-1), response[i]["EventDayEnd"], response[i]["EventHourEnd"], 0, 0),
                allday: false,
                id: response[i]["Event_Id"],
                backgroundColor: '#16A2B8'
            })}

            $("#eventCalendar").modal('show');

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {

                eventClick: function(info) {

                    var id = info.event.id
                    $.ajax({
                        method: "POST",
                        data: {data: id},
                        url: urlAddress + 'Calendar/checkCalendarDetails/',
                        success: function (response) {
                            response = JSON.parse(response)
                            $("#eventCalendarDetails").modal('show');

                            $("#Event_Contact_Name").text(response["Event_Contact_Name"]);
                            $("#Event_Contact_Phone").text(response['Event_Contact_Phone']);
                            $("#Event_Start_Time").text(formatDate(response['Event_Start_Time'])+' '+formatTime(response['Event_Start_Time']));
                            $("#Event_End_Time").text(formatDate(response['Event_End_Time'])+' '+formatTime(response['Event_End_Time']));

                            $("#editEventCalendar").html("<span class='editEvent editEventButton' id='editEvent"+id+"' ><i class=\"fal fa-edit\"></i></span>");
                            $("#eventCalendarCancel").html("<a class='eventCancel' id='eventCancel_"+id+"'><span class='btn btn-block btn-outline-secondary'>Otkazivanje</span></a>");
                            $("#eventCalendarConfirm").html("<a><span class='btn btn-block btn-outline-info eventConfirm' id='eventConfirm_"+id+"' >Potvrda dolaska</span></a>");

                            $('.eventCancel').on('click', function () {
                                var id = $(this).attr('id');
                                id = id.split('_')[1];

                                $.ajax({
                                    method: "POST",
                                    data: {Event_Id: id},
                                    url: urlAddress + 'Calendar/removeEvent',
                                    success: function () {
                                        $("#eventCalendarDetails").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $("#eventCalendar").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $(this).fadeIn(400, function notification() {
                                            successNotification('Uspješno otkazan termin.')
                                        });
                                        calendar.destroy();
                                    }
                                });
                            });

                            $('.eventConfirm').on('click', function () {
                                var id = $(this).attr('id');
                                id = id.split('_')[1];

                                $.ajax({
                                    method: "POST",
                                    data: {Event_Id: id},
                                    url: urlAddress + 'Calendar/confirmEvent',
                                    success: function () {
                                        $("#eventCalendarDetails").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $("#eventCalendar").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $(this).fadeIn(400, function notification() {
                                            successNotification('Uspješno potvrđen dolazak.')
                                        });
                                        calendar.destroy();
                                    }
                                });
                            });

                            $('.editEvent').on('click', function () {
                                $("#editCalendarEvent").modal('show');
                                $("#Event_Contact_Name_Edit").val(response["Event_Contact_Name"]);
                                $("#Event_Contact_Phone_Edit").val(response['Event_Contact_Phone']);
                                $("#Event_Start_Time_Edit").val(formatDateWithLine(response['Event_Start_Time'])+'T'+formatTime(response['Event_Start_Time']));
                                $("#Event_End_Time_Edit").val(formatDateWithLine(response['Event_End_Time'])+'T'+formatTime(response['Event_End_Time']));

                                $("#updateEventCalendarCancel").html("<a class='updateEventCancel'><span class='btn btn-block btn-outline-secondary'>Otkazivanje</span></a>");
                                $("#updateEventCalendarConfirm").html("<input type='hidden' name='Event_Id' value='"+id+"' ><input type='submit' class='m-b-10 f-w-600 btn btn-block btn-outline-info' form='updateEventForm' value='Spremi termin'>");

                                $('.updateEventCancel').on('click', function () {
                                    $("#editCalendarEvent").fadeOut(800, function () {
                                        $(this).modal('hide');
                                    });
                                });

                                $('#updateEventForm').on('submit', function (e) {
                                    e.preventDefault();
                                    $.ajax({
                                        method: 'POST',
                                        data: $('#updateEventForm').serialize(),
                                        url: urlAddress + 'Calendar/updateEvent/'+id,
                                        success: function () {
                                            $("#editCalendarEvent").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $("#eventCalendarDetails").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $("#eventCalendar").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $(this).fadeIn(400, function notification() {
                                                successNotification('Uspješno izmijenjen termin.');
                                            });
                                            clearInput(1000);
                                            },
                                        error: function (){
                                            $("#editCalendarEvent").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $("#eventCalendarDetails").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $("#eventCalendar").fadeOut(800, function () {
                                                $(this).modal('hide');
                                            });
                                            $(this).fadeIn(400, function notification() {
                                                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
                                            });
                                        }
                                    });
                                });

                            });

                        },
                        error: function () {
                            $("#eventCalendarDetails").fadeOut(800, function () {
                                $(this).modal('hide')
                            });
                            $(this).fadeIn(400, function notification() {
                                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
                            });
                        }
                    });
                },
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',

                events: events,
                editable  : false,
                droppable : false,
            });
            setTimeout(() => {  calendar.render(); }, 500);
        },
        error: function () {
            $("#eventCalendar").fadeOut(800, function () {
                $(this).modal('hide')
            });
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
            });
        }
    });
});
// event calendar end

// new event start
$('.newCalendarEvent').on('click', function () {
    $("#newCalendarEvent").modal('show');
});

$('#newEventForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        method: 'POST',
        data: $('#newEventForm').serialize(),
        url: urlAddress + 'Calendar/newEvent',
        success: function () {
            $("#newCalendarEvent").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $("#eventCalendar").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Uspješno spremljen termin.');
            });
            clearInput(1000);
        },
        error: function (){
            $("#newCalendarEvent").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $("#eventCalendar").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
            });
        }
    });
});

$('#newEventCancel').on('click', function () {
    $("#newCalendarEvent").fadeOut(800, function () {
        $(this).modal('hide');
    });
});
// new event end