/**
 * UniMart - Client-Side Interactive JavaScript Features
 * Fulfills requirements:
 * 1. Dynamic content filtering & updates (Marketplace live search, category & price slider filtering)
 * 2. Interactive image slider & preview modal
 * 3. Comprehensive client-side form validation (Contact, Register, Login)
 */

document.addEventListener('DOMContentLoaded', () => {
    initMarketplaceFilter();
    initFormValidation();
    initImageModal();
});

/* ==========================================================================
   Feature 1: Dynamic Content Updates & Item Filtering
   ========================================================================== */
function initMarketplaceFilter() {
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categoryFilter');
    const priceSlider = document.getElementById('priceRange');
    const priceDisplay = document.getElementById('priceValue');
    const productGrid = document.getElementById('productGrid');
    const productCards = document.querySelectorAll('.product-item-card');
    const itemCounter = document.getElementById('itemCounter');
    const noResultsMsg = document.getElementById('noResults');

    if (!productGrid) return; // Exit if not on marketplace page

    // Update price display live when slider moves
    if (priceSlider && priceDisplay) {
        priceSlider.addEventListener('input', (e) => {
            priceDisplay.textContent = `$${e.target.value}`;
            filterProducts();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', filterProducts);
    }

    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedCategory = categorySelect ? categorySelect.value : 'all';
        const maxPrice = priceSlider ? parseFloat(priceSlider.value) : 1000;

        let visibleCount = 0;

        productCards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const category = card.getAttribute('data-category');
            const price = parseFloat(card.getAttribute('data-price'));

            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = (selectedCategory === 'all' || category === selectedCategory);
            const matchesPrice = price <= maxPrice;

            if (matchesSearch && matchesCategory && matchesPrice) {
                card.style.display = 'block';
                card.classList.add('animate__fadeIn');
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update active visible count counter
        if (itemCounter) {
            itemCounter.textContent = `${visibleCount} item${visibleCount !== 1 ? 's' : ''} found`;
        }

        // Toggle "No Items Found" alert
        if (noResultsMsg) {
            if (visibleCount === 0) {
                noResultsMsg.style.display = 'block';
            } else {
                noResultsMsg.style.display = 'none';
            }
        }
    }
}

/* ==========================================================================
   Feature 2: Dynamic Modal Preview & Product Lightbox
   ========================================================================== */
function initImageModal() {
    const quickViewButtons = document.querySelectorAll('.btn-quick-view');
    const modalImage = document.getElementById('modalProductImg');
    const modalTitle = document.getElementById('modalProductTitle');
    const modalPrice = document.getElementById('modalProductPrice');
    const modalCategory = document.getElementById('modalProductCategory');
    const modalDesc = document.getElementById('modalProductDesc');
    const modalSeller = document.getElementById('modalProductSeller');

    quickViewButtons.forEach(button => {
        button.addEventListener('click', () => {
            const title = button.getAttribute('data-title');
            const price = button.getAttribute('data-price');
            const category = button.getAttribute('data-category');
            const desc = button.getAttribute('data-desc');
            const img = button.getAttribute('data-img');
            const seller = button.getAttribute('data-seller');

            if (modalTitle) modalTitle.textContent = title;
            if (modalPrice) modalPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
            if (modalCategory) modalCategory.textContent = category;
            if (modalDesc) modalDesc.textContent = desc;
            if (modalImage) modalImage.src = img;
            if (modalSeller) modalSeller.textContent = seller;
        });
    });
}

/* ==========================================================================
   Feature 3: Client-Side Form Validation (Contact, Login, Register)
   ========================================================================== */
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        // Real-time listener on inputs
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', () => validateField(input));
            input.addEventListener('blur', () => validateField(input));
        });

        // On Form Submit
        form.addEventListener('submit', (event) => {
            let isValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });

    function validateField(input) {
        const value = input.value.trim();
        let valid = true;
        let errorMsg = '';

        // Standard Required Check
        if (input.hasAttribute('required') && value === '') {
            valid = false;
            errorMsg = 'This field is required.';
        }
        // Email Validation
        else if (input.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                valid = false;
                errorMsg = 'Please enter a valid email address.';
            }
        }
        // Password Minimum Length Check
        else if (input.type === 'password' && input.id === 'password' && value !== '') {
            if (value.length < 6) {
                valid = false;
                errorMsg = 'Password must be at least 6 characters.';
            }
        }
        // Confirm Password Match Check
        else if (input.id === 'confirm_password') {
            const passField = document.getElementById('password');
            if (passField && value !== passField.value) {
                valid = false;
                errorMsg = 'Passwords do not match.';
            }
        }

        // Apply UI feedback classes
        const feedbackElem = input.nextElementSibling;

        if (!valid) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (feedbackElem && feedbackElem.classList.contains('invalid-feedback')) {
                feedbackElem.textContent = errorMsg;
            }
        } else if (value !== '') {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-invalid', 'is-valid');
        }

        return valid;
    }
}
