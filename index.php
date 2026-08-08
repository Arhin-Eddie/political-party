<?php
$page_title = "Home";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$hero_title = get_setting($conn, 'hero_title');
$hero_subtitle = get_setting($conn, 'hero_subtitle');
$hero_btn_text = get_setting($conn, 'hero_button_text');
$hero_btn_link = get_setting($conn, 'hero_button_link');
$hero_image = get_setting($conn, 'hero_image');

if(empty($hero_title)) $hero_title = get_setting($conn, 'party_name') ?? APP_NAME;
if(empty($hero_btn_text)) { $hero_btn_text = "Become a Member"; $hero_btn_link = BASE_URL . "membership.php"; }

$events_stmt = $conn->query("SELECT id, title, description, event_date, event_time, location, image FROM events WHERE status = 'Upcoming' AND event_date >= CURDATE() ORDER BY event_date ASC, event_time ASC LIMIT 3");
$upcoming_events = $events_stmt->fetch_all(MYSQLI_ASSOC);

$news_stmt = $conn->query("SELECT id, title, content, image, published_at FROM news WHERE published_at <= NOW() ORDER BY published_at DESC LIMIT 3");
$latest_news = $news_stmt->fetch_all(MYSQLI_ASSOC);
?>

<main>
        <section class="hero-section">
        <div class="hero-text-col">
            <h1 class="hero-title"><?= h($hero_title) ?></h1>
            <?php if($hero_subtitle): ?>
                <p class="hero-subtitle"><?= h($hero_subtitle) ?></p>
            <?php endif; ?>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="<?= BASE_URL . ltrim(h($hero_btn_link), '/') ?>" class="btn btn-primary"><?= h($hero_btn_text) ?></a>
                <a href="<?= BASE_URL ?>events.php" class="btn btn-outline-primary">View Events</a>
            </div>
        </div>
        <div class="hero-img-col">
            <?php if($hero_image): ?>
                <img src="<?= BASE_URL . h($hero_image) ?>" alt="Hero" class="hero-img">
            <?php else: ?>
                                <div class="hero-img d-flex align-items-center justify-content-center bg-surface border-start border-bottom">
                    <span class="text-muted small text-uppercase letter-spacing-1">Visual Placeholder</span>
                </div>
            <?php endif; ?>
        </div>
    </section>

        <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title">Our Vision for the Future</h2>
                    <p class="fs-5 text-muted mb-4">We believe in a society where every voice is heard, and policies are driven by the needs of the community rather than special interests.</p>
                    <p>Our foundational principles are built upon transparency in governance, economic fairness, and sustainable development. We are working every day at the grassroots level to ensure a brighter tomorrow.</p>
                    <a href="<?= BASE_URL ?>about.php" class="btn btn-outline-primary mt-3">Read Our Full Mission &rarr;</a>
                </div>
            </div>
        </div>
    </section>

        <section class="section-padding bg-surface border-top border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h2 class="section-title mb-0 border-0 pb-0">Calendar</h2>
                <a href="<?= BASE_URL ?>events.php" class="text-muted d-none d-md-block">All Events &rarr;</a>
            </div>
            
            <?php if (empty($upcoming_events)): ?>
                <p class="text-muted">No upcoming events scheduled at this time.</p>
            <?php else: ?>
                <div class="border-top pt-3">
                    <?php foreach ($upcoming_events as $event): 
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
                                <p class="text-muted d-none d-md-block"><?= h(substr($event['description'], 0, 120)) ?>...</p>
                                <a href="<?= BASE_URL ?>event.php?id=<?= $event['id'] ?>" class="fw-medium">Details</a>
                            </div>
                            <?php if($event['image']): ?>
                            <div class="editorial-img-col d-none d-md-block">
                                <img src="<?= BASE_URL . h($event['image']) ?>" alt="Event" class="editorial-img">
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 d-md-none">
                    <a href="<?= BASE_URL ?>events.php" class="btn btn-outline-primary w-100">See All Events</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

        <section class="section-padding">
        <div class="container">
            <h2 class="section-title">Latest Announcements</h2>
            
            <?php if (empty($latest_news)): ?>
                <p class="text-muted">No recent announcements.</p>
            <?php else: ?>
                <div class="row gy-5">
                    <?php foreach ($latest_news as $news): ?>
                        <div class="col-6 col-lg-4">
                            <div class="news-item">
                                <?php if ($news['image']): ?>
                                    <a href="<?= BASE_URL ?>news-detail.php?id=<?= $news['id'] ?>">
                                        <img src="<?= BASE_URL . h($news['image']) ?>" class="news-img" alt="<?= h($news['title']) ?>">
                                    </a>
                                <?php endif; ?>
                                <div class="editorial-date mb-2"><?= format_date($news['published_at']) ?></div>
                                <h4 class="mb-2"><a href="<?= BASE_URL ?>news-detail.php?id=<?= $news['id'] ?>" class="text-decoration-none text-reset"><?= h($news['title']) ?></a></h4>
                                <p class="text-muted"><?= h(substr($news['content'], 0, 100)) ?>...</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>
