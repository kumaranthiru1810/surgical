<?php
session_start();
?>

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
            // Don't die, just return null so we can use fallback data
            error_log("Database connection failed: " . $e->getMessage());
            return null;
        }
    }

    return $pdo;
}

// Set page title and metadata
$pageTitle = "Bharathi Surgicals - Management";
$pageDescription = "Meet the team behind our commitment to excellence in medical supplies.";

// Fetch management team from database
$managementTeam = [];

try {
    $pdo = getDBConnection();
    if ($pdo) {
        $stmt = $pdo->query("SELECT * FROM management ORDER BY id");
        $managementTeam = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Add order pattern for alternating layout
        foreach ($managementTeam as $index => &$member) {
            $member['order'] = ($index % 2 == 0) ? 'image-first' : 'text-first';
        }
        unset($member);
    }
} catch (PDOException $e) {
    error_log("Error fetching management data: " . $e->getMessage());
}

// Fallback to hardcoded data if database is empty or fails
if (empty($managementTeam)) {
    $managementTeam = [
        [
            'name' => 'RenugaDevi R, B.Sc.,',
            'position' => 'Co-Founder, Chairman, Managing Director,<br>Head Of Production',
            'image' => '../assets/renugadevi.jpg',
            'order' => 'image-first'
        ],
        [
            'name' => 'RajaRathinam R, B.E.,',
            'position' => 'Co-Founder, Chairman, Managing Director, CFO<br>CEO',
            'image' => '../assets/rathinam.jpg',
            'order' => 'text-first'
        ],
        [
            'name' => 'Amit Bagchi, MCA.,',
            'position' => 'Chief Marketing Officer India<br>International',
            'image' => '../assets/amit.jpg',
            'order' => 'image-first'
        ],
        [
            'name' => 'Ranathive S, B., Ph.D.,',
            'position' => 'Marketing Manager, South India',
            'image' => '../assets/ranathive.jpg',
            'order' => 'text-first'
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
        .management-img {
            height: 340px;
            object-fit: cover;
            object-position: top;
            width: 100%;
        }

        .default-management-img {
            height: 300px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
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
    </style>
</head>

<body>
    <!-- Navigation -->
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
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="phone text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i><?php echo $data['phone']; ?>
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
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="phone1 text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i><?php echo $data['phone']; ?>
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
        <nav
            aria-label="breadcrumb"
            data-aos="fade-down"
            data-aos-delay="100"
            class="mb-4 d-flex justify-content-center">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item">
                    <a href="../index.php" class="text-decoration-none text-secondary">Home</a>
                </li>
                <li class="breadcrumb-item active text-primary">Management</li>
            </ol>
        </nav>

        <!-- Main Title -->
        <h1 class="about-title mt-5" data-aos="fade-up" data-aos-delay="200">
            Management
        </h1>

        <!-- Subtitle Text -->
        <p class="about-text" data-aos="fade-up" data-aos-delay="300">
            <?php echo $pageDescription; ?>
        </p>
    </div>

    <section class="py-5">
        <?php
        // Loop through management team members
        $delay = 200;
        foreach ($managementTeam as $index => $member) {
            $delay += 100;
            $aosDelay = $delay;

            // Handle image path - check if it's from database or fallback data
            $imagePath = '';
            if (!empty($member['image'])) {
                // If image path doesn't start with "../" and doesn't contain "assets", it's from database
                if (strpos($member['image'], '../') === false && strpos($member['image'], 'assets') === false) {
                    $imagePath = '../' . $member['image'];
                } else {
                    $imagePath = $member['image'];
                }
            }

            if ($member['order'] == 'image-first') {
                echo '<div class="container mt-5" data-aos="fade-up" data-aos-delay="' . $aosDelay . '">
                      <div class="row align-items-center">
                          <div class="col-md-4 mb-4 mb-md-0">
                              <!-- Image container with proper display -->
                              <div class="management-image-container rounded-4">';

                // Display management image or placeholder
                if (!empty($imagePath)) {
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($member['name']) . '" class="img-fluid rounded-4 management-img">';
                } else {

                    echo '<div class="default-management-img d-flex align-items-center justify-content-center rounded-4" style="height: 350px;">
                          <i class="bi bi-person" style="font-size: 4rem;"></i>
                        </div>';
                }

                echo '</div>
                          </div>
                          
                          <div class="col-md-6">
                              <!-- White background card with subtle shadow -->
                              <div class="bg-white rounded-4 p-4 management-name-card">
                                  <!-- Name with blue color matching the design -->
                                  <h3 class="text-primary mb-2" style="color: #007bff !important;">
                                      ' . htmlspecialchars($member['name']) . '
                                  </h3>
                                  
                                  <!-- Position text with proper line height and size -->
                                  <h4 class="fs-4 fw-normal" style="line-height: 1.4;">
                                      ' . $member['position'] . '
                                  </h4>
                              </div>
                          </div>
                      </div>
                  </div>';
            } else {
                echo '<div class="container mt-5" data-aos="fade-up" data-aos-delay="' . $aosDelay . '">
                      <div class="row align-items-center">
                          <!-- Text Content (Left Side) -->
                          <div class="col-md-6">
                              <!-- White background card with subtle shadow -->
                              <div class="bg-white rounded-4 p-4 management-name-card">
                                  <!-- Name with blue color matching the design -->
                                  <h3 class="text-primary mb-2" style="color: #007bff !important;">
                                      ' . htmlspecialchars($member['name']) . '
                                  </h3>
                                  
                                  <!-- Position text with proper line height and size -->
                                  <h4 class="fs-4 fw-normal" style="line-height: 1.4;">
                                      ' . $member['position'] . '
                                  </h4>
                              </div>
                          </div>
                  
                          <!-- Image container (Right Side) -->
                          <div class="col-md-4 mb-4 mb-md-0">
                              <div class="management-image-container rounded-4">';

                // Display management image or placeholder
                if (!empty($imagePath)) {
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($member['name']) . '" class="img-fluid rounded-4 management-img">';
                } else {
                    echo '<div class="default-management-img d-flex align-items-center justify-content-center rounded-4">
                          <i class="bi bi-person" style="font-size: 3rem;"></i>
                        </div>';
                }

                echo '</div>
                          </div>
                      </div>
                  </div>';
            }
        }
        ?>
    </section>


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
                                <i class="bi bi-envelope-fill"></i> </i> <?php echo $data['email']; ?>
                            </a>
                        </div>

                        <div>
                            <a href="https://www.google.com/maps/search/Rajapalayam,+Tamil+Nadu,+India" target="_blank" class="text-decoration-none text-dark">
                                <i class="bi bi-geo-alt-fill"></i> </i> <?php echo $data['address']; ?>
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
        document.getElementById('footer-open-chat').addEventListener('click', function() {
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
        document.getElementById('nav-open-chat').addEventListener('click', function() {
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
            mirror: true /* Re-trigger on scroll up */ ,
        });
    </script>
</body>

</html>