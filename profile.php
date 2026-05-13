<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user stats
$stats_query = "SELECT * FROM user_stats WHERE user_id = $user_id";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Fetch user's recent quiz results
$recent_query = "SELECT * FROM quiz_results WHERE user_id = $user_id ORDER BY completed_at DESC LIMIT 5";
$recent_result = mysqli_query($conn, $recent_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">My Profile</h2>

            <div class="profile-card" style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 20px; width: 90%; margin-bottom: 20px; text-align: center;">
                <h3 style="color: #333; font-size: 24px; margin-bottom: 10px;"><?php echo htmlspecialchars($user['fullname']); ?></h3>
                <p style="color: #666; font-size: 14px; margin-bottom: 15px;"><?php echo htmlspecialchars($user['email']); ?></p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div style="background: #e9ff00; padding: 15px; border-radius: 10px;">
                        <p style="color: #333; font-size: 12px;">Total Score</p>
                        <p style="color: #333; font-size: 24px; font-weight: bold;"><?php echo $user['totalScore']; ?></p>
                    </div>
                    <div style="background: #4CAF50; padding: 15px; border-radius: 10px;">
                        <p style="color: white; font-size: 12px;">Current Streak</p>
                        <p style="color: white; font-size: 24px; font-weight: bold;"><?php echo $user['currentStreak']; ?></p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="background: #FF9800; padding: 15px; border-radius: 10px;">
                        <p style="color: white; font-size: 12px;">Best Streak</p>
                        <p style="color: white; font-size: 24px; font-weight: bold;"><?php echo $user['bestStreak']; ?></p>
                    </div>
                    <div style="background: #2196F3; padding: 15px; border-radius: 10px;">
                        <p style="color: white; font-size: 12px;">Accuracy</p>
                        <p style="color: white; font-size: 24px; font-weight: bold;"><?php echo round($stats['accuracy'], 1); ?>%</p>
                    </div>
                </div>
            </div>

            <div style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 20px; width: 90%; margin-bottom: 20px;">
                <h3 style="color: #333; font-size: 18px; margin-bottom: 15px;">Statistics</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <p style="color: #666; font-size: 12px;">Total Quizzes</p>
                        <p style="color: #333; font-size: 20px; font-weight: bold;"><?php echo $stats['total_quizzes']; ?></p>
                    </div>
                    <div>
                        <p style="color: #666; font-size: 12px;">Questions Answered</p>
                        <p style="color: #333; font-size: 20px; font-weight: bold;"><?php echo $stats['total_questions_answered']; ?></p>
                    </div>
                    <div>
                        <p style="color: #666; font-size: 12px;">Correct Answers</p>
                        <p style="color: #333; font-size: 20px; font-weight: bold;"><?php echo $stats['correct_answers']; ?></p>
                    </div>
                    <div>
                        <p style="color: #666; font-size: 12px;">Total Attempts</p>
                        <p style="color: #333; font-size: 20px; font-weight: bold;"><?php echo $stats['total_quizzes'] > 0 ? $stats['total_quizzes'] : 0; ?></p>
                    </div>
                </div>
            </div>

            <div style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 20px; width: 90%; margin-bottom: 20px;">
                <h3 style="color: #333; font-size: 18px; margin-bottom: 15px;">Recent Activity</h3>
                <?php
                $count = 0;
                while ($recent = mysqli_fetch_assoc($recent_result) && $count < 5) {
                    $count++;
                ?>
                <div style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px;">
                    <p style="color: #333; font-size: 14px;"><strong><?php echo ucfirst($recent['category']); ?></strong> - <?php echo ucfirst($recent['difficulty']); ?></p>
                    <p style="color: #666; font-size: 12px;">Score: <?php echo $recent['score']; ?>/<?php echo $recent['total_items']; ?> | Time: <?php echo $recent['time_taken']; ?>s</p>
                    <p style="color: #999; font-size: 11px;"><?php echo date('M d, Y', strtotime($recent['completed_at'])); ?></p>
                </div>
                <?php
                }
                if ($count == 0) {
                    echo "<p style='color: #999; text-align: center;'>No quizzes completed yet</p>";
                }
                ?>
            </div>

            <button class="btn-main" onclick="window.location.href='index.php'" style="margin-bottom: 20px;">BACK TO HOME</button>
        </div>
    </div>
</body>
</html>
