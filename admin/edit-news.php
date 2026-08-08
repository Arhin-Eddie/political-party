<?php
$page_title = "Edit News";
require_once '../includes/admin_header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('news.php');
}

$id = (int)$_GET['id'];
$error = '';

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) {
    redirect('news.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $published_at = trim($_POST['published_at']);
    
    $image_path = $news['image']; // Default to existing
    
    if (empty($title) || empty($content) || empty($published_at)) {
        $error = "Title, content, and publish date are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['image'], 'assets/uploads/news/');
            if ($uploaded) {
                // Delete old image if exists
                if ($image_path && file_exists(__DIR__ . '/../' . $image_path)) {
                    unlink(__DIR__ . '/../' . $image_path);
                }
                $image_path = $uploaded;
            } else {
                $error = "Failed to upload image. Please ensure it is a valid JPG/PNG/WEBP under the size limit.";
            }
        }
        
        if (!$error) {
            $upd = $conn->prepare("UPDATE news SET title=?, content=?, published_at=?, image=? WHERE id=?");
            $upd->bind_param("ssssi", $title, $content, $published_at, $image_path, $id);
            
            if ($upd->execute()) {
                redirect('news.php');
            } else {
                $error = "Database error. Failed to update article.";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Edit News Article</h2>
    <a href="news.php" class="btn btn-outline-secondary">Back to News</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        
        <form action="edit-news.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Article Title *</label>
                    <input type="text" class="form-control" name="title" required value="<?= h($_POST['title'] ?? $news['title']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Publish Date & Time *</label>
                    <input type="datetime-local" class="form-control" name="published_at" required value="<?= h($_POST['published_at'] ?? date('Y-m-d\TH:i', strtotime($news['published_at']))) ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Content *</label>
                    <textarea class="form-control" name="content" rows="10" required><?= h($_POST['content'] ?? $news['content']) ?></textarea>
                </div>
                
                <div class="col-12">
                    <label class="form-label">Featured Image</label>
                    <?php if($news['image']): ?>
                        <div class="mb-2">
                            <img src="<?= BASE_URL . h($news['image']) ?>" alt="Current Image" style="height: 100px; border-radius: 4px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Leave blank to keep the current image.</div>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
