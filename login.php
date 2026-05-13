<?php
session_start();

$error = isset($_GET['error']) ? $_GET['error'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* This ensures the mobile background is present */
        .iphone-screen {
            background-image: url('back0.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Specifically matching your earlier UI input styling */
        .vocab-form input {
            width: 85%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            outline: none;
            backdrop-filter: blur(5px);
        }

        .vocab-form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .vocab-form input:focus {
            border-color: #e9ff00; /* CIT-U Yellow Highlight */
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay">
            <h1 class="logo-text">VocabQuest</h1>
            <h2 class="title" style="color: white; margin-bottom: 20px;">Login</h2>
            
            <?php if($error): ?>
                <p style="color: #ff4d4d; font-size: 14px; margin-bottom: 10px;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="auth.php" method="POST" class="vocab-form" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-main" style="margin-top: 20px;">CONTINUE</button>
            </form>
            
            <p style="color: white; font-size: 14px; margin-top: 25px;">
                New student? <a href="register.php" style="color: #e9ff00; font-weight: bold; text-decoration: none;">Create Account</a>
            </p>
        </div>
    </div>
</body>
</html>