<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../includes/functions.php';

require_admin_login();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if ($row['image'] && file_exists(__DIR__ . '/../' . $row['image'])) {
            unlink(__DIR__ . '/../' . $row['image']);
        }
        
        $del = $conn->prepare("DELETE FROM events WHERE id = ?");
        $del->bind_param("i", $id);
        $del->execute();
    }
}

redirect('events.php?msg=deleted');
