<?php
require_once __DIR__ . '/../includes/db.php';

$page_title = "Student Registration";
$errors = [];
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Server-Side Validations
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Password confirmation does not match.";
    }

    // Check Database if email or username already exists
    if (empty($errors) && isset($pdo) && $pdo !== null) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1");
            $stmt->execute(['username' => $username, 'email' => $email]);
            
            if ($stmt->fetch()) {
                $errors[] = "A user with this username or email already exists.";
            } else {
                // Securely Hash Password using password_hash()
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insertStmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $insertStmt->execute([
                    'username' => $username,
                    'email'    => $email,
                    'password' => $hashed_password
                ]);

                $success_msg = "Account created successfully! You can now log in.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    } elseif (empty($errors) && ($pdo === null)) {
        // Fallback simulation mode if MySQL server is off
        $success_msg = "Account created successfully! (Offline Demo Mode)";
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h2 class="fw-bold">Create an Account</h2>
                    <p class="text-muted small">Join UniMart to start buying and selling on campus</p>
                </div>

                <!-- Display Server Feedback Errors -->
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

                <!-- Display Success Alert -->
                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($success_msg); ?>
                        <div class="mt-2">
                            <a href="login.php" class="btn btn-sm btn-success px-4 rounded-pill">Proceed to Login</a>
                        </div>
                    </div>
                <?php else: ?>

                <!-- Registration Form -->
                <form action="register.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="e.g. john_doe" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                            <div class="invalid-feedback">Username is required.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">University Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="student@university.edu" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <div class="invalid-feedback">Valid email address is required.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="At least 6 characters" required>
                            <div class="invalid-feedback">Password must be at least 6 characters.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
                            <div class="invalid-feedback">Passwords must match.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fs-6">
                        <i class="bi bi-person-check-fill me-2"></i> Register Account
                    </button>
                </form>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">Already have an account? <a href="login.php" class="fw-bold text-primary text-decoration-none">Log In here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
