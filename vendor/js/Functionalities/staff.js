// staff profileData modal
$(document).ajaxComplete(function () {
    $('.staffProfileData').on('click', function () {
        var id = $(this).attr('id');
        if (id) {
            globalVariableStaff = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {data: globalVariableStaff},
                url: urlAddress + 'Staff/staffInfo/' + globalVariableStaff,
                success: function (response) {
                    response = JSON.parse(response);
                    fadeOut("#staffData")
                    fadeIn("#staffProfileData")
                    $("#staffEmail").html("<a href='mailto:"+(response["Staff_Email"])+"'><span class='linkanimation'>"+response["Staff_Email"]+"</span></a>");
                    $("#staffUsersName").text(response["Staff_Username"]);
                    $("#staffPhone").html("<a href='tel:"+(response["Staff_Phone"])+"'><span class='linkanimation'>"+response["Staff_Phone"]+"</span></a>");
                    $("#staffSurname").text(response["Staff_Surname"]);
                    $("#staffName").text(response["Staff_Name"]);
                    $("#additionalStaffSettingsDeactivateStaff").text(response["Staff_Active"] === '1'? 'Deaktivacija zaposlenika' : 'Aktivacija zaposlenika');
                    document.getElementById("staffActiveStatusIcon").style.color = response["Staff_Active"] === '1'? successColor : errorColor;
                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        }
    });
});

$('#additionalStaffSettingsButton').on('click', function () {
    if (document.getElementById('additionalStaffSettings').style.display === "none"){
        document.getElementById('additionalStaffSettings').style.display = "block";
    }else {
        document.getElementById('additionalStaffSettings').style.display = "none";
    }
});

// staff profileData modal end


// staffSettings modal start
$('.staffSettings').on('click', function () {
    $.ajax({
        type: 'post',
        url: urlAddress + 'Staff/staffInfo/',
        success: function (response) {
            response = JSON.parse(response)
            fadeIn("#staffSettings")
            $("#Staff_Oib").val(response["Staff_Oib"]);
            $("#Staff_Phone").val(response["Staff_Phone"]);
            $("#Staff_Email").val(response["Staff_Email"]);
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

$('#formformaStaffSettingsPassword').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'Staff/passwordChecker/',
        data: $('#formformaStaffSettingsPassword').serialize(),
        success: function (response) {
            if (response === 'true'){
                $.ajax({
                    type: 'post',
                    url: urlAddress + 'Staff/passwordChange/',
                    data: $('#formformaStaffSettingsPassword').serialize(),
                    success: function () {
                        fadeOut("#staffSettings")
                        successNotification('Nova lozinka je uspješno postavljena.');
                        clearInput(1000, 'formformaStaffSettingsPassword');
                    },
                    error: function () {
                        warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                    }
                });
            }else {
                warningNotification('Trenutna lozinka nije točna. Pokušajte ponovo.');
            }
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
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
            fadeOut("#staffSettings")
            successNotification('Novi podaci su uspješno spremljeni.');
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

$('.staff').on('click', function () {
    fadeIn("#staffData")
    $.ajax({
        url: urlAddress + 'Staff/allStaffInfo/',
        method: "POST",
        success: function (data) {
            document.getElementById('dataTableBodyStaff').innerHTML = "";
            document.getElementById("dt2").style.display = "block";
            $("#displayInactiveStaff").html('Prikaži inaktivne zaposlenike <span><i style="padding-left: 5px" class="fas fa-angle-right"></i></span>');
            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyStaff');

            searchData.innerHTML = response.reduce((options, {Staff_Id, Staff_Name, Staff_Surname, Staff_Username, Staff_Phone, Staff_Email, Staff_Active}) =>
                    options += `<tr class="staffActive_${Staff_Active}">
                                    <td class="text-left" id="${Staff_Id}_staffName">${Staff_Name} ${Staff_Surname}</td>
                                    <td class="text-left" id="${Staff_Id}_staffUserName">${Staff_Username}</td>
                                    <td class="text-left" id="${Staff_Id}_staffPhone">${Staff_Phone}</td>
                                    <td class="text-left" id="${Staff_Id}_staffEmail">${Staff_Email}</td>
                                    <td id="${Staff_Id}_staffActive" style="background-color: ${(Staff_Active == 1) ? successColor: errorColor}; color: white; font-weight: bolder" class="text-center">
                                        ${(Staff_Active) ? 'Da': 'Ne'}
                                    </td>
                                    <td class="text-center staffProfileData" id="i_${Staff_Id}">
                                        <a class="submitlink linkanimation "> Pregled <i class="fad fa-user ml-10"></i></a>
                                    </td>
                                </tr>
                                `,
                ``);
            var elements = document.getElementsByClassName("staffActive_0");

            for (var i = 0; i < elements.length; i++){
                elements[i].style.display = 'none';
            }

        }
    });
});

$('#displayInactiveStaff').on('click', function () {
   toggleClassStaff('staffActive_0')
});

// Activate - deactivate staff start
$('#additionalStaffSettingsDeactivateStaff').on('click', function () {
    $.ajax({
        method: "POST",
        data: {staffId: globalVariableStaff},
        url: urlAddress + 'Staff/changeActiveStatusStaff/',
        success: function (response) {
            response = JSON.parse(response)
            fadeOut("#staffProfileData")
            if (response === 0){
                successNotification('Zaposlenik je uspješno deaktiviran.')
                fadeOut('#additionalStaffSettings')
            }else {
                successNotification('Zaposlenik je uspješno aktiviran.')
                fadeOut('#additionalStaffSettings')
            }
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// Activate - deactivate staff end

// Staff password restart start
$('#additionalStaffSettingsRestartPassword').on('click', function () {
    $.ajax({
        method: "POST",
        data: {staffId: globalVariableStaff},
        url: urlAddress + 'Staff/changeStaffPassword/',
        success: function (response) {
            response = JSON.parse(response)
            fadeOut("#staffProfileData")
            successNotification('Lozinka zaposlenika je uspješno generirana.')
            fadeOut('#additionalStaffSettings')
            fadeIn('#newPasswordModal')
            $("#newStaffPassword").text(response);
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// Staff password restart end

function toggleClassStaff(className){
    var elements = document.getElementsByClassName(className)

    for (var i = 0; i < elements.length; i++){
        if (elements[i].style.display === 'none'){
            elements[i].style.display = 'table-row';
            $("#displayInactiveStaff").html('Sakrij inaktivne zaposlenike <span><i style="padding-left: 5px" class="fas fa-angle-down"></i></span>');
        }else {
            elements[i].style.display = 'none';
            $("#displayInactiveStaff").html('Prikaži inaktivne zaposlenike <span><i style="padding-left: 5px" class="fas fa-angle-right"></i></span>');
        }
    }
}

// staff history memberships start
$('#additionalStaffSettingsHistoryMembershipsButton').on('click', function () {
    fadeIn("#membershipHistoryStaffData")
    $.ajax({
        method: "POST",
        data: {Users_Memberships_Admin_Id: globalVariableStaff},
        url: urlAddress + 'Staff/checkStaffMemberships/',
        success: function (data) {
            document.getElementById('dataTableBodyStaffHistoryMemberships').innerHTML = "";
            document.getElementById("dt4").style.display = "block";

            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyStaffHistoryMemberships');

            searchData.innerHTML = response.reduce((options, {Users_Name, Users_Surname, Users_Memberships_Membership_Name, Users_Memberships_Start_Date, Users_Memberships_Price}) =>
                    options += `<tr>
                                    <td class="text-left" id="">${Users_Name} ${Users_Surname}</td>
                                    <td class="text-left" id="">${Users_Memberships_Membership_Name}</td>
                                    <td class="text-left" id="">${formatDate(Users_Memberships_Start_Date)}</td>
                                    <td class="text-left" id="">${Users_Memberships_Price}</td>
                                </tr>
                                `,
                ``);
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// staff history memberships end

// edit staff data start
$('.additionalStaffEditSettings').on('click', function () {
    $.ajax({
        method: "POST",
        data: {data: globalVariableStaff},
        url: urlAddress + 'Staff/staffInfo/' + globalVariableStaff,
        success: function (response) {
            response = JSON.parse(response)
            fadeOut("#staffProfileData")
            fadeIn("#staffEdit")
            document.getElementById("Edit_Staff_Name").value = response["Staff_Name"];
            document.getElementById("Edit_Staff_Surname").value = response["Staff_Surname"];
            document.getElementById("Edit_Staff_Username").value = response["Staff_Username"];
            document.getElementById("Edit_Staff_Oib").value = response["Staff_Oib"];
            document.getElementById("Edit_Staff_Phone").value = response["Staff_Phone"];
            document.getElementById("Edit_Staff_Email").value = response["Staff_Email"];
            },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

$('#formformaEditStaff').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'Staff/editStaff/'+globalVariableStaff,
        data: $('#formformaEditStaff').serialize(),
        success: function (response) {

            response = JSON.parse(response)
            if (response === true){
                fadeOut("#staffEdit");
                successNotification('Podaci zaposlenika su uspješno spremljeni.');
                clearInput(1000, 'formformaEditStaff')
                fadeOut('#additionalStaffSettingsButton')
            }else {
                warningNotification('Korisničko ime zaposlenika već postoji. Pokušajte ponovo.');
                fadeOut('#additionalStaffSettingsButton')
            }
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#additionalUserSettings')
            fadeOut('#additionalStaffSettingsButton')
        }
    });
});
// edit staff data end
// staffSettings modal end
