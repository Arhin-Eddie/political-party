<?php
$page_title = "Add Event";
require_once '../includes/admin_header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = trim($_POST['event_date']);
    $event_time = trim($_POST['event_time']);
    $location = trim($_POST['location']);
    $status = trim($_POST['status']);
    
    $image_path = null;
    
    if (empty($title) || empty($event_date) || empty($location)) {
        $error = "Title, date, and location are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploaded = upload_image($_FILES['image'], 'assets/uploads/events/');
            if ($uploaded) {
                $image_path = $uploaded;
            } else {
                $error = "Failed to upload image. Please ensure it is a valid JPG/PNG/WEBP under the size limit.";
            }
        }
        
        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, event_time, location, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title, $description, $event_date, $event_time, $location, $image_path, $status);
            
            if ($stmt->execute()) {
                redirect('events.php');
            } else {
                $error = "Database error. Failed to create event.";
            }
        }
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Add New Event</h2>
    <a href="events.php" class="btn btn-outline-secondary">Back to Events</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endif; ?>
        
        <form action="add-event.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Event Title *</label>
                    <input type="text" class="form-control" name="title" required value="<?= h($_POST['title'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Date *</label>
                    <input type="date" class="form-control" name="event_date" required value="<?= h($_POST['event_date'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Time</label>
                    <input type="time" class="form-control" name="event_time" value="<?= h($_POST['event_time'] ?? '') ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Location *</label>
                    <input type="text" class="form-control" name="location" required value="<?= h($_POST['location'] ?? '') ?>">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="5"><?= h($_POST['description'] ?? '') ?></textarea>
                </div>
                
                <div class="col-12">
                    <label class="form-label">Event Image (Optional)</label>
                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Recommended size: 800x600 pixels. Max size: 2MB.</div>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Create Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
