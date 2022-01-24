// stopwatch start
var stopwatchInterval = 0;
function startStopWatch(sportId){
    let prevTime, elapsedTime = 0;

    var updateTime = function () {
        var tempTime = elapsedTime;
        var milliseconds = tempTime % 1000;
        tempTime = Math.floor(tempTime / 1000);
        var seconds = tempTime % 60;
        tempTime = Math.floor(tempTime / 60);
        var minutes = tempTime % 60;
        tempTime = Math.floor(tempTime / 60);
        var hours = tempTime % 60;

        var time = hours + " : " + minutes + " : " + seconds;

        document.getElementById('podatakProtekloVrijeme_'+sportId).innerHTML = 'Proteklo vrijeme: '+time
    };

    stopwatchInterval = setInterval(function () {
        if (!prevTime) {
            prevTime = Date.now();
        }

        elapsedTime += Date.now() - prevTime;
        prevTime = Date.now();

        updateTime();
    }, 1000);
}

function stopStopWatch(){
    clearInterval(stopwatchInterval)
}

function checkTimerbutton(sportId){
    document.getElementById('formabutton_'+sportId).innerHTML = ''
    $.ajax({
        url: urlAddress + 'Aditional/checkTimer',
        method: "POST",
        data: {Timers_Sport_Id: sportId},
        success: function (data) {
            response = JSON.parse(data)
            if (response === true){
                var stopWatchValue = 'Pokreni štopericu'
            }else {
                var stopWatchValue = 'Zaustavi štopericu'
            }
            document.getElementById('formabutton_'+sportId).innerHTML = stopWatchValue
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $("#tableSports").modal('show');
}

function manipulateTimer(sportId){
    $.ajax({
        url: urlAddress + 'Aditional/manipulateTimer',
        method: "POST",
        data: {Timers_Sport_Id: sportId},
        success: function (response) {
            response = JSON.parse(response)
            if (response === true){ // pokrenuta štoperica
                $.ajax({
                    url: urlAddress + 'Aditional/checkStartedTime',
                    method: "POST",
                    data: {Timers_Sport_Id: sportId},
                    success: function (response) {
                        response = JSON.parse(response) // ovo je početno vrijeme, koristiti za neku drugu verziju
                        startStopWatch(sportId)
                        checkTimerbutton(sportId)
                        document.getElementById('podatakStart_'+sportId).innerHTML = '* Korištenje u tijeku'

                        successNotification('Štoperica je uspješno pokrenuta')
                        $("#tableSports").fadeOut(1500, function () {
                            $(this).modal('hide');
                        });
                    }
                });
            }else { // zaustavljena štoperica
                stopStopWatch()
                $.ajax({
                    url: urlAddress + 'Aditional/checkTotalTime',
                    method: "POST",
                    data: {Timers_Sport_Id: sportId},
                    success: function (response) {
                        response = JSON.parse(response)

                        checkTimerbutton(sportId)
                        document.getElementById('podatakStart_'+sportId).innerHTML = ''
                        document.getElementById('podatakProtekloVrijeme_'+sportId).innerHTML = ''
                        successNotification('Štoperica je uspješno zaustavljena')
                        $("#tableSports").fadeOut(1500, function () {
                            $(this).modal('hide');
                        });
                        $("#tableSportsCheckout").modal('show');

                        $.ajax({
                            url: urlAddress + 'Aditional/checkSportsName',
                            method: "POST",
                            data: {Sport_Settings_Sport_Id: sportId},
                            success: function (data) {
                                data = JSON.parse(data)
                                document.getElementById('sportsName').innerHTML = data["Sport_Settings_Name"]
                                document.getElementById('ProtekloVrijeme').innerHTML = 'Ukupno vrijeme: '+response["TimeDifference"]+' '+'minuta'
                                document.getElementById('SportNaplata').innerHTML = 'Ukupna naplata: <b>'+response["TotalPrice"]+' '+'kn </b>' // formatirati
                            },
                            error: function (){
                                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                            }
                        });
                    }
                });
            }
        }
    });
}

$('#sportsCheckout').on('click', function () {
    infoNotification('Štoperica je restartirana i spremna za ponovno korištenje.')
    $("#tableSportsCheckout").fadeOut(1500, function () {
        $(this).modal('hide');
    });
});
// stopwatch end