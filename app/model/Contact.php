<?php

class Contact
{
    public static function contact()
    {
        $reply = Request::post('Contact_Email');
        $toEmail = 'info@tinako.hr';
        $mailHeaders = 'From: no-reply@tinako.hr' . '\r\n';
        $mailHeaders .= 'Reply-To: '. $reply . '\r\n';
        $mailHeaders .= 'MIME-Version: 1.0\r\n';
        $mailHeaders .= 'Content-Type: text/html; charset=UTF-8\r\n';

        $emailSubject = 'Upit za gymzone aplikaciju';

        $emailMessage = '';

        $emailMessage .="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <title>Gymzone upit</title>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
            </head>
            <body style='margin: 0; padding: 0;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%'> 
                    <tr>
                        <td style='padding: 10px 0 30px 0;'>
                            <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border: 0px solid #cccccc; border-collapse: collapse;'>   
                                <tr>
                                    <td bgcolor='#ffffff' style='padding: 40px 30px 40px 30px;'>
                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                            <tr>
                                                <td style='color: #153643; font-family: Arial, sans-serif; font-size: 24px; text-align: center'>
                                                    <b>Novi upit za aplikaciju</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='text-align: center; padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                    E-mail korisnika: ".$_POST['Contact_Email']."                            
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='text-align: center; padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                    Poruka: ".$_POST['Contact_Message']."                            
                                                </td>
                                            </tr>
                                            <br><br>           
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#333333' style='padding: 30px 30px 30px 30px;'>
                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                            <tr>
                                                <td style='color: #ffffff !important; font-family: Arial, sans-serif; font-size: 14px; text-align: center' width='100%'>
                                                    &reg; tinako ".date('Y')."<br/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";

        if (mail($toEmail, $emailSubject, $emailMessage, $mailHeaders)) {
            return true;
        } else {
            return false;
        }
    }
}