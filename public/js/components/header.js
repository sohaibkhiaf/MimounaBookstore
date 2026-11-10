import {URL} from "../connection.js";

// search icon on click
var searchIcon = document.querySelector('.search-icon');
var searchForm = document.querySelector('.search-form');

if (searchIcon && searchForm) {
    searchIcon.onclick = () => {
        searchForm.classList.toggle('active');
        if (searchForm.classList.contains('active')) {
            var box = searchForm.querySelector('.search-box');
            if (box) box.focus();
        }
    };
}

// search button on click
var searchBtn = document.querySelector('.search-button');
var searchBox = document.querySelector('.search-box');

if (searchBtn && searchBox) {
    searchBtn.onclick = () => {
        var searchValue = searchBox.value.trim();
        if(searchValue !== ""){
            window.location.href = URL + "browse/shop?search=" + encodeURIComponent(searchValue);
        }
    };
}

// open home page when the logo is clicked
var navLogo = document.querySelector('.navigation-logo');
if (navLogo) {
    navLogo.onclick = () => {
        window.location.href = URL + "browse/index";
    };
}

// login and wishlist icons
var loginIcon = document.querySelector('.login-icon');
var wishlistIcon = document.querySelector('.wishlist-icon');

if (loginIcon) {
    if(loginIcon.classList.contains('active')){
        loginIcon.onclick = () => {
            window.location.href = URL + "user/account";
        };
    } else {
        loginIcon.onclick = () => {
            window.location.href = URL + "login";
        };
        if (wishlistIcon) {
            wishlistIcon.onclick = () => {
                window.location.href = URL + "login?intended=wishlist";
            };
        }
    }
}

// Live Cart Count Badge on Header Cart Icon
var cartIcon = document.querySelector('.header .header-1 .icons .cart-icon');
function updateHeaderCartBadge() {
    if (!cartIcon) return;
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    var badge = cartIcon.querySelector('.header-cart-badge');
    if (cartItems.length > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'header-cart-badge';
            cartIcon.appendChild(badge);
        }
        badge.textContent = cartItems.length;
    } else if (badge) {
        badge.remove();
    }
}

updateHeaderCartBadge();
window.addEventListener('cartUpdated', updateHeaderCartBadge);
window.addEventListener('storage', function(e) {
    if (e.key === 'cartItems') updateHeaderCartBadge();
});

// Global interactive toast helper
var toastTimer = null;
window.showToast = function(message) {
    var toast = document.querySelector('.ui-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'ui-toast';
        document.body.appendChild(toast);
    }
    toast.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>' + message + '</span>';
    toast.classList.add('show');
    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(function() {
        toast.classList.remove('show');
    }, 2400);
};

// scroll
var header2 = document.querySelector('.header .header-2');
function handleHeaderScroll() {
    if (searchForm) searchForm.classList.remove('active');
    if (!header2) return;
    if(window.scrollY > 80){
        header2.classList.add('active');
    } else {
        header2.classList.remove('active');
    }
}

window.onscroll = handleHeaderScroll;
window.onload = handleHeaderScroll;
