<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - UniMart' : 'UniMart - Campus Student Marketplace'; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css for dynamic transitions -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../css/style.css' : 'css/style.css'; ?>">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../index.php' : 'index.php'; ?>">
            <i class="bi bi-shop text-primary fs-3"></i>
            <span>Uni</span>Mart
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" 
                       href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../index.php' : 'index.php'; ?>">
                       <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'marketplace.php') ? 'active' : ''; ?>" 
                       href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php'; ?>">
                       <i class="bi bi-grid-fill me-1"></i> Marketplace
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" 
                       href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../contact.php' : 'contact.php'; ?>">
                       <i class="bi bi-envelope me-1"></i> Contact Us
                    </a>
                </li>
            </ul>

            <!-- Auth Status Section -->
            <div class="d-flex align-items-center gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-6"></i>
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><span class="dropdown-item-text text-muted small">Signed in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? 'logout.php' : 'auth/logout.php'; ?>">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? 'login.php' : 'auth/login.php'; ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                    <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? 'register.php' : 'auth/register.php'; ?>" class="btn btn-primary-custom btn-sm px-3 rounded-pill fw-semibold">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Offline DB Notification if MySQL connection fails -->
<?php if (isset($pdo) && $pdo === null): ?>
    <div class="alert alert-warning alert-dismissible fade show mb-0 rounded-0 border-0 text-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Database Notice:</strong> MySQL server is offline. Previewing sample products in client demo mode. Please import <code>unimart_db.sql</code> into your local MySQL server (XAMPP/WAMP).
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
