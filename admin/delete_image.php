<?php
// delete_image.php
header('Content-Type: application/json');

include('../db.php');


$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['image_id'])) {
    echo json_encode(['success' => false, 'error' => 'No image id']);
    exit;
}

$image_id = (int)$input['image_id'];

try {
    // fetch path
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo json_encode(['success' => false, 'error' => 'Image not found']);
        exit;
    }

    $imagePath = '../' . $row['image_path']; // adjust prefix if needed
    if (file_exists($imagePath) && is_file($imagePath)) {
        @unlink($imagePath);
    }

    $del = $pdo->prepare("DELETE FROM product_images WHERE id = ?");
    $del->execute([$image_id]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}





















// echo "<script>alert('Image deleted successfully!');
//             window.location.href = 'admin.php';