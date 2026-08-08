<?php
$page_title = "About Us";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$leadership_stmt = $conn->query("SELECT id, name, position, biography, image FROM leadership ORDER BY id ASC");
$leaders = $leadership_stmt->fetch_all(MYSQLI_ASSOC);
?>

<main>
    <section class="section-padding">
        <div class="container">
            <h1 class="mb-5 text-center text-md-start">About Our Party</h1>
            
            <div class="row gy-5 mb-5">
                <div class="col-lg-6">
                    <h2 class="section-title">Our Mission</h2>
                    <p class="fs-5 text-muted mb-4">To govern with transparency, foster equitable economic growth, and protect the rights of every citizen.</p>
                    <p>We are a coalition of citizens dedicated to reforming the political landscape. We believe that a government should serve its people by listening to their needs and acting decisively to solve modern challenges.</p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-arrow-right text-primary me-3 mt-1"></i> 
                            <div><strong>Accountability:</strong> Elected officials must be held to the highest ethical standards.</div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-arrow-right text-primary me-3 mt-1"></i> 
                            <div><strong>Equality:</strong> Equal opportunity for all, regardless of background.</div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-arrow-right text-primary me-3 mt-1"></i> 
                            <div><strong>Sustainability:</strong> Protecting our environment for future generations.</div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-arrow-right text-primary me-3 mt-1"></i> 
                            <div><strong>Innovation:</strong> Modernizing public services through technology.</div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <h2 class="section-title">Our History</h2>
                    <p>Founded by a group of passionate community leaders, our party emerged from the grassroots need for genuine representation.</p>
                    <p>What started as a small series of town hall meetings quickly blossomed into a nationwide movement. We have consistently fought for essential reforms in education, healthcare access, and infrastructure development.</p>
                    <div class="clean-container bg-surface border-0 mt-4">
                        <figure class="mb-0">
                            <blockquote class="blockquote fs-5">
                                <p>"True progress is only achieved when the community works together toward a common goal, leaving no one behind."</p>
                            </blockquote>
                            <figcaption class="blockquote-footer mt-3 mb-0">
                                Party Founding Charter
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <section class="section-padding bg-surface border-top">
        <div class="container">
            <h2 class="section-title border-0 text-center mb-5">Our Leadership</h2>
            
            <?php if (empty($leaders)): ?>
                <div class="text-center py-4">
                    <p class="text-muted">Leadership information is currently being updated.</p>
                </div>
            <?php else: ?>
                <div class="row gy-5 justify-content-center">
                    <?php foreach ($leaders as $leader): ?>
                        <div class="col-6 col-md-4 col-lg-3 text-center">
                            <div class="mb-3">
                                <?php if ($leader['image']): ?>
                                    <img src="<?= BASE_URL . h($leader['image']) ?>" class="rounded-circle" alt="<?= h($leader['name']) ?>" style="width: 150px; height: 150px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                        <span class="text-muted fs-1 font-serif"><?= substr(h($leader['name']), 0, 1) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="mb-1 fs-5"><?= h($leader['name']) ?></h4>
                            <p class="text-muted small text-uppercase letter-spacing-1 mb-2"><?= h($leader['position']) ?></p>
                            <p class="text-muted small"><?= h($leader['biography']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
