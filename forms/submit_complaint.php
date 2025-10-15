<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';
require_once('../db.php');

// Always send JSON response
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firmName = trim($_POST['firmName'] ?? '');
    $invoiceNo = trim($_POST['invoiceNo'] ?? '');
    $invoiceDate = $_POST['invoiceDate'] ?? '';
    $countryCode = $_POST['countryCode'] ?? '';
    $mobileNumber = trim($_POST['mobileNumber'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $complaintDescription = trim($_POST['complaintDescription'] ?? '');

    if ($firmName && $invoiceNo && $invoiceDate && $mobileNumber && $email && $complaintDescription) {
        try {
            // Insert complaint into DB
            $stmt = $pdo->prepare("INSERT INTO complaints 
                (firm_name, invoice_no, invoice_date, country_code, mobile_number, email, complaint_description)
                VALUES (:firm_name, :invoice_no, :invoice_date, :country_code, :mobile_number, :email, :complaint_description)");

            $stmt->execute([
                ':firm_name' => $firmName,
                ':invoice_no' => $invoiceNo,
                ':invoice_date' => $invoiceDate,
                ':country_code' => $countryCode,
                ':mobile_number' => $mobileNumber,
                ':email' => $email,
                ':complaint_description' => $complaintDescription
            ]);

            // Send email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thirukumaran18102006@gmail.com';
            $mail->Password = 'sqdi hluc nhsg sben'; // App password only
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thirukumaran18102006@gmail.com', 'Complaint System');
            $mail->addAddress('thirukumaran18102006@gmail.com', 'Customer Support');

            $mail->isHTML(true);
            $mail->Subject = "New Complaint Received from $firmName";
            $mail->Body = "
                <h3>Complaint Details</h3>
                <p><strong>Firm Name:</strong> $firmName</p>
                <p><strong>Invoice No:</strong> $invoiceNo</p>
                <p><strong>Invoice Date:</strong> $invoiceDate</p>
                <p><strong>Contact:</strong> $countryCode $mobileNumber</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Description:</strong><br>$complaintDescription</p>
            ";

            $mail->send();

            $response = ['status' => 'success', 'message' => 'Complaint submitted and email sent successfully!'];

        } catch (Exception $e) {
            $response = ['status' => 'warning', 'message' => 'Complaint saved but email could not be sent: ' . $mail->ErrorInfo];
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Please fill all required fields.'];
    }
}

// Output JSON
echo json_encode($response);
exit;
?>
