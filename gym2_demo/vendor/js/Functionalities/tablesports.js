// tableSports modal start
$('.tableSports').on('click', function () {
    checkTimerbutton(1)
    checkTimerbutton(2)
    checkTimerbutton(3)
});
// tableSports modal end

// Biljar timer start and stop
$('#formabutton_1').on('click', function (e) {
    manipulateTimer(1)
});

// Stolni nogomet timer start and stop
$('#formabutton_2').on('click', function (e) {
    manipulateTimer(2)
});

// Stolni tenis timer start and stop
$('#formabutton_3').on('click', function (e) {
    manipulateTimer(3)
});
