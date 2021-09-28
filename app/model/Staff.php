<?php


class staff
{
    public static function loginCheck()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Username=:Staff_Username AND Staff_Active=:Staff_Active');
        $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
        $stmt->bindValue('Staff_Active', 1);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            return true;
        }
    }

    public static function newPassword()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Staff SET Staff_Password=:Staff_Password WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Password', password_hash(Request::post('Staff_New_Password'), PASSWORD_BCRYPT));
        $stmt->bindValue('Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
        unset($_POST['Staff_Password']);
    }

    public static function passwordCheck()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Username=:Staff_Username');
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

    public static function passwordChangeCheck()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Staff_Password FROM Staff WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
        $staffPassword=$stmt->fetch();
        if (password_verify(Request::post('Staff_Password'), $staffPassword->Staff_Password)) {
            unset($staffPassword->Staff_Password);
            return true;
        } else {
            unset($staffPassword->Staff_Password);
            return false;
        }
    }
}