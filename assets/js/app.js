document.addEventListener('DOMContentLoaded', function () {
    const nav = document.querySelector('nav');
    const navToggle = document.querySelector('.nav-toggle');

    if (navToggle && nav) {
        navToggle.addEventListener('click', function () {
            nav.classList.toggle('nav-open');
        });
    }

    document.addEventListener('click', function (event) {
        if (nav && nav.classList.contains('nav-open') && !nav.contains(event.target)) {
            nav.classList.remove('nav-open');
        }
    });

    const authForm = document.querySelector('form[action="login.php"], form[action="signup.php"]');
    if (authForm) {
        authForm.addEventListener('submit', function (event) {
            const requiredInputs = Array.from(authForm.querySelectorAll('input[required]'));
            const emptyFields = requiredInputs.filter(function (input) {
                return input.value.trim() === '';
            });

            if (emptyFields.length > 0) {
                event.preventDefault();
                showFormAlert(authForm, 'Please complete all required fields.');
                emptyFields[0].focus();
                return;
            }

            const emailField = authForm.querySelector('input[type="email"]');
            if (emailField && emailField.value && !validateEmail(emailField.value.trim())) {
                event.preventDefault();
                showFormAlert(authForm, 'Please enter a valid email address.');
                emailField.focus();
                return;
            }

            const passwordField = authForm.querySelector('input[name="password"]');
            const confirmField = authForm.querySelector('input[name="confirm_password"]');
            if (passwordField && confirmField && passwordField.value !== confirmField.value) {
                event.preventDefault();
                showFormAlert(authForm, 'Passwords do not match.');
                confirmField.focus();
                return;
            }
        });
    }

    function showFormAlert(form, message) {
        let alertBox = form.querySelector('.form-alert');
        if (!alertBox) {
            alertBox = document.createElement('div');
            alertBox.className = 'form-alert';
            form.insertBefore(alertBox, form.firstChild);
        }
        alertBox.textContent = message;
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    const filterBar = document.querySelector('.filter-bar');
    const productCards = Array.from(document.querySelectorAll('.products-grid .product-card'));
    if (filterBar && productCards.length) {
        const searchInput = filterBar.querySelector('.search-input');
        const categorySelect = filterBar.querySelector('.filter-select');
        const countDisplay = filterBar.querySelector('.product-count');

        function createNoResultsMessage() {
            let noResults = document.querySelector('.product-filter-empty');
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.className = 'product-filter-empty empty-state';
                noResults.innerHTML = '<div class="icon">🔍</div><h3>No products match your search</h3><p>Try a different keyword or category.</p>';
                const productsGrid = document.querySelector('.products-grid');
                if (productsGrid) productsGrid.parentNode.insertBefore(noResults, productsGrid.nextSibling);
            }
            return noResults;
        }

        function updateProductFilter() {
            const searchTerm = searchInput ? searchInput.value.trim().toLowerCase() : '';
            const selectedCategory = categorySelect ? categorySelect.value : 'all';
            let shownCount = 0;

            productCards.forEach(function (card) {
                const name = card.querySelector('.product-name')?.textContent.toLowerCase() || '';
                const desc = card.querySelector('.product-desc')?.textContent.toLowerCase() || '';
                const category = card.querySelector('.product-category')?.textContent.toLowerCase() || '';

                const searchMatch = searchTerm === '' || name.includes(searchTerm) || desc.includes(searchTerm);
                const categoryMatch = selectedCategory === 'all' || category === selectedCategory.toLowerCase();
                const visible = searchMatch && categoryMatch;

                card.style.display = visible ? '' : 'none';
                if (visible) shownCount += 1;
            });

            if (countDisplay) {
                countDisplay.textContent = shownCount + ' product' + (shownCount !== 1 ? 's' : '');
            }

            const noResults = createNoResultsMessage();
            noResults.style.display = shownCount === 0 ? 'block' : 'none';
        }

        const sortSelect = filterBar.querySelector('.sort-select');

        function sortProductCards(order) {
            const container = document.querySelector('.products-grid');
            if (!container) return;

            const cards = Array.from(container.querySelectorAll('.product-card'));
            if (order === 'default') return;

            const sorted = cards.slice().sort(function (a, b) {
                const priceA = parseFloat(a.querySelector('.product-price')?.textContent.replace(/[^0-9.]/g, '') || '0');
                const priceB = parseFloat(b.querySelector('.product-price')?.textContent.replace(/[^0-9.]/g, '') || '0');
                return order === 'price-asc' ? priceA - priceB : priceB - priceA;
            });

            sorted.forEach(function (card) {
                container.appendChild(card);
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', updateProductFilter);
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', updateProductFilter);
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                sortProductCards(sortSelect.value);
            });
        }

        updateProductFilter();
    }
});