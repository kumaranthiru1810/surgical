<?php
// replace_image.php
header('Content-Type: application/json');
include('../db.php');


if (empty($_POST['image_id']) || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'Missing params']);
    exit;
}

$image_id = (int)$_POST['image_id'];
$uploadDir = '../uploads/products/';
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

try {
    // get current path
    $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo json_encode(['success' => false, 'error' => 'Image not found']);
        exit;
    }
    $oldPath = '../' . $row['image_path'];

    // validate and move new file
    $file = $_FILES['image'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'Upload error']);
        exit;
    }
    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    $fType = mime_content_type($file['tmp_name']);
    if (!in_array($fType, $allowed)) {
        echo json_encode(['success' => false, 'error' => 'Invalid file type']);
        exit;
    }

    $filename = uniqid() . '_' . basename($file['name']);
    $target = $uploadDir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        echo json_encode(['success' => false, 'error' => 'Move failed']);
        exit;
    }

    $dbPath = 'uploads/products/' . $filename;
    // update DB
    $upd = $pdo->prepare("UPDATE product_images SET image_path = ? WHERE id = ?");
    $upd->execute([$dbPath, $image_id]);

    // unlink old file if exists (and not same)
    if ($oldPath && file_exists($oldPath) && realpath($oldPath) !== realpath($target)) {
        @unlink($oldPath);
    }

    echo json_encode(['success' => true, 'new_path' => $dbPath]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
