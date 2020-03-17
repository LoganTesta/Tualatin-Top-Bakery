<?php
declare(strict_types=1);
session_start();

define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');


//Estimate cart code.
include("assets/include/product.php");

$WholeWheatLoaf = new Product("Whole Wheat Loaf", 2.95, "", "");
$WhiteBreadLoaf = new Product("White Bread Loaf", 1.99, "", "");
$BlueberryScone = new Product("Blueberry Scone", 2.25, "", "");
$ChocolateCake = new Product("Chocolate Cake", 15.00, "", "");
$CherryPie = new Product("Cherry Pie", 12.00, "", "");
$BlueberryPie = new Product("Blueberry Pie", 12.00, "", "");
$BlueberryMuffin = new Product("Blueberry Muffin", 2.25, "", "");


$products = array($WholeWheatLoaf, $WhiteBreadLoaf, $BlueberryScone, $ChocolateCake, $CherryPie, $BlueberryPie, $BlueberryMuffin);
$quantities = array();
$itemSubtotal = array();


//Initialize the cart.
if (isset($_SESSION["estimateCart"]) === false) {
    $_SESSION["estimateCart"] = "not empty";
    for ($i = 0; $i < count($products); $i++) {
        $_SESSION["products"][$i] = $products[$i];   //We need to store this for the reset function since that logic is in a separate function.
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["itemSubtotal"][$i] = number_format(0.00, 2);
        $_SESSION["totalCost"] = number_format(0.00, 2);
    }
}

//Set cart value quantity
if (isset($_SESSION["estimateCart"])) {
    if (isset($_GET["item"])) {
        $itemNumber = $_GET["item"];
        if((int)$_GET["setValue"] < 0){
            $_GET["setValue"] = 0;
        } else if((int)$_GET["setValue"] > 100){
            $_GET["setValue"] = 100;
        }
        
        if(isset($_GET["setValue"])){
            $_SESSION["quantity"][$itemNumber] = $_GET["setValue"];
        } else {
            $_SESSION["quantity"][$itemNumber] = $_SESSION["quantity"][$itemNumber] + 1;
        }
        $_SESSION["itemSubtotal"][$itemNumber] = number_format($products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber], 2);
    }

    $_SESSION["totalCost"] = number_format(0.00, 2);
    for ($i = 0; $i < count($products); $i++) {
        $_SESSION["totalCost"] = number_format($_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i], 2);
    }
}


//Remove one item from cart.
if (isset($_SESSION["estimateCart"])) {
    if (isset($_GET["remove"])) {
        $itemNumber = $_GET["remove"];
        $newQuantity = $_SESSION["quantity"][$itemNumber] - 1;

        if ($newQuantity >= 0) {
            $_SESSION["quantity"][$itemNumber] = $newQuantity;
            $_SESSION["itemSubtotal"][$itemNumber] = number_format($products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber], 2);

            $_SESSION["totalCost"] = number_format(0.00, 2);
            for ($i = 0; $i < count($products); $i++) {
                $_SESSION["totalCost"] = number_format($_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i], 2);
            }
        }
    }
}

//Reset cart.
if (isset($_SESSION["estimateCart"])) {
    if (isset($_GET["resetCart"])) {
        resetEstimateCart();
    }
}

