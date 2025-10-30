<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e8f0ff);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        header {
            background: linear-gradient(135deg, #004aad, #0066cc);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 40px 50px;
        }

        .section-title {
            color: #004aad;
            font-size: 1.6rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e8f0ff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.4rem;
        }

        .terms-list {
            list-style: none;
            margin-bottom: 30px;
        }

        .terms-list li {
            padding: 15px 20px;
            margin-bottom: 15px;
            background: #f8f9ff;
            border-left: 4px solid #004aad;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .terms-list li i {
            color: #004aad;
            margin-top: 3px;
            font-size: 1.1rem;
        }

        .terms-list li strong {
            color: #004aad;
        }

        .enquiry-section {
            background: #f8f9ff;
            padding: 30px;
            border-radius: 12px;
            margin-top: 40px;
        }

        .enquiry-title {
            color: #004aad;
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        input,
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e7ff;
            border-radius: 10px;
            font-family: "Poppins", sans-serif;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #004aad;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
        }

        textarea {
            height: 140px;
            resize: none;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: #004aad;
            color: white;
        }

        .btn-primary:hover {
            background: #003a8a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
        }

        .btn-secondary {
            background: #f0f4ff;
            color: #004aad;
            border: 2px solid #004aad;
        }

        .btn-secondary:hover {
            background: #e0e7ff;
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            padding: 25px;
            background: #f8f9ff;
            color: #666;
            font-size: 0.9rem;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .content {
                padding: 30px 25px;
            }

            h1 {
                font-size: 2.2rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .buttons {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Terms & Conditions</h1>
            <p class="header-subtitle">Please read our terms carefully before proceeding</p>
        </header>

        <div class="content">
            <h2 class="section-title">
                <i class="fas fa-gavel"></i>
                Sales Policy
            </h2>

            <ul class="terms-list">
                <li>
                    <i class="fas fa-ban"></i>
                    <div>Goods once sold will not be taken back.</div>
                </li>
                <li>
                    <i class="fas fa-percentage"></i>
                    <div>Bills not paid on due date will attract <strong>24% Interest per annum</strong> till it is paid.</div>
                </li>
                <li>
                    <i class="fas fa-balance-scale"></i>
                    <div>On payment default, all expenses such as Legal Cost, Travel, Court Fee, etc. due to recovery of the payment will be collected from the buyer.</div>
                </li>
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <div>All disputes are subject to <strong>Srivilliputtur/Rajapalayam, Tamil Nadu Jurisdiction</strong> only.</div>
                </li>
            </ul>

            <div class="enquiry-section">
                <h2 class="enquiry-title">
                    <i class="fas fa-question-circle"></i>
                    For Any Enquiry
                </h2>

                <form action="" method="post" onsubmit="return validateForm()">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Your Name" value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Your Email" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea id="enquiry" name="enquiry" placeholder="Please enter your enquiry here..."><?php if (isset($_POST['enquiry'])) echo htmlspecialchars($_POST['enquiry']); ?></textarea>
                    </div>

                    <div class="buttons">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Submit Enquiry
                        </button>
                        <a href="./index.php" style="text-decoration: none;">
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-home"></i>
                                Back to Home
                            </button>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <p>© 2025 All Rights Reserved.</p>
            <div class="contact-info">
                <div class="contact-item">
                    <a href="mailto:cs@bharathi.co.in" style="text-decoration: none;">
                        <i class="fas fa-envelope"></i>
                        <span>cs@bharathi.co.in</span>
                    </a>
                </div>
                <div class="contact-item">
                    <a href="tel:+919790972432" style="text-decoration: none;">
                        <i class="fas fa-phone"></i>
                        <span>+91 9790972432</span>
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function validateForm() {
            let name = document.getElementById('name').value.trim();
            let email = document.getElementById('email').value.trim();
            let enquiry = document.getElementById('enquiry').value.trim();

            if (name === '' || email === '' || enquiry === '') {
                alert('Please fill all fields');
                return false;
            }

            // Email validation
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            return true;
        }

        document.getElementById('submit').addEventListener('click', function() {
            let name = document.getElementById('name').value.trim();
            let email = document.getElementById('email').value.trim();
            let enquiry = document.getElementById('enquiry').value.trim();

            if (name && email && enquiry) {
                // Create the message with proper newlines
                let message = `New Enquiry :\n\nName: ${name}\nEmail: ${email}\nEnquiry: ${enquiry}\n\n`;

                const storeNumber = "919790972432";
                const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

                const whatsappURL = isMobile ?
                    `https://wa.me/${storeNumber}?text=${encodeURIComponent(message)}` :
                    `https://web.whatsapp.com/send?phone=${storeNumber}&text=${encodeURIComponent(message)}`;

                window.open(whatsappURL, '_blank');
            }
        });
    </script>

    <?php
    include("./db.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPmailer/vendor/phpmailer/phpmailer/src/Exception.php';
    require './PHPmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require './PHPmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

    require './PHPmailer/vendor/autoload.php';

    // Process form submission
    if (isset($_POST['submit'])) {
        $mail = new PHPMailer(true);

        // Sanitize input data
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $enquiry = trim($_POST['enquiry']);

        // Validate all fields
        if (empty($name) || empty($email) || empty($enquiry)) {
            echo "<script>alert('Please fill all fields');</script>";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Please enter a valid email address');</script>";
        } else {
            try {
                $to = "srvnkmrmarimuthu@gmail.com";
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'srvnkmrmarimuthu@gmail.com';
                $mail->Password = 'nqdm ktju anvb zoqf';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('srvnkmrmarimuthu@gmail.com', 'Bharathi Surgicals');
                $mail->addAddress($to);
                $mail->addReplyTo($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'New Enquiry - Bharathi Surgicals';
                $mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>New Enquiry</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css' integrity='sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            text-align: center;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
            width: 100%;
        }
        
        .logo-container img {
            display: block;
            margin: 0 auto;
            max-width: 180px;
            height: auto;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .email-header {
            background: linear-gradient(135deg, #004aad, #0066cc);
            padding: 20px 15px;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .email-header p {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        .content-section {
            padding: 20px;
        }
        
        .user-details {
            background: white;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e8f0ff;
        }
        
        .user-details h3 {
            color: #004aad;
            margin-bottom: 15px;
            font-size: 1.1rem;
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 1px solid #e8f0ff;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9ff;
            border-radius: 6px;
            align-items: flex-start;
        }
        
        .detail-icon {
            color: #004aad;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
            font-size: 0.9rem;
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-weight: 600;
            color: #004aad;
            margin-bottom: 4px;
            font-size: 0.8rem;
        }
        
        .detail-value {
            color: #333;
            font-size: 0.85rem;
            line-height: 1.3;
        }
        
        .enquiry-box {
            background: #fff9e6;
            border: 1px solid #ffd43b;
            border-radius: 5px;
            padding: 10px;
            margin-top: 6px;
            font-size: 0.85rem;
            line-height: 1.4;
        }
        
        .email-footer {
            background: #f8f9ff;
            color: #666;
            text-align: center;
            padding: 15px;
            font-size: 0.8rem;
        }
        
        .footer-contact {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
        }
        
        @media (max-width: 600px) {
            .content-section {
                padding: 15px;
            }
            
            .footer-contact {
                flex-direction: column;
                gap: 8px;
            }
            
            .email-header h1 {
                font-size: 1.3rem;
            }
            
            .logo-container img {
                max-width: 160px;
            }
            
            .user-details h3 {
                font-size: 1rem;
            }
            
            .detail-item {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class='logo-container'>
        <a target='_blank' style='text-decoration: none; display: inline-block;' href='bharathi.co.in'>
            <img src='https://bharathi-surgicals-products.com.parasuramnurserygarden.com/assets/logo.jpeg' width='180' height='120' alt='Logo' title='Logo' style='color: #000000; font-size: 10px; border: 0; display: block;' />
        </a>
    </div>
    
    <div class='email-container'>
        <div class='email-header'>
            <h1>New Enquiry Received</h1>
            <p>Bharathi Surgicals</p>
        </div>
        
        <div class='content-section'>
            <div class='user-details'>
                <h3>Customer Information</h3>
                
                <div class='detail-item'>
                    <div class='detail-icon'><i class='fas fa-user'></i></div>
                    <div class='detail-content'>
                        <div class='detail-label'>FULL NAME</div>
                        <div class='detail-value'>$name</div>
                    </div>
                </div>
                
                <div class='detail-item'>
                    <div class='detail-icon'><i class='fas fa-envelope'></i></div>
                    <div class='detail-content'>
                        <div class='detail-label'>EMAIL ADDRESS</div>
                        <div class='detail-value'>$email</div>
                    </div>
                </div>
                
                <div class='detail-item'>
                    <div class='detail-icon'><i class='fas fa-comment'></i></div>
                    <div class='detail-content'>
                        <div class='detail-label'>ENQUIRY MESSAGE</div>
                        <div class='detail-value'>
                            <div class='enquiry-box'>
                                $enquiry
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>";

                $mail->send();
                echo "<script>alert('Thank you! Your enquiry has been sent successfully.');window.location.href='./index.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    }
    ?>
</body>

</html>