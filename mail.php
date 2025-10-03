<?php
// include('../db.php');

// $lpassword = "1234";
// $name = "thangapandian";
// $phoneno = "9876543210";
// $email = "mailtosakthisaravanan@gmail.com";
// $teamid = 12;

$msql = "SELECT distinct pname, password FROM participants WHERE teamid = $teamid";
$mres = $con->query($msql);

$participantTable = "";
$sno = 1;
foreach ($mres as $val) {
    $participantTable .= "
    <tr>
        <td style='border: 1px solid #000000; padding: 5px;'>$sno</td>
        <td style='border: 1px solid #000000; padding: 5px;'>{$val['pname']}</td>
        <td style='border: 1px solid #000000; padding: 5px;'>{$val['password']}</td>
    </tr>";
    $sno++;
}

$msql1 = "
    SELECT 
        p.pname, 
        GROUP_CONCAT(e.evname ORDER BY e.evname SEPARATOR ', ') as event_names 
    FROM 
        participants p
    JOIN 
        event e ON p.event = e.eventid 
    WHERE 
        p.teamid = '$teamid'
    GROUP BY 
        p.pname";

$mres1 = $con->query($msql1);

$eventTable = "";
$sno = 1;
foreach ($mres1 as $val1) {
    $eventTable .= "
    <tr>
        <td style='border: 1px solid #000000; padding: 5px;'>$sno</td>
        <td style='border: 1px solid #000000; padding: 5px;'>{$val1['pname']}</td>
        <td style='border: 1px solid #000000; padding: 5px;'>{$val1['event_names']}</td>
    </tr>";
    $sno++;
}






use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require './PHPmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './PHPmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

require './PHPmailer/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'anjacstrataofficial@gmail.com';
    $mail->Password = 'krmm xnpi vzwm bokl';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('anjacstrataofficial@gmail.com', 'Strata:');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Strata';
    $mail->Body = "
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='content-type' content='text/html; charset=utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0;'>
        <meta name='format-detection' content='telephone=no'/>
        <style>
        body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
        body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        #outlook a { padding: 0; }
        .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
        @media all and (min-width: 560px) {
            .container { border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; -khtml-border-radius: 0px;}
        }
        a, a:hover { color: #B72C43; }
        .footer a, .footer a:hover { color: #999999; }
        </style>
        <title>Strata-2K24</title>
    </head>
    <body topmargin='0' rightmargin='0' bottommargin='0' leftmargin='0' marginwidth='0' marginheight='0' width='100%' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
        background-color: #F0F0F0; color: #000000;' bgcolor='#F0F0F0' text='#000000'>
    
    <table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;' class='background'>
        <tr>
            <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;' bgcolor='#ffffff'>
                <table border='0' cellpadding='0' cellspacing='0' align='center'
                    width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                    max-width: 560px;' class='wrapper'>
                    <tr>
                        <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                            padding-top: 20px; padding-bottom: 20px;'>
                            <a target='_blank' style='text-decoration: none;'
                                href='https://anjacstrata.in'><img border='0' vspace='0' hspace='0'
                                src='http://strata.friendsmobile.net/strataadmin/uploads/competitionlogo/maillogo.jpg'
                                width='130' height='150'
                                alt='Logo' title='Logo' style='color: #000000;
                                font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;' /></a>
                        </td>
                    </tr>
                </table>
                <table border='0' cellpadding='0' cellspacing='0' align='center'
                    bgcolor='#FFFFFF'
                    width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                    max-width: 560px;' class='container'>
                    <tr>
                        <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
                            padding-top: 25px;
                            color: #000000;
                            font-family: sans-serif;' class='header'>
                                Welcome to Strata -<b>2K24</b>
                                <p>August-30</p>
                        </td>
                    </tr>
                    <tr>
                        <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                            font-size: 17px; font-weight: 400; line-height: 160%;
                            padding-top: 20px;
                            color: #000000;
                            font-family: sans-serif;' class='paragraph'>
                                Thanks for registering with Strata 2K24.
                        </td>
                    </tr>
                    <tr>
                     <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                            font-size: 17px; font-weight: 400; line-height: 160%;
                            padding-top: 20px;
                            color: #000000;
                            font-family: sans-serif;' class='paragraph'>
                                STRATA’24, The Inter-Collegiate competition being conducted by the department of computer science every year is a technical platform wherein the tech savvy students showcase their presentation, quizzy, programming and marketing talents.
                        </td>
                    </tr>
                    <tr>
                        <td align='left' valign='top' style='padding-left: 20px;'>
                            <h3>Leader Details:</h3>
                            <p><b>Name:</b> $name</p>
                            <p><b>Phone:</b> $phoneno</p>
                            <p><b>Email:</b> $email</p>
                            <p><b>Password:</b>$lpassword</p>
                            <p><b>Lot Name:</b>$lotname</p>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' valign='top' style='padding-left: 20px; padding-top: 20px;'>
                            <h3>Participants Details:</h3>
                            <table style='border-collapse: collapse; width: 100%;'>
                                <tr>
                                    <th style='border: 1px solid #000000; padding: 5px;'>S.No</th>
                                    <th style='border: 1px solid #000000; padding: 5px;'>User Name</th>
                                    <th style='border: 1px solid #000000; padding: 5px;'>Password</th>
                                </tr>
                                $participantTable
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' valign='top' style='padding-left: 20px; padding-top: 20px;'>
                            <h3>Events Details:</h3>
                            <table style='border-collapse: collapse; width: 100%;'>
                                <tr>
                                    <th style='border: 1px solid #000000; padding: 5px;'>S.No</th>
                                    <th style='border: 1px solid #000000; padding: 5px;'>Participant Name</th>
                                    <th style='border: 1px solid #000000; padding: 5px;'>Event</th>
                                </tr>
                                $eventTable
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' valign='top' style='padding-left: 20px; padding-top: 25px;'>
        <h3>Contact Details:</h3>
        <p><b>Convener:</b> Dr.V.Jayakumar M.Sc.,M.Phil.,M.B.A.,Ph.D. - 9655081108</p>
        <p><b>Co-ordinator:</b> Dr.A.Dharmarajan M.Sc.,M.Phil.,M.Tech.,Ph.D. - 9751624123</p>
        <p><b>Co-ordinator:</b> Mrs.S.Yogalakshmi M.Sc.,M.Phil.,NET., - 7639535161</p>
        <p><b>Email:</b> <a href='mailto:anjacstrataofficial@gmail.com'>anjacstrataofficial@gmail.com</a></p>
        <p><b>Website:</b> <a href='http://anjacstrata.in'>anjacstrata.in</a></p>
        <p><b>App:</b> <a href='https://play.google.com/store/apps/details?id=com.anjacarchistra.kvm.stratafest'>StrataFest</a></p>
    </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
