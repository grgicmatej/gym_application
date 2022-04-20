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
                                    <td class="text-left" id="${Warehouse_Id}_warehouseItemQuantitySold">${Warehouse_Item_Sold_Count}
                                     ${(remainingWarehouseCount > 0) ? '<span class="successColor newWarehouseItemSell" style="margin-left: 20px" id="i_${Warehouse_Id}"><i class="fad fa-plus ml-10"></i> Nova prodaja</span>' : ''}  
                                     </td>
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

// warehouse item modal start
$(document).ajaxComplete(function () {

    $('.warehouseItemEdit').on('click', function () {
        fadeOut('#warehouse')
        var id = $(this).attr('id');
        if (id) {
            id = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {warehouseId: id},
                url: urlAddress + 'Warehouse/viewWarehouseItem/',
                success: function (response) {
                    response = JSON.parse(response);

                    fadeIn("#editWarehouseItemData")
                    document.getElementById("Edit_Warehouse_Item_Name").value = response["Warehouse_Item_Name"];
                    document.getElementById("Edit_Warehouse_Item_Price").value = response["Warehouse_Item_Price"];
                    document.getElementById("Edit_Warehouse_Item_Count").value = response["Warehouse_Item_Count"];
                    globalVariableWarehouseItem = response["Warehouse_Id"];

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

// warehouse item form cancel start
$('.editWarehouseFormCancel').on('click', function () {
    fadeOut("#editWarehouseItemData");
});

$('.newWarehouseFormCancel').on('click', function () {
    fadeOut("#newWarehouseItemData");
});
// warehouse item form cancel end

// warehouse item delete start
$('.deleteWarehouseItembutton').on('click', function () {
    fadeOut("#editWarehouseItemData")
    fadeIn("#deleteWarehouseItem")
});

$('.cancelWarehouseDeleteButton').on('click', function () {
    fadeOut("#deleteWarehouseItem")
});

$('.confirmWarehouseDeleteButton').on('click', function () {
    $.ajax({
        method: "POST",
        data: {warehouseId: globalVariableWarehouseItem},
        url: urlAddress + 'warehouse/deleteWarehouseItem',
        success: function () {
            fadeOut("#deleteWarehouseItem")
            successNotification('Proizvod je uspješno obrisan.');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// warehouse item delete end

// warehouse item reset start
$('.resetWarehouseCountbutton').on('click', function () {
    fadeOut("#editWarehouseItemData")
    fadeIn("#resetWarehouseItem")
});

$('.cancelWarehouseResetButton').on('click', function () {
    fadeOut("#resetWarehouseItem")
});

$('.confirmWarehouseResetButton').on('click', function () {
    $.ajax({
        method: "POST",
        data: {warehouseId: globalVariableWarehouseItem},
        url: urlAddress + 'warehouse/resetWarehouseItem',
        success: function () {
            fadeOut("#resetWarehouseItem")
            successNotification('Broj prodaja je uspješno restartiran.');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});
// warehouse item reset end

// warehouse item sell start
$(document).ajaxComplete(function () {
    $('.newWarehouseItemSell').on('click', function () {
        var id = $(this).attr('id');
        if (id) {
            id = id.split('_')[1];
            $.ajax({
                method: "POST",
                data: {warehouseId: id},
                url: urlAddress + 'Warehouse/newSellWarehouseItem/',
                success: function () {
                    fadeOut('#warehouse')
                    successNotification('Nova prodaja je uspješno zabilježena.');

                },
                error: function (){
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        }
    });
});
// warehouse item sell end

// warehouse new item modal start
$('.newWarehouseProduct').on('click', function () {
    fadeOut("#warehouse")
    fadeIn("#newWarehouseItemData")
});
// warehouse new item modal end

// warehouse new item form start
$('#newWarehouseForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: urlAddress + 'Warehouse/newWarehouseItem/',
        data: $('#newWarehouseForm').serialize(),
        success: function () {
            fadeOut("#newWarehouseItemData");
            successNotification('Novi proizvod je uspješno spremljen.');
            clearInput(1000, 'newWarehouseForm')
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
            fadeOut('#editWarehouseItemData')
        }
    });
});
// warehouse new item form end
