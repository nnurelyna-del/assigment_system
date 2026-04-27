Assignment Submission Management System

This project is a web-based system developed using PHP, MySQL, and Bootstrap. It allows students to submit assignments online and enables admins to manage assignments and view submissions.

Features

Student
    -Register and login
    -View available assignments
    -Submit assignments (file upload)
    -View own submissions

Admin
    -Login
    -Create assignments
    -View all student submissions
    -Download uploaded files

Technologies Used
    -PHP
    -MySQL
    -Bootstrap
    -JavaScript (AJAX / Fetch API)


Database

Database Name: assignment_system

Tables:
    -users
    -assignments
    -submissions

Setup Instructions
1. Download or clone the repository:
    git clone https://github.com/nnurelyna-delassigment_system.git
2. Move the project folder to:
    C:\laragon\www\
3. Start Laragon and run Apache & MySQL
4. Open phpMyAdmin
    Create database: assignment_system
    Import the provided .sql file
5. Open browser and run:
    http://localhost/assigment_system

Default Roles
    -Admin → Manage assignments and submissions
    -Student → Submit and view assignments

GitHub Repository
    https://github.com/nnurelyna-del/assigment_system.git

Notes
    -Make sure file upload folder /uploads exists
    -Only allowed file types: PDF, DOCX, TXT
    -Ensure proper database connection in db.php