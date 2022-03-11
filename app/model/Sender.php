<?php


class Sender
{
    public static function addNewRecipient($usersEmail, $usersId, $membershipEndDate)
    {
        $membershipEndDateTemp=strtotime($membershipEndDate);

        $dateSeconds=($membershipEndDateTemp) - (5 * 86400);
        $membershipEndDate=date('Y-m-d', $dateSeconds);

        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Sender
                            (
                            Sender_Users_Id,
                            Sender_Users_Email,
                            Sender_Date
                            )
                            VALUES
                            (
                            :senderUsersId,
                            :senderUsersEmail,
                            :senderDate
                            )
                            ');
        $stmt->bindValue('senderUsersId', $usersId);
        $stmt->bindValue('senderUsersEmail', $usersEmail->Users_Email);
        $stmt->bindValue('senderDate', $membershipEndDate);
        $stmt->execute();
    }

    public static function addNewRecipientFromExistingMembership($usersEmail, $usersId)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Sender
                            (
                            Sender_Users_Id,
                            Sender_Users_Email,
                            Sender_Date
                            )
                            VALUES
                            (
                            :senderUsersId,
                            :senderUsersEmail,
                            :senderDate
                            )
                            ');
        $stmt->bindValue('senderUsersId', $usersId);
        $stmt->bindValue('senderUsersEmail', $usersEmail->Users_Email);
        $stmt->bindValue('senderDate', date_create(Request::post('Users_Memberships_End_Date'))->modify('-5 days')->format('Y-m-d'));
        $stmt->execute();
    }

    public static function deleteRecipient($usersId)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('DELETE FROM Sender WHERE Sender_Users_Id=:senderUsersId');
        $stmt->bindValue('senderUsersId', $usersId);
        $stmt->execute();
    }
}