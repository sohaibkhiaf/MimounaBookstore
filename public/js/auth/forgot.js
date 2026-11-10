import {URL} from "../connection.js";

// initialize variables
var createAccountLink = document.querySelector('.forgot .form-container .reset-password-form p a.create-account');
var resetPasswordLink = document.querySelector('.forgot .form-container .reset-password-form p a.login-link');

var lackAccountLabel = document.querySelector('.forgot .form-container .reset-password-form p.lack-account');
var haveAccountLabel = document.querySelector('.forgot .form-container .reset-password-form p.have-account');

createAccountLink.addEventListener('click' , function(e){
    e.preventDefault();

    var intended = lackAccountLabel.getAttribute('data-intended-page');
    var bookId = lackAccountLabel.getAttribute('data-book-id');

    window.location.href = URL+"register?intended="+intended+"&bid="+bookId;
});


resetPasswordLink.addEventListener('click' , function(e){
    e.preventDefault();

    var intended = haveAccountLabel.getAttribute('data-intended-page');
    var bookId = haveAccountLabel.getAttribute('data-book-id');

    window.location.href = URL+"login?intended="+intended+"&bid="+bookId;
});
