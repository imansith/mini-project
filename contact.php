<?php
require_once __DIR__ . '/includes/db.php';
$page_title = "Contact Us - UniMart Support";

$errors = [];
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Server-side validation checks
    if (empty($name)) {
        $errors[] = "Please provide your full name.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    if (empty($subject)) {
        $errors[] = "Please specify a subject for your inquiry.";
    }

    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters long.";
    }

    // Save message into database securely using PDO prepared statement
    if (empty($errors)) {
        if (isset($pdo) && $pdo !== null) {
            try {
                $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
                $stmt->execute([
                    'name'    => $name,
                    'email'   => $email,
                    'subject' => $subject,
                    'message' => $message
                ]);
                $success_msg = "Thank you, $name! Your inquiry has been submitted successfully. Our team or seller will get back to you shortly.";
            } catch (PDOException $e) {
                $errors[] = "Database insertion error: " . $e->getMessage();
            }
        } else {
            // Demo mode fallback if DB offline
            $success_msg = "Thank you, $name! Your message was received (Demo Mode).";
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center mb-5 text-center">
        <div class="col-lg-7">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-2 font-monospace">CAMPUS SUPPORT</span>
            <h1 class="fw-bold">Contact & Inquiries</h1>
            <p class="text-muted">Have a question about a marketplace listing or need assistance with your account? Fill out the form below to get in touch.</p>
        </div>
    </div>

    <div class="row g-5">
        <!-- Contact Information Sidebar -->
        <div class="col-lg-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                <h4 class="fw-bold mb-4">Get in Touch</h4>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                        <i class="bi bi-geo-alt-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Campus Help Desk</h6>
                        <p class="text-muted small mb-0">Student Center, Suite 204<br>University Main Campus</p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                        <i class="bi bi-envelope-paper-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Support Email</h6>
                        <p class="text-muted small mb-0">unimart-support@university.edu</p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                        <i class="bi bi-clock-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Support Hours</h6>
                        <p class="text-muted small mb-0">Monday – Friday: 9:00 AM – 5:00 PM</p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-2">Safety Reminder</h6>
                <p class="text-muted small">
                    Never send money via wire transfers or off-campus payment apps to unknown sellers. Inspect physical items in person before paying.
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h3 class="fw-bold mb-4">Send Us a Message</h3>

                <!-- Feedback Notifications -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($success_msg); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            <div class="invalid-feedback">Name is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">University Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="student@university.edu" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <div class="invalid-feedback">Valid email is required.</div>
                        </div>

                        <div class="col-12">
                            <label for="subject" class="form-label fw-semibold">Subject / Item Reference</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Inquiry about Calculus Textbook..." required value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                            <div class="invalid-feedback">Subject is required.</div>
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message or inquiry here..." required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            <div class="invalid-feedback">Message must be at least 10 characters long.</div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary-custom px-4 py-2 fs-6">
                                <i class="bi bi-send-fill me-2"></i> Submit Inquiry
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
