<?php
session_start();
if (!isset($_SESSION['name'])) {
    echo "<script>alert('Please login to access this page.');window.location.href='../pages/signin.php';</script>";
    exit();
}

include('../db.php');

// Fetch company info
$sql = $pdo->query("SELECT * FROM company_info WHERE id = 1");
$data = $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : [];

// Fetch social links
$sql1 = $pdo->query("SELECT * FROM social_links WHERE id = 1");
$data1 = $sql1->rowCount() > 0 ? $sql1->fetch(PDO::FETCH_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Quote - <?php echo htmlspecialchars($data['company_name'] ?? 'Bharathi Surgicals'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
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

        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .page-header {
            color: rgb(0, 0, 0);
            padding: 10px 0;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .form-label {
            font-weight: 500;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .submit-btn {
            margin-top: 20px;
        }

        .product-row {
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .remove-product {
            cursor: pointer;
            color: #dc3545;
            transition: color 0.2s ease;
        }

        .remove-product:hover {
            color: #c82333;
        }

        .get_a_qoute {
            margin-top: 100px !important;
            margin-bottom: 100px !important;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
        }

        .form-control:invalid {
            border-color: #dc3545;
        }

        .form-control:valid {
            border-color: #28a745;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-valid {
            border-color: #28a745 !important;
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
                        <a href="#" id="open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
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
                        <a href="#" id="open-chat" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
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
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['name'])) { ?>
                            <a class="btn btn-primary me-3" href="#"><?php echo $_SESSION['name']; ?></a>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container get_a_qoute">
        <div class="row mb-3">
            <div class="col-12 text-center page-header">
                <h3><i class="bi bi-file-earmark-text me-2"></i> Get Quote</h3>
                <p class="lead mb-0">Fill out the form below to request a quote for our products</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <form id="quoteForm" method="POST" novalidate>
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label for="firmName" class="form-label required-field">Name of Firm</label>
                                <input type="text" class="form-control" id="firmName" name="firmName" placeholder="Enter your firm name" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label required-field">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your complete address" required></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label required-field">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label required-field">PinCode/Zip Code</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" pattern="^[0-9]{5,6}$" placeholder="Enter pincode" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mobileNumber" class="form-label required-field">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobileNumber" name="mobileNumber" placeholder="Enter mobile number" pattern="^[0-9]{10}$" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required-field">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            </div>

                            <div class="col-12">
                                <h4>Products</h4>
                                <div id="productsContainer">
                                    <div class="product-row" id="product-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-0">Product #1</h5>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required-field">Product Name</label>
                                                <input type="text" class="form-control product-name" placeholder="Enter product name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required-field">Size</label>
                                                <input type="text" class="form-control product-size" placeholder="Enter size details" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required-field">Quantity</label>
                                                <input type="number" class="form-control product-quantity" placeholder="Enter quantity" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-3 mb-3">
                                    <button type="button" id="addProductBtn" class="btn btn-success btn-sm">
                                        <i class="bi bi-plus-circle me-2"></i>Add Another Product
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg submit-btn">
                                    <i class="bi bi-send me-2"></i>Submit Quote Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let productCount = 1;

        // Add product functionality
        document.getElementById('addProductBtn').addEventListener('click', function() {
            productCount++;
            const productRow = `
                <div class="product-row" id="product-${productCount}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Product #${productCount}</h5>
                        <span class="remove-product" onclick="removeProduct(${productCount})">
                            <i class="bi bi-trash"></i> Remove
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required-field">Product Name</label>
                            <input type="text" class="form-control product-name" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Size</label>
                            <input type="text" class="form-control product-size" placeholder="Enter size details" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Quantity</label>
                            <input type="number" class="form-control product-quantity" placeholder="Enter quantity" min="1" required>
                        </div>
                    </div>
                </div>`;
            document.getElementById('productsContainer').insertAdjacentHTML('beforeend', productRow);
        });

        // Remove product functionality
        function removeProduct(id) {
            if (document.querySelectorAll('.product-row').length > 1) {
                document.getElementById(`product-${id}`)?.remove();
            } else {
                showAlert('You must have at least one product.', 'warning');
            }
        }

        // Form submission
        // Form submission
document.getElementById('quoteForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    if (!validateForm()) {
        showAlert('Please fill all required fields correctly.', 'warning');
        return;
    }

    const products = [];
    document.querySelectorAll('.product-row').forEach(row => {
        const productData = {
            name: row.querySelector('.product-name').value.trim(),
            size: row.querySelector('.product-size').value.trim(),
            quantity: row.querySelector('.product-quantity').value.trim()
        };
        if (productData.name) products.push(productData);
    });

    if (products.length === 0) {
        showAlert('Please add at least one product before submitting.', 'warning');
        return;
    }

    const formData = {
        firmName: document.getElementById('firmName').value.trim(),
        address: document.getElementById('address').value.trim(),
        city: document.getElementById('city').value.trim(),
        pincode: document.getElementById('pincode').value.trim(),
        mobileNumber: document.getElementById('mobileNumber').value.trim(),
        email: document.getElementById('email').value.trim(),
        products: products
    };

    const submitButton = document.querySelector('.submit-btn');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Submitting...`;
    submitButton.disabled = true;

    try {
        // First, save the quote to database
        const response = await fetch('save_quote.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            throw new Error('Server returned non-JSON response');
        }

        const result = await response.json();

        if (result.status === 'success') {
            // Generate and open WhatsApp message
            generateWhatsAppMessage(formData);
            
            showAlert('Thank you! Your quote request has been submitted successfully.', 'success');
            this.reset();
            resetProducts();
            
            // Optional: Redirect after successful submission
            setTimeout(() => {
                window.location.href = 'get_a_qoute.php';
            }, 2000);
        } else {
            showAlert('Error: ' + result.message, 'danger');
        }
    } catch (error) {
        console.error('Submission error:', error);
        showAlert('Submission failed: ' + error.message, 'danger');
    } finally {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }
});

// Generate and open WhatsApp message
function generateWhatsAppMessage(formData) {
    let message = `Hello! I would like to request a quote for the following products:%0A%0A`;

    // Add company information
    message += `*Company Details:*%0A`;
    message += `Firm Name: ${formData.firmName}%0A`;
    message += `Address: ${formData.address}%0A`;
    message += `City: ${formData.city}%0A`;
    message += `Pincode: ${formData.pincode}%0A`;
    message += `Mobile: ${formData.mobileNumber}%0A`;
    message += `Email: ${formData.email}%0A%0A`;

    // Add products section
    message += `*Products Requested:*%0A`;
    message += `────────────────────%0A`;

    formData.products.forEach((product, index) => {
        message += `*Product ${index + 1}:*%0A`;
        message += `Product: ${product.name}%0A`;
        message += `Size: ${product.size}%0A`;
        message += `Quantity: ${product.quantity}%0A`;

        if (index < formData.products.length - 1) {
            message += `────────────────────%0A`;
        }
    });

    message += `%0APlease provide me with the best quote for these products. Thank you!`;

    const storeNumber = "918489089784"; // Your WhatsApp number
    const isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

    // WhatsApp URL - fixed encoding
    const whatsappURL = isMobile ?
        `https://wa.me/${storeNumber}?text=${message}` :
        `https://web.whatsapp.com/send?phone=${storeNumber}&text=${message}`;

    // Open WhatsApp in a new tab
    window.open(whatsappURL, '_blank');
}

        // Form validation
        function validateForm() {
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            });

            // Validate mobile number
            const mobileField = document.getElementById('mobileNumber');
            const mobilePattern = /^[0-9]{10}$/;
            if (mobileField.value && !mobilePattern.test(mobileField.value)) {
                mobileField.classList.add('is-invalid');
                isValid = false;
            }

            // Validate pincode
            const pincodeField = document.getElementById('pincode');
            const pincodePattern = /^[0-9]{5,6}$/;
            if (pincodeField.value && !pincodePattern.test(pincodeField.value)) {
                pincodeField.classList.add('is-invalid');
                isValid = false;
            }

            return isValid;
        }

        // Reset products to initial state
        function resetProducts() {
            document.getElementById('productsContainer').innerHTML = `
                <div class="product-row" id="product-1">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0">Product #1</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required-field">Product Name</label>
                            <input type="text" class="form-control product-name" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Size</label>
                            <input type="text" class="form-control product-size" placeholder="Enter size details" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Quantity</label>
                            <input type="number" class="form-control product-quantity" placeholder="Enter quantity" min="1" required>
                        </div>
                    </div>
                </div>`;
            productCount = 1;
        }

        // Show alert function
        function showAlert(message, type) {
            const alertContainer = document.querySelector('.alert-container');
            const alertId = 'alert-' + Date.now();
            const alert = `
                <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
            alertContainer.insertAdjacentHTML('beforeend', alert);

            // Auto remove after 5 seconds
            setTimeout(() => {
                const alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.remove();
                }
            }, 5000);
        }

        // Real-time validation
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
                      <a href="#" aria-label="WhatsApp" class="social-icon whatsapp"><i class="bi bi-whatsapp"></i></a>
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

    <!-- Helper Widget -->
    <div class="helper-widget">
        <button class="helper-toggle">
            <i class="bi bi-question-circle-fill"></i>
        </button>
        <div class="helper-menu">
            <ul>
                <li><a href="./get_a_qoute.php">Get Quote</a></li>
                <li><a href="./request_sample.php">Request Samples</a></li>
                <li><a href="#brochure">Download Brochure</a></li>
                <li><a href="./raise_of_complaint.php">Raise a Complaint</a></li>
                <li><a href="./suggestions.php">Suggestions</a></li>
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
        // Helper widget functionality
        const toggleButton = document.querySelector('.helper-toggle');
        const helperMenu = document.querySelector('.helper-menu');

        toggleButton.addEventListener('click', (e) => {
            e.stopPropagation();
            helperMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.helper-widget')) {
                helperMenu.classList.remove('active');
            }
        });
    </script>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../index.js"></script>
</body>

</html>