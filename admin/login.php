<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../includes/functions.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect(BASE_URL . 'admin/dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, password_hash FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $row['id'];
                redirect(BASE_URL . 'admin/dashboard.php');
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= h(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif;}
        .login-card { width: 100%; max-width: 400px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px;}
        .login-header { background-color: #1a252f; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4 d-flex justify-content-center">
            <div class="card login-card">
                <div class="login-header">
                    <h4 class="mb-0">Admin Login</h4>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2"><?= h($error) ?></div>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label text-muted small fw-bold text-uppercase">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label text-muted small fw-bold text-uppercase">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                    </form>
                    <div class="mt-4 text-center">
                        <a href="<?= BASE_URL ?>" class="text-decoration-none text-muted small">&larr; Back to Website</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
