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

                    fadeIn("#profileData")
                    $("#email").text(response["Users_Email"]);
                    $("#id").text(response["Users_Id"].split('-').pop());
                    $("#usersName").text(response["Users_Name"] + " " + response["Users_Surname"]);
                    $("#usersPhone").text(response["Users_Phone"]);
                    $("#membershipName").text(response["Users_Memberships_Membership_Name"]);
                    $("#status").text(response["Users_Status"]);
                    $("#birthday").text(formatDate(response["Users_Birthday"]));
                    $("#membershipDuration").text(formatDate(response["Users_Memberships_Start_Date"]) + "  -  " + formatDate(response["Users_Memberships_End_Date"]));
                    $("#numberOfArrivals").text("Broj dolazaka ovaj tjedan: " + response["countrow"]);

                    $("#confirmArrival").html("<a><span class='btn btn-block btn-outline-info potvrdiDolazakBox' id='"+(response["Users_Id"])+"'>Potvrda dolaska</span></a>");
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

    var id = $('.potvrdiDolazakBox').attr('id');
        $.ajax({
        method: "POST",
        data: {data: id},
        url: urlAddress + 'User/addUserArrival/' + id,
        success: function () {
            fadeOut("#profileData")
            successNotification('Uspješno potvrđen dolazak.')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// arrivalCounter end

// Registration of new user
$('.newUserRegistration').on('click', function () {
    fadeIn("#newUserRegistration")
});

$('#formformaNewUser').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'User/addNewUser/',
        data: $('#formformaNewUser').serialize(),
        success: function () {
            fadeOut("#newUserRegistration")
            successNotification('Uspješno registriran korisnik.');
            clearInput(1000, 'formformaNewUser');
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
        document.getElementById('additionalUserSettings').style.display = "block";
        checkMembershipPause()
    }else {
        document.getElementById('additionalUserSettings').style.display = "none";
    }
});

// History of memberships
$('#additionalUserSettingsHistoryMembershipsButton').on('click', function () {
    fadeIn("#membershipHistoryUserData")
    $.ajax({
        method: "POST",
        data: {Users_Memberships_Users_Id: globalVariable},
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
    fadeIn("#editUserMembershipData")
});

$('#formformaEditMembershipUser').on('submit', function (e) {
    e.preventDefault();

    if(new Date(document.getElementById('Edit_Users_Memberships_Start_Date').value) < new Date(document.getElementById('Edit_Users_Memberships_End_Date').value)) {
        $.ajax({
            type: 'post',
            url: urlAddress + 'User/editMembershipUser/'+globalVariable,
            data: $('#formformaEditMembershipUser').serialize(),
            success: function () {
                fadeOut("#editUserMembershipData")
                fadeOut("#profileData")
                successNotification('Uspješno postavljena članarina.')
                fadeOut("#additionalUserSettings")
                clearInput(1000, 'formformaEditMembershipUser')
                changeActiveMembershipStatusField(globalVariable, "Da", successColor)
            },
            error: function (){
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.')
            }
        });
    } else {
        warningNotification('Početni datum ne može biti veći od završnog. Pokušajte ponovo.');
    }
});

// Pause current membership start
$('#additionalUserSettingsUserMembershipPauseButton').on('click', function () {
    $.ajax({
        method: "POST",
        data: {userId: globalVariable},
        url: urlAddress + 'User/pauseMembership/',
        success: function (response) {
            response = JSON.parse(response)
            fadeOut("#profileData")
            if (response === false){
                successNotification('Članarina je uspješno pauzirana.')
                changeActiveMembershipStatusField(globalVariable, 'Zamrznuto', membershipPauseColor)
                fadeOut('#additionalUserSettings')
            }else {
                successNotification('Članarina je uspješno nastavljena.')
                changeActiveMembershipStatusField(globalVariable, 'Da', successColor)
                fadeOut('#additionalUserSettings')
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
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
}

// User edit start
$('.additionalUserSettingsUserSettingsButton').on('click', function () {
        $.ajax({
            method: "POST",
            data: {data: globalVariable},
            url: urlAddress + 'User/viewUser/' + globalVariable,
            success: function (response) {
                response = JSON.parse(response);

                fadeIn("#editUserData")
                document.getElementById("Edit_Users_Id").value = response["Users_Id"].split('-').pop();
                document.getElementById("Edit_Users_Name").value = response["Users_Name"];
                document.getElementById("Edit_Users_Surname").value = response["Users_Surname"];
                document.getElementById("Edit_Users_Email").value = response["Users_Email"];
                document.getElementById("Edit_Users_Phone").value = response["Users_Phone"];
                document.getElementById("Edit_Users_Address").value = response["Users_Address"];
                document.getElementById("Edit_Users_City").value = response["Users_City"];
                document.getElementById("Edit_Users_Oib").value = response["Users_Oib"];
                document.getElementById("Edit_Users_Birthday").value = response["Users_Birthday"];
                document.getElementById("Edit_Users_Gender").value = response["Users_Gender"];
                document.getElementById("Edit_Users_Status").value = response["Users_Status"];
                document.getElementById("Edit_Users_Reference").value = response["Users_Reference"];
                document.getElementById("Edit_Users_Company").value = response["Users_Company"] !== null ? response["Users_Company"] : "";
                $('#formformaEditUser').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: urlAddress + 'User/EditUser/'+response["Users_Id"],
                        data: $('#formformaEditUser').serialize(),
                        success: function (response) {

                            response = JSON.parse(response)
                            if (response === true){
                                fadeOut("#editUserData");
                                fadeOut("#profileData");
                                successNotification('Podaci su uspješno spremljeni.');
                                fadeOut('#additionalUserSettings')
                                clearSearchTable()
                                clearInput(1000, 'formformaEditUser')
                            }else {
                                warningNotification('ID broj kartice već postoji. Pokušajte ponovo.');
                                fadeOut('#additionalUserSettings')
                            }
                        },
                        error: function (){
                            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                            fadeOut('#additionalUserSettings')
                        }
                    });
                });
            },
            error: function (){
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            }
        });
});



// User edit end

// Additional user settings end
