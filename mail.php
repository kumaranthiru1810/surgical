<?php

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
    $mail->Body = "";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
