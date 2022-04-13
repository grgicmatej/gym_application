$('.warehouse').on('click', function () {
    fadeIn("#warehouse");
    $.ajax({
        url: urlAddress + 'Warehouse/allWarehouseItems/',
        method: "POST",
        success: function (data) {
            document.getElementById('dataTableBodyWarehouse').innerHTML = "";
            document.getElementById("dt6").style.display = "block";
            response = JSON.parse(data);
            const searchData = document.getElementById('dataTableBodyWarehouse');

            searchData.innerHTML = response.reduce((options, {Warehouse_Id, Warehouse_Item_Name, Warehouse_Item_Price, Warehouse_Item_Count, Warehouse_Item_Sold_Count, remainingWarehouseCount}) =>
                    options += `<tr class="warehouse_${Warehouse_Id}">
                                    <td class="text-left" id="${Warehouse_Id}_warehouseItemName">${Warehouse_Item_Name}</td>
                                    <td class="text-left" id="${Warehouse_Id}_warehouseItemPrice">${Warehouse_Item_Price}</td>
                                    <td class="text-center" id="${Warehouse_Id}_warehouseItemQuantity">${Warehouse_Item_Count}</td>
                                    <td class="text-left" id="${Warehouse_Id}_warehouseItemQuantitySold">${Warehouse_Item_Sold_Count} <span class="successColor newWarehouseItemSell" style="margin-left: 20px" id="i_${Warehouse_Id}"><i class="fad fa-plus ml-10"></i> Nova prodaja</span></td>
                                    <td class="text-center" id="${Warehouse_Id}_warehouseItemQuantity">${remainingWarehouseCount}</td>
                                    <td class="text-center warehouseItemEdit text-right" id="i_${Warehouse_Id}">
                                        <a class="submitlink linkanimation "> Uređivanje  <i class="fad fa-edit ml-10"></i></a>
                                    </td>
                                </tr>
                                `,
                ``);
        }
    });
});

// warehouse item modal
$(document).ajaxComplete(function () {

    $('.warehouseItemEdit').on('click', function () {
        fadeOut('#warehouse')
        var id = $(this).attr('id');
        if (id) {
            id = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {data: id},
                url: urlAddress + 'Warehouse/viewWarehouseItem/' + id,
                success: function (response) {
                    response = JSON.parse(response);

                    fadeIn("#editWarehouseItemData")
                    document.getElementById("Edit_Warehouse_Item_Name").value = response["Warehouse_Item_Name"];
                    document.getElementById("Edit_Warehouse_Item_Price").value = response["Warehouse_Item_Price"];
                    document.getElementById("Edit_Warehouse_Item_Count").value = response["Warehouse_Item_Count"];
                    globalVariableWarehouseItem = response["Warehouse_Id"];
                    /*
                    treba dodati gumbove za restartiranje stanja i za brisanje
                    $("#confirmArrival").html("<a><span class='btn btn-block btn-outline-info potvrdiDolazakBox' id='"+(response["Users_Id"])+"'>Potvrda dolaska</span></a>");
                    globalVariable = response["Users_Id"];
                    */

                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        }
    });
});
// warehouse item modal end

// warehouse item form start
$('#editWarehouseForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'Warehouse/editWarehouseItem/'+globalVariableWarehouseItem,
        data: $('#editWarehouseForm').serialize(),
        success: function () {
            fadeOut("#editWarehouseItemData");
            successNotification('Podaci proizvoda su uspješno spremljeni.');
            clearInput(1000, 'editWarehouseForm')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#editWarehouseItemData')
        }
    });
});
// warehouse item form end
