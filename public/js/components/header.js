import {URL} from "../connection.js";

// search icon on click
var searchIcon = document.querySelector('.search-icon');
var searchForm = document.querySelector('.search-form');

searchIcon.onclick = () =>{
    // show search field in small screen when user clicks on searh button
    searchForm.classList.toggle('active');
}

// search button on click
var searchBtn = document.querySelector('.search-button');
var searchBox = document.querySelector('.search-box');

searchBtn.onclick = () => {
    // go to shop page and search for the book when user clicks search button and the field isn't empty
    var searchValue = searchBox.value;
    if(searchValue != ""){
        window.location.href = URL+"browse/shop?search="+searchValue;
    }
}

// open home page when the logo is clicked
var navLogo = document.querySelector('.navigation-logo');
navLogo.onclick = () =>{
    window.location.href = URL+"browse/index";
}

// login and wishlist icons
var loginIcon = document.querySelector('.login-icon');
var wishlistIcon = document.querySelector('.wishlist-icon');

if(loginIcon.classList.contains('active')){
    loginIcon.onclick = () =>{
        window.location.href = URL+"user/account";
    }
}else{
    loginIcon.onclick = () =>{
        window.location.href = URL+"login";
    }
    wishlistIcon.onclick = () =>{
        window.location.href = URL+"login?intended=wishlist";
    }
}

// scroll
var header2 = document.querySelector('.header .header-2');
window.onscroll = () =>{

    // hide search field on scroll
    searchForm.classList.remove('active');
    // hide and show the header on scroll
    if(window.scrollY > 80){
        header2.classList.add('active');
    }else{
        header2.classList.remove('active');
    }
}

window.onload = () =>{
    // hide and show the header on load
    if(window.scrollY > 80){
        header2.classList.add('active');
    }else{
        header2.classList.remove('active');
    }
}

