import {URL} from "../connection.js";

// initialize variables
var dialog = document.querySelector('.dialog');

var logoutButton = document.querySelector('.logout-button');
var languageButton = document.querySelector('.language-icon');

var languageForm = document.querySelector('.dialog .dialog-container .language-form');
var logoutDialog = document.querySelector('.dialog .dialog-container .logout-dialog');

var confirmLogoutBtn = document.querySelector('.dialog .dialog-container .logout-dialog .buttons-container .confirm-logout');
var cancelLogoutBtn = document.querySelector('.dialog .dialog-container .logout-dialog .buttons-container .cancel-logout');

var closeDialog = document.querySelector('.close-dialog');

// logout dialog
if(logoutButton){
    logoutButton.onclick = (e) =>{
        e.preventDefault();

        languageForm.style.display = "none";
        logoutDialog.style.display = "block";

        dialog.classList.add('active');

        dialog.style.alignItems = "center";

        confirmLogoutBtn.addEventListener('click' , function(e){
            window.location.href = URL + "user/account?tab=logout";
        });

        cancelLogoutBtn.addEventListener('click' , function(e){
            dialog.classList.remove('active');
        });

        closeDialog.onclick = () => {
            dialog.classList.remove('active');
        }
    }
}

// language dialog
if(languageButton){
    languageButton.onclick = (e) =>{
        e.preventDefault();

        dialog.classList.add('active');

        languageForm.style.display = "block";
        logoutDialog.style.display = "none";

        closeDialog.onclick = () => {
            dialog.classList.remove('active');
        }
    }
}


