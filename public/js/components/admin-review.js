import {URL} from "../connection.js";

var LANGUAGE = document.documentElement.getAttribute('lang');

// upvote / downvote review

var upvoteBtn = document.querySelectorAll('.admin-review-container .top .user-actions a.upvote-review');

upvoteBtn.forEach(function(button){

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

        }else{

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
});

// publish review
var publishButtons = document.querySelectorAll(".admin-actions form .publish-review");
publishButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var reviewId = button.getAttribute('data-review-id');
        var userName = button.getAttribute('data-user-name');
        var bookTitle = button.getAttribute('data-book-title');

        if(LANGUAGE == 'ar'){
            if (confirm(" هل أنت متأكد من نشر مراجعة المستخدم `"+userName+"` لكتاب `"+bookTitle+"` ؟") == true) {
                var publishReviewForm = document.querySelector('form.admin-publish-review-form[data-review-id="'+ reviewId+'"]');
                publishReviewForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if (confirm("Êtes-vous sûr de vouloir publier l'avis de `"+userName+"` pour le livre `"+bookTitle+"` ?") == true) {
                var publishReviewForm = document.querySelector('form.admin-publish-review-form[data-review-id="'+ reviewId+'"]');
                publishReviewForm.submit();
            }
        }else{
            if (confirm("Are you sure you want to publish the review of `"+userName+"` for the book `"+bookTitle+"` ?") == true) {
                var publishReviewForm = document.querySelector('form.admin-publish-review-form[data-review-id="'+ reviewId+'"]');
                publishReviewForm.submit();
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

