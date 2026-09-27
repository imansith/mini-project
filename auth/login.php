<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$page_title = "Student Login";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($password)) {
        $errors[] = "Please enter your password.";
    }

    if (empty($errors)) {
        if (isset($pdo) && $pdo !== null) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Password matches - Create session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];

                    header("Location: ../index.php?login=success");
                    exit();
                } else {
                    $errors[] = "Invalid email or password credentials.";
                }
            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        } else {
            // Offline Demo Login Fallback
            if ($email === 'student@university.edu' || !empty($email)) {
                $username_parts = explode('@', $email);
                $_SESSION['user_id'] = 999;
                $_SESSION['username'] = $username_parts[0];
                $_SESSION['email'] = $email;

                header("Location: ../index.php?login=success");
                exit();
            }
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-2">
                        <i class="bi bi-box-arrow-in-right fs-2"></i>
                    </div>
                    <h2 class="fw-bold">Welcome Back</h2>
                    <p class="text-muted small">Log in to access campus listings and inquiries</p>
                </div>

                <!-- Display Errors -->
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

                <!-- Login Form -->
                <form action="login.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">University Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="student@university.edu" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <div class="invalid-feedback">Please enter your email.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fs-6">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">Don't have an account yet? <a href="register.php" class="fw-bold text-primary text-decoration-none">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
