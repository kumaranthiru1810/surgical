<?php
session_start();
include('../db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';

try {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login to submit your suggestion.'); window.location.href='../login.php';</script>";
        exit;
    }

    $sess_id = $_SESSION['user_id'];
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

    $user_id = $_SESSION['user_id'];
    $suggestion = $_POST['suggestion'];

    if ($suggestion === '') {
        echo "<script>alert('Please enter a suggestion before submitting.'); window.history.back();</script>";
        exit;
    }

    // Insert suggestion into DB
    $stmt = $pdo->prepare("INSERT INTO suggestions (user_id, email, suggestion, created_at) VALUES (:user_id, :email, :suggestion, NOW())");
    $stmt->execute([
        ':user_id' => $user_id,
        ':email' => $email,
        ':suggestion' => $suggestion
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

    $mail->setFrom('thirukumaran18102006@gmail.com', 'Suggestion System');
    $mail->addAddress('thirukumaran18102006@gmail.com', 'Admin'); 
    $mail->isHTML(true);
    $mail->Subject = "New Suggestion from $name";
    $mail->Body = "
        <h3>New Suggestion Submitted</h3>
        <h3>Firm Details</h3>
        <p><strong>Firm Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Whatsapp:</strong> $whatsapp</p>
        <p><strong>Address:</strong> $address</p>
        <p><strong>City:</strong> $city</p>
        <p><strong>Country:</strong> $country</p>
        <p><strong>PinCode:</strong> $pin</p>
        <p><strong>Gst No:</strong> $gst</p>
        <h3>Suggestion</h3>
        <p>$suggestion</p>
    ";

    $mail->send();

    echo "<script>alert('Suggestion submitted and email sent successfully!'); window.location.href='suggestions.php';</script>";
    exit;

} catch (Exception $e) {
    echo "<script>alert('Suggestion not submitted or email failed: {$e->getMessage()}'); window.history.back();</script>";
    exit;
}
?>
