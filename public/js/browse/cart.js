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

    // get user's region id
    var regionId = document.querySelector('.shipping-price').getAttribute('data-region-id');

    // calculate subtotal ////////////////////////
    var sbtl = 0;
    cartItems.forEach(function(cartItem){
        sbtl += cartItem.bookPrice * cartItem.bookQuantity;
    });

    var subtotal = document.querySelector(".subtotal");
    subtotal.innerHTML = sbtl+CURRENCY;

    // print shipping price  /////////////////////////
    var dlv = 0;

    if(regionId != 0){
        var shippingPriceSelector = document.querySelector('.shipping-price-selector');
        var shippingPrice = document.querySelector('.shipping-price');

        if(shippingPrice && shippingPriceSelector){

            var homeShipping = shippingPriceSelector.getAttribute("data-home-shipping");
            var deskShipping = shippingPriceSelector.getAttribute("data-desk-shipping");

            /* retrieve data from locale storage */

            var selectorValue = localStorage.getItem('shippingType');
            if(selectorValue != null){
                shippingPriceSelector.value = selectorValue;
            }else{
                shippingPriceSelector.value = 1;
            }

            /* end */

            if(shippingPriceSelector.value == 1){
                shippingPrice.innerHTML = homeShipping + CURRENCY;
                dlv = homeShipping;
            }else if(shippingPriceSelector.value == 2){
                shippingPrice.innerHTML = deskShipping + CURRENCY;
                dlv = deskShipping;
            }

            // update shipping choice
            shippingPriceSelector.addEventListener('change' , function(event){

                if(event.target.value == 1){
                    shippingPrice.innerHTML = homeShipping + CURRENCY;
                    dlv = homeShipping;
                }else if(event.target.value == 2){
                    shippingPrice.innerHTML = deskShipping + CURRENCY;
                    dlv = deskShipping;
                }

                /* save shipping type in locale storage */
                localStorage.setItem('shippingType' , event.target.value);
                /* end */

                // realculate and update total
                var total = document.querySelector('.total');
                let ttl = parseInt(sbtl) + parseInt(dlv);
                total.innerHTML =ttl+CURRENCY;
            });
        }

    }

    // calculate total amount ///////////////////////
    var total = document.querySelector('.total');
    let ttl = parseInt(sbtl) + parseInt(dlv);
    total.innerHTML =ttl+CURRENCY;

    // set cart items number  //////////////////////
    var numOfItems = document.querySelector('.cart .cart-container h3 span');
    numOfItems.innerHTML = "(" + cartItems.length + ")";

    //  inject cart items  ///////////////////////
    const table = document.querySelector('.cart .cart-container table tbody');

    cartItems.forEach(function(item) {

        // create item row
        const newRow = document.createElement('tr');

        // create book cell
        const prodCell = document.createElement('td');
        prodCell.textContent = item.bookTitle; // set book cell value
        newRow.appendChild(prodCell); // append it as a child of item row

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
        for(let i =1; i <= 5 ; i++){
            const quantOption = document.createElement('option');
            quantOption.value = i;
            quantOption.innerHTML = i+"";
            selectQuant.appendChild(quantOption);
        }
        // set its value
        selectQuant.value = item.bookQuantity;
        quantCell.appendChild(selectQuant);
        newRow.appendChild(quantCell);

        // add book id attribute
        selectQuant.setAttribute("data-book-id" , item.bookID);

        selectQuant.addEventListener('change' , function(event){

            // get quantity from select element
            var quantity = event.target.value;

            cartItems.forEach(function(cartItem){

                // find the item in the cart
                if(cartItem.bookId == item.bookId){
                    item.bookQuantity = quantity;  // update quantity
                    cartItems.reverse();
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));  // update cart in storage
                    cartItems.reverse();
                    // get all amount elements
                    var amounts = document.querySelectorAll('.cart .cart-container table tbody tr td.amount-cell');

                    // update the amount of the item in which we updated its quantity
                    amounts.forEach(function(amount){
                        var bid = amount.getAttribute("data-book-id");
                        if(bid == item.bookId){
                            amount.innerHTML = quantity*item.bookPrice + CURRENCY;
                        }
                    });

                    // recalculate and update subtotal
                    sbtl = 0;
                    cartItems.forEach(function(cartItem){
                        sbtl += cartItem.bookPrice * cartItem.bookQuantity;
                    });
                    var subtotal = document.querySelector(".subtotal");
                    subtotal.innerHTML = sbtl + CURRENCY;

                    // update shipping price variable
                    var dlv = 0;

                    if(regionId != 0){
                        var shippingPriceSelector = document.querySelector('.shipping-price-selector');
                        var shippingPrice = document.querySelector('.shipping-price');

                        if (shippingPriceSelector) {

                            var homeShipping = shippingPriceSelector.getAttribute("data-home-shipping");
                            var deskShipping = shippingPriceSelector.getAttribute("data-desk-shipping");

                            /* retrieve data from locale storage */

                            var selectorValue = localStorage.getItem('shippingType');
                            if(selectorValue != null){
                                shippingPriceSelector.value = selectorValue;
                            }else{
                                shippingPriceSelector.value = 1;
                            }

                            /* end */

                            if(shippingPriceSelector.value == 1){
                                shippingPrice.innerHTML = homeShipping + CURRENCY;
                                dlv = homeShipping;
                            }else if(shippingPriceSelector.value == 2){
                                shippingPrice.innerHTML = deskShipping + CURRENCY;
                                dlv = deskShipping;
                            }
                        }

                    }

                    // recalculate and update total
                    var total = document.querySelector('.total');
                    let ttl = parseInt(sbtl) + parseInt(dlv);
                    total.innerHTML =ttl + CURRENCY;

                }
            });

        });

        // create amount cell
        const amountCell = document.createElement('td');
        amountCell.textContent = (item.bookPrice * item.bookQuantity) + CURRENCY;
        amountCell.setAttribute("data-book-id" , item.bookId);
        amountCell.classList.add("amount-cell");
        newRow.appendChild(amountCell);

        // create remove cell
        const removeCell = document.createElement('td');
        const remove = document.createElement('i');
        remove.classList.add("fa-solid");
        remove.classList.add("fa-trash");
        remove.classList.add("remove-from-cart");
        remove.setAttribute("data-book-id" , item.bookId);
        removeCell.appendChild(remove);
        newRow.appendChild(removeCell);

        // add the new item row to the table
        table.insertBefore(newRow,table.childNodes[2]);
    });

    if(regionId != 0){
        // edit address //////////////////////
        var editButton = document.querySelector('.edit');
        editButton.addEventListener('click' , function(){
            // open account page
            window.location.href = URL+"user/account?tab=account_info&action=edit&intended=cart";
        });
    }else{
        // register / login to checkout ///////////////////

        var registerButton = document.querySelector('.register-to-checkout');
        registerButton.addEventListener('click' , function(e){
            e.preventDefault();

            window.location.href = URL + "register?intended=cart";
        });

        var loginButton = document.querySelector('.login-to-checkout');
        loginButton.addEventListener('click' , function(e){
            e.preventDefault();

            window.location.href = URL + "login?intended=cart";
        });
    }


    // checkout  ///////////////////////////

    var checkoutButton = document.querySelector('.checkout');

    if(checkoutButton){

        if(regionId != 0){   // user logged in

            checkoutButton.addEventListener('click' , function(){

                checkoutButton.disabled = true;

                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
                var shippingType = shippingPriceSelector.value;

                placeOrder(shippingType, cartItems);

            });
        }else{  // user isnt logged in
            checkoutButton.onclick = () =>{
                window.location.href = URL + "login?intended=cart";
            }
        }
    }

    // remove item from cart ///////////////////////
    var removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
    removeFromCartButtons.forEach(function(button){
        button.addEventListener('click' , function(){
            // get deleted book id
            var bookId = button.getAttribute('data-book-id');
            // get it from the list
            var index = cartItems.findIndex(function(item){
                return item.bookId == bookId;
            });
            // get it out from storage
            cartItems.splice(index , 1);
            cartItems.reverse();
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            // refresh cart page
            window.location.href = URL +"browse/cart";
        });
    });
}

// functions /////////////////////////

async function placeOrder(shippingType, cartItems) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: URL+`orders/place-order`,
        method: "POST",
        dataType : 'json',
        data: {
            cartItems: cartItems,
            shippingType: shippingType
        },
        success: function(response) {
            console.log(response.message);
            if(!response.error){
                cartItems = [];
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                window.location.href = URL + "browse/cart?created=true";
            }
        }
    });
}
