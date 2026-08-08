<?php
require_once 'config/database.php';

$username = 'admin';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

// Clear the admins table and insert a fresh, guaranteed-to-work admin account
$conn->query("TRUNCATE TABLE admins");

$stmt = $conn->prepare("INSERT INTO admins (id, username, password_hash) VALUES (1, ?, ?)");
$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2>✅ Admin Account Setup Successful!</h2>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($username) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
    echo "<p>The database has been updated using your server's native <code>password_hash()</code>.</p>";
    echo "<a href='admin/login.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #0d3b66; color: white; text-decoration: none; border-radius: 5px;'>Go to Login</a>";
    echo "</div>";
} else {
    echo "Error: " . $conn->error;
}
