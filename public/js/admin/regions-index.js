import {URL} from "../connection.js";

// edit region
var editButtons = document.querySelectorAll('.region-edit');
editButtons.forEach(function(button){
    button.addEventListener('click' , function(e){
        var regionId = button.getAttribute('data-region-id');
        window.location.href = URL+"admin/regions/"+regionId+"/edit";
    });
});



// change view for phone

window.onresize = () => {

    if(window.innerWidth <= 768){

        var regionIdHeader = document.querySelector('.region-header');
        var nameHeader = document.querySelector('.name-header');
        var deskHeader = document.querySelector('.desk-header');
        var homeHeader = document.querySelector('.home-header');
        var statusHeader = document.querySelector('.status-header');
        var editHeader = document.querySelector('.edit-header');

        if(regionIdHeader){regionIdHeader.innerHTML = regionIdHeader.getAttribute('data-header-r');}
        if(nameHeader){ nameHeader.innerHTML = nameHeader.getAttribute('data-header-n'); }
        if(deskHeader){ deskHeader.innerHTML = deskHeader.getAttribute('data-header-dk'); }
        if(homeHeader){ homeHeader.innerHTML = homeHeader.getAttribute('data-header-hd'); }
        if(statusHeader){ statusHeader.innerHTML = statusHeader.getAttribute('data-header-st'); }
        if(editHeader){ editHeader.innerHTML = editHeader.getAttribute('data-header-ed'); }

    }else{
        var regionIdHeader = document.querySelector('.region-header');
        var nameHeader = document.querySelector('.name-header');
        var deskHeader = document.querySelector('.desk-header');
        var homeHeader = document.querySelector('.home-header');
        var statusHeader = document.querySelector('.status-header');
        var editHeader = document.querySelector('.edit-header');

        if(regionIdHeader){regionIdHeader.innerHTML =  regionIdHeader.getAttribute('data-header-regionid'); }
        if(nameHeader){ nameHeader.innerHTML = nameHeader.getAttribute('data-header-name'); }
        if(deskHeader){ deskHeader.innerHTML = deskHeader.getAttribute('data-header-desk'); }
        if(homeHeader){ homeHeader.innerHTML = homeHeader.getAttribute('data-header-home'); }
        if(statusHeader){ statusHeader.innerHTML = statusHeader.getAttribute('data-header-status'); }
        if(editHeader){ editHeader.innerHTML = editHeader.getAttribute('data-header-edit'); }
    }
}

window.onload = () => {

    if(window.innerWidth <= 768){

        var regionIdHeader = document.querySelector('.region-header');
        var nameHeader = document.querySelector('.name-header');
        var deskHeader = document.querySelector('.desk-header');
        var homeHeader = document.querySelector('.home-header');
        var statusHeader = document.querySelector('.status-header');
        var editHeader = document.querySelector('.edit-header');

        if(regionIdHeader){regionIdHeader.innerHTML = regionIdHeader.getAttribute('data-header-r');}
        if(nameHeader){ nameHeader.innerHTML = nameHeader.getAttribute('data-header-n'); }
        if(deskHeader){ deskHeader.innerHTML = deskHeader.getAttribute('data-header-dk'); }
        if(homeHeader){ homeHeader.innerHTML = homeHeader.getAttribute('data-header-hd'); }
        if(statusHeader){ statusHeader.innerHTML = statusHeader.getAttribute('data-header-st'); }
        if(editHeader){ editHeader.innerHTML = editHeader.getAttribute('data-header-ed'); }

    }else{
        var regionIdHeader = document.querySelector('.region-header');
        var nameHeader = document.querySelector('.name-header');
        var deskHeader = document.querySelector('.desk-header');
        var homeHeader = document.querySelector('.home-header');
        var statusHeader = document.querySelector('.status-header');
        var editHeader = document.querySelector('.edit-header');

        if(regionIdHeader){regionIdHeader.innerHTML =  regionIdHeader.getAttribute('data-header-regionid'); }
        if(nameHeader){ nameHeader.innerHTML = nameHeader.getAttribute('data-header-name'); }
        if(deskHeader){ deskHeader.innerHTML = deskHeader.getAttribute('data-header-desk'); }
        if(homeHeader){ homeHeader.innerHTML = homeHeader.getAttribute('data-header-home'); }
        if(statusHeader){ statusHeader.innerHTML = statusHeader.getAttribute('data-header-status'); }
        if(editHeader){ editHeader.innerHTML = editHeader.getAttribute('data-header-edit'); }
    }
}


