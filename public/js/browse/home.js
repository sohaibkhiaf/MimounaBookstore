// set the slider of books
var bookshelfItems = document.querySelectorAll(".home .book-item").length;
var swiper = new Swiper(".bookshelf-slider", {
loop:true,
autoplay: {
    delay: 6400,
    disableOnInteraction: false
},
breakpoints: {
    0: {
    slidesPerView: 1,
    loopedSlides: 1,
    },
    768: {
    slidesPerView: 2,
    loopedSlides: bookshelfItems <= 2 ? bookshelfItems : 1,
    },
    1024: {
    slidesPerView: 3,
    loopedSlides: bookshelfItems <= 3 ? bookshelfItems : 1,
    },
},
});

// set book sliders

var bestsellersItems = document.querySelectorAll(".bestsellers .book-item").length;
var swiper = new Swiper(".bestsellers .book-slider", {
spaceBetween: 10,
loop:true,
autoplay: {
    delay: 6400,
    disableOnInteraction: false
},
navigation: {
    nextEl: '.swiper-button-next' ,
    prevEl: '.swiper-button-prev'
},
breakpoints: {
    0: {
    slidesPerView: 1,
    loopedSlides: 1,
    },
    450: {
    slidesPerView: 3,
    loopedSlides: bestsellersItems <= 3 ? bestsellersItems : 1,
    },
    768: {
    slidesPerView: 4,
    loopedSlides: bestsellersItems <= 4 ? bestsellersItems : 1,
    },
    1024: {
    slidesPerView: 5,
    loopedSlides: bestsellersItems <= 5 ? bestsellersItems : 1,
    },
},
});

var novelsItems = document.querySelectorAll(".novels .book-item").length;
var swiper = new Swiper(".novels .book-slider", {
spaceBetween: 10,
loop:true,
autoplay: {
    delay: 6400,
    disableOnInteraction: false
},
navigation: {
    nextEl: '.swiper-button-next' ,
    prevEl: '.swiper-button-prev'
},
breakpoints: {
    0: {
    slidesPerView: 1,
    loopedSlides: 1,
    },
    450: {
    slidesPerView: 3,
    loopedSlides: novelsItems <= 3 ? novelsItems : 1,
    },
    768: {
    slidesPerView: 4,
    loopedSlides: novelsItems <= 4 ? novelsItems : 1,
    },
    1024: {
    slidesPerView: 5,
    loopedSlides: novelsItems <= 5 ? novelsItems : 1,
    },
},
});

var newlyAddedItems = document.querySelectorAll(".newly-added .book-item").length;
var swiper = new Swiper(".newly-added .book-slider", {
spaceBetween: 10,
loop:true,
autoplay: {
    delay: 6400,
    disableOnInteraction: false
},
navigation: {
    nextEl: '.swiper-button-next' ,
    prevEl: '.swiper-button-prev'
},
breakpoints: {
    0: {
    slidesPerView: 1,
    loopedSlides: 1,
    },
    450: {
    slidesPerView: 3,
    loopedSlides: newlyAddedItems <= 3 ? newlyAddedItems : 1,
    },
    768: {
    slidesPerView: 4,
    loopedSlides: newlyAddedItems <= 4 ? newlyAddedItems : 1,
    },
    1024: {
    slidesPerView: 5,
    loopedSlides: newlyAddedItems <= 5 ? newlyAddedItems : 1,
    },
},
});


// get cart items
var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

// start cart button flickering if there is items in the cart
if (cartItems.length !== 0) {
    startCartFlickering();
}

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
