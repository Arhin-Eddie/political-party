<?php

/**
 * Sanitize output for HTML context to prevent XSS.
 *
 * @param string $string
 * @return string
 */
function h($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a specific URL and exit.
 *
 * @param string $url
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Format a date string into a readable format.
 *
 * @param string $date
 * @param string $format
 * @return string
 */
function format_date($date, $format = 'F j, Y') {
    if (empty($date)) return '';
    $d = new DateTime($date);
    return $d->format($format);
}

/**
 * Format a time string into a readable format.
 *
 * @param string $time
 * @param string $format
 * @return string
 */
function format_time($time, $format = 'g:i A') {
    if (empty($time)) return '';
    $d = new DateTime($time);
    return $d->format($format);
}

/**
 * Get a global setting value from the database.
 *
 * @param mysqli $conn
 * @param string $key
 * @return string|null
 */
function get_setting($conn, $key) {
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    return null;
}

/**
 * Handle image file uploads securely.
 *
 * @param array $file $_FILES['input_name']
 * @param string $upload_dir Relative to BASE_URL (e.g., 'assets/uploads/events/')
 * @return string|false The relative path on success, false on failure.
 */
function upload_image($file, $upload_dir) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $target_dir = __DIR__ . '/../' . ltrim($upload_dir, '/');
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        return false;
    }

    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_exts)) {
        return false;
    }

    $new_filename = uniqid('img_', true) . '.' . $ext;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return rtrim($upload_dir, '/') . '/' . $new_filename;
    }

    return false;
}
