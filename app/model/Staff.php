<?php


class staff
{
    public static function newStaff()
    {
        if(self::newStaffData()){
            self::newStaffGymId(self::lastAddedStaff()->Staff_Id);
            return true;
        }else{
            return false;
        }
    }

    public static function lastAddedStaff()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff ORDER BY Staff_Id DESC LIMIT 1');
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function newStaffGymId($staffId)
    {

        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Staff_Gym (Staff_Id, Gym_Id) VALUES (:Staff_Id, :Gym_Id)');
        $stmt->bindValue('Staff_Id', $staffId);
        $stmt->bindValue('Gym_Id', $_SESSION['Gym_Id']);
        $stmt->execute();
    }

    public static function newStaffData()
    {
        if (!self::checkStaffUsername()){
            $newPassword=self::generatePassword();
            $db = Db::getInstance();
            $stmt = $db->prepare('INSERT INTO Staff 
                                        (
                                         Staff_Parent_Id,
                                         Staff_Name,
                                         Staff_Surname,
                                         Staff_Username,
                                         Staff_Password,
                                         Staff_Phone,
                                         Staff_Email,
                                         Staff_Oib,
                                         Staff_Adminstatus,
                                         Staff_Active
                                        ) 
                                        VALUES 
                                        (
                                         :Staff_Parent_Id,
                                         :Staff_Name,
                                         :Staff_Surname,
                                         :Staff_Username,
                                         :Staff_Password,
                                         :Staff_Phone,
                                         :Staff_Email,
                                         :Staff_Oib,
                                         :Staff_Adminstatus,
                                         true
                                        )');
            $stmt->bindValue('Staff_Parent_Id', Session::getInstance()->getUser()->Staff_Id);
            $stmt->bindValue('Staff_Name', Request::post('Staff_Name'));
            $stmt->bindValue('Staff_Surname', Request::post('Staff_Surname'));
            $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
            $stmt->bindValue('Staff_Password', password_hash(Request::post('Staff_Password'), PASSWORD_BCRYPT));
            $stmt->bindValue('Staff_Phone', Request::post('Staff_Phone'));
            $stmt->bindValue('Staff_Email', Request::post('Staff_Email'));
            $stmt->bindValue('Staff_Oib', Request::post('Staff_Oib'));
            $stmt->bindValue('Staff_Adminstatus', 3);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }

    public static function editStaff($id)
    {
        if (((self::staffData($id)->Staff_Username != Request::post('Staff_Username')) && !self::checkStaffUsername()) || (self::staffData($id)->Staff_Username == Request::post('Staff_Username'))){
            $db = Db::getInstance();
            $stmt = $db->prepare('UPDATE Staff SET 
                                        Staff_Name=:Staff_Name, 
                                        Staff_Surname=:Staff_Surname, 
                                        Staff_Username=:Staff_Username, 
                                        Staff_Oib=:Staff_Oib, 
                                        Staff_Phone=:Staff_Phone,
                                        Staff_Email=:Staff_Email
                                        WHERE
                                        Staff_Id=:Staff_Id');
            $stmt->bindValue('Staff_Name', Request::post('Staff_Name'));
            $stmt->bindValue('Staff_Surname', Request::post('Staff_Surname'));
            $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
            $stmt->bindValue('Staff_Oib', Request::post('Staff_Oib'));
            $stmt->bindValue('Staff_Phone', Request::post('Staff_Phone'));
            $stmt->bindValue('Staff_Email', Request::post('Staff_Email'));
            $stmt->bindValue('Staff_Id', $id);
            $stmt->execute();
            return true;

        } else {
            return false;
        }
    }

    public static function checkStaffUsername()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Username=:Staff_Username');
        $stmt->bindValue('Staff_Username', Request::post('Staff_Username'));
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function checkStaffMemberships()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT Users.Users_Name, Users.Users_Surname, Users_Memberships_Archive.Users_Memberships_Membership_Name, Users_Memberships_Archive.Users_Memberships_Start_Date, Users_Memberships_Archive.Users_Memberships_Price FROM Users_Memberships_Archive LEFT JOIN Users ON Users_Memberships_Archive.Users_Memberships_Users_Id = Users.Users_Id WHERE Users_Memberships_Archive.Users_Memberships_Admin_Id=:Users_Memberships_Admin_Id AND Users_Memberships_Archive.Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id ORDER BY Users_Memberships_Archive.Users_Memberships_Start_Date DESC');
        $stmt->bindValue('Users_Memberships_Gym_Id', $_SESSION['Gym_Id']);
        $stmt->bindValue('Users_Memberships_Admin_Id', Request::post('Users_Memberships_Admin_Id'));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function checkActiveStatusStaff()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Id=:Staff_Id AND Staff_Active=:Staff_Active');
        $stmt->bindValue('Staff_Id', Request::post('staffId'));
        $stmt->bindValue('Staff_Active', true);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function changeActiveStatus()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Staff SET Staff_Active=:Staff_Active WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Active', (self::checkActiveStatusStaff() ? 0 : 1));
        $stmt->bindValue('Staff_Id', Request::post('staffId'));
        $stmt->execute();
        return self::checkActiveStatusStaff();
    }

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

    public static function newPasswordByAdmin()
    {
        $newPassword=self::generatePassword();

        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Staff SET Staff_Password=:Staff_Password WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Password', password_hash($newPassword, PASSWORD_BCRYPT));
        $stmt->bindValue('Staff_Id', Request::post('staffId'));
        $stmt->execute();
        return $newPassword;
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

    public static function staffData($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff WHERE Staff_Id=:Staff_Id');
        $stmt->bindValue('Staff_Id', $id !== 0 ? $id : Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allStaffData()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Staff.Staff_Id AS StaffID, Staff.Staff_Name, Staff.Staff_Surname, Staff.Staff_Username, Staff.Staff_Phone, Staff.Staff_Email, Staff.Staff_Active, Staff_Gym.Staff_Id FROM Staff LEFT JOIN Staff_Gym ON Staff.Staff_Id=Staff_Gym.Staff_Id WHERE Staff_Gym.Gym_Id=:Gym_Id AND Staff.Staff_Adminstatus=:Staff_Adminstatus ORDER BY Staff.Staff_Active DESC');
        $stmt->bindValue('Gym_Id', $_SESSION['Gym_Id']);
        $stmt->bindValue('Staff_Adminstatus', 3);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function generatePassword()
    {
        $characters = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < 10; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }
}