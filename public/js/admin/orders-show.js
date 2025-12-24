var LANGUAGE = document.documentElement.getAttribute('lang');

// delete order
var deleteButton = document.querySelector("form.delete-order-form .delete-order-button");
if(deleteButton){
    deleteButton.addEventListener('click' , function(e){
        e.preventDefault();

        var orderId = deleteButton.getAttribute('data-order-id');

        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد خذف الطلبية `"+orderId+"` ؟") == true) {
                var deleteOrderForm = document.querySelector('form.delete-order-form[data-order-id="'+ orderId+'"]');
                deleteOrderForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir supprimer la commande `"+ orderId +"` ?") == true) {
                var deleteOrderForm = document.querySelector('form.delete-order-form[data-order-id="'+ orderId+'"]');
                deleteOrderForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to delete Order `"+ orderId +"` ?") == true) {
                var deleteOrderForm = document.querySelector('form.delete-order-form[data-order-id="'+ orderId+'"]');
                deleteOrderForm.submit();
            }
        }
    });
}
