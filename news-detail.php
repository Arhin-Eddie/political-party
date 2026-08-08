<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('news.php');
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT title, content, image, published_at FROM news WHERE id = ? AND published_at <= NOW()");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) {
    redirect('news.php');
}

$page_title = $news['title'];
require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main class="bg-bg-color">
    <article class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <a href="<?= BASE_URL ?>news.php" class="text-muted text-decoration-none small">&larr; Back to News</a>
                    </div>
                    
                    <div class="editorial-date mb-3"><?= format_date($news['published_at']) ?></div>
                    <h1 class="font-serif fw-bold mb-5 display-5"><?= h($news['title']) ?></h1>
                    
                    <?php if ($news['image']): ?>
                        <div class="mb-5">
                            <img src="<?= BASE_URL . h($news['image']) ?>" alt="<?= h($news['title']) ?>" class="img-fluid w-100" style="border-radius: var(--border-radius-md);">
                        </div>
                    <?php endif; ?>
                    
                    <div class="fs-5 lh-lg text-muted">
                        <?= nl2br(h($news['content'])) ?>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted small">Published by the <?= h(get_setting($conn, 'party_name') ?? APP_NAME) ?> Communications Team.</p>
                    </div>
                </div>
            </div>
        </div>
    </article>
</main>

<?php require_once 'includes/footer.php'; ?>
