<?php declare(strict_types=1);
session_start();

//Estimate cart code.
include("assets/include/product.php");

$WholeWheatLoaf = new Product("Whole Wheat Loaf", 3.00, "", "");
$WhiteBreadLoaf = new Product("White Bread Loaf", 2.00, "", "");
$BlueberryScone = new Product("Blueberry Scone", 2.25, "", "");
$ChocolateCake = new Product("Chocolate Cake", 15.00, "", "");
$CherryPie = new Product("Cherry Pie", 12.00, "", "");
$BlueberryMuffin = new Product("Blueberry Muffin", 2.25, "", "");


$products = array($WholeWheatLoaf, $WhiteBreadLoaf, $BlueberryScone, $ChocolateCake, $CherryPie, $BlueberryMuffin);
$quantities = array();
$itemSubtotal = array();

//Initialize the cart.
if(isset($_SESSION["estimateCart"]) === false){
    $_SESSION["estimateCart"] = "not empty";
    for($i = 0; $i < count($products); $i++){
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["itemSubtotal"][$i] = 0;
        $_SESSION["totalCost"] = 0;
    }
}

//Add items to cart.
if(isset($_SESSION["estimateCart"])){
    if(isset($_GET["item"])){
        $itemNumber = $_GET["item"];
        $_SESSION["quantity"][$itemNumber] = $_SESSION["quantity"][$itemNumber] + 1;
        $_SESSION["itemSubtotal"][$itemNumber] = $products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber];       
    }
    
    $_SESSION["totalCost"] = 0;
    for($i = 0; $i < count($products); $i++){
        $_SESSION["totalCost"] = $_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i];
    }
}

//Remove one item from cart.
if (isset($_SESSION["estimateCart"])) {
    if (isset($_GET["remove"])) {
        $itemNumber = $_GET["remove"];
        $newQuantity = $_SESSION["quantity"][$itemNumber] - 1;

        if ($newQuantity >= 0) {
            $_SESSION["quantity"][$itemNumber] = $newQuantity;
            $_SESSION["itemSubtotal"][$itemNumber] = $products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber];

            $_SESSION["totalCost"] = 0;
            for ($i = 0; $i < count($products); $i++) {
                $_SESSION["totalCost"] = $_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i];
            }
        }
    }
}

//Reset cart.
if (isset($_SESSION["estimateCart"])) {
    if(isset($_GET["resetCart"])){
        resetEstimateCart();
    }
}

function resetEstimateCart() {
    unset($_SESSION["estimateCart"]);
    $_SESSION["totalCost"] = 0;
    for ($i = 0; $i < 6; $i++) {
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["itemSubtotal"][$i] = 0;
    }
}

