<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // LOGIN
    if ($action == 'login') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['totalScore'] = $user['totalScore'];
                $_SESSION['currentStreak'] = $user['currentStreak'];
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php?error=Invalid password");
                exit();
            }
        } else {
            header("Location: login.php?error=Account not found");
            exit();
        }
    }

    // REGISTER
    if ($action == 'register') {
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $checkEmail);

        if (mysqli_num_rows($result) > 0) {
            header("Location: register.php?error=Email already registered");
            exit();
        } else {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (fullname, email, password, totalScore, currentStreak) 
                      VALUES ('$fullname', '$email', '$hashedPass', 0, 0)";

            if (mysqli_query($conn, $query)) {
                $user_id = mysqli_insert_id($conn);
                
                // Create user stats entry
                $stats_query = "INSERT INTO user_stats (user_id, total_quizzes, total_questions_answered, correct_answers, accuracy) 
                                VALUES ($user_id, 0, 0, 0, 0)";
                mysqli_query($conn, $stats_query);

                header("Location: register_success.php?name=" . urlencode($fullname));
                exit();
            } else {
                header("Location: register.php?error=Registration failed");
                exit();
            }
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
