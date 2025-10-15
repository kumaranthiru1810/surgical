<?php
session_start();
if (!(isset($_SESSION['name']))) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Please login to access this page.']);
    exit();
}

require_once('../db.php');

// Always send JSON response
header('Content-Type: application/json');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPmailer/vendor/autoload.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate required fields
        $required_fields = ['firmName', 'email', 'countryCode', 'mobileNumber', 'suggestion'];
        foreach ($required_fields as $field) {
            if (empty(trim($_POST[$field]))) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        $firm_name = trim($_POST['firmName']);
        $email = trim($_POST['email']);
        $country_code = trim($_POST['countryCode']);
        $mobile_number = trim($_POST['mobileNumber']);
        $wa_same = isset($_POST['sameWhatsapp']);
        $wa_country_code = $wa_same ? $country_code : trim($_POST['waCountryCode']);
        $whatsapp_number = $wa_same ? $mobile_number : trim($_POST['whatsappNumber']);
        $suggestion = trim($_POST['suggestion']);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please enter a valid email address.");
        }

        // Validate mobile number
        if (!preg_match('/^\d{10}$/', $mobile_number)) {
            throw new Exception("Mobile number must be 10 digits.");
        }

        // Save to DB
        $stmt = $pdo->prepare("INSERT INTO suggestions (firm_name, email, country_code, mobile_number, whatsapp_country_code, whatsapp_number, suggestion_description) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt->execute([$firm_name, $email, $country_code, $mobile_number, $wa_country_code, $whatsapp_number, $suggestion])) {
            throw new Exception("Failed to save suggestion to database.");
        }

        // Send Email
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thirukumaran18102006@gmail.com';
            $mail->Password = 'sqdi hluc nhsg sben';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thirukumaran18102006@gmail.com', 'Bharathi CS Website');
            $mail->addAddress('thirukumaran18102006@gmail.com', 'Suggestions');
            
            $mail->isHTML(true);
            $mail->Subject = "New Suggestion Received from $firm_name";

            $mail->Body = "
                <h3>New Suggestion Submitted</h3>
                <p><strong>Firm Name:</strong> {$firm_name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Mobile:</strong> {$country_code} {$mobile_number}</p>
                <p><strong>WhatsApp:</strong> {$wa_country_code} {$whatsapp_number}</p>
                <p><strong>Suggestion:</strong><br>{$suggestion}</p>
            ";

            $mail->send();
            $response = ['status' => 'success', 'message' => 'Suggestion submitted successfully!'];
            
        } catch (Exception $e) {
            // Email failed but data was saved
            $response = ['status' => 'success', 'message' => 'Suggestion submitted! (Email notification failed)'];
        }

    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
}

echo json_encode($response);
exit;
?>