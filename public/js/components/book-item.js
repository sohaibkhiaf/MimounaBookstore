import {URL} from "../connection.js";

// open book page on click
var bookImages = document.querySelectorAll('.book-image');

bookImages.forEach(function(image){
    var bookId = image.getAttribute('data-book-id');
    image.addEventListener('click' , function(){
        window.location.href = URL+"browse/"+bookId;
    });
});

// add to wishlist
var addToWishlistButtons = document.querySelectorAll('.book-item .like a.add-to-wishlist');
var loginIcon = document.querySelector('.login-icon');

addToWishlistButtons.forEach(function(button){
    // if user logged in
    if(loginIcon.classList.contains('active')){

        button.addEventListener('click' , function(){
            var bookId = button.getAttribute('data-book-id');  // get book id
            if(button.classList.contains('active')){  // if already in wishlist remove it

                unlikeBook(bookId);

                button.classList.remove('active');
                button.style.color = "#222";
                button.addEventListener('mouseenter' , function(){
                    button.style.color = "#a81f23";
                });
                button.addEventListener('mouseleave' , function(){
                    button.style.color = "#222";
                });
            }else{  // if not in wishlist

                likeBook(bookId);

                button.classList.add('active');
                button.style.color = "#a81f23";
                button.addEventListener('mouseenter' , function(){
                    button.style.color = "#a81f23";
                });
                button.addEventListener('mouseleave' , function(){
                    button.style.color = "#a81f23";
                });
            }
        });

    }else{  // if user isnt logged in yet, open login dialog when they clicks on add to wishlist button
        button.onclick = () => {
            window.location.href = URL + "login?intended=index";
        }
    }
});

// add to cart
var addToCartButtons = document.querySelectorAll('.book-item .add-to-cart');
var flickeringStarted = false;

function syncBookItemButtons() {
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    addToCartButtons.forEach(function(button) {
        var bookId = button.getAttribute('data-book-id');
        var bookQuantity = button.getAttribute('data-book-quantity');

        var existingItemIndex = cartItems.findIndex(function(item) {
            return String(item.bookId) === String(bookId);
        });

        if (existingItemIndex !== -1) {  // if item is already in cart
            var viewCart = button.getAttribute('data-view-cart');
            button.innerHTML = viewCart + " <i class=\"fa-solid fa-eye\"></i>";
            button.style.backgroundColor = "#fff";
            button.style.color = "#222";
            button.style.border = ".1rem solid #222";
        } else if (bookQuantity == 0) {
            var notAvailable = button.getAttribute('data-not-available');
            button.innerHTML = notAvailable + " <i class=\"fa-solid fa-circle-exclamation\"></i>";
            button.style.backgroundColor = "#222";
            button.style.color = "#fff";
            button.style.border = "none";
        } else {
            var addToCart = button.getAttribute('data-add-to-cart');
            button.innerHTML = addToCart + " <i class=\"fa-solid fa-cart-shopping\"></i>";
            button.style.backgroundColor = "#a81f23";
            button.style.color = "#fff";
            button.style.border = "none";
        }
    });
}

addToCartButtons.forEach(function(button) {
    var bookId = button.getAttribute('data-book-id');
    var bookTitle = button.getAttribute('data-book-title');
    var bookPrice = button.getAttribute('data-book-price');
    var bookQuantity = button.getAttribute('data-book-quantity');

    button.addEventListener('mouseover', function() {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var inCart = cartItems.some(function(item) { return String(item.bookId) === String(bookId); });
        if (inCart) {
            button.style.backgroundColor = "#dfdfdf";
        } else if (bookQuantity == 0) {
            button.style.backgroundColor = "#222";
        } else {
            button.style.backgroundColor = "#70000c";
        }
    });

    button.addEventListener('mouseout', function() {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var inCart = cartItems.some(function(item) { return String(item.bookId) === String(bookId); });
        if (inCart) {
            button.style.backgroundColor = "#fff";
        } else if (bookQuantity == 0) {
            button.style.backgroundColor = "#222";
        } else {
            button.style.backgroundColor = "#a81f23";
        }
    });

    button.addEventListener('click', function(event) {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var existingItemIndex = cartItems.findIndex(function(item) {
            return String(item.bookId) === String(bookId);
        });

        if (existingItemIndex !== -1) {
            window.location.href = URL + "browse/cart";
        } else if (bookQuantity == 0) {
            event.preventDefault();
        } else {
            cartItems.push({ bookId: bookId, bookTitle: bookTitle, bookPrice: bookPrice, bookQuantity: 1 });
            localStorage.setItem('cartItems', JSON.stringify(cartItems));

            syncBookItemButtons();

            if (!flickeringStarted) {
                flickeringStarted = true;
                startCartFlickering();
            }

            window.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { source: 'book-item', addedBookId: bookId }
            }));

            if (typeof window.showToast === 'function') {
                window.showToast(bookTitle);
            }
        }
    });
});

syncBookItemButtons();
window.addEventListener('cartUpdated', syncBookItemButtons);

// functions

function startCartFlickering(){
    var active = 0;
    setInterval(function(){
        var cartIcon = document.querySelector(".cart-icon");
        if(active == 0){
            cartIcon.style.color = "#a81f23";
            active = 1;
        }else{
            cartIcon.style.color = "#222";
            active = 0;
        }
    }, 1000);
}

async function likeBook(bookId) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: URL+`books/${bookId}/like`,
        method: "POST",
        dataType : 'json',
        data: {
            book: bookId
        },
        success: function(response) {
            console.log(response.message);
        }
    });

}

async function unlikeBook(bookId) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType : 'json',
        url: URL+`books/${bookId}/unlike`,
        method: "POST",
        data: {
            book: bookId
        },
        success: function(response) {
            console.log(response.message);
        }
    });
}


