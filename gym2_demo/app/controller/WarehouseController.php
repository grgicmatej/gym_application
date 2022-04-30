<?php

class WarehouseController extends SecurityController
{
    public function allWarehouseItems()
    {
        
        echo json_encode(Warehouse::allWarehouseItems());
    }

    public function deleteWarehouseItem()
    {
        
        Warehouse::deleteWarehouseItem();
    }

    public function editWarehouseItem($id)
    {
        
        Warehouse::editWarehouseItemData($id);
    }

    public function newSellWarehouseItem()
    {
        
        Warehouse::newSellWarehouseItem();
    }

    public function newWarehouseItem()
    {
        
        Warehouse::newWarehouseItem();
    }

    public function resetWarehouseItem()
    {
        
        Warehouse::resetWarehouseItem();
    }

    public function viewWarehouseItem($id)
    {
        
        echo json_encode(Warehouse::viewWarehouseItem($id));
    }
}
