<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/functions.php';

require_admin_login();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? h($page_title) . ' | ' : '' ?>Admin | <?= h(APP_NAME) ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>

<div id="admin-wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0 text-white">Administration</h4>
            <small class="text-muted"><?= h(APP_NAME) ?></small>
        </div>

        <ul class="list-unstyled components">
            <li class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            </li>
            <li class="<?= $current_page == 'members.php' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/members.php"><i class="bi bi-people"></i> Members</a>
            </li>
            <li class="<?= in_array($current_page, ['events.php', 'add-event.php', 'edit-event.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/events.php"><i class="bi bi-calendar-event"></i> Events</a>
            </li>
            <li class="<?= in_array($current_page, ['news.php', 'add-news.php', 'edit-news.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/news.php"><i class="bi bi-newspaper"></i> News</a>
            </li>
            <li class="<?= in_array($current_page, ['leadership.php', 'add-leader.php', 'edit-leader.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/leadership.php"><i class="bi bi-person-badge"></i> Leadership</a>
            </li>
            <li class="<?= $current_page == 'messages.php' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/messages.php"><i class="bi bi-envelope"></i> Messages</a>
            </li>
            <li class="<?= $current_page == 'settings.php' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>admin/settings.php"><i class="bi bi-gear"></i> Settings</a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <div class="topbar">
            <div>
                <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary d-md-none">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <a href="<?= BASE_URL ?>" class="btn btn-sm btn-outline-primary me-3" target="_blank">View Site</a>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="admin-container">
