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
var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
var addToCartButtons = document.querySelectorAll('.add-to-cart');

addToCartButtons.forEach(function(button) {

    // get book id, title and price
    var bookId = button.getAttribute('data-book-id');
    var bookTitle = button.getAttribute('data-book-title');
    var bookPrice = button.getAttribute('data-book-price');
    var bookQuantity = button.getAttribute('data-book-quantity');

    // check if the book is already in the cart
    var existingItemIndex = cartItems.findIndex(function(item) {
        return item.bookId === bookId;
    });

    if (existingItemIndex !== -1) {  // if item is already in cart

        // text content
        var viewCart = button.getAttribute('data-view-cart');
        button.innerHTML = viewCart+" <i class=\"fa-solid fa-eye\"></i>";

        // style
        button.style.backgroundColor = "#fff";
        button.style.color = "#222";
        button.style.border = ".1rem solid #222";

        // events
        button.addEventListener('mouseover', function() {
            button.style.backgroundColor = "#dfdfdf";
        });
        button.addEventListener('mouseout', function() {
            button.style.backgroundColor = "#fff";
        });
        button.addEventListener('click', function() {
            window.location.href = URL+"browse/cart";
        });

    } else { // if item isnt already in cart

        if(bookQuantity == 0){

            // text content
            var notAvailable = button.getAttribute('data-not-available');
            button.innerHTML = notAvailable + " <i class=\"fa-solid fa-circle-exclamation\"></i>";

            // style
            button.style.backgroundColor = "#222";

            // events
            button.addEventListener('mouseover', function() {
                button.style.backgroundColor = "#222";
            });
            button.addEventListener('mouseout', function() {
                button.style.backgroundColor = "#222";
            });
            // prevent click event
            button.addEventListener('click', function(event) {
                event.preventDefault();
            });

        }else{
            // text content
            var addToCart = button.getAttribute('data-add-to-cart');
            button.innerHTML = addToCart+" <i class=\"fa-solid fa-cart-shopping\"></i>";

            // style
            button.style.backgroundColor = "#a81f23";

            // events
            button.addEventListener('mouseover', function() {
                button.style.backgroundColor = "#70000c";
            });
            button.addEventListener('mouseout', function() {
                button.style.backgroundColor = "#a81f23";
            });
            button.addEventListener('click', function() {
                // add to cart
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
                var existingItemIndex = cartItems.findIndex(function(item) {
                    return item.bookId === bookId;
                });
                if(existingItemIndex === -1){
                    // add item to cart if not already in it
                    cartItems.push({ bookId: bookId , bookTitle : bookTitle , bookPrice : bookPrice , bookQuantity : 1});
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));
                }
                // text content
                var viewCart = button.getAttribute('data-view-cart');
                button.innerHTML = viewCart+" <i class=\"fa-solid fa-eye\"></i>";

                // style
                button.style.backgroundColor = "#fff";
                button.style.color = "#222";
                button.style.border = ".1rem solid #222";

                // events
                button.addEventListener('mouseover', function() {
                    button.style.backgroundColor = "#dfdfdf";
                });
                button.addEventListener('mouseout', function() {
                    button.style.backgroundColor = "#fff";
                });
                button.addEventListener('click', function() {
                    window.location.href = URL+"browse/cart";
                });

                startCartFlickering();
            });
        }
    }
});

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


