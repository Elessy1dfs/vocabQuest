<?php
session_start();
include 'db_config.php';

$user_logged_in = isset($_SESSION['user_id']) ? true : false;
$fullname = $user_logged_in ? $_SESSION['fullname'] : '';
$user_id = $user_logged_in ? $_SESSION['user_id'] : '';

// Fetch user stats if logged in
$user_stats = null;
if ($user_logged_in) {
    $stats_query = "SELECT * FROM user_stats WHERE user_id = $user_id";
    $stats_result = mysqli_query($conn, $stats_query);
    $user_stats = mysqli_fetch_assoc($stats_result);

    $user_data_query = "SELECT totalScore, currentStreak, bestStreak FROM users WHERE id = $user_id";
    $user_data_result = mysqli_query($conn, $user_data_query);
    $user_data = mysqli_fetch_assoc($user_data_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VocabQuest - Master Your Vocabulary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="iphone-screen">

    <!-- =============== SPLASH SCREEN =============== -->
    <div id="screen-splash" class="screen <?php echo $user_logged_in ? 'hidden' : ''; ?>">
        <div class="content-overlay">
            <h1 class="logo-text">VocabQuest</h1>
            <p class="subtitle">Master new vocabulary through interactive quizzes and challenges!</p>
            <button class="btn-main" onclick="showScreen('screen-login')">GET STARTED</button>
        </div>
    </div>

    <!-- =============== LOGIN SCREEN =============== -->
    <div id="screen-login" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: white;">Login</h2>
            <form action="auth.php" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Email Address" required style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Password" required style="margin-bottom: 20px;">
                <button type="submit" class="btn-main" style="margin-bottom: 20px;">LOGIN</button>
            </form>
            <p class="footer-text">
                New student? <span onclick="showScreen('screen-register')" style="color: #e9ff00; cursor: pointer;">Create Account</span>
            </p>
            <button class="btn-back" onclick="showScreen('screen-splash')">BACK</button>
        </div>
    </div>

    <!-- =============== REGISTER SCREEN =============== -->
    <div id="screen-register" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: white;">Create Account</h2>
            <form action="auth.php" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <input type="hidden" name="action" value="register">
                <input type="text" name="fullname" placeholder="Full Name" required style="margin-bottom: 15px;">
                <input type="email" name="email" placeholder="Email Address" required style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Password" required style="margin-bottom: 20px;">
                <button type="submit" class="btn-main" style="margin-bottom: 20px;">SIGN UP</button>
            </form>
            <p class="footer-text">
                Already have an account? <span onclick="showScreen('screen-login')" style="color: #e9ff00; cursor: pointer;">Login</span>
            </p>
            <button class="btn-back" onclick="showScreen('screen-splash')">BACK</button>
        </div>
    </div>

    <!-- =============== HOME SCREEN =============== -->
    <div id="screen-home" class="screen <?php echo !$user_logged_in ? 'hidden' : ''; ?>">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00; margin-bottom: 10px;">Welcome, <?php echo htmlspecialchars($fullname); ?></h2>
            
            <div class="stats-box" style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 20px; width: 90%; margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="text-align: center;">
                    <p style="color: #999; font-size: 12px;">Total Score</p>
                    <p style="color: #333; font-size: 24px; font-weight: bold;"><?php echo $user_data['totalScore'] ?? 0; ?></p>
                </div>
                <div style="text-align: center;">
                    <p style="color: #999; font-size: 12px;">Streak</p>
                    <p style="color: #333; font-size: 24px; font-weight: bold;"><?php echo $user_data['currentStreak'] ?? 0; ?></p>
                </div>
            </div>

            <div class="menu-card" onclick="goToDifficulty('Nature')" style="cursor: pointer;">
                <span class="menu-icon">🎯</span>
                <span class="menu-text">Start Quiz</span>
            </div>

            <div class="menu-card" onclick="showScreen('screen-dashboard')" style="cursor: pointer;">
                <span class="menu-icon">📊</span>
                <span class="menu-text">Dashboard</span>
            </div>

            <div class="menu-card" onclick="goToLeaderboard()" style="cursor: pointer;">
                <span class="menu-icon">🏆</span>
                <span class="menu-text">Leaderboard</span>
            </div>

            <div class="menu-card" onclick="goToProfile()" style="cursor: pointer;">
                <span class="menu-icon">👤</span>
                <span class="menu-text">Profile</span>
            </div>

            <div class="menu-card" onclick="logout()" style="cursor: pointer;">
                <span class="menu-icon">🚪</span>
                <span class="menu-text">Logout</span>
            </div>
        </div>
    </div>

    <!-- =============== DASHBOARD SCREEN =============== -->
    <div id="screen-dashboard" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">Dashboard</h2>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px;">
                <div class="act-info">
                    <h3>Total Quizzes</h3>
                    <p><?php echo $user_stats['total_quizzes'] ?? 0; ?> completed</p>
                </div>
                <span class="act-icon">📋</span>
            </div>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px;">
                <div class="act-info">
                    <h3>Questions Answered</h3>
                    <p><?php echo $user_stats['total_questions_answered'] ?? 0; ?> total</p>
                </div>
                <span class="act-icon">❓</span>
            </div>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px;">
                <div class="act-info">
                    <h3>Correct Answers</h3>
                    <p><?php echo $user_stats['correct_answers'] ?? 0; ?> correct</p>
                </div>
                <span class="act-icon">✅</span>
            </div>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px;">
                <div class="act-info">
                    <h3>Accuracy</h3>
                    <p><?php echo round($user_stats['accuracy'] ?? 0, 1); ?>%</p>
                </div>
                <span class="act-icon">🎯</span>
            </div>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 10px;">
                <div class="act-info">
                    <h3>Current Streak</h3>
                    <p><?php echo $user_data['currentStreak'] ?? 0; ?> days</p>
                </div>
                <span class="act-icon">🔥</span>
            </div>

            <div class="activity-card" style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 15px; margin-bottom: 20px;">
                <div class="act-info">
                    <h3>Best Streak</h3>
                    <p><?php echo $user_data['bestStreak'] ?? 0; ?> days</p>
                </div>
                <span class="act-icon">⭐</span>
            </div>

            <button class="btn-back" onclick="showScreen('screen-home')" style="margin-bottom: 20px;">BACK</button>
        </div>
    </div>

    <!-- =============== CATEGORIES SCREEN =============== -->
    <div id="screen-categories" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">Choose Category</h2>

            <div style="width: 90%; max-height: 600px; overflow-y: auto;">
                <button class="cat-btn" onclick="goToDifficulty('Nature')" style="margin-bottom: 10px;">🌿 Nature</button>
                <button class="cat-btn" onclick="goToDifficulty('Food')" style="margin-bottom: 10px;">🍔 Food</button>
                <button class="cat-btn" onclick="goToDifficulty('School')" style="margin-bottom: 10px;">📚 School</button>
                <button class="cat-btn" onclick="goToDifficulty('Business')" style="margin-bottom: 10px;">💼 Business</button>
                <button class="cat-btn" onclick="goToDifficulty('Travel')" style="margin-bottom: 10px;">✈️ Travel</button>
                <button class="cat-btn" onclick="goToDifficulty('Emotions')" style="margin-bottom: 10px;">😊 Emotions</button>
            </div>

            <button class="btn-back" onclick="showScreen('screen-home')" style="margin-top: 20px;">BACK</button>
        </div>
    </div>

    <!-- =============== DIFFICULTY SCREEN =============== -->
    <div id="screen-difficulty" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">Select Difficulty</h2>
            <p style="color: white; font-size: 14px; text-align: center; margin-bottom: 20px;">Each quiz is 10 minutes</p>

            <div class="difficulty-options">
                <button class="diff-btn easy" onclick="startQuiz('Beginner')" style="cursor: pointer;">
                    <span style="font-size: 20px; margin-right: 10px;">🟢</span> Beginner (10 items)
                </button>
                <button class="diff-btn medium" onclick="startQuiz('Intermediate')" style="cursor: pointer;">
                    <span style="font-size: 20px; margin-right: 10px;">🟡</span> Intermediate (15 items)
                </button>
                <button class="diff-btn hard" onclick="startQuiz('Advanced')" style="cursor: pointer;">
                    <span style="font-size: 20px; margin-right: 10px;">🔴</span> Advanced (25 items)
                </button>
            </div>

            <button class="btn-back" onclick="showScreen('screen-categories')" style="margin-top: 20px;">BACK</button>
        </div>
    </div>

</div>

<script src="script.js"></script>

<?php
if (isset($_SESSION['user_id'])) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showScreen('screen-home');
        });
    </script>
    ";
}
?>

</body>
</html>
