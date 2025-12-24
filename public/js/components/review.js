import {URL} from "../connection.js";

var LANGUAGE = document.documentElement.getAttribute('lang');

// delete review

var deleteButtons = document.querySelectorAll(".user-actions form .action-delete");
deleteButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var reviewId = button.getAttribute('data-review-id');

        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من حذف مراجعتك للكتاب؟") == true) {
                var deleteReviewForm = document.querySelector('form.delete-review-form[data-review-id="'+ reviewId+'"]');
                deleteReviewForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir supprimer votre avis sur ce livre?") == true) {
                var deleteReviewForm = document.querySelector('form.delete-review-form[data-review-id="'+ reviewId+'"]');
                deleteReviewForm.submit();
            }
        }
        else {
            if (confirm("Are you sure you want to delete your review on the book?") == true) {
                var deleteReviewForm = document.querySelector('form.delete-review-form[data-review-id="'+ reviewId+'"]');
                deleteReviewForm.submit();
            }
        }
    });
});

// upvote / downvote review

var upvoteBtn = document.querySelectorAll('.review-container .top .user-actions a.upvote-review');
var loginIcon = document.querySelector('.login-icon');

upvoteBtn.forEach(function(button){
    // if user logged in
    if(loginIcon.classList.contains('active')){

        button.addEventListener('click' , function(e){

            e.preventDefault();

            var reviewId = button.getAttribute('data-review-id');  // get review id
            if(button.classList.contains('active')){  // if already upvoted downvote it

                downvoteReview(reviewId);

                button.classList.remove('active');
                button.style.color = "#222";
                button.addEventListener('mouseenter' , function(){
                    button.style.color = "green";
                });
                button.addEventListener('mouseleave' , function(){
                    button.style.color = "#222";
                });

                var numOfUpvotes = button.nextElementSibling;
                let upvotes = numOfUpvotes.innerHTML;
                numOfUpvotes.innerHTML = parseInt(upvotes)-1;

            }else{  // if not in wishlist

                upvoteReview(reviewId);

                button.classList.add('active');
                button.style.color = "green";
                button.addEventListener('mouseenter' , function(){
                    button.style.color = "green";
                });
                button.addEventListener('mouseleave' , function(){
                    button.style.color = "green";
                });

                var numOfUpvotes = button.nextElementSibling;
                let upvotes = numOfUpvotes.innerHTML;
                numOfUpvotes.innerHTML = parseInt(upvotes)+1;
            }
        });

    }else{  // if user isnt logged in yet, open login page when they click on upvote button
        button.onclick = () => {
            var bookId = button.getAttribute('data-book-id');
            window.location.href = URL+"login/?intended=book&bid="+bookId;
        }
    }
});


// unpublish review
var publishButtons = document.querySelectorAll(".admin-actions form .unpublish-review");
publishButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var reviewId = button.getAttribute('data-review-id');
        var userName = button.getAttribute('data-user-name');
        var bookTitle = button.getAttribute('data-book-title');

        if(LANGUAGE == 'ar'){
            if (confirm(" هل أنت متأكد من التراجع عن نشر مراجعة المستخدم `"+userName+"` لكتاب `"+bookTitle+"` ؟") == true) {
                var unpublishReviewForm = document.querySelector('form.admin-unpublish-review-form[data-review-id="'+ reviewId+'"]');
                unpublishReviewForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir dépublier l'avis de `"+userName+"` pour le livre `"+bookTitle+"` ?") == true) {
                var unpublishReviewForm = document.querySelector('form.admin-unpublish-review-form[data-review-id="'+ reviewId+'"]');
                unpublishReviewForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to unpublish the review of `"+userName+"` for the book `"+bookTitle+"` ?") == true) {
                var unpublishReviewForm = document.querySelector('form.admin-unpublish-review-form[data-review-id="'+ reviewId+'"]');
                unpublishReviewForm.submit();
            }
        }

    });
});

// ban user

var banButtons = document.querySelectorAll(".admin-actions form .ban-user");
banButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var userId = button.getAttribute('data-user-id');
        var userName = button.getAttribute('data-user-name');

        if(LANGUAGE == 'ar'){
            if (confirm(" هل أنت متأكد من حضر المستخدم `"+userName+"`؟") == true) {
                var banUserForm = document.querySelector('form.ban-user-form[data-user-id="'+ userId+'"]');
                banUserForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir bannir l’utilisateur "+userName+" ?") == true) {
                var banUserForm = document.querySelector('form.ban-user-form[data-user-id="'+ userId+'"]');
                banUserForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to ban the user `"+userName+"`?") == true) {
                var banUserForm = document.querySelector('form.ban-user-form[data-user-id="'+ userId+'"]');
                banUserForm.submit();
            }
        }
    });
});

// unban user

var banButtons = document.querySelectorAll(".admin-actions form .unban-user");
banButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var userId = button.getAttribute('data-user-id');
        var userName = button.getAttribute('data-user-name');

        if(LANGUAGE == 'ar'){
            if (confirm(" هل أنت متأكد من رفع الحضر على المستخدم `"+userName+"`؟") == true) {
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+ userId+'"]');
                unbanUserForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir débannir l’utilisateur `"+userName+"` ?") == true) {
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+ userId+'"]');
                unbanUserForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to unban the user `"+userName+"`?") == true) {
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+ userId+'"]');
                unbanUserForm.submit();
            }
        }
    });
});

//  admin delete review

var adminDeleteButton = document.querySelectorAll(".admin-actions form .delete-review");
adminDeleteButton.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var reviewId = button.getAttribute('data-review-id');
        var userName = button.getAttribute('data-user-name');

        if(LANGUAGE == 'ar'){
            if (confirm("هل أنت متأكد من أنك تريد حذف مراجعة "+userName+" للكتاب؟") == true) {
                var adminDeleteReviewForm = document.querySelector('form.admin-delete-review-form[data-review-id="'+ reviewId+'"]');
                adminDeleteReviewForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to delete "+userName+"'s review of the book?") == true) {
                var adminDeleteReviewForm = document.querySelector('form.admin-delete-review-form[data-review-id="'+ reviewId+'"]');
                adminDeleteReviewForm.submit();
            }
        }
    });
});

// functions

async function upvoteReview(reviewId) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: URL+`reviews/${reviewId}/upvote`,
        method: "POST",
        dataType : 'json',
        data: {
            review: reviewId
        },
        success: function(response) {
            console.log(response.message);
        }
    });

}

async function downvoteReview(reviewId) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: URL+`reviews/${reviewId}/downvote`,
        method: "POST",
        dataType : 'json',
        data: {
            review: reviewId
        },
        success: function(response) {
            console.log(response.message);
        }
    });
}

