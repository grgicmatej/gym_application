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
            unset($user->Users_Password);
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

    public static function userDataChange()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Staff SET Staff_Oib=:Staff_Oib, Staff_Phone=:Staff_Phone, Staff_Email=:Staff_Email WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Oib', Request::post('Staff_Oib'));
        $stmt->bindValue('Staff_Phone', Request::post('Staff_Phone'));
        $stmt->bindValue('Staff_Email', Request::post('Staff_Email'));
        $stmt->bindValue('Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }

    public static function StaffData()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allStaffData()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Staff.Staff_Id AS StaffID, Staff.Staff_Name, Staff.Staff_Surname, Staff.Staff_Username, Staff.Staff_Phone, Staff.Staff_Email, Staff.Staff_Active, Staff_Gym.Staff_Id FROM Staff LEFT JOIN Staff_Gym ON Staff.Staff_Id=Staff_Gym.Staff_Id WHERE Staff_Gym.Gym_Id=:Gym_Id');
        $stmt->bindValue('Gym_Id', $_SESSION['Gym_Id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}