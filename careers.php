<?php declare(strict_types=1);

$transmitResponse = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['applyButton'])) {
        if (isset($_POST['userName'])) {
            $UserName = htmlspecialchars(strip_tags(trim($_POST['userName'])));
        }
        if (isset($_POST['positionApplyingFor'])) {
            $PositionApplyingFor = htmlspecialchars(strip_tags(trim($_POST['positionApplyingFor'])));
        }
        if (isset($_POST['userEmail'])) {
            $UserEmail = htmlspecialchars(strip_tags(trim($_POST['userEmail'])));
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
        if (Trim($UserName) === "") {
            $PassedValidation = false;
        }
        if (Trim($PositionApplyingFor) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserEmail) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserResume) === "") {
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
        $Body .= "User Name: " . $UserName . "\n";
        $Body .= "Position Applying for: " . $PositionApplyingFor . "\n";      
        $Body .= "User Email: " . $UserEmail . "\n";
        $Body .= "\n";
        $Body .= "Resume: " . $UserResume . "\n";
        $Body .= "\n";
        $Body .= "Cover Letter: " . $CoverLetter . "\n";

        /* Send the e-mail. */
        $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: Application for " . $PositionApplyingFor, $Body, "From: <$UserEmail>");
        if ($SuccessfulSubmission) {
            $transmitResponse .= $UserName . ", your application was successfully submitted for the " . $PositionApplyingFor .  " position.  "
                    . "Thanks for applying, we look forward to reviewing your application!";
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
        <title>Careers | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-careers">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">Careers</h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-5">
                        <h3>Bake with Us!</h3>
                        <p>Want to come work for the best local bakery for all your baked goods?</p>
                        <p>We are looking for several part and full time store associates.</p>
                        <p><strong>To apply: either fill out the application form on this page, or come on in and pick up an application!</strong></p>
                        <div class="careers-container">
                            <div class="careers-container__position">
                                <div class="careers-container__posititon__title">Cashier/Store Supply Associate</div>
                                <p>Duties range from cashiering, taking custom orders, and stocking to baking both in batches
                                    and from scratch.  Make sure every customer is satisfied and eager to come back again soon!</p>
                                <p>Bonus points for baking enthusiasm, skills, and previous experience working in a bakery.</p>
                            </div>
                            <div class="careers-container__position">
                                <div class="careers-container__posititon__title">Baker</div>
                                <p>Love baking, especially from scratch?  Come help us make top-notch health and tasty baked goods.  We 
                                    produce everything from cookies, bread, cakes, pies, pastries, and more!  Opportunity to customize recipes too.</p>
                                <p>Bonus points for baking enthusiasm, skills, and previous experience working in a bakery.</p>
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
                            <?php if(!empty($transmitResponse)) { echo "<div class=\"contact-container__response-message\">$transmitResponse</div>"; } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'assets/include/message-content.php'; ?>
            <?php include 'assets/include/footer-content.php'; ?>
            <script type="text/javascript" src="assets/javascript/javascript-functions.js"></script>
            <script type="text/javascript" src="assets/javascript/careers-form-validation.js"></script>
            <script type="text/javascript" src="assets/javascript/vue-functions.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(5);
                });
            </script>
        </div>
    </body>

</html>
