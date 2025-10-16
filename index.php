<?php session_start(); ?>
<?php include('./db.php');
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
    <title><?php echo $data['title']; ?></title>
    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
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
    <link rel="stylesheet" href="./index.css" />

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

        


        /* Flash Message Styles */

        #flash-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            /* hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Message box */
        #flash-box {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease;
        }

        #flash-box h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        #flash-box p {
            color: #444;
            line-height: 1.6;
            font-size: 15px;
        }

        #flash-ok {
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        #flash-ok:hover {
            background-color: #2980b9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 991px) {
            .offcanvas {
                background-color: blue !important;
            }
        }
    </style>
</head>

<body>

    <!-- Flash Message at starting -->

    <div id="flash-overlay">
        <div id="flash-box">
            <p>
                5% of our profit will be transferred to <b>SELVI MANI FOUNDATION</b>,
                a NGO non-profit foundation which will primarily focus on educating our Talented Poor Indian children.
                <br><br>
                We thank you so much for indirectly contributing, by placing order with our firm.
                <br><br>
                We appreciate your decision.
            </p>
            <h2>Thank You so Much!!!</h2>
            <button id="flash-ok">OK</button>
        </div>
    </div>


    <!-- Main Code -->

    <?php

    $social_links = [
        'whatsapp' => '#'
    ];

    // Get current year dynamically
    $current_year = date('Y');
    ?>
    <!-- Top Navigation -->
    <nav class="respon2">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                    <div class="contact-info text-start">
                        <a href="mailto:<?php echo $data['email']; ?>" class="phone text-decoration-none text-dark">
                            <i class="bi bi-envelope-fill"></i> <?php echo $data['email']; ?>
                        </a>
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
                        <a href="#" id="open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-4 mt-2 col-sm-4 col-xs-6">
                    <div class="contact-info text-end">
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="phone text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> <?php echo $data['phone']; ?>
                        </a>
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
                        <a href="#" id="open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-4 col-lg-4 mt-2 col-sm-3 col-xs-3">
                    <div class="contact-info text-start">
                        <a href="mailto:<?php echo $data['email']; ?>" class="phone1 text-decoration-none text-dark">
                            <i class="bi bi-envelope-fill"></i> <?php echo $data['email']; ?>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mt-2 col-sm-3 col-xs-3">
                    <div class="contact-info text-end">
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="phone1 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> <?php echo $data['phone']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>





    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top position-sticky">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="d-flex align-items-center">
                    <img src="./assets/logo.jpeg" alt="<?php echo $company_name; ?> Logo" class="me-2">
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/management.php">Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/contact-us.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a class="btn btn-primary me-3">HI, <?php echo $_SESSION['name']; ?></a>
                        <?php } else { ?>
                            <a href="./pages/signup.php" class="btn btn-primary me-3">Sign Up</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a href="./pages/logout.php" class="btn btn-primary me-3"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                        <?php } else { ?>
                            <a href="./pages/signin.php" class="btn btn-primary me-3">Sign In</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="hero-section pt-5">
        <div class="container">
            <div class="row h-100 align-items-center flex-column">
                <div class="col-lg-6 content-wrapper_btns" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="hero-title text-center">Quality Surgical Products<br>You Can Trust</h1>
                    <div class="buttons mt-4 text-center">
                        <a href="./pages/Products.php" class="btn btn-primary me-3">Our Products</a>
                        <a href="./pages/contact-us.php" class="btn-outline">Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-6 content-wrapper mt-5">
                    <div data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="1000">
                        <img src="./assets/hero-img.png" alt="Medical Professional" class="doctor-img">
                    </div>
                    <div class="bg-gradient">
                        <img src="./assets/Property 1=Frame 46.png" alt="" class="back_sideof_doc" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="0">
                    </div>
                    <div class="bg-round">
                        <img src="./assets/Property 1=Frame 42.png" alt="" class="back_sideof_doc img-fluid" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="400">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-section">
        <div class="container">
            <!-- <div class="section-title">
                <h1 data-aos="zoom-in-up" data-aos-delay="100">Our Featured <span>Products</span></h1>
                <p class="section-subtitle mt-4" data-aos="zoom-in-up" data-aos-delay="200">Experience the pinnacle of quality with our featured surgical products trusted by professionals for accuracy and dependability.</p>
            </div> -->

            <!-- <div class="row">
                <?php foreach ($featured_products as $index => $product): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 200; ?>">
                    <div class="product-card">
                        <img src="<?php echo $product['image']; ?>" alt="Surgical Product" class="product-image">
                        <div class="product-specs">
                            <div class="spec-item">
                                <span class="label">TPI</span> <span class="colon">:</span> <span class="value"><?php echo $product['tpi']; ?></span>
                            </div>
                            <div class="spec-item">
                                <span class="label">Width</span> <span class="colon">:</span> <span class="value"><?php echo $product['width']; ?></span>
                            </div>
                            <div class="spec-item">
                                <span class="label">Length</span> <span class="colon">:</span> <span class="value"><?php echo $product['length']; ?></span>
                            </div>
                            <div class="spec-item">
                                <span class="label">Sterility</span> <span class="colon">:</span>  <span class="value"><?php echo $product['sterility']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div> -->

            <div class="view-more-btn" data-aos="fade-up" data-aos-delay="200">
                <a href="./pages/Products.php" class="btn btn-primary">View more Products →</a>
            </div>
        </div>
    </section>

    <section class="why-choose-section py-5">
        <div class="container text-center">
            <div class="title-section mb-5">
                <h1 data-aos="zoom-in-up" data-aos-delay="100">Why Choose <span>Us</span></h1>
            </div>

            <div class="image-container" data-aos="zoom-in">
                <img src="./assets/Frame 45 (1).png" alt="Why Choose Us" class="img-fluid">
            </div>
        </div>
    </section>

    <section class="testimonial-section position-relative">
        <div class="container">
            <div class="section-title">
                <h1 data-aos="zoom-in-up">Loved by Over <span>Thousand People</span></h1>
                <p class="section-subtitle" data-aos="zoom-in-up" data-aos-delay="100">
                    Real stories from professionals who trust our products, experiencing the impact of quality and precision in every procedure we support.
                </p>
            </div>

            <!-- Swiper Slider Container -->
            <!-- <div class="swiper-container">
                <div class="swiper-wrapper" id="testimonial-container">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="swiper-slide">
                        <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100"> -->
            <!-- <div class="testimonial-top">
                                <div class="stars"><?php echo str_repeat('★', $testimonial['rating']) . str_repeat('☆', 5 - $testimonial['rating']); ?></div>
                                <p class="testimonial-text">
                                    <?php echo $testimonial['text']; ?>
                                </p>
                            </div>  -->
            <!-- <div class="testimonial-author">
                                <img src="<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>" class="author-image">
                                <div class="author-info">
                                    <h4><?php echo $testimonial['name']; ?></h4>
                                   
                                    <p><?php echo $testimonial['position']; ?></p>
                                    
                                </div>

                               
                            </div> -->
            <!-- </div>
                    </div>
                    <?php endforeach; ?>
                </div> -->
        </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-container" data-aos="fade-up">
                <h1 class="cta-title">Lets talk together for Medical Supply!</h1>
                <a href="./pages/contact-us.php" class="btn btn-primary contact-btn">
                    Contact Us
                    <span class="arrow-icon">→</span>
                </a>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-logo d-flex align-items-center mb-3">
                        <img src="./assets/logo.jpeg" alt="<?php echo $company_name; ?> Logo" class="me-2">
                    </div>
                    <div class="opening-time">
                        <?php echo $data['opening_time']; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="social-icons text-center">
                        <a href="<?php echo $data1['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                        <a href="<?php echo $social_links['whatsapp']; ?>" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-info">
                        <div>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> <?php echo $data['phone']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="mailto:<?php echo $data['email']; ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope-fill"></i> <?php echo $data['email']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="https://www.google.com/maps/search/<?php echo urlencode($data['address']); ?>" target="_blank" class="text-decoration-none text-dark">
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
                        <p>© <?php echo $current_year; ?> All Rights Reserved.</p>
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
                <li><a href="./forms/get_a_qoute.php">Get Quote</a></li>
                <li><a href="./forms/request_sample.php ">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./forms/raise_of_complaint.php">Raise a Complaint</a></li>
                <li><a href="./forms/suggestions.php">Suggestions</a></li>
                <li><a href="#chat" id="open-chat">Chat with us</a></li>
            </ul>
        </div>
    </div>

    <!-- <div id="chatbot-box" class="hidden">
        <div id="chatbot-header">
            <span>Chatbot</span>
            <button id="chatbot-close" class="close-btn" aria-label="Close Chatbot">
                <i class="bi bi-x-circle"></i>
            </button>
        </div>
        <div id="chatbot-content">
            <p>Hi! How can I help you today?</p>
        </div>
        <input type="text" id="chatbot-input" placeholder="Type your message...">
        <button id="chatbot-send">Send</button>
    </div> -->
    <script>
        document.getElementById('open-chat').addEventListener('click', function() {
            let message = `How can i help You? %0A%0A`;

            const storeNumber = "918489089784"; // Your WhatsApp number
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


        window.onload = function() {
            // Show only if not shown before in this browser session
            if (!sessionStorage.getItem("flashShown")) {
                document.getElementById("flash-overlay").style.display = "flex";
                sessionStorage.setItem("flashShown", "true");
            }

            document.getElementById("flash-ok").onclick = function() {
                document.getElementById("flash-overlay").style.display = "none";
            };
        };
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