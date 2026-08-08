# Political Party Website

A simple, responsive, and professional PHP/MySQL web application for a political party. 
Designed as a student project that runs cleanly on XAMPP.

## Requirements
- PHP 8+
- MySQL (MariaDB)
- XAMPP environment

## Installation Instructions

1.  **Copy Files:** Copy the entire `political-party` directory into your `C:\xampp\htdocs\` folder.
2.  **Start Services:** Open the XAMPP Control Panel and start **Apache** and **MySQL**.
3.  **Database Setup:**
    *   Open your browser and navigate to `http://localhost/phpmyadmin/`.
    *   Create a new database named `political_party` (utf8mb4 encoding recommended).
    *   Click on the newly created database, go to the **Import** tab.
    *   Browse and select the `database/political_party.sql` file provided in this project.
    *   Click **Go** to import the tables and demo data.
4.  **Access the Website:**
    *   Public facing site: `http://localhost/political-party/`
    *   Admin Dashboard: `http://localhost/political-party/admin/login.php`

## Admin Credentials
The default administrator account created during the SQL import is:
- **Username:** `admin`
- **Password:** `admin123`

*Note: For security reasons, the password is hashed in the database using bcrypt.*

## Architecture & Security
- Developed with plain PHP (no frameworks) and standard MySQLi.
- Utilizes prepared SQL statements across all queries to prevent SQL injection.
- Employs password_hash/password_verify for administrative authentication.
- Uses htmlspecialchars for XSS protection.
- Bootstrap 5 for responsive design and mobile-first layouts.
