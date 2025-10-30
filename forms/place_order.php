<?php
session_start();
if (!(isset($_SESSION['name']))) {
    echo "<script>alert('Please login to access this page.');window.location.href='../pages/signin.php';</script>";
    exit();
}
include('../db.php');
?>

<?php
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
?>

<?php
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
if ($sql->rowCount() > 0) {
    $data = $sql->fetch(PDO::FETCH_ASSOC);
}

$sql1 = $pdo->query("SELECT * FROM social_links WHERE id = 1");
if ($sql1->rowCount() > 0) {
    $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        .helper-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .helper-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #007BFF;
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .helper-toggle:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .helper-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 220px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            transition: all 0.3s ease;
        }

        .helper-menu.active {
            display: block;
            animation: slideUp 0.3s forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .helper-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .helper-menu ul li {
            border-bottom: 1px solid #f0f0f0;
        }

        .helper-menu ul li:last-child {
            border-bottom: none;
        }

        .helper-menu ul li a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .helper-menu ul li a:hover {
            background-color: #f8f9fa;
            color: #007BFF;
            padding-left: 25px;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .page-header {
            color: rgb(0, 0, 0);
            padding: 10px 0;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .form-label {
            font-weight: 500;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .submit-btn {
            margin-top: 20px;
        }

        .product-row {
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        /* .remove-product {
            cursor: pointer;
            color: #dc3545;
        } */

        .place_order {
            margin-top: 100px !important;
            margin-bottom: 100px !important;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            margin: 10px 0;
        }

        .file-upload input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            cursor: pointer;
            display: block;
        }

        .file-upload-label {
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            text-align: center;
            background-color: #f8f9fa;
        }

        .dynamic-field {
            margin-top: 10px;
        }

        .custom-input {
            display: none;
        }


        /* CAPTCHA Styles */
        .captcha-container {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .captcha-display {
            font-family: 'Courier New', monospace;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            background: linear-gradient(45deg, #333, #666);
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 10px;
            user-select: none;
        }

        .captcha-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .captcha-input {
            flex-grow: 1;
            margin-right: 10px;
        }

        .captcha-refresh {
            background: none;
            border: none;
            color: #0d6efd;
            cursor: pointer;
            font-size: 18px;
        }

        .captcha-refresh:hover {
            color: #0a58ca;
        }

        .captcha-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .captcha-controls {
                flex-direction: column;
                gap: 10px;
            }

            .captcha-input {
                margin-right: 0;
                width: 100%;
            }
        }

        .another-btn {
            display: none;
        }

        input {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <div style="position: sticky; top:0; z-index:9999; background-color:white;">
        <nav class="respon2">
            <div class="container">
                <div class="row">
                    <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                        <div class="contact-info text-start">
                            <div>
                                <a href="mailto:<?php echo $data['email']; ?>" class="phone text-decoration-none text-dark">
                                    <i class="bi bi-envelope-fill"></i><?php echo $data['email']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-1 col-sm-4 col-xs-6">
                        <div class="social-icons text-center">
                            <a href="<?php echo $data1['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                            <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" id="nav-open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                        <div class="contact-info text-end">
                            <div>
                                <a href="tel:+919790972432" class="phone text-decoration-none text-dark"><i class="bi bi-telephone"></i></a>
                                <a href="#" id="top-whatsapp" class="phone text-decoration-none text-dark">
                                    <i class="bi bi-whatsapp"></i><?php echo $data['phone']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <nav class="respon">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 mt-1 col-sm-6 col-xs-6" style="display: flex; justify-content: center; align-items: center;">
                        <div class="social-icons">
                            <a href="<?php echo $data1['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                            <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" id="nav-open-chat2" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-4 col-sm-3 col-xs-3">
                        <div class="contact-info text-start">
                            <div>
                                <a href="mailto:<?php echo $data['email']; ?>" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-envelope-fill"></i><?php echo $data['email']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 col-sm-3 col-xs-3">
                        <div class="contact-info text-end">
                            <div>
                                <a href="tel:+919790972432" class="phone1 text-decoration-none text-dark"><i class="bi bi-telephone"></i></a>
                                <a href="#" id="top-whatsapp2" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-whatsapp"></i><?php echo $data['phone']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="../index.php">
                    <div class="d-flex align-items-center">
                        <img src="../assets/logo.jpeg" alt="Logo" class="me-2">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/Products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/Management.php">Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./place_order.php">Place Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/contact-us.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a class="btn btn-primary me-3">HI, <?php echo $_SESSION['name']; ?></a>
                            <?php } else { ?>
                                <a href="../pages/signup.php" class="btn btn-primary me-3">Sign Up</a>
                            <?php } ?>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a href="../pages/logout.php" onclick="return confirm('Are you sure you want to logout?');" class="btn btn-primary me-3">Logout</a>
                            <?php } else { ?>
                                <a href="../pages/signin.php" class="btn btn-primary me-3">Sign In</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <?php
    $products = [
        'Absorbent Gauze',
        'Bandage Cloth',
        'Gauze Swabs',
        'Roller Bandage',
        'Jumbo Roll Starched',
        'Jumbo Roll Un Starched',
        'Dressing Pad',
        'Combine Dressing Pad',
        'Gamjee Roll',
        'Gauze Sponge',
        'Cotton Balls',
        'Gauze Balls',
        "Triangular Bandage",
        "Absorbent Cotton",
        "Pre-Operative Kit",
        "Patient Gown",
        "Surgeon Gown",
        "Bed Sheet & Pillow Cover",
        'Custom Product'
    ];
    ?>

    <div class="container place_order">
        <div class="row mb-3">
            <div class="col-12 text-center page-header">
                <h3><i class="bi bi-cart-check me-2"></i> PLACE ORDER</h3>
                <p class="lead mb-0">Fill out the form below to place your order for our products</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <form id="orderForm" method="POST" action="./submit_order.php" novalidate>
                        <div class="row g-3">
                            <!-- Customer Information Fields -->
                            <!-- <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                             <div class="col-md-8 mb-3">
                                <label for="firmName" class="form-label required-field">Name of Firm</label> 
                                <input type="hidden" class="form-control" id="firmName" name="firmName" placeholder="Enter your firm name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="gstNo" class="form-label required-field">GST No</label> 
                                <input type="hidden" class="form-control" id="gstNo" name="gstNo" placeholder="Enter GST number" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control d-none" id="address" rows="3" name="address" placeholder="Enter your complete address"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label required-field">City</label>
                                <input type="hidden" class="form-control" id="city" name="city" placeholder="Enter city" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label required-field">Country</label>
                                <select class="form-select" id="country" name="country" required></select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label required-field">PinCode/Zip Code</label>
                                <input type="hidden" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mobileNumber" class="form-label required-field">Mobile Number</label>
                                <div class="input-group">
                                    <select class="form-select" id="mobile_cc" style="max-width: 120px;" name="countryCode" required></select>
                                    <input type="hidden" class="form-control" id="mobileNumber" name="mobileNumber" placeholder="Enter mobile number" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required-field">Email Address</label>
                                <input type="hidden" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            </div> -->

                            <!-- Products Section -->
                            <div class="col-12">
                                <h4>Products</h4>
                                <div id="productsContainer">
                                    <div class="product-row" id="product-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5>Product #1</h5>
                                        </div>
                                        <input type="hidden" name="order_id" value="<?php echo uniqid('ORD-'); ?>">

                                        <div class="row">
                                            <!-- Product Name -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label required-field">Product Name</label>
                                                <select class="form-select product-name" name="productName[]" required onchange="updateProductFields(this)">
                                                    <option value="" selected disabled>Select Product</option>
                                                    <?php foreach ($products as $pro) { ?>
                                                        <option value="<?php echo $pro; ?>"><?php echo $pro; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="text" class="form-control mt-2 custom-product-name" name="customProductName[]" placeholder="Enter custom product name" style="display: none;">
                                            </div>

                                            <!-- Dynamic Fields Container -->
                                            <div class="col-md-8 mb-3 product-fields">
                                                <!-- Fields will be dynamically populated here -->
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required-field">Quantity</label>
                                                <input type="number" class="form-control product-quantity" name="productQuantity[]" placeholder="Enter quantity" onkeyup="disbtn()" min="1" required>
                                                <div class="note mt-1"><small> Quantity must fill</small></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-3 mb-3 another-btn">
                                    <button type="button" id="addProductBtn" class="btn btn-success btn-sm">
                                        <i class="bi bi-plus-circle me-2"></i>Add Another Product
                                    </button>
                                </div>
                            </div>

                            <!-- Attachments Section -->
                            <div class="col-12 attachment-section">
                                <div class="attachment-header">
                                    <h4><i class="bi bi-paperclip me-2"></i>Attachments</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="gstCertificate" class="form-label">GST Certificate</label>
                                        <div class="file-upload">
                                            <label for="gstCertificate" class="file-upload-label">
                                                <i class="bi bi-upload me-2"></i>Choose File
                                            </label>
                                            <input type="file" id="gstCertificate" accept=".pdf,.jpg,.jpeg,.png" name="gstCertificate">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="drugLicense" class="form-label required-field">Drug License / Manufacturing License / IE Code</label>
                                        <div class="file-upload">
                                            <label for="drugLicense" class="file-upload-label">
                                                <i class="bi bi-upload me-2"></i>Choose File
                                            </label>
                                            <input type="file" id="drugLicense" accept=".pdf,.jpg,.jpeg,.png" name="drugLicense" required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- CAPTCHA Section -->
                            <div class="col-12">
                                <div class="captcha-container">
                                    <label class="form-label">Enter the text shown below <span class="text-danger">*</span></label>
                                    <div class="captcha-display" id="captchaDisplay"></div>
                                    <div class="captcha-controls">
                                        <input type="text" class="form-control captcha-input" id="captchaInput" placeholder="Type the characters above" style="border:1px solid #000" required>
                                        <button type="button" class="captcha-refresh" id="refreshCaptcha" title="Refresh CAPTCHA">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="captcha-error" id="captchaError">CAPTCHA verification failed. Please try again.</div>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md submit-btn comp-btn" id="submitButton" disabled>
                                    <i class="bi bi-cart-check-fill me-2"></i>Place Order
                                </button>
                            </div>
                        </div>
                        <div id="formMsg" class="mt-3 text-center text-md-start"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="helper-widget">
        <button class="helper-toggle">
            <i class="bi bi-question-circle-fill"></i>
        </button>
        <div class="helper-menu">
            <ul>
                <li><a href="./place_order.php">Place Order</a></li>
                <li><a href="./get_a_qoute.php">Get Quote</a></li>
                <li><a href="./request_sample.php">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./raise_of_complaint.php">Raise a Complaint</a></li>
                <li><a href="./suggestions.php">Suggestions</a></li>
                <li><a href="#chat" id="open-chat">Chat with us</a></li>
            </ul>
        </div>
    </div>

    <script>
        document.getElementById('top-whatsapp').addEventListener('click', function() {
            let message = `How can I help You? %0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>
    <script>
        document.getElementById('top-whatsapp2').addEventListener('click', function() {
            let message = `How can I help You? %0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>
    <script>
        document.getElementById('nav-open-chat2').addEventListener('click', function() {
            let message = `How can I help You? %0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>

    <script>
        // CAPTCHA functionality
        let currentCaptcha = '';

        // Generate random CAPTCHA text
        function generateCaptcha() {
            const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            let result = '';
            const length = 6; // CAPTCHA length

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            currentCaptcha = result;
            document.getElementById('captchaDisplay').textContent = result;

            // Clear input and disable submit button
            document.getElementById('captchaInput').value = '';
            document.getElementById('submitButton').disabled = true;
            document.getElementById('captchaError').style.display = 'none';
        }

        // Validate CAPTCHA input
        function validateCaptcha() {
            const input = document.getElementById('captchaInput').value;
            const submitButton = document.getElementById('submitButton');
            const errorElement = document.getElementById('captchaError');

            if (input === currentCaptcha) {
                submitButton.disabled = false;
                errorElement.style.display = 'none';
                return true;
            } else {
                submitButton.disabled = true;
                if (input.length >= currentCaptcha.length) {
                    errorElement.style.display = 'block';
                } else {
                    errorElement.style.display = 'none';
                }
                return false;
            }
        }

        // Initialize CAPTCHA
        document.addEventListener('DOMContentLoaded', function() {
            generateCaptcha();

            // Add event listeners
            document.getElementById('refreshCaptcha').addEventListener('click', generateCaptcha);
            document.getElementById('captchaInput').addEventListener('input', validateCaptcha);

            // Form validation
            document.getElementById('signupForm').addEventListener('submit', function(e) {
                if (!validateCaptcha()) {
                    e.preventDefault();
                    document.getElementById('captchaError').style.display = 'block';
                    return;
                }

                // Continue with form submission if CAPTCHA is valid
                const form = e.target;
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.classList.add('was-validated');
                }
            });
        });
    </script>
    <script>
        document.getElementById('open-chat').addEventListener('click', function() {
            let message = `How can i help You? %0A%0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-logo d-flex align-items-center mb-3">
                        <img src="../assets/logo.jpeg" alt="Bharathi Surgicals Logo" class="me-2">
                    </div>
                    <div class="opening-time">
                        <?php echo $data['opening_time']; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="social-icons text-center">
                        <a href="<?php echo $data1['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" id="footer-open-chat" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-info">
                        <div>
                            <a href="tel:<?php echo $data['phone']; ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> <?php echo $data['phone']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="mailto:<?php echo $data['email']; ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope-fill"></i> <?php echo $data['email']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="https://www.google.com/maps/search/<?php echo $data['address']; ?>" target="_blank" class="text-decoration-none text-dark">
                                <i class="bi bi-geo-alt-fill"></i> <?php echo $data['address']; ?>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-4">
                        <p>Developed by <a href="https://anjanainfotech.in/" style="color: #007BFF; text-decoration: none;">Anjana Infotech</a></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p>© <?php echo date('Y'); ?> All Rights Reserved.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-links text-end">
                            <a href="#">Terms & Conditions</a>
                            <a href="#">Privacy Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Toggle the helper menu
        const toggleButton = document.querySelector('.helper-toggle');
        const helperMenu = document.querySelector('.helper-menu');

        toggleButton.addEventListener('click', () => {
            helperMenu.classList.toggle('active');
        });

        // Optional: hide menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.helper-widget')) {
                helperMenu.classList.remove('active');
            }
        });
    </script>

    <script src="../index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        function disbtn() {
            document.querySelectorAll('.another-btn').forEach(btn => {
                btn.style.display = 'block';
            });
        }
    </script>
    <script>
        // Product configuration data
        const productConfig = {
            "Absorbent Gauze": {
                fields: [{
                        name: "quality",
                        label: "Quality",
                        type: "select",
                        options: ["27 TPI", "34 TPI", "40 TPI", "42 TPI", "50 TPI", "60 TPI", "FII Gauze", "Custom TPI"],
                        required: true
                    },
                    {
                        name: "size",
                        label: "Size",
                        type: "select",
                        dynamic: true,
                        dependsOn: "quality",
                        mapping: {
                            "27 TPI": [
                                "100 CM X 10 Meters",
                                "100 CM X 10 Yards",
                                "100 CM X 16 Meters",
                                "100 CM X 16 Yards",
                                "100 CM X 18 Meters",
                                "100 CM X 18 Yards",
                                "100 CM X 20 Meters",
                                "100 CM X 20 Yards",
                                "90 CM X 10 Meters",
                                "90 CM X 10 Yards",
                                "90 CM X 16 Meters",
                                "90 CM X 16 Yards",
                                "90 CM X 18 Meters",
                                "90 CM X 18 Yards",
                                '90 CM X 20 Meters',
                                "90 CM X 20 Yards",
                                "Custom Size"
                            ],
                            "34 TPI": [
                                "120 CM X 10 Meters", "120 CM X 10 Yards", "120 CM X 16 Meters", "120 CM X 16 Yards",
                                "120 CM X 18 Meters", "120 CM X 18 Yards", "120 CM X 20 Meters", "120 CM X 20 Yards", "Custom Size"
                            ],
                            "40 TPI": [
                                "100 CM X 10 Meters",
                                "100 CM X 10 Yards",
                                "100 CM X 16 Meters",
                                "100 CM X 16 Yards",
                                "100 CM X 18 Meters",
                                "100 CM X 18 Yards",
                                "100 CM X 20 Meters",
                                "100 CM X 20 Yards",
                                "90 CM X 10 Meters",
                                "90 CM X 10 Yards",
                                "90 CM X 16 Meters",
                                "90 CM X 16 Yards",
                                "90 CM X 18 Meters",
                                "90 CM X 18 Yards",
                                "90 CM X 20 Meters",
                                "90 CM X 20 Yards",
                                "Custom Size"
                            ],
                            "42 TPI": [
                                "100 CM X 10 Meters",
                                "100 CM X 10 Yards",
                                "100 CM X 18 Meters",
                                "100 CM X 20 Meters",
                                "100 CM X 20 Yards",
                                "90 CM X 10 Meters",
                                "90 CM X 10 Yards",
                                "90 CM X 18 Meters",
                                "90 CM X 20 Meters",
                                "90 CM X 20 Yards",
                                "120 CM X 10 Meters",
                                '120 CM X 10 Yards',
                                "120 CM X 18 Meters",
                                "120 CM X 20 Meters",
                                "120 CM X 20 Yards",
                                "Custom Size"
                            ],
                            "50 TPI": [

                                "100 CM X 10 Meters",
                                "100 CM X 10 Yards",
                                "100 CM X 18 Meters",
                                "100 CM X 20 Meters",
                                "100 CM X 20 Yards",
                                "90 CM X 10 Meters",
                                "90 CM X 10 Yards",
                                "90 CM X 18 Meters",
                                "90 CM X 20 Meters",
                                "90 CM X 20 Yards",
                                "120 CM X 10 Meters",
                                "120 CM X 10 Yards",
                                "120 CM X 18 Meters",
                                "120 CM X 20 Meters",
                                "120 CM X 20 Yards", "Custom Size"
                            ],
                            "60 TPI": [
                                "100 CM X 10 Meters",
                                "100 CM X 10 Yards",
                                "100 CM X 18 Meters",
                                "100 CM X 20 Meters",
                                "100 CM X 20 Yards",
                                "90 CM X 10 Meters",
                                "90 CM X 10 Yards",
                                "90 CM X 18 Meters",
                                "90 CM X 20 Meters",
                                "90 CM X 20 Yards",
                                "120 CM X 10 Meters",
                                "120 CM X 10 Yards",
                                "120 CM X 18 Meters",
                                "120 CM X 20 Meters",
                                "120 CM X 20 Yards", "Custom Size"
                            ],
                            "FII Gauze": ["100 CM X 10 M", "100 CM X 20 M", "90 CM X 10 M", "90 CM X 20 M", "Custom Size"],
                            "Custom TPI": ["Custom Size"]
                        },
                        required: true
                    }
                ]
            },
            "Bandage Cloth": {
                fields: [{
                    name: "size",
                    label: "Size",
                    type: "select",
                    options: ["100 CM X 10 Meter",
                        "100 CM X 20 Meter",
                        "90 CM X 10 Meter",
                        "90 CM X 20 Meter",
                        "Custom Size"
                    ],
                    required: true
                }]
            },
            "Gauze Swabs": {
                fields: [{
                        name: "quality",
                        label: "Quality",
                        type: "select",
                        options: ["Type-13", "Type-17"],
                        required: true
                    },
                    {
                        name: "folding",
                        label: "Folding Type",
                        type: "select",
                        options: ["French", "American"],
                        required: true
                    },
                    {
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: [],
                        dependsOn: ["quality", "folding"],
                        options: {
                            // Type-13 with French Folding
                            "Type-13_French": [
                                "10 CM  X 10 CM X 8 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 8 PLY PLAIN",
                                "5 CM  X 5 CM X 8 PLY PLAIN",
                                "10 CM  X 10 CM X 12 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 12 PLY PLAIN",
                                "5 CM  X 5 CM X 12 PLY PLAIN",
                                "10 CM  X 10 CM X 16 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 16 PLY PLAIN",
                                "5 CM  X 5 CM X 16 PLY PLAIN"
                            ],
                            // Type-13 with American Folding - No options available
                            "Type-13_American": [],
                            // Type-17 with French Folding
                            "Type-17_French": [
                                "10 CM  X 10 CM X 8 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 8 PLY PLAIN",
                                "5 CM  X 5 CM X 8 PLY PLAIN",
                                "10 CM  X 10 CM X 12 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 12 PLY PLAIN",
                                "5 CM  X 5 CM X 12 PLY PLAIN",
                                "10 CM  X 10 CM X 16 PLY PLAIN",
                                "7.5 CM  X 7.5 CM X 16 PLY PLAIN",
                                "5 CM  X 5 CM X 16 PLY PLAIN",
                                "10 CM  X 10 CM X 12 PLY X-RAY",
                                "7.5 CM  X 7.5 CM X 12 PLY X-RAY"
                            ],
                            // Type-17 with American Folding
                            "Type-17_American": [
                                "10 CM X 10 CM X 12 PLY PLAIN",
                                "7.5 CM X 7.5 CM X 12 PLY PLAIN",
                                "5 CM X 5 CM X 12 PLY PLAIN",
                                "10 CM X 10 CM X 12 PLY X-RAY",
                                "7.5 CM X 7.5 CM X 12 PLY X-RAY"
                            ]
                        },
                        required: true
                    },
                    {
                        name: "sterility",
                        label: "Sterility",
                        type: "select",
                        options: ["Sterile", "Non-Sterile"],
                        required: true
                    },
                    {
                        name: "pieces",
                        label: "No. Of Pieces",
                        type: "number",
                        required: false,
                        placeholder: "Enter number of pieces",
                        showIf: {
                            field: "sterility",
                            value: "Sterile"
                        }
                    }
                ]
            },
            "Roller Bandage": {
                fields: [{
                        name: "quality",
                        label: "Quality",
                        type: "select",
                        options: ["34 TPI", "42 TPI", "50 TPI", "60 TPI", "FII Bandage", "Custom TPI"],
                        required: true
                    },
                    {
                        name: "width",
                        label: "Width",
                        type: "select",
                        options: ["15 CM", "10 CM", "7.5 CM", "5 CM", "Custom width"],
                        required: true
                    },
                    {
                        name: "length",
                        label: "Length",
                        type: "text",
                        placeholder: "Enter length",
                        required: true
                    },
                    {
                        name: "unit",
                        label: "Unit",
                        type: "select",
                        options: ["Meters", "Yards"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing",
                        type: "select",
                        options: ["10 Roll Pack", "12 Roll Pack"],
                        required: true
                    }
                ]
            },
            "Jumbo Roll Starched": {
                fields: [{
                        name: "width",
                        label: "Width",
                        type: "select",
                        options: ["100 CM", "120 CM", "Custom Width"],
                        required: true
                    },
                    {
                        name: "length",
                        label: "Length",
                        type: "number",
                        placeholder: "Enter length",
                        required: true
                    }
                ]
            },
            "Jumbo Roll Un Starched": {
                fields: [{
                        name: "width",
                        label: "Width",
                        type: "select",
                        options: ["100 CM", "120 CM", "Custom Width"],
                        required: true
                    },
                    {
                        name: "length",
                        label: "Length",
                        type: "number",
                        placeholder: "Enter length",
                        required: true
                    }
                ]
            },
            // "Dressing Pad Non-Sterile": {
            //     fields: [{
            //             name: "size",
            //             label: "Size",
            //             type: "select",
            //             options: ["10 CM X 10 CM", "10 CM X 20 CM", "Custom size"],
            //             required: true
            //         },
            //         {
            //             name: "packing",
            //             label: "Packing (No. of Pieces)",
            //             type: "number",
            //             placeholder: "Enter number of pieces",
            //             required: true
            //         }
            //     ]
            // },
            "Dressing Pad": {
                fields: [{
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: ["10 CM X 10 CM", "10 CM X 20 CM", "Custom size"],
                        required: true
                    },
                    {
                        name: "sterility",
                        label: "Sterility",
                        type: "select",
                        options: ["Sterile", "Non-Sterile"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing (No. of Pieces)",
                        type: "number",
                        placeholder: "Enter number of pieces",
                        required: true
                    }
                ]
            },
            "Combine Dressing Pad": {
                fields: [{
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: ["10 CM X 10 CM", "10 CM X 20 CM", "Custom size"],
                        required: true
                    },
                    {
                        name: "sterility",
                        label: "Sterility",
                        type: "select",
                        options: ["Sterile", "Non-sterile"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing (No. of Pieces)",
                        type: "number",
                        placeholder: "Enter number of pieces",
                        required: true
                    }
                ]
            },
            // "Combine Dressing Pad Non-Sterile": {
            //     fields: [{
            //             name: "size",
            //             label: "Size",
            //             type: "select",
            //             options: ["10 CM X 10 CM", "10 CM X 20 CM", "Custom size"],
            //             required: true
            //         },
            //         {
            //             name: "packing",
            //             label: "Packing (No. of Pieces)",
            //             type: "number",
            //             placeholder: "Enter number of pieces",
            //             required: true
            //         }
            //     ]
            // },
            "Gamjee Roll": {
                fields: [{
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: ["15 CM X 2 Meters", "15 CM X 3 Meters", "10 CM X 2 Meters", "10 CM X 3 Meters", "Custom size"],
                        required: true
                    },
                    {
                        name: "sterility",
                        label: "Sterility",
                        type: "select",
                        options: ["Sterile", "Non-Sterile"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing (No. of Pieces)",
                        type: "number",
                        placeholder: "Enter number of pieces",
                        required: true
                    }
                ]
            },
            // "Gamjee Roll Non-Sterile": {
            //     fields: [{
            //             name: "size",
            //             label: "Size",
            //             type: "select",
            //             options: ["15 CM X 2 Meters", "15 CM X 3 Meters", "10 CM X 2 Meters", "10 CM X 3 Meters", "Custom size"],
            //             required: true
            //         },
            //         {
            //             name: "packing",
            //             label: "Packing (No. of Pieces)",
            //             type: "number",
            //             placeholder: "Enter number of pieces",
            //             required: true
            //         }
            //     ]
            // },
            "Gauze Sponge": {
                fields: [{
                        name: "quality",
                        label: "Quality",
                        type: "select",
                        options: ["Type-13", "Type-17"],
                        required: true
                    },
                    {
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: ["20 CM X 20 CM", "25 CM X 25 CM", "30 CM X 30 CM", "25 CM X 40 CM", "Custom size"],
                        required: true
                    },
                    {
                        name: "ply",
                        label: "No. of Ply",
                        type: "select",
                        options: ["8 PLY", "12 PLY", "custom PLY"],
                        required: true
                    },
                    {
                        name: "x-ray",
                        label: "X-Ray Detectable",
                        type: "select",
                        options: ["Yes", "No"],
                        required: true
                    },
                    {
                        name: "sterility",
                        label: "Sterility",
                        type: "select",
                        options: ["Sterile", "Non-Sterile"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing (No. of Pieces)",
                        type: "number",
                        placeholder: "Enter number of pieces",
                        required: true
                    }
                ]
            },
            // "Gauze Sponge Non-Sterile": {
            //     fields: [{
            //             name: "quality",
            //             label: "Quality",
            //             type: "select",
            //             options: ["Type-13", "Type-17", "Custom Quality"],
            //             required: true
            //         },
            //         {
            //             name: "size",
            //             label: "Size",
            //             type: "select",
            //             options: ["20 CM X 20 CM", "25 CM X 25 CM", "30 CM X 30 CM", "25 CM X 40 CM", "Custom size"],
            //             required: true
            //         },
            //         {
            //             name: "ply",
            //             label: "No. of Ply",
            //             type: "select",
            //             options: ["8 PLY", "12 PLY", "custom PLY"],
            //             required: true
            //         },
            //         {
            //             name: "packing",
            //             label: "Packing (No. of Pieces)",
            //             type: "number",
            //             placeholder: "Enter number of pieces",
            //             required: true
            //         }
            //     ]
            // },
            "Cotton Balls": {
                fields: [{
                    name: "size",
                    label: "Weight",
                    type: "select",
                    options: ["½ Gram", "1 Gram"],
                    required: true
                }]
            },
            "Gauze Balls": {
                fields: [{
                    name: "size",
                    label: "Weight",
                    type: "select",
                    options: ["½ Gram", "1 Gram"],
                    required: true
                }]
            },
            "Triangular Bandage": {
                fields: [{
                        name: "size",
                        label: "Size",
                        type: "select",
                        options: ["90 CM X 90 CM", "100 CM X 100 CM"],
                        required: true
                    },
                    {
                        name: "packing",
                        label: "Packing (No. of Pieces)",
                        type: "number",
                        placeholder: "Enter number of pieces",
                        required: true
                    }
                ]
            },
            "Absorbent Cotton": {
                fields: [{
                    name: "weight",
                    label: "Weight",
                    type: "select",
                    options: ["300 Net / 400 Gross"],
                    required: true
                }]
            },
            "Pre-Operative Kit": {
                fields: [{
                    name: "contents",
                    label: "Contents",
                    type: "select",
                    options: ["1 Pair Leggin / 1 Piece Bouffant Cap / 1 Piece Patient Gown", "Custom Contents"],
                    required: true
                }]
            },
            "Patient Gown": {
                fields: [{
                    name: "size",
                    label: "Size",
                    type: "select",
                    options: ["XL"],
                }]
            },
            "Surgeon Gown": {
                fields: [{
                    name: "size",
                    label: "Size",
                    type: "select",
                    options: ["XL"],
                    required: true
                }]
            },
            "Bed Sheet & Pillow Cover": {
                fields: [{
                    name: "size",
                    label: "Size",
                    type: "select",
                    options: ["210 CM X 160 CM & 75 CM X 55 CM", "Custom Size"],
                    required: true
                }]
            },

            "Custom Product": {
                fields: [{
                    name: "custom_specifications",
                    label: "Product Specifications",
                    type: "textarea",
                    placeholder: "Enter detailed product specifications",
                    required: true
                }]
            }
        };
    </script>
    <script>
        // Update the handleFieldChange function to properly handle Gauze Swabs
        function handleFieldChange(selectElement, productName, fieldName) {
            const productRow = selectElement.closest('.product-row');
            const value = selectElement.value;

            // Show/hide custom inputs
            if (value && (value.includes('Custom') || value === 'Custom Size' || value === 'Custom TPI' || value === 'Custom width' || value === 'custom PLY' || value === 'Custom Contents' || value === 'Custom Quality' || value === 'Custom size')) {
                const customInput = productRow.querySelector(`input[name="custom_${fieldName}[]"]`);
                if (customInput) {
                    customInput.style.display = 'block';
                    customInput.required = true;
                }
            } else {
                const customInput = productRow.querySelector(`input[name="custom_${fieldName}[]"]`);
                if (customInput) {
                    customInput.style.display = 'none';
                    customInput.required = false;
                    customInput.value = '';
                }
            }

            // Handle dynamic field dependencies for Absorbent Gauze
            if (productName === 'Absorbent Gauze' && fieldName === 'quality') {
                updateSizeOptions(productRow, value);
            }

            // Handle dynamic field dependencies for Gauze Swabs
            if (productName === 'Gauze Swabs') {
                const qualitySelect = productRow.querySelector('select[name="quality[]"]');
                const foldingSelect = productRow.querySelector('select[name="folding[]"]');

                const quality = qualitySelect ? qualitySelect.value : '';
                const folding = foldingSelect ? foldingSelect.value : '';

                // Update size options when either quality or folding changes
                if ((fieldName === 'quality' || fieldName === 'folding') && quality && folding) {
                    updateGauzeSwabsSizeOptions(productRow, quality, folding);
                }

                // Handle conditional fields (like pieces for sterile gauze swabs)
                if (fieldName === 'sterility') {
                    updatePiecesFieldVisibility(productRow, value);
                }
            }
        }

        // Fixed function to update Gauze Swabs size options
        function updateGauzeSwabsSizeOptions(productRow, quality, folding) {

           
// const key = `${quality.trim()}_${folding.trim()}`;
// console.log("Key:", key);
// console.log("Available keys:", Object.keys(sizeField.options));

            const sizeSelect = productRow.querySelector('select[name="size[]"]');

            if (sizeSelect && productConfig["Gauze Swabs"]) {
                const sizeField = productConfig["Gauze Swabs"].fields.find(f => f.name === 'size');

                if (sizeField && sizeField.options) {
                    const key = `${quality.trim()}_${folding.trim()}`;
                    console.log(key);
                    console.log(sizeField.options);
                    const sizeOptions = sizeField.options[key];

                    // Store current value
                    const currentValue = sizeSelect.value;

                    // Clear existing options
                    sizeSelect.innerHTML = '<option value="" selected disabled>Select Size</option>';

                    if (sizeOptions && sizeOptions.length > 0) {
                        sizeOptions.forEach(size => {
                            const option = document.createElement('option');
                            option.value = size;
                            option.textContent = size;
                            sizeSelect.appendChild(option);
                        });

                        // Try to restore previous selection if possible
                        if (currentValue && sizeOptions.includes(currentValue)) {
                            sizeSelect.value = currentValue;
                        }
                    } else {
                        sizeSelect.innerHTML = '<option value="" selected disabled>No sizes available for this combination</option>';
                    }
                }
            }
        }

        // Update the addFieldEventListeners function to ensure Gauze Swabs works properly
        function addFieldEventListeners(productRow, productName) {
            const selects = productRow.querySelectorAll('select');

            selects.forEach(select => {
                // Remove existing event listeners to avoid duplicates
                const newSelect = select.cloneNode(true);
                select.parentNode.replaceChild(newSelect, select);
            });

            // Get fresh references after cloning
            const freshSelects = productRow.querySelectorAll('select');

            freshSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const productNameSelect = productRow.querySelector('.product-name');
                    const currentProductName = productNameSelect ? productNameSelect.value : productName;
                    const fieldName = this.name.replace('[]', '');

                    if (currentProductName) {
                        handleFieldChange(this, currentProductName, fieldName);
                    }
                });

                // Trigger change event on existing values to initialize dependent fields
                if (select.value) {
                    select.dispatchEvent(new Event('change'));
                }
            });

            // If it's Absorbent Gauze and quality is already selected, trigger size update
            if (productName === 'Absorbent Gauze') {
                const qualitySelect = productRow.querySelector('select[name="quality[]"]');
                if (qualitySelect && qualitySelect.value) {
                    updateSizeOptions(productRow, qualitySelect.value);
                }
            }

            // If it's Gauze Swabs and both quality and folding are selected, trigger size update
            if (productName === 'Gauze Swabs') {
                const qualitySelect = productRow.querySelector('select[name="quality[]"]');
                const foldingSelect = productRow.querySelector('select[name="folding[]"]');

                const quality = qualitySelect ? qualitySelect.value : '';
                const folding = foldingSelect ? foldingSelect.value : '';

                if (quality && folding) {
                    updateGauzeSwabsSizeOptions(productRow, quality, folding);
                }
            }
        }

        // Update product fields based on selection
        function updateProductFields(selectElement) {
            const productRow = selectElement.closest('.product-row');
            const productName = selectElement.value;
            const fieldsContainer = productRow.querySelector('.product-fields');
            const customProductInput = productRow.querySelector('.custom-product-name');

            // Show/hide custom product input
            if (productName === 'Custom Product') {
                customProductInput.style.display = 'block';
                customProductInput.required = true;
            } else {
                customProductInput.style.display = 'none';
                customProductInput.required = false;
            }

            // Clear existing fields
            fieldsContainer.innerHTML = '';

            if (productName && productConfig[productName]) {
                const fields = productConfig[productName].fields;

                // Calculate column size based on number of fields
                const colSize = fields.length > 2 ? 'col-md-6' : 'col-md-12';

                fields.forEach((field, index) => {
                    const fieldHtml = createFieldHtml(field, productName);
                    const fieldContainer = document.createElement('div');
                    fieldContainer.className = `${colSize} mb-3`;
                    fieldContainer.innerHTML = fieldHtml;

                    // Add conditional display class if needed
                    if (field.showIf) {
                        fieldContainer.classList.add('conditional-field');
                        fieldContainer.style.display = 'none';
                    }

                    fieldsContainer.appendChild(fieldContainer);
                });

                // Add event listeners for dynamic fields
                addFieldEventListeners(productRow, productName);
            }
        }
        // Create HTML for a field
        function createFieldHtml(field, productName) {
            let html = '';
            const nameAttr = `${field.name}[]`;
            const requiredAttr = field.required ? 'required' : '';
            const requiredClass = field.required ? 'required-field' : '';

            html += `<label class="form-label ${requiredClass}">${field.label}</label>`;

            if (field.type === 'select') {
                html += `<select class="form-select" name="${nameAttr}" ${requiredAttr}>`;
                html += `<option value="" selected disabled>Select ${field.label}</option>`;

                // For Absorbent Gauze size field, show a default message
                if (productName === 'Absorbent Gauze' && field.name === 'size' && (!field.options || field.options.length === 0)) {
                    html += `<option value="" disabled>Please select quality first</option>`;
                } else if (field.options && field.options.length > 0) {
                    // For static options
                    field.options.forEach(option => {
                        const isCustomOption = option.toLowerCase().includes('custom');
                        html += `<option value="${option}" ${isCustomOption ? 'data-custom="true"' : ''}>${option}</option>`;
                    });
                }

                html += `</select>`;

                // Add custom input for ALL select fields that might have custom options
                // This ensures custom inputs are available when needed
                const customPlaceholder = `Enter custom ${field.label.toLowerCase()}`;
                html += `<input type="text" class="form-control mt-2 custom-input" 
                 name="custom_${field.name}[]" 
                 placeholder="${customPlaceholder}" style="display: none;">`;

            } else if (field.type === 'number' || field.type === 'text') {
                html += `<input type="${field.type}" class="form-control" name="${nameAttr}" 
                 placeholder="${field.placeholder || 'Enter ' + field.label.toLowerCase()}" ${requiredAttr}>`;
            } else if (field.type === 'textarea') {
                html += `<textarea class="form-control" name="${nameAttr}" 
                 rows="3" placeholder="${field.placeholder || 'Enter ' + field.label.toLowerCase()}" ${requiredAttr}></textarea>`;
            }

            return html;
        }

        // Update size options for Absorbent Gauze based on quality
        // Update size options for Absorbent Gauze based on quality
        function updateSizeOptions(productRow, quality) {
            const sizeSelect = productRow.querySelector('select[name="size[]"]');

            if (sizeSelect && productConfig['Absorbent Gauze']) {
                const sizeField = productConfig['Absorbent Gauze'].fields.find(f => f.name === 'size');

                if (sizeField && sizeField.mapping && sizeField.mapping[quality]) {
                    // Store the current value to restore it if possible
                    const currentValue = sizeSelect.value;

                    // Clear and repopulate options
                    sizeSelect.innerHTML = '<option value="" selected disabled>Select Size</option>';

                    sizeField.mapping[quality].forEach(size => {
                        const option = document.createElement('option');
                        option.value = size;
                        option.textContent = size;
                        if (size === 'Custom Size') {
                            option.setAttribute('data-custom', 'true');
                        }
                        sizeSelect.appendChild(option);
                    });

                    // Try to restore previous selection if it exists in new options
                    if (currentValue && sizeField.mapping[quality].includes(currentValue)) {
                        sizeSelect.value = currentValue;
                    }

                    // Trigger change event to handle custom inputs
                    sizeSelect.dispatchEvent(new Event('change'));
                } else {
                    sizeSelect.innerHTML = '<option value="" selected disabled>No sizes available for this quality</option>';
                }
            }
        }

        // Update pieces field visibility for Gauze Swabs
        function updatePiecesFieldVisibility(productRow, sterility) {
            const piecesField = productRow.querySelector('.conditional-field');
            if (piecesField) {
                if (sterility === 'Sterile') {
                    piecesField.style.display = 'block';
                } else {
                    piecesField.style.display = 'none';
                    const piecesInput = piecesField.querySelector('input');
                    if (piecesInput) {
                        piecesInput.value = '';
                    }
                }
            }
        }

        // Add event listeners for dynamic field behavior
        function addFieldEventListeners(productRow, productName) {
            const selects = productRow.querySelectorAll('select');

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const productNameSelect = productRow.querySelector('.product-name');
                    const currentProductName = productNameSelect ? productNameSelect.value : productName;
                    const fieldName = this.name.replace('[]', '');

                    if (currentProductName) {
                        handleFieldChange(this, currentProductName, fieldName);
                    }
                });
            });

            // If it's Absorbent Gauze and quality is already selected, trigger size update
            if (productName === 'Absorbent Gauze') {
                const qualitySelect = productRow.querySelector('select[name="quality[]"]');
                if (qualitySelect && qualitySelect.value) {
                    updateSizeOptions(productRow, qualitySelect.value);
                }
            }
        }

        // Add product functionality
        let productCount = 1;
        document.getElementById('addProductBtn').addEventListener('click', function() {
            productCount++;
            const productsContainer = document.getElementById('productsContainer');
            const newProductRow = document.createElement('div');
            newProductRow.className = 'product-row';
            newProductRow.id = `product-${productCount}`;

            // Create product options HTML
            let productOptions = '';
            const products = <?php echo json_encode($products); ?>;
            products.forEach(product => {
                productOptions += `<option value="${product}">${product}</option>`;
            });

            newProductRow.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>Product #${productCount}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-product" onclick="removeProduct(${productCount})">
                    <i class="bi bi-trash me-1"></i>Remove
                </button>
            </div>
            <input type="hidden" name="order_id" value="<?php echo uniqid('ORD-'); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Product Name</label>
                    <select class="form-select product-name" name="productName[]" required onchange="updateProductFields(this)">
                        <option value="" selected disabled>Select Product</option>
                        ${productOptions}
                    </select>
                    <input type="text" class="form-control mt-2 custom-product-name" name="customProductName[]" placeholder="Enter custom product name" style="display: none;">
                </div>
                <div class="col-md-8 mb-3 product-fields"></div>
                <div class="col-md-12 mb-3">
                                                <label class="form-label required-field">Quantity</label>
                                                <input type="number" class="form-control product-quantity" name="productQuantity[]" placeholder="Enter quantity" onkeyup="disbtn()" min="1" required>
                                                <div class="note mt-1"><small> Quantity must fill</small></div>
                                            </div>
            </div>
            </div>
        `;
            productsContainer.appendChild(newProductRow);
        });

        // Remove product functionality
        function removeProduct(productId) {
            if (productCount > 1) {
                const productRow = document.getElementById(`product-${productId}`);
                if (productRow) {
                    productRow.remove();
                    productCount--;

                    // Update product numbers
                    const productRows = document.querySelectorAll('.product-row');
                    productRows.forEach((row, index) => {
                        const productNumber = index + 1;
                        row.id = `product-${productNumber}`;
                        row.querySelector('h5').textContent = `Product #${productNumber}`;
                        row.querySelector('.remove-product').setAttribute('onclick', `removeProduct(${productNumber})`);
                    });
                }
            } else {
                alert('You must have at least one product in your order.');
            }
        }

        // Initialize the first product row to have proper event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to the first product row
            const firstProductRow = document.getElementById('product-1');
            if (firstProductRow) {
                const productNameSelect = firstProductRow.querySelector('.product-name');
                if (productNameSelect) {
                    // Remove the inline onchange and use event listener instead
                    productNameSelect.removeAttribute('onchange');
                    productNameSelect.addEventListener('change', function() {
                        updateProductFields(this);
                    });
                }
            }
        });

        // Form submission
        // Form submission
        const form = document.getElementById('orderForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let productText = "";

            // Get all product rows
            const productRows = document.querySelectorAll('.product-row');

            productRows.forEach((row, index) => {
                const productNumber = index + 1;
                const details = [];

                // Get product name (select or custom input)
                const productSelect = row.querySelector('select[name="productName[]"]');
                const customProductInput = row.querySelector('input[name="customProductName[]"]');
                const productName = productSelect ? productSelect.value : '';
                const customProductName = customProductInput ? customProductInput.value : '';

                // Get quantity
                const quantityInput = row.querySelector('input[name="productQuantity[]"]');
                const quantity = quantityInput ? quantityInput.value : '';

                // Add basic product info
                if (productName === 'Custom Product' && customProductName) {
                    details.push(`Product: ${customProductName}`);
                } else if (productName) {
                    details.push(`Product: ${productName}`);
                }

                if (quantity) details.push(`Quantity: ${quantity}`);

                // Get all dynamic product fields
                const qualitySelect = row.querySelector('select[name="quality[]"]');
                const customQualityInput = row.querySelector('input[name="custom_quality[]"]');
                const sizeSelect = row.querySelector('select[name="size[]"]');
                const customSizeInput = row.querySelector('input[name="custom_size[]"]');
                const sterilitySelect = row.querySelector('select[name="sterility[]"]');
                const piecesInput = row.querySelector('input[name="pieces[]"]');
                const widthSelect = row.querySelector('select[name="width[]"]');
                const customWidthInput = row.querySelector('input[name="custom_width[]"]');
                const lengthInput = row.querySelector('input[name="length[]"]');
                const unitSelect = row.querySelector('select[name="unit[]"]');
                const packingSelect = row.querySelector('select[name="packing[]"]');
                const plySelect = row.querySelector('select[name="ply[]"]');
                const xraySelect = row.querySelector('select[name="x-ray[]"]');
                const contentsSelect = row.querySelector('select[name="contents[]"]');
                const weightSelect = row.querySelector('select[name="weight[]"]');
                const customSpecTextarea = row.querySelector('textarea[name="custom_specifications[]"]');

                // Add dynamic field values
                if (qualitySelect && qualitySelect.value) {
                    details.push(`Quality: ${qualitySelect.value}`);
                }
                if (customQualityInput && customQualityInput.value) {
                    details.push(`Custom Quality: ${customQualityInput.value}`);
                }
                if (sizeSelect && sizeSelect.value) {
                    details.push(`Size: ${sizeSelect.value}`);
                }
                if (customSizeInput && customSizeInput.value) {
                    details.push(`Custom Size: ${customSizeInput.value}`);
                }
                if (sterilitySelect && sterilitySelect.value) {
                    details.push(`Sterility: ${sterilitySelect.value}`);
                }
                if (piecesInput && piecesInput.value) {
                    details.push(`Pieces: ${piecesInput.value}`);
                }
                if (widthSelect && widthSelect.value) {
                    details.push(`Width: ${widthSelect.value}`);
                }
                if (customWidthInput && customWidthInput.value) {
                    details.push(`Custom Width: ${customWidthInput.value}`);
                }
                if (lengthInput && lengthInput.value) {
                    details.push(`Length: ${lengthInput.value}`);
                }
                if (unitSelect && unitSelect.value) {
                    details.push(`Unit: ${unitSelect.value}`);
                }
                if (packingSelect && packingSelect.value) {
                    details.push(`Packing: ${packingSelect.value}`);
                }
                if (plySelect && plySelect.value) {
                    details.push(`Ply: ${plySelect.value}`);
                }
                if (xraySelect && xraySelect.value) {
                    details.push(`X-Ray Detectable: ${xraySelect.value}`);
                }
                if (contentsSelect && contentsSelect.value) {
                    details.push(`Contents: ${contentsSelect.value}`);
                }
                if (weightSelect && weightSelect.value) {
                    details.push(`Weight: ${weightSelect.value}`);
                }
                if (customSpecTextarea && customSpecTextarea.value) {
                    details.push(`Specifications: ${customSpecTextarea.value}`);
                }

                // Add product to message
                if (details.length > 0) {
                    productText += `${productNumber}. ${details.join(" | ")}%0A`;
                }
            });

            // Product configuration data (keep your existing productConfig object as is)
            const productConfig = {
                // ... your existing productConfig object remains the same ...
            };

            // Global product counter
            let productCount = 1;

            // Update product fields based on selection
            function updateProductFields(selectElement) {
                const productRow = selectElement.closest('.product-row');
                const productName = selectElement.value;
                const fieldsContainer = productRow.querySelector('.product-fields');
                const customProductInput = productRow.querySelector('.custom-product-name');

                // Show/hide custom product input
                if (productName === 'Custom Product') {
                    customProductInput.style.display = 'block';
                    customProductInput.required = true;
                } else {
                    customProductInput.style.display = 'none';
                    customProductInput.required = false;
                    customProductInput.value = '';
                }

                // Clear existing fields
                fieldsContainer.innerHTML = '';

                if (productName && productConfig[productName]) {
                    const fields = productConfig[productName].fields;

                    // Calculate column size based on number of fields
                    const colSize = fields.length > 2 ? 'col-md-6' : 'col-md-12';

                    fields.forEach((field, index) => {
                        const fieldHtml = createFieldHtml(field, productName);
                        const fieldContainer = document.createElement('div');
                        fieldContainer.className = `${colSize} mb-3`;
                        fieldContainer.innerHTML = fieldHtml;

                        // Add conditional display class if needed
                        if (field.showIf) {
                            fieldContainer.classList.add('conditional-field');
                            fieldContainer.style.display = 'none';
                        }

                        fieldsContainer.appendChild(fieldContainer);
                    });

                    // Add event listeners for dynamic fields
                    addFieldEventListeners(productRow, productName);
                }
            }

            // Create HTML for a field
            function createFieldHtml(field, productName) {
                let html = '';
                const nameAttr = `${field.name}[]`;
                const requiredAttr = field.required ? 'required' : '';
                const requiredClass = field.required ? 'required-field' : '';

                html += `<label class="form-label ${requiredClass}">${field.label}</label>`;

                if (field.type === 'select') {
                    html += `<select class="form-select" name="${nameAttr}" ${requiredAttr}>`;
                    html += `<option value="" selected disabled>Select ${field.label}</option>`;

                    // For Absorbent Gauze size field, show a default message
                    if (productName === 'Absorbent Gauze' && field.name === 'size' && (!field.options || field.options.length === 0)) {
                        html += `<option value="" disabled>Please select quality first</option>`;
                    } else if (field.options && field.options.length > 0) {
                        // For static options
                        field.options.forEach(option => {
                            const isCustomOption = option.toLowerCase().includes('custom');
                            html += `<option value="${option}" ${isCustomOption ? 'data-custom="true"' : ''}>${option}</option>`;
                        });
                    }

                    html += `</select>`;

                    // Add custom input for ALL select fields that might have custom options
                    const customPlaceholder = `Enter custom ${field.label.toLowerCase()}`;
                    html += `<input type="text" class="form-control mt-2 custom-input" 
                     name="custom_${field.name}[]" 
                     placeholder="${customPlaceholder}" style="display: none;">`;

                } else if (field.type === 'number' || field.type === 'text') {
                    html += `<input type="${field.type}" class="form-control" name="${nameAttr}" 
                     placeholder="${field.placeholder || 'Enter ' + field.label.toLowerCase()}" ${requiredAttr}>`;
                } else if (field.type === 'textarea') {
                    html += `<textarea class="form-control" name="${nameAttr}" 
                     rows="3" placeholder="${field.placeholder || 'Enter ' + field.label.toLowerCase()}" ${requiredAttr}></textarea>`;
                }

                return html;
            }


            // Update pieces field visibility for Gauze Swabs
            function updatePiecesFieldVisibility(productRow, sterility) {
                const piecesField = productRow.querySelector('.conditional-field');
                if (piecesField) {
                    if (sterility === 'Sterile') {
                        piecesField.style.display = 'block';
                        // Make the pieces field required when visible
                        const piecesInput = piecesField.querySelector('input');
                        if (piecesInput) {
                            piecesInput.required = true;
                        }
                    } else {
                        piecesField.style.display = 'none';
                        const piecesInput = piecesField.querySelector('input');
                        if (piecesInput) {
                            piecesInput.value = '';
                            piecesInput.required = false;
                        }
                    }
                }
            }

            // Add event listeners for dynamic field behavior
            function addFieldEventListeners(productRow, productName) {
                const selects = productRow.querySelectorAll('select');

                selects.forEach(select => {
                    // Remove existing event listeners to avoid duplicates
                    select.replaceWith(select.cloneNode(true));
                });

                // Get fresh references after cloning
                const freshSelects = productRow.querySelectorAll('select');

                freshSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const productNameSelect = productRow.querySelector('.product-name');
                        const currentProductName = productNameSelect ? productNameSelect.value : productName;
                        const fieldName = this.name.replace('[]', '');

                        if (currentProductName) {
                            handleFieldChange(this, currentProductName, fieldName);
                        }
                    });
                });

                // If it's Absorbent Gauze and quality is already selected, trigger size update
                if (productName === 'Absorbent Gauze') {
                    const qualitySelect = productRow.querySelector('select[name="quality[]"]');
                    if (qualitySelect && qualitySelect.value) {
                        updateSizeOptions(productRow, qualitySelect.value);
                    }
                }
            }

            // Add product functionality
            document.getElementById('addProductBtn').addEventListener('click', function() {
                productCount++;
                const productsContainer = document.getElementById('productsContainer');
                const newProductRow = document.createElement('div');
                newProductRow.className = 'product-row';
                newProductRow.id = `product-${productCount}`;

                // Create product options HTML
                let productOptions = '';
                const products = <?php echo json_encode($products); ?>;
                products.forEach(product => {
                    productOptions += `<option value="${product}">${product}</option>`;
                });

                newProductRow.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>Product #${productCount}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-product">
                    <i class="bi bi-trash me-1"></i>Remove
                </button>
            </div>
            <input type="hidden" name="order_id" value="<?php echo uniqid('ORD-'); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Product Name</label>
                    <select class="form-select product-name" name="productName[]" required>
                        <option value="" selected disabled>Select Product</option>
                        ${productOptions}
                    </select>
                    <input type="text" class="form-control mt-2 custom-product-name" name="customProductName[]" placeholder="Enter custom product name" style="display: none;">
                </div>
                <div class="col-md-8 mb-3 product-fields"></div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required-field">Quantity</label>
                    <input type="number" class="form-control product-quantity" name="productQuantity[]" placeholder="Enter quantity" min="1" required>
                </div>
            </div>
        `;

                productsContainer.appendChild(newProductRow);

                // Add event listeners to the new product row
                const productNameSelect = newProductRow.querySelector('.product-name');
                productNameSelect.addEventListener('change', function() {
                    updateProductFields(this);
                });

                // Add remove functionality
                const removeBtn = newProductRow.querySelector('.remove-product');
                removeBtn.addEventListener('click', function() {
                    removeProduct(productCount);
                });

                // Scroll to the new product
                newProductRow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });

            // Remove product functionality
            function removeProduct(productId) {
                if (productCount > 1) {
                    const productRow = document.getElementById(`product-${productId}`);
                    if (productRow) {
                        productRow.remove();
                        productCount--;

                        // Update product numbers
                        const productRows = document.querySelectorAll('.product-row');
                        productRows.forEach((row, index) => {
                            const productNumber = index + 1;
                            row.id = `product-${productNumber}`;
                            row.querySelector('h5').textContent = `Product #${productNumber}`;
                        });
                    }
                } else {
                    alert('You must have at least one product in your order.');
                }
            }

            // Initialize the first product row
            document.addEventListener('DOMContentLoaded', function() {
                // Add event listeners to the first product row
                const firstProductRow = document.getElementById('product-1');
                if (firstProductRow) {
                    const productNameSelect = firstProductRow.querySelector('.product-name');
                    if (productNameSelect) {
                        productNameSelect.addEventListener('change', function() {
                            updateProductFields(this);
                        });
                    }

                    // Add remove functionality to first product's remove button
                    const removeBtn = firstProductRow.querySelector('.remove-product');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            removeProduct(1);
                        });
                    }
                }

                // Initialize file upload previews
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    input.addEventListener('change', function() {
                        const label = this.previousElementSibling;
                        if (this.files.length > 0) {
                            label.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i>${this.files[0].name}`;
                            label.classList.add('text-success');
                        } else {
                            label.innerHTML = `<i class="bi bi-upload me-2"></i>Choose File`;
                            label.classList.remove('text-success');
                        }
                    });
                });
            });

            // Form validation and submission
            const form = document.getElementById('orderForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate all required fields
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');

                        // Add error message if not exists
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'This field is required';
                            field.parentNode.appendChild(errorDiv);
                        }
                    } else {
                        field.classList.remove('is-invalid');
                        // Remove error message if exists
                        const errorDiv = field.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv.remove();
                        }
                    }
                });

                // Validate quantity fields specifically
                const quantityFields = form.querySelectorAll('.product-quantity');
                quantityFields.forEach(field => {
                    if (!field.value || field.value < 1) {
                        isValid = false;
                        field.classList.add('is-invalid');

                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'Please enter a valid quantity (minimum 1)';
                            field.parentNode.appendChild(errorDiv);
                        }
                    } else {
                        field.classList.remove('is-invalid');
                        const errorDiv = field.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv.remove();
                        }
                    }
                });

                if (!isValid) {
                    alert('Please fill in all required fields with valid values.');
                    return;
                }

                // If validation passes, proceed with form submission
                const formData = new FormData(this);
                const submitButton = document.querySelector('.comp-btn');

                if (submitButton) {
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...`;
                    submitButton.disabled = true;

                    // Simulate form processing (replace with actual AJAX call if needed)
                    setTimeout(() => {
                        // For demonstration - in real scenario, you'd use AJAX or let the form submit normally
                        alert('Form submitted successfully!');
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;

                        // Uncomment the line below to actually submit the form
                        // this.submit();
                    }, 2000);
                }
            });

            // CAPTCHA functionality (keep your existing CAPTCHA code)
            // ... your existing CAPTCHA code ...

            // Construct WhatsApp message
            let message = `New Order Request%0A%0A`;
            message += `Company Details :%0A`;
            message += `Firm Name: <?php echo $name; ?>%0A`;
            message += `GST No: <?php echo $gst; ?>%0A`;
            message += `Email:<?php echo $email; ?>%0A`;
            message += `Phone: <?php echo $phone; ?>%0A`;
            message += `Address: <?php echo $address; ?>%0A`;
            message += `City: <?php echo $city; ?>%0A`;
            message += `Country: <?php echo $country; ?>%0A`;
            message += `Pincode: <?php echo $pin; ?>%0A%0A`;

            message += `Order Details :%0A`;
            message += productText;
            message += `%0AThank you!`;

            // Your store's WhatsApp number
            const storeNumber = "919790972432";
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Basic form validation
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields.');
                return;
            }

            // Open WhatsApp in new tab
            window.open(whatsappURL, '_blank');
            const formData = new FormData(this);

            const submitButton = document.querySelector('.comp-btn');

            if (submitButton) {
                const originalText = submitButton.innerHTML;

                // Show spinner and disable button
                submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Ordering...`;
                submitButton.disabled = true;

                // After submission finishes (success or failure), reset the button    
            }
            this.submit();
        });

        // Initialize file upload previews
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.previousElementSibling;
                if (this.files.length > 0) {
                    label.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i>${this.files[0].name}`;
                    label.classList.add('text-success');
                } else {
                    label.innerHTML = `<i class="bi bi-upload me-2"></i>Choose File`;
                    label.classList.remove('text-success');
                }
            });
        });
    </script>
    <script>
        document.getElementById('open-chat').addEventListener('click', function() {
            let message = `How can i help You? %0A%0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>
    <script>
        document.getElementById('footer-open-chat').addEventListener('click', function() {
            let message = `How can i help You? %0A%0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>
    <script>
        document.getElementById('nav-open-chat').addEventListener('click', function() {
            let message = `How can i help You? %0A%0A`;

            const storeNumber = "919790972432"; // Your WhatsApp number
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL - fixed encoding
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in a new tab
            window.open(whatsappURL, '_blank');
        });
    </script>
</body>

</html>