<?php
session_start();
require_once('../db.php');

// Redirect logic
if (!isset($_SESSION['name'])) {
    echo "<script>alert('Please login to access this page.');window.location.href='../pages/signin.php';</script>";
    exit();
}

// Fetch company info
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
$data = ($sql->rowCount() > 0) ? $sql->fetch(PDO::FETCH_ASSOC) : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Raise a Complaint</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../index.css">

    <style>
        .helper-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .helper-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #007BFF;
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .helper-toggle:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .helper-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 220px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            transition: all 0.3s ease;
        }

        .helper-menu.active {
            display: block;
            animation: slideUp 0.3s forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .helper-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .helper-menu ul li {
            border-bottom: 1px solid #f0f0f0;
        }

        .helper-menu ul li:last-child {
            border-bottom: none;
        }

        .helper-menu ul li a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .helper-menu ul li a:hover {
            background-color: #f8f9fa;
            color: #007BFF;
            padding-left: 25px;
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

<body class="bg-light">


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
                        <a href="<?php echo $data1['insta']; ?>" aria-label="Instagram" class="social-icon instagram"><i class="bi bi-instagram"></i></a>
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
                    <img src="../assets/logo.jpeg" alt="<?php echo $data['company_name'] ?? 'Company'; ?> Logo" class="me-2">
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
                        <a class="nav-link" href="../pages/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/Products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/Management.php">Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/contact-us.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a class="btn btn-primary me-3" href="#"><?php echo $_SESSION['name']; ?></a>
                        <?php } else { ?>
                            <a href="../pages/signup.php" class="btn btn-primary me-3">Sign Up</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a href="../pages/logout.php" class="btn btn-primary me-3">Logout</a>
                        <?php } else { ?>
                            <a href="../pages/signin.php" class="btn btn-primary me-3">Sign In</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4"><i class="bi bi-exclamation-triangle me-2"></i> Raise a Complaint</h3>
                        <form method="POST" id="complaintForm">
                            <div class="mb-3">
                                <label class="form-label">Name of Firm <span class="text-danger">*</span></label>
                                <input type="text" name="firmName" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                                    <input type="text" name="invoiceNo" class="form-control" pattern="[A-Za-z0-9]+" title="Alphanumeric only" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                    <input type="date" name="invoiceDate" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <!-- <select class="form-select" name="countryCode" id="mobil_cc" style="max-width:100px;">
                                    </select> -->
                                    <select class="form-select" name="countryCode" id="mobile_cc" required style="flex: 0 0 140px;"></select>
                                    <input type="tel" name="mobileNumber" class="form-control" pattern="\d{10,15}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Detailed Complaint <span class="text-danger">*</span></label>
                                <textarea name="complaintDescription" class="form-control" rows="5" placeholder="Describe your complaint in detail..." required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 comp-btn"><i class="bi bi-send"></i> Submit Complaint</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        // WhatsApp message functionality for complaint form
        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);

            const complaintDetails = {
                firmName: formData.get('firmName'),
                invoiceNo: formData.get('invoiceNo'),
                invoiceDate: formData.get('invoiceDate'),
                countryCode: formData.get('countryCode'),
                mobileNumber: formData.get('mobileNumber'),
                email: formData.get('email'),
                complaintDescription: formData.get('complaintDescription')
            };

            // Format date for better readability
            const formattedDate = new Date(complaintDetails.invoiceDate).toLocaleDateString('en-IN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            // Construct WhatsApp message
            let message = `New Complaint Received%0A%0A`;
            message += `Company Details :%0A`;
            message += `Firm Name : ${complaintDetails.firmName}%0A`;
            message += `Email : ${complaintDetails.email}%0A`;
            message += `Phone : ${complaintDetails.countryCode} ${complaintDetails.mobileNumber}%0A%0A`;

            message += `Invoice Details :%0A`;
            message += `Invoice No : ${complaintDetails.invoiceNo}%0A`;
            message += `Invoice Date : ${formattedDate}%0A%0A`;

            message += `*Complaint Details:*%0A`;
            message += `⚠️ ${complaintDetails.complaintDescription}%0A%0A`;

            // message += `Priority : URGENT%0A`;
            // message += `Status : PENDING REVIEW%0A%0A`;
            message += `%0AThank you!.`;

            // Your store's WhatsApp number
            const storeNumber = "918489089784";
            const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

            // WhatsApp URL
            const whatsappURL = isMobile ?
                `https://wa.me/${storeNumber}?text=${message}` :
                `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

            // Basic form validation
            let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields.');
                return;
            }

            // Open WhatsApp in new tab
            window.open(whatsappURL, '_blank');

            // Submit form via AJAX
            // fetch('submit_complaint.php', {
            //         method: 'POST',
            //         body: formData
            //     })
            //     .then(async res => {
            //         try {
            //             const data = await res.json();
            //             if (data.status === 'success') {
            //                 alert('Complaint submitted successfully!');
            //                 this.reset();
            //             } else {
            //                 alert('Error submitting complaint. Please try again.');
            //             }
            //         } catch (e) {
            //             console.error('Invalid JSON response', e);
            //             alert('Server returned an unexpected response.');
            //         }
            //     })
            //     .catch(err => {
            //         console.error('Fetch error:', err);
            //         alert('An error occurred while submitting the complaint.');
            //     });

            const submitButton = document.querySelector('.comp-btn');

if (submitButton) {
    const originalText = submitButton.innerHTML;

    // Show spinner and disable button
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...`;
    submitButton.disabled = true;

    // After submission finishes (success or failure), reset the button
    fetch('submit_complaint.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            document.querySelector('form').reset();
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Something went wrong. Please try again.');
    })
    .finally(() => {
        // Restore button text and state
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}
        });

        // Add real-time validation
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            });
        });


        const countryCodes = [{
                code: "+93",
                country: "Afghanistan"
            },
            {
                code: "+355",
                country: "Albania"
            },
            {
                code: "+213",
                country: "Algeria"
            },
            {
                code: "+376",
                country: "Andorra"
            },
            {
                code: "+244",
                country: "Angola"
            },
            {
                code: "+1-264",
                country: "Anguilla"
            },
            {
                code: "+1-268",
                country: "Antigua and Barbuda"
            },
            {
                code: "+54",
                country: "Argentina"
            },
            {
                code: "+374",
                country: "Armenia"
            },
            {
                code: "+297",
                country: "Aruba"
            },
            {
                code: "+61",
                country: "Australia"
            },
            {
                code: "+43",
                country: "Austria"
            },
            {
                code: "+994",
                country: "Azerbaijan"
            },
            {
                code: "+1-242",
                country: "Bahamas"
            },
            {
                code: "+973",
                country: "Bahrain"
            },
            {
                code: "+880",
                country: "Bangladesh"
            },
            {
                code: "+1-246",
                country: "Barbados"
            },
            {
                code: "+375",
                country: "Belarus"
            },
            {
                code: "+32",
                country: "Belgium"
            },
            {
                code: "+501",
                country: "Belize"
            },
            {
                code: "+229",
                country: "Benin"
            },
            {
                code: "+1-441",
                country: "Bermuda"
            },
            {
                code: "+975",
                country: "Bhutan"
            },
            {
                code: "+591",
                country: "Bolivia"
            },
            {
                code: "+387",
                country: "Bosnia and Herzegovina"
            },
            {
                code: "+267",
                country: "Botswana"
            },
            {
                code: "+55",
                country: "Brazil"
            },
            {
                code: "+246",
                country: "British Indian Ocean Territory"
            },
            {
                code: "+1-284",
                country: "British Virgin Islands"
            },
            {
                code: "+673",
                country: "Brunei"
            },
            {
                code: "+359",
                country: "Bulgaria"
            },
            {
                code: "+226",
                country: "Burkina Faso"
            },
            {
                code: "+257",
                country: "Burundi"
            },
            {
                code: "+855",
                country: "Cambodia"
            },
            {
                code: "+237",
                country: "Cameroon"
            },
            {
                code: "+1-345",
                country: "Cayman Islands"
            },
            {
                code: "+236",
                country: "Central African Republic"
            },
            {
                code: "+56",
                country: "Chile"
            },
            {
                code: "+86",
                country: "China"
            },
            {
                code: "+61",
                country: "Christmas Island"
            },
            {
                code: "+61",
                country: "Cocos (Keeling) Islands"
            },
            {
                code: "+57",
                country: "Colombia"
            },
            {
                code: "+269",
                country: "Comoros"
            },
            {
                code: "+242",
                country: "Congo (Republic)"
            },
            {
                code: "+243",
                country: "Congo (Democratic Republic)"
            },
            {
                code: "+682",
                country: "Cook Islands"
            },
            {
                code: "+506",
                country: "Costa Rica"
            },
            {
                code: "+225",
                country: "Côte d'Ivoire"
            },
            {
                code: "+385",
                country: "Croatia"
            },
            {
                code: "+53",
                country: "Cuba"
            },
            {
                code: "+599",
                country: "Curaçao"
            },
            {
                code: "+357",
                country: "Cyprus"
            },
            {
                code: "+420",
                country: "Czech Republic"
            },
            {
                code: "+45",
                country: "Denmark"
            },
            {
                code: "+253",
                country: "Djibouti"
            },
            {
                code: "+1-767",
                country: "Dominica"
            },
            {
                code: "+1-809",
                country: "Dominican Republic"
            },
            {
                code: "+670",
                country: "East Timor"
            },
            {
                code: "+593",
                country: "Ecuador"
            },
            {
                code: "+20",
                country: "Egypt"
            },
            {
                code: "+503",
                country: "El Salvador"
            },
            {
                code: "+240",
                country: "Equatorial Guinea"
            },
            {
                code: "+291",
                country: "Eritrea"
            },
            {
                code: "+372",
                country: "Estonia"
            },
            {
                code: "+251",
                country: "Ethiopia"
            },
            {
                code: "+500",
                country: "Falkland Islands"
            },
            {
                code: "+298",
                country: "Faroe Islands"
            },
            {
                code: "+679",
                country: "Fiji"
            },
            {
                code: "+358",
                country: "Finland"
            },
            {
                code: "+33",
                country: "France"
            },
            {
                code: "+594",
                country: "French Guiana"
            },
            {
                code: "+689",
                country: "French Polynesia"
            },
            {
                code: "+241",
                country: "Gabon"
            },
            {
                code: "+220",
                country: "Gambia"
            },
            {
                code: "+995",
                country: "Georgia"
            },
            {
                code: "+49",
                country: "Germany"
            },
            {
                code: "+233",
                country: "Ghana"
            },
            {
                code: "+350",
                country: "Gibraltar"
            },
            {
                code: "+30",
                country: "Greece"
            },
            {
                code: "+299",
                country: "Greenland"
            },
            {
                code: "+1-473",
                country: "Grenada"
            },
            {
                code: "+1-671",
                country: "Guam"
            },
            {
                code: "+502",
                country: "Guatemala"
            },
            {
                code: "+224",
                country: "Guinea"
            },
            {
                code: "+245",
                country: "Guinea-Bissau"
            },
            {
                code: "+595",
                country: "Guyana"
            },
            {
                code: "+509",
                country: "Haiti"
            },
            {
                code: "+504",
                country: "Honduras"
            },
            {
                code: "+852",
                country: "Hong Kong"
            },
            {
                code: "+36",
                country: "Hungary"
            },
            {
                code: "+354",
                country: "Iceland"
            },
            {
                code: "+91",
                country: "India"
            },
            {
                code: "+62",
                country: "Indonesia"
            },
            {
                code: "+98",
                country: "Iran"
            },
            {
                code: "+964",
                country: "Iraq"
            },
            {
                code: "+353",
                country: "Ireland"
            },
            {
                code: "+972",
                country: "Israel"
            },
            {
                code: "+39",
                country: "Italy"
            },
            {
                code: "+1-876",
                country: "Jamaica"
            },
            {
                code: "+81",
                country: "Japan"
            },
            {
                code: "+962",
                country: "Jordan"
            },
            {
                code: "+7",
                country: "Kazakhstan"
            },
            {
                code: "+254",
                country: "Kenya"
            },
            {
                code: "+686",
                country: "Kiribati"
            },
            {
                code: "+965",
                country: "Kuwait"
            },
            {
                code: "+996",
                country: "Kyrgyzstan"
            },
            {
                code: "+856",
                country: "Laos"
            },
            {
                code: "+371",
                country: "Latvia"
            },
            {
                code: "+961",
                country: "Lebanon"
            },
            {
                code: "+266",
                country: "Lesotho"
            },
            {
                code: "+231",
                country: "Liberia"
            },
            {
                code: "+218",
                country: "Libya"
            },
            {
                code: "+423",
                country: "Liechtenstein"
            },
            {
                code: "+370",
                country: "Lithuania"
            },
            {
                code: "+352",
                country: "Luxembourg"
            },
            {
                code: "+853",
                country: "Macau"
            },
            {
                code: "+261",
                country: "Madagascar"
            },
            {
                code: "+265",
                country: "Malawi"
            },
            {
                code: "+60",
                country: "Malaysia"
            },
            {
                code: "+960",
                country: "Maldives"
            },
            {
                code: "+223",
                country: "Mali"
            },
            {
                code: "+356",
                country: "Malta"
            },
            {
                code: "+692",
                country: "Marshall Islands"
            },
            {
                code: "+596",
                country: "Martinique"
            },
            {
                code: "+222",
                country: "Mauritania"
            },
            {
                code: "+230",
                country: "Mauritius"
            },
            {
                code: "+262",
                country: "Mayotte"
            },
            {
                code: "+52",
                country: "Mexico"
            },
            {
                code: "+691",
                country: "Micronesia"
            },
            {
                code: "+373",
                country: "Moldova"
            },
            {
                code: "+377",
                country: "Monaco"
            },
            {
                code: "+976",
                country: "Mongolia"
            },
            {
                code: "+382",
                country: "Montenegro"
            },
            {
                code: "+1-664",
                country: "Montserrat"
            },
            {
                code: "+212",
                country: "Morocco"
            },
            {
                code: "+258",
                country: "Mozambique"
            },
            {
                code: "+95",
                country: "Myanmar"
            },
            {
                code: "+264",
                country: "Namibia"
            },
            {
                code: "+674",
                country: "Nauru"
            },
            {
                code: "+977",
                country: "Nepal"
            },
            {
                code: "+31",
                country: "Netherlands"
            },
            {
                code: "+687",
                country: "New Caledonia"
            },
            {
                code: "+64",
                country: "New Zealand"
            },
            {
                code: "+505",
                country: "Nicaragua"
            },
            {
                code: "+227",
                country: "Niger"
            },
            {
                code: "+234",
                country: "Nigeria"
            },
            {
                code: "+683",
                country: "Niue"
            },
            {
                code: "+672",
                country: "Norfolk Island"
            },
            {
                code: "+850",
                country: "North Korea"
            },
            {
                code: "+1-670",
                country: "Northern Mariana Islands"
            },
            {
                code: "+47",
                country: "Norway"
            },
            {
                code: "+968",
                country: "Oman"
            },
            {
                code: "+92",
                country: "Pakistan"
            },
            {
                code: "+680",
                country: "Palau"
            },
            {
                code: "+970",
                country: "Palestine"
            },
            {
                code: "+507",
                country: "Panama"
            },
            {
                code: "+675",
                country: "Papua New Guinea"
            },
            {
                code: "+595",
                country: "Paraguay"
            },
            {
                code: "+51",
                country: "Peru"
            },
            {
                code: "+63",
                country: "Philippines"
            },
            {
                code: "+48",
                country: "Poland"
            },
            {
                code: "+351",
                country: "Portugal"
            },
            {
                code: "+1-787",
                country: "Puerto Rico"
            },
            {
                code: "+974",
                country: "Qatar"
            },
            {
                code: "+262",
                country: "Réunion"
            },
            {
                code: "+40",
                country: "Romania"
            },
            {
                code: "+7",
                country: "Russia"
            },
            {
                code: "+250",
                country: "Rwanda"
            },
            {
                code: "+590",
                country: "Saint Barthélemy"
            },
            {
                code: "+1-869",
                country: "Saint Kitts and Nevis"
            },
            {
                code: "+1-758",
                country: "Saint Lucia"
            },
            {
                code: "+590",
                country: "Saint Martin"
            },
            {
                code: "+1-721",
                country: "Sint Maarten"
            },
            {
                code: "+685",
                country: "Samoa"
            },
            {
                code: "+378",
                country: "San Marino"
            },
            {
                code: "+239",
                country: "São Tomé and Príncipe"
            },
            {
                code: "+966",
                country: "Saudi Arabia"
            },
            {
                code: "+221",
                country: "Senegal"
            },
            {
                code: "+381",
                country: "Serbia"
            },
            {
                code: "+248",
                country: "Seychelles"
            },
            {
                code: "+232",
                country: "Sierra Leone"
            },
            {
                code: "+65",
                country: "Singapore"
            },
            {
                code: "+421",
                country: "Slovakia"
            },
            {
                code: "+386",
                country: "Slovenia"
            },
            {
                code: "+677",
                country: "Solomon Islands"
            },
            {
                code: "+252",
                country: "Somalia"
            },
            {
                code: "+27",
                country: "South Africa"
            },
            {
                code: "+82",
                country: "South Korea"
            },
            {
                code: "+211",
                country: "South Sudan"
            },
            {
                code: "+34",
                country: "Spain"
            },
            {
                code: "+94",
                country: "Sri Lanka"
            },
            {
                code: "+249",
                country: "Sudan"
            },
            {
                code: "+597",
                country: "Suriname"
            },
            {
                code: "+268",
                country: "Eswatini"
            },
            {
                code: "+46",
                country: "Sweden"
            },
            {
                code: "+41",
                country: "Switzerland"
            },
            {
                code: "+963",
                country: "Syria"
            },
            {
                code: "+886",
                country: "Taiwan"
            },
            {
                code: "+992",
                country: "Tajikistan"
            },
            {
                code: "+255",
                country: "Tanzania"
            },
            {
                code: "+66",
                country: "Thailand"
            },
            {
                code: "+670",
                country: "Timor-Leste"
            },
            {
                code: "+228",
                country: "Togo"
            },
            {
                code: "+690",
                country: "Tokelau"
            },
            {
                code: "+676",
                country: "Tonga"
            },
            {
                code: "+1-868",
                country: "Trinidad and Tobago"
            },
            {
                code: "+216",
                country: "Tunisia"
            },
            {
                code: "+90",
                country: "Turkey"
            },
            {
                code: "+993",
                country: "Turkmenistan"
            },
            {
                code: "+1-649",
                country: "Turks and Caicos Islands"
            },
            {
                code: "+688",
                country: "Tuvalu"
            },
            {
                code: "+256",
                country: "Uganda"
            },
            {
                code: "+380",
                country: "Ukraine"
            },
            {
                code: "+971",
                country: "United Arab Emirates"
            },
            {
                code: "+44",
                country: "United Kingdom"
            },
            {
                code: "+1",
                country: "United States"
            },
            {
                code: "+598",
                country: "Uruguay"
            },
            {
                code: "+998",
                country: "Uzbekistan"
            },
            {
                code: "+678",
                country: "Vanuatu"
            },
            {
                code: "+379",
                country: "Vatican City"
            },
            {
                code: "+58",
                country: "Venezuela"
            },
            {
                code: "+84",
                country: "Vietnam"
            },
            {
                code: "+681",
                country: "Wallis and Futuna"
            },
            {
                code: "+967",
                country: "Yemen"
            },
            {
                code: "+260",
                country: "Zambia"
            },
            {
                code: "+263",
                country: "Zimbabwe"
            }
        ];

        const mobileCC = document.getElementById("mobile_cc");
        // const whatsappCC = document.getElementById("whatsapp_cc");
        countryCodes.forEach(c => {
            mobileCC.add(new Option(`${c.country} (${c.code})`, c.code, c.code === "+91", c.code === "+91"));
            // whatsappCC.add(new Option(`${c.country} (${c.code})`, c.code, c.code === "+91", c.code === "+91"));
        });
    </script>
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


    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

</body>

</html>