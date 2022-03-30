// membershipData modal
$('.membershipData').on('click', function () {
    fadeOut("#profileData")
    if (globalVariable) {
        $.ajax({
            method: "POST",
            data: {data: globalVariable},
            url: urlAddress + 'Membership/allActiveMemberships/',
            success: function (response) {
                $('#formforma').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'post',
                        url: urlAddress + 'User/addNewUserMembership/' + globalVariable,
                        data: $('#formforma').serialize(),
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response === false) {
                                warningNotification('Molimo odaberite članarinu.')
                            } else {
                                fadeOut("#membershipData")
                                successNotification('Uspješno produžena članarina.')
                                changeActiveMembershipStatusField(globalVariable, "Da", successColor)
                            }
                        }
                    });
                });
                fadeIn("#membershipData")
                response = JSON.parse(response);
                const membershipsData = document.getElementById('memberships');
                const srcArray = response;
                membershipsData.innerHTML = srcArray.reduce((options, {Memberships_Name}) =>
                        options += `<option value="${Memberships_Name}" >${Memberships_Name}</option>`,
                    `<option value="disabled"  selected="false">Odaberi članarinu</option>`);
            }
        });
    }
});
// membershipData modal end

// Memberhships data modal start
$('.memberships').on('click', function () {
    fadeIn("#allMembershipData")
    $.ajax({
        url: urlAddress + 'Membership/allMemberships/',
        method: "POST",
        success: function (data) {
            document.getElementById('dataTableBodyStaff').innerHTML = "";
            document.getElementById("dt5").style.display = "block";
            $("#displayInactiveMemberships").html('Prikaži inaktivne članarine <span><i style="padding-left: 5px" class="fas fa-angle-right"></i></span>');
            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyMembership');

            searchData.innerHTML = response.reduce((options, {Memberships_Id, Memberships_Name, Memberships_Price, Memberships_Duration, Memberships_Active}) =>
                    options += `<tr class="membershipActive_${Memberships_Active}">
                                    <td class="text-left" id="${Memberships_Id}_membershipName">${Memberships_Name}</td>
                                    <td class="text-left" id="${Memberships_Id}_membershipDuration">${Memberships_Duration} dana</td>
                                    <td class="text-left" id="${Memberships_Id}_membershipPrice">${Memberships_Price} kn</td>
                                    <td id="${Memberships_Id}_membershipActive" style="background-color: ${(Memberships_Active === '1') ? successColor: errorColor}; color: white; font-weight: bolder" class="text-center">
                                        ${(Memberships_Active === '1') ? 'Da': 'Ne'}
                                    </td>
                                    <td class="text-center membershipProfileData" id="memid_${Memberships_Id}">
                                        <a class="submitlink linkanimation "> Uređivanje <i class="fad fa-edit ml-10"></i></a>
                                    </td>
                                </tr>
                                `,
                ``);
            var elements = document.getElementsByClassName("membershipActive_0");

            for (var i = 0; i < elements.length; i++){
                elements[i].style.display = 'none';
            }

        }
    });
});

$('#displayInactiveMemberships').on('click', function () {
    toggleClassMemberships('membershipActive_0')
});

// membership profile modal start
$(document).ajaxComplete(function () {

$('.membershipProfileData').on('click', function () {
    var id = $(this).attr('id');
    if (id) {
        id = id.split('_')[1];
        $.ajax({
            method: "POST",
            data: {Memberships_Id: id},
            url: urlAddress + 'Membership/checkMembership/',
            success: function (response) {
                response = JSON.parse(response);
                fadeOut("#allMembershipData")
                fadeIn("#checkMembershipData")
                $("#Memberships_Name").text(response["Memberships_Name"]);
                $("#Memberships_Duration").text(response["Memberships_Duration"]+" dana");
                $("#Memberships_Price").text(response["Memberships_Price"]+" kn");
                $("#Memberships_Status").text(response["Memberships_Active"] === '1'? "Aktivno" : "Inaktivno");
                document.getElementById("membershipActiveStatusIcon").style.color = response["Memberships_Active"] === '1'? successColor : errorColor;
            },
            error: function (){
                warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            }
        });
    }
});
});
// tu sam stao, prikaz membershipa radi, treba dodati pod napredno upravljanje: aktivacija/deaktivacija, uređivanje, brisanje
// membership profile modal end

// memberships data modal end


function toggleClassMemberships(className){
    var elements = document.getElementsByClassName(className)

    for (var i = 0; i < elements.length; i++){
        if (elements[i].style.display === 'none'){
            elements[i].style.display = 'table-row';
            $("#displayInactiveMemberships").html('Sakrij inaktivne članarine <span><i style="padding-left: 5px" class="fas fa-angle-down"></i></span>');
        }else {
            elements[i].style.display = 'none';
            $("#displayInactiveMemberships").html('Prikaži inaktivne članarine <span><i style="padding-left: 5px" class="fas fa-angle-right"></i></span>');
        }
    }
}
