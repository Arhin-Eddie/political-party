<?php
$page_title = "Members";
require_once '../includes/admin_header.php';

if (isset($_POST['update_status']) && isset($_POST['member_id']) && isset($_POST['new_status'])) {
    $member_id = (int)$_POST['member_id'];
    $new_status = $_POST['new_status'];
    
    if (in_array($new_status, ['Pending', 'Approved', 'Rejected'])) {
        $stmt = $conn->prepare("UPDATE members SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $member_id);
        $stmt->execute();
    }
}

$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM members WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY created_at DESC");
    $term = "%{$search}%";
    $stmt->bind_param("sss", $term, $term, $term);
    $stmt->execute();
    $members = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $members = $conn->query("SELECT * FROM members ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Member Management</h2>
    <form class="d-flex" action="members.php" method="GET">
        <input type="text" name="search" class="form-control me-2" placeholder="Search members..." value="<?= h($search) ?>">
        <button class="btn btn-primary" type="submit">Search</button>
        <?php if($search): ?>
            <a href="members.php" class="btn btn-outline-secondary ms-2">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($members)): ?>
                        <tr><td colspan="7" class="text-center py-4">No members found.</td></tr>
                    <?php else: ?>
                        <?php foreach($members as $m): ?>
                            <tr>
                                <td><?= $m['id'] ?></td>
                                <td>
                                    <strong><?= h($m['first_name'] . ' ' . $m['last_name']) ?></strong>
                                    <br><small class="text-muted"><?= h($m['region'] ?? 'N/A') ?></small>
                                </td>
                                <td><?= h($m['email']) ?><br><small class="text-muted"><?= h($m['phone'] ?? '') ?></small></td>
                                <td><?= h($m['membership_type']) ?></td>
                                <td><?= format_date($m['created_at']) ?></td>
                                <td>
                                    <?php 
                                    $badge = 'bg-secondary';
                                    if($m['status'] == 'Approved') $badge = 'bg-success';
                                    if($m['status'] == 'Rejected') $badge = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= h($m['status']) ?></span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#memberModal<?= $m['id'] ?>">
                                        Review
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Member Modal -->
                            <div class="modal fade" id="memberModal<?= $m['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review Application: <?= h($m['first_name'] . ' ' . $m['last_name']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group list-group-flush mb-4">
                                                <li class="list-group-item px-0"><strong>Email:</strong> <?= h($m['email']) ?></li>
                                                <li class="list-group-item px-0"><strong>Phone:</strong> <?= h($m['phone'] ?? 'N/A') ?></li>
                                                <li class="list-group-item px-0"><strong>Address:</strong> <?= nl2br(h($m['address'] ?? 'N/A')) ?></li>
                                                <li class="list-group-item px-0"><strong>Region:</strong> <?= h($m['region'] ?? 'N/A') ?></li>
                                                <li class="list-group-item px-0"><strong>Membership Type:</strong> <?= h($m['membership_type']) ?></li>
                                                <li class="list-group-item px-0"><strong>Applied:</strong> <?= format_date($m['created_at'], 'F j, Y, g:i a') ?></li>
                                            </ul>
                                            
                                            <form method="POST" action="members.php">
                                                <input type="hidden" name="member_id" value="<?= $m['id'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Update Status</label>
                                                    <select class="form-select" name="new_status">
                                                        <option value="Pending" <?= $m['status']=='Pending'?'selected':'' ?>>Pending</option>
                                                        <option value="Approved" <?= $m['status']=='Approved'?'selected':'' ?>>Approve</option>
                                                        <option value="Rejected" <?= $m['status']=='Rejected'?'selected':'' ?>>Reject</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="update_status" class="btn btn-primary w-100">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
