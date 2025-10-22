<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';
require_once('../db.php');

$sess_id = $_SESSION['user_id'];

if (!$sess_id) {
    echo "<script>alert('Please login first.'); window.location.href='../login.php';</script>";
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $sess_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $data['firm'];
$email = $data['email'];
$phone = $data['mobile_cc'] . $data['mobile'];
$whatsapp = $data['whatsapp_cc'] . $data['whatsapp'];
$address = $data['address'];
$city = $data['city'];
$country = $data['country'];
$pin = $data['pin'];
$gst = $data['gst'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firmName = $name;
    $invoiceNo = $_POST['invoiceNo'];
    $invoiceDate = $_POST['invoiceDate'];
    $complaintDescription = $_POST['complaintDescription'];

    if ($firmName && $invoiceNo && $invoiceDate && $email && $complaintDescription) {
        try {
            // Store complaint in database
            $stmt = $pdo->prepare("INSERT INTO complaints 
                (firm_name, invoice_no, invoice_date, email, complaint_description)
                VALUES (:firm_name, :invoice_no, :invoice_date, :email, :complaint_description)");
            $stmt->execute([
                ':firm_name' => $firmName,
                ':invoice_no' => $invoiceNo,
                ':invoice_date' => $invoiceDate,
                ':email' => $email,
                ':complaint_description' => $complaintDescription
            ]);

            // Send email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thirukumaran18102006@gmail.com';
            $mail->Password = 'sqdi hluc nhsg sben';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thirukumaran18102006@gmail.com', 'Complaint System');
            $mail->addAddress('thirukumaran18102006@gmail.com', 'Customer Support');
            $mail->isHTML(true);
            $mail->Subject = "New Complaint Received from $firmName";
            $mail->Body = "
                <h3>Complaint Details</h3>
                <p><strong>Firm Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Whatsapp:</strong> $whatsapp</p>
                <p><strong>Address:</strong> $address</p>
                <p><strong>City:</strong> $city</p>
                <p><strong>Country:</strong> $country</p>
                <p><strong>PinCode:</strong> $pin</p>
                <p><strong>Gst No:</strong> $gst</p>
                <h1>Details: </h1>
                <p><strong>Invoice No:</strong> $invoiceNo</p>
                <p><strong>Invoice Date:</strong> $invoiceDate</p>
                <p><strong>Description:</strong><br>$complaintDescription</p>
            ";
            $mail->send();

            echo "<script>alert('Complaint submitted and email sent successfully!'); window.location.href='raise_of_complaint.php';</script>";
            exit();
        } catch (Exception $e) {
            echo "<script>alert('Complaint saved but email could not be sent: {$mail->ErrorInfo}'); window.location.href='raise_of_complaint.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Database error: {$e->getMessage()}'); window.location.href='raise_of_complaint.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit();
    }
}
?>
