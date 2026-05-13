<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $score = isset($_POST['score']) ? intval($_POST['score']) : 0;
    $total_items = isset($_POST['total_items']) ? intval($_POST['total_items']) : 0;
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : '';
    $difficulty = isset($_POST['difficulty']) ? mysqli_real_escape_string($conn, $_POST['difficulty']) : '';
    $time_taken = isset($_POST['time_taken']) ? intval($_POST['time_taken']) : 0;
    $accuracy = isset($_POST['accuracy']) ? floatval($_POST['accuracy']) : 0;

    // Insert quiz result
    $insert_query = "INSERT INTO quiz_results (user_id, category, difficulty, score, total_items, time_taken) 
                     VALUES ($user_id, '$category', '$difficulty', $score, $total_items, $time_taken)";
    
    if (mysqli_query($conn, $insert_query)) {
        // Update user's total score
        $update_score_query = "UPDATE users SET totalScore = totalScore + $score WHERE id = $user_id";
        mysqli_query($conn, $update_score_query);

        // Update user statistics
        $get_stats_query = "SELECT * FROM user_stats WHERE user_id = $user_id";
        $stats_result = mysqli_query($conn, $get_stats_query);
        
        if (mysqli_num_rows($stats_result) > 0) {
            $stats = mysqli_fetch_assoc($stats_result);
            $new_total_questions = $stats['total_questions_answered'] + $total_items;
            $new_correct_answers = $stats['correct_answers'] + ($score / 10);
            $new_accuracy = ($new_correct_answers / $new_total_questions) * 100;

            $update_stats_query = "UPDATE user_stats SET 
                                   total_quizzes = total_quizzes + 1,
                                   total_questions_answered = $new_total_questions,
                                   correct_answers = $new_correct_answers,
                                   accuracy = $new_accuracy
                                   WHERE user_id = $user_id";
            mysqli_query($conn, $update_stats_query);
        }

        // Update streak logic (simple version - increment if score is good)
        if ($score >= (($total_items / 2) * 10)) { // 50% or higher
            $update_streak_query = "UPDATE users SET currentStreak = currentStreak + 1 WHERE id = $user_id";
            mysqli_query($conn, $update_streak_query);

            // Update best streak if needed
            $check_best_query = "SELECT currentStreak, bestStreak FROM users WHERE id = $user_id";
            $check_best_result = mysqli_query($conn, $check_best_query);
            $user_data = mysqli_fetch_assoc($check_best_result);

            if ($user_data['currentStreak'] > $user_data['bestStreak']) {
                $update_best_query = "UPDATE users SET bestStreak = currentStreak WHERE id = $user_id";
                mysqli_query($conn, $update_best_query);
            }
        } else {
            $reset_streak_query = "UPDATE users SET currentStreak = 0 WHERE id = $user_id";
            mysqli_query($conn, $reset_streak_query);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save quiz result']);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
