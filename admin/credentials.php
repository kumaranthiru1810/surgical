<?php session_start();
include('../db.php');

if(!(isset($_SESSION['email']))){
    header('login.php');
}

$sql = "SELECT * FROM admin_credentials";
$stmt = $pdo->query($sql);
$res = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $pdo->prepare("UPDATE admin_credentials SET email = ?, password = ?");
    $result = $query->execute([$email, $password]);
    if($result){
        echo "<script>
                alert('Updated the Admin Credentials Successfully!');
                window.location.href = 'admin.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Admin Credentials</title>
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(to right, #36d1dc, #5b86e5);
            /* Previous background */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.96);
            padding: 35px 30px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease forwards;
            transform: translateY(20px);
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            background: linear-gradient(to right, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus {
            border-color: #5b86e5;
            box-shadow: 0 0 0 3px rgba(91, 134, 229, 0.2);
            outline: none;
        }

        .update-btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .update-btn:hover {
            background: linear-gradient(to right, #5b86e5, #36d1dc);
            transform: scale(1.03);
            box-shadow: 0 6px 16px rgba(91, 134, 229, 0.4);
        }

        .note {
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-top: 14px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Update Admin Credentials</h2>
        <form method="POST">
            <div class="input-group">
                <label for="email">New Admin Email</label>
                <input type="email" id="email" name="email" value="<?php echo $res['email']; ?>" required>
            </div>

            <div class="input-group">
                <label for="password">New Admin Password</label>
                <input type="password" id="password" name="password" value="<?php echo $res['password']; ?>" required>
            </div>

            <button name="update" class="update-btn">Update Credentials</button>
        </form>
        <p class="note">Make sure your new credentials are secure.</p>
    </div>

</body>

</html>