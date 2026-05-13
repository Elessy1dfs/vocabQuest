<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 0;
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'Unknown';
$difficulty = isset($_GET['difficulty']) ? htmlspecialchars($_GET['difficulty']) : 'Unknown';
$time = isset($_GET['time']) ? intval($_GET['time']) : 0;

$percentage = $total > 0 ? ($score / $total) * 100 : 0;
$minutes = intdiv($time, 60);
$seconds = $time % 60;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .result-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            text-align: center;
            margin-bottom: 20px;
        }

        .mascot {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .result-title {
            color: #333;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .result-subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .score-display {
            color: #e9ff00;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .score-label {
            color: #999;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
        }

        .stat-label {
            color: #999;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #333;
            font-size: 20px;
            font-weight: bold;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .btn-retry {
            padding: 15px;
            background: #FF9800;
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .btn-retry:hover {
            transform: translateY(-2px);
        }

        .btn-retry:active {
            transform: scale(0.98);
        }

        .btn-home {
            padding: 15px;
            background: #e9ff00;
            border: none;
            border-radius: 25px;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .btn-home:hover {
            transform: translateY(-2px);
        }

        .btn-home:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay" style="overflow-y: auto; padding-top: 20px; justify-content: flex-start;">
            <div class="result-card">
                <div class="mascot">
                    <?php
                    if ($percentage >= 80) {
                        echo '🎉';
                    } elseif ($percentage >= 60) {
                        echo '👍';
                    } else {
                        echo '🤔';
                    }
                    ?>
                </div>

                <div class="result-title">
                    <?php
                    if ($percentage >= 80) {
                        echo 'Excellent!';
                    } elseif ($percentage >= 60) {
                        echo 'Good Job!';
                    } else {
                        echo 'Keep Trying!';
                    }
                    ?>
                </div>

                <div class="result-subtitle"><?php echo ucfirst($category); ?> - <?php echo ucfirst($difficulty); ?></div>

                <div class="score-display"><?php echo round($percentage); ?>%</div>
                <div class="score-label">Your Score: <?php echo $score; ?> / <?php echo $total; ?> Points</div>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-label">Correct Answers</div>
                        <div class="stat-value"><?php echo intdiv($score, 10); ?>/<?php echo $total; ?></div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Accuracy</div>
                        <div class="stat-value"><?php echo round($percentage, 1); ?>%</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Time Taken</div>
                        <div class="stat-value"><?php echo $minutes; ?>:<?php echo str_pad($seconds, 2, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Bonus</div>
                        <div class="stat-value"><?php echo $score > 0 ? '+' . $score : '0'; ?></div>
                    </div>
                </div>

                <div class="button-group" style="width: 100%; margin-top: 30px;">
                    <button class="btn-retry" onclick="retakeQuiz()">RETAKE QUIZ</button>
                    <button class="btn-home" onclick="window.location.href='index.php'">BACK TO HOME</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function retakeQuiz() {
            window.location.href = 'index.php#categories';
        }
    </script>
</body>
</html>
