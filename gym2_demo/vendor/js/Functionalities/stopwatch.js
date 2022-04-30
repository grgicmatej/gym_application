// stopwatch start
var stopwatchInterval = 0;

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
            document.getElementById('formabutton_'+sportId).innerHTML = response === true ? 'Pokreni štopericu' : 'Zaustavi štopericu';
            if (response === true){
                document.getElementById('podatakProtekloVrijeme_'+sportId).innerHTML = '';
            }else {
                $.ajax({
                    url: urlAddress + 'Aditional/checkStartedTime',
                    method: "POST",
                    data: {Timers_Sport_Id: sportId},
                    success: function (data) {
                        response = JSON.parse(data)

                        document.getElementById('podatakProtekloVrijeme_'+sportId).innerHTML = 'Početak štoperice: ' + formatTime(response['Timers_Start_Time']);
                    },
                    error: function () {
                        warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                    }
                });
            }
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
    fadeIn("#tableSports")
}

function manipulateTimer(sportId){
    $.ajax({
        url: urlAddress + 'Aditional/manipulateTimer',
        method: "POST",
        data: {Timers_Sport_Id: sportId},
        success: function (response) {
            response = JSON.parse(response)
            if (response === true){
                $.ajax({
                    url: urlAddress + 'Aditional/checkStartedTime',
                    method: "POST",
                    data: {Timers_Sport_Id: sportId},
                    success: function (response) {
                        response = JSON.parse(response) // ovo je početno vrijeme, koristiti za neku drugu verziju
                        checkTimerbutton(sportId)
                        document.getElementById('podatakStart_'+sportId).innerHTML = '* Korištenje u tijeku'

                        successNotification('Štoperica je uspješno pokrenuta')
                        fadeOut("#tableSports")
                    },
                    error: function () {
                        warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
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
                        fadeOut("#tableSports")
                        fadeIn("#tableSportsCheckout")

                        $.ajax({
                            url: urlAddress + 'Aditional/checkSportsName',
                            method: "POST",
                            data: {Sport_Settings_Sport_Id: sportId},
                            success: function (data) {
                                data = JSON.parse(data)
                                document.getElementById('sportsName').innerHTML = data["Sport_Settings_Name"]
                                document.getElementById('ProtekloVrijeme').innerHTML = 'Ukupno vrijeme: '+response["TimeDifference"]+' '+'minuta'
                                document.getElementById('SportNaplata').innerHTML = 'Ukupna naplata: <b>'+response["TotalPrice"]+' '+'kn </b>'
                                document.getElementById('podatakProtekloVrijeme_'+sportId).innerHTML = '';
                            },
                            error: function (){
                                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                            }
                        });
                    },
                    error: function () {
                        warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                    }
                });
            }
        }
    });
}

$('#sportsCheckout').on('click', function () {
    infoNotification('Štoperica je restartirana i spremna za ponovno korištenje.')
    fadeOut("#tableSportsCheckout")
});
// stopwatch end
