<?php
declare(strict_types=1);

define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');

$transmitResponse = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['positionApplyingFor']) && isset($_POST['userResume'])) {
        if (isset($_POST['userName'])) {
            $UserName = htmlspecialchars(strip_tags(trim($_POST['userName'])));
        }
        if (isset($_POST['userEmail'])) {
            $UserEmail = htmlspecialchars(strip_tags(trim($_POST['userEmail'])));
        }
        if (isset($_POST['positionApplyingFor'])) {
            $PositionApplyingFor = htmlspecialchars(strip_tags(trim($_POST['positionApplyingFor'])));
        }
        if (isset($_POST['userResume'])) {
            $UserResume = htmlspecialchars(strip_tags(trim($_POST['userResume'])));
        }
        if (isset($_POST['coverLetter'])) {
            $CoverLetter = htmlspecialchars(strip_tags(trim($_POST['coverLetter'])));
        }
        $SendEmailTo = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;



        $ValidUserName = true;
        if (Trim($UserName) === "") {
            $ValidUserName = false;
        }
        if ($ValidUserName === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a name.</p>";
        }


        $ValidPositionApplyingFor = true;
        if (Trim($PositionApplyingFor) === "") {
            $ValidPositionApplyingFor = false;
        }
        if ($ValidPositionApplyingFor === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter the position you are applying for.</p>";
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


        $ValidUserResume = true;
        if (Trim($UserResume) === "") {
            $ValidUserResume = false;
        }
        if ($ValidUserResume === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please paste your resume in the resume textarea.</p>";
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
            $Body .= "<strong>User Name:</strong> " . $UserName . "<br />";
            $Body .= "<strong>Position Applying for:</strong> " . $PositionApplyingFor . "<br />";
            $Body .= "<strong>User Email:</strong> " . $UserEmail . "<br />";
            $Body .= "<br />";
            $Body .= "<strong>Resume:</strong> " . $UserResume . "<br />";
            $Body .= "<br />";
            $Body .= "<strong>Cover Letter:</strong> " . $CoverLetter . "<br />";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: Application for " . $PositionApplyingFor, $Body, $Headers);
            if ($SuccessfulSubmission) {
                $transmitResponse .= "<p>" . $UserName . ", your application was successfully submitted for the " . $PositionApplyingFor . " position.  "
                        . "Thanks for applying, we look forward to reviewing your application!</p>";
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
        <title>Careers | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-careers">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(41)->post_title); ?></h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="inner-wrapper">
                <div class="content">
                    <div class="content-row">
                        <div class="col-sma-5">
                            <?php
                            $id = 41;
                            $page = get_post($id);
                            $content = "" . apply_filters('the_content', $page->post_content);
                            echo $content;
                            ?>
                            <div class="careers-container">
                                <div class="careers-container__position zero">
                                    <div class="careers-container__posititon__title">Cashier/Store Supply Associate</div>
                                    <div class="careers-container__position__image"></div>
                                    <p>Duties range from cashiering, taking custom orders, and stocking to baking both in batches
                                        and from scratch.  Make sure every customer is satisfied and eager to come back again soon!</p>
                                    <p>Bonus points for baking enthusiasm, skills, and previous experience working in a bakery.</p>
                                    <div class="clear-both"></div>
                                </div>
                                <div class="careers-container__position one">
                                    <div class="careers-container__posititon__title">Baker</div>
                                    <div class="careers-container__position__image"></div>
                                    <p>Love baking, especially from scratch?  Come help us make top-notch health and tasty baked goods.  We 
                                        produce everything from cookies, bread, cakes, pies, pastries, and more!  Opportunity to customize recipes too.</p>
                                    <p>Bonus points for baking enthusiasm, skills, and previous experience working in a bakery.</p>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sma-7">
                            <div class="careers-image-container">
                                <div class="careers-container__background"></div>
                            </div>
                            <div class="careers-container" id="careersContainer">
                                <h4 class="contact-container__title">Send Your Application Here!</h4>
                                <form class="contact-container__form" id="careersForm" @submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="contact-container__response">
                                        <p>Thank you <strong>{{writeResponse}}</strong> for applying, we look forward to reviewing you application!</p>
                                        <p><strong>We are an Equal Opportunity Employer!</strong></p>     
                                        <div v-if="errors.length">
                                            <strong>Review the following fields:</strong>
                                            <ul>
                                                <li v-for="error in errors">{{error}}</li>
                                            </ul>
                                        </div>   
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="userName"><strong>Name *</strong></label>
                                        <input type="text" id="userName" name="userName" placeholder="Enter Full Name Here" required="required" v-model="userName"> 
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="userEmail"><strong>Email *</strong></label>
                                        <input type="email" id="userEmail" name="userEmail" placeholder="Enter Email Here" required="required" v-model="userEmail"> 
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="positionApplyingFor"><strong>Position Applying for *</strong></label>
                                        <input type="text" id="positionApplyingFor" name="positionApplyingFor" placeholder="Enter The Position You are Applying for" required="required" v-model="positionApplyingFor">    
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="userResume"><strong>Resume (paste here) *</strong></label>
                                        <textarea id="userResume" name="userResume" rows="8" placeholder="Paste Resume Here" required="required" v-model="userResume"></textarea>  
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="coverLetter"><strong>Cover Letter</strong></label>
                                        <textarea id="coverLetter" name="coverLetter" rows="8" placeholder="Please write your cover letter here."></textarea>                          
                                    </div>                           
                                    <div class="input-container">
                                        <button class="input-container__contact-button" id="applyButton" name="applyButton" type="submit" @click="setClickedSubmitTrue">Send Application!</button>                          
                                    </div>
                                </form>
                                <?php
                                    echo "<div class=\"contact-container__response-message\">$transmitResponse</div>";
                                ?>
                            </div>
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
                    setCurrentPage(5);
                });
            </script>
        </div>
        <script type="text/javascript">
            // Use AJAX to update part of the page without reloading the whole page.
            document.getElementById("careersForm").addEventListener("submit", function (event) {
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

                let userName = document.getElementById("userName").value;  
                let userEmail = document.getElementById("userEmail").value;  
                let positionApplyingFor = document.getElementById("positionApplyingFor").value;    
                let userResume = document.getElementById("userResume").value;  
                let coverLetter = document.getElementById("coverLetter").value;  

                let formInfo = "userName=" + userName + "&userEmail=" + userEmail + "&positionApplyingFor=" + 
                        positionApplyingFor + "&userResume=" + userResume + "&coverLetter=" + coverLetter;


                xhttp.open("POST", "careers.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(formInfo); 
            }
        </script>
    </body>

</html>
