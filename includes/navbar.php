<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>">
            <?= h(get_setting($conn, 'party_name') ?? APP_NAME) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'about.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'events.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'news.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>contact.php">Contact</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary nav-link text-white" href="<?= BASE_URL ?>membership.php">Become a Member</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
