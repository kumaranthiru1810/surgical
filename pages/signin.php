<?php
session_start();
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
                            <a class="nav-link" href="./about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./Products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./Management.php">Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../forms/place_order.php">Place Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contact-us.php">Contact Us</a>
                        </li>
                        <!-- <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a class="btn btn-primary me-3" href="#"><?php echo $_SESSION['name']; ?></a>
                        <?php } else { ?>
                            <a href="./signup.php" class="btn btn-primary me-3">Sign Up</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a href="./logout.php" onclick="return confirm('Are you sure you want to logout?');" class="btn btn-primary me-3">Logout</a>
                        <?php } else { ?>
                            <a href="./signin.php" class="btn btn-primary me-3">Sign In</a>
                        <?php } ?>
                    </li> -->
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
        /* body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */
        .card {
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(45deg, #4e73df, #2e59d9);
            color: white;
            border-radius: 0 !important;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #2e59d9);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .input-group {
            position: relative;
        }

        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-text {
            font-size: 0.8rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }

        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.4.4.4-.4'/%3e%3cpath d='M6 7v1'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .is-valid {
            border-color: #198754;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .success-message {
            color: #198754;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center align-item-center mt-5">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user-circle me-2"></i>Sign In</h3>
                    </div>
                    <div class="card-body p-4">
                        <form id="signInForm" method="POST" novalidate>
                            <!-- Email Field -->
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="name@example.com" required>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <span class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- CAPTCHA Section -->
                            <div class="col-12">
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



                            <!-- Sign In Button -->
                            <div class="d-grid">
                                <!-- <button type="submit" class="btn btn-primary btn-lg" name="signin">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </button> -->
                                <input type="submit" value="Sign In" class="btn btn-primary btn-lg" id="submitButton" name="signin" disabled>
                            </div>
                            <div id="formMsg" class="mt-3 text-center text-md-start"></div>
                        </form>

                        <!-- Additional Options -->
                        <div class="mt-4 text-center">
                            <!-- <a href="#" class="text-decoration-none">Forgot Password?</a> -->
                            <hr>
                            <p class="mb-0">Don't have an account? <a href="signup.php" class="text-decoration-none">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php


    // When form is submitted
    if (isset($_POST['signin'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!empty($email) && !empty($password)) {
            // Prepare SQL to fetch user
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Store session
                    $_SESSION['name'] = $user['firm'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];

                    echo "<script>alert('Login successful!'); window.location.href='../index.php';</script>";
                } else {
                    echo "<script>alert('Invalid password.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Email not found. Please sign up first.'); window.location.href='./signup.php';</script>";
            }
        } else {
            echo "<script>alert('Please enter both email and password.'); window.history.back();</script>";
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


    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Email validation
        document.getElementById('email').addEventListener('blur', function() {
            validateEmail();
        });

        // Password validation
        document.getElementById('password').addEventListener('input', function() {
            validatePassword();
            updatePasswordStrength();
        });

        // Form validation on submit
        // document.getElementById('signInForm').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     const isEmailValid = validateEmail();
        //     const isPasswordValid = validatePassword();

        //     if (isEmailValid && isPasswordValid) {
        //         // If validation passes, submit the form (in a real app, this would send to a server)
        //         showSuccessMessage();
        //     }
        // });

        document.getElementById('signInForm').addEventListener('submit', function(e) {
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();

            if (!(isEmailValid && isPasswordValid)) {
                e.preventDefault(); // block only if validation fails
            }
        });


        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailSuccess = document.getElementById('emailSuccess');
            const email = emailInput.value.trim();

            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

            if (email === '') {
                emailInput.classList.remove('is-valid', 'is-invalid');
                emailError.style.display = 'none';
                emailSuccess.style.display = 'none';
                return false;
            }

            if (isValid) {
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                emailError.style.display = 'none';
                emailSuccess.style.display = 'block';
                return true;
            } else {
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
                emailError.style.display = 'block';
                emailSuccess.style.display = 'none';
                return false;
            }
        }

        function validatePassword() {
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');
            const passwordSuccess = document.getElementById('passwordSuccess');
            const password = passwordInput.value;

            // Check if password contains at least one letter, one number, and one special character
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[^a-zA-Z0-9]/.test(password);

            const isValid = hasLetter && hasNumber && hasSpecialChar;

            if (password === '') {
                passwordInput.classList.remove('is-valid', 'is-invalid');
                passwordError.style.display = 'none';
                passwordSuccess.style.display = 'none';
                return false;
            }

            if (isValid) {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                passwordError.style.display = 'none';
                passwordSuccess.style.display = 'block';
                return true;
            } else {
                passwordInput.classList.remove('is-valid');
                passwordInput.classList.add('is-invalid');
                passwordError.style.display = 'block';
                passwordSuccess.style.display = 'none';
                return false;
            }
        }

        function updatePasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrength');

            // Reset strength bar
            strengthBar.className = 'password-strength';

            if (password.length === 0) {
                strengthBar.classList.add('bg-secondary');
                return;
            }

            // Check password strength
            let strength = 0;

            // Length check
            if (password.length >= 8) strength++;

            // Contains letters
            if (/[a-zA-Z]/.test(password)) strength++;

            // Contains numbers
            if (/[0-9]/.test(password)) strength++;

            // Contains special characters
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            // Update strength bar
            if (strength <= 1) {
                strengthBar.classList.add('bg-danger');
            } else if (strength <= 3) {
                strengthBar.classList.add('bg-warning');
            } else {
                strengthBar.classList.add('bg-success');
            }
        }

        // function showSuccessMessage() {
        //     // Create a success alert
        //     const alertDiv = document.createElement('div');
        //     alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
        //     alertDiv.innerHTML = `
        //         <strong>Success!</strong> You have successfully signed in.
        //         <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        //     `;

        //     // Insert after the form
        //     document.getElementById('signInForm').appendChild(alertDiv);

        //     // Reset form after 3 seconds
        //     setTimeout(() => {
        //         document.getElementById('signInForm').reset();
        //         // Remove validation classes
        //         document.getElementById('email').classList.remove('is-valid');
        //         document.getElementById('password').classList.remove('is-valid');
        //         // Hide success messages
        //         document.getElementById('emailSuccess').style.display = 'none';
        //         document.getElementById('passwordSuccess').style.display = 'none';
        //         // Reset password strength indicator
        //         document.getElementById('passwordStrength').className = 'password-strength bg-secondary';
        //         // Remove alert
        //         if (document.querySelector('.alert')) {
        //             document.querySelector('.alert').remove();
        //         }
        //     }, 3000);
        // }
    </script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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