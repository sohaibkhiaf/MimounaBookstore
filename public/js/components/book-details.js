import {URL} from "../connection.js";

// add book to wishlist

var addBookToWishlistBtn = document.querySelector('.add-book-to-wishlist');
var loginIcon = document.querySelector('.login-icon');
var numOfLikes = document.querySelector('.number-of-likes');

if(loginIcon.classList.contains('active')){

    addBookToWishlistBtn.addEventListener('click' , function(){
        var bookId = addBookToWishlistBtn.getAttribute('data-book-id');  // get book id
        if(addBookToWishlistBtn.classList.contains('active')){  // if already in wishlist remove it

            unlikeBook(bookId);

            addBookToWishlistBtn.classList.remove('active');
            addBookToWishlistBtn.style.color = "#222";
            addBookToWishlistBtn.addEventListener('mouseenter' , function(){
                addBookToWishlistBtn.style.color = "#a81f23";
            });
            addBookToWishlistBtn.addEventListener('mouseleave' , function(){
                addBookToWishlistBtn.style.color = "#222";
            });
            // upadte number of likes
            let likes = numOfLikes.innerHTML;
            numOfLikes.innerHTML = parseInt(likes)-1;
        }else{  // if not in wishlist

            likeBook(bookId);

            addBookToWishlistBtn.classList.add('active');
            addBookToWishlistBtn.style.color = "#a81f23";
            addBookToWishlistBtn.addEventListener('mouseenter' , function(){
                addBookToWishlistBtn.style.color = "#a81f23";
            });
            addBookToWishlistBtn.addEventListener('mouseleave' , function(){
                addBookToWishlistBtn.style.color = "#a81f23";
            });
            // upadte number of likes
            let likes = numOfLikes.innerHTML;
            numOfLikes.innerHTML = parseInt(likes)+1;
        }
    });

}else{
    addBookToWishlistBtn.onclick = () => {
        var bookId = addBookToWishlistBtn.getAttribute('data-book-id');
        window.location.href = URL+ "login?intended=book&bid="+bookId;
    }
}

// add book to cart

// cart items
var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

// book quantity element
var bookQuantity = document.querySelector('.book-quantity');
var addToCartBtn = document.querySelector('.book-details div a.add-to-cart');

if(bookQuantity != null){

    // get book id
    var bid = addToCartBtn.getAttribute('data-book-id');

    // if the book is already in the cart, update its quantity
    cartItems.forEach(function(item){
        if(item.bookId == bid){
            bookQuantity.value = item.bookQuantity;
            bookQuantity.style.display = "inline";
        }
    });

    // on book quantity element value changed
    bookQuantity.addEventListener('change' , function(event){
        var quantity = event.target.value;
        var cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        var exists = cart.findIndex(function(item){
            return item.bookId === bid;
        });
        if(exists !== -1){
            cart.forEach(function(item){
                if(item.bookId == bid){
                    item.bookQuantity = quantity;
                    localStorage.setItem('cartItems', JSON.stringify(cart));
                }
            });
        }
    });

    // on add to cart click

    // get book id, title and price
    var bookId = addToCartBtn.getAttribute('data-book-id');
    var bookTitle = addToCartBtn.getAttribute('data-book-title');
    var bookPrice = addToCartBtn.getAttribute('data-book-price');

    // check if the book is already in the cart
    var existingItemIndex = cartItems.findIndex(function(item) {
        return item.bookId === bookId;
    });

    if (existingItemIndex !== -1) {  // if item is already in cart

        // text content
        var viewCart = addToCartBtn.getAttribute('data-view-cart');
        addToCartBtn.innerHTML = viewCart+" <i class=\"fa-solid fa-eye\"></i>";

        // style
        addToCartBtn.style.backgroundColor = "#fff";
        addToCartBtn.style.color = "#222";
        addToCartBtn.style.border = ".1rem solid #222";

        // events
        addToCartBtn.addEventListener('mouseover', function() {
            addToCartBtn.style.backgroundColor = "#dfdfdf";
        });
        addToCartBtn.addEventListener('mouseout', function() {
            addToCartBtn.style.backgroundColor = "#fff";
        });
        addToCartBtn.addEventListener('click', function() {
            window.location.href = URL + "browse/cart";
        });

    } else { // if item isnt already in cart

        // text content
        var addToCart = addToCartBtn.getAttribute('data-add-to-cart');
        addToCartBtn.innerHTML = addToCart+" <i class=\"fa-solid fa-cart-shopping\"></i>";

        // style
        addToCartBtn.style.backgroundColor = "#a81f23";

        // events
        addToCartBtn.addEventListener('mouseover', function() {
            addToCartBtn.style.backgroundColor = "#70000c";
        });
        addToCartBtn.addEventListener('mouseout', function() {
            addToCartBtn.style.backgroundColor = "#a81f23";
        });
        addToCartBtn.addEventListener('click', function() {
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
            var viewCart = addToCartBtn.getAttribute('data-view-cart');
            addToCartBtn.innerHTML = viewCart+" <i class=\"fa-solid fa-eye\"></i>";

            // style
            addToCartBtn.style.backgroundColor = "#fff";
            addToCartBtn.style.color = "#222";
            addToCartBtn.style.border = ".1rem solid #222";

            // events
            addToCartBtn.addEventListener('mouseover', function() {
                addToCartBtn.style.backgroundColor = "#dfdfdf";
            });
            addToCartBtn.addEventListener('mouseout', function() {
                addToCartBtn.style.backgroundColor = "#fff";
            });
            addToCartBtn.addEventListener('click', function() {
                window.location.href = URL+"browse/cart";
            });

            // show book quantity select option element
            bookQuantity.style.display = "inline";
            startCartFlickering();
        });
    }
}

// functions

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
