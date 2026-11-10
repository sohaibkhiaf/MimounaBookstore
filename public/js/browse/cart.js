import {URL} from "../connection.js";

var LANGUAGE = document.documentElement.getAttribute('lang');
var CURRENCY = (LANGUAGE == 'ar') ? 'دج' : 'DA';

// initialize cart items /////////////////////

var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
cartItems.reverse();

// show empty cart message ///////////////////

var cartContainer = document.querySelector('.cart .cart-container');
var table = document.querySelector('.cart .cart-container table');

if(cartItems.length == 0){

    // remove the table
    table.remove();

    // insert the message

    if(LANGUAGE == 'ar'){
        cartContainer.innerHTML = '<div class="no-items">'+
            '<i class="fa-solid fa-circle-exclamation"></i><br>'+
            'ليس لديك أي عناصر في السلة، <a href="'+URL+'browse/shop">تسوق الآن!</a>'+
        '</div>';
    }else if(LANGUAGE == 'fr'){
        cartContainer.innerHTML = '<div class="no-items">'+
            '<i class="fa-solid fa-circle-exclamation"></i><br>'+
            'Vous n’avez aucun article dans votre panier, <a href="'+URL+'browse/shop">Achetez maintenant !</a>'+
        '</div>';
    }else {
        cartContainer.innerHTML = '<div class="no-items">'+
            '<i class="fa-solid fa-circle-exclamation"></i><br>'+
            'You don\'t have any items in Cart, <a href="'+URL+'browse/shop">Shop Now!</a>'+
        '</div>';
    }

    // style the message
    var noItemsMessage = document.querySelector('.cart .cart-container .no-items');
    noItemsMessage.style.fontSize = "2.5rem";
    noItemsMessage.style.color = "#222";
    noItemsMessage.style.textAlign = "center";
    noItemsMessage.style.marginTop = "4rem";

    var shopNowMessage = document.querySelector('.cart .cart-container .no-items a');
    shopNowMessage.style.color = "#a81f23";
    shopNowMessage.style.textDecoration = "none";
    shopNowMessage.style.fontWeight = "bold";

    var iconMessage = document.querySelector('.cart .cart-container .no-items i');
    iconMessage.style.fontSize = "8rem";
    iconMessage.style.marginBottom = "2rem";
}else{

    var shippingPriceEl = document.querySelector('.shipping-price');
    var regionId = shippingPriceEl.getAttribute('data-region-id');
    var guestShippingForm = document.querySelector('.guest-shipping-form');
    var isGuest = guestShippingForm !== null;

    var shippingPriceSelector = document.querySelector('.shipping-price-selector');
    var guestRegionSelector = document.querySelector('.guest-region-selector');
    var guestNameInput = document.querySelector('.guest-name');
    var guestPhoneInput = document.querySelector('.guest-phone');
    var guestAddressInput = document.querySelector('.guest-address');
    var guestUnavailableEl = document.querySelector('.guest-shipping-unavailable');
    var guestFormErrorEl = document.querySelector('.guest-form-error');
    var checkoutButton = document.querySelector('.checkout');

    // calculate subtotal ////////////////////////
    var sbtl = 0;
    cartItems.forEach(function(cartItem){
        sbtl += cartItem.bookPrice * cartItem.bookQuantity;
    });

    var subtotal = document.querySelector(".subtotal");
    subtotal.innerHTML = sbtl + CURRENCY;

    // helper to recalculate shipping and total
    var dlv = 0;

    function updateTotals() {
        dlv = 0;

        if (!isGuest && regionId != 0) {
            if (shippingPriceSelector) {
                var homeShipping = shippingPriceSelector.getAttribute("data-home-shipping");
                var deskShipping = shippingPriceSelector.getAttribute("data-desk-shipping");

                if (shippingPriceSelector.value == 1) {
                    shippingPriceEl.innerHTML = homeShipping + CURRENCY;
                    dlv = parseInt(homeShipping) || 0;
                } else {
                    shippingPriceEl.innerHTML = deskShipping + CURRENCY;
                    dlv = parseInt(deskShipping) || 0;
                }
            }
        } else if (isGuest && guestRegionSelector) {
            var selectedOption = guestRegionSelector.options[guestRegionSelector.selectedIndex];
            var selectedRegionId = guestRegionSelector.value;
            var isEnabled = selectedOption ? selectedOption.getAttribute('data-enabled') == '1' : false;

            if (selectedRegionId && isEnabled) {
                var gHome = selectedOption.getAttribute('data-home-shipping');
                var gDesk = selectedOption.getAttribute('data-desk-shipping');

                if (shippingPriceSelector.value == 1) {
                    shippingPriceEl.innerHTML = gHome + CURRENCY;
                    dlv = parseInt(gHome) || 0;
                } else {
                    shippingPriceEl.innerHTML = gDesk + CURRENCY;
                    dlv = parseInt(gDesk) || 0;
                }
            } else {
                shippingPriceEl.innerHTML = '-';
                dlv = 0;
            }
        }

        var total = document.querySelector('.total');
        var ttl = parseInt(sbtl) + parseInt(dlv);
        total.innerHTML = ttl + CURRENCY;
    }

    // initialize shipping selector from localStorage
    if (shippingPriceSelector) {
        var savedShippingType = localStorage.getItem('shippingType');
        if (savedShippingType != null) {
            shippingPriceSelector.value = savedShippingType;
        } else {
            shippingPriceSelector.value = 1;
        }

        shippingPriceSelector.addEventListener('change', function(event) {
            localStorage.setItem('shippingType', event.target.value);
            updateTotals();
        });
    }

    // handle guest region selection and saved guest info
    if (isGuest) {
        var savedGuestInfo = JSON.parse(localStorage.getItem('guestShippingInfo') || '{}');
        if (savedGuestInfo.name && guestNameInput) guestNameInput.value = savedGuestInfo.name;
        if (savedGuestInfo.phone && guestPhoneInput) guestPhoneInput.value = savedGuestInfo.phone;
        if (savedGuestInfo.address && guestAddressInput) guestAddressInput.value = savedGuestInfo.address;
        if (savedGuestInfo.region && guestRegionSelector) {
            guestRegionSelector.value = savedGuestInfo.region;
        }

        function saveGuestDraft() {
            localStorage.setItem('guestShippingInfo', JSON.stringify({
                name: guestNameInput ? guestNameInput.value : '',
                phone: guestPhoneInput ? guestPhoneInput.value : '',
                region: guestRegionSelector ? guestRegionSelector.value : '',
                address: guestAddressInput ? guestAddressInput.value : ''
            }));
        }

        function onGuestRegionChange() {
            var selectedOption = guestRegionSelector.options[guestRegionSelector.selectedIndex];
            var selectedVal = guestRegionSelector.value;
            var isEnabled = selectedOption ? selectedOption.getAttribute('data-enabled') == '1' : false;
            var regionName = selectedOption ? selectedOption.getAttribute('data-region-name') : '';

            var homeLabel = shippingPriceSelector.getAttribute('data-home-label');
            var deskLabel = shippingPriceSelector.getAttribute('data-desk-label');

            if (!selectedVal) {
                shippingPriceSelector.disabled = true;
                shippingPriceSelector.options[0].textContent = homeLabel;
                shippingPriceSelector.options[1].textContent = deskLabel;
                shippingPriceEl.setAttribute('data-region-id', '0');
                if (guestUnavailableEl) guestUnavailableEl.style.display = 'none';
                if (checkoutButton) checkoutButton.style.display = 'inline-block';
            } else if (!isEnabled) {
                shippingPriceSelector.disabled = true;
                shippingPriceSelector.options[0].textContent = homeLabel;
                shippingPriceSelector.options[1].textContent = deskLabel;
                shippingPriceEl.setAttribute('data-region-id', selectedVal);
                if (guestUnavailableEl) {
                    var template = guestUnavailableEl.getAttribute('data-template') || '';
                    guestUnavailableEl.textContent = template.replace(':region_name', regionName);
                    guestUnavailableEl.style.display = 'block';
                }
                if (checkoutButton) checkoutButton.style.display = 'none';
            } else {
                var gHome = selectedOption.getAttribute('data-home-shipping');
                var gDesk = selectedOption.getAttribute('data-desk-shipping');

                shippingPriceSelector.disabled = false;
                shippingPriceSelector.setAttribute('data-home-shipping', gHome);
                shippingPriceSelector.setAttribute('data-desk-shipping', gDesk);
                shippingPriceSelector.options[0].textContent = homeLabel + ' (' + gHome + CURRENCY + ')';
                shippingPriceSelector.options[1].textContent = deskLabel + ' (' + gDesk + CURRENCY + ')';
                shippingPriceEl.setAttribute('data-region-id', selectedVal);

                if (guestUnavailableEl) guestUnavailableEl.style.display = 'none';
                if (checkoutButton) checkoutButton.style.display = 'inline-block';
            }

            saveGuestDraft();
            updateTotals();
        }

        if (guestRegionSelector) {
            guestRegionSelector.addEventListener('change', function() {
                guestRegionSelector.classList.remove('input-error');
                if (guestFormErrorEl) guestFormErrorEl.style.display = 'none';
                onGuestRegionChange();
            });
            onGuestRegionChange();
        }

        [guestNameInput, guestPhoneInput, guestAddressInput].forEach(function(input) {
            if (input) {
                input.addEventListener('input', function() {
                    input.classList.remove('input-error');
                    if (guestFormErrorEl) guestFormErrorEl.style.display = 'none';
                    saveGuestDraft();
                });
            }
        });
    } else {
        updateTotals();
    }

    // set cart items number  //////////////////////
    var numOfItems = document.querySelector('.cart .cart-container h3 span');
    numOfItems.innerHTML = "(" + cartItems.length + ")";

    //  inject cart items  ///////////////////////
    const tbody = document.querySelector('.cart .cart-container table tbody');

    cartItems.forEach(function(item) {

        // create item row
        const newRow = document.createElement('tr');

        // create book cell
        const prodCell = document.createElement('td');
        prodCell.textContent = item.bookTitle;
        newRow.appendChild(prodCell);

        // create price cell
        const priceCell = document.createElement('td');
        priceCell.textContent = item.bookPrice + CURRENCY;
        newRow.appendChild(priceCell);

        // create quantity cell
        const quantCell = document.createElement('td');

        // create select quantity element
        const selectQuant = document.createElement('select');
        selectQuant.classList.add('book-quantity');

        // add options
        for(let i = 1; i <= 5; i++){
            const quantOption = document.createElement('option');
            quantOption.value = i;
            quantOption.innerHTML = i + "";
            selectQuant.appendChild(quantOption);
        }
        // set its value
        selectQuant.value = item.bookQuantity;
        quantCell.appendChild(selectQuant);
        newRow.appendChild(quantCell);

        // add book id attribute
        selectQuant.setAttribute("data-book-id", item.bookId);

        selectQuant.addEventListener('change', function(event){

            var quantity = event.target.value;

            cartItems.forEach(function(cartItem){

                if(cartItem.bookId == item.bookId){
                    item.bookQuantity = quantity;
                    cartItems.reverse();
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));
                    cartItems.reverse();

                    var amounts = document.querySelectorAll('.cart .cart-container table tbody tr td.amount-cell');

                    amounts.forEach(function(amount){
                        var bid = amount.getAttribute("data-book-id");
                        if(bid == item.bookId){
                            amount.innerHTML = quantity * item.bookPrice + CURRENCY;
                        }
                    });

                    // recalculate and update subtotal
                    sbtl = 0;
                    cartItems.forEach(function(cartItem){
                        sbtl += cartItem.bookPrice * cartItem.bookQuantity;
                    });
                    subtotal.innerHTML = sbtl + CURRENCY;

                    updateTotals();
                }
            });

        });

        // create amount cell
        const amountCell = document.createElement('td');
        amountCell.textContent = (item.bookPrice * item.bookQuantity) + CURRENCY;
        amountCell.setAttribute("data-book-id", item.bookId);
        amountCell.classList.add("amount-cell");
        newRow.appendChild(amountCell);

        // create remove cell
        const removeCell = document.createElement('td');
        const remove = document.createElement('i');
        remove.classList.add("fa-solid", "fa-trash", "remove-from-cart");
        remove.setAttribute("data-book-id", item.bookId);
        removeCell.appendChild(remove);
        newRow.appendChild(removeCell);

        // add the new item row to the table
        tbody.insertBefore(newRow, tbody.childNodes[2]);
    });

    if (!isGuest) {
        var editButton = document.querySelector('.edit');
        if (editButton) {
            editButton.addEventListener('click', function(){
                window.location.href = URL + "user/account?tab=account_info&action=edit&intended=cart";
            });
        }
    } else {
        var registerButton = document.querySelector('.register-to-checkout');
        if (registerButton) {
            registerButton.addEventListener('click', function(e){
                e.preventDefault();
                window.location.href = URL + "register?intended=cart";
            });
        }

        var loginButton = document.querySelector('.login-to-checkout');
        if (loginButton) {
            loginButton.addEventListener('click', function(e){
                e.preventDefault();
                window.location.href = URL + "login?intended=cart";
            });
        }
    }

    // checkout  ///////////////////////////

    if (checkoutButton) {
        checkoutButton.addEventListener('click', function(){
            var currentCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            var shippingType = shippingPriceSelector ? shippingPriceSelector.value : 1;

            if (!isGuest) {
                checkoutButton.style.pointerEvents = 'none';
                placeOrder({
                    cartItems: currentCartItems,
                    shippingType: shippingType
                });
            } else {
                var gName = guestNameInput ? guestNameInput.value.trim() : '';
                var gPhone = guestPhoneInput ? guestPhoneInput.value.trim() : '';
                var gRegion = guestRegionSelector ? guestRegionSelector.value : '';
                var gAddress = guestAddressInput ? guestAddressInput.value.trim() : '';

                var hasEmpty = false;
                if (!gName) { guestNameInput.classList.add('input-error'); hasEmpty = true; }
                if (!gPhone) { guestPhoneInput.classList.add('input-error'); hasEmpty = true; }
                if (!gRegion) { guestRegionSelector.classList.add('input-error'); hasEmpty = true; }
                if (!gAddress) { guestAddressInput.classList.add('input-error'); hasEmpty = true; }

                if (hasEmpty) {
                    if (guestFormErrorEl) {
                        guestFormErrorEl.textContent = guestFormErrorEl.getAttribute('data-error-required');
                        guestFormErrorEl.style.display = 'block';
                    }
                    var firstError = guestShippingForm.querySelector('.input-error');
                    if (firstError) firstError.focus();
                    return;
                }

                if (!/^\d{10}$/.test(gPhone)) {
                    guestPhoneInput.classList.add('input-error');
                    if (guestFormErrorEl) {
                        guestFormErrorEl.textContent = guestFormErrorEl.getAttribute('data-error-phone');
                        guestFormErrorEl.style.display = 'block';
                    }
                    guestPhoneInput.focus();
                    return;
                }

                var selectedOpt = guestRegionSelector.options[guestRegionSelector.selectedIndex];
                if (!selectedOpt || selectedOpt.getAttribute('data-enabled') != '1') {
                    return;
                }

                checkoutButton.style.pointerEvents = 'none';
                placeOrder({
                    cartItems: currentCartItems,
                    shippingType: shippingType,
                    guestName: gName,
                    guestPhone: gPhone,
                    guestRegion: gRegion,
                    guestAddress: gAddress
                });
            }
        });
    }

    // remove item from cart ///////////////////////
    var removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
    removeFromCartButtons.forEach(function(button){
        button.addEventListener('click', function(){
            var bookId = button.getAttribute('data-book-id');
            var index = cartItems.findIndex(function(item){
                return item.bookId == bookId;
            });
            cartItems.splice(index, 1);
            cartItems.reverse();
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            window.location.href = URL + "browse/cart";
        });
    });
}

// functions /////////////////////////

async function placeOrder(payload) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: URL + `orders/place-order`,
        method: "POST",
        dataType: 'json',
        data: payload,
        success: function(response) {
            if (!response.error) {
                localStorage.setItem('cartItems', JSON.stringify([]));
                window.location.href = URL + "browse/cart?created=true";
            } else {
                var checkoutBtn = document.querySelector('.checkout');
                if (checkoutBtn) checkoutBtn.style.pointerEvents = 'auto';
                var errEl = document.querySelector('.guest-form-error');
                if (errEl && response.message) {
                    errEl.textContent = response.message;
                    errEl.style.display = 'block';
                }
            }
        },
        error: function(xhr) {
            var checkoutBtn = document.querySelector('.checkout');
            if (checkoutBtn) checkoutBtn.style.pointerEvents = 'auto';
            var errEl = document.querySelector('.guest-form-error');
            if (errEl && xhr.responseJSON && xhr.responseJSON.message) {
                errEl.textContent = xhr.responseJSON.message;
                errEl.style.display = 'block';
            }
        }
    });
}
