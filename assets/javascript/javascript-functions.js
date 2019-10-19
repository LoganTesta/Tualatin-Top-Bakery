

function setCurrentPage(linkNumber) {
    var navBarDesktop = document.getElementById("desktop-nav");
    var navBarDesktopItems = navBarDesktop.getElementsByClassName("nav__nav-link");
    for (var i = 0; i < navBarDesktopItems.length; i++) {
        navBarDesktopItems[i].className.replace(" current-page", "");
    }
    navBarDesktopItems[linkNumber].className += " current-page";
}


var dropdownButton=document.getElementById("dropdownButton");
dropdownButton.addEventListener("click", toggleHamburgerMenu, "false");

function toggleHamburgerMenu (){
    document.getElementById("dropdownContent").classList.toggle("show");
}