<!-- Footer -->
<footer class="footer-custom">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="d-flex align-items-center gap-2">
                    <i class="bi bi-shop text-primary"></i> UniMart
                </h5>
                <p class="small text-secondary">
                    The premier student-to-student campus marketplace. Buy, sell, and trade textbooks, electronics, dorm furniture, and gear safely within your university community.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-twitter-x fs-5"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-github fs-5"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Navigation</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../index.php' : 'index.php'; ?>">Home</a></li>
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php'; ?>">Browse Marketplace</a></li>
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../contact.php' : 'contact.php'; ?>">Help & Support</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Popular Categories</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php?category=Books'; ?>">Textbooks & Coursework</a></li>
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php?category=Electronics'; ?>">Electronics & Gadgets</a></li>
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php?category=Furniture'; ?>">Dorm Furniture</a></li>
                    <li><a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../marketplace.php' : 'marketplace.php?category=Sports'; ?>">Sports & Bicycles</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Campus Safety Tip</h5>
                <div class="p-3 rounded bg-dark border border-secondary border-opacity-25 small text-secondary">
                    <i class="bi bi-shield-check text-success fs-5 me-1"></i>
                    Always meet buyers and sellers in public campus areas (e.g. Student Union, Library Lobby) during daytime hours.
                </div>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-secondary">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> UniMart Campus Marketplace. Built for University Mini-Project.</p>
            <p class="mb-0">Powered by PHP, MySQL, Bootstrap & JavaScript</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JavaScript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JavaScript -->
<script src="<?php echo (strpos($_SERVER['PHP_SELF'], '/auth/') !== false) ? '../js/main.js' : 'js/main.js'; ?>"></script>
</body>
</html>
