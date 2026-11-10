import {URL} from "../connection.js";

// initialize variables
var createAccountLink = document.querySelector('.login .form-container .login-form p a.create-account');
var resetPasswordLink = document.querySelector('.login .form-container .login-form p a.reset-password');

var lackAccountLabel = document.querySelector('.login .form-container .login-form p.lack-account');
var forgotPasswordLabel = document.querySelector('.login .form-container .login-form p.forgot-password');

// create account link
createAccountLink.addEventListener('click' , function(e){
    e.preventDefault();

    var intended = lackAccountLabel.getAttribute('data-intended-page');
    var bookId = lackAccountLabel.getAttribute('data-book-id');

    window.location.href = URL+"register?intended="+intended+"&bid="+bookId;

});

// reset password link
resetPasswordLink.addEventListener('click' , function(e){
    e.preventDefault();

    var intended = forgotPasswordLabel.getAttribute('data-intended-page');
    var bookId = forgotPasswordLabel.getAttribute('data-book-id');

    window.location.href = URL+"forgot?intended="+intended+"&bid="+bookId;

});
