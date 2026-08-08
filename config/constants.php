<?php

define('APP_NAME', 'Political Party');

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_path = dirname($_SERVER['SCRIPT_NAME']);
$script_path = str_replace('\\', '/', $script_path); // Windows compatibility

$script_path = preg_replace('/\/admin(\/.*)?$/', '', $script_path);

define('BASE_URL', $protocol . "://" . $host . $script_path . "/");

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'political_party');
