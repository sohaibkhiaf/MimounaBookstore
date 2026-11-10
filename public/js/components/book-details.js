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

// book quantity element
var bookQuantity = document.querySelector('.book-details .book-quantity');
var addToCartBtn = document.querySelector('.book-details div a.add-to-cart');
var detailsFlickeringStarted = false;

function syncBookDetailsState() {
    if (!bookQuantity || !addToCartBtn) return;

    var bid = addToCartBtn.getAttribute('data-book-id');
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    var existingItem = cartItems.find(function(item) {
        return String(item.bookId) === String(bid);
    });

    if (existingItem) {
        bookQuantity.value = existingItem.bookQuantity;
        bookQuantity.style.display = "inline";

        var viewCart = addToCartBtn.getAttribute('data-view-cart');
        addToCartBtn.innerHTML = viewCart + " <i class=\"fa-solid fa-eye\"></i>";
        addToCartBtn.style.backgroundColor = "#fff";
        addToCartBtn.style.color = "#222";
        addToCartBtn.style.border = ".1rem solid #222";
    } else {
        bookQuantity.value = 1;
        bookQuantity.style.display = "none";

        var addToCart = addToCartBtn.getAttribute('data-add-to-cart');
        addToCartBtn.innerHTML = addToCart + " <i class=\"fa-solid fa-cart-shopping\"></i>";
        addToCartBtn.style.backgroundColor = "#a81f23";
        addToCartBtn.style.color = "#fff";
        addToCartBtn.style.border = "none";
    }
}

if(bookQuantity != null && addToCartBtn != null){

    var bid = addToCartBtn.getAttribute('data-book-id');
    var bookId = addToCartBtn.getAttribute('data-book-id');
    var bookTitle = addToCartBtn.getAttribute('data-book-title');
    var bookPrice = addToCartBtn.getAttribute('data-book-price');

    syncBookDetailsState();

    // on book quantity element value changed
    bookQuantity.addEventListener('change' , function(event){
        var quantity = event.target.value;
        var cart = JSON.parse(localStorage.getItem('cartItems')) || [];
        var exists = cart.findIndex(function(item){
            return String(item.bookId) === String(bid);
        });
        if(exists !== -1){
            cart.forEach(function(item){
                if(String(item.bookId) === String(bid)){
                    item.bookQuantity = quantity;
                    localStorage.setItem('cartItems', JSON.stringify(cart));
                }
            });
            window.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { source: 'book-details', bookId: bid, quantity: quantity }
            }));
        }
    });

    addToCartBtn.addEventListener('mouseover', function() {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var inCart = cartItems.some(function(item) { return String(item.bookId) === String(bookId); });
        addToCartBtn.style.backgroundColor = inCart ? "#dfdfdf" : "#70000c";
    });

    addToCartBtn.addEventListener('mouseout', function() {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var inCart = cartItems.some(function(item) { return String(item.bookId) === String(bookId); });
        addToCartBtn.style.backgroundColor = inCart ? "#fff" : "#a81f23";
    });

    addToCartBtn.addEventListener('click', function() {
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        var existingItemIndex = cartItems.findIndex(function(item) {
            return String(item.bookId) === String(bookId);
        });

        if (existingItemIndex !== -1) {
            window.location.href = URL + "browse/cart";
        } else {
            cartItems.push({ bookId: bookId , bookTitle : bookTitle , bookPrice : bookPrice , bookQuantity : 1});
            localStorage.setItem('cartItems', JSON.stringify(cartItems));

            syncBookDetailsState();

            if (!detailsFlickeringStarted) {
                detailsFlickeringStarted = true;
                startCartFlickering();
            }

            window.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { source: 'book-details', addedBookId: bookId }
            }));

            if (typeof window.showToast === 'function') {
                window.showToast(bookTitle);
            }
        }
    });

    window.addEventListener('cartUpdated', syncBookDetailsState);
}

function startCartFlickering(){
    var active = 0;
    setInterval(function(){
        var cartIcon = document.querySelector(".cart-icon");
        if(!cartIcon) return;
        if(active == 0){
            cartIcon.style.color = "#a81f23";
            active = 1;
        }else{
            cartIcon.style.color = "#222";
            active = 0;
        }
    }, 1000);
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
