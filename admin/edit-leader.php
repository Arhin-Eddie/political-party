<?php
$page_title = "Edit Leader";
require_once '../includes/admin_header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('leadership.php');
}

$id = (int)$_GET['id'];
$error = '';

$stmt = $conn->prepare("SELECT * FROM leadership WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$leader = $stmt->get_result()->fetch_assoc();

if (!$leader) {
    redirect('leadership.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $biography = trim($_POST['biography']);
    
    $image_path = $leader['image'];
    
    if (empty($name) || empty($position)) {
        $error = "Name and position are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['image'], 'assets/uploads/leadership/');
            if ($uploaded) {
                // Delete old image if exists
                if ($image_path && file_exists(__DIR__ . '/../' . $image_path)) {
                    unlink(__DIR__ . '/../' . $image_path);
                }
                $image_path = $uploaded;
            } else {
                $error = "Failed to upload image.";
            }
        }
        
        if (!$error) {
            $upd = $conn->prepare("UPDATE leadership SET name=?, position=?, biography=?, image=? WHERE id=?");
            $upd->bind_param("ssssi", $name, $position, $biography, $image_path, $id);
            
            if ($upd->execute()) {
                redirect('leadership.php');
            } else {
                $error = "Database error. Failed to update leader.";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Edit Leader</h2>
    <a href="leadership.php" class="btn btn-outline-secondary">Back to Leadership</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        
        <form action="edit-leader.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" class="form-control" name="name" required value="<?= h($_POST['name'] ?? $leader['name']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Position *</label>
                    <input type="text" class="form-control" name="position" required value="<?= h($_POST['position'] ?? $leader['position']) ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Biography</label>
                    <textarea class="form-control" name="biography" rows="5"><?= h($_POST['biography'] ?? $leader['biography']) ?></textarea>
                </div>
                
                <div class="col-12">
                    <label class="form-label">Photograph</label>
                    <?php if($leader['image']): ?>
                        <div class="mb-2">
                            <img src="<?= BASE_URL . h($leader['image']) ?>" alt="Current Image" style="height: 100px; border-radius: 4px;">
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
