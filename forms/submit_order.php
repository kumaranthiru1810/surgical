<?php
session_start();
include('../db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/autoload.php';

if (!isset($_SESSION['name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to place an order.']);
    exit();
}

$sess_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    $productNames = $_POST['productName'] != '' ? $_POST['productName'] : [];
    $quantities   = $_POST['productQuantity'] != '' ? $_POST['productQuantity'] : [];
    $customProductNames = $_POST['customProductName'] ?? [];
    $qualities = $_POST['quality'] ?? [];
    $sizes = $_POST['size'] ?? [];
    $sterilities = $_POST['sterility'] ?? [];
    $pieces = $_POST['pieces'] ?? [];
    $widths = $_POST['width'] ?? [];
    $lengths = $_POST['length'] ?? [];
    $units = $_POST['unit'] ?? [];
    $packings = $_POST['packing'] ?? [];
    $plies = $_POST['ply'] ?? [];
    $exrays = $_POST['x-ray'] ?? [];
    $contents = $_POST['contents'] ?? [];
    $weights = $_POST['weight'] ?? [];
    $customSpecs = $_POST['custom_specifications'] ?? [];
    $customQualities = $_POST['custom_quality'] ?? [];
    $customSizes = $_POST['custom_size'] ?? [];
    $customWidths = $_POST['custom_width'] ?? [];

    if (!is_array($productNames) || empty($productNames[0])) {
        echo json_encode(['status' => 'error', 'message' => 'At least one product is required.']);
        exit();
    }

    try {
        $pdo->beginTransaction();

        $productSql = "INSERT INTO order_products (
            email, product_name, custom_product_name, quality, size, sterility,
            pieces, width, length, unit, packing, ply, x_ray, contents, weight, custom_specifications,
            custom_quality, custom_size, custom_width, quantity, created_at
        ) VALUES (
            :email, :product_name, :custom_product_name, :quality, :size, :sterility,
            :pieces, :width, :length, :unit, :packing, :ply, :x_ray, :contents, :weight, :custom_specifications,
            :custom_quality, :custom_size, :custom_width, :quantity, NOW()
        )";

        $productStmt = $pdo->prepare($productSql);
        $productDetails = [];

        foreach ($productNames as $index => $productName) {
            if (empty($productName)) continue;

            $quantity = !empty($quantities[$index]) ? (int)$quantities[$index] : 1;
            
            // Determine actual product name
            $actualProductName = $productName;
            if ($productName === 'Custom Product' && !empty($customProductNames[$index])) {
                $actualProductName = $customProductNames[$index];
            }

            // Build product details array for email
            $productDetail = [
                'name' => $actualProductName,
                'quantity' => $quantity,
                'specifications' => []
            ];

            // Add all specifications
            if (!empty($qualities[$index])) {
                $qualityValue = $qualities[$index];
                if (!empty($customQualities[$index]) && strpos($qualityValue, 'Custom') !== false) {
                    $qualityValue .= " - " . $customQualities[$index];
                }
                $productDetail['specifications'][] = "Quality: " . $qualityValue;
            }

            if (!empty($sizes[$index])) {
                $sizeValue = $sizes[$index];
                if (!empty($customSizes[$index]) && strpos($sizeValue, 'Custom') !== false) {
                    $sizeValue .= " - " . $customSizes[$index];
                }
                $productDetail['specifications'][] = "Size: " . $sizeValue;
            }

            if (!empty($sterilities[$index])) {
                $productDetail['specifications'][] = "Sterility: " . $sterilities[$index];
            }

            if (!empty($pieces[$index])) {
                $productDetail['specifications'][] = "Pieces: " . $pieces[$index];
            }

            if (!empty($widths[$index])) {
                $widthValue = $widths[$index];
                if (!empty($customWidths[$index]) && strpos($widthValue, 'Custom') !== false) {
                    $widthValue .= " - " . $customWidths[$index];
                }
                $productDetail['specifications'][] = "Width: " . $widthValue;
            }

            if (!empty($lengths[$index])) {
                $productDetail['specifications'][] = "Length: " . $lengths[$index];
            }

            if (!empty($units[$index])) {
                $productDetail['specifications'][] = "Unit: " . $units[$index];
            }

            if (!empty($packings[$index])) {
                $productDetail['specifications'][] = "Packing: " . $packings[$index];
            }

            if (!empty($plies[$index])) {
                $productDetail['specifications'][] = "Ply: " . $plies[$index];
            }

            if (!empty($weights[$index])) {
                $productDetail['specifications'][] = "Weight: " . $weights[$index];
            }
            if (!empty($exrays[$index])) {
                $productDetail['specifications'][] = "X-Ray Detectable: " . $exrays[$index];
            }

            if (!empty($contents[$index])) {
                $productDetail['specifications'][] = "Contents: " . $contents[$index];
            }   

            if (!empty($customSpecs[$index])) {
                $productDetail['specifications'][] = "Specifications: " . $customSpecs[$index];
            }

            $productDetails[] = $productDetail;

            // Insert into database
            // Insert into database
$productStmt->execute([
    ':email'                 => $email,
    ':product_name'          => $productName,
    ':custom_product_name'   => $customProductNames[$index] ?? '',
    ':quality'               => $qualities[$index] ?? '',
    ':size'                  => $sizes[$index] ?? '',
    ':sterility'             => $sterilities[$index] ?? '',
    ':pieces'                => $pieces[$index] ?? '',
    ':width'                 => $widths[$index] ?? '',
    ':length'                => $lengths[$index] ?? '',
    ':unit'                  => $units[$index] ?? '',
    ':packing'               => $packings[$index] ?? '',
    ':ply'                   => $plies[$index] ?? '',
    ':x_ray'                 => $exrays[$index] ?? '',
    ':contents'              => !empty($contents[$index]) ? $contents[$index] : '', // Fixed line
    ':weight'                => $weights[$index] ?? '',
    ':custom_specifications' => $customSpecs[$index] ?? '',
    ':custom_quality'        => $customQualities[$index] ?? '',
    ':custom_size'           => $customSizes[$index] ?? '',
    ':custom_width'          => $customWidths[$index] ?? '',
    ':quantity'              => $quantity,
]);
        }

        $pdo->commit();

        /** -------- SEND EMAIL WITH PRODUCT DETAILS -------- **/
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thirukumaran18102006@gmail.com'; // Replace with your company email
            $mail->Password = 'sqdi hluc nhsg sben'; // Replace with your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('thirukumaran18102006@gmail.com', 'Bharathi Surgicals');
            $mail->addAddress('thirukumaran18102006@gmail.com'); // Replace with your order email
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Product Order from $name";
            
            // Build email body with all product details
            $mail->Body = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
                        .header { background: #007BFF; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                        .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 5px 5px; }
                        .section { margin-bottom: 20px; padding: 15px; background: white; border-radius: 5px; border-left: 4px solid #007BFF; }
                        .product-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                        .product-table th { background: #007BFF; color: white; padding: 12px; text-align: left; }
                        .product-table td { padding: 12px; border-bottom: 1px solid #ddd; }
                        .product-table tr:nth-child(even) { background: #f2f2f2; }
                        .specs-list { margin: 5px 0; padding-left: 20px; }
                        .specs-list li { margin-bottom: 3px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>New Product Order Received</h1>
                            <p>Order Date: " . date('Y-m-d H:i:s') . "</p>
                        </div>
                        
                        <div class='content'>
                            <div class='section'>
                                <h2>Customer Details</h2>
                                <table style='width: 100%;'>
                                    <tr><td><strong>Firm Name:</strong></td><td>$name</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>$email</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>$phone</td></tr>
                                    <tr><td><strong>WhatsApp:</strong></td><td>$whatsapp</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>$address</td></tr>
                                    <tr><td><strong>City:</strong></td><td>$city</td></tr>
                                    <tr><td><strong>Country:</strong></td><td>$country</td></tr>
                                    <tr><td><strong>PinCode:</strong></td><td>$pin</td></tr>
                                    <tr><td><strong>GST No:</strong></td><td>$gst</td></tr>
                                </table>
                            </div>
                            
                            <div class='section'>
                                <h2>Order Details</h2>
                                <table class='product-table'>
                                    <thead>
                                        <tr>
                                            <th>Product #</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Specifications</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

            // Add each product with all specifications
            foreach ($productDetails as $index => $product) {
                $productNumber = $index + 1;
                $specsHtml = '';
                
                if (!empty($product['specifications'])) {
                    $specsHtml = "<ul class='specs-list'>";
                    foreach ($product['specifications'] as $spec) {
                        $specsHtml .= "<li>" . htmlspecialchars($spec) . "</li>";
                    }
                    $specsHtml .= "</ul>";
                } else {
                    $specsHtml = "No additional specifications";
                }

                $mail->Body .= "
                    <tr>
                        <td><strong>$productNumber</strong></td>
                        <td><strong>" . htmlspecialchars($product['name']) . "</strong></td>
                        <td><strong>" . $product['quantity'] . "</strong></td>
                        <td>$specsHtml</td>
                    </tr>";
            }

            $mail->Body .= "
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class='section'>
                                <h3>Order Summary</h3>
                                <p><strong>Total Products:</strong> " . count($productDetails) . "</p>
                                <p><strong>Total Items:</strong> " . array_sum(array_column($productDetails, 'quantity')) . "</p>
                                <p>This order was placed through the website order form.</p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ";

            // Alternative plain text version
            $plainText = "NEW PRODUCT ORDER\n";
            $plainText .= "================\n\n";
            $plainText .= "Customer: $name\n";
            $plainText .= "Email: $email\n";
            $plainText .= "Phone: $phone\n";
            $plainText .= "Date: " . date('Y-m-d H:i:s') . "\n\n";
            $plainText .= "PRODUCTS:\n";
            $plainText .= "---------\n";
            
            foreach ($productDetails as $index => $product) {
                $productNumber = $index + 1;
                $plainText .= "$productNumber. {$product['name']} (Qty: {$product['quantity']})\n";
                if (!empty($product['specifications'])) {
                    foreach ($product['specifications'] as $spec) {
                        $plainText .= "   - $spec\n";
                    }
                }
                $plainText .= "\n";
            }
            
            $plainText .= "Total Products: " . count($productDetails) . "\n";
            $plainText .= "Total Items: " . array_sum(array_column($productDetails, 'quantity')) . "\n";

            $mail->AltBody = $plainText;

            $mail->send();
            
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            // Continue even if email fails
        }

        echo "<script>alert('Order placed successfully! We will contact you shortly.');window.location.href='request_sample.php';</script>";
        
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo "<script>alert('Submission failed: " . addslashes($e->getMessage()) . "');window.location.href='request_sample.php';</script>";
    }
}
?>