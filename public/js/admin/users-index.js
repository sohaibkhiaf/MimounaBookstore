var LANGUAGE = document.documentElement.getAttribute('lang');

// unban user
var unbanButtons = document.querySelectorAll('.user-unban');

unbanButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        e.preventDefault();

        var userId = button.getAttribute('data-user-id');
        var userName = button.getAttribute('data-user-name');

        if(LANGUAGE == 'ar'){
            if(confirm("هل أنت متأكد من رفع الحضر على المستخدم `"+userName+"`؟") == true){
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+userId+'"]');
                unbanUserForm.submit();
            }
        }else if(LANGUAGE == 'fr'){
            if(confirm("Êtes-vous sûr de vouloir lever le bannissement de l’utilisateur `"+userName+"` ?") == true){
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+userId+'"]');
                unbanUserForm.submit();
            }
        }else{
            if(confirm("Are you sure you want to unban the user `"+userName+"`?") == true){
                var unbanUserForm = document.querySelector('form.unban-user-form[data-user-id="'+userId+'"]');
                unbanUserForm.submit();
            }
        }
    });
});


// change view for phone

window.onresize = () => {

    if(window.innerWidth <= 768){

        var userIdHeader = document.querySelector('.indentifier-header');
        var contactInfoHeader = document.querySelector('.information-header');
        var ordersHeader = document.querySelector('.orders-header');
        var ubanHeader = document.querySelector('.unban-header');

        if(userIdHeader){userIdHeader.innerHTML = userIdHeader.getAttribute('data-header-id');}
        if(contactInfoHeader){ contactInfoHeader.innerHTML = contactInfoHeader.getAttribute('data-header-in'); }
        if(ordersHeader){ ordersHeader.innerHTML = ordersHeader.getAttribute('data-header-o'); }
        if(ubanHeader){ ubanHeader.innerHTML = ubanHeader.getAttribute('data-header-ub'); }

    }else{
        var userIdHeader = document.querySelector('.indentifier-header');
        var contactInfoHeader = document.querySelector('.information-header');
        var ordersHeader = document.querySelector('.orders-header');
        var ubanHeader = document.querySelector('.unban-header');

        if(userIdHeader){userIdHeader.innerHTML =  userIdHeader.getAttribute('data-header-userid'); }
        if(contactInfoHeader){ contactInfoHeader.innerHTML = contactInfoHeader.getAttribute('data-header-information'); }
        if(ordersHeader){ ordersHeader.innerHTML = ordersHeader.getAttribute('data-header-orders'); }
        if(ubanHeader){ ubanHeader.innerHTML = ubanHeader.getAttribute('data-header-unban'); }
    }
}

window.onload = () => {

    if(window.innerWidth <= 768){

        var userIdHeader = document.querySelector('.indentifier-header');
        var contactInfoHeader = document.querySelector('.information-header');
        var ordersHeader = document.querySelector('.orders-header');
        var ubanHeader = document.querySelector('.unban-header');

        if(userIdHeader){userIdHeader.innerHTML = userIdHeader.getAttribute('data-header-id');}
        if(contactInfoHeader){ contactInfoHeader.innerHTML = contactInfoHeader.getAttribute('data-header-in'); }
        if(ordersHeader){ ordersHeader.innerHTML = ordersHeader.getAttribute('data-header-o'); }
        if(ubanHeader){ ubanHeader.innerHTML = ubanHeader.getAttribute('data-header-ub'); }

    }else{
        var userIdHeader = document.querySelector('.indentifier-header');
        var contactInfoHeader = document.querySelector('.information-header');
        var ordersHeader = document.querySelector('.orders-header');
        var ubanHeader = document.querySelector('.unban-header');

        if(userIdHeader){userIdHeader.innerHTML =  userIdHeader.getAttribute('data-header-userid'); }
        if(contactInfoHeader){ contactInfoHeader.innerHTML = contactInfoHeader.getAttribute('data-header-information'); }
        if(ordersHeader){ ordersHeader.innerHTML = ordersHeader.getAttribute('data-header-orders'); }
        if(ubanHeader){ ubanHeader.innerHTML = ubanHeader.getAttribute('data-header-unban'); }
    }
}

