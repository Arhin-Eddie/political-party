<?php
$page_title = "Leadership";
require_once '../includes/admin_header.php';

$leaders = $conn->query("SELECT * FROM leadership ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Leadership Management</h2>
    <a href="add-leader.php" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Leader</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show">
        Leader deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($leaders)): ?>
                        <tr><td colspan="4" class="text-center py-4">No leadership members found.</td></tr>
                    <?php else: ?>
                        <?php foreach($leaders as $ldr): ?>
                            <tr>
                                <td>
                                    <?php if($ldr['image']): ?>
                                        <img src="<?= BASE_URL . h($ldr['image']) ?>" alt="img" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <?= h(substr($ldr['name'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= h($ldr['name']) ?></strong></td>
                                <td><?= h($ldr['position']) ?></td>
                                <td>
                                    <a href="edit-leader.php?id=<?= $ldr['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $ldr['id'] ?>)"><i class="bi bi-trash"></i></button>
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
    if (confirm("Are you sure you want to delete this leader?")) {
        window.location.href = "delete-leader.php?id=" + id;
    }
}
</script>

<?php require_once '../includes/admin_footer.php'; ?>
