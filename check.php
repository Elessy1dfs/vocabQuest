<?php
/**
 * VocabQuest - System Check
 * This file verifies that all components are properly configured
 * Access it at: http://localhost/VocabQuest/check.php
 */

session_start();
include 'db_config.php';

$checks = array();

// 1. Database Connection
try {
    if ($conn->connect_error) {
        $checks['Database Connection'] = array('status' => false, 'message' => 'Connection Failed: ' . $conn->connect_error);
    } else {
        $checks['Database Connection'] = array('status' => true, 'message' => 'Connected Successfully');
    }
} catch (Exception $e) {
    $checks['Database Connection'] = array('status' => false, 'message' => $e->getMessage());
}

// 2. Database Tables
$required_tables = array('users', 'categories', 'questions', 'quiz_results', 'user_stats');
foreach ($required_tables as $table) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    $exists = mysqli_num_rows($result) > 0;
    $checks['Table: ' . $table] = array(
        'status' => $exists,
        'message' => $exists ? 'Found' : 'Missing'
    );
}

// 3. File Checks
$required_files = array(
    'index.php' => 'Main Application',
    'auth.php' => 'Authentication Handler',
    'quiz.php' => 'Quiz Module',
    'results.php' => 'Results Page',
    'profile.php' => 'Profile Page',
    'leaderboard.php' => 'Leaderboard',
    'dashboard.php' => 'Dashboard',
    'finish_quiz.php' => 'Quiz Finish Handler',
    'logout.php' => 'Logout Handler',
    'db_config.php' => 'Database Configuration',
    'style.css' => 'Stylesheet',
    'script.js' => 'JavaScript'
);

foreach ($required_files as $file => $description) {
    $path = __DIR__ . '/' . $file;
    $exists = file_exists($path);
    $checks[$description . ' (' . $file . ')'] = array(
        'status' => $exists,
        'message' => $exists ? 'Found' : 'Missing'
    );
}

// 4. Sample Data Check
$question_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM questions");
$question_data = mysqli_fetch_assoc($question_count);
$checks['Sample Questions'] = array(
    'status' => $question_data['count'] > 0,
    'message' => $question_data['count'] . ' questions found'
);

$category_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM categories");
$category_data = mysqli_fetch_assoc($category_count);
$checks['Categories'] = array(
    'status' => $category_data['count'] > 0,
    'message' => $category_data['count'] . ' categories found'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VocabQuest - System Check</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #999;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .check-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            background: #f5f5f5;
            border-left: 4px solid #ccc;
        }

        .check-item.success {
            background: #e8f5e9;
            border-left-color: #4CAF50;
        }

        .check-item.error {
            background: #ffebee;
            border-left-color: #f44336;
        }

        .check-icon {
            font-size: 24px;
            margin-right: 15px;
            width: 30px;
        }

        .check-content {
            flex: 1;
        }

        .check-label {
            color: #333;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .check-message {
            color: #999;
            font-size: 12px;
        }

        .summary {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            text-align: center;
        }

        .summary-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .summary-status {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }

        .summary-status.warning {
            color: #FF9800;
        }

        .summary-status.error {
            color: #f44336;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: #efefef;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 VocabQuest System Check</h1>
        <p class="subtitle">Verifying all components are properly configured</p>

        <?php
        $passed = 0;
        $failed = 0;

        foreach ($checks as $check_name => $check_result) {
            $status_class = $check_result['status'] ? 'success' : 'error';
            $icon = $check_result['status'] ? '✅' : '❌';

            if ($check_result['status']) {
                $passed++;
            } else {
                $failed++;
            }

            echo "<div class='check-item {$status_class}'>";
            echo "<div class='check-icon'>{$icon}</div>";
            echo "<div class='check-content'>";
            echo "<div class='check-label'>{$check_name}</div>";
            echo "<div class='check-message'>{$check_result['message']}</div>";
            echo "</div>";
            echo "</div>";
        }

        $total = $passed + $failed;
        $percentage = round(($passed / $total) * 100);
        $status_class = $percentage === 100 ? '' : ($percentage >= 80 ? 'warning' : 'error');
        $status_icon = $percentage === 100 ? '✅' : '⚠️';
        ?>

        <div class="summary">
            <p class="summary-text">System Health Status</p>
            <div class="summary-status <?php echo $status_class; ?>">
                <?php echo $status_icon; ?> <?php echo $percentage; ?>% Operational
            </div>
            <p class="summary-text" style="margin-top: 10px; font-size: 12px;">
                <?php echo $passed; ?> checks passed, <?php echo $failed; ?> checks failed
            </p>

            <?php if ($percentage === 100): ?>
                <p style="color: #4CAF50; font-weight: bold; margin-top: 15px;">
                    ✅ Everything is ready! You can start using VocabQuest now.
                </p>
            <?php elseif ($failed > 0): ?>
                <p style="color: #f44336; font-weight: bold; margin-top: 15px;">
                    ⚠️ Some components are missing. Please review the errors above.
                </p>
            <?php endif; ?>

            <div class="actions">
                <a href="index.php" class="btn btn-primary">🚀 Launch App</a>
                <a href="check.php" class="btn btn-secondary">🔄 Refresh Check</a>
            </div>
        </div>
    </div>
</body>
</html>
