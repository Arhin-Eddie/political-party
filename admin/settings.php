<?php
$page_title = "Website Settings";
require_once '../includes/admin_header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_global'])) {
        $updates = [
            'party_name' => $_POST['party_name'] ?? '',
            'contact_email' => $_POST['contact_email'] ?? '',
            'contact_phone' => $_POST['contact_phone'] ?? '',
            'office_address' => $_POST['office_address'] ?? ''
        ];
        
        $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        foreach ($updates as $key => $value) {
            $clean_val = trim($value);
            $stmt->bind_param("ss", $clean_val, $key);
            $stmt->execute();
        }
        $success = "Global settings updated successfully.";
    }
    
    if (isset($_POST['update_hero'])) {
        $updates = [
            'hero_title' => $_POST['hero_title'] ?? '',
            'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
            'hero_button_text' => $_POST['hero_button_text'] ?? '',
            'hero_button_link' => $_POST['hero_button_link'] ?? ''
        ];
        
        $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        foreach ($updates as $key => $value) {
            $clean_val = trim($value);
            $stmt->bind_param("ss", $clean_val, $key);
            $stmt->execute();
        }
        
        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['hero_image'], 'assets/uploads/hero/');
            if ($uploaded) {
                $old_img = get_setting($conn, 'hero_image');
                if ($old_img && file_exists(__DIR__ . '/../' . $old_img)) {
                    unlink(__DIR__ . '/../' . $old_img);
                }
                
                $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'hero_image'");
                $stmt->bind_param("s", $uploaded);
                $stmt->execute();
            } else {
                $error = "Failed to upload hero image. Please ensure it is a valid JPG/PNG/WEBP under the size limit.";
            }
        }
        
        if (!$error) {
            $success = "Hero section updated successfully.";
        }
    }
}

$settings_result = $conn->query("SELECT setting_key, setting_value FROM settings");
$current_settings = [];
while ($row = $settings_result->fetch_assoc()) {
    $current_settings[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Website Settings</h2>
</div>

<?php if ($success): ?>
    <div class="alert alert-success"><?= h($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= h($error) ?></div>
<?php endif; ?>

<div class="row gy-4">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Hero Section</h5>
            </div>
            <div class="card-body">
                <form action="settings.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Current Hero Image</label>
                        <?php if(!empty($current_settings['hero_image'])): ?>
                            <div class="mb-2">
                                <img src="<?= BASE_URL . h($current_settings['hero_image']) ?>" alt="Hero" class="img-fluid rounded border" style="max-height: 200px; width: 100%; object-fit: cover;">
                            </div>
                        <?php else: ?>
                            <div class="mb-2 p-4 bg-light border rounded text-center text-muted">
                                No image currently set. Default styling will apply.
                            </div>
                        <?php endif; ?>
                        
                        <label class="form-label">Upload New Image</label>
                        <input type="file" class="form-control" name="hero_image" accept="image/jpeg, image/png, image/webp">
                        <div class="form-text">Recommended size: 1920x1080 pixels (JPG/PNG/WEBP).</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Title</label>
                        <input type="text" class="form-control" name="hero_title" value="<?= h($current_settings['hero_title'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Description</label>
                        <textarea class="form-control" name="hero_subtitle" rows="2"><?= h($current_settings['hero_subtitle'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Button Text</label>
                            <input type="text" class="form-control" name="hero_button_text" value="<?= h($current_settings['hero_button_text'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Button Link</label>
                            <input type="text" class="form-control" name="hero_button_link" value="<?= h($current_settings['hero_button_link'] ?? '') ?>">
                            <div class="form-text">e.g., `/membership.php`</div>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_hero" class="btn btn-primary w-100">Save Hero Changes</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Global Information</h5>
            </div>
            <div class="card-body">
                <form action="settings.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Party Name</label>
                        <input type="text" class="form-control" name="party_name" required value="<?= h($current_settings['party_name'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Email</label>
                        <input type="email" class="form-control" name="contact_email" required value="<?= h($current_settings['contact_email'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Phone Number</label>
                        <input type="text" class="form-control" name="contact_phone" value="<?= h($current_settings['contact_phone'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Office Address</label>
                        <textarea class="form-control" name="office_address" rows="3"><?= h($current_settings['office_address'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" name="update_global" class="btn btn-primary w-100">Save Global Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
