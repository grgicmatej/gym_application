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

var url_string = window.location.href;
var url = new URL(url_string);
var m = url.searchParams.get("m");
if (m === '1'){
    $(window).on('load', function() {
        fadeIn("#myModal")
        document.getElementById('invalidDataNotice0').style.display = 'block';
    });
}

if (m === '0'){
    $(window).on('load', function() {
        fadeIn("#myModal")
        document.getElementById('invalidDataNotice3').style.display = 'block';
    });
}

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
