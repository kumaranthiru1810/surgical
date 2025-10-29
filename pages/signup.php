<?php include('../db.php');
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
if ($sql->rowCount() > 0) {
    $data = $sql->fetch(PDO::FETCH_ASSOC);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../PHPmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

require '../PHPmailer/vendor/autoload.php';

$mail = new PHPMailer(true);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $data['title']; ?></title>
    <!-- Cache Control -->
    <meta
        http-equiv="Cache-Control"
        content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- Description -->
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <!-- Bootstrap CSS -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
        rel="stylesheet" />
    <!-- Animate.css for animations -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet" />
    <!-- AOS CSS -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        rel="stylesheet" />
    <!-- css -->
    <link rel="stylesheet" href="../index.css" />

    <style>
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

        .card {
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        canvas {
            display: block;
            background: #f6f8fb;
            border-radius: 6px;
        }

        .controls {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            align-items: center;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 180px;
        }

        button {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #888;
            background: white;
            cursor: pointer;
        }

        .msg {
            margin-top: 8px;
            font-weight: 600;
        }

        .small {
            font-size: 0.9rem;
            color: #555;
            margin-top: 6px;
        }

        .respon2 {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .respon {
            display: none;
        }

        @media (max-width: 991px) {
            .offcanvas {
                background-color: blue !important;
            }
        }

        @media (min-width:558px) and (max-width:768px) {
            .phone {
                font-size: 15px;
            }
        }

        @media(min-width:454px) and (max-width:557px) {
            .phone {
                font-size: 13px;
            }
        }

        @media(min-width:425px) and (max-width:454px) {
            .phone {
                font-size: 12px;
            }
        }

        @media(max-width:424px) {
            .phone {
                display: none;
            }

            .social-icons {
                display: flex;
                justify-self: start;
                text-align: start;
            }

            .respon2 {
                display: none;
            }

            .respon {
                display: block;
                background-color: #fff;
            }

            .respon .social-icons {
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        @media(min-width:320px) and (max-width:374px) {
            .phone1 {
                font-size: 13px;
            }
        }

        /* .sig-btn {
            padding: 0.75rem 5rem;
            min-width: 160px;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .sig-btn {
                width: 100%;
                padding: 0.75rem 2rem;
            }
        } */
    </style>
</head>

<body>
    <?php
    // PHP configuration and data
    $company_name = "Bharathi Surgicals";
    $featured_products = [
        [
            'image' => './assets/product_1.png',
            'tpi' => '27',
            'width' => '90cm, 100cm, 110cm',
            'length' => '9m - 36m',
            'sterility' => 'Non-Sterile'
        ],
        [
            'image' => './assets/product_2.png', // You might want different product images
            'tpi' => '30',
            'width' => '80cm, 90cm, 100cm',
            'length' => '10m - 40m',
            'sterility' => 'Sterile'
        ],
        [
            'image' => './assets/product_3.png',
            'tpi' => '25',
            'width' => '95cm, 105cm, 115cm',
            'length' => '8m - 35m',
            'sterility' => 'Non-Sterile'
        ]
    ];

    $testimonials = [
        [
            'name' => 'John Doe',
            'position' => 'Nursing Manager',
            'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias quae ad voluptates aliquam.',
            'image' => './assets/testimonial_image.jpg',
            'rating' => 5
        ],
        [
            'name' => 'Jane Smith',
            'position' => 'Head Surgeon',
            'text' => 'Excellent quality products that we rely on for our critical procedures. Highly recommended!',
            'image' => './assets/testimonial2.jpg',
            'rating' => 5
        ],
        [
            'name' => 'Robert Johnson',
            'position' => 'Hospital Administrator',
            'text' => 'Their products have consistently met our standards and their customer service is exceptional.',
            'image' => './assets/testimonial3.jpg',
            'rating' => 4
        ]
    ];

    $contact_info = [
        'phone' => '+91 98765 43210',
        'email' => 'info@bharathisurgicals.com',
        'address' => 'Rajapalayam, Tamil Nadu, India'
    ];

    $social_links = [
        'facebook' => '#',
        'instagram' => '#',
        'whatsapp' => '#'
    ];

    // Get current year dynamically
    $current_year = date('Y');
    ?>

    <!-- Top Navigation -->
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
                    <?php

                    $sql1 = $pdo->query("SELECT * FROM social_links WHERE id = 1");
                    if ($sql1->rowCount() > 0) {
                        $data1 = $sql1->fetch(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <div class="col-4 col-md-4 col-lg-4 mt-1 col-sm-4 col-xs-6">
                        <div class="social-icons text-center">
                            <a href="<?php echo $data1['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                            <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                            <a href="<?php echo $social_links['whatsapp']; ?>" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                        <div class="contact-info text-end">
                            <div>
                                <a href="tel:+919790972432" id="top-whatsapp" class="phone text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i>
                                </a>
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
                            <a href="<?php echo $data1['instagram']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                            <a id="nav-open-chat2" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
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
                                <a href="tel:+919790972432" id="top-whatsapp2" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i>
                                </a>
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
                        <img src="../assets/logo.jpeg" alt="<?php echo $company_name; ?> Logo" class="me-2">
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
                            <a class="nav-link" href="../forms/place_order.php">Place Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/contact-us.php">Contact Us</a>
                        </li>


                        <?php if (!isset($_SESSION['user_name'])): ?>
                            <!-- Not logged in -->
                            <li class="nav-item">
                                <a href="./signup.php" class="btn btn-primary me-3">Sign Up</a>
                            </li>
                            <li class="nav-item">
                                <a href="./signin.php" class="btn btn-primary me-3">Sign In</a>
                            </li>
                        <?php else: ?>
                            <!-- Logged in -->
                            <li class="nav-item">
                                <span class="btn btn-success me-3">
                                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                                </span>
                            </li>
                            <li class="nav-item">
                                <a href="./logout.php" onclick="return confirm('Are you sure you want to logout?');" class="btn btn-danger me-3">Logout</a>
                            </li>
                        <?php endif; ?>


                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <style>
        body {
            background: #f8f9fa;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .note {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .error {
            color: #dc3545;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .card {
                margin: 0 -10px;
                border-radius: 0;
                box-shadow: none;
            }

            .btn-primary {
                width: 100%;
            }

            .input-group {
                flex-wrap: nowrap;
            }

            .input-group .form-select {
                flex: 0 0 120px;
            }

            .input-group .form-control {
                flex: 1;
            }
        }

        @media (max-width: 576px) {
            .input-group {
                flex-direction: column;
            }

            .input-group .form-select,
            .input-group .form-control {
                width: 100%;
                flex: none;
            }

            .input-group .form-select {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow p-3 p-md-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center text-md-start">Sign Up</h3>

                        <form id="signupForm" method="POST" novalidate>
                            <div class="row g-3">

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">User ID (Email) <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>

                                <!-- Password -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" required
                                        pattern="(?=^.*[A-Z])(?=^.*[a-z])(?=^.*\d)(?=^.*[^A-Za-z0-9]).{8,}">
                                    <div class="note mt-1">At least 8 characters, must include uppercase, lowercase, number & special character.</div>
                                    <div class="invalid-feedback">Password must meet the complexity requirements.</div>
                                </div>

                                <!-- Firm Name -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Firm Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="firm" required>
                                    <div class="invalid-feedback">Please enter your firm name.</div>
                                </div>

                                <!-- GST -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">GST No (India)</label>
                                    <input style="text-transform: uppercase;" type="text" class="form-control" name="gst"
                                        minlength="15" maxlength="15" pattern="[0-9A-Z]{15}">
                                    <div class="note mt-1">15 characters (letters and numbers)</div>
                                    <div class="invalid-feedback">Please enter a valid 15-character GST number.</div>
                                </div>

                                <!-- Licence -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Drug/Manufacturing Licence/IE Code</label>
                                    <input type="text" class="form-control" name="drug" pattern="[A-Za-z0-9\-\/ ]+">
                                    <div class="invalid-feedback">Please enter a valid licence number.</div>
                                </div>

                                <!-- Mobile -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" name="mobile_cc" id="mobile_cc" required style="flex: 0 0 140px;"></select>
                                        <input type="tel" class="form-control" name="mobile" required pattern="\d{6,15}" placeholder="Enter mobile number">
                                    </div>
                                    <div class="invalid-feedback">Please enter a valid mobile number.</div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label">WhatsApp Number</label>
                                    <div class="input-group">
                                        <select class="form-select" name="whatsapp_cc" id="whatsapp_cc" style="flex: 0 0 140px;"></select>
                                        <input type="tel" class="form-control" name="whatsapp" pattern="\d{6,15}" placeholder="Enter WhatsApp number">
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="copyMobile">
                                        <label class="form-check-label" for="copyMobile">Copy from Mobile</label>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" name="address" required placeholder="Enter your complete address"></textarea>
                                    <div class="invalid-feedback">Please enter your address.</div>
                                </div>

                                <!-- City -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="city" required>
                                    <div class="invalid-feedback">Please enter your city.</div>
                                </div>

                                <!-- Country -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select class="form-select" name="country" id="country" required></select>
                                    <div class="invalid-feedback">Please select your country.</div>
                                </div>

                                <!-- PIN -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label">PIN / ZIP Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pin" id="pin" required pattern="\d{6}">
                                    <div class="invalid-feedback">Please enter a valid PIN/ZIP code.</div>
                                </div>

                                <!-- State -->
                                <div class="col-12 col-md-6" id="stateDiv">
                                    <label class="form-label">State (India only)</label>
                                    <select class="form-select" name="state" id="state"></select>
                                </div>

                                <!-- District -->
                                <div class="col-12 col-md-6" id="districtDiv">
                                    <label class="form-label">District</label>
                                    <select class="form-select" name="district" id="district"></select>
                                </div>

                            </div>
                            <!-- CAPTCHA Section -->
                            <div class="col-12 mt-4">
                                <div class="captcha-container">
                                    <label class="form-label">Enter the text shown below <span class="text-danger">*</span></label>
                                    <div class="captcha-display" id="captchaDisplay"></div>
                                    <div class="captcha-controls">
                                        <input type="text" class="form-control captcha-input" id="captchaInput" placeholder="Type the characters above" style="border: 1px solid #000;" required>
                                        <button type="button" class="captcha-refresh" id="refreshCaptcha" title="Refresh CAPTCHA">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="captcha-error" id="captchaError">CAPTCHA verification failed. Please try again.</div>
                                </div>
                            </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <!-- <div class="d-grid d-md-flex justify-content-md-end"> -->
                            <button type="submit" class="btn btn-primary px-4 sig-btn" id="submitButton" name="register" style="width:100%;" disabled>
                                Register
                            </button>
                            <!-- </div> -->
                        </div>
                    </div>

                    <div id="formMsg" class="mt-3 text-center text-md-start"></div>
                    </form>

                    <!-- Login Link -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <p class="mb-0">Already have an account?
                                <a href="./signin.php" class="text-decoration-none">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php
    // Include your database connection
    include('../db.php');

    // Check if form is submitted
    if (isset($_POST['register'])) {

        // Get POST data and sanitize
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $firm = trim($_POST['firm']);
        $gst = trim($_POST['gst']);
        $drug = trim($_POST['drug']);
        $mobile_cc = trim($_POST['mobile_cc']);
        $mobile = trim($_POST['mobile']);
        $whatsapp_cc = trim($_POST['whatsapp_cc']);
        $whatsapp = trim($_POST['whatsapp']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);
        $pin = trim($_POST['pin']);
        $state = trim($_POST['state']);
        $district = trim($_POST['district']);


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
            $mail->Subject = "New User Registration from $name";
            
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
                                    <tr><td><strong>Firm Name:</strong></td><td>$firm</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>$email</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>$mobile_cc.$mobile</td></tr>
                                    <tr><td><strong>WhatsApp:</strong></td><td>$whatsapp_cc.$whatsapp</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>$address</td></tr>
                                    <tr><td><strong>City:</strong></td><td>$city</td></tr>
                                    <tr><td><strong>Country:</strong></td><td>$country</td></tr>
                                    <tr><td><strong>PinCode:</strong></td><td>$pin</td></tr>
                                    <tr><td><strong>GST No:</strong></td><td>$gst</td></tr>
                                    <tr><td><strong>Drug License No:</strong></td><td>$drug</td></tr>
                                    <tr><td><strong>State:</strong></td><td>$state</td></tr>
                                    <tr><td><strong>District:</strong></td><td>$district</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            ";
             $mail->send();

        } catch (Exception $e) {
            // Handle email sending error
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Step 1: Check if email already exists
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();
        $count = $check->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('Email already registered! Please use another email.');window.location.href='./signup.php';</script>";
            exit;
        }

        // ✅ Step 2: Insert the new record
        $sql = "INSERT INTO users 
        (email, password, firm, gst, drug, mobile_cc, mobile, whatsapp_cc, whatsapp, address, city, country, pin, state, district) 
        VALUES 
        (:email, :password, :firm, :gst, :drug, :mobile_cc, :mobile, :whatsapp_cc, :whatsapp, :address, :city, :country, :pin, :state, :district)";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':firm', $firm);
        $stmt->bindParam(':gst', $gst);
        $stmt->bindParam(':drug', $drug);
        $stmt->bindParam(':mobile_cc', $mobile_cc);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':whatsapp_cc', $whatsapp_cc);
        $stmt->bindParam(':whatsapp', $whatsapp);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':pin', $pin);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':district', $district);

        

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');window.location.href='./signin.php';</script>";
        } else {
            echo "<script>alert('Error! Please try again.');window.location.href='./signup.php';</script>";
        }
    }
    ?>

    <div class="helper-widget">
        <button class="helper-toggle">
            <i class="bi bi-question-circle-fill"></i>
        </button>
        <div class="helper-menu">
            <ul>
                <li><a href="../forms/place_order.php">Place Orders</a></li>
                <li><a href="../forms/get_a_qoute.php">Get Quote</a></li>
                <li><a href="../forms/request_sample.php">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="../forms/raise_of_complaint.php">Raise a Complaint</a></li>
                <li><a href="../forms/suggestions.php">Suggestions</a></li>
                <li><a href="#chat" id="open-chat">Chat with us</a></li>
            </ul>
        </div>
    </div>
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
        // --- Country List ---
        const countries = [
            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia",
            "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin",
            "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi",
            "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile", "China", "Colombia",
            "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica",
            "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini",
            "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada",
            "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia",
            "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait",
            "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg",
            "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico",
            "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru",
            "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway",
            "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal",
            "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent", "Samoa", "San Marino",
            "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands",
            "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
            "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
            "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
            "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
        ];

        const countrySel = document.getElementById("country");
        countries.forEach(c => {
            let opt = new Option(c, c, c === "India", c === "India");
            countrySel.add(opt);
        });

        // --- Mobile & WhatsApp Country Codes ---
        //   const codes = ["+91","+1","+44","+61","+971","+81","+49","+33","+7"];
        const countryCodes = [{
                code: "+93",
                country: "Afghanistan"
            },
            {
                code: "+355",
                country: "Albania"
            },
            {
                code: "+213",
                country: "Algeria"
            },
            {
                code: "+376",
                country: "Andorra"
            },
            {
                code: "+244",
                country: "Angola"
            },
            {
                code: "+1-264",
                country: "Anguilla"
            },
            {
                code: "+1-268",
                country: "Antigua and Barbuda"
            },
            {
                code: "+54",
                country: "Argentina"
            },
            {
                code: "+374",
                country: "Armenia"
            },
            {
                code: "+297",
                country: "Aruba"
            },
            {
                code: "+61",
                country: "Australia"
            },
            {
                code: "+43",
                country: "Austria"
            },
            {
                code: "+994",
                country: "Azerbaijan"
            },
            {
                code: "+1-242",
                country: "Bahamas"
            },
            {
                code: "+973",
                country: "Bahrain"
            },
            {
                code: "+880",
                country: "Bangladesh"
            },
            {
                code: "+1-246",
                country: "Barbados"
            },
            {
                code: "+375",
                country: "Belarus"
            },
            {
                code: "+32",
                country: "Belgium"
            },
            {
                code: "+501",
                country: "Belize"
            },
            {
                code: "+229",
                country: "Benin"
            },
            {
                code: "+1-441",
                country: "Bermuda"
            },
            {
                code: "+975",
                country: "Bhutan"
            },
            {
                code: "+591",
                country: "Bolivia"
            },
            {
                code: "+387",
                country: "Bosnia and Herzegovina"
            },
            {
                code: "+267",
                country: "Botswana"
            },
            {
                code: "+55",
                country: "Brazil"
            },
            {
                code: "+246",
                country: "British Indian Ocean Territory"
            },
            {
                code: "+1-284",
                country: "British Virgin Islands"
            },
            {
                code: "+673",
                country: "Brunei"
            },
            {
                code: "+359",
                country: "Bulgaria"
            },
            {
                code: "+226",
                country: "Burkina Faso"
            },
            {
                code: "+257",
                country: "Burundi"
            },
            {
                code: "+855",
                country: "Cambodia"
            },
            {
                code: "+237",
                country: "Cameroon"
            },
            {
                code: "+1-345",
                country: "Cayman Islands"
            },
            {
                code: "+236",
                country: "Central African Republic"
            },
            {
                code: "+56",
                country: "Chile"
            },
            {
                code: "+86",
                country: "China"
            },
            {
                code: "+61",
                country: "Christmas Island"
            },
            {
                code: "+61",
                country: "Cocos (Keeling) Islands"
            },
            {
                code: "+57",
                country: "Colombia"
            },
            {
                code: "+269",
                country: "Comoros"
            },
            {
                code: "+242",
                country: "Congo (Republic)"
            },
            {
                code: "+243",
                country: "Congo (Democratic Republic)"
            },
            {
                code: "+682",
                country: "Cook Islands"
            },
            {
                code: "+506",
                country: "Costa Rica"
            },
            {
                code: "+225",
                country: "Côte d'Ivoire"
            },
            {
                code: "+385",
                country: "Croatia"
            },
            {
                code: "+53",
                country: "Cuba"
            },
            {
                code: "+599",
                country: "Curaçao"
            },
            {
                code: "+357",
                country: "Cyprus"
            },
            {
                code: "+420",
                country: "Czech Republic"
            },
            {
                code: "+45",
                country: "Denmark"
            },
            {
                code: "+253",
                country: "Djibouti"
            },
            {
                code: "+1-767",
                country: "Dominica"
            },
            {
                code: "+1-809",
                country: "Dominican Republic"
            },
            {
                code: "+670",
                country: "East Timor"
            },
            {
                code: "+593",
                country: "Ecuador"
            },
            {
                code: "+20",
                country: "Egypt"
            },
            {
                code: "+503",
                country: "El Salvador"
            },
            {
                code: "+240",
                country: "Equatorial Guinea"
            },
            {
                code: "+291",
                country: "Eritrea"
            },
            {
                code: "+372",
                country: "Estonia"
            },
            {
                code: "+251",
                country: "Ethiopia"
            },
            {
                code: "+500",
                country: "Falkland Islands"
            },
            {
                code: "+298",
                country: "Faroe Islands"
            },
            {
                code: "+679",
                country: "Fiji"
            },
            {
                code: "+358",
                country: "Finland"
            },
            {
                code: "+33",
                country: "France"
            },
            {
                code: "+594",
                country: "French Guiana"
            },
            {
                code: "+689",
                country: "French Polynesia"
            },
            {
                code: "+241",
                country: "Gabon"
            },
            {
                code: "+220",
                country: "Gambia"
            },
            {
                code: "+995",
                country: "Georgia"
            },
            {
                code: "+49",
                country: "Germany"
            },
            {
                code: "+233",
                country: "Ghana"
            },
            {
                code: "+350",
                country: "Gibraltar"
            },
            {
                code: "+30",
                country: "Greece"
            },
            {
                code: "+299",
                country: "Greenland"
            },
            {
                code: "+1-473",
                country: "Grenada"
            },
            {
                code: "+1-671",
                country: "Guam"
            },
            {
                code: "+502",
                country: "Guatemala"
            },
            {
                code: "+224",
                country: "Guinea"
            },
            {
                code: "+245",
                country: "Guinea-Bissau"
            },
            {
                code: "+595",
                country: "Guyana"
            },
            {
                code: "+509",
                country: "Haiti"
            },
            {
                code: "+504",
                country: "Honduras"
            },
            {
                code: "+852",
                country: "Hong Kong"
            },
            {
                code: "+36",
                country: "Hungary"
            },
            {
                code: "+354",
                country: "Iceland"
            },
            {
                code: "+91",
                country: "India"
            },
            {
                code: "+62",
                country: "Indonesia"
            },
            {
                code: "+98",
                country: "Iran"
            },
            {
                code: "+964",
                country: "Iraq"
            },
            {
                code: "+353",
                country: "Ireland"
            },
            {
                code: "+972",
                country: "Israel"
            },
            {
                code: "+39",
                country: "Italy"
            },
            {
                code: "+1-876",
                country: "Jamaica"
            },
            {
                code: "+81",
                country: "Japan"
            },
            {
                code: "+962",
                country: "Jordan"
            },
            {
                code: "+7",
                country: "Kazakhstan"
            },
            {
                code: "+254",
                country: "Kenya"
            },
            {
                code: "+686",
                country: "Kiribati"
            },
            {
                code: "+965",
                country: "Kuwait"
            },
            {
                code: "+996",
                country: "Kyrgyzstan"
            },
            {
                code: "+856",
                country: "Laos"
            },
            {
                code: "+371",
                country: "Latvia"
            },
            {
                code: "+961",
                country: "Lebanon"
            },
            {
                code: "+266",
                country: "Lesotho"
            },
            {
                code: "+231",
                country: "Liberia"
            },
            {
                code: "+218",
                country: "Libya"
            },
            {
                code: "+423",
                country: "Liechtenstein"
            },
            {
                code: "+370",
                country: "Lithuania"
            },
            {
                code: "+352",
                country: "Luxembourg"
            },
            {
                code: "+853",
                country: "Macau"
            },
            {
                code: "+261",
                country: "Madagascar"
            },
            {
                code: "+265",
                country: "Malawi"
            },
            {
                code: "+60",
                country: "Malaysia"
            },
            {
                code: "+960",
                country: "Maldives"
            },
            {
                code: "+223",
                country: "Mali"
            },
            {
                code: "+356",
                country: "Malta"
            },
            {
                code: "+692",
                country: "Marshall Islands"
            },
            {
                code: "+596",
                country: "Martinique"
            },
            {
                code: "+222",
                country: "Mauritania"
            },
            {
                code: "+230",
                country: "Mauritius"
            },
            {
                code: "+262",
                country: "Mayotte"
            },
            {
                code: "+52",
                country: "Mexico"
            },
            {
                code: "+691",
                country: "Micronesia"
            },
            {
                code: "+373",
                country: "Moldova"
            },
            {
                code: "+377",
                country: "Monaco"
            },
            {
                code: "+976",
                country: "Mongolia"
            },
            {
                code: "+382",
                country: "Montenegro"
            },
            {
                code: "+1-664",
                country: "Montserrat"
            },
            {
                code: "+212",
                country: "Morocco"
            },
            {
                code: "+258",
                country: "Mozambique"
            },
            {
                code: "+95",
                country: "Myanmar"
            },
            {
                code: "+264",
                country: "Namibia"
            },
            {
                code: "+674",
                country: "Nauru"
            },
            {
                code: "+977",
                country: "Nepal"
            },
            {
                code: "+31",
                country: "Netherlands"
            },
            {
                code: "+687",
                country: "New Caledonia"
            },
            {
                code: "+64",
                country: "New Zealand"
            },
            {
                code: "+505",
                country: "Nicaragua"
            },
            {
                code: "+227",
                country: "Niger"
            },
            {
                code: "+234",
                country: "Nigeria"
            },
            {
                code: "+683",
                country: "Niue"
            },
            {
                code: "+672",
                country: "Norfolk Island"
            },
            {
                code: "+850",
                country: "North Korea"
            },
            {
                code: "+1-670",
                country: "Northern Mariana Islands"
            },
            {
                code: "+47",
                country: "Norway"
            },
            {
                code: "+968",
                country: "Oman"
            },
            {
                code: "+92",
                country: "Pakistan"
            },
            {
                code: "+680",
                country: "Palau"
            },
            {
                code: "+970",
                country: "Palestine"
            },
            {
                code: "+507",
                country: "Panama"
            },
            {
                code: "+675",
                country: "Papua New Guinea"
            },
            {
                code: "+595",
                country: "Paraguay"
            },
            {
                code: "+51",
                country: "Peru"
            },
            {
                code: "+63",
                country: "Philippines"
            },
            {
                code: "+48",
                country: "Poland"
            },
            {
                code: "+351",
                country: "Portugal"
            },
            {
                code: "+1-787",
                country: "Puerto Rico"
            },
            {
                code: "+974",
                country: "Qatar"
            },
            {
                code: "+262",
                country: "Réunion"
            },
            {
                code: "+40",
                country: "Romania"
            },
            {
                code: "+7",
                country: "Russia"
            },
            {
                code: "+250",
                country: "Rwanda"
            },
            {
                code: "+590",
                country: "Saint Barthélemy"
            },
            {
                code: "+1-869",
                country: "Saint Kitts and Nevis"
            },
            {
                code: "+1-758",
                country: "Saint Lucia"
            },
            {
                code: "+590",
                country: "Saint Martin"
            },
            {
                code: "+1-721",
                country: "Sint Maarten"
            },
            {
                code: "+685",
                country: "Samoa"
            },
            {
                code: "+378",
                country: "San Marino"
            },
            {
                code: "+239",
                country: "São Tomé and Príncipe"
            },
            {
                code: "+966",
                country: "Saudi Arabia"
            },
            {
                code: "+221",
                country: "Senegal"
            },
            {
                code: "+381",
                country: "Serbia"
            },
            {
                code: "+248",
                country: "Seychelles"
            },
            {
                code: "+232",
                country: "Sierra Leone"
            },
            {
                code: "+65",
                country: "Singapore"
            },
            {
                code: "+421",
                country: "Slovakia"
            },
            {
                code: "+386",
                country: "Slovenia"
            },
            {
                code: "+677",
                country: "Solomon Islands"
            },
            {
                code: "+252",
                country: "Somalia"
            },
            {
                code: "+27",
                country: "South Africa"
            },
            {
                code: "+82",
                country: "South Korea"
            },
            {
                code: "+211",
                country: "South Sudan"
            },
            {
                code: "+34",
                country: "Spain"
            },
            {
                code: "+94",
                country: "Sri Lanka"
            },
            {
                code: "+249",
                country: "Sudan"
            },
            {
                code: "+597",
                country: "Suriname"
            },
            {
                code: "+268",
                country: "Eswatini"
            },
            {
                code: "+46",
                country: "Sweden"
            },
            {
                code: "+41",
                country: "Switzerland"
            },
            {
                code: "+963",
                country: "Syria"
            },
            {
                code: "+886",
                country: "Taiwan"
            },
            {
                code: "+992",
                country: "Tajikistan"
            },
            {
                code: "+255",
                country: "Tanzania"
            },
            {
                code: "+66",
                country: "Thailand"
            },
            {
                code: "+670",
                country: "Timor-Leste"
            },
            {
                code: "+228",
                country: "Togo"
            },
            {
                code: "+690",
                country: "Tokelau"
            },
            {
                code: "+676",
                country: "Tonga"
            },
            {
                code: "+1-868",
                country: "Trinidad and Tobago"
            },
            {
                code: "+216",
                country: "Tunisia"
            },
            {
                code: "+90",
                country: "Turkey"
            },
            {
                code: "+993",
                country: "Turkmenistan"
            },
            {
                code: "+1-649",
                country: "Turks and Caicos Islands"
            },
            {
                code: "+688",
                country: "Tuvalu"
            },
            {
                code: "+256",
                country: "Uganda"
            },
            {
                code: "+380",
                country: "Ukraine"
            },
            {
                code: "+971",
                country: "United Arab Emirates"
            },
            {
                code: "+44",
                country: "United Kingdom"
            },
            {
                code: "+1",
                country: "United States"
            },
            {
                code: "+598",
                country: "Uruguay"
            },
            {
                code: "+998",
                country: "Uzbekistan"
            },
            {
                code: "+678",
                country: "Vanuatu"
            },
            {
                code: "+379",
                country: "Vatican City"
            },
            {
                code: "+58",
                country: "Venezuela"
            },
            {
                code: "+84",
                country: "Vietnam"
            },
            {
                code: "+681",
                country: "Wallis and Futuna"
            },
            {
                code: "+967",
                country: "Yemen"
            },
            {
                code: "+260",
                country: "Zambia"
            },
            {
                code: "+263",
                country: "Zimbabwe"
            }
        ];

        const mobileCC = document.getElementById("mobile_cc");
        const whatsappCC = document.getElementById("whatsapp_cc");
        countryCodes.forEach(c => {
            mobileCC.add(new Option(`${c.country} (${c.code})`, c.code, c.code === "+91", c.code === "+91"));
            whatsappCC.add(new Option(`${c.country} (${c.code})`, c.code, c.code === "+91", c.code === "+91"));
        });

        // --- Indian States ---
        const states = ["Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana",
            "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya",
            "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
            "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands", "Chandigarh",
            "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry", "Ladakh", "Jammu and Kashmir"
        ];
        const stateSel = document.getElementById("state");
        states.forEach(s => stateSel.add(new Option(s, s)));

        // --- Sample Districts ---
        const districts = {
            "Andhra Pradesh": ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Kadapa", "Krishna", "Kurnool", "Nellore", "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari", "YSR Kadapa"],
            "Arunachal Pradesh": ["Tawang", "West Kameng", "East Kameng", "Papum Pare", "Kurung Kumey", "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "East Siang", "Siang", "Lower Siang", "Upper Siang", "Lower Dibang Valley", "Dibang Valley", "Upper Dibang Valley", "Anjaw", "Lohit", "Namsai", "Changlang", "Tirap", "Longding"],
            "Assam": ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup", "Kamrup Metropolitan", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", "Tinsukia", "Udalguri", "West Karbi Anglong"],
            "Bihar": ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"],
            "Chhattisgarh": ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Janjgir-Champa", "Jashpur", "Kabirdham", "Kanker", "Kawardha", "Korba", "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur", "Surguja"],
            "Goa": ["North Goa", "South Goa"],
            "Gujarat": ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar", "Botad", "Chhota Udepur", "Dahod", "Dang", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad"],
            "Haryana": ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurgaon", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Mewat", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"],
            "Himachal Pradesh": ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul & Spiti", "Mandi", "Shimla", "Sirmaur", "Solan", "Una"],
            "Jharkhand": ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahibganj", "Saraikela Kharsawan", "Simdega", "West Singhbhum"],
            "Karnataka": ["Bagalkot", "Ballari", "Belagavi", "Bengaluru Rural", "Bengaluru Urban", "Bidar", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", "Dakshina Kannada", "Davangere", "Dharwad", "Gadag", "Hassan", "Haveri", "Kalaburagi", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysuru", "Raichur", "Ramanagara", "Shivamogga", "Tumakuru", "Udupi", "Uttara Kannada", "Vijayapura", "Yadgir"],
            "Kerala": ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"],
            "Madhya Pradesh": ["Agar Malwa", "Alirajpur", "Anuppur", "Ashok Nagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna", "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"],
            "Maharashtra": ["Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"],
            "Manipur": ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"],
            "Meghalaya": ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"],
            "Mizoram": ["Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip"],
            "Nagaland": ["Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Peren", "Phek", "Tuensang", "Wokha", "Zunheboto"],
            "Odisha": ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Deogarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Sonepur", "Sundargarh"],
            "Punjab": ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Firozpur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Mansa", "Moga", "Muktsar", "Pathankot", "Patiala", "Rupnagar", "Sangrur", "Shahid Bhagat Singh Nagar", "Tarn Taran"],
            "Rajasthan": ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Tonk", "Udaipur"],
            "Sikkim": ["East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"],
            "Tamil Nadu": ["Ariyalur", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Tirunelveli", "Tirupattur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"],
            "Telangana": ["Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar Bhoopalpally", "Jogulamba Gadwal", "Kamareddy", "Karimnagar", "Khammam", "Komaram Bheem Asifabad", "Mahabubabad", "Mahabubnagar", "Mancherial", "Medak", "Medchal Malkajgiri", "Nagarkurnool", "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Rangareddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"],
            "Tripura": ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"],
            "Uttar Pradesh": ["Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Ayodhya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Faizabad", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kushinagar", "Lakhimpur Kheri", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"],
            "Uttarakhand": ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal", "Udham Singh Nagar", "Uttarkashi"],
            "West Bengal": ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", "Purulia", "South 24 Parganas", "Uttar Dinajpur"]
        };
        const districtSel = document.getElementById("district");

        function updateDistricts(state) {
            districtSel.innerHTML = "";
            if (districts[state]) {
                districts[state].forEach(d => districtSel.add(new Option(d, d)));
            } else {
                districtSel.add(new Option("Other", "Other"));
            }
        }

        // Initialize district based on default state
        if (stateSel.value) {
            stateSel.dispatchEvent(new Event('change'));
        }


        // Initialize district based on default state
        if (stateSel.value) {
            stateSel.dispatchEvent(new Event('change'));
        }


        // Populate districts based on state
        function updateDistricts(state) {
            districtSel.innerHTML = "";
            if (districts[state]) {
                districts[state].forEach(d => districtSel.add(new Option(d, d)));
            } else {
                districtSel.add(new Option("Other", "Other"));
            }
        }

        // Trigger when state changes
        stateSel.addEventListener("change", e => updateDistricts(e.target.value));

        // Initialize default
        updateDistricts(stateSel.value);





        //   stateSel.addEventListener("change", e=>updateDistricts(e.target.value));

        // --- Country Change ---
        countrySel.addEventListener("change", () => {
            if (countrySel.value === "India") {
                document.getElementById("stateDiv").style.display = "block";
                document.getElementById("districtDiv").style.display = "block";
                document.getElementById("pin").pattern = "\\d{6}";
            } else {
                document.getElementById("stateDiv").style.display = "none";
                document.getElementById("districtDiv").style.display = "none";
                document.getElementById("pin").pattern = ".{3,10}";
            }
        });

        // --- Copy Mobile to WhatsApp ---
        document.getElementById("copyMobile").addEventListener("change", (e) => {
            if (e.target.checked) {
                whatsappCC.value = mobileCC.value;
                document.querySelector("[name=whatsapp]").value = document.querySelector("[name=mobile]").value;
            }
        });

        // --- Form Validation ---
        // document.getElementById("signupForm").addEventListener("submit", e => {
        //     e.preventDefault();
        //     const form = e.target;
        //     if (!form.checkValidity()) {
        //         form.classList.add("was-validated");
        //         return;
        //     }
        //      document.getElementById("formMsg").innerHTML = "<span class='text-success'>Form validated successfully!</span>";
        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: false,
            mirror: true,
            /* Re-trigger on scroll up */
        });
    </script>

</body>

</html>