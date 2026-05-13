-- VocabQuest Database Schema
-- Create Database
CREATE DATABASE IF NOT EXISTS vocabquest_db;
USE vocabquest_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    totalScore INT DEFAULT 0,
    currentStreak INT DEFAULT 0,
    bestStreak INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description VARCHAR(255)
);

-- Questions Table
CREATE TABLE IF NOT EXISTS questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    category VARCHAR(50),
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    difficulty VARCHAR(20) DEFAULT 'Beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Quiz Results Table
CREATE TABLE IF NOT EXISTS quiz_results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    category VARCHAR(50),
    difficulty VARCHAR(20),
    score INT,
    total_items INT,
    time_taken INT,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- User Statistics Table
CREATE TABLE IF NOT EXISTS user_stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    total_quizzes INT DEFAULT 0,
    total_questions_answered INT DEFAULT 0,
    correct_answers INT DEFAULT 0,
    accuracy FLOAT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert Categories
INSERT INTO categories (name, description) VALUES
('Nature', 'Words related to nature and environment'),
('Food', 'Culinary and food-related words'),
('School', 'Academic and school-related words'),
('Business', 'Business and professional words'),
('Travel', 'Travel and tourism-related words'),
('Emotions', 'Words describing feelings and emotions');

-- Insert Sample Questions for Nature Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(1, 'Nature', 'What does "Explore" mean?', 'To ignore something', 'To search and learn', 'To destroy something', 'To hide from something', 'To search and learn', 'Beginner'),
(1, 'Nature', 'Which word means a large natural elevation of land?', 'Valley', 'Mountain', 'Plain', 'Desert', 'Mountain', 'Beginner'),
(1, 'Nature', 'What is a synonym for "Lush"?', 'Dry', 'Green and full of vegetation', 'Rocky', 'Barren', 'Green and full of vegetation', 'Beginner'),
(1, 'Nature', 'What does "Cascade" refer to?', 'A small hill', 'A type of waterfall', 'A forest animal', 'A weather pattern', 'A type of waterfall', 'Intermediate'),
(1, 'Nature', 'Which term describes the variety of species in an ecosystem?', 'Monoculture', 'Biodiversity', 'Extinction', 'Evolution', 'Biodiversity', 'Intermediate'),
(1, 'Nature', 'What does "Perennial" mean in botany?', 'Lasting one year', 'Lasting multiple years', 'Growing underground', 'Blooming once', 'Lasting multiple years', 'Intermediate'),
(1, 'Nature', 'Define "Photosynthesis":', 'Process of eating', 'Process of moving', 'Process where plants convert light to energy', 'Process of reproduction', 'Process where plants convert light to energy', 'Advanced'),
(1, 'Nature', 'What is "Deforestation"?', 'Planting trees', 'Clearing forests for other uses', 'Growing new forests', 'Studying forests', 'Clearing forests for other uses', 'Advanced'),
(1, 'Nature', 'Which term refers to the transition between seasons?', 'Equinox', 'Solstice', 'Eclipse', 'Zenith', 'Equinox', 'Advanced'),
(1, 'Nature', 'What does "Ecosystem" mean?', 'A single organism', 'A community of organisms and their environment', 'A type of weather', 'A geographical location', 'A community of organisms and their environment', 'Advanced'),
(1, 'Nature', 'Define "Predator":', 'A plant-eating animal', 'An animal that hunts other animals', 'A type of bird', 'An extinct animal', 'An animal that hunts other animals', 'Beginner'),
(1, 'Nature', 'What does "Habitat" mean?', 'A type of clothing', 'The natural home of an organism', 'A building structure', 'A weather condition', 'The natural home of an organism', 'Beginner'),
(1, 'Nature', 'Which word means "adaptation to environmental changes"?', 'Evolution', 'Revolution', 'Dissolution', 'Devolution', 'Evolution', 'Intermediate'),
(1, 'Nature', 'What is a "Herbivore"?', 'An animal that eats only plants', 'An animal that eats only meat', 'An omnivorous animal', 'An extinct animal', 'An animal that eats only plants', 'Beginner'),
(1, 'Nature', 'Define "Pollination":', 'The process of plant reproduction', 'The process of soil formation', 'The process of water evaporation', 'The process of decomposition', 'The process of plant reproduction', 'Intermediate');

