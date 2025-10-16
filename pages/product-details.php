<?php
    $conn = mysqli_connect("localhost" , "root" , "" , "surgical");
?>
<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = mysqli_query($conn , "SELECT * FROM products WHERE id='$id'");
        $product = mysqli_fetch_assoc($sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name'] ?? 'Product Detail'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
            color: #333;
            padding: 30px 15px;
        }

        .product-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 40px;
            animation: fadeIn 0.6s ease;
        }

        .flex-row {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .image-box {
            flex: 1 1 45%;
            text-align: center;
        }

        .image-box img {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            border: 2px solid #e3f2fd;
            transition: transform 0.4s ease;
        }

        .image-box img:hover {
            transform: scale(1.03);
        }

        .features-box {
            flex: 1 1 50%;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
        }

        .check-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .check-list li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            font-size: 16px;
            line-height: 1.6;
        }

        .check-list li::before {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #28a745;
            position: absolute;
            left: 0;
            top: 2px;
        }

        .uses-box {
            margin-top: 60px;
        }

        .uses-box ul li::before {
            color: #28a745;
        }

        .btn-back {
            display: inline-block;
            margin-top: 40px;
            background-color: #007bff;
            color: #fff;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3;
            color: #fff;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .flex-row {
                flex-direction: column;
            }

            .features-box,
            .image-box {
                width: 100%;
            }
        }

        @media(max-width:375px){
            #product_name{
                font-size:30px;
            }
        }
        @media(max-width:320px){
            #product_name{
                font-size: 25px;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="product-wrapper">

        <h1 class="mb-4 text-center text-dark font-weight-bold" id="product_name">
            <?php echo htmlspecialchars($product['name'] ?? 'Product Name'); ?>
        </h1>

        <!-- Flex Row: Image + Key Features -->
        <div class="flex-row mt-4">
            <!-- Product Image -->
            <div class="image-box">
                <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
            </div>

            <!-- Key Features -->
            <div class="features-box">
                <div class="section-title">
                    <i class="fas fa-list-check"></i> Key Characteristics
                </div>
                <ul class="check-list">
                    <?php
                        $features = explode("\n", htmlspecialchars($product['key_characteristics']));
                        foreach ($features as $line) {
                            if (trim($line)) {
                                echo "<li>" . trim($line) . "</li>";
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>

        <?php if($product['uses']!=NULL) {?>
        <!-- Uses Section (Below Entire Row) -->
        <div class="uses-box">
            <div class="section-title mt-5">
                <i class="fas fa-stethoscope"></i> Uses
            </div>
            <ul class="check-list">
                <?php
                    $uses = explode("\n", htmlspecialchars($product['uses']));
                    foreach ($uses as $line) {
                        if (trim($line)) {
                            echo "<li>" . trim($line) . "</li>";
                        }
                    }
                ?>
            </ul>
        </div>
        <?php } ?>

        <!-- Back Button -->
        <div class="text-center">
            <a href="products.php" class="btn-back mt-4" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

    </div>

</body>
</html>
