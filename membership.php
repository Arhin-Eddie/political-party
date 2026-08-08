<?php
$page_title = "Become a Member";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($address)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $check = $conn->prepare("SELECT id FROM members WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = "A membership application with this email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO members (first_name, last_name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $address);
            
            if ($stmt->execute()) {
                $success = "Thank you! Your membership application has been submitted and is pending review.";
            } else {
                $error = "Something went wrong. Please try again later.";
            }
        }
    }
}
?>

<main>
    <section class="section-padding bg-surface min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    
                    <div class="text-center mb-5">
                        <h1 class="font-serif">Join the Movement</h1>
                        <p class="text-muted fs-5">Add your voice to our growing community. Register as an official party member today.</p>
                    </div>

                    <?php if ($success): ?>
                        <div class="alert alert-success border-0 rounded-0 border-start border-success border-4 py-3">
                            <h5 class="alert-heading">Application Received</h5>
                            <p class="mb-0"><?= h($success) ?></p>
                        </div>
                        <div class="text-center mt-4">
                            <a href="<?= BASE_URL ?>" class="btn btn-primary">Return to Homepage</a>
                        </div>
                    <?php else: ?>
                        <div class="clean-container bg-white">
                            <?php if ($error): ?>
                                <div class="alert alert-danger border-0 rounded-0 border-start border-danger border-4 mb-4"><?= h($error) ?></div>
                            <?php endif; ?>

                            <form action="membership.php" method="POST">
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <label class="form-label">First Name *</label>
                                        <input type="text" class="form-control" name="first_name" required value="<?= h($_POST['first_name'] ?? '') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" name="last_name" required value="<?= h($_POST['last_name'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" name="email" required value="<?= h($_POST['email'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="<?= h($_POST['phone'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Residential Address *</label>
                                        <textarea class="form-control" name="address" rows="3" required><?= h($_POST['address'] ?? '') ?></textarea>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary w-100 py-2 fs-5">Submit Application</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-center mt-4">
                            <p class="text-muted small">By submitting this form, you agree to our party's code of conduct and privacy policy.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
