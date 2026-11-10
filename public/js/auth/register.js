import {URL} from "../connection.js";

// initialize variables
var loginLink = document.querySelector('.register .form-container .register-form p a.login-link');
var haveAccountLabel = document.querySelector('.register .form-container .register-form p.have-account');

// on login link click
loginLink.addEventListener('click' , function(e){
    e.preventDefault();

    var intended = haveAccountLabel.getAttribute('data-intended-page');
    var bookId = haveAccountLabel.getAttribute('data-book-id');

    window.location.href = URL + "login?intended="+intended+ "&bid="+bookId;
});

