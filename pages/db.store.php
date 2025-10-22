<?php
include("../db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

require '../PHPmailer/vendor/autoload.php';

$mail = new PHPMailer(true);




// Initialize variables
$locations = [];
$contact_info = [];
$form_submitted = false;
$form_errors = [];
$form_data = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

// Fetch locations from database
try {
    $stmt = $pdo->query("SELECT * FROM locations ORDER BY display_order");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle appropriately
    $locations = []; // Empty array if query fails
}

// Fetch contact information from database
try {
    $stmt = $pdo->query("SELECT * FROM company_info LIMIT 1");
    $contact_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Fallback to default values if query fails
    $contact_info = [
        'phone' => '+91-97909 72432',
        'email' => 'cs@bharathi.co.in',
        'address' => 'Rajapalayam, Tamil Nadu, India'
    ];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

    $form_data['name'] = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $form_data['email'] = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $form_data['subject'] = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $form_data['message'] = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);
    
    // Validate inputs
    if (empty($form_data['name'])) {
        $form_errors['name'] = 'Please enter your full name';
    }
    
    if (empty($form_data['email']) || !filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $form_errors['email'] = 'Please enter a valid email address';
    }
    
    if (empty($form_data['subject'])) {
        $form_errors['subject'] = 'Please enter a subject';
    }
    
    if (empty($form_data['message'])) {
        $form_errors['message'] = 'Please enter your message';
    }
    
    // If no errors, insert into database
    if (empty($form_errors)) {
        try {
            // $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, subject, message, ip_address) 
                                  VALUES (:name, :email, :subject, :message, :ip)");
            $stmt->execute([
                ':name' => $form_data['name'],
                ':email' => $form_data['email'],
                ':subject' => $form_data['subject'],
                ':message' => $form_data['message'],
                ':ip' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $form_submitted = true;
            
            // Clear form data
            $form_data = [
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => ''
            ];
try {
    $to = "srvnkmrmarimuthu@gmail.com";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'srvnkmrmarimuthu@gmail.com';
    $mail->Password = 'nqdm ktju anvb zoqf';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('srvnkmrmarimuthu@gmail.com', 'Bharathi Surgicals:');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = 'Bharathi Surgicals';
    $mail->Body = "
    <html>
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
        <title>Bharathi Surgicals</title>
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
                                href='bharathi.co.in'><img
                                src='https://bharathi-surgicals-products.com.parasuramnurserygarden.com/assets/logo.jpeg'
                                width='130' height='100'
                                alt='Logo' title='Logo' style='color: #000000;
                                font-size: 10px; margin: 0; padding: 0; display: block;' /></a>
                        </td>
                    </tr>
                    <tr>
                    <p>Dear Bharathi Surgicals Team,<br><br>

I hope this message finds you well. I am reaching out to learn more about the medical and surgical products you offer. Could you kindly share details about your product catalog, pricing, and availability?

Additionally, please let me know if you provide bulk order facilities, delivery timelines, and warranty/service support for your products.
<br><br>

Thank you for your assistance.</p>
                    </tr>
                </table>
                <table border='0' cellpadding='0' cellspacing='0' align='center'
                    bgcolor='#FFFFFF'
                    width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                    max-width: 560px;' class='container'>
                    <tr>
                        <td align='left' valign='top' style='padding-left: 20px;'>
                            <h3>User Details:</h3>
                            <p><b>Name:</b> $name</p>
                            <p><b>Email:</b> $email</p>
                            <p><b>Subject:</b>$subject</p>
                            <p><b>Message:</b>$message</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>";

    $mail->send();
    echo "<script>alert('Message has been sent');window.location.href='../index.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');window.location.href='../index.php';</script>";
}
        } catch (PDOException $e) {
            // $form_errors['database'] = 'Sorry, there was an error submitting your message. Please try again.';
            echo "<script>alert('Successfully not submit..');window.location.href='../index.php';</script>";
        }
    }
}
?>