var LANGUAGE = document.documentElement.getAttribute('lang');

// delete genre
var deleteGenreButton = document.querySelector('.delete-genre-button');
if(deleteGenreButton){
    deleteGenreButton.addEventListener('click' , function(e){
        e.preventDefault();

        var genreId = deleteGenreButton.getAttribute('data-genre-id');
        var genreName = deleteGenreButton.getAttribute('data-genre-name');

        if(LANGUAGE == 'ar'){
            if(confirm("هل أنت متأكد من حذف `"+genreName+"` ؟ كل الكتب التي تندرج تحت هذا التصنيف سيتم حذفها.") == true){
                var deleteGenreForm = document.querySelector('form.delete-genre-form[data-genre-id="'+genreId+'"]');
                deleteGenreForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if(confirm("Êtes-vous sûr de vouloir supprimer `"+genreName+"` ? Tous les livres de ce genre seront supprimés !") == true){
                var deleteGenreForm = document.querySelector('form.delete-genre-form[data-genre-id="'+genreId+'"]');
                deleteGenreForm.submit();
            }
        }else{
            if(confirm("Are you sure you want to delete `"+genreName+"`? all books under this genre will be removed!") == true){
                var deleteGenreForm = document.querySelector('form.delete-genre-form[data-genre-id="'+genreId+'"]');
                deleteGenreForm.submit();
            }
        }
    });
}

