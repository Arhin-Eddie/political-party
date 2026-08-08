<?php
$page_title = "Contact Us";
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully. We will get back to you shortly.";
        } else {
            $error = "Something went wrong. Please try again later.";
        }
    }
}
?>

<main>
    <section class="section-padding">
        <div class="container">
            <h1 class="mb-5 text-center text-md-start">Contact Us</h1>
            
            <div class="row gy-5">
                <div class="col-lg-5 pe-lg-5">
                    <h3 class="font-serif mb-4">Get in Touch</h3>
                    <p class="text-muted mb-4 pb-4 border-bottom">We welcome your questions, feedback, and ideas. Our team is dedicated to responding to community inquiries as quickly as possible.</p>
                    
                    <div class="mb-4">
                        <h6 class="text-uppercase letter-spacing-1 text-muted mb-2 small">Office Address</h6>
                        <p class="fs-5"><?= nl2br(h(get_setting($conn, 'office_address') ?? '123 Main St, Capital City')) ?></p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-uppercase letter-spacing-1 text-muted mb-2 small">Email</h6>
                        <p class="fs-5"><a href="mailto:<?= h(get_setting($conn, 'contact_email')) ?>" class="text-decoration-none text-reset"><?= h(get_setting($conn, 'contact_email') ?? 'info@party.org') ?></a></p>
                    </div>
                    
                    <div>
                        <h6 class="text-uppercase letter-spacing-1 text-muted mb-2 small">Phone</h6>
                        <p class="fs-5"><?= h(get_setting($conn, 'contact_phone') ?? '1-800-555-0000') ?></p>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="clean-container">
                        <h4 class="mb-4 font-serif">Send a Message</h4>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success border-0 rounded-0 border-start border-success border-4"><?= h($success) ?></div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger border-0 rounded-0 border-start border-danger border-4"><?= h($error) ?></div>
                        <?php endif; ?>
                        
                        <form action="contact.php" method="POST">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="name" required value="<?= h($_POST['name'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" required value="<?= h($_POST['email'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone (Optional)</label>
                                    <input type="text" class="form-control" name="phone" value="<?= h($_POST['phone'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Subject *</label>
                                    <input type="text" class="form-control" name="subject" required value="<?= h($_POST['subject'] ?? '') ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Your Message *</label>
                                    <textarea class="form-control" name="message" rows="5" required><?= h($_POST['message'] ?? '') ?></textarea>
                                </div>
                                <div class="col-12 mt-4 pt-2">
                                    <button type="submit" class="btn btn-primary px-4">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
