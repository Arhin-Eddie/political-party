<?php
require_once 'includes/header.php'; // Need DB connection first to get event

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect(BASE_URL . 'events.php');
}

$event_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect(BASE_URL . 'events.php');
}

$event = $result->fetch_assoc();
$page_title = h($event['title']);

?>
<!-- We rely on header.php already being output, so we update title via JS as a simple workaround for this single file without restructuring everything -->
<script>document.title = "<?= h($event['title']) ?> | <?= h(APP_NAME) ?>";</script>

<?php require_once 'includes/navbar.php'; ?>

<main>
    <section class="py-5 bg-surface border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>events.php">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= h($event['title']) ?></li>
                </ol>
            </nav>
            <h1 class="mb-3"><?= h($event['title']) ?></h1>
            <div class="d-flex flex-wrap gap-4 text-muted">
                <div>
                    <i class="bi bi-calendar3 text-primary me-2"></i>
                    <strong>Date:</strong> <?= format_date($event['event_date']) ?>
                </div>
                <div>
                    <i class="bi bi-clock text-primary me-2"></i>
                    <strong>Time:</strong> <?= format_time($event['event_time']) ?>
                </div>
                <div>
                    <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                    <strong>Location:</strong> <?= h($event['location']) ?>
                </div>
                <div>
                    <span class="badge <?= $event['status'] === 'Upcoming' ? 'bg-primary' : ($event['status'] === 'Completed' ? 'bg-secondary' : 'bg-danger') ?>">
                        <?= h($event['status']) ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php if ($event['image']): ?>
                        <img src="<?= BASE_URL . h($event['image']) ?>" alt="<?= h($event['title']) ?>" class="img-fluid rounded border mb-4 w-100" style="max-height: 400px; object-fit: cover;">
                    <?php endif; ?>
                    
                    <div class="content-formatted fs-5" style="line-height: 1.8;">
                        <?= nl2br(h($event['description'])) ?>
                    </div>
                    
                    <?php if ($event['status'] === 'Upcoming'): ?>
                        <div class="mt-5 p-4 bg-light border rounded text-center">
                            <h4>Plan to attend?</h4>
                            <p class="text-muted mb-4">Let us know you're interested or share this event with others.</p>
                            <a href="<?= BASE_URL ?>contact.php?subject=Inquiry regarding event: <?= urlencode($event['title']) ?>" class="btn btn-primary">Contact Us About This Event</a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Event Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Date</span>
                                    <span class="fw-medium"><?= format_date($event['event_date'], 'M j, Y') ?></span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Time</span>
                                    <span class="fw-medium"><?= format_time($event['event_time']) ?></span>
                                </li>
                                <li class="list-group-item px-0">
                                    <span class="text-muted d-block mb-1">Location</span>
                                    <span class="fw-medium"><?= nl2br(h($event['location'])) ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
