

function setCurrentPage(linkNumber) {
    let navBarMobile = document.getElementById("mobileNav");
    let navBarMobileItems = navBarMobile.getElementsByClassName("nav__nav-link");
 
    for (let i = 0; i < navBarMobileItems.length; i++) {
        navBarMobileItems[i].className.replace(" current-page", "");
    }
    navBarMobileItems[linkNumber].className += " current-page";
    
    
    let navBarDesktop = document.getElementById("desktopNav");
    let navBarDesktopItems = navBarDesktop.getElementsByClassName("nav__nav-link");
    for (let i = 0; i < navBarDesktopItems.length; i++) {
        navBarDesktopItems[i].className.replace(" current-page", "");
    }
    navBarDesktopItems[linkNumber].className += " current-page";
}


let dropdownButton = document.getElementById("dropdownButton");
dropdownButton.addEventListener("click", toggleHamburgerMenu, "false");

function toggleHamburgerMenu() {
    document.getElementById("mobileNav").classList.toggle("show");
}


function openModal(e) {
    let footerSubscribeButton = document.getElementById("footerSubscribeButton");
    let modalMask = document.getElementById("modalMask");
    
    if (document.activeElement === footerSubscribeButton){
        if (!e.keyCode || e.keyCode === 13){
            modalMask.classList.add("show");
        }
    }
}
document.addEventListener( "keydown", openModal );


function closeModal(e) {
    if (!e.keyCode || e.keyCode === 27){
        document.getElementById("modalMask").classList.remove("show");
    }
}
document.addEventListener( "keydown", closeModal );
