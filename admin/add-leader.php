<?php
$page_title = "Add Leader";
require_once '../includes/admin_header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $biography = trim($_POST['biography']);
    
    $image_path = null;
    
    if (empty($name) || empty($position)) {
        $error = "Name and position are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['image'], 'assets/uploads/leadership/');
            if ($uploaded) {
                $image_path = $uploaded;
            } else {
                $error = "Failed to upload image. Please ensure it is a valid JPG/PNG/WEBP under the size limit.";
            }
        }
        
        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO leadership (name, position, biography, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $position, $biography, $image_path);
            
            if ($stmt->execute()) {
                redirect('leadership.php');
            } else {
                $error = "Database error. Failed to add leader.";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Add Leader</h2>
    <a href="leadership.php" class="btn btn-outline-secondary">Back to Leadership</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        
        <form action="add-leader.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" class="form-control" name="name" required value="<?= h($_POST['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Position *</label>
                    <input type="text" class="form-control" name="position" required value="<?= h($_POST['position'] ?? '') ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Biography</label>
                    <textarea class="form-control" name="biography" rows="5"><?= h($_POST['biography'] ?? '') ?></textarea>
                </div>
                
                <div class="col-12">
                    <label class="form-label">Photograph (Optional)</label>
                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Recommended format: Square image (e.g. 400x400px).</div>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Add Leader</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
