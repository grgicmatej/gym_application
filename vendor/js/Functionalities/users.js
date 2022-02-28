// profileData modal
$(document).ajaxComplete(function () {
    $('.profileData').on('click', function () {
        var id = $(this).attr('id');
        if (id) {
            id = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {data: id},
                url: urlAddress + 'User/viewUser/' + id,
                success: function (response) {
                    response = JSON.parse(response);

                    $("#profileData").modal('show');
                    $("#email").text(response["Users_Email"]);
                    $("#id").text(response["Users_Id"].split('-').pop());
                    $("#usersName").text(response["Users_Name"] + " " + response["Users_Surname"]);
                    $("#usersPhone").text(response["Users_Phone"]);
                    $("#membershipName").text(response["Users_Memberships_Membership_Name"]);
                    $("#status").text(response["Users_Status"]);
                    $("#birthday").text(formatDate(response["Users_Birthday"]));
                    $("#membershipDuration").text(formatDate(response["Users_Memberships_Start_Date"]) + "  -  " + formatDate(response["Users_Memberships_End_Date"]));
                    $("#numberOfArrivals").text("Broj dolazaka ovaj tjedan: " + response["countrow"]);

                    $("#confirmArrival").html("<a><span class='btn btn-block btn-outline-info' >Potvrda dolaska</span></a>");
                    globalVariable = response["Users_Id"];
                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        }
    });
});
// profileData modal end


// arrivalCounter
$('.potvrdidolazak').on('click', function () {
    var id = globalVariable;
    $.ajax({
        method: "POST",
        data: {data: id},
        url: urlAddress + 'User/addUserArrival/' + id,
        success: function () {
            $("#profileData").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Uspješno potvrđen dolazak.')
            });
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// arrivalCounter end

// Registration of new user
$('.newUserRegistration').on('click', function () {
    $("#newUserRegistration").modal('show');
});

$('#formformaNewUser').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'User/addNewUser/',
        data: $('#formformaNewUser').serialize(),
        success: function () {
            $("#newUserRegistration").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Uspješno registriran korisnik.');
            });
            clearInput(1000);
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// Registration of new user end

// Additional user settings start
function checkMembershipPause(){
    var id = globalVariable;
    $.ajax({
        method: "POST",
        data: {userId: id},
        url: urlAddress + 'User/checkPausedMembership/',
        success: function (response) {
            response=JSON.parse(response)
            if (response === true){
                $("#additionalUserSettingsUserMembershipPauseButton").text('Zamrzavanje članarine');
            }else{
                $("#additionalUserSettingsUserMembershipPauseButton").text('Nastavak članarine');
            }
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
}

$('#additionalUserSettingsButton').on('click', function () {
    if (document.getElementById('additionalUserSettings').style.display === "none"){
        $('#additionalUserSettings').fadeIn('slow', function () {});
        checkMembershipPause()
    }else {
        $('#additionalUserSettings').fadeOut('slow', function () {});
    }
});

// History of memberships
$('#additionalUserSettingsHistoryMembershipsButton').on('click', function () {
    var id = globalVariable;
    $("#membershipHistoryUserData").modal('show');
    $.ajax({
        method: "POST",
        data: {Users_Memberships_Users_Id: id},
        url: urlAddress + 'User/checkUserMemberships/',
        success: function (data) {
            document.getElementById('dataTableBodyUserHistoryMemberships').innerHTML = "";
            document.getElementById("dt3").style.display = "block";

            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyUserHistoryMemberships');

            searchData.innerHTML = response.reduce((options, {Users_Memberships_Membership_Name, Users_Memberships_Start_Date, Users_Memberships_End_Date, Staff_Name, Staff_Surname}) =>
                    options += `<tr>
                                        <td class="text-left" id="">${Users_Memberships_Membership_Name}</td>
                                        <td class="text-left" id="">${formatDate(Users_Memberships_Start_Date)}</td>
                                        <td class="text-left" id="">${formatDate(Users_Memberships_End_Date)}</td>
                                        <td class="text-left" id="">${Staff_Name} ${Staff_Surname}</td>
                                    </tr>
                                    `,
                ``);
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

// Adding existing membership
$('#additionalUserSettingsAddExistingMembershipsButton').on('click', function () {
    console.log("postojeća članarina")
});

// Pause current membership start
$('#additionalUserSettingsUserMembershipPauseButton').on('click', function () {
    var id = globalVariable;
    $.ajax({
        method: "POST",
        data: {userId: id},
        url: urlAddress + 'User/pauseMembership/',
        success: function (response) {
            response = JSON.parse(response)
            $("#profileData").fadeOut(800, function () {
                $(this).modal('hide');
            });
            if (response === false){
                $(this).fadeIn(400, function notification() {
                    successNotification('Članarina je uspješno pauzirana.')
                });
                changeActiveMembershipStatusField(id, 'Zamrznuto', '#FFD75F')
                $('#additionalUserSettings').fadeOut('slow', function () {});
            }else {
                $(this).fadeIn(400, function notification() {
                    successNotification('Članarina je uspješno nastavljena.')
                });
                changeActiveMembershipStatusField(id, 'Da', '#74C687')
                $('#additionalUserSettings').fadeOut('slow', function () {});
            }

        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// Pause current membership end

function changeActiveMembershipStatusField(id, text, color){
    $.ajax({
        method: "POST",
        data: {data: id},
        url: urlAddress + 'User/viewUser/' + id,
        success: function (response) {
            response = JSON.parse(response);

            $("#" + id + "_membershipsStartDate").text(formatDate(response["Users_Memberships_Start_Date"]));
            $("#" + id + "_membershipsEndDate").text(formatDate(response["Users_Memberships_End_Date"]));
            $("#" + id + "_membershipsName").text(response["Users_Memberships_Membership_Name"]);
            $("#" + id + "_membershipsStatus").text(text);
            document.getElementById(id + '_membershipsStatus').style.backgroundColor = color;

            globalVariable = response["Users_Id"];
        }
    });
}

// pauziranje i nastavljanje radi uredno, treba srediti da se updatea frontend na indexu i da se oboja u žuto, Također možda neka obavijest na profilu?

// Additional user settings end
