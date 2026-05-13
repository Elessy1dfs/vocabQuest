<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .iphone-screen {
            background-image: url('back0.jpg');
            background-size: cover;
            background-position: center;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px;
            width: 80%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay">
            <div class="welcome-card">
                <h1 style="color: #e9ff00; font-size: 28px;">Success!</h1>
                <p style="color: white; font-size: 18px; margin: 15px 0;">
                    Welcome to the quest, <br>
                    <strong><?php echo htmlspecialchars($_GET['name'] ?? 'Adventurer'); ?></strong>!
                </p>
                <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin-bottom: 20px;">
                    Your account has been created. Are you ready to master new vocabulary?
                </p>
                
                <a href="login.php" class="btn-main">GET STARTED</a>
            </div>
        </div>
    </div>
</body>
</html>