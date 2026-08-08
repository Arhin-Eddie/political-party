<?php
require_once '../config/session.php';
require_once '../config/constants.php';
logout_admin();
header("Location: " . BASE_URL . "admin/login.php");
exit();
