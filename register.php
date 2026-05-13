<?php
session_start();

$message = isset($_GET['error']) ? $_GET['error'] : ""; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
    <style>

        .iphone-screen {
            background-image: url('backR0.jpg');
            background-size: cover;
            background-position: center;
        }

        .vocab-form input {
            width: 85%;
            padding: 15px;
            margin: 8px 0;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            outline: none;
            backdrop-filter: blur(5px);
        }

        .vocab-form input:focus {
            border-color: #e9ff00;
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay">
            <h1 class="logo-text">VocabQuest</h1>
            <h2 class="title" style="color: white; margin-bottom: 10px;">Create Account</h2>
            
            <?php if($message): ?>
                <div style="color: #ff4d4d; background: rgba(0,0,0,0.5); padding: 8px; border-radius: 8px; margin-bottom: 10px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="auth.php" method="POST" class="vocab-form" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <input type="hidden" name="action" value="register">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-main" style="margin-top: 20px;">SIGN UP</button>
            </form>
            
            <p style="color: white; font-size: 14px; margin-top: 25px;">
                Already a member? <a href="login.php" style="color: #e9ff00; font-weight: bold; text-decoration: none;">Login</a>
            </p>
        </div>
    </div>
</body>
</html>