<?php
require_once __DIR__ . '/includes/db.php';
$page_title = "Home - Campus Student Marketplace";
require_once __DIR__ . '/includes/header.php';

// Fetch Featured Products from DB
$featured_products = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 6");
        $featured_products = $stmt->fetchAll();
    } catch (PDOException $e) {
        $featured_products = [];
    }
}

// Fallback seed array if DB is empty or offline
if (empty($featured_products)) {
    $featured_products = [
        [
            'id' => 1,
            'title' => 'Calculus: Early Transcendentals (8th Ed)',
            'category' => 'Books',
            'price' => '45.00',
            'condition_type' => 'Like New',
            'description' => 'Essential textbook for MAT101 & MAT102. No highlights inside.',
            'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Sarah M.'
        ],
        [
            'id' => 2,
            'title' => 'Logitech Wireless Headphones',
            'category' => 'Electronics',
            'price' => '65.00',
            'condition_type' => 'Used - Good',
            'description' => 'Great sound quality for library study sessions. Includes charger.',
            'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'David K.'
        ],
        [
            'id' => 3,
            'title' => 'Ergonomic Mesh Desk Chair',
            'category' => 'Furniture',
            'price' => '55.00',
            'condition_type' => 'Good',
            'description' => 'Super comfortable for long study nights. Adjustable lumbar support.',
            'image_url' => 'https://images.unsplash.com/photo-1580481072645-022f9a6d1203?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Emma W.'
        ],
        [
            'id' => 4,
            'title' => '21-Speed City Commuter Bicycle',
            'category' => 'Sports',
            'price' => '120.00',
            'condition_type' => 'Fair',
            'description' => 'Includes heavy-duty U-lock and helmet. Ready to ride across campus.',
            'image_url' => 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Marcus B.'
        ]
    ];
}
?>

<!-- Hero Banner Section -->
<section class="hero-section text-center text-lg-start mb-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-primary bg-opacity-20 text-info mb-3 px-3 py-2 rounded-pill font-monospace text-uppercase tracking-wider">
                    <i class="bi bi-mortarboard-fill me-1"></i> Verified Campus Marketplace
                </span>
                <h1 class="hero-title mb-3">Buy & Sell Items Across Campus Safely</h1>
                <p class="hero-subtitle mb-4">
                    UniMart connects university students to trade textbooks, electronics, dorm essentials, and gear with fellow students right on campus.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="marketplace.php" class="btn btn-primary-custom btn-lg px-4 rounded-pill">
                        <i class="bi bi-search me-2"></i> Explore Marketplace
                    </a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                        <i class="bi bi-chat-dots me-2"></i> Ask a Question
                    </a>
                </div>
            </div>

            <!-- Feature Carousel / Slider (JS Feature) -->
            <div class="col-lg-6">
                <div id="heroCarousel" class="carousel slide slider-container" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80" class="d-block w-100" alt="Textbooks">
                            <div class="carousel-caption carousel-caption-custom">
                                <span class="badge bg-success mb-1">Save up to 70%</span>
                                <h5 class="text-white fw-bold mb-1">Course Textbooks & Notes</h5>
                                <p class="small text-light mb-0">Buy used textbooks directly from students who took the class last semester.</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" class="d-block w-100" alt="Electronics">
                            <div class="carousel-caption carousel-caption-custom">
                                <span class="badge bg-primary mb-1">Tech Deals</span>
                                <h5 class="text-white fw-bold mb-1">Laptops, Headphones & Tablets</h5>
                                <p class="small text-light mb-0">Affordable student electronics checked and sold locally.</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1580481072645-022f9a6d1203?auto=format&fit=crop&w=800&q=80" class="d-block w-100" alt="Dorm Furniture">
                            <div class="carousel-caption carousel-caption-custom">
                                <span class="badge bg-info text-dark mb-1">Dorm Living</span>
                                <h5 class="text-white fw-bold mb-1">Dorm Furniture & Mini Fridges</h5>
                                <p class="small text-light mb-0">Everything you need to set up your dorm room on a student budget.</p>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feature Value Cards -->
<div class="container my-5">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-shield-lock-fill fs-2"></i>
                </div>
                <h4 class="fw-bold">Campus Verified</h4>
                <p class="text-muted small mb-0">Connect exclusively with verified university email addresses for trusted, safe transactions.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-currency-dollar fs-2"></i>
                </div>
                <h4 class="fw-bold">Zero Commissions</h4>
                <p class="text-muted small mb-0">Keep 100% of your earnings. No listing fees or hidden platform charges for students.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-geo-alt-fill fs-2"></i>
                </div>
                <h4 class="fw-bold">Instant Campus Pickup</h4>
                <p class="text-muted small mb-0">No waiting for shipping! Handshake meetups in student unions, libraries, or dorm plazas.</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Items Grid -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Featured Campus Listings</h2>
            <p class="text-muted mb-0 small">Hand-picked recent items from fellow students</p>
        </div>
        <a href="marketplace.php" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
            View All Items <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php foreach ($featured_products as $item): ?>
            <div class="col-lg-3 col-md-6">
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <span class="category-badge"><?php echo htmlspecialchars($item['category']); ?></span>
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="product-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <span class="price-tag">$<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                    <div class="product-body">
                        <h5 class="product-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                        <p class="product-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="product-footer">
                            <span><i class="bi bi-person me-1"></i> <?php echo htmlspecialchars($item['seller_name']); ?></span>
                            <span class="badge bg-secondary opacity-75"><?php echo htmlspecialchars($item['condition_type']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Lightbox Quick View Modal (JS Feature) -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 overflow-hidden">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-6 bg-light">
                        <img id="modalProductImg" src="" class="w-100 h-100 object-fit-cover" style="min-height: 300px;" alt="Product preview">
                    </div>
                    <div class="col-md-6 p-4 d-flex flex-direction-column">
                        <button type="button" class="btn-close ms-auto mb-2" data-bs-dismiss="modal"></button>
                        <span id="modalProductCategory" class="badge bg-primary rounded-pill mb-2 w-fit-content">Category</span>
                        <h3 id="modalProductTitle" class="fw-bold mb-2">Item Title</h3>
                        <h4 id="modalProductPrice" class="text-primary fw-bold mb-3">$0.00</h4>
                        <p id="modalProductDesc" class="text-muted small mb-4">Description details go here...</p>
                        <div class="mt-auto border-top pt-3">
                            <p class="small text-muted mb-2">Seller: <strong id="modalProductSeller">User</strong></p>
                            <a href="contact.php" class="btn btn-primary-custom w-100 rounded-pill">
                                <i class="bi bi-chat-text-fill me-2"></i> Contact Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
