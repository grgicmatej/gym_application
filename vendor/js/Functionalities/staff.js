// staffSettings modal start
$('.staffSettings').on('click', function () {
    $("#staffSettings").modal('show');
});

$('#formformaStaffSettingsPassword').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'Staff/passwordChange/',
        data: $('#formformaStaffSettingsPassword').serialize(),
        success: function () {
            $("#staffSettings").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Nova lozinka je uspješno postavljena.');
            });
            clearInput();
        }
    });
});

$('#formformaStaffSettingsData').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'Staff/dataChange/',
        data: $('#formformaStaffSettingsData').serialize(),
        success: function () {
            $("#staffSettings").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Novi podaci su uspješno spremljeni.');
            });
        },
        error: function () {
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            });

        }
    });
});
// staffSettings modal end