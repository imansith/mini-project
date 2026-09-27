<?php
require_once __DIR__ . '/includes/db.php';
$page_title = "Marketplace - Browse Campus Items";
require_once __DIR__ . '/includes/header.php';

// Fetch products from database
$products = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        $products = [];
    }
}

// Fallback seed data if DB is empty/offline
if (empty($products)) {
    $products = [
        [
            'id' => 1,
            'title' => 'Calculus: Early Transcendentals (8th Ed)',
            'category' => 'Books',
            'price' => '45.00',
            'condition_type' => 'Like New',
            'description' => 'Essential textbook for MAT101 & MAT102. No highlights or markings inside.',
            'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Sarah M.'
        ],
        [
            'id' => 2,
            'title' => 'Logitech Wireless Headphones',
            'category' => 'Electronics',
            'price' => '65.00',
            'condition_type' => 'Used - Good',
            'description' => 'Great sound quality for library study sessions. Includes charging cable and travel pouch.',
            'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'David K.'
        ],
        [
            'id' => 3,
            'title' => 'Ergonomic Mesh Desk Chair',
            'category' => 'Furniture',
            'price' => '55.00',
            'condition_type' => 'Good',
            'description' => 'Super comfortable for long study nights. Adjustable height and lumbar support.',
            'image_url' => 'https://images.unsplash.com/photo-1580481072645-022f9a6d1203?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Emma W.'
        ],
        [
            'id' => 4,
            'title' => '21-Speed City Commuter Bicycle',
            'category' => 'Sports',
            'price' => '120.00',
            'condition_type' => 'Fair',
            'description' => 'Includes heavy-duty U-lock and helmet. Perfect for getting across campus quickly.',
            'image_url' => 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Marcus B.'
        ],
        [
            'id' => 5,
            'title' => 'Mini Fridge (3.2 cu. ft. with Freezer)',
            'category' => 'Appliances',
            'price' => '85.00',
            'condition_type' => 'Like New',
            'description' => 'Clean and quiet mini fridge. Perfect for dorm rooms or shared apartments.',
            'image_url' => 'https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Jessica T.'
        ],
        [
            'id' => 6,
            'title' => 'iPad Air (64GB) with Apple Pencil 2',
            'category' => 'Electronics',
            'price' => '340.00',
            'condition_type' => 'Like New',
            'description' => 'Includes original box, case, and screen protector installed. Ideal for digital note taking.',
            'image_url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
            'seller_name' => 'Liam R.'
        ]
    ];
}
?>

<div class="container py-4">
    <!-- Page Header Banner -->
    <div class="p-4 p-md-5 mb-4 rounded-4 text-white bg-dark position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">Campus Marketplace</h1>
                <p class="mb-0 text-light opacity-90">Find books, electronics, dorm gear, and course essentials listed by fellow students.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-primary fs-6 px-3 py-2 rounded-pill shadow-sm" id="itemCounter">
                    <?php echo count($products); ?> items available
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filter Controls (Dynamic JS Filter) -->
        <div class="col-lg-3">
            <div class="filter-card sticky-top" style="top: 90px; z-index: 10;">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-funnel-fill text-primary"></i> Filter Items
                </h5>

                <!-- Search Input -->
                <div class="mb-3">
                    <label for="searchInput" class="form-label small fw-semibold text-muted">Search Keyword</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search by title...">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="mb-3">
                    <label for="categoryFilter" class="form-label small fw-semibold text-muted">Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="Books">Books & Coursework</option>
                        <option value="Electronics">Electronics & Gadgets</option>
                        <option value="Furniture">Furniture & Decor</option>
                        <option value="Sports">Sports & Bicycles</option>
                        <option value="Appliances">Appliances & Dorm</option>
                    </select>
                </div>

                <!-- Max Price Slider -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="priceRange" class="form-label small fw-semibold text-muted mb-0">Max Price</label>
                        <span class="fw-bold text-primary" id="priceValue">$500</span>
                    </div>
                    <input type="range" class="form-range" id="priceRange" min="10" max="500" step="5" value="500">
                </div>

                <button class="btn btn-outline-secondary btn-sm w-100 mt-2" onclick="document.getElementById('searchInput').value=''; document.getElementById('categoryFilter').value='all'; document.getElementById('priceRange').value=500; document.getElementById('priceRange').dispatchEvent(new Event('input'));">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                </button>
            </div>
        </div>

        <!-- Main Product Grid -->
        <div class="col-lg-9">
            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5 bg-white rounded-4 border" style="display: none;">
                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold">No matching items found</h4>
                <p class="text-muted small">Try adjusting your search query or price filter.</p>
            </div>

            <div class="row g-4" id="productGrid">
                <?php foreach ($products as $item): ?>
                    <div class="col-md-6 col-lg-4 product-item-card" 
                         data-title="<?php echo htmlspecialchars($item['title']); ?>" 
                         data-category="<?php echo htmlspecialchars($item['category']); ?>" 
                         data-price="<?php echo htmlspecialchars($item['price']); ?>">
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <span class="category-badge"><?php echo htmlspecialchars($item['category']); ?></span>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="product-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <span class="price-tag">$<?php echo number_format($item['price'], 2); ?></span>
                            </div>
                            <div class="product-body">
                                <h5 class="product-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <p class="product-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark border me-1"><i class="bi bi-info-circle me-1"></i><?php echo htmlspecialchars($item['condition_type']); ?></span>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-person me-1"></i><?php echo htmlspecialchars($item['seller_name']); ?></span>
                                </div>
                                <button type="button" 
                                        class="btn btn-outline-primary btn-sm w-100 rounded-pill mt-auto btn-quick-view" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#quickViewModal"
                                        data-title="<?php echo htmlspecialchars($item['title']); ?>"
                                        data-price="<?php echo htmlspecialchars($item['price']); ?>"
                                        data-category="<?php echo htmlspecialchars($item['category']); ?>"
                                        data-desc="<?php echo htmlspecialchars($item['description']); ?>"
                                        data-img="<?php echo htmlspecialchars($item['image_url']); ?>"
                                        data-seller="<?php echo htmlspecialchars($item['seller_name']); ?>">
                                    <i class="bi bi-eye me-1"></i> Quick View Details
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quick View Dialog -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-6 bg-light">
                        <img id="modalProductImg" src="" class="w-100 h-100 object-fit-cover" style="min-height: 320px;" alt="Product image">
                    </div>
                    <div class="col-md-6 p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span id="modalProductCategory" class="badge bg-primary rounded-pill px-3 py-2">Category</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <h3 id="modalProductTitle" class="fw-bold mb-2">Item Title</h3>
                        <h4 id="modalProductPrice" class="text-primary fw-bold mb-3">$0.00</h4>
                        <p id="modalProductDesc" class="text-muted small mb-4">Description text...</p>
                        <div class="mt-auto border-top pt-3">
                            <p class="small text-muted mb-3"><i class="bi bi-person-check-fill text-success me-1"></i> Seller: <strong id="modalProductSeller">User</strong></p>
                            <a href="contact.php" class="btn btn-primary-custom w-100 rounded-pill">
                                <i class="bi bi-envelope-paper-fill me-2"></i> Send Inquiry to Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
