<?php

ini_set('max_execution_time','10000');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
        

    function send_mail($to, $subject, $message, $attachments = false, $attachment_name = 'Project Bill.pdf')
    {

        $mail = new PHPMailer(true);
        
        try {
            // $mail->SMTPDebug = 2;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'prasathaviswa@gmail.com';      // SMTP username
            $mail->Password = 'prasatha';                       // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
                                                                  // Set email format to HTML
            if($attachments != false)
            {
                $mail->addAttachment($attachments, $attachment_name ,$encoding = 'base64');
            } 

            $mail->Subject = $subject;
            $mail->isHTML(true);   
            $mail->Body = $message;
            
            
            if(is_array($to))
            {   
                $to = array_unique($to);
                
                $to = array_values($to);

                for ($i=0; $i<count($to); $i++) 
                { 
    
                    $mail->setFrom("prasathaviswa@gmail.com","AnjanaInfotech Admin");
                    $mail->addAddress($to[$i]);
                    
                }
            }
            else
            {
                
                $mail->setFrom("prasathaviswa@gmail.com","AnjanaInfotech Admin");
                $mail->addAddress($to);
                
            }
            // $mail->send()

           

            if($mail->send())
            {//
                // $result = array(
                //     'error' => 0,
                //     'msg' => 'Mail sent successfully !!'
                // );
                // echo json_encode($result);
                return true;
            }
            else
            {
                // $result = array(
                //     'error' => 2,
                //     'msg' => 'Failed to send the message !!'
                // );
                // echo json_encode($result);
                return false;
            }
        } catch (Exception $e) {
    
            // $result = array(
            //     'error' => $e,
            //     'msg' => 'Failed to send the message !!'
            // );
            // echo json_encode($result);
            // exit();
            return false;
        }
    }
        

?>
