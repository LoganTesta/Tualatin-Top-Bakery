<?php declare(strict_types = 1);

define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');

$transmitResponse = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['contactButton'])) {
        if (isset($_POST['userFirstName'])) {
            $UserFirstName = htmlspecialchars(strip_tags(trim($_POST['userFirstName'])));
        }
        if (isset($_POST['userLastName'])) {
            $UserLastName = htmlspecialchars(strip_tags(trim($_POST['userLastName'])));
        }
        if (isset($_POST['userEmail'])) {
            $UserEmail = htmlspecialchars(strip_tags(trim($_POST['userEmail'])));
        }
        if (isset($_POST['userSubject'])) {
            $UserSubject = htmlspecialchars(strip_tags(trim($_POST['userSubject'])));
        }
        if (isset($_POST['userComments'])) {
            $UserComments = htmlspecialchars(strip_tags(trim($_POST['userComments'])));
        }
        $SendEmailTo = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;
        
           
        $ValidUserFirstName = true;
        if (Trim($UserFirstName) === "") {
            $ValidUserFirstName = false;
        }
        if ($ValidUserFirstName === false){
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a first name.</p>";
        }
        
        
        $ValidUserLastName = true;
        if (Trim($UserLastName) === "") {
            $ValidUserLastName = false;
        }
        if ($ValidUserLastName === false){
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a last name.</p>";
        }
        
        
        $ValidUserEmail = true;
        if (Trim($UserEmail) === "") {
            $ValidUserEmail = false;
        }
        /* More advanced e-mail validation */
        if (!filter_var($UserEmail, FILTER_VALIDATE_EMAIL)) {
            $ValidUserEmail = false;
        }
        if ($ValidUserEmail === false){
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a valid email.</p>";
        }
        
          
        $ValidUserComments = true;
        if (Trim($UserComments) === "") {
            $ValidUserComments = false;
        }
        if ($ValidUserComments === false){
            $PassedValidation = false;
            $transmitResponse .= "<p>Please provide your message in the textarea.</p>";
        }


        if ($PassedValidation === false) {
            $transmitResponse .= "<p>Sorry, validation failed.  Please check all fields again.</p>";
        }

        if ($PassedValidation) {
            /* Create the e-mail body. */
            $Body = "";
            $Body .= "User Name: " . $UserFirstName . " " . $UserLastName . "\n";
            $Body .= "User Email: " . $UserEmail . "\n";
            $Body .= "Subject: " . $UserSubject . "\n";
            $Body .= "User Comments: " . $UserComments . "\n";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: " . $UserSubject, $Body, "From: <$UserEmail>");
            if ($SuccessfulSubmission) {
                $transmitResponse .= "<p>" . $UserFirstName . ", your form was successfully submitted.  Thanks for contacting us!</p>";
            } else if ($SuccessfulSubmission === false) {
                $transmitResponse .= "<p>Submission failed. Please try again.</p>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Contact | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-contact-us">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(45)->post_title); ?></h2>
                </div>
            </header>
            <?php include 'assets/include/navigation-content.php'; ?>
            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-5">
                        <?php
                        $id = 45;
                        $page = get_post($id);
                        $content = "&nbsp;" . apply_filters('the_content', $page->post_content);
                        echo $content;
                        ?>
                        <div class="contact-container" id="contactContainer">
                            <h4 class="contact-container__title">Write Us Here</h4>
                            <form class="contact-container__form" id="contactOurBakery" v-on:submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="contact-container__response">
                                    <p>Thank you <strong>{{writeResponse}}</strong> for writing to us!</p>
                                    <div v-if="errors.length">
                                        <strong>Review the following fields:</strong>
                                        <ul>
                                        <li v-for="error in errors">{{error}}</li>
                                        </ul>
                                    </div>    
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userFirstName"><strong>First Name *</strong></label>
                                    <input type="text" id="userFirstName" name="userFirstName" placeholder="Enter First Name Here" required="required" v-model="userFirstName"> 
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userLastName"><strong>Last Name *</strong></label>
                                    <input type="text" id="userLastName" name="userLastName" placeholder="Enter Last Name Here" required="required" v-model="userLastName">    
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userEmail"><strong>Email *</strong></label>
                                    <input type="text" id="userEmail" name="userEmail" placeholder="Enter Email Here" required="required" v-model="userEmail"> 
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userSubject"><strong>Subject</strong></label>
                                    <input type="text" id="userSubject" name="userSubject" placeholder="Enter Subject Here">    
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userComments"><strong>Message *</strong></label>
                                    <textarea id="userComments" name="userComments" rows="6" placeholder="Please write your message here.  Thanks." required="required" v-model="userComments"></textarea>                          
                                </div>                           
                                <div class="input-container">
                                    <button class="input-container__contact-button" id="contactButton" name="contactButton" type="submit" v-on:click="setClickedSubmitTrue">Contact Us!</button>                          
                                </div>
                            </form>
                            <?php echo "<div class=\"contact-container__response-message\">$transmitResponse</div>"; ?>
                        </div>
                    </div>
                    <div class="col-sma-7">
                        <div class="contact-us-image-container">
                            <div class="contact-us-container__background"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'assets/include/message-content.php'; ?>
            <?php include 'assets/include/footer-content.php'; ?>
            <script type="text/javascript" src="assets/javascript/javascript-functions.js"></script>
            <script type="text/javascript" src="assets/javascript/vue-functions.js"></script>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(7);
                });
            </script>
            <script type="text/javascript">
                //Use AJAX to update the cart without reloading the page.
                document.getElementById("contactOurBakery").addEventListener("submit", function (event) {
                   updateServerResponse(event); 
               }, false);

                function updateServerResponse(event){
                    event.preventDefault();
                    let xhttp = new XMLHttpRequest();

                    xhttp.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            let parser = new DOMParser();
                            let ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                            let message = ajaxDocument.getElementsByClassName("contact-container__response-message")[0];    

                            document.getElementsByClassName("contact-container__response-message")[0].innerHTML = "" + message.innerHTML + "";    
                            document.getElementsByClassName("contact-container__response-message")[0].classList.add("show");
                        }
                    };

                    let userFirstName = document.getElementById("userFirstName").value;  
                    let userLastName = document.getElementById("userLastName").value;  
                    let userEmail = document.getElementById("userEmail").value;  
                    let userSubject = document.getElementById("userSubject").value;   
                    let userComments = document.getElementById("userComments").value;  
                    let contactButton = document.getElementById("contactButton").value;  

                    let formInfo = "userFirstName=" + userFirstName + "&userLastName=" + userLastName + "&userEmail=" + userEmail + "&userSubject=" + userSubject + "&userComments=" + userComments + "&contactButton=" + contactButton;


                    xhttp.open("POST", "contact-us.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(formInfo); 
                }
            </script>
        </div>
    </body>

</html>
