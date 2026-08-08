<?php

require_once 'constants.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // In a real application, you would log this error and show a generic message.
    // For this student project, displaying the error can help with setup debugging.
    die("Database Connection Failed: " . $e->getMessage() . "<br>Please ensure XAMPP MySQL is running and the database 'political_party' has been imported.");
}
