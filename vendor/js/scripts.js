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

window.onload = function loadData(){
    loadEvents()
}
