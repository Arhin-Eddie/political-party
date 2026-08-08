<?php
$page_title = "Add News";
require_once '../includes/admin_header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $published_at = trim($_POST['published_at']);
    
    $image_path = null;
    
    if (empty($title) || empty($content) || empty($published_at)) {
        $error = "Title, content, and publish date are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['image'], 'assets/uploads/news/');
            if ($uploaded) {
                $image_path = $uploaded;
            } else {
                $error = "Failed to upload image. Please ensure it is a valid JPG/PNG/WEBP under the size limit.";
            }
        }
        
        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, published_at, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $content, $published_at, $image_path);
            
            if ($stmt->execute()) {
                redirect('news.php');
            } else {
                $error = "Database error. Failed to create news article.";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Add News Article</h2>
    <a href="news.php" class="btn btn-outline-secondary">Back to News</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        
        <form action="add-news.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Article Title *</label>
                    <input type="text" class="form-control" name="title" required value="<?= h($_POST['title'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Publish Date & Time *</label>
                    <!-- Default to current time, using local datetime-local format -->
                    <input type="datetime-local" class="form-control" name="published_at" required value="<?= h($_POST['published_at'] ?? date('Y-m-d\TH:i')) ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Content *</label>
                    <textarea class="form-control" name="content" rows="10" required><?= h($_POST['content'] ?? '') ?></textarea>
                </div>
                
                <div class="col-12">
                    <label class="form-label">Featured Image (Optional)</label>
                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Recommended size: 800x400 pixels. Max size: 2MB.</div>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Publish Article</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
