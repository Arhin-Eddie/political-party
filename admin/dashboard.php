<?php
$page_title = "Dashboard";
require_once '../includes/admin_header.php';

$stats = [
    'members' => $conn->query("SELECT COUNT(*) FROM members")->fetch_row()[0],
    'pending_members' => $conn->query("SELECT COUNT(*) FROM members WHERE status = 'Pending'")->fetch_row()[0],
    'events' => $conn->query("SELECT COUNT(*) FROM events WHERE status = 'Upcoming'")->fetch_row()[0],
    'news' => $conn->query("SELECT COUNT(*) FROM news")->fetch_row()[0],
    'unread_messages' => $conn->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'Unread'")->fetch_row()[0],
];

$recent_apps = $conn->query("SELECT id, first_name, last_name, email, membership_type, created_at FROM members WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

$upcoming_events = $conn->query("SELECT id, title, event_date FROM events WHERE status = 'Upcoming' ORDER BY event_date ASC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

$recent_messages = $conn->query("SELECT id, name, subject, created_at FROM contact_messages WHERE status = 'Unread' ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Dashboard Overview</h2>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-start border-primary border-4">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-details">
                <p>Total Members</p>
                <h3><?= number_format($stats['members']) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-start border-warning border-4">
            <div class="stat-icon text-warning"><i class="bi bi-person-plus"></i></div>
            <div class="stat-details">
                <p>Pending Applications</p>
                <h3><?= number_format($stats['pending_members']) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-start border-success border-4">
            <div class="stat-icon text-success"><i class="bi bi-calendar-event"></i></div>
            <div class="stat-details">
                <p>Upcoming Events</p>
                <h3><?= number_format($stats['events']) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-start border-danger border-4">
            <div class="stat-icon text-danger"><i class="bi bi-envelope"></i></div>
            <div class="stat-details">
                <p>Unread Messages</p>
                <h3><?= number_format($stats['unread_messages']) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <!-- Recent Applications -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Recent Pending Applications</h6>
                <a href="members.php" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($recent_apps)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">No pending applications.</td></tr>
                            <?php else: ?>
                                <?php foreach($recent_apps as $app): ?>
                                    <tr>
                                        <td><?= h($app['first_name'] . ' ' . $app['last_name']) ?></td>
                                        <td><?= h($app['membership_type']) ?></td>
                                        <td><?= format_date($app['created_at'], 'M j, Y') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Unread Messages</h6>
                <a href="messages.php" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($recent_messages)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">No unread messages.</td></tr>
                            <?php else: ?>
                                <?php foreach($recent_messages as $msg): ?>
                                    <tr>
                                        <td><?= h($msg['name']) ?></td>
                                        <td><?= h(substr($msg['subject'], 0, 30)) ?>...</td>
                                        <td><?= format_date($msg['created_at'], 'M j, Y') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/admin_footer.php'; ?>
