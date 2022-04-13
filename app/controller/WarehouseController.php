<?php

class WarehouseController extends SecurityController
{
    public function allWarehouseItems()
    {
        echo json_encode(Warehouse::allWarehouseItems());
    }

    public function viewWarehouseItem($id)
    {
        echo json_encode(Warehouse::viewWarehouseItem($id));
    }

    public function editWarehouseItem($id)
    {
        Warehouse::editWarehouseItemData($id);
    }
}
