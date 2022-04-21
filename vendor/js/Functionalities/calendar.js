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
                backgroundColor: calendarFieldColor
            })}
            fadeIn("#eventCalendar")

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
                            fadeIn("#eventCalendarDetails")
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
                                        fadeOut("#eventCalendarDetails")
                                        fadeOut("#eventCalendar")
                                        successNotification('Uspješno otkazan termin.')
                                        loadEvents()
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
                                        fadeOut("#eventCalendarDetails")
                                        fadeOut("#eventCalendar")
                                        successNotification('Uspješno potvrđen dolazak.')
                                        loadEvents()
                                        calendar.destroy();
                                    }
                                });
                            });

                            $('.editEvent').on('click', function () {
                                fadeIn("#editCalendarEvent")
                                $("#Event_Contact_Name_Edit").val(response["Event_Contact_Name"]);
                                $("#Event_Contact_Phone_Edit").val(response['Event_Contact_Phone']);
                                $("#Event_Start_Time_Edit").val(formatDateWithLine(response['Event_Start_Time'])+'T'+formatTime(response['Event_Start_Time']));
                                $("#Event_End_Time_Edit").val(formatDateWithLine(response['Event_End_Time'])+'T'+formatTime(response['Event_End_Time']));

                                $("#updateEventCalendarCancel").html("<a class='updateEventCancel'><span class='btn btn-block btn-outline-secondary'>Odustani</span></a>");
                                $("#updateEventCalendarConfirm").html("<input type='hidden' name='Event_Id' value='"+id+"' ><input type='submit' class='m-b-10 f-w-600 btn btn-block btn-outline-info' form='updateEventForm' value='Spremi termin'>");

                                $('.updateEventCancel').on('click', function () {
                                    fadeOut("#editCalendarEvent")
                                });

                                $('#updateEventForm').on('submit', function (e) {
                                    e.preventDefault();
                                    $.ajax({
                                        method: 'POST',
                                        data: $('#updateEventForm').serialize(),
                                        url: urlAddress + 'Calendar/updateEvent/'+id,
                                        success: function () {
                                            fadeOut('#editCalendarEvent')
                                            fadeOut('#eventCalendarDetails')
                                            fadeOut('#eventCalendar')
                                            successNotification('Uspješno izmijenjen termin.')
                                            loadEvents()
                                            clearInput(1000, 'updateEventForm');
                                            },
                                        error: function (){
                                            fadeOut('#editCalendarEvent')
                                            fadeOut('#eventCalendarDetails')
                                            fadeOut('#eventCalendar')
                                            warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
                                        }
                                    });
                                });
                            });
                        },
                        error: function () {
                            fadeOut("#eventCalendarDetails")
                            warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
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
            fadeOut("#eventCalendar")
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
        }
    });
});
// event calendar end

// new event start
$('.newCalendarEvent').on('click', function () {
    fadeIn("#newCalendarEvent")
});

$('#newEventForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        method: 'POST',
        data: $('#newEventForm').serialize(),
        url: urlAddress + 'Calendar/newEvent',
        success: function () {
            fadeOut("#newCalendarEvent")
            fadeOut("#eventCalendar")
            successNotification('Uspješno spremljen termin.');
            loadEvents()
            clearInput(1000, 'newEventForm');
        },
        error: function (){
            fadeOut("#newCalendarEvent")
            fadeOut("#eventCalendar")
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
        }
    });
});

$('#newEventCancel').on('click', function () {
    fadeOut("#newCalendarEvent")
});
// new event end

// load events start
function loadEvents(){
    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Calendar/checkCalendarToday',
        success: function (response) {
            if (response.length > 2){
                response = JSON.parse(response);
                const searchData = document.getElementById('EventsData');

                searchData.innerHTML = response.reduce((options, {Event_Id, EventHourStart, EventHourEnd, Event_Contact_Name}) =>
                        options += `
                                <tr style="border-bottom: 1px dotted gray; padding-bottom: 10px">
                                    <td class="text-right rowPadding" id=""><i class="fas fa-circle circleColor"></i></td>
                                    <td class="text-left rowPadding" id="" style="padding-left: 10px">${Event_Contact_Name}</td>
                                    <td class="text-center rowPadding" id="">Početak: ${EventHourStart}h</td>
                                    <td class="text-center rowPadding" id="">Završetak: ${EventHourEnd}h</td>
                                    <td class="text-right rowPadding successColor confirmEvent" id="i_${Event_Id}"><i class="fas fa-check"></i></td>
                                </tr>
                               
                                `,
                    ``);
            }else {
                $("#EventsData").html("<p class='text-center' style='font-size: 18px'>Nema rezerviranih termina.</p>");
            }

        }
    });
}
// load events end


// confirm event
$(document).ajaxComplete(function () {
    $('.confirmEvent').on('click', function () {
        var id = $(this).attr('id');
        id = id.split('_')[1];

        $.ajax({
            method: "POST",
            data: {Event_Id: id},
            url: urlAddress + 'Calendar/confirmEvent',
            success: function () {
                successNotification('Uspješno potvrđen dolazak.')
                loadEvents()
            },
            error: function () {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
            }
        });
    });
});
