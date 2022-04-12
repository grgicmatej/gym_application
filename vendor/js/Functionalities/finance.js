$('.finance').on('click', function () {
    fadeIn("#finance");

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/yearlyStats/',
        success: function (responseCurrentYear) {
            $.ajax({
                method: "POST",
                data: {},
                url: urlAddress + 'Statistics/yearlyStatsPreviousYear/',
                success: function (responsePreviousYear) {
                    drawActiveUsersGraph(responseCurrentYear, responsePreviousYear)
                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

});