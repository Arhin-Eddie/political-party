<?php
$page_title = "News & Announcements";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$news_stmt = $conn->query("SELECT id, title, content, image, published_at FROM news WHERE published_at <= NOW() ORDER BY published_at DESC");
$news_items = $news_stmt->fetch_all(MYSQLI_ASSOC);
?>

<main>
    <section class="section-padding">
        <div class="container">
            <h1 class="mb-5 text-center text-md-start">News & Announcements</h1>
            
            <?php if (empty($news_items)): ?>
                <p class="text-muted fs-5 py-4 text-center text-md-start">No news articles have been published yet.</p>
            <?php else: ?>
                                <?php $featured = $news_items[0]; ?>
                <div class="row align-items-center mb-5 pb-5 border-bottom gy-4">
                    <div class="col-lg-7">
                        <?php if ($featured['image']): ?>
                            <a href="<?= BASE_URL ?>news-detail.php?id=<?= $featured['id'] ?>">
                                <img src="<?= BASE_URL . h($featured['image']) ?>" alt="<?= h($featured['title']) ?>" class="img-fluid" style="width:100%; border-radius: var(--border-radius-md);">
                            </a>
                        <?php else: ?>
                            <div class="bg-surface d-flex align-items-center justify-content-center" style="height: 400px; border-radius: var(--border-radius-md);">
                                <span class="text-muted">News Image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 ps-lg-5">
                        <div class="editorial-date mb-3">Featured &bull; <?= format_date($featured['published_at']) ?></div>
                        <h2 class="mb-3 display-6 font-serif fw-bold"><a href="<?= BASE_URL ?>news-detail.php?id=<?= $featured['id'] ?>" class="text-reset text-decoration-none"><?= h($featured['title']) ?></a></h2>
                        <p class="fs-5 text-muted mb-4"><?= h(substr($featured['content'], 0, 200)) ?>...</p>
                        <a href="<?= BASE_URL ?>news-detail.php?id=<?= $featured['id'] ?>" class="btn btn-outline-primary">Read Article</a>
                    </div>
                </div>
                
                                <?php if (count($news_items) > 1): ?>
                    <div class="row gy-5">
                        <?php for($i = 1; $i < count($news_items); $i++): $news = $news_items[$i]; ?>
                            <div class="col-6 col-lg-4">
                                <div class="news-item">
                                    <?php if ($news['image']): ?>
                                        <a href="<?= BASE_URL ?>news-detail.php?id=<?= $news['id'] ?>">
                                            <img src="<?= BASE_URL . h($news['image']) ?>" class="news-img" alt="<?= h($news['title']) ?>">
                                        </a>
                                    <?php endif; ?>
                                    <div class="editorial-date mb-2"><?= format_date($news['published_at']) ?></div>
                                    <h4 class="mb-2"><a href="<?= BASE_URL ?>news-detail.php?id=<?= $news['id'] ?>" class="text-decoration-none text-reset"><?= h($news['title']) ?></a></h4>
                                    <p class="text-muted"><?= h(substr($news['content'], 0, 120)) ?>...</p>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
