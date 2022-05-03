$('#loginform').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'login/login/',
        data: $('#loginform').serialize(),
        success: function (response) {
            if (response === 'false'){
                document.getElementById('invalidDataNotice').style.display = 'block';
            }else{
                window.location = urlAddress + 'Dashboard/dashboardCheck';
            }
            clearInput(1000, 'loginform');
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

/*
$('#contactform').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'contact/contact/',
        data: $('#contactform').serialize(),
        success: function (response) {
            if (response === 'true'){
                document.getElementById('invalidDataNotice').style.display = 'block';
            }else{
                document.getElementById('invalidDataNotice2').style.display = 'block';
            }
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
 */
