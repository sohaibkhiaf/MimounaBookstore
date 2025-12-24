var LANGUAGE = document.documentElement.getAttribute('lang');

// delete book

var deleteButtons = document.querySelectorAll(".actions .action-delete");
deleteButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var bookId = button.getAttribute('data-book-id');
        var bookTitle = button.getAttribute('data-book-title');

        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من حذف `"+ bookTitle +"` ؟ يمكنك فقط تعديله وتحديد الكمية صفر 0 لإخفائه ومنع أي طلبيات عليه.") == true) {
                var deleteBookForm = document.querySelector('form.delete-book-form[data-book-id="'+ bookId+'"]');
                deleteBookForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir supprimer `"+ bookTitle +"` ? Vous pouvez simplement le modifier et mettre sa quantité à 0 si vous souhaitez le masquer temporairement.") == true) {
                var deleteBookForm = document.querySelector('form.delete-book-form[data-book-id="'+ bookId+'"]');
                deleteBookForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to delete `"+ bookTitle +"` ? you can just edit it and set its quantity to 0 if you want to hide it temporarily.") == true) {
                var deleteBookForm = document.querySelector('form.delete-book-form[data-book-id="'+ bookId+'"]');
                deleteBookForm.submit();
            }
        }
    });
});
