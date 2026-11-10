import {URL} from "../connection.js";

var LANGUAGE = document.documentElement.getAttribute('lang');

// order status change

var startDeliveryButtons = document.querySelectorAll(".start-delivery");
startDeliveryButtons.forEach(function(button){
    button.addEventListener('click' , function(){

        var orderId = button.getAttribute('data-order-id');
        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد تغيير حالة الطلبية `"+orderId+"` إلى `قيد الإرسال` ؟") == true) {
                window.location.href = URL+"admin/orders/index?tab=processing&order_id="+orderId + "&order_status_id=2";
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir changer le statut de la commande en `En cours de livraison` ?") == true) {
                window.location.href = URL+"admin/orders/index?tab=processing&order_id="+orderId + "&order_status_id=2";
            }
        }else{
            if (confirm("Are you sure you want to set the status of the order to `Delivering` ?") == true) {
                window.location.href = URL+"admin/orders/index?tab=processing&order_id="+orderId + "&order_status_id=2";
            }
        }

    });
});

var cancelOrderButtons = document.querySelectorAll(".cancel-order");
cancelOrderButtons.forEach(function(button){
    button.addEventListener('click' , function(){

        var orderId = button.getAttribute('data-order-id');
        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد تغيير حالة الطلبية `"+orderId+"` إلى `تم إلغاؤه` ؟") == true) {
                window.location.href = URL +"admin/orders/index?tab=processing&order_id="+orderId + "&order_status_id=4";
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir changer le statut de la commande en `Annulée` ?") == true) {
                window.location.href = URL +"admin/orders/index/?tab=processing&order_id="+orderId + "&order_status_id=4";
            }
        }else{
            if (confirm("Are you sure you want to set the status of the order to `Canceled` ?") == true) {
                window.location.href = URL +"admin/orders/index/?tab=processing&order_id="+orderId + "&order_status_id=4";
            }
        }

    });
});

var orderDeliveredButtons = document.querySelectorAll(".order-delivered");
orderDeliveredButtons.forEach(function(button){
    button.addEventListener('click' , function(){

        var orderId = button.getAttribute('data-order-id');
        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد تغيير حالة الطلبية `"+orderId+"` إلى `تم التسليم` ؟") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=3";
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir changer le statut de la commande en `Livrée` ?") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=3";
            }
        }else{
            if (confirm("Are you sure you want to set the status of the order to `Delivered` ?") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=3";
            }
        }

    });
});

var orderReturnedButtons = document.querySelectorAll(".order-returned");
orderReturnedButtons.forEach(function(button){
    button.addEventListener('click' , function(){

        var orderId = button.getAttribute('data-order-id');
        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد تغيير حالة الطلبية `"+orderId+"` إلى `تم إرجاعه` ؟") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=5";
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir changer le statut de la commande en `Retourée` ?") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=5";
            }
        }else{
            if (confirm("Are you sure you want to set the status of the order to `Returned` ?") == true) {
                window.location.href = URL +"admin/orders/index?tab=delivering&order_id="+orderId + "&order_status_id=5";
            }
        }

    });
});

// change view for phone

window.onresize = () => {

    if(window.innerWidth <= 768){

        var orderHeader = document.querySelector('.order-header');
        var detailsHeader = document.querySelector('.details-header');
        var sendHeader = document.querySelector('.send-header');
        var cancelHeader = document.querySelector('.cancel-header');
        var deliverHeader = document.querySelector('.deliver-header');
        var returnHeader = document.querySelector('.return-header');

        if(orderHeader){orderHeader.innerHTML = orderHeader.getAttribute('data-header-o');}
        if(detailsHeader){detailsHeader.innerHTML = detailsHeader.getAttribute('data-header-d');}
        if(sendHeader){ sendHeader.innerHTML = sendHeader.getAttribute('data-header-s'); }
        if(cancelHeader){ cancelHeader.innerHTML = cancelHeader.getAttribute('data-header-c'); }
        if(deliverHeader){ deliverHeader.innerHTML = deliverHeader.getAttribute('data-header-d'); }
        if(returnHeader){ returnHeader.innerHTML = returnHeader.getAttribute('data-header-r'); }

    }else{
        var orderHeader = document.querySelector('.order-header');
        var detailsHeader = document.querySelector('.details-header');
        var sendHeader = document.querySelector('.send-header');
        var cancelHeader = document.querySelector('.cancel-header');
        var deliverHeader = document.querySelector('.deliver-header');
        var returnHeader = document.querySelector('.return-header');

        if(orderHeader){orderHeader.innerHTML =  orderHeader.getAttribute('data-header-order'); }
        if(detailsHeader){detailsHeader.innerHTML = detailsHeader.getAttribute('data-header-details'); }
        if(sendHeader){ sendHeader.innerHTML = sendHeader.getAttribute('data-header-send'); }
        if(cancelHeader){ cancelHeader.innerHTML = cancelHeader.getAttribute('data-header-cancel'); }
        if(deliverHeader){ deliverHeader.innerHTML = deliverHeader.getAttribute('data-header-deliver'); }
        if(returnHeader){ returnHeader.innerHTML = returnHeader.getAttribute('data-header-return'); }
    }
}

window.onload = () => {

    if(window.innerWidth <= 768){

        var orderHeader = document.querySelector('.order-header');
        var detailsHeader = document.querySelector('.details-header');
        var sendHeader = document.querySelector('.send-header');
        var cancelHeader = document.querySelector('.cancel-header');
        var deliverHeader = document.querySelector('.deliver-header');
        var returnHeader = document.querySelector('.return-header');

        if(orderHeader){orderHeader.innerHTML = orderHeader.getAttribute('data-header-o');}
        if(detailsHeader){detailsHeader.innerHTML = detailsHeader.getAttribute('data-header-d');}
        if(sendHeader){ sendHeader.innerHTML = sendHeader.getAttribute('data-header-s'); }
        if(cancelHeader){ cancelHeader.innerHTML = cancelHeader.getAttribute('data-header-c'); }
        if(deliverHeader){ deliverHeader.innerHTML = deliverHeader.getAttribute('data-header-d'); }
        if(returnHeader){ returnHeader.innerHTML = returnHeader.getAttribute('data-header-r'); }

    }else{
        var orderHeader = document.querySelector('.order-header');
        var detailsHeader = document.querySelector('.details-header');
        var sendHeader = document.querySelector('.send-header');
        var cancelHeader = document.querySelector('.cancel-header');
        var deliverHeader = document.querySelector('.deliver-header');
        var returnHeader = document.querySelector('.return-header');

        if(orderHeader){orderHeader.innerHTML =  orderHeader.getAttribute('data-header-order'); }
        if(detailsHeader){detailsHeader.innerHTML = detailsHeader.getAttribute('data-header-details'); }
        if(sendHeader){ sendHeader.innerHTML = sendHeader.getAttribute('data-header-send'); }
        if(cancelHeader){ cancelHeader.innerHTML = cancelHeader.getAttribute('data-header-cancel'); }
        if(deliverHeader){ deliverHeader.innerHTML = deliverHeader.getAttribute('data-header-deliver'); }
        if(returnHeader){ returnHeader.innerHTML = returnHeader.getAttribute('data-header-return'); }
    }
}

