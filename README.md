# VocabQuest - Setup and Installation Guide

## 📱 Project Overview
VocabQuest is a mobile-friendly vocabulary learning app built with PHP, CSS, and JavaScript. It features interactive quizzes, leaderboards, user profiles, and streak tracking.

## 🚀 Quick Setup Instructions

### Step 1: Import Database
1. Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`)
2. Create a new database named `vocabquest_db`
3. Go to the **Import** tab
4. Upload the file: `vocabquest_db.sql`
5. Click **Import**

### Step 2: Configure Connection
- The app is pre-configured to use:
  - **Host**: localhost
  - **User**: root
  - **Password**: (empty)
  - **Database**: vocabquest_db
- If your setup is different, edit `db_config.php`

### Step 3: Start the App
1. Make sure XAMPP Apache is running
2. Navigate to: `http://localhost/VocabQuest/`
3. You should see the VocabQuest splash screen

## 📂 Project Structure

```
VocabQuest/
├── index.php              # Main application file (all screens)
├── auth.php               # Login/Register handler
├── quiz.php               # Quiz page with timer
├── results.php            # Quiz results page
├── profile.php            # User profile page
├── leaderboard.php        # Global leaderboard
├── dashboard.php          # User dashboard
├── finish_quiz.php        # Save quiz results
├── logout.php             # Logout handler
├── db_config.php          # Database configuration
├── style.css              # Main stylesheet
├── script.js              # JavaScript functionality
├── vocabquest_db.sql      # Database schema
└── backR0.jpg             # Background image (required)
```

## 🎮 Features

### ✅ Authentication
- User registration and login
- Secure password hashing
- Session management
- Profile viewing

### 📚 Quiz System
- **6 Categories**: Nature, Food, School, Business, Travel, Emotions
- **3 Difficulty Levels**:
  - Beginner: 10 questions
  - Intermediate: 15 questions
  - Advanced: 25 questions
- **10-minute timer** for all quizzes
- **Countdown display** (changes color: blue → orange → red)
- **Question shuffling** (questions and answers are randomized)

### 🏆 Gamification
- **Streaks**: Current and best streaks
- **Points**: Score accumulation
- **Leaderboard**: Global rankings
- **Statistics**: Accuracy, questions answered, correct answers

### 📊 Dashboard
- View all statistics
- Quiz history (recent activity)
- Personal best scores
- Accuracy percentage

## 🔧 Customization

### Change Background Image
1. Replace `backR0.jpg` with your image
2. The CSS is already configured to use it

### Add More Questions
1. Edit `vocabquest_db.sql` to add more quiz questions
2. Run the import again, or use phpMyAdmin to add them manually

### Modify Quiz Time
Edit `quiz.php`:
```php
$quiz_time = 600; // Change to desired seconds (currently 10 minutes)
```

### Change Difficulty Settings
Edit `quiz.php`:
```php
// Modify these numbers to change questions per difficulty
$num_questions = 10;   // Beginner
$num_questions = 15;   // Intermediate
$num_questions = 25;   // Advanced
```

## 🎨 Color Scheme
- **Primary Yellow**: #e9ff00
- **Success Green**: #4CAF50
- **Warning Orange**: #FF9800
- **Error Red**: #f44336
- **Info Blue**: #2196F3
- **Dark Background**: #1a1a1a

## 🔐 Security Notes
- Passwords are hashed using PHP's `password_hash()` function
- Use prepared statements for all database queries (already implemented)
- Session-based authentication is used throughout
- Always validate and sanitize user input

## 📱 Responsive Design
- Mobile-first approach
- iPhone screen frame display (440px width)
- Adjusts to mobile screens automatically
- Touch-friendly buttons and interactions

## 🐛 Troubleshooting

### "Connection Failed" Error
- Check if XAMPP MySQL is running
- Verify database name in `db_config.php`
- Ensure `vocabquest_db` database exists

### Quiz Timer Not Working
- Check browser console for JavaScript errors
- Ensure `script.js` is properly linked in `quiz.php`

### Login Issues
- Clear browser cookies/cache
- Verify user exists in database
- Check password is correct

### Images Not Loading
- Ensure `backR0.jpg` is in the project root directory
- Check file path in CSS/HTML

## 📝 Test Account
After importing the database, create an account:
1. Click "Create Account" on splash screen
2. Enter your details
3. You're ready to start taking quizzes!

## 🚀 Future Enhancements
- Daily challenges
- Word pronunciation
- Offline mode
- Social sharing
- Progress tracking charts
- Custom word lists
- Mobile app version

## 📞 Support
For issues or questions:
1. Check the troubleshooting section above
2. Review browser console for errors
3. Verify all files are in the correct directory
4. Re-import the database if needed

---

**Version**: 1.0  
**Last Updated**: 2026  
**License**: Open Source
