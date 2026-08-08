<?php
$page_title = "Events";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$events_stmt = $conn->query("SELECT id, title, description, event_date, event_time, location, image, status FROM events ORDER BY event_date ASC, event_time ASC");
$all_events = $events_stmt->fetch_all(MYSQLI_ASSOC);

$upcoming = [];
$past = [];
$current_date = date('Y-m-d');

foreach ($all_events as $evt) {
    if ($evt['status'] === 'Upcoming' && $evt['event_date'] >= $current_date) {
        $upcoming[] = $evt;
    } else {
        $past[] = $evt;
    }
}
?>

<main>
    <section class="section-padding">
        <div class="container">
            <h1 class="mb-5 text-center text-md-start">Events & Gatherings</h1>
            
            <h2 class="section-title">Upcoming Events</h2>
            <?php if (empty($upcoming)): ?>
                <p class="text-muted fs-5 py-4">There are no upcoming events scheduled at the moment.</p>
            <?php else: ?>
                <div class="mb-5 border-top pt-3">
                    <?php foreach ($upcoming as $event): 
                        $event_date = new DateTime($event['event_date']);
                    ?>
                        <div class="editorial-list-item">
                            <div class="editorial-date-col">
                                <div class="editorial-date"><?= $event_date->format('d M Y') ?></div>
                            </div>
                            <div class="editorial-content-col">
                                <h4 class="editorial-title"><a href="<?= BASE_URL ?>event.php?id=<?= $event['id'] ?>" class="text-decoration-none text-reset"><?= h($event['title']) ?></a></h4>
                                <div class="editorial-meta">
                                    <?= h($event['location']) ?> &bull; <?= format_time($event['event_time']) ?>
                                </div>
                                <p class="text-muted d-none d-md-block"><?= h(substr($event['description'], 0, 180)) ?>...</p>
                                <a href="<?= BASE_URL ?>event.php?id=<?= $event['id'] ?>" class="fw-medium">Event Details &rarr;</a>
                            </div>
                            <?php if($event['image']): ?>
                            <div class="editorial-img-col d-none d-md-block">
                                <img src="<?= BASE_URL . h($event['image']) ?>" alt="Event" class="editorial-img">
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($past)): ?>
                <h2 class="section-title mt-5">Past Events</h2>
                <div class="row gy-4">
                    <?php 
                    usort($past, function($a, $b) {
                        return strtotime($b['event_date']) - strtotime($a['event_date']);
                    });
                    
                    foreach ($past as $event): 
                    ?>
                        <div class="col-6 col-lg-6">
                            <div class="d-flex flex-column h-100">
                                <div class="editorial-date mb-2">
                                    <?= format_date($event['event_date']) ?>
                                    <span class="ms-2 text-lowercase fw-normal">(<?= h($event['status']) ?>)</span>
                                </div>
                                <h5 class="mb-2"><?= h($event['title']) ?></h5>
                                <p class="text-muted small mb-2 flex-grow-1"><?= h(substr($event['description'], 0, 120)) ?>...</p>
                                <div>
                                    <a href="<?= BASE_URL ?>event.php?id=<?= $event['id'] ?>" class="text-primary small text-decoration-underline">Read Summary</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
