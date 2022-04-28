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
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});