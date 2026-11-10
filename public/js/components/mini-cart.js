import {URL} from "../connection.js";

const miniCart = document.getElementById('miniCart');

if (miniCart) {
    const CURRENCY = miniCart.getAttribute('data-currency') || ((document.documentElement.getAttribute('lang') === 'ar') ? 'دج' : 'DA');
    const REMOVE_TITLE = miniCart.getAttribute('data-remove-title') || '';
    const QTY_LABEL = miniCart.getAttribute('data-qty-label') || '';

    const collapsedBtn = miniCart.querySelector('.mini-cart-collapsed-btn');
    const toggleBtn = miniCart.querySelector('.mini-cart-toggle-btn');
    const itemsContainer = miniCart.querySelector('.mini-cart-items');
    const emptyState = miniCart.querySelector('.mini-cart-empty');
    const countSpan = miniCart.querySelector('.mini-cart-count');
    const badgeSpan = miniCart.querySelector('.mini-cart-badge');
    const totalAmountSpan = miniCart.querySelector('.mini-cart-total-amount');
    const collapsedTotalSpan = miniCart.querySelector('.mini-cart-collapsed-total');

    // Restore minimized/expanded state from localStorage
    const savedMinimized = localStorage.getItem('miniCartMinimized');
    if (savedMinimized === 'true') {
        miniCart.classList.add('minimized');
    }

    // Minimize cart (تقليص)
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            miniCart.classList.add('minimized');
            localStorage.setItem('miniCartMinimized', 'true');
        });
    }

    // Expand cart (تكبير)
    if (collapsedBtn) {
        collapsedBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            miniCart.classList.remove('minimized');
            localStorage.setItem('miniCartMinimized', 'false');
        });
    }

    // Keep mini-cart positioned nicely on scroll
    function handleScrollPosition() {
        if (window.scrollY > 80) {
            miniCart.classList.add('scrolled');
        } else {
            miniCart.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleScrollPosition, { passive: true });
    handleScrollPosition();

    // Render mini-cart items and totals
    function renderMiniCart() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        itemsContainer.innerHTML = '';

        let totalPrice = 0;
        let totalCount = cartItems.length;

        if (totalCount === 0) {
            emptyState.style.display = 'flex';
            itemsContainer.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            itemsContainer.style.display = 'flex';

            // Show newest added items first (matching cart.js display order)
            const displayItems = [...cartItems].reverse();

            displayItems.forEach(function (item) {
                const unitPrice = parseInt(item.bookPrice, 10) || 0;
                const quantity = parseInt(item.bookQuantity, 10) || 1;
                const itemSubtotal = unitPrice * quantity;
                totalPrice += itemSubtotal;

                const itemEl = document.createElement('div');
                itemEl.className = 'mini-cart-item';
                itemEl.setAttribute('data-book-id', item.bookId);

                // Top section: Book title + Delete button
                const topRow = document.createElement('div');
                topRow.className = 'mini-cart-item-top';

                const titleLink = document.createElement('a');
                titleLink.className = 'mini-cart-item-title';
                titleLink.href = URL + 'browse/' + item.bookId;
                titleLink.textContent = item.bookTitle;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'mini-cart-item-remove';
                removeBtn.title = REMOVE_TITLE;
                removeBtn.setAttribute('data-book-id', item.bookId);
                removeBtn.innerHTML = '<i class="fa-solid fa-trash"></i>';

                removeBtn.addEventListener('click', function () {
                    removeItemFromCart(item.bookId);
                });

                topRow.appendChild(titleLink);
                topRow.appendChild(removeBtn);

                // Bottom section: Quantity controls + Item subtotal
                const bottomRow = document.createElement('div');
                bottomRow.className = 'mini-cart-item-bottom';

                const qtyControl = document.createElement('div');
                qtyControl.className = 'mini-cart-qty-control';

                const minusBtn = document.createElement('button');
                minusBtn.type = 'button';
                minusBtn.className = 'mini-cart-qty-btn minus';
                minusBtn.innerHTML = '<i class="fa-solid fa-minus"></i>';
                minusBtn.disabled = quantity <= 1;

                const qtySelect = document.createElement('select');
                qtySelect.className = 'mini-cart-qty-select';
                qtySelect.title = QTY_LABEL;
                for (let i = 1; i <= 5; i++) {
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = i;
                    if (i === quantity) {
                        opt.selected = true;
                    }
                    qtySelect.appendChild(opt);
                }

                const plusBtn = document.createElement('button');
                plusBtn.type = 'button';
                plusBtn.className = 'mini-cart-qty-btn plus';
                plusBtn.innerHTML = '<i class="fa-solid fa-plus"></i>';
                plusBtn.disabled = quantity >= 5;

                minusBtn.addEventListener('click', function () {
                    if (quantity > 1) {
                        updateItemQuantity(item.bookId, quantity - 1);
                    }
                });

                plusBtn.addEventListener('click', function () {
                    if (quantity < 5) {
                        updateItemQuantity(item.bookId, quantity + 1);
                    }
                });

                qtySelect.addEventListener('change', function (e) {
                    const newQty = parseInt(e.target.value, 10);
                    if (newQty >= 1 && newQty <= 5) {
                        updateItemQuantity(item.bookId, newQty);
                    }
                });

                qtyControl.appendChild(minusBtn);
                qtyControl.appendChild(qtySelect);
                qtyControl.appendChild(plusBtn);

                const pricesDiv = document.createElement('div');
                pricesDiv.className = 'mini-cart-item-prices';

                const subtotalSpan = document.createElement('span');
                subtotalSpan.className = 'mini-cart-item-subtotal';
                subtotalSpan.textContent = itemSubtotal + CURRENCY;

                pricesDiv.appendChild(subtotalSpan);

                if (quantity > 1) {
                    const unitSpan = document.createElement('span');
                    unitSpan.className = 'mini-cart-item-unit';
                    unitSpan.textContent = quantity + ' × ' + unitPrice + CURRENCY;
                    pricesDiv.appendChild(unitSpan);
                }

                bottomRow.appendChild(qtyControl);
                bottomRow.appendChild(pricesDiv);

                itemEl.appendChild(topRow);
                itemEl.appendChild(bottomRow);

                itemsContainer.appendChild(itemEl);
            });
        }

        // Update counts and totals
        if (countSpan) countSpan.textContent = '(' + totalCount + ')';
        if (badgeSpan) badgeSpan.textContent = totalCount;
        if (totalAmountSpan) totalAmountSpan.textContent = totalPrice + CURRENCY;
        if (collapsedTotalSpan) collapsedTotalSpan.textContent = totalPrice + CURRENCY;
    }

    function updateItemQuantity(bookId, newQuantity) {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        let updated = false;

        cartItems.forEach(function (cartItem) {
            if (String(cartItem.bookId) === String(bookId)) {
                cartItem.bookQuantity = newQuantity;
                updated = true;
            }
        });

        if (updated) {
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            renderMiniCart();
            window.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { source: 'mini-cart', bookId: bookId, quantity: newQuantity }
            }));
        }
    }

    function removeItemFromCart(bookId) {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const index = cartItems.findIndex(function (item) {
            return String(item.bookId) === String(bookId);
        });

        if (index !== -1) {
            cartItems.splice(index, 1);
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            renderMiniCart();
            window.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { source: 'mini-cart', removedBookId: bookId }
            }));
        }
    }

    // Listen for cart updates triggered from book-item.js, book-details.js, or other tabs
    window.addEventListener('cartUpdated', function (e) {
        if (!e.detail || e.detail.source !== 'mini-cart') {
            renderMiniCart();
            if (e.detail && e.detail.addedBookId) {
                miniCart.classList.remove('pulse');
                void miniCart.offsetWidth; // trigger reflow for animation
                miniCart.classList.add('pulse');
            }
        }
    });

    window.addEventListener('storage', function (e) {
        if (e.key === 'cartItems') {
            renderMiniCart();
        }
    });

    // Initial render
    renderMiniCart();
}

