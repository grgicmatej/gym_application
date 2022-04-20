<?php


class SettingsController extends SecurityController
{
    public function gymSettings()
    {
        $this->adminCheck();
        echo json_encode(Settings::gymSettings());
    }

    public function gymSettingsCash()
    {
        $this->adminCheck();
        echo json_encode(Settings::gymSettingsCash());
    }

    public function editCashRegisterAmount()
    {
        Settings::editCashRegisterAmount();
    }

    public function settingsSportEditPrep($id)
    {
        echo json_encode(Settings::settingsSportEditPrep($id));
    }

    public function settingsSportEdit($id)
    {
        Settings::settingsSportEdit($id);
    }
}