//Process the estimate request and validate the user input.
$transmitResponse = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['estimateButton'])) {
        if (isset($_POST['userName'])) {
            $UserName = htmlspecialchars(strip_tags(trim($_POST['userName'])));
        }
        if (isset($_POST['userEmail'])) {
            $UserEmail = htmlspecialchars(strip_tags(trim($_POST['userEmail'])));
        }
        if (isset($_POST['userPhone'])) {
            $UserPhone = htmlspecialchars(strip_tags(trim($_POST['userPhone'])));
        }
        if (isset($_POST['userStreetAddress'])) {
            $UserStreetAddress = htmlspecialchars(strip_tags(trim($_POST['userStreetAddress'])));
        }
        if (isset($_POST['userCity'])) {
            $UserCity = htmlspecialchars(strip_tags(trim($_POST['userCity'])));
        }
        if (isset($_POST['userState'])) {
            $UserState = htmlspecialchars(strip_tags(trim($_POST['userState'])));
        }
        if (isset($_POST['userZipCode'])) {
            $UserZipCode = htmlspecialchars(strip_tags(trim($_POST['userZipCode'])));
        }
        if (isset($_POST['additionalNotes'])) {
            $AdditionalNotes = htmlspecialchars(strip_tags(trim($_POST['additionalNotes'])));
        }
        $SendEmailTo = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;
        if (Trim($UserName) === "") {
            $PassedValidation = false;
        }
        
        if (Trim($UserEmail) === "") {
            $PassedValidation = false;
        }
        
        if (Trim($UserPhone) === "") {
            $PassedValidation = false;
        }
        if(strlen($UserPhone) !== 10){
            $PassedValidation = false;
        }

        if (Trim($UserState) === "") {
            $PassedValidation = false;
        }
        
        if (Trim($UserCity) === "") {
            $PassedValidation = false;
        }
        
        if (Trim($UserZipCode) === "") {
            $PassedValidation = false;
        }
        if(strlen($UserZipCode) !== 5){
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
        $Body .= "Email: " . $UserEmail . "\n";      
        $Body .= "Phone: " . $UserPhone . "\n";
        $Body .= "Address: " . $UserStreetAddress . "\n";
        $Body .= "" . $UserCity . ", " . $UserState . " " . $UserZipCode .  " " . "\n";
        $Body .= "\n";
        $Body .= "Estimate Items: \n";
        for ($i = 0; $i < count($products); $i++) {
            $Body .= "Product: " . $products[$i]->get_name() . ": " . $_SESSION["quantity"][$i] . " (Subtotal): $" . $_SESSION["itemSubtotal"][$i] . " \n";
        }
        $Body .= "\n";
        $Body .= "Estimate Cart Total: $" . $_SESSION["totalCost"] . ". \n";
        $Body .= "\n";
        $Body .= "Additional Notes: " . $AdditionalNotes . "\n";
        $Body .= "\n";

        /* Send the e-mail. */
        $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: Estimate Order Request for " . $UserName, $Body, "From: <$UserEmail>");
       
        if ($SuccessfulSubmission) {
            $transmitResponse .= $UserName . ", your estimate request was successfully submitted. <br />";
            $transmitResponse .= "<br />";
            $transmitResponse .= "Estimate Items: <br />";
            for($i = 0; $i < count($products); $i++){
                 $transmitResponse .= "Product: " . $products[$i]->get_name() . ": " . $_SESSION["quantity"][$i] . " (Subtotal): $" . $_SESSION["itemSubtotal"][$i] . " <br />";
            }
            $transmitResponse .= "<br />";
            $transmitResponse .= "Estimate Cart Total: $" . $_SESSION["totalCost"] . ". <br />";
            $transmitResponse .= "<br />";
            $transmitResponse .= "We will respond back within 2 business days! <br />";
            $transmitResponse .= "Thank you for shopping with Tualatin Top Bakery!";
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
        <title>Products | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-products">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">Products</h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-12 products-wrapper">
                        <div class="products-header">
                            <h3>Products</h3>
                            <p>Learn more about the baked goods we sell.  Baked fresh daily.</p>
                        </div>
                        <div class="products content-row">
                            <div class="col-sma-6">
                                <div class="product-container one">
                                    <div class="product__title"><?php echo $WholeWheatLoaf->get_name(); ?></div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $WholeWheatLoaf->get_price(); ?></div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our delicious and wholesome house-made whole wheat 
                                            bread, baked fresh daily.  One of our staples and customer favorites!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container two">
                                    <div class="product__title"><?php echo $WhiteBreadLoaf->get_name(); ?></div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $WhiteBreadLoaf->get_price(); ?></div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our delicious and fluffy house-made white bread, baked 
                                            fresh daily.  One of our staples and customer favorites!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container three">
                                    <div class="product__title"><?php echo $BlueberryScone->get_name(); ?></div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $BlueberryScone->get_price(); ?>/each</div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Light and fluffy and flaky.  We are always trying new 
                                            varieties of scones including some seasonal.  We often have blueberry, vanilla, chocolate scones, 
                                            and many more, so come on in and see what we're baking this week!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container four">
                                    <div class="product__title"><?php echo $ChocolateCake->get_name(); ?></div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $ChocolateCake->get_price(); ?> or $2.50/slice</div>  
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our signature crisp, fluffy chocolate cake with a light 
                                            layer of house-made chocolate fudge on top!  Yum!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container five">
                                    <div class="product__title"><?php echo $CherryPie->get_name(); ?> (and assorted pies)</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $CherryPie->get_price(); ?> or $2.50/slice</div> 
                                    <div class="product__description">
                                        <p>Assorted wide variety of pies here at Tualatin Top Bakery!</p>
                                        <p class="no-padding-bottom">We sell cherry pie year round and other pies we sell depending
                                            on the season include blueberry, pumpkin, banana cream pie, chocolate cream pie, and more!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container six">
                                    <div class="product__title"><?php echo $BlueberryMuffin->get_name(); ?></div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$<?php echo $BlueberryMuffin->get_price(); ?>/each</div> 
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Made with lots of blueberries and a hint of sugar.</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-row inner-wrapper estimate-section">
                    <div class="col-sma-6">
                        <div class="estimate-cart">
                            <h3 class="estimate-cart__title">Estimate Items</h3>
                            <table class="estimate-table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Cost</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Add</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $WholeWheatLoaf->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $WholeWheatLoaf->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][0]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][0]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                            
                                    </tr>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $WhiteBreadLoaf->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $WhiteBreadLoaf->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][1]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][1]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                             
                                    </tr>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $BlueberryScone->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $BlueberryScone->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][2]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][2]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                    </tr>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $ChocolateCake->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $ChocolateCake->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][3]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][3]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                    </tr>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $CherryPie->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $CherryPie->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][4]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][4]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                            
                                    </tr>
                                    <tr>
                                        <td class="estimate-table__item-title"><?php echo $BlueberryMuffin->get_name(); ?></td>
                                        <td class="estimate-table__item-cost">$<?php echo $BlueberryMuffin->get_price(); ?></td>
                                        <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][5]; ?></td>
                                        <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][5]; ?></td>
                                        <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                        <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                    </tr>
                                </tbody>
                            </table>
                            <div class="content-row estimate-table__cart-summary">
                                <div class="col-sma-6">
                                    <div class="cart-total">Today's Total: $<?php echo $_SESSION["totalCost"]; ?></div>
                                </div>
                                <div class="col-sma-6">
                                    <div class="reset-cart">Empty Cart</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sma-6">
                        <div class="estimate-container" id="estimateContainer">
                            <h3 class="estimate-container__title">Request Estimate</h3>
                            <form class="contact-container__form" id="estimateForm" @submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="contact-container__response">
                                    <p>We appreciate your business <strong>{{writeResponse}}</strong> at Tualatin Top Bakery! 
                                        We will look over your estimate, and respond 
                                        back within 2 business days with a quote including shipping costs.  We ship anywhere in the continental U.S.</p>
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
                                    <label class="input-container__label" for="userPhone"><strong>Phone (10 numbers, no dashes)*</strong></label>
                                    <input type="text" id="userPhone" name="userPhone" placeholder="Phone Number Here" required="required" v-model="userPhone">    
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userStreetAddress"><strong>Street Address *</strong></label>
                                    <input id="userStreetAddress" name="userStreetAddress" placeholder="Street Address" required="required" v-model="userStreetAddress" />  
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userCity"><strong>City *</strong></label>
                                    <input id="userCity" name="userCity" placeholder="City" required="required" v-model="userCity" />  
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userState"><strong>State *</strong></label>
                                    <input id="userState" name="userState" placeholder="State" required="required" v-model="userState" />  
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="userZipCode"><strong>ZIP Code *</strong></label>
                                    <input id="userZipCode" name="userZipCode" placeholder="ZIP Code" required="required" v-model="userZipCode" />  
                                </div>
                                <div class="input-container">
                                    <label class="input-container__label" for="additionalNotes"><strong>Additional Notes</strong></label>
                                    <textarea id="additionalNotes" name="additionalNotes" rows="8" placeholder="Please write any additional order notes here."></textarea>                          
                                </div>                           
                                <div class="input-container">
                                    <button class="input-container__contact-button" id="estimateButton" name="estimateButton" type="submit">Request Estimate!</button>                          
                                </div>
                            </form>
                            <?php if (!empty($transmitResponse)) {
                                echo "<div class=\"contact-container__response-message\">$transmitResponse</div>";
                            } ?>
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
                    setCurrentPage(2);
                });
            </script>
        </div>
        <script type="text/javascript">
            
            //Use AJAX to update the cart without reloading the page.
            document.getElementsByClassName("estimate-table__add__item")[0].addEventListener("click", function() { updateCart("item", "=", 0); }, false);
            document.getElementsByClassName("estimate-table__add__item")[1].addEventListener("click", function() { updateCart("item", "=", 1); }, false);
            document.getElementsByClassName("estimate-table__add__item")[2].addEventListener("click", function() { updateCart("item", "=", 2); }, false);
            document.getElementsByClassName("estimate-table__add__item")[3].addEventListener("click", function() { updateCart("item", "=", 3); }, false);
            document.getElementsByClassName("estimate-table__add__item")[4].addEventListener("click", function() { updateCart("item", "=", 4); }, false);
            document.getElementsByClassName("estimate-table__add__item")[5].addEventListener("click", function() { updateCart("item", "=", 5); }, false);
            
            document.getElementsByClassName("estimate-table__minus__item")[0].addEventListener("click", function() { updateCart("remove", "=", 0); }, false);
            document.getElementsByClassName("estimate-table__minus__item")[1].addEventListener("click", function() { updateCart("remove", "=", 1); }, false);
            document.getElementsByClassName("estimate-table__minus__item")[2].addEventListener("click", function() { updateCart("remove", "=", 2); }, false);
            document.getElementsByClassName("estimate-table__minus__item")[3].addEventListener("click", function() { updateCart("remove", "=", 3); }, false);
            document.getElementsByClassName("estimate-table__minus__item")[4].addEventListener("click", function() { updateCart("remove", "=", 4); }, false);
            document.getElementsByClassName("estimate-table__minus__item")[5].addEventListener("click", function() { updateCart("remove", "=", 5); }, false);
            
            document.getElementsByClassName("reset-cart")[0].addEventListener("click", function() { resetCart("resetCart", "="); }, false);
            
            
            
            function updateCart(actionString, operatorString, itemID){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var parser = new DOMParser();
                        var ajaxDocument = parser.parseFromString(this.responseText, "text/html");
                        
                        var product = ajaxDocument.getElementsByClassName("estimate-table__item-quantity")[itemID];
                        var productSubtotal = ajaxDocument.getElementsByClassName("estimate-table__item-subtotal")[itemID];
                        var cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];
                        
                        document.getElementsByClassName("estimate-table__item-quantity")[itemID].innerHTML = product.innerHTML;
                        document.getElementsByClassName("estimate-table__item-subtotal")[itemID].innerHTML = productSubtotal.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;   
                    }
                };
                
                xhttp.open("GET", "products.php?" + actionString + operatorString + itemID, false);
                xhttp.send(); 
            }
            
            function resetCart(actionString, operatorString){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var parser = new DOMParser();
                        var ajaxDocument = parser.parseFromString(this.responseText, "text/html");
                        
                        var products = ajaxDocument.getElementsByClassName("estimate-table__item-quantity");
                        var productSubtotals = ajaxDocument.getElementsByClassName("estimate-table__item-subtotal");
                        var cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];
                        
                        for(let i = 0; i < products.length; i++){
                            document.getElementsByClassName("estimate-table__item-quantity")[i].innerHTML = products[i].innerHTML;
                            document.getElementsByClassName("estimate-table__item-subtotal")[i].innerHTML = productSubtotals[i].innerHTML;
                        }
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;   
                    }
                };
                
                xhttp.open("GET", "products.php?" + actionString + operatorString, false);
                xhttp.send(); 
            }
        </script>
    </body>

</html>
