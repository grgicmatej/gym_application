<?php


class SettingsController extends SecurityController
{
    public function gymSettings()
    {
        
        echo json_encode(Settings::gymSettings());
    }

    public function gymSettingsCash()
    {
        
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

    public function SettingsSportActiveStatus()
    {
        Settings::SettingsSportActiveStatus();
    }
}