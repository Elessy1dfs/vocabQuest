<?php
session_start();
include 'db_config.php';

$user_logged_in = isset($_SESSION['user_id']) ? true : false;
$fullname = $user_logged_in ? $_SESSION['fullname'] : '';
$user_id = $user_logged_in ? $_SESSION['user_id'] : '';

// Fetch user stats if logged in
$user_stats = null;
$user_data = null;
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
            <div class="splash-container">
                <img src="back0.jpg" alt="VocabQuest Logo" class="splash-logo">
                <h1 class="logo-text">VocabQuest</h1>
                <p class="subtitle">Master new vocabulary through interactive quizzes and challenges!</p>
                <button class="btn-main" onclick="showScreen('screen-login')">GET STARTED</button>
            </div>
        </div>
    </div>

    <!-- =============== LOGIN SCREEN =============== -->
    <div id="screen-login" class="screen hidden">
        <div class="content-overlay">
            <div class="auth-container">
                <img src="back0.jpg" alt="VocabQuest Logo" class="auth-logo">
                <h1 class="logo-text">VocabQuest</h1>
                <h2 class="title" style="color: white; margin-top: 20px;">Login</h2>
                <form action="auth.php" method="POST" class="auth-form">
                    <input type="hidden" name="action" value="login">
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn-main">LOGIN</button>
                </form>
                <p class="footer-text">
                    New student? <span onclick="showScreen('screen-register')" style="color: #e9ff00; cursor: pointer;">Create Account</span>
                </p>
                <button class="btn-back" onclick="showScreen('screen-splash')">BACK</button>
            </div>
        </div>
    </div>

    <!-- =============== REGISTER SCREEN =============== -->
    <div id="screen-register" class="screen hidden">
        <div class="content-overlay">
            <div class="auth-container">
                <img src="back0.jpg" alt="VocabQuest Logo" class="auth-logo">
                <h1 class="logo-text">VocabQuest</h1>
                <h2 class="title" style="color: white; margin-top: 20px;">Create Account</h2>
                <form action="auth.php" method="POST" class="auth-form">
                    <input type="hidden" name="action" value="register">
                    <input type="text" name="fullname" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn-main">SIGN UP</button>
                </form>
                <p class="footer-text">
                    Already have an account? <span onclick="showScreen('screen-login')" style="color: #e9ff00; cursor: pointer;">Login</span>
                </p>
                <button class="btn-back" onclick="showScreen('screen-splash')">BACK</button>
            </div>
        </div>
    </div>

    <!-- =============== HOME SCREEN =============== -->
    <div id="screen-home" class="screen <?php echo !$user_logged_in ? 'hidden' : ''; ?>">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00; margin-bottom: 20px;">Welcome, <?php echo htmlspecialchars($fullname); ?>!</h2>
            
            <div class="stats-box-home">
                <div class="stat-item">
                    <p class="stat-label">Total Score</p>
                    <p class="stat-value"><?php echo $user_data['totalScore'] ?? 0; ?></p>
                </div>
                <div class="stat-item">
                    <p class="stat-label">Current Streak</p>
                    <p class="stat-value"><?php echo $user_data['currentStreak'] ?? 0; ?> 🔥</p>
                </div>
            </div>

            <div class="menu-card" onclick="goToDifficulty('Nature')">
                <span class="menu-icon">🎯</span>
                <span class="menu-text">Start Quiz</span>
            </div>

            <div class="menu-card" onclick="showScreen('screen-dashboard')">
                <span class="menu-icon">📊</span>
                <span class="menu-text">Dashboard</span>
            </div>

            <div class="menu-card" onclick="goToLeaderboard()">
                <span class="menu-icon">🏆</span>
                <span class="menu-text">Leaderboard</span>
            </div>

            <div class="menu-card" onclick="goToProfile()">
                <span class="menu-icon">👤</span>
                <span class="menu-text">Profile</span>
            </div>

            <div class="menu-card" onclick="logout()">
                <span class="menu-icon">🚪</span>
                <span class="menu-text">Logout</span>
            </div>
        </div>
    </div>

    <!-- =============== DASHBOARD SCREEN =============== -->
    <div id="screen-dashboard" class="screen hidden">
        <div class="content-overlay dashboard-scroll">
            <h2 class="title" style="color: #e9ff00; margin-bottom: 25px;">Dashboard</h2>

            <!-- STATISTICS SECTION -->
            <div class="dashboard-section">
                <h3 class="section-title">📊 Your Statistics</h3>
                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <span class="dash-icon">📋</span>
                        <p class="dash-label">Total Quizzes</p>
                        <p class="dash-value"><?php echo $user_stats['total_quizzes'] ?? 0; ?></p>
                    </div>
                    <div class="dashboard-card">
                        <span class="dash-icon">❓</span>
                        <p class="dash-label">Questions</p>
                        <p class="dash-value"><?php echo $user_stats['total_questions_answered'] ?? 0; ?></p>
                    </div>
                    <div class="dashboard-card">
                        <span class="dash-icon">✅</span>
                        <p class="dash-label">Correct</p>
                        <p class="dash-value"><?php echo intval($user_stats['correct_answers'] ?? 0); ?></p>
                    </div>
                    <div class="dashboard-card">
                        <span class="dash-icon">🎯</span>
                        <p class="dash-label">Accuracy</p>
                        <p class="dash-value"><?php echo round($user_stats['accuracy'] ?? 0, 1); ?>%</p>
                    </div>
                    <div class="dashboard-card">
                        <span class="dash-icon">🔥</span>
                        <p class="dash-label">Current Streak</p>
                        <p class="dash-value"><?php echo $user_data['currentStreak'] ?? 0; ?></p>
                    </div>
                    <div class="dashboard-card">
                        <span class="dash-icon">⭐</span>
                        <p class="dash-label">Best Streak</p>
                        <p class="dash-value"><?php echo $user_data['bestStreak'] ?? 0; ?></p>
                    </div>
                </div>
            </div>

            <!-- LEARNING AREAS SECTION -->
            <div class="dashboard-section">
                <h3 class="section-title">📚 Learning Areas</h3>
                <div class="categories-list">
                    <div class="category-item" onclick="goToDifficulty('Nature')">
                        <span class="cat-icon">🌿</span>
                        <p class="cat-name">Nature</p>
                    </div>
                    <div class="category-item" onclick="goToDifficulty('Food')">
                        <span class="cat-icon">🍔</span>
                        <p class="cat-name">Food</p>
                    </div>
                    <div class="category-item" onclick="goToDifficulty('School')">
                        <span class="cat-icon">📚</span>
                        <p class="cat-name">School</p>
                    </div>
                    <div class="category-item" onclick="goToDifficulty('Business')">
                        <span class="cat-icon">💼</span>
                        <p class="cat-name">Business</p>
                    </div>
                    <div class="category-item" onclick="goToDifficulty('Travel')">
                        <span class="cat-icon">✈️</span>
                        <p class="cat-name">Travel</p>
                    </div>
                    <div class="category-item" onclick="goToDifficulty('Emotions')">
                        <span class="cat-icon">😊</span>
                        <p class="cat-name">Emotions</p>
                    </div>
                </div>
            </div>

            <!-- RECOMMENDATIONS SECTION -->
            <div class="dashboard-section">
                <h3 class="section-title">💡 Recommendations</h3>
                <div class="recommendation-card">
                    <span class="rec-icon">🎯</span>
                    <div class="rec-content">
                        <p class="rec-title">Practice Daily</p>
                        <p class="rec-text">Build consistency and improve your vocabulary faster</p>
                    </div>
                </div>
                <div class="recommendation-card">
                    <span class="rec-icon">📈</span>
                    <div class="rec-content">
                        <p class="rec-title">Focus on Accuracy</p>
                        <p class="rec-text">Try harder difficulties to challenge yourself more</p>
                    </div>
                </div>
            </div>

            <button class="btn-back" onclick="showScreen('screen-home')" style="margin-bottom: 30px;">BACK TO HOME</button>
        </div>
    </div>

    <!-- =============== CATEGORIES SCREEN =============== -->
    <div id="screen-categories" class="screen hidden">
        <div class="content-overlay">
            <h2 class="title" style="color: #e9ff00;">Choose Category</h2>

            <div style="width: 90%; max-height: 600px; overflow-y: auto;">
                <button class="cat-btn" onclick="goToDifficulty('Nature')">🌿 Nature</button>
                <button class="cat-btn" onclick="goToDifficulty('Food')">🍔 Food</button>
                <button class="cat-btn" onclick="goToDifficulty('School')">📚 School</button>
                <button class="cat-btn" onclick="goToDifficulty('Business')">💼 Business</button>
                <button class="cat-btn" onclick="goToDifficulty('Travel')">✈️ Travel</button>
                <button class="cat-btn" onclick="goToDifficulty('Emotions')">😊 Emotions</button>
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
                <button class="diff-btn easy" onclick="startQuiz('Beginner')">
                    <span style="font-size: 20px; margin-right: 10px;">🟢</span> Beginner (10 items)
                </button>
                <button class="diff-btn medium" onclick="startQuiz('Intermediate')">
                    <span style="font-size: 20px; margin-right: 10px;">🟡</span> Intermediate (15 items)
                </button>
                <button class="diff-btn hard" onclick="startQuiz('Advanced')">
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
