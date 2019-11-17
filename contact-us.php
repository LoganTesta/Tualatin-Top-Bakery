<?php declare(strict_types=1);

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
        if (Trim($UserFirstName) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserLastName) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserEmail) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserComments) === "") {
            $PassedValidation = false;
        }

        /* More advanced e-mail validation */
        if (!filter_var($UserEmail, FILTER_VALIDATE_EMAIL)) {
            $PassedValidation = false;
        }
        if ($PassedValidation === false) {
            $transmitResponse .= "Sorry validation failed.  Please check all fields again.";
        }

        /* Create the e-mail body. */
        $Body = "";
        $Body .= "User Name: " . $UserFirstName . " " . $UserLastName . "\n";
        $Body .= "User Email: " . $UserEmail . "\n";
        $Body .= "Subject: " . $UserSubject . "\n";
        $Body .= "User Comments: " . $UserComments . "\n";

        /* Send the e-mail. */
        $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: " . $UserSubject, $Body, "From: <$UserEmail>");
        if ($SuccessfulSubmission) {
            $transmitResponse .= $UserFirstName . ", your form was successfully submitted.  Thanks for contacting us!";
        } else if ($SuccessfulSubmission === false) {
            $transmitResponse .= " Submission failed. Please try again.";
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
                    <h2 class="header__subtitle">Contact Us</h2>
                </div>
            </header>
            <?php include 'assets/include/navigation-content.php'; ?>
            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-5">
                        <h3>Contact Us</h3>
                        <p>We are the best local bakery for all your baked goods.</p>
                        <div class="contact-container" id="contactContainer">
                            <h4 class="contact-container__title">Write Us Here</h4>
                            <form class="contact-container__form" id="contactOurCoffeeShop" v-on:submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                            <?php if(!empty($transmitResponse)) { echo "<div class=\"contact-container__response-message\">$transmitResponse</div>"; } ?>
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
            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    setCurrentPage(6);
                                });
            </script>
        </div>
    </body>

</html>
