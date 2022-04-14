<?php

class WarehouseController extends SecurityController
{
    public function allWarehouseItems()
    {
        $this->employeeCheck();
        echo json_encode(Warehouse::allWarehouseItems());
    }

    public function deleteWarehouseItem()
    {
        $this->employeeCheck();
        Warehouse::deleteWarehouseItem();
    }

    public function editWarehouseItem($id)
    {
        $this->employeeCheck();
        Warehouse::editWarehouseItemData($id);
    }

    public function newSellWarehouseItem()
    {
        $this->employeeCheck();
        Warehouse::newSellWarehouseItem();
    }

    public function newWarehouseItem()
    {
        $this->employeeCheck();
        Warehouse::newWarehouseItem();
    }

    public function resetWarehouseItem()
    {
        $this->employeeCheck();
        Warehouse::resetWarehouseItem();
    }

    public function viewWarehouseItem($id)
    {
        $this->employeeCheck();
        echo json_encode(Warehouse::viewWarehouseItem($id));
    }
}
