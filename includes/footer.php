<?php
?>
    <footer class="site-footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-3"><?= h(get_setting($conn, 'party_name') ?? APP_NAME) ?></h5>
                    <p>Committed to progress, community, and transparency. Join us in shaping a better future for everyone.</p>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>about.php">About Us</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>events.php">Events</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>news.php">News</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Get Involved</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= BASE_URL ?>membership.php">Become a Member</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>contact.php">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> <?= h(get_setting($conn, 'office_address')) ?></li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> <a href="mailto:<?= h(get_setting($conn, 'contact_email')) ?>"><?= h(get_setting($conn, 'contact_email')) ?></a></li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> <?= h(get_setting($conn, 'contact_phone')) ?></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> <?= h(get_setting($conn, 'party_name') ?? APP_NAME) ?>. All rights reserved.</p>
                <div class="mt-2">
                    <small><a href="<?= BASE_URL ?>admin/login.php" class="text-muted text-decoration-none">Admin Login</a></small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
