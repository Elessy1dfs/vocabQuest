// VocabQuest Main JavaScript File

// Show/Hide screens
function showScreen(screenId) {
    // Hide all screens
    const screens = document.querySelectorAll('.screen');
    screens.forEach(screen => {
        screen.classList.add('hidden');
    });

    // Show selected screen
    const selectedScreen = document.getElementById(screenId);
    if (selectedScreen) {
        selectedScreen.classList.remove('hidden');
    }

    // Save current screen to session storage
    sessionStorage.setItem('currentScreen', screenId);
}

// Navigation functions
function goToLogin() {
    showScreen('screen-login');
}

function goToRegister() {
    showScreen('screen-register');
}

function goToHome() {
    showScreen('screen-home');
}

function goToCategories() {
    showScreen('screen-categories');
}

function goToDifficulty(category) {
    const difficulty_screen = document.getElementById('screen-difficulty');
    if (difficulty_screen) {
        // Store selected category for difficulty selection
        sessionStorage.setItem('selectedCategory', category);
    }
    showScreen('screen-difficulty');
}

// Start quiz with selected difficulty
function startQuiz(difficulty) {
    const category = sessionStorage.getItem('selectedCategory') || 'Nature';
    const difficultyMap = {
        'Beginner': 'Beginner',
        'Intermediate': 'Intermediate',
        'Advanced': 'Advanced'
    };
    
    const selectedDifficulty = difficultyMap[difficulty] || 'Beginner';
    window.location.href = `quiz.php?category=${encodeURIComponent(category)}&difficulty=${encodeURIComponent(selectedDifficulty)}`;
}

// Go to dashboard
function goToDashboard() {
    showScreen('screen-dashboard');
}

// Go to profile
function goToProfile() {
    window.location.href = 'profile.php';
}

// Go to leaderboard
function goToLeaderboard() {
    window.location.href = 'leaderboard.php';
}

// Logout
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'logout.php';
    }
}

// Initialize app
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is logged in
    const splash = document.getElementById('screen-splash');
    const home = document.getElementById('screen-home');
    
    if (home && !sessionStorage.getItem('user_logged_in')) {
        // User is logged in on server-side, but show home on front-end
        // This is handled by PHP in index.php
    }
});

// Utility functions
function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${mins}:${secs.toString().padStart(2, '0')}`;
}

function getCurrentDateFormatted() {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date().toLocaleDateString('en-US', options);
}
