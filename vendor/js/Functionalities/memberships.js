// membershipData modal
$('.membershipData').on('click', function () {
    fadeOut("#profileData")
    if (globalVariable) {
        $.ajax({
            method: "POST",
            data: {data: globalVariable},
            url: urlAddress + 'User/allMemberships/',
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
