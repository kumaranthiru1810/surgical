<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bharathi Surgicals</title>
    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css for animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- css -->
    <link rel="stylesheet" href="index.css">
    <style>
        @media (max-width: 991px) {
            .offcanvas {
                background-color: blue !important;
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
    <nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-info text-start">
                        <div>
                            <a href="mailto:<?php echo $contact_info['email']; ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope-fill"></i> <?php echo $contact_info['email']; ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="social-icons text-center">
                        <a href="<?php echo $social_links['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="<?php echo $social_links['instagram']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                        <a href="<?php echo $social_links['whatsapp']; ?>" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="contact-info text-end">
                        <div>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $contact_info['phone']); ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> <?php echo $contact_info['phone']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>



    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="d-flex align-items-center">
                    <img src="./assets/logo.png" alt="<?php echo $company_name; ?> Logo" class="me-2">
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
                        <a class="nav-link" href="./pages/Products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/Management.php">Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/contact-us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container navbar-g">
        <img src="./assets/nav-gradient-bg.png" alt="" class="img-fluid">
    </div>

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
                        <img src="./assets/logo.png" alt="<?php echo $company_name; ?> Logo" class="me-2">
                    </div>
                    <div class="opening-time">
                        <h5>Opening Time</h5>
                        <p>9.00 AM - 6.00 PM<br>(Monday - Sunday)</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="social-icons text-center">
                        <a href="<?php echo $social_links['facebook']; ?>" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="<?php echo $social_links['instagram']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                        <a href="<?php echo $social_links['whatsapp']; ?>" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-info">
                        <div>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $contact_info['phone']); ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> <?php echo $contact_info['phone']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="mailto:<?php echo $contact_info['email']; ?>" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope-fill"></i> <?php echo $contact_info['email']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="https://www.google.com/maps/search/<?php echo urlencode($contact_info['address']); ?>" target="_blank" class="text-decoration-none text-dark">
                                <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_info['address']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-4">
                        <p>Developed by <a href="#" style="color: #007BFF; text-decoration: none;">Anjana Infotech</a></p>
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
                <li><a href="./forms/get_a_qoute.html">Get Quote</a></li>
                <li><a href="./forms/request_sample.html">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./forms/raise_of_complaint.html">Raise a Complaint</a></li>
                <li><a href="./forms/suggestions.html">Suggestions</a></li>
                <li><a href="#chat" id="open-chat">Chat with us</a></li>
            </ul>
        </div>
    </div>

    <div id="chatbot-box" class="hidden">
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
    </div>


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