-- Insert Sample Questions for Food Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(2, 'Food', 'What is a "Recipe"?', 'A cooking utensil', 'A set of instructions for preparing food', 'A type of cuisine', 'A food ingredient', 'A set of instructions for preparing food', 'Beginner'),
(2, 'Food', 'Which word means to cook with dry heat?', 'Boiling', 'Baking', 'Steaming', 'Frying', 'Baking', 'Beginner'),
(2, 'Food', 'What does "Marinate" mean?', 'To freeze food', 'To soak food in liquid', 'To grind food', 'To slice food', 'To soak food in liquid', 'Beginner'),
(2, 'Food', 'Define "Cuisine":', 'A cooking method', 'A style of food preparation', 'A kitchen tool', 'A restaurant', 'A style of food preparation', 'Beginner'),
(2, 'Food', 'What is "Seasoning"?', 'A time of year', 'Substances added to enhance flavor', 'A cooking technique', 'A type of food', 'Substances added to enhance flavor', 'Intermediate'),
(2, 'Food', 'What does "Garnish" mean?', 'To cook completely', 'To decorate food for presentation', 'To mix ingredients', 'To cut vegetables', 'To decorate food for presentation', 'Intermediate'),
(2, 'Food', 'Define "Simmer":', 'To boil rapidly', 'To cook just below boiling point', 'To freeze', 'To grill', 'To cook just below boiling point', 'Intermediate'),
(2, 'Food', 'What is "Fermentation"?', 'A type of cooking', 'A chemical process that breaks down food', 'A food ingredient', 'A kitchen appliance', 'A chemical process that breaks down food', 'Advanced'),
(2, 'Food', 'Define "Blanching":', 'Adding sauce', 'Briefly boiling then ice-bathing', 'Grinding food', 'Frying lightly', 'Briefly boiling then ice-bathing', 'Advanced'),
(2, 'Food', 'What does "Emulsion" mean in cooking?', 'A liquid substance', 'A mixture of two liquids that normally do not mix', 'A type of spice', 'A cooking method', 'A mixture of two liquids that normally do not mix', 'Advanced');

-- Insert Sample Questions for School Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(3, 'School', 'What is a "Curriculum"?', 'A school building', 'The subjects and courses taught', 'A type of examination', 'A teaching method', 'The subjects and courses taught', 'Beginner'),
(3, 'School', 'Define "Assignment":', 'A seating arrangement', 'A task given to students', 'A school subject', 'A teaching style', 'A task given to students', 'Beginner'),
(3, 'School', 'What does "Graduation" mean?', 'Completing a level of education', 'Starting school', 'Taking an exam', 'Choosing a subject', 'Completing a level of education', 'Beginner'),
(3, 'School', 'What is a "Lecture"?', 'A type of game', 'A formal presentation of information', 'A written test', 'A school building', 'A formal presentation of information', 'Beginner'),
(3, 'School', 'Define "Academic":', 'Related to school and learning', 'Related to sports', 'Related to art', 'Related to business', 'Related to school and learning', 'Intermediate'),
(3, 'School', 'What does "Scholarship" mean?', 'A type of award or financial aid for students', 'A school subject', 'A teaching certificate', 'An examination', 'A type of award or financial aid for students', 'Intermediate');

-- Insert Sample Questions for Business Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(4, 'Business', 'What is a "Profit"?', 'Total expenses', 'Money earned minus costs', 'Total sales', 'Employee salary', 'Money earned minus costs', 'Beginner'),
(4, 'Business', 'Define "Investment":', 'Spending money on things', 'Putting money into something expecting returns', 'Saving money', 'Borrowing money', 'Putting money into something expecting returns', 'Beginner'),
(4, 'Business', 'What does "Revenue" mean?', 'Total profit', 'Income from sales', 'Operating costs', 'Employee wages', 'Income from sales', 'Intermediate'),
(4, 'Business', 'Define "Entrepreneur":', 'An employee', 'A person who starts a business', 'A business manager', 'An accountant', 'A person who starts a business', 'Intermediate');

-- Insert Sample Questions for Travel Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(5, 'Travel', 'What is a "Passport"?', 'A type of luggage', 'A document for international travel', 'A travel ticket', 'A hotel reservation', 'A document for international travel', 'Beginner'),
(5, 'Travel', 'Define "Itinerary":', 'A type of vehicle', 'A detailed plan for a trip', 'A travel agency', 'A hotel guide', 'A detailed plan for a trip', 'Beginner'),
(5, 'Travel', 'What does "Destination" mean?', 'A starting point', 'The place where you are going', 'A travel company', 'A type of transport', 'The place where you are going', 'Beginner'),
(5, 'Travel', 'Define "Tourism":', 'Business of providing accommodations', 'Travel for leisure and recreation', 'Air transportation', 'Hotel management', 'Travel for leisure and recreation', 'Intermediate');

-- Insert Sample Questions for Emotions Category
INSERT INTO questions (category_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
(6, 'Emotions', 'What does "Enthusiastic" mean?', 'Tired and bored', 'Eager and excited', 'Angry and upset', 'Sad and lonely', 'Eager and excited', 'Beginner'),
(6, 'Emotions', 'Define "Melancholy":', 'Very happy', 'Sad and thoughtful', 'Angry and violent', 'Excited and energetic', 'Sad and thoughtful', 'Beginner'),
(6, 'Emotions', 'What is "Nostalgia"?', 'Fear of the future', 'Sentimental memory of the past', 'Anger about present', 'Joy of discovery', 'Sentimental memory of the past', 'Intermediate'),
(6, 'Emotions', 'Define "Pessimism":', 'Being hopeful', 'Believing things will go badly', 'Being realistic', 'Being optimistic', 'Believing things will go badly', 'Intermediate');
