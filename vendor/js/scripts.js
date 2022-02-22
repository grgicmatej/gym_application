/*
    ajax primjer start
$.ajax({
    method: "POST",
    data: {imepodatka: podatak},
    url: urlAddress + 'User/addUserArrival/' + id,
    success: function (response) { // staviti response ako je url upit vratio neki podatak
        response = JSON.parse(response) // isto kao komentar gore
    },
    error: function () {

    }
});
    ajax primjer kraj
*/


$('#testgumb').on('click', function () {
    document.getElementById("test12").style.display = "block";
});

//gumb radi za pojavljivanje opcija, treba to finesirati, neki fade in napravit