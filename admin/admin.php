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

// Check if tables exist and create them if they don't
function checkAndCreateTables()
{
    $pdo = getDBConnection();

    // Check if products table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($tableCheck->rowCount() == 0) {
        $pdo->exec("CREATE TABLE products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            category VARCHAR(100),
            stock INT DEFAULT 0,
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
    }

    // Check if management table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'management'");
    if ($tableCheck->rowCount() == 0) {
        $pdo->exec("CREATE TABLE management (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            position VARCHAR(255) NOT NULL,
            bio TEXT,
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
    }

    // Check if contact_submissions table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'contact_submissions'");
    if ($tableCheck->rowCount() == 0) {
        $pdo->exec("CREATE TABLE contact_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255),
            message TEXT,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('new', 'read', 'replied') DEFAULT 'new'
        )");
    }

    $tableCheck = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($tableCheck->rowCount() == 0) {
        $pdo->exec("CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firm VARCHAR(255) NOT NULL,
    gst CHAR(15) DEFAULT NULL,
    drug VARCHAR(100) DEFAULT NULL,
    mobile_cc VARCHAR(5) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    whatsapp_cc VARCHAR(5) DEFAULT NULL,
    whatsapp VARCHAR(15) DEFAULT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    pin CHAR(6) NOT NULL,
    state VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
    }
}

// Call the function to check and create tables
checkAndCreateTables();

// Initialize messages
$product_message = '';
$member_message = '';
$contact_message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getDBConnection();

    // Add/Edit Product
    if (isset($_POST['add_product']) || isset($_POST['edit_product'])) {
        $name = $_POST['product_name'];
        $description = $_POST['product_description'];
        $category = $_POST['product_category'];
        $features = $_POST['product_features'];
        $uses = $_POST['product_uses'];
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

        // Handle product image upload
        $image = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/products/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['product_image']['name']);
            $targetPath = $uploadDir . $fileName;

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['product_image']['tmp_name']);

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
                    $image = 'uploads/products/' . $fileName;

                    // Delete old image if editing
                    if (isset($_POST['edit_product']) && $product_id && !empty($_POST['current_image'])) {
                        $oldImagePath = '../' . $_POST['current_image'];
                        if (file_exists($oldImagePath) && $_POST['current_image'] != $image) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }
        } elseif (isset($_POST['current_image']) && !empty($_POST['current_image'])) {
            $image = $_POST['current_image'];
        }

        try {
            if (isset($_POST['edit_product']) && $product_id) {
                // Update existing product
                if ($image) {
                    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, image = ?, key_characteristics = ?, uses = ?, category = ? WHERE id = ?");
                    $stmt->execute([$name, $description, $image, $features, $uses, $category, $product_id]);
                    echo "<script>
                            alert('Updated Successfully');
                            window.location.href='admin.php';
                        </script>";
                } else {
                    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, key_characteristics = ?, uses = ?, category = ? WHERE id = ?");
                    $stmt->execute([$name, $description, $features, $uses, $category, $product_id]);
                    echo "<script>
                            alert('Updated Successfully');
                            window.location.href='admin.php';
                        </script>";
                }
                $product_message = "Product updated successfully!";
            } else {
                // Add new product
                $stmt = $pdo->prepare("INSERT INTO products (name, description, image, key_characteristics, uses, category) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $image, $features, $uses, $category]);
                $product_message = "Product added successfully!";
            }
        } catch (PDOException $e) {
            $product_message = "Error: " . $e->getMessage();
        }
    }

    // Add/Edit Management Member
    if (isset($_POST['add_member']) || isset($_POST['edit_member'])) {
        $name = $_POST['member_name'];
        $position = $_POST['member_position'];
        $bio = $_POST['member_bio'];
        $member_id = isset($_POST['member_id']) ? $_POST['member_id'] : null;

        // Handle image upload if provided
        $image = '';
        if (isset($_FILES['member_image']) && $_FILES['member_image']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/management/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['member_image']['name']);
            $targetPath = $uploadDir . $fileName;

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['member_image']['tmp_name']);

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['member_image']['tmp_name'], $targetPath)) {
                    $image = 'uploads/management/' . $fileName;

                    // Delete old image if editing
                    if (isset($_POST['edit_member']) && $member_id && !empty($_POST['current_member_image'])) {
                        $oldImagePath = '../' . $_POST['current_member_image'];
                        if (file_exists($oldImagePath) && $_POST['current_member_image'] != $image) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }
        } elseif (isset($_POST['current_member_image']) && !empty($_POST['current_member_image'])) {
            $image = $_POST['current_member_image'];
        }

        try {
            if (isset($_POST['edit_member']) && $member_id) {
                // Update existing member
                if ($image) {
                    $stmt = $pdo->prepare("UPDATE management SET name = ?, position = ?, bio = ?, image = ? WHERE id = ?");
                    $stmt->execute([$name, $position, $bio, $image, $member_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE management SET name = ?, position = ?, bio = ? WHERE id = ?");
                    $stmt->execute([$name, $position, $bio, $member_id]);
                }
                $member_message = "Management member updated successfully!";
            } else {
                // Add new member
                $stmt = $pdo->prepare("INSERT INTO management (name, position, bio, image) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $position, $bio, $image]);
                $member_message = "Management member added successfully!";
            }
        } catch (PDOException $e) {
            $member_message = "Error: " . $e->getMessage();
        }
    }

    // Delete Product
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        $current_image = $_POST['current_image'];

        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$product_id]);

            // Delete product image if exists
            if (!empty($current_image)) {
                $imagePath = '../' . $current_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product_message = "Product deleted successfully!";
        } catch (PDOException $e) {
            $product_message = "Error deleting product: " . $e->getMessage();
        }
    }

    // Delete Management Member
    if (isset($_POST['delete_member'])) {
        $member_id = $_POST['member_id'];
        $current_image = $_POST['current_image'];

        try {
            $stmt = $pdo->prepare("DELETE FROM management WHERE id = ?");
            $stmt->execute([$member_id]);

            // Delete member image if exists
            if (!empty($current_image)) {
                $imagePath = '../' . $current_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $member_message = "Management member deleted successfully!";
        } catch (PDOException $e) {
            $member_message = "Error deleting member: " . $e->getMessage();
        }
    }

    // Delete Contact Submission
    if (isset($_POST['delete_contact'])) {
        $contact_id = $_POST['contact_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?");
            $stmt->execute([$contact_id]);
            $contact_message = "Contact submission deleted successfully!";
        } catch (PDOException $e) {
            $contact_message = "Error deleting contact: " . $e->getMessage();
        }
    }

    // Update Contact Status
    if (isset($_POST['update_contact_status'])) {
        $contact_id = $_POST['contact_id'];
        $status = $_POST['status'];
        try {
            $stmt = $pdo->prepare("UPDATE contact_submissions SET status = ? WHERE id = ?");
            $stmt->execute([$status, $contact_id]);
            $contact_message = "Contact status updated successfully!";
        } catch (PDOException $e) {
            $contact_message = "Error updating contact: " . $e->getMessage();
        }
    }


    if (isset($_POST['delete_users'])) {
        $user_id = $_POST['user_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $users_message = "User entry deleted successfully!";
        } catch (PDOException $e) {
            $users_message = "Error deleting user: " . $e->getMessage();
        }
    }

    // Update User Status
    if (isset($_POST['update_user_status'])) {
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];
        try {
            $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->execute([$status, $user_id]);
            $users_message = "User status updated successfully!";
        } catch (PDOException $e) {
            $users_message = "Error updating user status: " . $e->getMessage();
        }
    }
}

