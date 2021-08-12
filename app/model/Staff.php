<?php


class staff
{
    public static function loginCheck()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('select * from Staff WHERE Staff_Username=:Staff_Username AND Staff_Active=:Staff_Active');
        $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
        $stmt->bindValue('Staff_Active', 1);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            return true;
        }
    }

    public static function passwordCheck()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('select * from Staff where Staff_Username=:Staff_Username');
        $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
        $stmt->execute();
        $user=$stmt->fetch();

        if (password_verify(Request::post('Staff_Password'), $user->Staff_Password)) {
            unset($user->Users_Password);
            Session::getInstance()->login($user);
            return true;
        } else {
            return false;
        }
    }
}