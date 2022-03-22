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

            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyStaff');

            searchData.innerHTML = response.reduce((options, {Staff_Id, Staff_Name, Staff_Surname, Staff_Username, Staff_Phone, Staff_Email, Staff_Active}) =>
                    options += `<tr>
                                    <td class="text-left" id="${Staff_Id}_staffName">${Staff_Name} ${Staff_Surname}</td>
                                    <td class="text-left" id="${Staff_Id}_staffUserName">${Staff_Username}</td>
                                    <td class="text-left" id="${Staff_Id}_staffPhone">${Staff_Phone}</td>
                                    <td class="text-left" id="${Staff_Id}_staffEmail">${Staff_Email}</td>
                                    <td id="${Staff_Id}_staffActive" style="background-color: ${(Staff_Active == 1) ? successColor: errorColor}; color: white; font-weight: bolder" class="text-center">
                                        ${(Staff_Active == 1) ? 'Da': 'Ne'}
                                    </td>
                                    <td class="text-center staffProfileData" id="i_${Staff_Id}">
                                        <a class="submitlink linkanimation "> Pregled <i class="fad fa-user ml-10"></i></a>
                                    </td>
                                </tr>
                                `,
                ``);
        }
    });
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



// staffSettings modal end
