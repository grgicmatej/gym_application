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
                    $("#id").text(response["Users_Id"]);
                    $("#usersName").text(response["Users_Name"] + " " + response["Users_Surname"]);
                    $("#usersPhone").text(response["Users_Phone"]);
                    $("#membershipName").text(response["Users_Memberships_Membership_Name"]);
                    $("#status").text(response["Users_Status"]);
                    $("#birthday").text(formatDate(response["Users_Birthday"]));
                    $("#membershipDuration").text(formatDate(response["Users_Memberships_Start_Date"]) + "  -  " + formatDate(response["Users_Memberships_End_Date"]));
                    $("#numberOfArrivals").text("Broj dolazaka ovaj tjedan: " + response["countrow"]);

                    $("#confirmArrival").html("<a><span class='btn btn-block btn-outline-info' >Potvrda dolaska</span></a>");
                    globalVariable = response["Users_Id"];
                }
            });
        }
    });
});

function formatDate(input) {
    var datePart = input.match(/\d+/g),
        year = datePart[0],
        month = datePart[1], day = datePart[2];
    return day + '.' + month + '.' + year + '.';
}
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
        }
    });
});
// arrivalCounter end

// widgets
function successNotification(message) {
    toastr.success(message)
}

function infoNotification(message) {
    toastr.info(message)
}

function errorNotification(message) {
    toastr.error(message)
}

function warningNotification(message) {
    toastr.warning(message)
}
// widgets end

// membershipData modal
$('.membershipData').on('click', function () {

    var id = globalVariable;
    $("#profileData").fadeOut(400, function () {
        $(this).modal('hide');
    });

    if (id) {
        $.ajax({
            method: "POST",
            data: {data: id},
            url: urlAddress + 'User/allMemberships/',
            success: function (response) {
                $('#formforma').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'post',
                        url: urlAddress + 'User/addNewUserMembership/' + id,
                        data: $('#formforma').serialize(),
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response === false) {
                                $(this).fadeIn(400, function notification() {
                                    warningNotification('Molimo odaberite članarinu.')
                                });
                            } else {
                                $("#membershipData").fadeOut(800, function () {
                                    $(this).modal('hide');
                                });
                                $(this).fadeIn(400, function notification() {
                                    successNotification('Uspješno produžena članarina.')
                                });
                                $.ajax({
                                    method: "POST",
                                    data: {data: id},
                                    url: urlAddress + 'User/viewUser/' + id,
                                    success: function (response) {
                                        response = JSON.parse(response);

                                        $("#" + id + "_membershipsStartDate").text(formatDate(response["Users_Memberships_Start_Date"]));
                                        $("#" + id + "_membershipsEndDate").text(formatDate(response["Users_Memberships_End_Date"]));
                                        $("#" + id + "_membershipsName").text(response["Users_Memberships_Membership_Name"]);
                                        $("#" + id + "_membershipsStatus").text("Da");
                                        document.getElementById(id + '_membershipsStatus').style.backgroundColor = "#74C687";

                                        globalVariable = response["Users_Id"];
                                    }
                                });
                            }
                        }
                    });
                });
                $("#membershipData").modal('show');
                response = JSON.parse(response);
                const membershipsData = document.getElementById('memberships');
                const srcArray = response;
                membershipsData.innerHTML = srcArray.reduce((options, {Memberships_Id, Memberships_Name}) =>
                        options += `<option value="${Memberships_Name}" >${Memberships_Name}</option>`,
                    `<option value="disabled"  selected="false">Odaberi članarinu</option>`);
            }
        });
    }
});
// membershipData modal end

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
        }
    });
});
// Registration of new user end

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
        success: function (response) {
            response = JSON.parse(response);
            if (response === false) {
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            } else {
                $("#staffSettings").fadeOut(800, function () {
                    $(this).modal('hide');
                });
                $(this).fadeIn(400, function notification() {
                    successNotification('Novi podaci su uspješno spremljeni.');
                });
            }
        }
    });
});
// staffSettings modal end

// Search bar start

function searchfunction() {
    if (document.getElementById("search").value.length > 2) {
        var tekst = $('#search').val();
        $.ajax({
            url: urlAddress + 'User/userDataSearch/',
            method: "POST",
            data: {query: tekst},
            success: function (data) {
                document.getElementById('dataTableBody').innerHTML = "";
                document.getElementById("dt1").style.display = "block";
                var d1 = document.getElementById('dataTableBody');
                d1.insertAdjacentHTML('beforeend', data);
            }
        });
    } else {
        document.getElementById("dt1").style.display = "none";
        document.getElementById('dataTableBody').innerHTML = "";
    }
}
// Search bar end

// Clear input start
function clearInput(time) {
    setTimeout(function (){
        let userId= [
            "Users_Id", "Users_Name", "Users_Surname", "Users_Email", "Users_Phone", "Users_Address", "Users_City",
            "Users_Oib", "Users_Birthday", "Users_Gender", "Users_Status", "Users_Reference", "Staff_Password", "Staff_New_Password",
            "Staff_Oib", "Staff_Phone", "Staff_Email"
        ];

        userId.forEach((element) => {
            RemoveClass(element)
            if (element === 'Staff_Oib' || element === 'Staff_Phone' || element === 'Staff_Email'){
                return
            }else {
                document.getElementById(element).value = '';
            }
        });
    }, time);
}
// Clear input end