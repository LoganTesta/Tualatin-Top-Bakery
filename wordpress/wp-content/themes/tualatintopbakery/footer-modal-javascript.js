
window.addEventListener("load", function () {

    let numberSubscribeForms = document.getElementsByClassName("footer__subscribe").length;

    document.getElementsByClassName("footer__subscribe-button__bg")[0].addEventListener("click", function (event) {
        document.getElementsByClassName("modal__mask")[0].classList.add("show");
    }, false);

    document.getElementsByClassName("modal__close-button")[0].addEventListener("click", function (event) {
        document.getElementsByClassName("modal__mask")[0].classList.remove("show");
    }, false);



    // Use AJAX to update part of the page without reloading the whole page.
    document.getElementById("subscribeForm").addEventListener("submit", function (event) {
        updateServerResponse(event);
    }, false);

    function updateServerResponse(event) {
        event.preventDefault();
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let parser = new DOMParser();
                let ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                let message = ajaxDocument.getElementsByClassName("subscribe__response-message")[0];

                document.getElementsByClassName("subscribe__response-message")[0].innerHTML = "" + message.innerHTML + "";
                document.getElementsByClassName("subscribe__response-message")[0].classList.add("show");
            }
        };

        let userNameSubscribe = document.getElementById("userNameSubscribe").value;
        let userEmailSubscribe = document.getElementById("userEmailSubscribe").value;

        let formInfo = "userNameSubscribe=" + userNameSubscribe + "&userEmailSubscribe=" + userEmailSubscribe;


        xhttp.open("POST", "" + window.location.href, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(formInfo);
    }

}, "false");
