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

                searchData.innerHTML = response.reduce((options, {Users_Id_Main, Users_Name, Users_Surname, Users_Memberships_Membership_Name, Users_Memberships_Membership_Active, Users_Memberships_Start_Date, Users_Memberships_End_Date, Memberships_Pause_Active}) =>
                        options +=
                            `<tr>
                                <td class="text-center" id="${Users_Id_Main}_usersId">${Users_Id_Main.split('-').pop()}</td>
                                <td class="text-left" id="${Users_Id_Main}_usersName">${Users_Name} ${Users_Surname}</td>
                                <td class="text-left hide_on_small" id="${Users_Id_Main}_membershipsName">${Users_Memberships_Membership_Name}</td>
                                <td id="${Users_Id_Main}_membershipsStatus" style="background-color: ${Memberships_Pause_Active ? membershipPauseColor : (Users_Memberships_Membership_Active === "1" ? successColor: errorColor)}; color: white; font-weight: bolder" class="text-center">
                                    ${Memberships_Pause_Active ? 'Zamrznuto' : (Users_Memberships_Membership_Active === "1" ? 'Da': 'Ne')}
                                </td>
                                <td class="text-center hide_on_small" id="${Users_Id_Main}_membershipsStartDate">${formatDate(Users_Memberships_Start_Date)}</td>
                                <td class="text-center hide_on_small" id="${Users_Id_Main}_membershipsEndDate">${formatDate(Users_Memberships_End_Date)}</td>
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

function clearSearchTable(){
    document.getElementById("dt1").style.display = "none";
    document.getElementById("search").value = "";
}
// Search bar end