// Handle GET requests for editing
$edit_product = null;
$edit_member = null;

if (isset($_GET['edit_product'])) {
    $pdo = getDBConnection();
    $product_id = $_GET['edit_product'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $edit_product = $stmt->fetch();
    } catch (PDOException $e) {
        $product_message = "Error loading product: " . $e->getMessage();
    }
}

if (isset($_GET['edit_member'])) {
    $pdo = getDBConnection();
    $member_id = $_GET['edit_member'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM management WHERE id = ?");
        $stmt->execute([$member_id]);
        $edit_member = $stmt->fetch();
    } catch (PDOException $e) {
        $member_message = "Error loading member: " . $e->getMessage();
    }
}

// Fetch data for display
$pdo = getDBConnection();
try {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    $management = $pdo->query("SELECT * FROM management ORDER BY id DESC")->fetchAll();
    $contacts = $pdo->query("SELECT * FROM contact_submissions ORDER BY submitted_at DESC")->fetchAll();
    $users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    // Handle error if tables don't exist yet
    $products = [];
    $management = [];
    $contacts = [];
    $users = [];
}

// Calculate statistics
$total_products = count($products);
$total_members = count($management);
$total_contacts = count($contacts);
$total_users = count($users);
$new_contacts = count(array_filter($contacts, function ($contact) {
    return $contact['status'] == 'new';
}));

