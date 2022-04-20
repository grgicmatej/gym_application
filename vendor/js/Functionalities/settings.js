// gym settings modal start
$('.gymSettings').on('click', function () {
    $.ajax({
        type: 'post',
        url: urlAddress + 'Settings/gymSettingsCash/',
        success: function (response) {
            response = JSON.parse(response)
            fadeIn("#gymSettings")
            document.getElementById("Cash_Register_Amount").value = response["Cash_Register_Amount"];
        },
        error: function () {
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        url: urlAddress + 'Settings/gymSettings/',
        method: "POST",
        success: function (data) {
            document.getElementById('dataTableBodySettings').innerHTML = "";
            document.getElementById("dt7").style.display = "block";
            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodySettings');

            searchData.innerHTML = response.reduce((options, {Sport_Settings_Id, Sport_Settings_Name, Sport_Settings_Sport_Active, Sport_Settings_Price}) =>
                    options += `<tr class="warehouse_${Sport_Settings_Id}">
                                    <td class="text-left" id="${Sport_Settings_Id}_sportSettingsName">${Sport_Settings_Name}</td>
                                    <td class="text-left" id="${Sport_Settings_Id}_sportSettingsPrice">${Sport_Settings_Price}</td>
                                    <td id="${Sport_Settings_Id}_sportSettingsSportActive" style="background-color: ${(Sport_Settings_Sport_Active === '1') ? successColor: errorColor}; color: white; font-weight: bolder" class="text-center">
                                        ${(Sport_Settings_Sport_Active === '1') ? 'Da': 'Ne'}
                                    </td>
                                    <td class="text-right settingsSportData" id="i_${Sport_Settings_Id}">
                                        <a class="submitlink linkanimation "> Uređivanje  <i class="fad fa-edit ml-10"></i></a>
                                    </td>
                                </tr>
                                `,
                ``);
        }
    });
});
// gym settings modal end

// gym cash amount edit start
$('#formformaGymSettingsAmount').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'settings/editCashRegisterAmount/',
        data: $('#formformaGymSettingsAmount').serialize(),
        success: function () {
            fadeOut("#gymSettings");
            successNotification('Podaci blagajne su uspješno spremljeni.');
            clearInput(1000, 'formformaGymSettingsAmount')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#gymSettings')
        }
    });
});
// gym cash amount edit end

// gym sport settings edit start
$('#updateSportSettings').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'settings/settingsSportEdit/'+globalVariableSettings,
        data: $('#updateSportSettings').serialize(),
        success: function () {
            fadeOut("#sportSettings");
            successNotification('Podaci sporta su uspješno spremljeni.');
            clearInput(1000, 'updateSportSettings')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#sportSettings')
        }
    });
});
// gym sport settings edit end

// edit sport settings modal start
$(document).ajaxComplete(function () {
    $('.settingsSportData').on('click', function () {
        var id = $(this).attr('id');
        if (id) {
            globalVariableSettings = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {data: globalVariableSettings},
                url: urlAddress + 'Settings/settingsSportEditPrep/' + globalVariableSettings,
                success: function (response) {
                    response = JSON.parse(response);
                    fadeOut("#gymSettings")
                    fadeIn("#sportSettings")
                    document.getElementById("Sport_Settings_Name_Edit").value = response["Sport_Settings_Name"];
                    document.getElementById("Sport_Settings_Price_Edit").value = response["Sport_Settings_Price"];
                    if (response["Sport_Settings_Sport_Active"] === '1'){
                        $("#activateSportSettingsSport").html("<a><span class='btn btn-block btn-outline-info sportSettingsDeactivate' id='"+(response["Sport_Settings_Id"])+"'>Deaktivacija</span></a>");
                    }else {
                        $("#activateSportSettingsSport").html("<a><span class='btn btn-block btn-outline-info sportSettingsActivate' id='"+(response["Sport_Settings_Id"])+"'>Aktivicija</span></a>");
                    }

                    document.getElementById("activateSportSettingsSport").style.color = response["Staff_Active"] === '1'? successColor : errorColor;
                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        }
    });
});
// edit sport settings modal end

// activate - deactivate sport settings start
$(document).ajaxComplete(function () {
    $('.sportSettingsActivate').on('click', function () {
        var id = $(this).attr('id');
        activateDeactivateSettingsSport(id, 1)
    });
});

$(document).ajaxComplete(function () {
    $('.sportSettingsDeactivate').on('click', function () {
        var id = $(this).attr('id');
        activateDeactivateSettingsSport(id, 0)
    });
});

function activateDeactivateSettingsSport(id, value)
{
    $.ajax({
        method: "POST",
        data: {sportId: id, sportActiveValue: value},
        url: urlAddress + 'Settings/SettingsSportActiveStatus/',
        success: function () {
            successNotification('Podaci sporta su uspješno spremljeni.');
            fadeOut("#sportSettings")
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
}
// activate - deactivate sport settings end