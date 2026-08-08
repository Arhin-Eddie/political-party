<?php
$page_title = "Messages";
require_once '../includes/admin_header.php';

if (isset($_POST['update_status']) && isset($_POST['message_id']) && isset($_POST['new_status'])) {
    $msg_id = (int)$_POST['message_id'];
    $new_status = $_POST['new_status'];
    
    if (in_array($new_status, ['Unread', 'Read', 'Resolved'])) {
        $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $msg_id);
        $stmt->execute();
    }
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Contact Messages</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($messages)): ?>
                        <tr><td colspan="5" class="text-center py-4">No messages found.</td></tr>
                    <?php else: ?>
                        <?php foreach($messages as $msg): ?>
                            <tr class="<?= $msg['status'] === 'Unread' ? 'table-warning' : '' ?>">
                                <td style="white-space: nowrap;"><?= format_date($msg['created_at'], 'M j, Y') ?></td>
                                <td>
                                    <strong><?= h($msg['name']) ?></strong><br>
                                    <small><a href="mailto:<?= h($msg['email']) ?>" class="text-decoration-none"><?= h($msg['email']) ?></a></small>
                                </td>
                                <td><?= h($msg['subject']) ?></td>
                                <td>
                                    <?php 
                                    $badge = 'bg-secondary';
                                    if($msg['status'] == 'Unread') $badge = 'bg-warning text-dark';
                                    if($msg['status'] == 'Resolved') $badge = 'bg-success';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= h($msg['status']) ?></span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#msgModal<?= $msg['id'] ?>">
                                        View
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Message Modal -->
                            <div class="modal fade" id="msgModal<?= $msg['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= h($msg['subject']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-4">
                                                <div class="col-sm-6">
                                                    <strong>From:</strong> <?= h($msg['name']) ?> (<a href="mailto:<?= h($msg['email']) ?>"><?= h($msg['email']) ?></a>)
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <strong>Date:</strong> <?= format_date($msg['created_at'], 'F j, Y, g:i a') ?>
                                                </div>
                                                <?php if($msg['phone']): ?>
                                                    <div class="col-12 mt-2">
                                                        <strong>Phone:</strong> <?= h($msg['phone']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="p-4 bg-light rounded border mb-4">
                                                <?= nl2br(h($msg['message'])) ?>
                                            </div>
                                            
                                            <form method="POST" action="messages.php">
                                                <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                                                <div class="d-flex align-items-center gap-3">
                                                    <label class="form-label fw-bold mb-0">Update Status:</label>
                                                    <select class="form-select w-auto" name="new_status">
                                                        <option value="Unread" <?= $msg['status']=='Unread'?'selected':'' ?>>Unread</option>
                                                        <option value="Read" <?= $msg['status']=='Read'?'selected':'' ?>>Read</option>
                                                        <option value="Resolved" <?= $msg['status']=='Resolved'?'selected':'' ?>>Resolved</option>
                                                    </select>
                                                    <button type="submit" name="update_status" class="btn btn-primary">Save</button>
                                                </div>
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
