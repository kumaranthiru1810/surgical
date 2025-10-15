<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';
include('../db.php');

header('Content-Type: application/json');

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No data received or invalid JSON']);
    exit;
}

try {
    // Validate required fields
    $required = ['firmName', 'address', 'city', 'pincode', 'mobileNumber', 'email', 'products'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Insert into main quote table
    $stmt = $pdo->prepare("INSERT INTO quotes (firm_name, address, city, pincode, mobile, email) 
                           VALUES (:firm_name, :address, :city, :pincode, :mobile, :email)");
    $stmt->execute([
        ':firm_name' => $data['firmName'],
        ':address'   => $data['address'],
        ':city'      => $data['city'],
        ':pincode'   => $data['pincode'],
        ':mobile'    => $data['mobileNumber'],
        ':email'     => $data['email']
    ]);

    $quote_id = $pdo->lastInsertId();

    // Insert product details
    $stmtProduct = $pdo->prepare("INSERT INTO quote_products (quote_id, product_name, size, quantity)
                                  VALUES (:quote_id, :product_name, :size, :quantity)");

    foreach ($data['products'] as $product) {
        if (!empty($product['name'])) {
            $stmtProduct->execute([
                ':quote_id' => $quote_id,
                ':product_name' => $product['name'],
                ':size' => $product['size'],
                ':quantity' => $product['quantity']
            ]);
        }
    }

    // Build HTML Email Content
    $productRows = '';
    $count = 1;
    foreach ($data['products'] as $product) {
        if (!empty($product['name'])) {
            $productRows .= "
                <tr>
                    <td>{$count}</td>
                    <td>{$product['name']}</td>
                    <td>{$product['quantity']}</td>
                    <td>{$product['size']}</td>
                </tr>";
            $count++;
        }
    }

    $htmlBody = "
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        h2 { color: #0066cc; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 20px; font-size: 14px; color: #555; }
      </style>
    </head>
    <body>
      <h2>New Quote Request</h2>
      <p><strong>Firm Name:</strong> {$data['firmName']}</p>
      <p><strong>Address:</strong> {$data['address']}, {$data['city']} - {$data['pincode']}</p>
      <p><strong>Email:</strong> {$data['email']}</p>
      <p><strong>Mobile Number:</strong> {$data['mobileNumber']}</p>

      <h3>Requested Products</h3>
      <table>
        <tr>
          <th>#</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Size / Description</th>
        </tr>
        {$productRows}
      </table>

      <div class='footer'>
        <p>This quote request was submitted through the website.</p>
      </div>
    </body>
    </html>";

    // Send Email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thirukumaran18102006@gmail.com';
        $mail->Password = 'your-app-password'; // Use App Password, not regular password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('thirukumaran18102006@gmail.com', 'Website Quote Request');
        $mail->addAddress('thirukumaran18102006@gmail.com', 'Bharathi Surgical');

        $mail->isHTML(true);
        $mail->Subject = "New Quote Request - {$data['firmName']}";
        $mail->Body = $htmlBody;

        $mail->send();
        $emailStatus = 'Email sent successfully';

    } catch (Exception $e) {
        $emailStatus = 'Email failed: ' . $mail->ErrorInfo;
        error_log("Mail error: " . $mail->ErrorInfo);
    }

    echo json_encode([
        'status' => 'success', 
        'message' => 'Quote saved successfully. ' . $emailStatus,
        'quote_id' => $quote_id
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'System error: ' . $e->getMessage()]);
}
?>