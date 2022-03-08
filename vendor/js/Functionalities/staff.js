// staffSettings modal start
$('.staffSettings').on('click', function () {
    $.ajax({
        type: 'post',
        url: urlAddress + 'Staff/staffInfo/',
        success: function (response) {
            response = JSON.parse(response)
            $("#staffSettings").modal('show');
            $("#Staff_Oib").val(response["Staff_Oib"]);
            $("#Staff_Phone").val(response["Staff_Phone"]);
            $("#Staff_Email").val(response["Staff_Email"]);
        },
        error: function () {
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            });
        }
    });
});

$('#formformaStaffSettingsPassword').on('submit', function (e) {


    e.preventDefault();

    $.ajax({ // ovo je za provjeru trenutne lozinke
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
                        $("#staffSettings").fadeOut(800, function () {
                            $(this).modal('hide');
                        });
                        $(this).fadeIn(400, function notification() {
                            successNotification('Nova lozinka je uspješno postavljena.');
                        });
                        clearInput();
                    },
                    error: function () {
                        $(this).fadeIn(400, function notification() {
                            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                        });
                    }
                });
            }else {
                $(this).fadeIn(400, function notification() {
                    warningNotification('Trenutna lozinka nije točna. Pokušajte ponovo.');
                });
            }
        },
        error: function () {
            $(this).fadeIn(400, function notification() {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            });
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

$('.staff').on('click', function () {
    $("#staffData").modal('show');
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
                                        <td id="${Staff_Id}_staffActive" style="background-color: ${(Staff_Active == 1) ? '#74C687': '#E87C87'}; color: white; font-weight: bolder" class="text-center">
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


// tu sam stao, urediti staff profile datu da ima profil kao i za korisnika. Dodati opcije "Deaktiviraj/aktiviraj zaposlenika", "Restartiraj lozinku"


// staffSettings modal end
