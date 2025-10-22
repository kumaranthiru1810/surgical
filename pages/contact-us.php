<?php
session_start();
?>

<?php include('../db.php');
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
if ($sql->rowCount() > 0) {
  $data = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include('./db.store.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - Bharathi Surgicals</title>
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

    #map {
      height: 600px;
      width: 550px;
      border-radius: 20px;
    }

    @media(max-width:768px) {
      #map {
        width: 700px;
      }
    }

    @media(max-width:425px) {
      #map {
        width: 400px;
      }
    }

    @media(max-width:375px) {
      #map {
        width: 350px;
      }
    }

    @media(max-width:320px) {
      #map {
        width: 300px;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
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
              <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $data['phone']); ?>" class="phone1 text-decoration-none text-dark">
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

  <!-- Breadcrumb -->
  <nav
    aria-label="breadcrumb"
    data-aos="fade-up"
    data-aos-delay="100"
    class="mb-4 d-flex justify-content-center">
    <ol class="breadcrumb mt-4">
      <li class="breadcrumb-item">
        <a href="../index.php" class="text-decoration-none text-secondary">Home</a>
      </li>
      <li class="breadcrumb-item active text-primary">Contact Us</li>
    </ol>
  </nav>

  <!-- Main Title -->
  <h1 class="about-title mt-5" data-aos="fade-up" data-aos-delay="200">
    Contact Us
  </h1>

  <div class="my-5">
    <!-- Location Section -->
    <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="200">
      <img src="../assets/our-location.png" alt="" />
      <h2 class="mt-3 our-location">Our Location</h2>
    </div>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "surgical");
    $sql = mysqli_query($conn, "SELECT * FROM contact_page_details");

    ?>
    <div class="container-fluid">
      <div class="row justify-content-center g-4">
        <?php if ($sql) {
          while ($res = mysqli_fetch_assoc($sql)) {
            if ($res['headoffice'] != "" && $res['branchoffice'] != "") {
        ?>
              <div class="col-md-5" data-aos="fade-up" data-aos-delay="0">
                <div class="card text-center h-100 location-card">
                  <div class="card-body">
                    <h4 class="card-title mb-4">Head Office</h4>
                    <p class="card-text">
                      <?= htmlspecialchars($res['headoffice']) ?>
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center h-100 location-card">
                  <div class="card-body">
                    <h4 class="card-title mb-4">Branch Office</h4>
                    <p class="card-text">
                      <?= htmlspecialchars($res['branchoffice']) ?>
                    </p>
                  </div>
                </div>
              </div>
          <?php
            }
          }
        } else {
          ?>

          <!-- Fallback locations if database is empty -->
          <div class="col-md-4" data-aos="fade-up">
            <div class="card text-center h-100 location-card">
              <div class="card-body">
                <h4 class="card-title mb-4">Head Office</h4>
                <p class="card-text">
                  Bharathi Surgicals<br />
                  151/9 New Street,<br />
                  Chatrapatti - 626 102.<br />
                  Via Rajapalayam,<br />
                  Virudhunagar Dist.<br />
                  Tamil Nadu, India.
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card text-center h-100 location-card">
              <div class="card-body">
                <h4 class="card-title mb-4">Branch Office</h4>
                <p class="card-text">
                  Bharathi Surgicals,<br />
                  House No 145, Lane No. 6,<br />
                  Gitanjali City Phase # 1,<br />
                  Bhatauri Road,<br />
                  Bilaspur - 495 006.<br />
                  Chhattisgarh, India.
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card text-center h-100 location-card-3">
              <div class="card-body">
                <h4 class="card-title mb-4">Branch Office</h4>
                <p class="card-text">
                  Bharathi Surgicals,<br />
                  S. Thiruvalluvar Street,<br />
                  Kattankudathur,<br />
                  Chengalput - 603203.<br />
                  Tamil Nadu, India.
                </p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <?php $sql = mysqli_query($conn, "SELECT * FROM contact_page_details");
    $res = mysqli_fetch_assoc($sql);
    ?>
    <div class="py-4 mt-6" data-aos="fade-up" data-aos-delay="200">
      <div class="row justify-content-evenly text-center g-2">
        <!-- Contact Number -->
        <div class="col-md-6">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3">
              <img src="../assets/contact-no.png" alt="Phone icon" />
            </div>
            <h5 class="mb-2">Contact Number</h5>
            <p class="text-muted"><?php echo htmlspecialchars($res['phone']); ?></p>
          </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3">
              <img src="../assets/emailus.png" alt="Email icon" />
            </div>
            <h5 class="mb-2">Email us</h5>
            <p class="text-muted"><?php echo htmlspecialchars($res['email']); ?></p>
          </div>
        </div>
      </div>

    </div>

    <section class="py-5 mt-5" data-aos="fade-up" data-aos-delay="200">
      <h2 class="text-center mb-5 fw-bold">For Any Enquiries</h2>

      <div class="container">
        <div class="row justify-content-center gx-4 gy-4">
          <div class="col-lg-6 col-sm-12">
            <!--<?php if ($form_submitted): ?>-->
            <!--  <div class="alert alert-success" role="alert">-->
            <!--    Thank you for your message! We'll get back to you soon.-->
            <!--  </div>-->
            <!--<?php elseif (!empty($form_errors['database'])): ?>-->
            <!--  <div class="alert alert-danger" role="alert">-->
            <!--    <?php echo $form_errors['database']; ?>-->
            <!--  </div>-->
            <!--<?php endif; ?>-->

            <form method="POST" action="db.store.php" id="myForm" novalidate>
              <div class="row mb-4">
                <!-- Full Name -->
                <div class="col-md-12 mb-4 mb-md-0">
                  <div class="form-group">
                    <label for="fullName" class="mb-2">Your Full Name</label>
                    <input
                      type="text"
                      class="form-control bg-light <?php echo !empty($form_errors['name']) ? 'is-invalid' : ''; ?>"
                      id="fullName"
                      name="name"
                      value="<?php echo htmlspecialchars($form_data['name']); ?>"
                      required />
                    <?php if (!empty($form_errors['name'])): ?>
                      <div class="invalid-feedback"><?php echo $form_errors['name']; ?></div>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Email -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="mb-2">Your Email ID</label>
                    <input
                      type="email"
                      class="form-control bg-light <?php echo !empty($form_errors['email']) ? 'is-invalid' : ''; ?>"
                      id="email"
                      name="email"
                      value="<?php echo htmlspecialchars($form_data['email']); ?>"
                      required />
                    <?php if (!empty($form_errors['email'])): ?>
                      <div class="invalid-feedback"><?php echo $form_errors['email']; ?></div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Subject -->
              <div class="form-group mb-4">
                <label for="subject" class="mb-2">Your Subject</label>
                <input
                  type="text"
                  class="form-control bg-light <?php echo !empty($form_errors['subject']) ? 'is-invalid' : ''; ?>"
                  id="subject"
                  name="subject"
                  value="<?php echo htmlspecialchars($form_data['subject']); ?>"
                  required />
                <?php if (!empty($form_errors['subject'])): ?>
                  <div class="invalid-feedback"><?php echo $form_errors['subject']; ?></div>
                <?php endif; ?>
              </div>

              <!-- Message -->
              <div class="form-group mb-4">
                <label for="message" class="mb-2">Your Message</label>
                <textarea
                  class="form-control bg-light <?php echo !empty($form_errors['message']) ? 'is-invalid' : ''; ?>"
                  id="message"
                  name="message"
                  rows="8"
                  required><?php echo htmlspecialchars($form_data['message']); ?></textarea>
                <?php if (!empty($form_errors['message'])): ?>
                  <div class="invalid-feedback"><?php echo $form_errors['message']; ?></div>
                <?php endif; ?>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                id="submitBtn"
                class="btn btn-primary px-4 py-2"
                style="
                background-color: #007bff;
                border: none;
                border-radius: 4px;
              "
                onclick="submit()">
                Submit
              </button>
            </form>
          </div>
          <div class="col-lg-6 col-sm-12 mt-3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7872.096228519837!2d77.60024834999999!3d9.41718005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b06c229335998f9%3A0xeb196eeb104eb3ea!2sChatrapatti%2C%20Tamil%20Nadu%20626102!5e0!3m2!1sen!2sin!4v1759667438965!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" id="map"></iframe>
          </div>
        </div>
      </div>
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

    <!-- <script>
    document.getElementById('nav-open-chat').addEventListener('onclick', function() {
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
  </script> -->


    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <script>
      // Initialize AOS
      AOS.init({
        duration: 1000,
        once: true,
        mirror: true /* Re-trigger on scroll up */ ,
      });
    </script>

    <script>
      const form = document.querySelector("form");
      const inputs = form.querySelectorAll("input, textarea");
      const submitBtn = document.getElementById("submitBtn");
      var pattern = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
      var email = document.getElementById('email').value;

      function validateInput(input) {
        if (input.validity.valueMissing) {
          input.classList.add("is-invalid");
          return false;
        }
        if (input.type === "email" && !pattern.test(input.value.trim())) {
          console.log(input.value); // log the actual email entered
          input.classList.add("is-invalid");
          return false;
        } else {
          input.classList.remove("is-invalid");
          return true;
        }
      }

      function checkForm() {
        let allValid = true;
        inputs.forEach((input) => {
          if (!validateInput(input)) {
            allValid = false;
          }
        });
        submitBtn.disabled = !allValid;
      }

      // Run check on input/blur
      inputs.forEach((input) => {
        input.addEventListener("input", checkForm);
        input.addEventListener("blur", () => validateInput(input));
      });

      // Initial check
      checkForm();

      // Prevent invalid submit
      form.addEventListener("submit", function(e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          checkForm();
          alert("❌ Please fix errors before submitting.");
        }
      });
    </script>


</body>

</html>

</html>