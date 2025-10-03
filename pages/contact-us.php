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
      content="no-cache, no-store, must-revalidate"
    />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Animate.css for animations -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
      rel="stylesheet"
    />
    <!-- AOS CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
      rel="stylesheet"
    />
    <!-- css -->
    <link rel="stylesheet" href="../index.css" />
  </head>
  <body>
    <!-- Navigation -->
    <nav
      class="navbar navbar-expand-lg navbar-light bg-transparent animate-navbar"
    >
      <div class="container">
        <a class="navbar-brand" href="#">
          <div class="d-flex align-items-center">
            <img
              src="../assets/logo.png"
              alt="Bharathi Surgicals Logo"
              class="me-2"
            />
          </div>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
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
              <a class="nav-link active" href="./contact-us.php">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container navbar-g">
      <img src="../assets/nav-gradient-bg.png" alt="" class="img-fluid">
    </div>
    
    <!-- Breadcrumb -->
    <nav
      aria-label="breadcrumb"
      data-aos="fade-up"
      data-aos-delay="100"
      class="mb-4 d-flex justify-content-center"
    >
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

      <div class="row justify-content-center g-4">
        <?php if (!empty($locations)): ?>
          <?php foreach ($locations as $index => $location): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 200; ?>">
              <div class="card text-center h-100 location-card">
                <div class="card-body">
                  <h4 class="card-title mb-4"><?php echo htmlspecialchars($location['title']); ?></h4>
                  <p class="card-text"><?php echo nl2br(htmlspecialchars($location['address'])); ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
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
        <?php endif; ?>
      </div>
    </div>

    <div class="py-4 mt-5" data-aos="fade-up" data-aos-delay="200">
      <div class="row justify-content-evenly text-center g-2">
        <!-- Contact Number -->
        <div class="col-md-6">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3">
              <img src="../assets/contact-no.png" alt="Phone icon" />
            </div>
            <h5 class="mb-2">Contact Number</h5>
            <p class="text-muted"><?php echo htmlspecialchars($contact_info['phone']); ?></p>
          </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3">
              <img src="../assets/emailus.png" alt="Email icon" />
            </div>
            <h5 class="mb-2">Email us</h5>
            <p class="text-muted"><?php echo htmlspecialchars($contact_info['email']); ?></p>
          </div>
        </div>
      </div>
    </div>

    <section class="py-5 mt-5" data-aos="fade-up" data-aos-delay="200">
      <h2 class="text-center mb-5 fw-bold">For Any Enquiries</h2>

      <div class="container row justify-content-center">
        <div class="col-lg-8">
          <!--<?php if ($form_submitted): ?>-->
          <!--  <div class="alert alert-success" role="alert">-->
          <!--    Thank you for your message! We'll get back to you soon.-->
          <!--  </div>-->
          <!--<?php elseif (!empty($form_errors['database'])): ?>-->
          <!--  <div class="alert alert-danger" role="alert">-->
          <!--    <?php echo $form_errors['database']; ?>-->
          <!--  </div>-->
          <!--<?php endif; ?>-->
          
 <form method="POST" action="db.store.php"  id="myForm" novalidate>
            <div class="row mb-4">
              <!-- Full Name -->
              <div class="col-md-6 mb-4 mb-md-0">
                <div class="form-group">
                  <label for="fullName" class="mb-2">Your Full Name</label>
                  <input
                    type="text"
                    class="form-control bg-light <?php echo !empty($form_errors['name']) ? 'is-invalid' : ''; ?>"
                    id="fullName"
                    name="name"
                    value="<?php echo htmlspecialchars($form_data['name']); ?>"
                    required
                  />
                  <?php if (!empty($form_errors['name'])): ?>
                    <div class="invalid-feedback"><?php echo $form_errors['name']; ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="mb-2">Your Email ID</label>
                  <input
                    type="email"
                    class="form-control bg-light <?php echo !empty($form_errors['email']) ? 'is-invalid' : ''; ?>"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($form_data['email']); ?>"
                    required
                  />
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
                required
              />
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
                required
              ><?php echo htmlspecialchars($form_data['message']); ?></textarea>
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
              onclick="submit()"
            >
              Submit
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="mt-5">
      <div class="container">
          <div class="row">
              <div class="col-md-4">
                  <div class="footer-logo d-flex align-items-center mb-3">
                      <img src="../assets/logo.png" alt="Bharathi Surgicals Logo" class="me-2">
                  </div>
                  <div class="opening-time">
                      <h5>Opening Time</h5>
                      <p>9.00 AM - 6.00 PM<br>(Monday - Sunday)</p>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="social-icons text-center">
                      <a href="#" aria-label="Facebook" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                      <a href="#" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
                      <a href="#" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="contact-info">
                      <div>
                          <a href="tel:<?php echo htmlspecialchars($contact_info['phone']); ?>" class="text-decoration-none text-dark">
                              <i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($contact_info['phone']); ?>
                          </a>
                      </div>
                      
                      <div>
                          <a href="mailto:<?php echo htmlspecialchars($contact_info['email']); ?>" class="text-decoration-none text-dark">
                              <i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($contact_info['email']); ?>
                          </a>
                      </div>
                      
                      <div>
                          <a href="https://www.google.com/maps/search/<?php echo urlencode($contact_info['address']); ?>" target="_blank" class="text-decoration-none text-dark">
                              <i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($contact_info['address']); ?>
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
              <li><a href="./forms/get_a_qoute.html">Get Quote</a></li>
                <li><a href="./forms/request_sample.html">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./forms/raise_of_complaint.html">Raise a Complaint</a></li>
                <li><a href="./forms/suggestions.html">Suggestions</a></li>
                <li><a href="#chat" id="open-chat">Chat with us</a></li>
          </ul>
      </div>
    </div>
    
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
        mirror: true /* Re-trigger on scroll up */,
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
  form.addEventListener("submit", function (e) {
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