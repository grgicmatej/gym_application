<?php

class Notes
{
    public static function checkStaffNotes()
    {
        if (Session::getInstance()->getUser()->Staff_Adminstatus == 4) {
            return self::allStaffNotes();
        } else {
            return self::staffNotes();
        }
    }

    public static function checkNote()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Notes_Note FROM Notes WHERE Notes_Id=:Notes_Id AND Notes_Gym_Id=:Notes_Gym_Id');
        $stmt->bindValue('Notes_Id', Request::post('Notes_Id'));
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allStaffNotes()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Notes.*, Staff.Staff_Name, Staff.Staff_Surname FROM Notes 
                                LEFT JOIN Staff ON Notes.Notes_Staff_Id=Staff.Staff_Id
                                WHERE Notes_Gym_Id=:Notes_Gym_Id ORDER BY Notes_Date DESC');
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function staffNotes()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Notes.*, Staff.Staff_Name, Staff.Staff_Surname FROM Notes 
                                LEFT JOIN Staff ON Notes.Notes_Staff_Id=Staff.Staff_Id
                                WHERE Notes_Staff_Id=:Notes_Staff_Id AND Notes_Gym_Id=:Notes_Gym_Id ORDER BY Notes_Date DESC');
        $stmt->bindValue('Notes_Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function newNote()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Notes 
                                (
                                 Notes_Note,
                                 Notes_Staff_Id,
                                 Notes_Gym_Id
                                ) 
                                VALUES 
                                (
                                 :Notes_Note,
                                 :Notes_Staff_Id,
                                 :Notes_Gym_Id
                                )');
        $stmt->bindValue('Notes_Note', Request::post('Notes_Note'));
        $stmt->bindValue('Notes_Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
    }

    public static function deleteNote()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('DELETE FROM Notes WHERE Notes_Id=:Notes_Id AND Notes_Gym_Id=:Notes_Gym_Id');
        $stmt->bindValue('Notes_Id', Request::post('notesId'));
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
    }

    public static function editNote($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Notes SET Notes_Note=:Notes_Note WHERE Notes_Id=:Notes_Id AND Notes_Gym_Id=:Notes_Gym_Id');
        $stmt->bindValue('Notes_Note', Request::post('Notes_Note'));
        $stmt->bindValue('Notes_Id', $id);
        $stmt->bindValue('Notes_Gym_Id', $_SESSION['Gym_Id'] ?? 0);

        $stmt->execute();
    }
}
