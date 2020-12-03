<?php
declare(strict_types=1);

define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');

$transmitResponse = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['userFirstName']) && isset($_POST['userLastName']) && isset($_POST['userEmail']) && isset($_POST['userComments'])) {
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
        if ($ValidUserFirstName === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a first name.</p>";
        }


        $ValidUserLastName = true;
        if (Trim($UserLastName) === "") {
            $ValidUserLastName = false;
        }
        if ($ValidUserLastName === false) {
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
        if ($ValidUserEmail === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a valid email.</p>";
        }


        $ValidUserComments = true;
        if (Trim($UserComments) === "") {
            $ValidUserComments = false;
        }
        if ($ValidUserComments === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please provide your message in the textarea.</p>";
        }


        if ($PassedValidation === false) {
            $transmitResponse .= "<p>Sorry, validation failed.  Please check all fields again.</p>";
        }

        if ($PassedValidation) {
            /* Set the headers */
            $Headers = "";
            $Headers .= "From: <$UserEmail>\r\n";
            $Headers .= "MIME-Version: 1.0\r\n";
            $Headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            /* Create the e-mail body. */
            $Body = "";
            $Body .= "<strong>User Name:</strong> " . $UserFirstName . " " . $UserLastName . "<br />";
            $Body .= "<strong>User Email:</strong> " . $UserEmail . "<br />";
            $Body .= "<strong>Subject:</strong> " . $UserSubject . "<br />";
            $Body .= "<strong>User Comments:</strong> " . $UserComments . "<br />";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: " . $UserSubject, $Body, $Headers);
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
            <div class="inner-wrapper">
                <div class="content">
                    <div class="content-row">
                        <div class="col-sma-5">
                            <?php
                            $id = 45;
                            $page = get_post($id);
                            $content = "" . apply_filters('the_content', $page->post_content);
                            echo $content;
                            ?>
                            <div class="contact-container" id="contactContainer">
                                <h4 class="contact-container__title">Write Us Here</h4>
                                <form class="contact-container__form" id="contactOurBakery" v-on:submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="contact-container__response">
                                        <p>&nbsp;</p>
                                        <h4>Note: this is fictional business site for a portfolio. Thanks!</h4>
                                        <p>&nbsp;</p>
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
                                <?php
                                    echo "<div class=\"contact-container__response-message\">$transmitResponse</div>";
                                ?>
                            </div>
                        </div>
                        <div class="col-sma-7">
                            <div class="contact-us-image-container">
                                <div class="contact-us-container__background"></div>
                            </div>
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
                    setCurrentPage(8);
                });
            </script>
        </div>
        <script type="text/javascript">
            // Use AJAX to update part of the page without reloading the whole page.
            document.getElementById("contactOurBakery").addEventListener("submit", function (event) {
                updateServerResponse(event); 
            }, false);

           function updateServerResponse(event) {
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

                let formInfo = "userFirstName=" + userFirstName + "&userLastName=" + userLastName + "&userEmail=" + userEmail + "&userSubject=" + 
                        userSubject + "&userComments=" + userComments;


                xhttp.open("POST", "contact-us.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(formInfo); 
            }
        </script>
    </body>

</html>
