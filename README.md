Quizzzo is a modern web-based quiz application built to simplify academic assessments. It provides a seamless experience for students to take exams with real-time feedback and an elegant user interface.

✨ Features
Modern UI: Built with a "Deep Purple" Glassmorphism theme using Tailwind CSS.

Timed Assessments: Includes a hard-coded 5-minute countdown timer for quizzes.

Automated Scoring: Instant result calculation and accuracy tracking using Laravel Eloquent ORM.

Dynamic Questions: Integrated with the Open Trivia Database (OpenTDB) API to fetch diverse questions.

Responsive Design: Fully optimized for desktops, tablets, and mobile devices.

🚀 Tech Stack
Framework: Laravel 11

Frontend: Tailwind CSS & JavaScript

Database: MySQL

Environment: Laravel Herd / Localhost

🛠️ Installation Guide
Clone the repository:

Bash
git clone https://github.com/wasifa-projects/Quizzo.git
Install dependencies:

Bash
composer install
npm install && npm run build
Environment Setup:

Copy .env.example to .env

Set your database credentials in .env

Run php artisan key:generate

Run Migrations:

Bash
php artisan migrate
Start the Server:

Bash
php artisan serve
