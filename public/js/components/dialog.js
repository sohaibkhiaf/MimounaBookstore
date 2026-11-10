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

function hideDialog() {
    if (dialog) {
        dialog.classList.remove('active');
    }
}

// logout dialog
if(logoutButton){
    logoutButton.onclick = (e) =>{
        e.preventDefault();

        languageForm.style.display = "none";
        logoutDialog.style.display = "block";

        dialog.classList.add('active');
        dialog.style.alignItems = "center";

        if (confirmLogoutBtn) {
            confirmLogoutBtn.onclick = function(){
                window.location.href = URL + "user/account?tab=logout";
            };
        }

        if (cancelLogoutBtn) {
            cancelLogoutBtn.onclick = hideDialog;
        }

        if (closeDialog) {
            closeDialog.onclick = hideDialog;
        }
    };
}

// language dialog
if(languageButton){
    languageButton.onclick = (e) =>{
        e.preventDefault();

        dialog.classList.add('active');

        languageForm.style.display = "block";
        logoutDialog.style.display = "none";

        if (closeDialog) {
            closeDialog.onclick = hideDialog;
        }
    };
}

// Close dialog when clicking on the backdrop or pressing Escape
if (dialog) {
    dialog.addEventListener('click', function(e) {
        if (e.target === dialog) {
            hideDialog();
        }
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && dialog && dialog.classList.contains('active')) {
        hideDialog();
    }
});
