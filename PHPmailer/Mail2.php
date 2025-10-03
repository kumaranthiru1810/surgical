<?php

ini_set('max_execution_time','10000');


function send_mail($receipants, $subject, $message, $attachments = false, $attachment_name = 'Project Bill.pdf')
{

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    $headers .= 'From: <Anjanainfotech.in>' . "\r\n";
    $headers .= 'Cc: mailtoanjanainfotech@gmail.com' . "\r\n";

    $to = '';

    if(is_array($receipants))
    {
        for( $i = 0; $i< count($receipants); $i++  )
        {
            $to.= $receipants[ $i ].',';
        }
        
        $to = rtrim( $to, "," );
        
    }
    else
    {
        $to = $receipants;
    }
    
    
    
    
    $html = '<div style="width: 100%;display: block">
    <div>
        <div style="text-align: center;width: 100%;padding: 8px;">
            <img src="https://admin.sbkc.in/assets/images/logo.png" width="72" height="72" style="float: left;">
            <h2> <span style="color: #d41378;" >A</span><span style="color:#262626" >njana</span> <span style="color: #d41378;">I</span> <span style="color:#262626"> nfotech</span></h2>
        </div>
        <hr style=" width: 100%;background-color: #d41378;height: 4px;border-radius: 8px;"/>
        <div style="margin-top: 5px;text-align: center;">
            <img style="width: 100%" src="https://admin.sbkc.in/assets/images/mail.png">
        </div>
        <div style="width: 100%;text-align: center;color: #d41378;">
            <h3>'.$subject.'</h3>
        </div>
        <div style="width: 100%;text-align: center;margin-top:-12px;color: #262626;">
            <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            '. $message .'
            </p>
        </div>
        <hr style=" width: 100%;background-color: #d41378;height: 4px;border-radius: 8px;"/>
        <div style="width: 100%;text-align: center;">
            For more details visit <a href="https://new.sbkc.in/" style="text-decoration: none;color: #d41378;font-weight: bold;" target="_blank">Anjana Infotech</a>
        </div> 
    </div>
</div>';
    
    
    if( $attachments != false )
    {
       $headers .= "Content-Type: application/image;name=\" $attachment_name  \"\r\n"
                  ."Content-Transfer-Encoding: base64\r\n"
                  ."Content-disposition: attachment; file=\"$attachments\"\r\n"
                  ."\r\n"
                  .chunk_split(base64_encode($attachments))
                  ."--1a2a3a--"; 
    }
    
    
    
    if(mail($to,$subject,$html, $headers))
    {
        return true;
    }
    else
    {
        return false;
    }


}
?>
