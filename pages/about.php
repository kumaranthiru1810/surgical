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
  <title>Bharathi Surgicals - About Us</title>
  <!-- Cache Control -->
  <meta
    http-equiv="Cache-Control"
    content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
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
  </style>
</head>

<body>
  <!-- Top Navigation -->
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
  <nav class="navbar navbar-expand-lg sticky-top position-sticky">
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

  <div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" data-aos="fade-down" data-aos-delay="100" class="mb-4 d-flex justify-content-center">
      <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item">
          <a href="../index.php" class="text-decoration-none text-secondary">Home</a>
        </li>
        <li class="breadcrumb-item active text-primary">About Us</li>
      </ol>
    </nav>

    <!-- Main Title -->
    <h1 class="about-title mt-5" data-aos="fade-up" data-aos-delay="200">
      About Us
    </h1>

    <!-- Subtitle Text -->
    <p class="about-text" data-aos="fade-up" data-aos-delay="300">
      Affordable for every hospital, clinic and medical practice<br />
      to have the very best equipment, supplies and service.
    </p>

    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
        <!-- Our Story Section -->
        <h1 class="subtitle">Our Story</h1>
        <p class="mb-4" style="text-align: justify; line-height: 32px;">
          Bharathi Surgicals was incorporated in Oct-2019 with a aim to
          provide Ethical Business in the field of Health Care in India and
          Abroad. We at Bharathi Surgicals strictly adhere to Corporate
          Governance. We are a manufacturer of Surgical Disposable Dressing
          Products such as Absorbent Gauze, Bandage Cloth, Grey Gauze Fabrics,
          Roller bandage, Starch Jumbo Roll, Triangular Bandage, Gauze Swabs,
          Mopping Pad/Abdominal Pad/Gauze Sponge/Laparotomy Sponge. We give
          utmost important to quality and deliverables on time. It is being
          managed by Educated experienced Professionals like Mrs. RenugaDevi R
          holding B.Sc Degree in Microbiology, She is Co-Founder, Chairman,
          Managing Director and Head of Production, very extensive experience
          in handling production and make deliverables on time. Mr.
          RajaRathinam R holding B.E Degree in Computer Science. He is
          Co-Founder, Managing Director, CFO and CEO having extensive
          experience in managing the company for Domestic and International.
          Mr. Amit Bagchi holding Master of Computer Application Degree, He is
          Chief Marketing Officer for India and Abroad, having extensive
          experience in Marketing and works smartly.  Dr. Ranathive S holding
          B.E and PhD in Computer Science. He is Marketing Manager for South
          India.
        </p>
      </div>
      <div class="col-lg-6 mt-5" data-aos="fade-up" data-aos-delay="500">
        <!-- Doctor Image -->
        <img
          src="../assets/about-us-doc-img.png"
          alt="Medical Professional"
          class="about-us-doc-img img-fluid h-75 p-3" />
      </div>
    </div>
  </div>

  <div class="container py-5 mt-5">
    <h1 class=" text-primary mb-4" data-aos="fade-up">Our Vision</h1>

    <div class="row">
      <?php
      // Vision data array - can be fetched from database in real scenario
      $visions = [
        [
          'number' => '01.',
          'title' => 'Customers First',
          'description' => 'We prioritize safety, reliability, and innovation, delivering solutions that empower healthcare professionals to provide exceptional care with confidence and precision.'
        ],
        [
          'number' => '02.',
          'title' => 'Move Intentionally Fast',
          'description' => 'We ensure timely service, empowering healthcare providers to stay focused on what truly matters—patient care and well-being.'
        ],
        [
          'number' => '03.',
          'title' => 'Think Big',
          'description' => 'Our mission is to deliver cutting-edge medical supplies that elevate patient outcomes and redefine possibilities in the medical field.'
        ]
      ];

      // Loop through vision items
      foreach ($visions as $vision) {
        echo '<div class="col-md-4">
                  <div class="vision-section text-center" data-aos="fade-up">
                    <div>
                      <div class="vision-number">' . $vision['number'] . '</div>
                      <h2 class="vision-title">' . $vision['title'] . '</h2>
                      <p style="text-align: justify;">' . $vision['description'] . '</p>
                    </div>
                  </div>
                </div>';
      }
      ?>
    </div>
  </div>

  <section class="cta-section">
    <div class="container">
      <div class="cta-container" data-aos="fade-up">
        <h1 class="cta-title">Lets talk together for Medical Supply!</h1>
        <a href="./contact-us.php" class="btn btn-primary contact-btn">
          Contact Us
          <span class="arrow-icon">→</span>
        </a>
      </div>
    </div>
  </section>


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
            <a href="#" id="footer-open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
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
  </script>
</body>

</html>