// soccer calendar start
$('.soccerCalendar').on('click', function () {
    $.ajax({
        method: "POST",
        url: urlAddress + 'Calendar/checkCalendar/',
        success: function (response) {

            response = JSON.parse(response)

            var events = [];
            for(var i =0; i < response.length; i++)
            {events.push( {
                title: response[i]["Soccer_Contact_Name"],
                start: new Date(response[i]["SoccerYearStart"], (response[i]["SoccerMonthStart"]-1), response[i]["SoccerDayStart"], response[i]["SoccerHourStart"], 0, 0),
                end: new Date(response[i]["SoccerYearEnd"], (response[i]["SoccerMonthEnd"]-1), response[i]["SoccerDayEnd"], response[i]["SoccerHourEnd"], 0, 0),
                allday: false,
                id: response[i]["Soccer_Id"],
                backgroundColor: '#16A2B8'
            })}

            $("#soccerCalendar").modal('show');

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
                            $("#soccerCalendarDetails").modal('show');

                            $("#Soccer_Contact_Name").text(response["Soccer_Contact_Name"]);
                            $("#Soccer_Contact_Phone").text(response['Soccer_Contact_Phone']);
                            $("#Soccer_Start_Time").text(formatDate(response['Soccer_Start_Time'])+' '+formatTime(response['Soccer_Start_Time']));
                            $("#Soccer_End_Time").text(formatDate(response['Soccer_End_Time'])+' '+formatTime(response['Soccer_End_Time']));

                            $("#SoccerCalendarCancel").html("<a class='SoccerCancel' id='SoccerCancel_"+id+"'><span class='btn btn-block btn-outline-secondary'>Otkazivanje termina</span></a>");
                            $("#SoccerCalendarConfirm").html("<a><span class='btn btn-block btn-outline-primary SoccerConfirm' id='SoccerConfirm_"+id+"' >Potvrda dolaska</span></a>");


                            $('.SoccerCancel').on('click', function () {
                                var id = $(this).attr('id');
                                id = id.split('_')[1];

                                $.ajax({
                                    method: "POST",
                                    data: {Soccer_Id: id},
                                    url: urlAddress + 'Calendar/removeEvent',
                                    success: function () {
                                        $("#soccerCalendarDetails").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $("#soccerCalendar").fadeOut(800, function () {
                                            $(this).modal('hide');
                                        });
                                        $(this).fadeIn(400, function notification() {
                                            successNotification('Uspješno otkazan termin.')
                                        });
                                        calendar.destroy();
                                    }
                                });
                            });
                        },
                        error: function () {
                            $("#soccerCalendarDetails").fadeOut(800, function () {
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
            $("#soccerCalendar").fadeOut(800, function () {
                $(this).modal('hide')
            });
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
            });
        }
    });
});
// soccer calendar end