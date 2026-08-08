<?php
$page_title = "Events";
require_once '../includes/admin_header.php';

$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Event Management</h2>
    <a href="add-event.php" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add New Event</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Event deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($events)): ?>
                        <tr><td colspan="6" class="text-center py-4">No events found.</td></tr>
                    <?php else: ?>
                        <?php foreach($events as $e): ?>
                            <tr>
                                <td>
                                    <?php if($e['image']): ?>
                                        <img src="<?= BASE_URL . h($e['image']) ?>" alt="img" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= h($e['title']) ?></strong></td>
                                <td>
                                    <?= format_date($e['event_date']) ?><br>
                                    <small class="text-muted"><?= format_time($e['event_time']) ?></small>
                                </td>
                                <td><?= h($e['location']) ?></td>
                                <td>
                                    <?php 
                                    $badge = 'bg-secondary';
                                    if($e['status'] == 'Upcoming') $badge = 'bg-primary';
                                    if($e['status'] == 'Cancelled') $badge = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= h($e['status']) ?></span>
                                </td>
                                <td>
                                    <a href="edit-event.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $e['id'] ?>)"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this event? This action cannot be undone.")) {
        window.location.href = "delete-event.php?id=" + id;
    }
}
</script>

<?php require_once '../includes/admin_footer.php'; ?>