function resetEstimateCart() {
    unset($_SESSION["estimateCart"]);
    $_SESSION["totalCost"] = number_format(0.00, 2);
    for ($i = 0; $i < count($_SESSION["products"]); $i++) {
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["itemSubtotal"][$i] = number_format(0.00, 2);
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


        $ValidUserName = true;
        if (Trim($UserName) === "") {
            $ValidUserName = false;
        }
        if ($ValidUserName === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a name.</p>";
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


        $ValidUserPhone = true;
        if (Trim($UserPhone) === "") {
            $ValidUserPhone = false;
        }
        if (strlen($UserPhone) !== 10) {
            $ValidUserPhone = false;
        }
        if (ctype_digit($UserPhone) === false) {
            $ValidUserPhone = false;
        }
        if ($ValidUserPhone === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a 10 digit phone number, no dashes.</p>";
        }


        $ValidUserState = true;
        if (Trim($UserState) === "") {
            $ValidUserState = false;
        }
        if ($ValidUserState === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a state.</p>";
        }


        $ValidUserCity = true;
        if (Trim($UserCity) === "") {
            $ValidUserCity = false;
        }
        if ($ValidUserCity === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a city.</p>";
        }


        $ValidUserZipCode = true;
        if (Trim($UserZipCode) === "") {
            $ValidUserZipCode = false;
        }
        if (strlen($UserZipCode) !== 5) {
            $ValidUserZipCode = false;
        }
        if (ctype_digit($UserZipCode) === false) {
            $ValidUserZipCode = false;
        }
        if ($ValidUserZipCode === false) {
            $PassedValidation = false;
            $transmitResponse .= "<p>ZIP Code must be exactly 5 digits.</p>";
        }


        if ($PassedValidation === false) {
            $transmitResponse .= "<p>Sorry, validation failed.  Please check all fields again.</p>";
        }

        if ($PassedValidation) {
            /* Create the e-mail body. */
            $Body = "";
            $Body .= "User Name: " . $UserName . "\n";
            $Body .= "Email: " . $UserEmail . "\n";
            $Body .= "Phone: " . $UserPhone . "\n";
            $Body .= "Address: " . $UserStreetAddress . "\n";
            $Body .= "" . $UserCity . ", " . $UserState . " " . $UserZipCode . " " . "\n";
            $Body .= "\n";
            $Body .= "Estimate Items: \n";
            for ($i = 0; $i < count($products); $i++) {
                if ($_SESSION["itemSubtotal"][$i] > 0) {
                    $Body .= "" . $products[$i]->get_name() . ": Qty: " . $_SESSION["quantity"][$i] . ", Sub: $" . $_SESSION["itemSubtotal"][$i] . " \n";
                }
            }
            $Body .= "\n";
            $Body .= "Estimate Total: $" . $_SESSION["totalCost"] . ". \n";
            $Body .= "\n";
            $Body .= "Additional Notes: " . $AdditionalNotes . "\n";
            $Body .= "\n";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail($SendEmailTo, "Tualatin Top Bakery: Estimate Order Request for " . $UserName, $Body, "From: <$UserEmail>");

            if ($SuccessfulSubmission) {
                $transmitResponse .= "<p>" . $UserName . ", your estimate request was successfully submitted.</p>";
                $transmitResponse .= "<p>Estimate Items:</p>";
                for ($i = 0; $i < count($products); $i++) {
                    if ($_SESSION["itemSubtotal"][$i] > 0) {
                        $transmitResponse .= "" . $products[$i]->get_name() . ": Qty: " . $_SESSION["quantity"][$i] . ", Sub: $" . $_SESSION["itemSubtotal"][$i] . "<br />";
                    }
                }
                $transmitResponse .= "<p>Estimate Total: $" . $_SESSION["totalCost"] . ".</p>";
                $transmitResponse .= "<p>We will respond back within 2 business days!</p>";
                $transmitResponse .= "<p>Thank you for shopping with Tualatin Top Bakery!</p>";
                resetEstimateCart();
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
        <title>Products | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-products">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(35)->post_title); ?></h2>
                </div>
            </header>
                
            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="inner-wrapper">
                    <div class="content-row">
                        <div class="col-sma-12 products-wrapper">
                            <div class="products-header">
                                <?php
                                $id = 35;
                                $page = get_post($id);
                                $content = "" . apply_filters('the_content', $page->post_content);
                                echo $content;
                                ?>
                            </div>
                            <div class="products content-row">
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container zero">
                                        <div class="product__title"><?php echo $WholeWheatLoaf->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $WholeWheatLoaf->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity0" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][0]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][0] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][0] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p class="no-padding-bottom">Our delicious and wholesome house-made whole wheat 
                                                bread, baked fresh daily.  One of our staples and customer favorites!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container one">
                                        <div class="product__title"><?php echo $WhiteBreadLoaf->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $WhiteBreadLoaf->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity1" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][1]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][1] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][1] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p class="no-padding-bottom">Our delicious and fluffy house-made white bread, baked 
                                                fresh daily.  One of our staples and customer favorites!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container two">
                                        <div class="product__title"><?php echo $BlueberryScone->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $BlueberryScone->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity2" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][2]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][2] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][2] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p class="no-padding-bottom">Light and fluffy and flaky.  We are always trying new 
                                                varieties of scones including some seasonal.  We often have blueberry, vanilla, chocolate scones, 
                                                and many more, so come on in and see what we're baking this week!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container three">
                                        <div class="product__title"><?php echo $ChocolateCake->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $ChocolateCake->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity3" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][3]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][3] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][3] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p class="no-padding-bottom">Our signature crisp, fluffy chocolate cake with a light 
                                                layer of house-made chocolate fudge on top!  Yum!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container four">
                                        <div class="product__title"><?php echo $CherryPie->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $CherryPie->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity4" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][4]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][4] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][4] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p>We sell cherry pie year round at Tualatin Top Bakery!</p>
                                            <p class="no-padding-bottom">In the late spring and summer we
                                                often make it with blueberries from local farmers. Made fresh in house!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container five">
                                        <div class="product__title"><?php echo $BlueberryPie->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $BlueberryPie->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity5" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][5]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][5] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][5] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p>We sell blueberry pie year round at Tualatin Top Bakery!</p>
                                            <p class="no-padding-bottom">In the summer we
                                                often make it with cherries from local farmers. Made fresh in house!</p></div>
                                    </div>
                                </div>
                                <div class="col-vsm-6 col-sma-4 col-lar-3">
                                    <div class="product-container six">
                                        <div class="product__title"><?php echo $BlueberryMuffin->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $BlueberryMuffin->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <div class="product__minus-quantity">-</div>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity" class="sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity6" class="product__set-quantity" name="productSetQuantity" placeholder="" value="<?php echo $_SESSION["quantity"][6]; ?>" />
                                                </div>
                                                <div class="product__increase-quantity">+</div>
                                            </div>
                                            <div class="product__request-item"><div class="product__request-item__add">Add to Cart</div></div>
                                            <div class="product__quantity"><?php
                                                if ($_SESSION["quantity"][6] > 0) {
                                                    echo "<a href='#estimateContainer'>(" . $_SESSION["quantity"][6] . ")</a>";
                                                }
                                                ?>
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description">
                                            <p class="no-padding-bottom">Made with lots of blueberries and a hint of sugar.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-row estimate-section">
                        <div class="col-sma-7">
                            <div class="estimate-cart">
                                <h3 class="estimate-cart__title">Estimate Items</h3>
                                <table class="estimate-table">
                                    <thead>
                                        <tr>
                                            <th class="estimate-table__th-item">Item</th>
                                            <th class="estimate-table__th-photo">Photo</th>
                                            <th class="estimate-table__th-cost">Cost</th>
                                            <th class="estimate-table__th-quantity">Quantity</th>
                                            <th class="estimate-table__th-subtotal">Subtotal</th>
                                            <th class="estimate-table__th-add">Add</th>
                                            <th class="estimate-table__th-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="estimate-table__item-zero <?php if($_SESSION["quantity"][0] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $WholeWheatLoaf->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $WholeWheatLoaf->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][0]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][0]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                            
                                        </tr>
                                        <tr class="estimate-table__item-one <?php if($_SESSION["quantity"][1] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $WhiteBreadLoaf->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $WhiteBreadLoaf->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][1]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][1]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                             
                                        </tr>
                                        <tr class="estimate-table__item-two <?php if($_SESSION["quantity"][2] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $BlueberryScone->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $BlueberryScone->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][2]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][2]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                        </tr>
                                        <tr class="estimate-table__item-three <?php if($_SESSION["quantity"][3] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $ChocolateCake->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $ChocolateCake->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][3]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][3]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                        </tr>
                                        <tr class="estimate-table__item-four <?php if($_SESSION["quantity"][4] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $CherryPie->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $CherryPie->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][4]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][4]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                            
                                        </tr>
                                        <tr class="estimate-table__item-five <?php if($_SESSION["quantity"][5] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $BlueberryPie->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $BlueberryPie->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][5]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][5]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                            
                                        </tr>
                                        <tr class="estimate-table__item-six <?php if($_SESSION["quantity"][6] <= 0){ echo "hide"; } ?>">
                                            <td class="estimate-table__item-title"><?php echo $BlueberryMuffin->get_name(); ?></td>
                                            <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                            <td class="estimate-table__item-cost">$<?php echo $BlueberryMuffin->get_price(); ?></td>
                                            <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][6]; ?></td>
                                            <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][6]; ?></td>
                                            <td class="estimate-table__add"><div class="estimate-table__add__item">+</div></td>
                                            <td class="estimate-table__minus"><div class="estimate-table__minus__item">-</div></td>                               
                                        </tr>
                                        <tr class="clear-both"></div>
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
                        <div class="col-sma-5">
                            <div class="estimate-container" id="estimateContainer">
                                <h3 class="estimate-container__title">Request Estimate</h3>
                                <form class="contact-container__form" id="estimateForm" v-on:submit="validateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                                        <input id="userZipCode" name="userZipCode" type="text" placeholder="ZIP Code" required="required" v-model="userZipCode" />  
                                    </div>
                                    <div class="input-container">
                                        <label class="input-container__label" for="additionalNotes"><strong>Additional Notes</strong></label>
                                        <textarea id="additionalNotes" name="additionalNotes" rows="8" placeholder="Please write any additional order notes here."></textarea>                          
                                    </div>                           
                                    <div class="input-container">
                                        <button class="input-container__contact-button" id="estimateButton" name="estimateButton" type="submit" v-on:click="setClickedSubmitTrue">Request Estimate!</button>                          
                                    </div>
                                </form>
                                <?php
                                if (!empty($transmitResponse)) {
                                    echo "<div class=\"contact-container__response-message\">$transmitResponse</div>";
                                }
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
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(2);
                });
            </script>
        </div>
        <script type="text/javascript">
            let numberOfProducts = 7;

            //Use AJAX to update the cart without reloading the page.
            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("product__request-item__add")[i].addEventListener("click", function () {
                    let quantityToSet = document.getElementsByClassName("product__set-quantity")[i].value;
                    setCart("item", "=", i, quantityToSet);
                }, false);
            }
            
            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function (event) {           
                    event.preventDefault();
                    document.getElementsByClassName("product__minus-quantity")[i].classList.remove("change-color");
                    void document.getElementsByClassName("product__minus-quantity")[i].offsetWidth;
                    document.getElementsByClassName("product__minus-quantity")[i].classList.add("change-color");
                 }, false);
                document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function (event) {           
                    event.preventDefault();
                    document.getElementsByClassName("product__increase-quantity")[i].classList.remove("change-color");
                    void document.getElementsByClassName("product__increase-quantity")[i].offsetWidth;
                    document.getElementsByClassName("product__increase-quantity")[i].classList.add("change-color");
                 }, false);
            }

            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function () {
                    adjustProductSetQuantity(i, "decrease");
                }, false); 
            }
            
            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function () {
                    adjustProductSetQuantity(i, "increase");
                }, false); 
            }
            
            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("estimate-table__add__item")[i].addEventListener("click", function () {
                   updateCart("item", "=", i);
                }, false);
            }
            
            for(let i=0; i<numberOfProducts; i++){
                document.getElementsByClassName("estimate-table__minus__item")[i].addEventListener("click", function () {        
                    updateCart("remove", "=", i);
                }, false);
            }

            document.getElementsByClassName("reset-cart")[0].addEventListener("click", function () {
                resetCart("resetCart", "=");
            }, false);
            
            
            function adjustProductSetQuantity(itemNumber, change) {
                if(change === "decrease"){
                    document.getElementsByClassName("product__set-quantity")[itemNumber].value --;
                } else if (change === "increase"){
                    document.getElementsByClassName("product__set-quantity")[itemNumber].value ++;     
                }     
            }

            function setCart(actionString, operatorString, itemID, setValue) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var parser = new DOMParser();
                        var ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                        var product = ajaxDocument.getElementsByClassName("estimate-table__item-quantity")[itemID];
                        var estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        var cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];

                        document.getElementsByClassName("product__quantity")[itemID].innerHTML = "<a href='#estimateContainer'>(" + product.innerHTML + ")</a>";
                        
                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };
                setValue = parseInt(setValue);
                if(setValue < 0){
                    setValue = 0;
                } else if(setValue > 100){
                    setValue = 100;
                }
                xhttp.open("GET", "products.php?" + actionString + operatorString + itemID + "&setValue=" + setValue, true);
                xhttp.send();
            }

            function updateCart(actionString, operatorString, itemID) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var parser = new DOMParser();
                        var ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                        var product = ajaxDocument.getElementsByClassName("estimate-table__item-quantity")[itemID];
                        var estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        var cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];

                        document.getElementsByClassName("product__quantity")[itemID].innerHTML = "<a href='#estimateContainer'>(" + product.innerHTML + ")</a>";

                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };

                xhttp.open("GET", "products.php?" + actionString + operatorString + itemID, true);
                xhttp.send();
            }

            function resetCart(actionString, operatorString) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var parser = new DOMParser();
                        var ajaxDocument = parser.parseFromString(this.responseText, "text/html");
                        
                        var products = ajaxDocument.getElementsByClassName("estimate-table__item-quantity");

                        var estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        var cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];

                        for (let i = 0; i < products.length; i++) {
                            document.getElementsByClassName("product__quantity")[i].innerHTML = "";  
                        }
                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };

                xhttp.open("GET", "products.php?" + actionString + operatorString, true);
                xhttp.send();
            }
            
            function reAddEventListeners () {
                for(let i=0; i<numberOfProducts; i++){
                    document.getElementsByClassName("estimate-table__add__item")[i].addEventListener("click", function () {
                       updateCart("item", "=", i);
                    }, false);
                }

                for(let i=0; i<numberOfProducts; i++){
                    document.getElementsByClassName("estimate-table__minus__item")[i].addEventListener("click", function () {        
                        updateCart("remove", "=", i);
                    }, false);
                }
            }
        </script>
    </body>

</html>
