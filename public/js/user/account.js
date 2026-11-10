// cart  flickering
var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

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

