 <?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

require '../PHPmailer/vendor/autoload.php';

$mail = new PHPMailer(true);

file_put_contents("debug.log", print_r($_SERVER, true), FILE_APPEND);

// Database configuration
$db_config = [
    'host' => 'localhost',
    'dbname' => 'vyasawom_surgical',
    'username' => 'vyasawom_surgical',
    'password' => 'Surgical@2025'
];

// Function to get DB connection
function getDBConnection() {
    global $db_config;
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host={$db_config['host']};dbname={$db_config['dbname']}",
                $db_config['username'],
                $db_config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO inquiries (product_name, name, email, phone, message, quantity) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['productName'] ?? '',
            $_POST['name'] ?? '',
            $_POST['email'] ?? '',
            $_POST['phone'] ?? '',
            $_POST['message'] ?? '',
            $_POST['quantity'] ?? null
        ]);

        echo json_encode(["status" => "success", "message" => "Inquiry submitted successfully!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

if(isset($_POST['submit'])){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $quantity = $_POST['quantity'];

try {
    $to = "thirukumaran18102006@gmail.com";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thirukumaran18102006@gmail.com';
    $mail->Password = 'knph zmxm mibl zshz';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('thirukumaran18102006@gmail.com', 'Inquery Detail:');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = 'Inquery Details';
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
                                src='../assets/logo.png'
                                width='130' height='150'
                                alt='Logo' title='Logo' style='color: #000000;
                                font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;' /></a>
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
                            <h3>Leader Details:</h3>
                            <p><h4>Product Name:</h4></p>
                            <p><b>Name:</b> $name</p>
                            <p><b>Email:</b> $email</p>
                            <p><b>Subject:</b> $phone</p>
                            <p><b>Message:</b>  $message</p>
                            <p><b>Message:</b> $quantity</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>";

    $mail->send();
    echo "<script>alert('Message has been sent');window.location.href='./Products.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');window.location.href='../Products.php';</script>";
}
}

?>


