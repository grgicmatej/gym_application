<?php

class Contact
{
    public static function contacts()
    {
        $toEmail = 'info@tinako.hr';

        $mailHeaders = "From: no-reply@tinako.hr" . "\r\n". 'Reply-To:'. Request::post('Contact_Email')."\r\n";

        $emailSubject = 'Upit za gymzone aplikaciju';

        $emailMessage ="Upit za aplikaciju"."\n";
        $emailMessage.="Korisnički email: ".Request::post('Contact_Email')."\n"."\n";
        $emailMessage.="Korisnička poruka: "."\n".Request::post('Contact_Message')."\n"."\n";
        $emailMessage.="Poruka je poslana u: ".date("Y-m-d h:i:sa")."\n"."\n";

        if (mail($toEmail, $emailSubject, $emailMessage, $mailHeaders)) {
            return true;
        } else {
            return false;
        }
    }
}