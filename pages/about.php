<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bharathi Surgicals - About Us</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent animate-navbar">
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
              <a class="nav-link active" href="./Products.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./Management.php">Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./contact-us.php">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div class="container navbar-g">
      <img src="../assets/nav-gradient-bg.png" alt="" class="img-fluid">
    </div>
    
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
            class="about-us-doc-img img-fluid h-75 p-3"
          />
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
        mirror: true, /* Re-trigger on scroll up */
      });
    </script>
  </body>
</html>