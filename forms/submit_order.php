<?php
session_start();
include('../db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to place an order.']);
    exit();
}

// Function to sanitize input data
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate mobile number
function validateMobile($mobile) {
    return preg_match('/^[0-9]{10}$/', $mobile);
}

// Function to validate GST number
function validateGST($gst) {
    return preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gst);
}

// Function to handle file upload
function handleFileUpload($file, $uploadDir = '../uploads/') {
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = uniqid() . '_' . md5(basename($file['name'])) . '.' . $fileExtension;
    $targetPath = $uploadDir . $fileName;
    
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($fileExtension, $allowedTypes)) {
        throw new Exception('Invalid file type. Only PDF, JPG, JPEG, PNG files are allowed.');
    }
    if ($file['size'] > $maxFileSize) {
        throw new Exception('File size too large. Maximum size is 5MB.');
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new Exception('Invalid file upload.');
    }
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    throw new Exception('Failed to upload file.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        $requiredFields = ['firmName', 'gstNo', 'city', 'country', 'pincode', 'mobileNumber', 'email'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Required field '$field' is missing.");
            }
        }

        $firmName = sanitizeInput($_POST['firmName']);
        $gstNo = sanitizeInput($_POST['gstNo']);
        $address = sanitizeInput($_POST['address'] ?? '');
        $city = sanitizeInput($_POST['city']);
        $country = sanitizeInput($_POST['country']);
        $pincode = sanitizeInput($_POST['pincode']);
        $countryCode = sanitizeInput($_POST['countryCode'] ?? '+91');
        $mobileNumber = sanitizeInput($_POST['mobileNumber']);
        $email = sanitizeInput($_POST['email']);
        $customerName = $_SESSION['name'];
        $userId = $_SESSION['user_id'] ?? null;

        if (!validateEmail($email)) throw new Exception('Invalid email address.');
        if (!validateMobile($mobileNumber)) throw new Exception('Invalid mobile number. Please enter a 10-digit number.');
        if (!validateGST($gstNo)) throw new Exception('Invalid GST number format.');

        $gstCertificatePath = null;
        $drugLicensePath = null;

        if (isset($_FILES['gstCertificate']) && $_FILES['gstCertificate']['error'] === UPLOAD_ERR_OK) {
            $gstCertificatePath = handleFileUpload($_FILES['gstCertificate']);
        }
        if (isset($_FILES['drugLicense']) && $_FILES['drugLicense']['error'] === UPLOAD_ERR_OK) {
            $drugLicensePath = handleFileUpload($_FILES['drugLicense']);
        } else {
            throw new Exception('Drug License is required.');
        }

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

        $orderSql = "INSERT INTO orders (
            user_id, order_number, customer_name, firm_name, gst_no, address, city, 
            country, pincode, country_code, mobile_number, email, 
            gst_certificate, drug_license, order_date, status, created_at
        ) VALUES (
            :user_id, :order_number, :customer_name, :firm_name, :gst_no, :address, :city, 
            :country, :pincode, :country_code, :mobile_number, :email, 
            :gst_certificate, :drug_license, NOW(), 'pending', NOW()
        )";

        $orderStmt = $pdo->prepare($orderSql);
        $orderStmt->execute([
            ':user_id' => $userId,
            ':order_number' => $orderNumber,
            ':customer_name' => $customerName,
            ':firm_name' => $firmName,
            ':gst_no' => $gstNo,
            ':address' => $address,
            ':city' => $city,
            ':country' => $country,
            ':pincode' => $pincode,
            ':country_code' => $countryCode,
            ':mobile_number' => $mobileNumber,
            ':email' => $email,
            ':gst_certificate' => $gstCertificatePath,
            ':drug_license' => $drugLicensePath
        ]);

        $orderId = $pdo->lastInsertId();

        if (isset($_POST['productName']) && is_array($_POST['productName']) && !empty($_POST['productName'][0])) {
            $productSql = "INSERT INTO order_products (
                order_id, product_name, custom_product_name, quality, size, 
                sterility, pieces, width, length, unit, packing, ply, 
                custom_specifications, custom_quality, custom_size, custom_width, quantity, created_at
            ) VALUES (
                :order_id, :product_name, :custom_product_name, :quality, :size, 
                :sterility, :pieces, :width, :length, :unit, :packing, :ply, 
                :custom_specifications, :custom_quality, :custom_size, :custom_width, :quantity, NOW()
            )";

            $productStmt = $pdo->prepare($productSql);

            foreach ($_POST['productName'] as $index => $productName) {
                $productName = sanitizeInput($productName);
                if (empty($productName)) continue;

                $quality = sanitizeInput($_POST['quality'][$index] ?? '');
                $size = sanitizeInput($_POST['size'][$index] ?? '');
                $sterility = sanitizeInput($_POST['sterility'][$index] ?? '');
                $pieces = !empty($_POST['pieces'][$index]) ? (int)$_POST['pieces'][$index] : null;
                $width = sanitizeInput($_POST['width'][$index] ?? '');
                $length = sanitizeInput($_POST['length'][$index] ?? '');
                $unit = sanitizeInput($_POST['unit'][$index] ?? '');
                $packing = sanitizeInput($_POST['packing'][$index] ?? '');
                $ply = sanitizeInput($_POST['ply'][$index] ?? '');
                $customSpecifications = sanitizeInput($_POST['custom_specifications'][$index] ?? '');
                $customProductName = sanitizeInput($_POST['customProductName'][$index] ?? '');
                $quantity = !empty($_POST['productQuantity'][$index]) ? (int)$_POST['productQuantity'][$index] : 1;

                $customQuality = sanitizeInput($_POST['custom_quality'][$index] ?? '');
                $customSize = sanitizeInput($_POST['custom_size'][$index] ?? '');
                $customWidth = sanitizeInput($_POST['custom_width'][$index] ?? '');

                if ($quantity < 1) throw new Exception('Quantity must be at least 1.');

                $productStmt->execute([
                    ':order_id' => $orderId,
                    ':product_name' => $productName,
                    ':custom_product_name' => $customProductName,
                    ':quality' => $quality,
                    ':size' => $size,
                    ':sterility' => $sterility,
                    ':pieces' => $pieces,
                    ':width' => $width,
                    ':length' => $length,
                    ':unit' => $unit,
                    ':packing' => $packing,
                    ':ply' => $ply,
                    ':custom_specifications' => $customSpecifications,
                    ':custom_quality' => $customQuality,
                    ':custom_size' => $customSize,
                    ':custom_width' => $customWidth,
                    ':quantity' => $quantity
                ]);
            }
        } else {
            throw new Exception('At least one product is required.');
        }

        $pdo->commit();

        /** -------- SEND EMAIL -------- **/
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thirukumaran18102006@gmail.com';  // your sender email
            $mail->Password = 'sqdi hluc nhsg sben';     // your app password (not normal password)
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thirukumaran18102006@gmail.com', 'Bharathi Medical Supplies');
            $mail->addAddress('thirukumaran18102006@gmail.com'); // Admin email
            // $mail->addAddress(''); // Customer email

            $mail->isHTML(true);
            $mail->Subject = "New Order Received - {$orderNumber}";
            $mail->Body = "
                <h3>New Order Received</h3>
                <p><strong>Order Number:</strong> {$orderNumber}</p>
                <p><strong>Customer:</strong> {$customerName}</p>
                <p><strong>Firm Name:</strong> {$firmName}</p>
                <p><strong>GST:</strong> {$gstNo}</p>
                <p><strong>City:</strong> {$city}, {$country}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Mobile:</strong> {$countryCode} {$mobileNumber}</p>
                <br>
                <p>Thank you for your order. We will contact you shortly.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Order placed successfully! Your order number is: ' . $orderNumber . '. A confirmation email has been sent.',
            'order_number' => $orderNumber
        ]);

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Order submission error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Only POST requests are allowed.']);
}
?>
