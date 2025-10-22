<?php session_start(); ?>


<?php include('../db.php');
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
if ($sql->rowCount() > 0) {
    $data = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
// Database configuration
$db_config = [
    'host' => 'localhost',
    'dbname' => 'surgical',
    'username' => 'root',
    'password' => ''
];

// Function to get database connection
function getDBConnection()
{
    global $db_config;
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host={$db_config['host']};dbname={$db_config['dbname']}",
                $db_config['username'],
                $db_config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}

// Set page title and metadata
$pageTitle = "Bharathi Surgicals - Products";
$pageDescription = "Explore our range of high-quality medical products including Absorbent Gauze and Roller Bandage.";

// Fetch products from database
$productCategories = [];

try {
    $pdo = getDBConnection();

    // Get all distinct categories
    $stmt = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category");
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Get products for each category
    foreach ($categories as $category) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY name");
        $stmt->execute([$category]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productCategories[$category] = $products;
    }
} catch (PDOException $e) {
    // Fallback to hardcoded data if database fails
    $productCategories = [
        "Absorbent Gauze" => [
            [
                'name' => 'Gauze Bandage Cloth',
                'image' => '../assets/Gauze_Bandage_Cloth.jpg',
                'description' => 'High-quality gauze bandage cloth for medical use.',
            ],
            [
                'name' => 'Absorbent Gauze Sponge',
                'image' => '../assets/Absorbent_Gauze_Sponge.jpg',
                'description' => 'Highly absorbent gauze sponges for wound care.',
            ]
        ],
        "Roller Bandage" => [
            [
                'name' => 'Cotton Roller Bandage',
                'image' => '../assets/Cotton_Roller_Bandage.jpg',
                'description' => 'Soft cotton roller bandage for comfortable support.',
            ],
            [
                'name' => 'Elastic Roller Bandage',
                'image' => '../assets/gaus.jpeg',
                'description' => 'Elastic roller bandage for compression and support.',
            ]
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
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

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .specs-list {
            list-style-type: none;
            padding-left: 0;
        }

        .specs-list li {
            padding: 2px 0;
            position: relative;
            padding-left: 15px;
        }

        .specs-list li:before {
            content: "•";
            color: #007bff;
            position: absolute;
            left: 0;
        }

        .default-product-img {
            height: 200px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .product-image {
            height: 350px;
            object-fit: cover;
            /* object-position:center; */
            border-radius: 20px;
            width: 40vw;
        }

        .key-title {
            font-size: 24px;
            font-weight: 600;
            color: #007bff;
            margin-top: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

    <div style="position: sticky; top:0; z-index:9999; background-color:white;">
        <!-- Navigation -->
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
                                <a href="#" id="top-whatsapp" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-whatssapp"></i><?php echo $data['phone']; ?>
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
                        <a class="nav-link" href="./about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./Products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./Management.php">Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../forms/request_sample.php">Place Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact-us.php">Contact Us</a>
                    </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a class="btn btn-primary me-3">HI, <?php echo $_SESSION['name']; ?></a>
                            <?php } else { ?>
                                <a href="./signup.php" class="btn btn-primary me-3">Sign Up</a>
                            <?php } ?>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['name'])) { ?>
                                <a href="./logout.php" class="btn btn-primary me-3">Logout</a>
                            <?php } else { ?>
                                <a href="./signin.php" class="btn btn-primary me-3">Sign In</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" data-aos="fade-down" data-aos-delay="100" class="mb-4 d-flex justify-content-center">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item">
                    <a href="../index.php" class="text-decoration-none text-secondary">Home</a>
                </li>
                <li class="breadcrumb-item active text-primary">Products</li>
            </ol>
        </nav>

        <!-- Main Title -->
        <h1 class="about-title mt-5" data-aos="fade-up" data-aos-delay="200">
            Products
        </h1>
    </div>

    <?php
    // Loop through product categories
    $categoryDelay = 100;
    foreach ($productCategories as $categoryName => $products) {
        $categoryDelay += 50;
        echo '<!-- ' . $categoryName . ' -->
        <div class="container py-5">
            <h1 class="text-primary mb-4" data-aos="fade-up" data-aos-delay="' . $categoryDelay . '">' . $categoryName . '</h1>
            <div class="row g-7">';

        // Check if category has products
        if (count($products) > 0) {
            // Loop through products in this category
            $productDelay = $categoryDelay;
            foreach ($products as $product) {
                $productDelay += 50;

                // Handle image path - check if it's from database or fallback data
                $imagePath = '';
                if (!empty($product['image'])) {
                    // If image path doesn't start with "../" and doesn't contain "assets", it's from database
                    if (strpos($product['image'], '../') === false && strpos($product['image'], 'assets') === false) {
                        $imagePath = '../' . $product['image'];
                    } else {
                        $imagePath = $product['image'];
                    }
                }

                echo '<div class="col-md-6 col-lg-6 mt-5" data-aos="fade-up" data-aos-delay="' . $productDelay . '">
                        <div class="card product-card h-100">';

                // Display product image or placeholder
                if (!empty($imagePath)) {
                    echo '<a href="product-details.php?id=' . htmlspecialchars($product['id']) . '">
                            <img src="' . $imagePath . '" class="product-image" alt="' . htmlspecialchars($product['name']) . '">
                          </a>  
                          ';
                } else {
                    echo '<div class="default-product-img">
                            <i class="bi bi-image" style="font-size: 3rem;"></i>
                          </div>';
                }


                echo '<div class="card-body">
                        <a href="product-details.php?id=' . htmlspecialchars($product['id']) . '" style="text-decoration:none;">
                            <h5 class="key-title">' . htmlspecialchars($product['name']) . '</h5>
                        </a>
                        <p class="card-text">' . htmlspecialchars($product['description']) . '</p>
                        <div class="features-box">
                            <div class="key-title">
                                <i class="fas fa-list-check"></i> Key Features
                            </div>
                            <ul class="check-list">';
                                $features = explode("\n", $product['key_characteristics']);
                                foreach ($features as $line) {
                                    if (trim($line)) {
                                        echo '<li>' . htmlspecialchars(trim($line)) . '</li>';
                                    }
                                }
                echo '      </ul>
                        </div>';
                        if($product['uses']!=NULL){
                    echo '<div class="uses-box">
                            <div class="key-title">
                                <i class="fas fa-stethoscope"></i> Uses
                            </div>
                            <ul class="check-list">';
                                $uses = explode("\n", htmlspecialchars($product['uses']));
                                foreach ($uses as $line) {
                                    if (trim($line)) {
                                        echo "<li>" . trim($line) . "</li>";
                                    }
                                }
                echo '      </ul>
                        </div>';
                            }
                            



                // Display price if available
                // if (!empty($product['price'])) {
                //     echo '<p class="card-text"><strong>Price: ₹' . number_format($product['price'], 2) . '</strong></p>';
                // }

                // Display stock status if available
                // if (!empty($product['stock'])) {
                //     $stockClass = $product['stock'] > 10 ? 'text-success' : ($product['stock'] > 0 ? 'text-warning' : 'text-danger');
                //     $stockText = $product['stock'] > 0 ? 'In Stock (' . $product['stock'] . ')' : 'Out of Stock';
                //     echo '<p class="card-text ' . $stockClass . '"><strong>' . $stockText . '</strong></p>';
                // }

                echo '</div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="../forms/get_a_qoute.php" class="btn btn-outline-primary w-100 inquire-btn" data-product="' . htmlspecialchars($product['name']) . '">Get Quote</a>
                            </div>
                      </div>
                    </div>';
            }
        } else {
            echo '<div class="col-12 text-center">
                    <p class="text-muted">No products available in this category yet.</p>
                  </div>';
        }

        echo '</div>
        </div>';
    }
    ?>

    <!-- Inquiry Modal -->
    <!-- <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="inquiryModalLabel">Product Inquiry</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method='POST' id="inquiryForm">
              <input type="hidden" id="productName" name="productName">
              <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number </label>
                <input type="tel" class="form-control" id="phone" name="phone">
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
              </div>
              <div class="mb-3">
                <label for="quantity" class="form-label">Estimated Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submitInquiry">Submit Inquiry</button>
          </div>
        </div>
      </div>
    </div> -->

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
                            <a href="tel:+91-97909 72432" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> <?php echo $data['phone']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="mailto:cs@bharathi.co.in" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope-fill"></i> <?php echo $data['email']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="https://www.google.com/maps/search/Rajapalayam,+Tamil+Nadu,+India" target="_blank" class="text-decoration-none text-dark">
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
            <li><a href="../forms/request_sample.php">Place Orders</a></li>
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
        document.getElementById('open-chat').addEventListener('click', function() {
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
        document.getElementById('footer-open-chat').addEventListener('click', function() {
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
        document.getElementById('nav-open-chat').addEventListener('click', function() {
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

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="../index.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            mirror: true,
            /* Re-trigger on scroll up */
        });

        // Product inquiry functionality
        document.querySelectorAll('.inquire-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productName = this.getAttribute('data-product');
                document.getElementById('productName').value = productName;
                document.getElementById('message').value = `I'm interested in ${productName}. Please provide more information.`;

                const inquiryModal = new bootstrap.Modal(document.getElementById('inquiryModal'));
                inquiryModal.show();
            });
        });

        // Form submission handling
        document.getElementById('submitInquiry').addEventListener('click', function() {
            const form = document.getElementById('inquiryForm');
            const formData = new FormData(form);

            fetch('./products.email.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json' // Tell server we expect JSON
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("Thank you for your inquiry! We will contact you soon.");
                        window.location.href = './Products.php';

                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('inquiryModal'));
                        modal.hide();

                        // Reset form
                        form.reset();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Something went wrong. Please try again.");
                });
        });


        // Form submission handling
        document.getElementById('submitInquiry').addEventListener('click', function() {
            const formData = {
                productName: document.getElementById('productName').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                message: document.getElementById('message').value,
                quantity: document.getElementById('quantity').value
            };

            // Here you would typically send this data to your server
            console.log('Inquiry submitted:', formData);

            // Show success message
            // alert('Thank you for your inquiry! We will contact you soon.');window.location.href='./products.email.php';

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('inquiryModal'));
            modal.hide();

            // Reset form
            document.getElementById('inquiryForm').reset();
        });
    </script>
</body>

</html>