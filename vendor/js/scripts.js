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
                }
            });
        }
    });
});

function formatDate(input) {
    var datePart = input.match(/\d+/g),
        year = datePart[0],
        month = datePart[1],
        day = datePart[2];
    return day + '.' + month + '.' + year + '.';
}

function formatTime(input){
    var timePart = input.match(/\d+/g),
        hour = timePart[3],
        minute = timePart[4],
        second = timePart[5];
    return hour + ':' + minute + ':' + second;
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
        success: function () {
            $("#staffSettings").fadeOut(800, function () {
                $(this).modal('hide');
            });
            $(this).fadeIn(400, function notification() {
                successNotification('Novi podaci su uspješno spremljeni.');
            });
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// staffSettings modal end

// Search bar start
function searchfunction() {
    if (document.getElementById("search").value.length > 2) {
        $.ajax({
            url: urlAddress + 'User/userDataSearch/',
            method: "POST",
            data: {query: $('#search').val()},
            success: function (data) {
                document.getElementById('dataTableBody').innerHTML = "";
                document.getElementById("dt1").style.display = "block";

                response = JSON.parse(data);
                const searchData = document.getElementById('dataTableBody');

                searchData.innerHTML = response.reduce((options, {Users_Id_Main, Users_Name, Users_Surname, Users_Memberships_Membership_Name, Users_Memberships_Membership_Active, Users_Memberships_Start_Date, Users_Memberships_End_Date}) =>
                        options += `<tr>
                                        <td class="text-center" id="${Users_Id_Main}_usersId">${Users_Id_Main.split('-').pop()}</td>
                                        <td class="text-left" id="${Users_Id_Main}_usersName">${Users_Name} ${Users_Surname}</td>
                                        <td class="text-left" id="${Users_Id_Main}_membershipsName">${Users_Memberships_Membership_Name}</td>
                                        <td id="${Users_Id_Main}_membershipsStatus" style="background-color: ${Users_Memberships_Membership_Active ? '#74C687': '#E87C87'}; color: white; font-weight: bolder" class="text-center">
                                            ${Users_Memberships_Membership_Active ? 'Da': 'Ne'}
                                        </td>
                                        <td class="text-center" id="${Users_Id_Main}_membershipsStartDate">${formatDate(Users_Memberships_Start_Date)}</td>
                                        <td class="text-center" id="${Users_Id_Main}_membershipsEndDate">${formatDate(Users_Memberships_End_Date)}</td>
                                        <td class="text-center profileData" id="i_${Users_Id_Main}">
                                            <a class="submitlink linkanimation "> Pregled <i class="fad fa-user ml-10"></i></a>
                                        </td>
                                    </tr>
                                    `,
                                    ``);
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

// tableSports modal start
$('.tableSports').on('click', function () {
    document.getElementById('formabiljarbutton').innerHTML = ''
    $.ajax({
        url: urlAddress + 'Aditional/checkTimer',
        method: "POST",
        data: {sportId: 1},
        success: function (data) {
            response = JSON.parse(data)
            if (response === true){
                var stopWatchValue = 'Pokreni štopericu'
            }else {
                var stopWatchValue = 'Zaustavi štopericu'
            }
            document.getElementById('formabiljarbutton').innerHTML = stopWatchValue
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $("#tableSports").modal('show');
});
// tableSports modal end



// Biljar timer start and stop
$('#formabiljarbutton').on('click', function (e) {
    e.preventDefault();
    $.ajax({
        url: urlAddress + 'Aditional/manipulateTimer',
        method: "POST",
        data: {sportId: 1},
        success: function (response) {
            response = JSON.parse(response)
            if (response === true){ // pokrenuta štoperica




                $.ajax({
                    url: urlAddress + 'Aditional/checkStartedTime',
                    method: "POST",
                    data: {sportId: 1},
                    success: function (response) {
                        response = JSON.parse(response)

                        startStopWatch()
                        //console.log(formatTime(response["Timers_Start_Time"]))
                    }

                });




            }else { // zaustavljena štoperica
                console.log("tu sam2");
                stopStopWatch()
            }
        }

    });
});

// mainWatch start


var stopwatchInterval = 0;
function startStopWatch(){
    let prevTime, elapsedTime = 0;

    var updateTime = function () {
        var tempTime = elapsedTime;
        var milliseconds = tempTime % 1000;
        tempTime = Math.floor(tempTime / 1000);
        var seconds = tempTime % 60;
        tempTime = Math.floor(tempTime / 60);
        var minutes = tempTime % 60;
        tempTime = Math.floor(tempTime / 60);
        var hours = tempTime % 60;

        var time = hours + " : " + minutes + " : " + seconds;

        console.log(time)
    };

    stopwatchInterval = setInterval(function () {
            if (!prevTime) {
                prevTime = Date.now();
            }

            elapsedTime += Date.now() - prevTime;
            prevTime = Date.now();

            updateTime();
        }, 1000);
}

function stopStopWatch(){
    clearInterval(stopwatchInterval)
}

// štoperica radi, treba napraviti zaustavljanje, promjenu gumba, prikaz štoperice itd



function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s;
    document.getElementById("clockDisplay").innerText = time;
    document.getElementById("clockDisplay").textContent = time;

    setTimeout(showTime, 1000);
}
showTime();
//showTimePassed(startTime);
// mainWatch end