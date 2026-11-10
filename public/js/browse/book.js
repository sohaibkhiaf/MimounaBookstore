// cart items
var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

// start cart icon flickering
if (cartItems.length !== 0) {
    startCartFlickering();
}

// related books swiper
var relatedItems = document.querySelectorAll(".related .book-item").length;
var swiper = new Swiper(".related-slider", {
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
    slidesPerView: 2,
    loopedSlides: relatedItems <= 2 ? relatedItems : 1,
    },
    768: {
    slidesPerView: 3,
    loopedSlides: relatedItems <= 3 ? relatedItems : 1,
    },
    1024: {
    slidesPerView: 4,
    loopedSlides: relatedItems <= 4 ? relatedItems : 1,
    },
},
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

