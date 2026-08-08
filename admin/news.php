<?php
$page_title = "News & Announcements";
require_once '../includes/admin_header.php';

$news = $conn->query("SELECT * FROM news ORDER BY published_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">News Management</h2>
    <a href="add-news.php" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add News</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show">
        News article deleted successfully.
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
                        <th>Published Date</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($news)): ?>
                        <tr><td colspan="5" class="text-center py-4">No news found.</td></tr>
                    <?php else: ?>
                        <?php foreach($news as $n): ?>
                            <tr>
                                <td>
                                    <?php if($n['image']): ?>
                                        <img src="<?= BASE_URL . h($n['image']) ?>" alt="img" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                            <i class="bi bi-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= h($n['title']) ?></strong></td>
                                <td><?= format_date($n['published_at'], 'M j, Y g:i A') ?></td>
                                <td><?= format_date($n['created_at'], 'M j, Y') ?></td>
                                <td>
                                    <a href="edit-news.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $n['id'] ?>)"><i class="bi bi-trash"></i></button>
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
    if (confirm("Are you sure you want to delete this article? This action cannot be undone.")) {
        window.location.href = "delete-news.php?id=" + id;
    }
}
</script>

<?php require_once '../includes/admin_footer.php'; ?>
