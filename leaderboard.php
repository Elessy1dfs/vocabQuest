<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch top users by total score
$leaderboard_query = "SELECT id, fullname, totalScore, currentStreak, bestStreak FROM users ORDER BY totalScore DESC LIMIT 20";
$leaderboard_result = mysqli_query($conn, $leaderboard_query);

// Get current user's rank
$rank_query = "SELECT COUNT(*) as rank FROM users WHERE totalScore > (SELECT totalScore FROM users WHERE id = " . $_SESSION['user_id'] . ")";
$rank_result = mysqli_query($conn, $rank_query);
$rank_data = mysqli_fetch_assoc($rank_result);
$user_rank = $rank_data['rank'] + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">Leaderboard</h2>

            <div style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 15px; width: 90%; margin-bottom: 20px; text-align: center;">
                <p style="color: #666; font-size: 12px;">Your Rank</p>
                <p style="color: #333; font-size: 32px; font-weight: bold;">#<?php echo $user_rank; ?></p>
                <p style="color: #999; font-size: 12px;"><?php echo htmlspecialchars($_SESSION['fullname']); ?></p>
            </div>

            <div style="width: 90%; max-height: 550px; overflow-y: auto;">
                <?php
                $position = 1;
                while ($user = mysqli_fetch_assoc($leaderboard_result)) {
                    $medal = '';
                    if ($position == 1) {
                        $medal = '🥇';
                    } else if ($position == 2) {
                        $medal = '🥈';
                    } else if ($position == 3) {
                        $medal = '🥉';
                    }

                    $is_current = ($user['id'] == $_SESSION['user_id']) ? 'style="background: rgba(233,255,0,0.2);"' : '';
                ?>
                <div <?php echo $is_current; ?> style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="color: #333; font-size: 18px; font-weight: bold; min-width: 30px;"><?php echo $medal ? $medal . ' ' : '#'; ?><?php echo $position; ?></span>
                        <div>
                            <p style="color: #333; font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($user['fullname']); ?></p>
                            <p style="color: #999; font-size: 12px;">Streak: <?php echo $user['currentStreak']; ?></p>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <p style="color: #e9ff00; font-size: 18px; font-weight: bold;"><?php echo $user['totalScore']; ?></p>
                        <p style="color: #999; font-size: 11px;">points</p>
                    </div>
                </div>
                <?php
                    $position++;
                }
                ?>
            </div>

            <button class="btn-main" onclick="window.location.href='index.php'" style="margin-top: 20px; margin-bottom: 20px;">BACK TO HOME</button>
        </div>
    </div>
</body>
</html>
