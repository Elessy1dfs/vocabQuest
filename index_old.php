<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>VocabQuest</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="iphone-screen">

    <!-- SPLASH SCREEN -->
    <div id="screen-splash" class="screen">

        <div class="content-overlay">

            <h1 class="logo-text">VocabQuest</h1>

            <p class="subtitle">
                Learn English Through Games
            </p>

            <button class="btn-main"
                    onclick="showScreen('screen-login')">

                START
            </button>

        </div>
    </div>

    <!-- LOGIN -->
    <div id="screen-login" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Login</h2>

            <form action="auth.php" method="POST">

                <input type="email"
                       name="email"
                       placeholder="Email"
                       required>

                <input type="password"
                       name="password"
                       id="loginPass"
                       placeholder="Password"
                       required>

                <button type="button"
                        class="small-btn"
                        onclick="togglePassword('loginPass')">

                    Show Password
                </button>

                <button type="submit"
                        name="login"
                        class="btn-main">

                    Login
                </button>

            </form>

            <p class="link-text"
               onclick="showScreen('screen-forgot')">

                Forgot Password?
            </p>

            <p class="footer-text">

                No account?

                <span onclick="showScreen('screen-register')">
                    Register
                </span>

            </p>

        </div>
    </div>

    <!-- REGISTER -->
    <div id="screen-register" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Register</h2>

            <form action="auth.php" method="POST">

                <input type="text"
                       name="fullname"
                       placeholder="Full Name"
                       required>

                <input type="email"
                       name="email"
                       placeholder="Email"
                       required>

                <input type="password"
                       name="password"
                       id="registerPass"
                       placeholder="Password"
                       required>

                <button type="button"
                        class="small-btn"
                        onclick="togglePassword('registerPass')">

                    Show Password
                </button>

                <button type="submit"
                        name="register"
                        class="btn-main">

                    Register
                </button>

            </form>

            <button class="btn-back"
                    onclick="showScreen('screen-login')">

                Back
            </button>

        </div>
    </div>

    <!-- FORGOT PASSWORD -->
    <div id="screen-forgot" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Forgot Password</h2>

            <input type="email"
                   placeholder="Enter Email">

            <button class="btn-main"
                    onclick="showScreen('screen-recovery')">

                Send Recovery Code
            </button>

            <button class="btn-back"
                    onclick="showScreen('screen-login')">

                Back
            </button>

        </div>
    </div>

    <!-- RECOVERY -->
    <div id="screen-recovery" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Account Recovery</h2>

            <div class="code-inputs">

                <input type="text"
                       maxlength="1"
                       class="small-input">

                <input type="text"
                       maxlength="1"
                       class="small-input">

                <input type="text"
                       maxlength="1"
                       class="small-input">

                <input type="text"
                       maxlength="1"
                       class="small-input">

            </div>

            <button class="btn-main"
                    onclick="showScreen('screen-login')">

                Verify
            </button>

        </div>
    </div>

    <!-- HOME -->
    <div id="screen-home" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">

                Welcome

                <?php echo $_SESSION['user_name'] ?? 'Player'; ?>

            </h2>

            <div class="stats-box">

                ⭐ Score:
                <?php echo $_SESSION['score'] ?? 0; ?>

            </div>

            <div class="menu-card"
                 onclick="showScreen('screen-dashboard')">

                <span class="menu-icon">📊</span>

                <span class="menu-text">
                    Dashboard
                </span>

            </div>

            <div class="menu-card">

                <span class="menu-icon">🤖</span>

                <span class="menu-text">
                    Recommendation
                </span>

            </div>

            <div class="menu-card">

                <span class="menu-icon">📈</span>

                <span class="menu-text">
                    Progress
                </span>

            </div>

            <div class="menu-card">

                <span class="menu-icon">⚙️</span>

                <span class="menu-text">
                    Account Settings
                </span>

            </div>

            <div class="menu-card"
                 onclick="window.location.href='logout.php'">

                <span class="menu-icon">🚪</span>

                <span class="menu-text">
                    Logout
                </span>

            </div>

        </div>
    </div>

    <!-- DASHBOARD -->
    <div id="screen-dashboard" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Dashboard</h2>

            <div class="activity-card"
                 onclick="showScreen('screen-categories')">

                <div class="act-info">

                    <h3>Categories</h3>

                    <p>Practice by category</p>

                </div>

                <span class="act-icon">📂</span>

            </div>

            <div class="activity-card"
                 onclick="showDifficulty('Daily Challenges')">

                <div class="act-info">

                    <h3>Daily Challenges</h3>

                    <p>Daily missions</p>

                </div>

                <span class="act-icon">🔥</span>

            </div>

            <div class="activity-card"
                 onclick="showDifficulty('Practice Scenario')">

                <div class="act-info">

                    <h3>Practice Scenario</h3>

                    <p>Conversation practice</p>

                </div>

                <span class="act-icon">🎭</span>

            </div>

            <div class="activity-card"
                 onclick="showDifficulty('Word Matching')">

                <div class="act-info">

                    <h3>Word Matching Challenge</h3>

                    <p>Match the correct words</p>

                </div>

                <span class="act-icon">🧩</span>

            </div>

            <div class="activity-card"
                 onclick="showDifficulty('Vocabulary Quiz')">

                <div class="act-info">

                    <h3>Vocabulary Quizzes</h3>

                    <p>Test your vocabulary</p>

                </div>

                <span class="act-icon">📝</span>

            </div>

            <div class="activity-card"
                 onclick="showDifficulty('Pronunciation')">

                <div class="act-info">

                    <h3>Practice Pronunciation</h3>

                    <p>Speak correctly</p>

                </div>

                <span class="act-icon">🗣️</span>

            </div>

            <button class="btn-back"
                    onclick="showScreen('screen-home')">

                Back
            </button>

        </div>
    </div>

    <!-- CATEGORY -->
    <div id="screen-categories" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">Categories</h2>

            <button class="cat-btn"
                    onclick="showDifficulty('Nature')">

                🌿 Nature
            </button>

            <button class="cat-btn"
                    onclick="showDifficulty('Food')">

                🍔 Food
            </button>

            <button class="cat-btn"
                    onclick="showDifficulty('School')">

                🏫 School
            </button>

            <button class="cat-btn"
                    onclick="showDifficulty('Business')">

                💼 Business
            </button>

            <button class="cat-btn"
                    onclick="showDifficulty('Travel')">

                ✈️ Travel
            </button>

            <button class="cat-btn"
                    onclick="showDifficulty('Emotions')">

                🎭 Emotions
            </button>

            <button class="btn-back"
                    onclick="showScreen('screen-dashboard')">

                Back
            </button>

        </div>
    </div>

    <!-- DIFFICULTY -->
    <div id="screen-difficulty" class="screen hidden">

        <div class="content-overlay">

            <h2 class="title"
                id="diff-title">

                Difficulty
            </h2>

            <div class="difficulty-options">

                <button class="diff-btn easy"
                        onclick="startQuiz('easy')">

                    Easy
                </button>

                <button class="diff-btn medium"
                        onclick="startQuiz('medium')">

                    Medium
                </button>

                <button class="diff-btn hard"
                        onclick="startQuiz('hard')">

                    Hard
                </button>

                <button class="diff-btn advanced"
                        onclick="startQuiz('advanced')">

                    Advanced
                </button>

            </div>

            <button class="btn-back"
                    onclick="showScreen('screen-dashboard')">

                Cancel
            </button>

        </div>
    </div>

    <!-- QUIZ -->
    <div id="screen-quiz"
         class="screen hidden">

        <div class="content-overlay">

            <h2 class="title">
                Vocabulary Quiz
            </h2>

            <div class="timer-box">

                ⏰ Time Left:
                <span id="timer">10:00</span>

            </div>

            <div class="stats-box">

                Question:
                <span id="question-count"></span>

            </div>

            <div class="quiz-box">

                <h3 id="question"></h3>

            </div>

            <div id="answers"></div>

        </div>
    </div>

</div>

<script src="script.js"></script>

<?php

if(isset($_SESSION['user_id'])) {

    echo "
    <script>
        showScreen('screen-home');
    </script>
    ";
}

?>

</body>
</html>