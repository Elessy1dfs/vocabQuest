<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : 'Nature';
$difficulty = isset($_GET['difficulty']) ? mysqli_real_escape_string($conn, $_GET['difficulty']) : 'Beginner';

// Determine number of questions based on difficulty
$num_questions = 10; // Default
if ($difficulty == 'Intermediate') {
    $num_questions = 15;
} elseif ($difficulty == 'Advanced') {
    $num_questions = 25;
}

// Quiz time is always 10 minutes (600 seconds)
$quiz_time = 600;

// Fetch random questions for the selected category and difficulty
$query = "SELECT * FROM questions WHERE category = '$category' AND difficulty = '$difficulty' ORDER BY RAND() LIMIT $num_questions";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// If not enough questions of this difficulty, fill with other difficulties
if (count($questions) < $num_questions) {
    $additional_needed = $num_questions - count($questions);
    $additional_query = "SELECT * FROM questions WHERE category = '$category' AND difficulty != '$difficulty' ORDER BY RAND() LIMIT $additional_needed";
    $additional_result = mysqli_query($conn, $additional_query);
    $additional_questions = mysqli_fetch_all($additional_result, MYSQLI_ASSOC);
    $questions = array_merge($questions, $additional_questions);
}

// Shuffle questions
shuffle($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - VocabQuest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .timer-display {
            background: rgba(255,255,255,0.95);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            text-align: center;
            width: 90%;
        }

        .timer-text {
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .timer-countdown {
            color: #2196F3;
            font-size: 32px;
            font-weight: bold;
            font-family: monospace;
        }

        .timer-countdown.warning {
            color: #FF9800;
        }

        .timer-countdown.danger {
            color: #f44336;
        }

        .progress-bar {
            background: rgba(200, 200, 200, 0.5);
            height: 6px;
            border-radius: 3px;
            margin-bottom: 15px;
            overflow: hidden;
            width: 90%;
        }

        .progress-fill {
            background: #e9ff00;
            height: 100%;
            transition: width 0.3s ease;
        }

        .question-container {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 20px;
            width: 90%;
            margin-bottom: 15px;
        }

        .question-text {
            color: #333;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .question-number {
            color: #999;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .answer-option {
            background: white;
            border: 2px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.2s ease;
            text-align: center;
            color: #333;
            font-size: 14px;
        }

        .answer-option:hover {
            background: #e9ff00;
            border-color: #e9ff00;
        }

        .answer-option.selected {
            background: #e9ff00;
            border-color: #e9ff00;
            color: #333;
        }

        .answer-option.correct {
            background: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }

        .answer-option.incorrect {
            background: #f44336;
            border-color: #f44336;
            color: white;
        }

        .submit-btn {
            width: 90%;
            padding: 15px;
            background: #e9ff00;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            transition: 0.2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body>
    <div class="iphone-screen">
        <div class="content-overlay" style="overflow-y: auto; padding-top: 20px;">
            <h2 class="title" style="color: #e9ff00; margin-bottom: 10px;"><?php echo ucfirst($category); ?></h2>
            <p style="color: white; font-size: 14px; text-align: center; margin-bottom: 20px;"><?php echo ucfirst($difficulty); ?> Difficulty - <?php echo count($questions); ?> Questions</p>

            <!-- Timer Display -->
            <div class="timer-display">
                <p class="timer-text">Time Remaining</p>
                <p class="timer-countdown" id="timerDisplay">10:00</p>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="progressBar" style="width: 0%"></div>
            </div>

            <!-- Question Container -->
            <div class="question-container">
                <p class="question-number">Question <span id="questionNumber">1</span> of <?php echo count($questions); ?></p>
                <p class="question-text" id="questionText">Loading...</p>

                <div id="answersContainer">
                    <!-- Answers will be inserted here by JavaScript -->
                </div>

                <button class="submit-btn" id="submitBtn" onclick="nextQuestion()" disabled>NEXT</button>
            </div>
        </div>
    </div>

    <script>
        // Quiz data from PHP
        const questionBank = <?php echo json_encode($questions); ?>;
        const quizTime = <?php echo $quiz_time; ?>; // 10 minutes in seconds
        let currentIdx = 0;
        let score = 0;
        let selectedAnswer = null;
        let timeRemaining = quizTime;
        let answered = false;
        let correctAnswersCount = 0;

        // Timer interval
        let timerInterval;

        // Start quiz
        function startQuiz() {
            loadQuestion();
            startTimer();
        }

        // Start timer
        function startTimer() {
            timerInterval = setInterval(updateTimer, 1000);
        }

        // Update timer display
        function updateTimer() {
            timeRemaining--;
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            const display = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            document.getElementById('timerDisplay').textContent = display;

            // Change color based on time
            const timerElement = document.getElementById('timerDisplay');
            if (timeRemaining <= 60) {
                timerElement.className = 'timer-countdown danger';
            } else if (timeRemaining <= 300) {
                timerElement.className = 'timer-countdown warning';
            }

            // End quiz if time runs out
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                finishQuiz();
            }
        }

        // Load question
        function loadQuestion() {
            if (currentIdx >= questionBank.length) {
                finishQuiz();
                return;
            }

            const q = questionBank[currentIdx];
            document.getElementById('questionText').textContent = q.question_text;
            document.getElementById('questionNumber').textContent = currentIdx + 1;

            // Create answer options
            const container = document.getElementById('answersContainer');
            container.innerHTML = '';

            const options = [
                { text: q.option_a, value: 'A' },
                { text: q.option_b, value: 'B' },
                { text: q.option_c, value: 'C' },
                { text: q.option_d, value: 'D' }
            ];

            // Shuffle options
            options.sort(() => Math.random() - 0.5);

            options.forEach(option => {
                const button = document.createElement('div');
                button.className = 'answer-option';
                button.textContent = option.text;
                button.onclick = () => selectAnswer(button, option.text);
                container.appendChild(button);
            });

            selectedAnswer = null;
            answered = false;
            document.getElementById('submitBtn').disabled = true;

            // Update progress bar
            const progress = ((currentIdx) / questionBank.length) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        // Select answer
        function selectAnswer(button, answer) {
            if (answered) return;

            // Remove previous selection
            document.querySelectorAll('.answer-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            button.classList.add('selected');
            selectedAnswer = answer;
            document.getElementById('submitBtn').disabled = false;
        }

        // Next question
        function nextQuestion() {
            if (!selectedAnswer && !answered) return;

            if (!answered) {
                // Check answer
                const q = questionBank[currentIdx];
                const buttons = document.querySelectorAll('.answer-option');

                answered = true;
                let answerCorrect = false;

                buttons.forEach(button => {
                    const buttonText = button.textContent;
                    if (buttonText === q.correct_answer) {
                        button.classList.add('correct');
                        if (buttonText === selectedAnswer) {
                            answerCorrect = true;
                            correctAnswersCount++;
                            score += 10;
                        }
                    } else if (buttonText === selectedAnswer) {
                        button.classList.add('incorrect');
                    }
                });

                document.getElementById('submitBtn').textContent = 'CONTINUE';
                document.getElementById('submitBtn').disabled = false;
            } else {
                // Move to next question
                currentIdx++;
                loadQuestion();
                document.getElementById('submitBtn').textContent = 'NEXT';
            }
        }

        // Finish quiz
        function finishQuiz() {
            clearInterval(timerInterval);

            const timeTaken = quizTime - timeRemaining;
            const accuracy = ((correctAnswersCount / questionBank.length) * 100).toFixed(1);

            // Send score to finish_quiz.php via AJAX
            const formData = new FormData();
            formData.append('score', correctAnswersCount * 10);
            formData.append('total_items', questionBank.length);
            formData.append('category', '<?php echo $category; ?>');
            formData.append('difficulty', '<?php echo $difficulty; ?>');
            formData.append('time_taken', timeTaken);
            formData.append('accuracy', accuracy);

            fetch('finish_quiz.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => {
                    window.location.href = 'results.php?score=' + correctAnswersCount + '&total=' + questionBank.length + '&category=<?php echo $category; ?>&difficulty=<?php echo $difficulty; ?>&time=' + timeTaken;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error finishing quiz');
                });
        }

        // Start quiz when page loads
        window.onload = startQuiz;
    </script>
</body>
</html>