// Get low stock products
try {
    $low_stock = $pdo->query("SELECT * FROM products WHERE stock < 10")->fetchAll();
} catch (PDOException $e) {
    $low_stock = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bharathi Surgicals</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #87CEEB;
            --primary-dark: #4682B4;
            --light: #f8f9fa;
            --dark: #343a40;
        }

        body {
            background-color: #f0f8ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .admin-nav {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .admin-nav .nav-link {
            color: var(--dark);
            font-weight: 500;
            padding: 15px 20px;
            transition: all 0.3s;
        }

        .admin-nav .nav-link:hover,
        .admin-nav .nav-link.active {
            background-color: var(--primary);
            color: white;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            background: white;
            color: var(--dark);
            padding: 20px;
            text-align: center;
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .section-title {
            color: var(--primary-dark);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: var(--primary-dark);
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background-color: var(--primary);
        }

        .table th {
            background-color: var(--primary);
            color: white;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .low-stock {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }

        .userentries-section {
            display: none;
        }

        .userentries-section.active {
            display: block;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .status-new {
            background-color: #007bff;
            color: white;
        }

        .status-read {
            background-color: #6c757d;
            color: white;
        }

        .status-replied {
            background-color: #28a745;
            color: white;
        }

        .product-image-thumb,
        .member-image-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fas fa-cog me-2"></i>Bharathi Surgicals Admin Panel</h1>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-inline-block p-2 rounded" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-user me-1"></i> Administrator
                    </div>
                    <div class="d-inline-block p-2 rounded" style="background: rgba(255,255,255,0.2);">
                        <a href="logout.php" onclick="return confirm('Are you sure to Logout?');" style="color: white; text-decoration:none;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                    <div class="d-inline-block p-2 rounded" style="background: rgba(255,255,255,0.2);">
                        <a href="credentials.php" onclick="return confirm('Do you Want to Update Credentials?');" style="color: white; text-decoration:none;"><i class="fa-solid fa-lock"></i> Credentials</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="admin-nav">
        <div class="container">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-section="dashboard"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="products"><i class="fas fa-box me-1"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="management"><i class="fas fa-users me-1"></i> Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="contact"><i class="fas fa-phone me-1"></i> Contact Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="contacts"><i class="fas fa-envelope me-1"></i> Contact Submissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="users"><i class="fas fa-user me-1"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" target="_blank"><i class="fas fa-external-link-alt me-1"></i> View Website</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section active">
            <h2 class="section-title">Dashboard Overview</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card card">
                        <i class="fas fa-box"></i>
                        <div class="stat-number"><?php echo $total_products; ?></div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card card">
                        <i class="fas fa-users"></i>
                        <div class="stat-number"><?php echo $total_members; ?></div>
                        <div class="stat-label">Management Members</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card card">
                        <i class="fas fa-envelope"></i>
                        <div class="stat-number"><?php echo $total_contacts; ?></div>
                        <div class="stat-label">Total Contacts</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card card">
                        <i class="fas fa-user"></i>
                        <div class="stat-number"><?php echo $total_users; ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card card">
                        <i class="fas fa-bell"></i>
                        <div class="stat-number"><?php echo $new_contacts; ?></div>
                        <div class="stat-label">New Messages</div>
                    </div>
                </div>
            </div>

            <?php if (!empty($low_stock)): ?>
                <div class="alert alert-warning low-stock mt-4">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alert</h5>
                    <p>The following products are running low on stock:</p>
                    <ul>
                        <?php foreach ($low_stock as $product): ?>
                            <li><?php echo htmlspecialchars($product['name']); ?> (Only <?php echo $product['stock']; ?> left)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Recent Contact Submissions</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($total_contacts > 0): ?>
                                <?php $recent_contacts = array_slice($contacts, 0, 5); ?>
                                <?php foreach ($recent_contacts as $contact): ?>
                                    <div class="border-bottom pb-2 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold"><?php echo htmlspecialchars($contact['name']); ?></div>
                                            <span class="status-badge status-<?php echo $contact['status']; ?>">
                                                <?php echo ucfirst($contact['status']); ?>
                                            </span>
                                        </div>
                                        <div class="small"><?php echo htmlspecialchars($contact['email']); ?></div>
                                        <div class="text-truncate"><?php echo htmlspecialchars($contact['subject']); ?></div>
                                        <small class="text-muted"><?php echo date('M j, Y H:i', strtotime($contact['submitted_at'])); ?></small>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-muted">No contact submissions yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-primary section-switch" data-section="products">
                                    <i class="fas fa-plus me-1"></i> Add New Product
                                </a>
                                <a href="#" class="btn btn-primary section-switch" data-section="management">
                                    <i class="fas fa-user-plus me-1"></i> Add Management Member
                                </a>
                                <a href="#" class="btn btn-primary section-switch" data-section="contacts">
                                    <i class="fas fa-eye me-1"></i> View Contact Submissions
                                </a>
                                <a href="#" class="btn btn-primary section-switch" data-section="users">
                                    <i class="fas fa-eye me-1"></i> View User Entries
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Products Section -->


        <div id="products" class="content-section">
            <h2 class="section-title">Product Management</h2>

            <?php if (!empty($product_message)): ?>
                <div class="alert alert-info"><?php echo $product_message; ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if ($edit_product): ?>
                                    <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
                                    <input type="hidden" name="current_image" value="<?php echo $edit_product['image'] ?? ''; ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="product_description" rows="3" required><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" class="form-control" name="product_category" value="<?php echo $edit_product ? htmlspecialchars($edit_product['category']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Key Features</label>
                                    <textarea class="form-control" name="product_features" rows="3" required><?php echo $edit_product ? htmlspecialchars($edit_product['key_characteristics']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Uses</label>
                                    <textarea class="form-control" name="product_uses" rows="3"><?php echo $edit_product ? htmlspecialchars($edit_product['uses']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Image</label>
                                    <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*">
                                    <?php if ($edit_product && !empty($edit_product['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../<?php echo $edit_product['image']; ?>" alt="Current Image" class="product-image-thumb">
                                            <small class="d-block text-muted">Current image</small>
                                        </div>
                                    <?php endif; ?>
                                    <img id="product_image_preview" class="image-preview mt-2" src="#" alt="Image Preview">
                                </div>
                                <?php if ($edit_product): ?>
                                    <button type="submit" name="edit_product" class="btn btn-primary w-100">Update Product</button>
                                    <a href="admin.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                                <?php else: ?>
                                    <button type="submit" name="add_product" class="btn btn-primary w-100">Add Product</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">All Products (<?php echo $total_products; ?>)</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($total_products > 0): ?>
                                <!-- Search Box -->
                                <div class="mb-3 d-flex">
                                    <input type="text" id="productSearchInput" class="form-control me-2" placeholder="Search product by name...">
                                    <button class="btn btn-primary" style="margin-right: 5px;" onclick="searchProduct()">Search</button>
                                    <button class="btn btn-primary" onclick="showAll()">All</button>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="productTable">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Key Features</th>
                                                <th>Uses</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <tr>
                                                    <td>
                                                        <?php if (!empty($product['image'])): ?>
                                                            <img src="../<?php echo $product['image']; ?>" alt="Product Image" class="product-image-thumb">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="product-name"><?php echo htmlspecialchars($product['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['key_characteristics']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['uses']); ?></td>
                                                    <td>
                                                        <a href="?edit_product=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                            <input type="hidden" name="current_image" value="<?php echo $product['image'] ?? ''; ?>">
                                                            <button type="submit" name="delete_product" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">No products added yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <!-- Management Section -->


        <!-- Management Section -->
        <div id="management" class="content-section">
            <h2 class="section-title">Management Team</h2>

            <?php if (!empty($member_message)): ?>
                <div class="alert alert-info"><?php echo $member_message; ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?php echo $edit_member ? 'Edit Member' : 'Add Management Member'; ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if ($edit_member): ?>
                                    <input type="hidden" name="member_id" value="<?php echo $edit_member['id']; ?>">
                                    <input type="hidden" name="current_member_image" value="<?php echo $edit_member['image'] ?? ''; ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="member_name" value="<?php echo $edit_member ? htmlspecialchars($edit_member['name']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="text" class="form-control" name="member_position" value="<?php echo $edit_member ? htmlspecialchars($edit_member['position']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bio/Description</label>
                                    <textarea class="form-control" name="member_bio" rows="3" required><?php echo $edit_member ? htmlspecialchars($edit_member['bio']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" name="member_image" id="member_image" accept="image/*">
                                    <?php if ($edit_member && !empty($edit_member['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../<?php echo $edit_member['image']; ?>" alt="Current Image" class="member-image-thumb">
                                            <small class="d-block text-muted">Current image</small>
                                        </div>
                                    <?php endif; ?>
                                    <img id="member_image_preview" class="image-preview mt-2" src="#" alt="Image Preview">
                                </div>
                                <?php if ($edit_member): ?>
                                    <button type="submit" name="edit_member" class="btn btn-primary w-100">Update Member</button>
                                    <a href="admin.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                                <?php else: ?>
                                    <button type="submit" name="add_member" class="btn btn-primary w-100">Add Member</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Management Team (<?php echo $total_members; ?>)</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($total_members > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($management as $member): ?>
                                                <tr>
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td>
                                                        <?php if (!empty($member['image'])): ?>
                                                            <img src="../<?php echo $member['image']; ?>" alt="Profile" class="member-image-thumb">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($member['position']); ?></td>
                                                    <td>
                                                        <a href="?edit_member=<?php echo $member['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="member_id" value="<?php echo $member['id']; ?>">
                                                            <input type="hidden" name="current_image" value="<?php echo $member['image'] ?? ''; ?>">
                                                            <button type="submit" name="delete_member" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">No management members added yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Contact Details Section -->

        <?php
        if (isset($_POST['add_contact'])) {
            $headoffice = $_POST['headoffice'];
            $branchoffice = $_POST['branchoffice'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $stmt = $pdo->prepare("INSERT INTO contact_page_details (headoffice, branchoffice, phone, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$headoffice, $branchoffice, $phone, $email]);
        }

        // $conn = mysqli_connect("localhost", "root", "", "surgical");
        include('../db.php');

        if (isset($_GET['edit_contact'])) {
            $contact_id = $_GET['edit_contact'];
            try {
                $select = $pdo->prepare("SELECT * FROM contact_page_details WHERE id = ?");
                $select->execute([$contact_id]);
                $edit_contact = $select->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $product_message = "Error loading product: " . $e->getMessage();
            }
        }


        if (isset($_POST['delete_contact_detail'])) {
            $id = $_POST['contactdetail_id'];
            $sql = $pdo->prepare("DELETE FROM contact_page_details WHERE id = ?");
            $sql->execute([$id]);
            if ($sql) {
                echo "<script>alert('Deleted Successfully');
                            window.location.href = 'admin.php';
                    </script>";
            }
        }

        if (isset($_POST['update_contact'])) {
            $headoffice = $_POST['headoffice'];
            $branchoffice = $_POST['branchoffice'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $id = $_POST['contactdetail_id'];

            $sql = $pdo->prepare("UPDATE contact_page_details SET headoffice = ? , branchoffice = ?, phone = ? , email = ? WHERE id = ?");
            $sql->execute([$headoffice , $branchoffice , $phone , $email , $id]);
            if ($sql) {
                echo "<script>alert('Updated Successfully');
                                    window.location.href = 'admin.php';
                    </script>";
            }
        }
        ?>


        <div id="contact" class="content-section">
            <h2 class="section-title">Contact Details Section</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <?php if (isset($edit_contact)) { ?>
                                    Edit Contact Page Details
                                <?php } else { ?>
                                    Add Contact Page Details
                                <?php } ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if (isset($edit_contact)): ?>
                                    <input type="hidden" name="id" value="<?php echo $edit_contact['id']; ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="form-label">Head Office Address</label>
                                    <input type="text" class="form-control" name="headoffice" value="<?php echo isset($edit_contact) ? htmlspecialchars($edit_contact['headoffice']) : '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Branch Office Address</label>
                                    <input type="text" class="form-control" name="branchoffice" value="<?php echo isset($edit_contact) ? htmlspecialchars($edit_contact['branchoffice']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo isset($edit_contact) ? htmlspecialchars($edit_contact['phone']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo isset($edit_contact) ? htmlspecialchars($edit_contact['email']) : ''; ?>" required>
                                </div>
                                <?php if (isset($edit_contact)): ?>
                                    <form method="POST">
                                        <input type="hidden" name="contactdetail_id" value="<?php echo $edit_contact['id']; ?>">
                                        <button type="submit" name="update_contact" class="btn btn-primary w-100">Update Contact Page Details</button>
                                        <a href="admin.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                                    </form>
                                <?php else: ?>
                                    <button type="submit" name="add_contact" class="btn btn-primary w-100">Add Contact Page Details</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                $sql = $pdo->prepare("SELECT * FROM contact_page_details");
                $sql->execute();
                ?>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Contact Page Details</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($sql): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Head Office</th>
                                                <th>Branch Office</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($res = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>

                                                    <td><?php echo $res['headoffice']; ?></td>
                                                    <td><?php echo $res['branchoffice']; ?></td>
                                                    <td><?php echo $res['phone']; ?></td>
                                                    <td><?php echo $res['email']; ?></td>
                                                    <td>
                                                        <a href="?edit_contact=<?php echo $res['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="contactdetail_id" value="<?php echo $res['id']; ?>">
                                                            <button type="submit" name="delete_contact_detail" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this Detail?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">No Details Added.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Contacts Section -->
        <div id="contacts" class="content-section">
            <h2 class="section-title">Contact Form Submissions</h2>

            <?php if (!empty($contact_message)): ?>
                <div class="alert alert-info"><?php echo $contact_message; ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Submissions (<?php echo $total_contacts; ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if ($total_contacts > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($contacts as $contact): ?>
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo $contact['status']; ?>">
                                                    <?php echo ucfirst($contact['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($contact['submitted_at'])); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary view-message" data-bs-toggle="modal" data-bs-target="#messageModal" data-message="<?php echo htmlspecialchars($contact['message']); ?>" data-name="<?php echo htmlspecialchars($contact['name']); ?>">View</button>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                    <button type="submit" name="delete_contact" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</button>
                                                </form>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        Status
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form method="POST" class="dropdown-item p-0">
                                                                <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                                <input type="hidden" name="status" value="new">
                                                                <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as New</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" class="dropdown-item p-0">
                                                                <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                                <input type="hidden" name="status" value="read">
                                                                <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as Read</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" class="dropdown-item p-0">
                                                                <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                                <input type="hidden" name="status" value="replied">
                                                                <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as Replied</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">No contact submissions yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div id="users" class="content-section container">
        <h2 class="section-title">Users Entry</h2>

        <?php if (!empty($users_message)): ?>
            <div class="alert alert-info"><?php echo $users_message; ?></div>
        <?php endif; ?>

        <div class="container card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Entries (<?php echo $total_users; ?>)</h5>
            </div>
            <div class="card-body">
                <?php if ($total_users > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Firm Name</th>
                                    <th>Email</th>
                                    <th>GST No</th>
                                    <th>Drug/Manufacturing Licence</th>
                                    <th>Mobile Number</th>
                                    <th>WhatsApp Number</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>PIN / ZIP Code</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $i; $i++; ?></td>
                                        <td><?php echo htmlspecialchars($user['firm']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['gst']); ?></td>
                                        <td><?php echo htmlspecialchars($user['drug']); ?></td>
                                        <td><?php echo htmlspecialchars($user['mobile_cc']) . htmlspecialchars($user['mobile']); ?></td>
                                        <td><?php echo htmlspecialchars($user['whatsapp_cc']) . htmlspecialchars($user['whatsapp']); ?></td>
                                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                                        <td><?php echo htmlspecialchars($user['city']); ?></td>
                                        <td><?php echo htmlspecialchars($user['country']); ?></td>
                                        <td><?php echo htmlspecialchars($user['pin']); ?></td>
                                        <td><?php echo htmlspecialchars($user['state']); ?></td>
                                        <td><?php echo htmlspecialchars($user['district']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary view-message" data-bs-toggle="modal" data-bs-target="#messageModal" data-name="<?php echo htmlspecialchars($user['firm']); ?>">View</button>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" name="delete_users" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    Status
                                                </button>
                                                <!-- <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST" class="dropdown-item p-0">
                                                            <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                            <input type="hidden" name="status" value="new">
                                                            <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as New</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" class="dropdown-item p-0">
                                                            <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                            <input type="hidden" name="status" value="read">
                                                            <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as Read</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" class="dropdown-item p-0">
                                                            <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                            <input type="hidden" name="status" value="replied">
                                                            <button type="submit" name="update_contact_status" class="btn btn-sm w-100 text-start">Mark as Replied</button>
                                                        </form>
                                                    </li>
                                                </ul> -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">No contact submissions yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Message from <span id="senderName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="messageContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">Bharathi Surgicals Admin Panel &copy; <?php echo date('Y'); ?></p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Section switching
        document.querySelectorAll('.nav-link, .section-switch').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Update navigation
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                if (this.classList.contains('nav-link')) {
                    this.classList.add('active');
                } else {
                    const section = this.getAttribute('data-section');
                    document.querySelector(`.nav-link[data-section="${section}"]`).classList.add('active');
                }

                // Show section
                const sectionId = this.getAttribute('data-section');
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(sectionId).classList.add('active');

                // Scroll to top
                window.scrollTo(0, 0);
            });
        });

        // Message modal
        const messageModal = document.getElementById('messageModal');
        if (messageModal) {
            messageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const message = button.getAttribute('data-message');
                const name = button.getAttribute('data-name');

                document.getElementById('senderName').textContent = name;
                document.getElementById('messageContent').textContent = message;
            });
        }

        // Image preview functionality
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('product_image').addEventListener('change', function() {
            readURL(this, 'product_image_preview');
        });

        document.getElementById('member_image').addEventListener('change', function() {
            readURL(this, 'member_image_preview');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);



        function searchProduct() {
            const input = document.getElementById('productSearchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('#productTable tbody tr');

            rows.forEach(row => {
                const nameCell = row.querySelector('.product-name');
                const productName = nameCell.textContent.toLowerCase();

                if (productName.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function showAll() {
            const rows = document.querySelectorAll('#productTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        }
    </script>
</body>

</html>