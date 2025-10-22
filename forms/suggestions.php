<?php
session_start();
if (!(isset($_SESSION['name']))) {
    echo "<script>alert('Please login to access this page.');window.location.href='../pages/signin.php';</script>";
    // header("Location: ../pages/signin.php");
    exit();
}
?>

<?php include('../db.php');
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
if ($sql->rowCount() > 0) {
    $data = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Suggestion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../index.css">
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

        /* .helper-widget {
    display: none; /* Hidden by default 
    opacity: 0;
    transition: opacity 0.3s ease;
} */
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

        /* .helper-widget {
    display: none; /* Hidden by default 
    opacity: 0;
    transition: opacity 0.3s ease;
} */

        .helper-widget.show {
            display: block;
            opacity: 1;
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

        .suggestion-form {
            margin-top: 100px !important;
            margin-bottom: 100px !important;
        }

        footer {
            background-color: #f8f9fa;
            padding: 30px 0 15px;
            margin-top: 50px;
        }

        .footer-logo img {
            max-height: 60px;
        }

        .footer-links a {
            margin-left: 15px;
            color: #333;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: #007BFF;
        }

        .footer-bottom {
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 20px;
        }

        .contact-info div {
            margin-bottom: 10px;
        }

        .contact-info i {
            margin-right: 8px;
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
                            <a href="#" id="nav-open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>

                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                        <div class="contact-info text-end">
                            <div>
                                <a href="top-whatsapp" class="phone text-decoration-none text-dark">
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
                            <a href="#" id="nav-open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-4 mt-2 col-sm-3 col-xs-3">
                        <div class="contact-info text-start">
                            <div>
                                <a href="mailto:<?php echo $data['email']; ?>" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-envelope-fill"></i><?php echo $data['email']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mt-2 col-sm-3 col-xs-3">
                        <div class="contact-info text-end">
                            <div>
                                <a href="top-whatsapp" class="phone1 text-decoration-none text-dark">
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
                <a class="navbar-brand" href="#">
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
                            <a class="nav-link" href="./request_sample.php">Place Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/contact-us.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a class="btn btn-primary me-3" href="#"><?php echo $_SESSION['name']; ?></a>
                            <?php } else { ?>
                                <a href="../pages/signup.php" class="btn btn-primary me-3">Sign Up</a>
                            <?php } ?>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a href="../pages/logout.php" class="btn btn-primary me-3">Logout</a>
                            <?php } else { ?>
                                <a href="../pages/signin.php" class="btn btn-primary me-3">Sign In</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
    <div class="container suggestion-form">
        <div class="row mb-3">
            <div class="col-12 text-center page-header">
                <h3><i class="bi bi-lightbulb me-2"></i> Submit a Suggestion</h3>
                <p class="lead mb-0">Share your valuable suggestions with us</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <form id="suggestionForm" method="POST" action="./submit_suggestions.php">
                        <!-- <div class="mb-3">
                            <label class="form-label">Firm Name *</label>
                            <input type="text" name="firmName" id="firmName" class="form-control" required pattern="[A-Za-z0-9\s]+" title="Alphanumeric only">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile No *</label>
                                <div class="input-group">
                                    <select class="form-select" name="countryCode" id="mobile_cc" required></select>
                                    <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" maxlength="10" pattern="\d{10}" title="10 digits only" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp No *</label>
                                <div class="input-group">
                                    <select class="form-select" name="waCountryCode" id="whatsapp_cc"></select>
                                    <input type="text" name="whatsappNumber" id="whatsappNumber" class="form-control" maxlength="10" pattern="\d{10}" title="10 digits only">
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="sameWhatsapp" name="sameWhatsapp">
                                    <label class="form-check-label" for="sameWhatsapp">Same as Mobile Number</label>
                                </div>
                            </div>
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label">Your Suggestions *</label>
                            <textarea name="suggestion" id="suggestionDescription" class="form-control" rows="5" required></textarea>
                        </div>

                        <!-- CAPTCHA Section -->
                        <div class="col-12">
                            <div class="captcha-container">
                                <label class="form-label">Enter the text shown below <span class="text-danger">*</span></label>
                                <div class="captcha-display" id="captchaDisplay"></div>
                                <div class="captcha-controls">
                                    <input type="text" class="form-control captcha-input" id="captchaInput" placeholder="Type the characters above" required>
                                    <button type="button" class="captcha-refresh" id="refreshCaptcha" title="Refresh CAPTCHA">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                                <div class="captcha-error" id="captchaError">CAPTCHA verification failed. Please try again.</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4 sugg-btn" id="submitButton" disabled><i class="bi bi-send"></i> Submit</button>
                        </div>
                        <div id="formMsg" class="mt-3 text-center text-md-start"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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


    <div class="helper-widget">
        <button class="helper-toggle">
            <i class="bi bi-question-circle-fill"></i>
        </button>
        <div class="helper-menu">
            <ul>
                <li><a href="./request_sample.php">Place Order</a></li>
                <li><a href="./get_a_qoute.php">Get Quote</a></li>
                <li><a href="./request_sample.php   ">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./raise_of_complaint.php">Raise a complaint</a></li>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <?php
    $sess_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $sess_id]);
    $suggdata = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $suggdata['firm'];
    $email = $suggdata['email'];
    $phone = $suggdata['mobile_cc'] . $suggdata['mobile'];
    $whatsapp = $suggdata['whatsapp_cc'] . $suggdata['whatsapp'];
    $address = $suggdata['address'];
    $city = $suggdata['city'];
    $country = $suggdata['country']
    ?>
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
        document.getElementById('suggestionForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            // const submitButton = document.querySelector('.sugg-btn');
            // const originalText = submitButton.innerHTML;

            // // Show spinner and disable button
            // submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...`;
            // submitButton.disabled = true;

            // Basic form validation
            let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');

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
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
                return;
            }

            const suggestionDetails = {
                suggestionDescription: formData.get('suggestion')
            };



            let message = `New suggestion Received%0A%0A`;
            message += `Company Details :%0A`;
            message += `Firm Name : <?php echo $name; ?>`;
            message += `Email : <?php echo $email; ?> %0A`;
            message += `Phone : <?php echo '+' . $phone; ?> %0A%0A`;
            message += `WhatsApp : <?php echo '+' . $whatsapp; ?> %0A%0A`;
            message += `Address : <?php echo $address; ?>%0A%0A`;
            message += `City : <?php echo $city; ?>%0A%0A`;
            message += `Country : <?php echo $country; ?>%0A%0A`;

            message += `*Suggestion Details:*%0A`;
            message += `⚠️ ${suggestionDetails.suggestionDescription}%0A%0A`;
            message += `%0AThank you!.`;

            const storeNumber = "919790972432";
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Open WhatsApp in new tab
            window.open(whatsappURL, '_blank');

            // fetch('submit_suggestions.php', {
            //         method: 'POST',
            //         body: formData
            //     })
            //     .then(res => res.json())
            //     .then(data => {
            //         alert(data.message);
            //         if (data.status === 'success') {
            //             window.location.href = 'suggestions.php';
            //         }
            //     })
            //     .catch(err => {
            //         alert('Error submitting suggestion.');
            //     });

            this.submit();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>

</body>

</html>