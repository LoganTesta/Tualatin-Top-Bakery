<?php
$transmitResponseSubscribe = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['userNameSubscribe']) && isset($_POST['userEmailSubscribe'])) {
        if (isset($_POST['userNameSubscribe'])) {
            $UserNameSubscribe = htmlspecialchars(strip_tags(trim($_POST['userNameSubscribe'])));
        }
        if (isset($_POST['userEmailSubscribe'])) {
            $UserEmailSubscribe = htmlspecialchars(strip_tags(trim($_POST['userEmailSubscribe'])));
        }
        $UserSubjectSubscribe = "Tualatin Top Bakery: Subscribe";
        $SendEmailToSubscribe = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;



        $ValidUserNameSubscribe = true;
        if (Trim($UserNameSubscribe) === "") {
            $ValidUserNameSubscribe = false;
        }
        if ($ValidUserNameSubscribe === false) {
            $PassedValidation = false;
            $transmitResponseSubscribe .= "<p>Please enter a name.</p>";
        }


        $ValidUserEmailSubscribe = true;
        if (Trim($UserEmailSubscribe) === "") {
            $ValidUserEmailSubscribe = false;
        }
        /* More advanced e-mail validation */
        if (!filter_var($UserEmailSubscribe, FILTER_VALIDATE_EMAIL)) {
            $ValidUserEmailSubscribe = false;
        }
        if ($ValidUserEmailSubscribe === false) {
            $PassedValidation = false;
            $transmitResponseSubscribe .= "<p>Please enter a valid email.</p>";
        }


        if ($PassedValidation === false) {
            $transmitResponseSubscribe .= "<p>Sorry, validation failed.  Please check all fields again.</p>";
        }

        if ($PassedValidation) {
            /* Set the headers */
            $Headers = "";
            $Headers .= "From: <$UserEmailSubscribe>\r\n";
            $Headers .= "MIME-Version: 1.0\r\n";
            $Headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            /* Create the e-mail body. */
            $BodySubscribe = "This user has requested subscription to our bakery customer emails.<br />";
            $BodySubscribe .= "<strong>User Name:</strong> " . $UserNameSubscribe . "<br />";
            $BodySubscribe .= "<strong>User Email:</strong> " . $UserEmailSubscribe . "<br />";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail($SendEmailToSubscribe, $UserSubjectSubscribe, $BodySubscribe, $Headers);
            if ($SuccessfulSubmission) {
                $transmitResponseSubscribe .= "<p>" . $UserNameSubscribe . ", your form was successfully submitted.  You are "
                        . "now subscribed to our specials and updates!</p>";
            } else if ($SuccessfulSubmission === false) {
                $transmitResponseSubscribe .= "<p>Submission failed. Please try again.</p>";
            }
        }
    }
}
?>


<footer>
    <div class="inner-wrapper">
        <div class="footer__additional-wrapper">     
            <div class="content-row">
                <div class="footer__copyright">
                    <p>&copy; <?php echo date("Y"); ?> Tualatin Top Bakery. All Rights Reserved.</p>
                </div>

                <script type="text/x-template" id="modal-template">
                    <transition name="modal">
                    <div class="modal__mask subscribe-modal">
                    <div class="modal__wrapper">
                    <div class="modal__container">
                    <div class="modal__header">
                    <slot name="header">
                    <h3>Subscribe</h3>
                    </slot>
                    </div>
                    <div class="modal__body">
                    <slot name="body">
                    <p>This is the modal body text.</p>        
                    </slot>
                    </div>
                    <div class="modal__footer">
                    <slot name="footer">
                    Footer text here.
                    </slot>
                    <div class="modal__close-button" @click="$emit('close')">
                    X
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>              
                    </transition>
                </script>       

                <div class="footer__subscribe">
                    <div class="footer__subscribe-button">
                        <div class="footer__subscribe-button__extra-bg-layer"></div>
                        <div class="footer__subscribe-button__bg"><span class="footer__subscribe-button__text">Subscribe for Discounts/Cookies!</span></div> 
                    </div>
                    <modal class="footer__modal">
                        <h3 slot="header">Subscribe for News + Coupons</h3>
                        <div slot="body">
                            <p>Get news on upcoming events and sweet discounts on bakery products!  All new subscribers get a free cookie coupon 
                                in their inbox!</p>


                            <form class="contact-container__form" id="subscribeForm" @submit="validateSubscribeForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                {{writeResponse}} 
                                <div v-if="errors.length">
                                    <strong>Review the following fields:</strong>
                                    <ul>
                                        <li v-for="error in errors">{{error}}</li>
                                    </ul>
                                </div>  
                                <div class="input-container">
                                    <label class="input-container__label" for="userNameSubscribe"><strong>Name *</strong></label>
                                    <input type="text" id="userNameSubscribe" name="userNameSubscribe" placeholder="Enter Name Here" required="required" v-model="userNameSubscribe">    
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userEmailSubscribe"><strong>Email *</strong></label>
                                    <input type="email" id="userEmailSubscribe" name="userEmailSubscribe" placeholder="Enter Email Here" required="required" v-model="userEmailSubscribe"> 
                                </div>
                                <div class="input-container">
                                    <button class="input-container__contact-button" id="subscribeButton" name="subscribeButton" type="submit" @click="setClickedSubmitTrue">Subscribe!</button>                          
                                </div>                              
                            </form>
                            <?php 
                                echo "<div class=\"subscribe__response-message\">$transmitResponseSubscribe</div>";
                            ?>
                        </div>
                        <div slot="footer">
                            <span>Enjoy!</span>
                        </div>
                    </modal>
                </div>

                <div class="footer__social col-sma-4">
                    <h4 class="footer__subheader">Social</h4>
                    <div class="footer__social-logo facebook">
                        <a class="footer__social-logo__link" href=""><i class="fab fa-facebook-f fa-2x social-icon"><span class="sr-only">Facebook</span></i>
                        </a>
                    </div>
                    <div class="footer__social-logo instagram">
                        <a class="footer__social-logo__link" href=""><i class="fab fa-instagram fa-2x social-icon"><span class="sr-only">Instagram</span></i></a>
                    </div>
                    <div class="footer__social-logo twitter">
                        <a class="footer__social-logo__link" href=""><i class="fab fa-twitter fa-2x social-icon"><span class="sr-only">Twitter</span></i></a>
                    </div>
                </div>
                <div class="footer__location col-sma-4">
                    <h4 class="footer__subheader">Location</h4>
                    <div>4422 SW Tualatin-Sherwood Road, Tualatin, Oregon 97062</div>
                </div>
                <div class="footer__hours col-sma-4">
                    <h4 class="footer__subheader">Hours</h4>
                    <div class="footer__hours__day">Monday-Friday 7:00 AM-8:00 PM</div>
                    <div class="footer__hours__day">Saturday 8:00 AM-8:00 PM</div>
                    <div class="footer__hours__day">Sunday 8:00 AM-5:00 PM</div>
                </div>
            </div>
        </div>
    </div>
</footer>
