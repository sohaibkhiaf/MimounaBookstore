// update total

var subtotalField = document.querySelector('.form-container form input[name="subtotal"]');
var shippingField = document.querySelector('.form-container form input[name="shipping"]');
var totalField = document.querySelector('.form-container form input[name="total"]');

if(subtotalField && shippingField && totalField){

    subtotalField.addEventListener('input' , function(){
        totalField.value = parseInt(subtotalField.value ) + parseInt(shippingField.value);
    });
    shippingField.addEventListener('input' , function(){
        totalField.value = parseInt(subtotalField.value ) + parseInt(shippingField.value);
    });
}

