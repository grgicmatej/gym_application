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
                                changeActiveMembershipStatusField(id, "Da", "#74C687")
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