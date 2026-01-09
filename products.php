<?php
declare( strict_types = 1 );
session_start();
define( 'WP_USE_THEMES', false );
require( './wordpress/wp-load.php' );


//Estimate cart code.
include( "assets/include/product.php" );

$WholeWheatLoaf = new Product("Whole Wheat Loaf", "zero", "0", "", 2.95, "breads", "", "<p>Our delicious and wholesome house-made whole wheat bread, baked fresh daily.  "
        . "One of our staples and customer favorites!</p>");
$WhiteBreadLoaf = new Product("White Bread Loaf", "one", "1", "", 1.99, "breads", "", "<p>Our delicious and fluffy house-made white bread, baked fresh daily.  One of our "
        . "staples and customer favorites!</p>");
$BlueberryScone = new Product("Blueberry Scone", "two", "2", "", 2.25, "pastries", "", "<p>Light and fluffy and flaky.  We are always trying new varieties of scones including "
        . "some seasonal.  We often have blueberry, vanilla, chocolate scones, and many more, so come on in and see what we're baking this week!</p>");
$ChocolateCake = new Product("Chocolate Cake", "three", "3", "", 15.00, "cakes", "", "<p>Our signature crisp, fluffy chocolate cake with a light layer of house-made "
        . "chocolate fudge on top!  Yum!</p>");
$CherryPie = new Product("Cherry Pie", "four", "4", "", 12.00, "pies", "", "<p>We sell cherry pie year round at Tualatin Top Bakery!</p><p>In the late spring and summer we "
        . "often make it with cherries from local farmers. Made fresh in house!</p>");
$BlueberryPie = new Product("Blueberry Pie", "five", "5", "", 12.00, "pies", "", "<p>We sell blueberry pie year round at Tualatin Top Bakery!</p><p>In the summer we often "
        . "make it with blueberries from local farmers. Made fresh in house!</p>");
$BlueberryMuffin = new Product("Blueberry Muffin", "six", "6", "", 2.25, "muffins", "", "Made with lots of blueberries and a hint of sugar.");
$ChocolateCupcake = new Product("Chocolate Cupcake", "seven", "7","", 2.50, "cakes", "", "Want a personal size cake (or two?) Pick up one of our delicious choclate cupcakes, with "
        . "a touch of powder on top!");
$RyeBread = new Product("Rye Bread", "eight", "8", "", 2.95, "breads", "", "Hearty rye bread rich with flavor, baked fresh daily.");


$products = array( $WholeWheatLoaf, $WhiteBreadLoaf, $BlueberryScone, $ChocolateCake, $CherryPie, $BlueberryPie, $BlueberryMuffin, $ChocolateCupcake, $RyeBread );
$itemSubtotal = array();


$_SESSION["products"] = array();
array_push( $_SESSION["products"], $WholeWheatLoaf );
array_push( $_SESSION["products"], $WhiteBreadLoaf );
array_push( $_SESSION["products"], $BlueberryScone );
array_push( $_SESSION["products"], $ChocolateCake );
array_push( $_SESSION["products"], $CherryPie );
array_push( $_SESSION["products"], $BlueberryPie );
array_push( $_SESSION["products"], $BlueberryMuffin );
array_push( $_SESSION["products"], $ChocolateCupcake );
array_push( $_SESSION["products"], $RyeBread );


//Initialize the cart.
if ( isset( $_SESSION["estimateCart"] ) === false) {
    $_SESSION["estimateCart"] = "not empty";
    for ( $i = 0; $i < count( $products ); $i++ ) {
        $_SESSION["products"][$i] = $products[$i];   //We need to store this for the reset function since that logic is in a separate function.
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["itemSubtotal"][$i] = number_format( 0.00, 2 );
        $_SESSION["numberOfItems"] = 0;
        $_SESSION["totalCost"] = number_format( 0.00, 2 );
    }
}




//Product searching.
$productSearchText = "";
$emptyForm = false;

$_SESSION["searchByCategory"] = strtolower( "" . $_GET['searchByCategory'] );
$_SESSION["orderByOptions"] = "" . $_GET['orderByOptions'];


if ( $_SESSION["searchByCategory"] === "" && $_SESSION["orderByOptions"] === "" ) {
    $emptyForm = true;
}

$searchedForProducts = array();
if ( $_SESSION["searchByCategory"] !== "" && $_SESSION["searchByCategory"] !== null ) {
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        array_push( $searchedForProducts, $_SESSION["products"][$i] );
        $productCount = count( $_SESSION["products"] );
        if ( $_SESSION["products"][$i]->get_category() === $_SESSION["searchByCategory"] ) {
            $_SESSION["products"][$i]->set_displayCSS( "" );
        } else {
            $_SESSION["products"][$i]->set_displayCSS( "hide" );
        }
    }
} else {
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        $_SESSION["products"][$i]->set_displayCSS( "" );
    }
}


if ( $_GET["orderByOptions"] === "Name (Alphabetical)" ) {
    usort( $_SESSION["products"], "compare_names" );
} else if ( $_GET["orderByOptions"] === "Name (Reverse Alphabetical)" ) {
    usort( $_SESSION["products"], "compare_names_reverse" );
} else if ( $_GET["orderByOptions"] === "Price (Ascending)" ) {
    usort( $_SESSION["products"], "compare_prices" );
} else if ( $_GET["orderByOptions"] === "Price (Descending)" ) {
    usort( $_SESSION["products"], "compare_prices_reverse" );
} else {
    $_SESSION["orderByOptions"] = "";
}

reorderProdQuantities();

//Loop through the products, set the class order equal to the products new order.  Then set the product quantity for the product cards equal to the new order.
function reorderProdQuantities(){
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        $_SESSION["classOrder"][$i] = $_SESSION["products"][$i]->get_classInt(); 
    }
    
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        $_SESSION["prodQuantity"][$i] = $_SESSION["quantity"][$_SESSION["classOrder"][$i]];
    }
}


if ( $emptyForm ) {
    $productSearchText = "Showing all products.";
} else {
    $categoryProductText = "";
    $orderByText = "";
    if ( $_SESSION["searchByCategory"] === "" ) {
        $categoryProductText = " all products";
    } else {
        $categoryProductText = $_SESSION["searchByCategory"];
    }

    if ( $_SESSION["orderByOptions"] === "" ) {
        $orderByText = "";
    } else {
        $orderByText = " ordered by " . $_SESSION["orderByOptions"];
    }
    $productSearchText = "Showing " . $categoryProductText . $orderByText . ".";
}

function compare_names( $a, $b ){
    return strcmp( $a->name, $b->name );
}

function compare_names_reverse( $b, $a ){
    return strcmp( $a->name, $b->name );
}

function compare_prices( $a, $b ){
    return strnatcmp( $a->price, strval( $b->price ) );
}

function compare_prices_reverse( $b, $a ){
    return strnatcmp( $a->price, strval( $b->price ) );
}
//End of product searching



//Set cart value quantity
if ( isset( $_SESSION["estimateCart"] ) ) {
    $_SESSION["numberOfItems"] = 0;
    if ( isset( $_GET["item"] ) ) {
        $itemNumber = $_GET["item"];    
        if ( isset( $_GET["setValue"] ) ){
            $_SESSION["quantity"][$itemNumber] = $_GET["setValue"];
        } else {
            $_SESSION["quantity"][$itemNumber] = $_SESSION["quantity"][$itemNumber] + 1;
        }
        
        if ( $_SESSION["quantity"][$itemNumber] < 0 ) {
            $_SESSION["quantity"][$itemNumber] = 0;
        }
        if ( $_SESSION["quantity"][$itemNumber] > 100) {
            $_SESSION["quantity"][$itemNumber] = 100;
        }
           
        $_SESSION["itemSubtotal"][$itemNumber] = number_format( $products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber], 2 );
    }

    //After setting the quantities array, then set the quantities for the shown products.
    $_SESSION["shownProductsQuantity"] = array();
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        if ( $_SESSION["orderByOptions"] === "" ) {
            if ( intval( $_SESSION["products"][$i]->get_classInt() ) === $i ) {
                $_SESSION["shownProductsQuantity"][$i] = $_SESSION["quantity"][$i];
            } else {
                $_SESSION["shownProductsQuantity"][$i] = 0;
            }
        } else {
            $_SESSION["shownProductsQuantity"][$i] = $_SESSION["quantity"][$_SESSION["products"][$i]->get_classInt()];
        }
    }


    $_SESSION["totalCost"] = number_format( 0.00, 2 );
    for ( $i = 0; $i < count($products); $i++ ) {
        $_SESSION["numberOfItems"] = $_SESSION["numberOfItems"] + $_SESSION["quantity"][$i];
        $_SESSION["totalCost"] = number_format( $_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i], 2 );
    }
}


//Remove one item from cart.
if ( isset( $_SESSION["estimateCart"] ) ) {
    if ( isset( $_GET["remove"] ) ) {
        $_SESSION["numberOfItems"] = 0;
           
        $itemNumber = $_GET["remove"];
        $newQuantity = $_SESSION["quantity"][$itemNumber] - 1;

        if ( $newQuantity >= 0 ) {
            $_SESSION["quantity"][$itemNumber] = $newQuantity;
            $_SESSION["itemSubtotal"][$itemNumber] = number_format( $products[$itemNumber]->get_price() * $_SESSION["quantity"][$itemNumber], 2 );

            $_SESSION["totalCost"] = number_format( 0.00, 2 );
            for ( $i = 0; $i < count( $products ); $i++ ) {
                $_SESSION["numberOfItems"] = $_SESSION["numberOfItems"] + $_SESSION["quantity"][$i];
                $_SESSION["totalCost"] = number_format( $_SESSION["totalCost"] + $_SESSION["itemSubtotal"][$i], 2 );
            }
        }
    }
}

//Reset cart.
if ( isset( $_SESSION["estimateCart"] ) ) {
    if ( isset( $_GET["resetCart"] ) ) {
        resetEstimateCart();
    }
}

function resetEstimateCart() {
    unset( $_SESSION["estimateCart"] );
    $_SESSION["numberOfItems"] = 0;
    $_SESSION["totalCost"] = number_format( 0.00, 2 );
    for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
        $_SESSION["quantity"][$i] = 0;
        $_SESSION["shownProductsQuantity"] = 0;
        $_SESSION["itemSubtotal"][$i] = number_format( 0.00, 2 );
    }
}

//Process the estimate request and validate the user input.
$transmitResponse = "";

if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
    if ( isset( $_POST['userName'] ) && isset( $_POST['userEmail'] ) && isset( $_POST['userPhone'] ) && isset( $_POST['userStreetAddress'] ) &&
            isset( $_POST['userCity'] ) && isset( $_POST['userState'] ) && isset( $_POST['userZipCode'] ) ) {
        if ( isset( $_POST['userName'] ) ) {
            $UserName = htmlspecialchars( strip_tags( trim( $_POST['userName'] ) ) );
        }
        if ( isset( $_POST['userEmail'] ) ) {
            $UserEmail = htmlspecialchars( strip_tags( trim( $_POST['userEmail'] ) ) );
        }
        if ( isset( $_POST['userPhone'] ) ) {
            $UserPhone = htmlspecialchars( strip_tags( trim( $_POST['userPhone'] ) ) );
        }
        if ( isset( $_POST['userStreetAddress'] ) ) {
            $UserStreetAddress = htmlspecialchars( strip_tags( trim( $_POST['userStreetAddress'] ) ) );
        }
        if ( isset( $_POST['userCity'] ) ) {
            $UserCity = htmlspecialchars( strip_tags( trim( $_POST['userCity'] ) ) );
        }
        if ( isset( $_POST['userState'] ) ) {
            $UserState = htmlspecialchars( strip_tags( trim( $_POST['userState'] ) ) );
        }
        if ( isset( $_POST['userZipCode'] ) ) {
            $UserZipCode = htmlspecialchars( strip_tags( trim( $_POST['userZipCode'] ) ) );
        }
        if ( isset( $_POST['additionalNotes'] ) ) {
            $AdditionalNotes = htmlspecialchars( strip_tags( trim( $_POST['additionalNotes'] ) ) );
        }
        $SendEmailTo = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;


        $ValidUserName = true;
        if ( Trim( $UserName ) === "" ) {
            $ValidUserName = false;
        }
        if ( $ValidUserName === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a name.</p>";
        }


        $ValidUserEmail = true;
        if ( Trim( $UserEmail ) === "" ) {
            $ValidUserEmail = false;
        }
        /* More advanced e-mail validation */
        if ( ! filter_var( $UserEmail, FILTER_VALIDATE_EMAIL ) ) {
            $ValidUserEmail = false;
        }
        if ( $ValidUserEmail === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a valid email.</p>";
        }


        $ValidUserPhone = true;
        if ( Trim( $UserPhone ) === "" ) {
            $ValidUserPhone = false;
        }
        if ( strlen( $UserPhone ) !== 10 ) {
            $ValidUserPhone = false;
        }
        if ( ctype_digit( $UserPhone ) === false ) {
            $ValidUserPhone = false;
        }
        if ( $ValidUserPhone === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a 10 digit phone number, no dashes.</p>";
        }


        $ValidUserState = true;
        if ( Trim( $UserState ) === "" ) {
            $ValidUserState = false;
        }
        if ( $ValidUserState === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a state.</p>";
        }


        $ValidUserCity = true;
        if ( Trim( $UserCity ) === "" ) {
            $ValidUserCity = false;
        }
        if ( $ValidUserCity === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>Please enter a city.</p>";
        }


        $ValidUserZipCode = true;
        if ( Trim( $UserZipCode ) === "" ) {
            $ValidUserZipCode = false;
        }
        if ( strlen( $UserZipCode ) !== 5 ) {
            $ValidUserZipCode = false;
        }
        if ( ctype_digit( $UserZipCode ) === false ) {
            $ValidUserZipCode = false;
        }
        if ( $ValidUserZipCode === false ) {
            $PassedValidation = false;
            $transmitResponse .= "<p>ZIP Code must be exactly 5 digits.</p>";
        }


        if ( $PassedValidation === false ) {
            $transmitResponse .= "<p>Sorry, validation failed.  Please check all fields again.</p>";
        }

        if ( $PassedValidation ) {
            /* Set the headers */
            $Headers = "";
            $Headers .= "From: <$UserEmail>\r\n";
            $Headers .= "MIME-Version: 1.0\r\n";
            $Headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            /* Create the e-mail body. */
            $Body = "";
            $Body .= "<strong>User Name:</strong> " . $UserName . "<br />";
            $Body .= "<strong>Email:</strong> " . $UserEmail . "<br />";
            $Body .= "<strong>Phone:</strong> " . $UserPhone . "<br />";
            $Body .= "<strong>Address:</strong> " . $UserStreetAddress . "<br />";
            $Body .= "" . $UserCity . ", " . $UserState . " " . $UserZipCode . " " . "<br />";
            $Body .= "<br />";
            $Body .= "<strong>Estimate Items:</strong><br />";
            for ( $i = 0; $i < count( $products ); $i++ ) {
                if ( $_SESSION["itemSubtotal"][$i] > 0 ) {
                    $Body .= "" . $products[$i]->get_name() . ": Qty: " . $_SESSION["quantity"][$i] . ", Sub: $" . $_SESSION["itemSubtotal"][$i] . "<br />";
                }
            }
            $Body .= "<br />";
            $Body .= "<strong>Estimate Total:</strong> $" . $_SESSION["totalCost"] . ".<br />";
            $Body .= "<br />";
            $Body .= "<strong>Additional Notes:</strong> " . $AdditionalNotes . "<br />";
            $Body .= "<br />";

            /* Send the e-mail. */
            $SuccessfulSubmission = mail( $SendEmailTo, "Tualatin Top Bakery: Estimate Order Request for " . $UserName, $Body, $Headers );

            if ( $SuccessfulSubmission ) {
                $transmitResponse .= "<p>" . $UserName . ", your estimate request was successfully submitted.</p>";
                $transmitResponse .= "<p>Estimate Items:</p>";
                for ( $i = 0; $i < count( $products ); $i++ ) {
                    if ( $_SESSION["itemSubtotal"][$i] > 0 ) {
                        $transmitResponse .= "" . $products[$i]->get_name() . ": Qty: " . $_SESSION["quantity"][$i] . ", Sub: $" . $_SESSION["itemSubtotal"][$i] . "<br />";
                    }
                }
                $transmitResponse .= "<p>Estimate Total: $" . $_SESSION["totalCost"] . ".</p>";
                $transmitResponse .= "<p>We will respond back within 2 business days!</p>";
                $transmitResponse .= "<p>Thank you for shopping with Tualatin Top Bakery!</p>";
                resetEstimateCart();
            } else if ( $SuccessfulSubmission === false ) {
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
        <meta name="description" content="Delicious baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
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
                    <h2 class="header__subtitle"><?php echo apply_filters( '<p>', get_post( 35 )->post_title ); ?></h2>
                    <div class="shopping-cart">
                        <div class="shopping-cart__image <?php if ( $_SESSION['numberOfItems'] > 0 ) { echo 'show'; } ?>">
                            <a class="shopping-cart__link" href="#estimateCartTitle">
                                <div class="shopping-cart__number-of-items"><?php echo $_SESSION["numberOfItems"]; ?></div>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
                
            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="inner-wrapper">
                <div class="content">
                    <div class="content-row">
                        <div class="col-lar-6">
                            <?php
                            $id = 35;
                            $page = get_post( $id );
                            $content = "" . apply_filters( 'the_content', $page->post_content );
                            echo $content;
                            ?>
                        </div>
                        <div class="col-lar-6">
                            <div class="product-search">
                                <div class="product-search__inputs">
                                    <h4 class="product-search__title">Search for Products</h4>
                                    <div class="input-container product-search-container">
                                        <label class="input-container__label" for="searchByCategory"><strong>Category</strong></label>
                                        <select class="product-search__select" id="searchByCategory" name="searchByCategory">
                                            <option value=""></option>                        
                                            <option value="Breads" <?php if ( $_SESSION["searchByCategory"] === "breads" ){ echo "selected='selected'"; } ?> >Breads</option>
                                            <option value="Pastries" <?php if ( $_SESSION["searchByCategory"] === "pastries" ){ echo "selected='selected'"; } ?> >Pastries</option>                                    
                                            <option value="Muffins" <?php if ( $_SESSION["searchByCategory"] === "muffins" ){ echo "selected='selected'"; } ?> >Muffins</option>
                                            <option value="Cakes" <?php if ( $_SESSION["searchByCategory"] === "cakes" ){ echo "selected='selected'"; } ?> >Cakes</option>
                                            <option value="Pies" <?php if ( $_SESSION["searchByCategory"] === "pies" ){ echo "selected='selected'"; } ?> >Pies</option>
                                            <option value="Other" <?php if ( $_SESSION["searchByCategory"] === "other" ){ echo "selected='selected'"; } ?> >Other</option>
                                        </select>
                                    </div>
                                    <div class="input-container product-search-container">
                                        <label class="input-container__label" for="orderByOptions"><strong>Order By</strong></label>
                                        <select class="product-search__select" id="orderByOptions" name="orderByOptions">
                                            <option value=""></option>                        
                                            <option value="Name (Alphabetical)" <?php if ( $_SESSION["orderByOptions"] === "Name (Alphabetical)" ){ echo "selected='selected'"; } ?> >Name (Alphabetical)</option>
                                            <option value="Name (Reverse Alphabetical)" <?php if ( $_SESSION["orderByOptions"] === "Name (Reverse Alphabetical)" ){ echo "selected='selected'"; } ?> >Name (Reverse Alphabetical)</option>                                    
                                            <option value="Price (Ascending)" <?php if ( $_SESSION["orderByOptions"] === "Price (Ascending)" ){ echo "selected='selected'"; } ?> >Price (Ascending)</option>
                                            <option value="Price (Descending)" <?php if ( $_SESSION["orderByOptions"] === "Price (Descending)" ){ echo "selected='selected'"; } ?> >Price (Descending)</option>
                                        </select>
                                    </div>
                                    <div class="input-container product-search-container">
                                        <button class="input-container__contact-button" id="searchButton" name="searchButton">Search</button>                          
                                    </div>
                                </div>
                                <div class="product-search__text">
                                    <?php echo $productSearchText; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-row product-quantities">
                        <div class="col-sma-12">
                            <?php for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) { ?>
                                <div class="product-quantities-hidden"><?php echo $_SESSION["shownProductsQuantity"][$i]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="content-row products">
                        <?php
                        for ( $i = 0; $i < count( $_SESSION["products"] ); $i++ ) {
                            if ( $_SESSION["products"][$i]->get_displayCSS() === "hide" ) {              
                            } else {
                                ?>
                                <div class="col-vsm-6 col-sma-4 col-lar-3 product-outer">
                                    <div class="product-container <?php echo $_SESSION["products"][$i]->get_classCSS(); ?> <?php echo $_SESSION["products"][$i]->get_classInt(); ?> <?php echo $_SESSION["products"][$i]->get_displayCSS(); ?>">
                                        <div class="product__title"><?php echo $_SESSION["products"][$i]->get_name(); ?></div>
                                        <div class="product__background-container">
                                            <div class="product__background"></div>
                                        </div>
                                        <div class="product__price-and-request">
                                            <div class="product__price">$<?php echo $_SESSION["products"][$i]->get_price(); ?></div>   
                                            <div class="product__adjust-quantity">
                                                <button class="product__minus-quantity">-</button>
                                                <div class="product__quantity-input">
                                                    <label for="productSetQuantity<?php echo $i; ?>" class="hidden-sr-only">Product Set Quantity</label>
                                                    <input type="number" min="0" max="100" id="productSetQuantity<?php echo $i; ?>" class="product__set-quantity" name="productSetQuantity<?php echo $i; ?>" placeholder="" value="<?php echo $_SESSION["shownProductsQuantity"][$i]; ?>" />
                                                </div>
                                                <button class="product__increase-quantity">+</button>
                                            </div>
                                            <div class="product__request-item">
                                                <button class="product__request-item__add">Add to Cart</button>
                                            </div>
                                            <div class="product__quantity-container <?php if ( $_SESSION["shownProductsQuantity"][$i] > 0 ) { echo 'show'; }?>">
                                                <a href='#estimateCartTitle' class='product__quantity'><?php echo "" . $_SESSION["shownProductsQuantity"][$i] . "</a>" ?>                                                
                                            </div>
                                            <div class="clear-both"></div>
                                        </div>
                                        <div class="product__description"><?php echo $_SESSION["products"][$i]->get_description(); ?></div>
                                    </div>
                                </div> 
                        <?php } ?>
                    <?php } ?>
                    </div>
                    <div class="content-row estimate-section">
                        <div class="col-sma-7">
                            <div class="estimate-cart">
                                <h3 id="estimateCartTitle" class="estimate-cart__title">Estimate Items</h3>
                                <table class="estimate-table">
                                    <thead>
                                        <tr>
                                            <th class="estimate-table__th-item">Item</th>
                                            <th class="estimate-table__th-photo">Photo</th>
                                            <th class="estimate-table__th-cost">Cost</th>
                                            <th class="estimate-table__th-quantity">Quantity</th>
                                            <th class="estimate-table__th-subtotal">Subtotal</th>
                                            <th class="estimate-table__th-remove">Remove</th>
                                            <th class="estimate-table__th-add">Add</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ( $i = 0; $i < count( $products ); $i++ ) { ?>
                                            <tr class="estimate-table__item <?php echo $products[$i]->get_classCSS(); ?> <?php if ( $_SESSION["quantity"][$i] <= 0 ){ echo "hide"; } ?>">
                                                <td class="estimate-table__item-title"><?php echo $products[$i]->get_name(); ?></td>
                                                <td class="estimate-table__item-image"><div class="estimate-table__item-image__photo"></div></td>
                                                <td class="estimate-table__item-cost">$<?php echo $products[$i]->get_price(); ?></td>
                                                <td class="estimate-table__item-quantity"><?php echo $_SESSION["quantity"][$i]; ?></td>
                                                <td class="estimate-table__item-subtotal">$<?php echo $_SESSION["itemSubtotal"][$i]; ?></td>
                                                <td class="estimate-table__minus"><button class="estimate-table__minus__item">-</button></td>  
                                                <td class="estimate-table__add"><button class="estimate-table__add__item">+</button></td>                       
                                            </tr>
                                        <?php } ?>
                                        <tr class="clear-both"></div>
                                    </tbody>
                                </table>
                                <div class="content-row estimate-table__cart-summary">
                                    <div class="col-sma-6">
                                        <div class="cart-total">Today's Total: $<?php echo $_SESSION["totalCost"]; ?></div>
                                    </div>
                                    <div class="col-sma-6">
                                        <button class="reset-cart">Empty Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sma-5">
                            <div class="estimate-container" id="estimateContainer">
                                <h3 class="estimate-container__title">Request Estimate</h3>
                                <form class="contact-container__form" id="estimateForm" v-on:submit="validateForm" method="post" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] ); ?>">
                                    <div class="contact-container__response">
                                        <p>We appreciate your business <strong>{{writeResponse}}</strong> at Tualatin Top Bakery! 
                                            We will look over your estimate, and respond 
                                            back within 2 business days with a quote including shipping costs.  We ship anywhere in the continental U.S.</p>
                                        <p>&nbsp;</p>
                                        <h4>Note: this is a fictional business site for a portfolio. Thanks!</h4>
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
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(3);
                });
            </script>
        </div>
        <script type="text/javascript">
            // Use AJAX to update part of the page without reloading the whole page.
            let numberOfProducts = document.getElementsByClassName("product-container").length;
            
            //Add event listeners.         
            //Header, search event listeners.        
            document.getElementById("searchButton").addEventListener("click", function () {
                let searchByCategory = "" + document.getElementById("searchByCategory").value;
                let orderByOptions = "" + document.getElementById("orderByOptions").value;
                updateProductsShown("searchByCategory=" + searchByCategory, "orderByOptions=" + orderByOptions);
            }, false);
            
            
            //Product item event listeners.
            for(let i = 0; i < numberOfProducts; i++){ 
                document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function (event) {           
                    event.preventDefault();
                    document.getElementsByClassName("product__minus-quantity")[i].classList.remove("change-color");
                    void document.getElementsByClassName("product__minus-quantity")[i].offsetWidth;
                    document.getElementsByClassName("product__minus-quantity")[i].classList.add("change-color");
                }, false);
                 
                 document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function () {
                    adjustProductSetQuantity(i, "decrease");
                }, false); 
                 
                document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function (event) {           
                    event.preventDefault();
                    document.getElementsByClassName("product__increase-quantity")[i].classList.remove("change-color");
                    void document.getElementsByClassName("product__increase-quantity")[i].offsetWidth;
                    document.getElementsByClassName("product__increase-quantity")[i].classList.add("change-color");
                 }, false);

                document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function () {
                    adjustProductSetQuantity(i, "increase");
                }, false); 
                
                document.getElementsByClassName("product__request-item__add")[i].addEventListener("click", function () {
                    let itemNumber = document.getElementsByClassName("product-container")[i].classList.item(2);
                    let quantityToSet = document.getElementsByClassName("product__set-quantity")[i].value;
                    quantityToSet = checkQuantityMinAndMax(quantityToSet);
                    setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);
                }, false);
            }
            
            
            //Estimate cart event listeners.
            for(let i = 0; i < numberOfProducts; i++){    
                document.getElementsByClassName("estimate-table__minus__item")[i].addEventListener("click", function () {     
                    let itemNumber = i;
                    let quantityToSet = document.getElementsByClassName("estimate-table__item-quantity")[i].innerHTML;
                    quantityToSet = checkQuantityMinAndMax(quantityToSet) - 1;
                    setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);
                }, false);

                document.getElementsByClassName("estimate-table__add__item")[i].addEventListener("click", function () {  
                    let itemNumber = i;
                    let quantityToSet = document.getElementsByClassName("estimate-table__item-quantity")[i].innerHTML;
                    quantityToSet = checkQuantityMinAndMax(quantityToSet) + 1;
                    setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);    
                }, false);
            }
            
            
            //Reset cart listener.
            document.getElementsByClassName("reset-cart")[0].addEventListener("click", function () {
                resetCart("resetCart", "=");
            }, false);
            
            
            //Estimate form listener.
            document.getElementById("estimateForm").addEventListener("submit", function (event) {
                updateServerResponse(event); 
            }, false);
            
            
            
            //General functions.
            function adjustProductSetQuantity(itemNumber, change) {
                if(change === "decrease"){
                    document.getElementsByClassName("product__set-quantity")[itemNumber].value --;
                } else if (change === "increase"){
                    document.getElementsByClassName("product__set-quantity")[itemNumber].value ++;     
                }     
            }
            
            function checkQuantityMinAndMax(setValue) {
                setValue = parseInt(setValue);
                if (setValue < 0){
                    setValue = 0;
                } else if(setValue > 100){
                    setValue = 100;
                }
                return setValue;
            }
            
            function updateServerResponse(event) {
                event.preventDefault();
                let xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function () { 
                    if (this.readyState === 4 && this.status === 200) {
                        let parser = new DOMParser();
                        let ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                        //Update form message
                        let message = ajaxDocument.getElementsByClassName("contact-container__response-message")[0];    

                        document.getElementsByClassName("contact-container__response-message")[0].innerHTML = "" + message.innerHTML + "";    
                        document.getElementsByClassName("contact-container__response-message")[0].classList.add("show");
                        
                        
                        //Update products, cart icon, estimate cart.
                        let estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        let numberOfItems = ajaxDocument.getElementsByClassName("shopping-cart")[0];
                        let cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];


                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("shopping-cart")[0].innerHTML = numberOfItems.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        
                        //Update the product quantities.
                        let numberOfProductsShown = document.getElementsByClassName("product-container").length; //Get the number of products shown to the user.           
                        let productQuantitiesHiddenArray = Array();
                        for(let i = 0; i < numberOfProducts; i++){                              
                            let productQuantitiesHidden = ajaxDocument.getElementsByClassName("product-quantities-hidden")[i];
                            document.getElementsByClassName("product-quantities-hidden")[i].innerHTML = productQuantitiesHidden.innerHTML;
                            productQuantitiesHiddenArray[i] = productQuantitiesHidden.innerHTML;
                        }
                        for(let i = 0; i < numberOfProductsShown; i++){
                            let product = ajaxDocument.getElementsByClassName("product__quantity-container")[i].innerHTML;
                            
                            let productClass = document.getElementsByClassName("product-container")[i].classList.item(2);
                            let productCount = productQuantitiesHiddenArray[productClass];

                            if (productCount > 0) {
                                document.getElementsByClassName("product__quantity-container")[i].innerHTML = "<a href='#estimateCartTitle' class='product__quantity'>" + productCount + "</a>";
                                document.getElementsByClassName("product__quantity-container")[i].classList.add("show");
                            } else {
                                document.getElementsByClassName("product__quantity-container")[i].innerHTML = "";
                                document.getElementsByClassName("product__quantity-container")[i].classList.remove("show");
                            }
                        } 
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };

                let userName = document.getElementById("userName").value;  
                let userEmail = document.getElementById("userEmail").value;  
                let userPhone = document.getElementById("userPhone").value;    
                let userStreetAddress = document.getElementById("userStreetAddress").value;  
                let userCity = document.getElementById("userCity").value;  
                let userState = document.getElementById("userState").value;  
                let userZipCode = document.getElementById("userZipCode").value;  
                let additionalNotes = document.getElementById("additionalNotes").value;  

                let formInfo = "userName=" + userName + "&userEmail=" + userEmail + "&userPhone=" + userPhone + "&userStreetAddress=" + userStreetAddress 
                        + "&userCity=" + userCity + "&userState=" + userState + "&userZipCode=" + userZipCode + "&additionalNotes=" + additionalNotes;


                xhttp.open("POST", "products.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(formInfo); 
            }

            function setCart(estimateCartItem, productsItem, setValue) {
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        let parser = new DOMParser();
                        let ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                        let estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        let numberOfItems = ajaxDocument.getElementsByClassName("shopping-cart")[0];
                        let cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];


                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("shopping-cart")[0].innerHTML = numberOfItems.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        
                        //Update the product quantities.
                        let numberOfProductsShown = document.getElementsByClassName("product-container").length; //Get the number of products shown to the user.
                        let productQuantitiesHiddenArray = Array();
                        for(let i = 0; i < numberOfProducts; i++){                              
                            let productQuantitiesHidden = ajaxDocument.getElementsByClassName("product-quantities-hidden")[i];
                            document.getElementsByClassName("product-quantities-hidden")[i].innerHTML = productQuantitiesHidden.innerHTML;
                            productQuantitiesHiddenArray[i] = productQuantitiesHidden.innerHTML;
                        }
                        for(let i = 0; i < numberOfProductsShown; i++){
                            let product = ajaxDocument.getElementsByClassName("product__quantity-container")[i].innerHTML;
                            
                            let productClass = document.getElementsByClassName("product-container")[i].classList.item(2);
                            let productCount = productQuantitiesHiddenArray[productClass];

                            if (productCount > 0) {
                                document.getElementsByClassName("product__quantity-container")[i].innerHTML = "<a href='#estimateCartTitle' class='product__quantity'>" + productCount + "</a>";
                                document.getElementsByClassName("product__quantity-container")[i].classList.add("show");
                            } else {
                                document.getElementsByClassName("product__quantity-container")[i].innerHTML = "";
                                document.getElementsByClassName("product__quantity-container")[i].classList.remove("show");
                            }
                        }  
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };        
                xhttp.open("GET", "products.php?" + estimateCartItem + "&productsItem" + productsItem + "&setValue=" + setValue, true);
                xhttp.send();
            }

            function resetCart(actionString, operatorString) {                
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        let parser = new DOMParser();
                        let ajaxDocument = parser.parseFromString(this.responseText, "text/html");
                        
                        let estimateTable = ajaxDocument.getElementsByClassName("estimate-table")[0];
                        let numberOfItems = ajaxDocument.getElementsByClassName("shopping-cart")[0];
                        let cartTotal = ajaxDocument.getElementsByClassName("cart-total")[0];
                        
                        let numberOfProductsShown = document.getElementsByClassName("product-container").length; //Get the number of products shown to the user.
                        for (let i = 0; i < numberOfProductsShown; i++) {
                            document.getElementsByClassName("product__quantity-container")[i].innerHTML = "";  
                        }
                        document.getElementsByClassName("estimate-table")[0].innerHTML = estimateTable.innerHTML;
                        document.getElementsByClassName("shopping-cart")[0].innerHTML = numberOfItems.innerHTML;
                        document.getElementsByClassName("cart-total")[0].innerHTML = cartTotal.innerHTML;
                        
                        //Recreate event listeners for - and + buttons.
                        reAddEventListeners();
                    }
                };
                xhttp.open("GET", "products.php?" + actionString + operatorString, true);
                xhttp.send();
            }
            
            function updateProductsShown(searchByCategoryString, orderByOptionsString) {
                var xhttp = new XMLHttpRequest();   
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        let parser = new DOMParser();
                        let ajaxDocument = parser.parseFromString(this.responseText, "text/html");
                        
                        let productSearch = ajaxDocument.getElementsByClassName("product-search")[0];
                        let products = ajaxDocument.getElementsByClassName("products")[0];

                        document.getElementsByClassName("product-search")[0].innerHTML = productSearch.innerHTML;
                        document.getElementsByClassName("products")[0].innerHTML = products.innerHTML;
                        //Recreate event listeners for - and + buttons.
                        reAddEventListenersAfterSearching();  
                    }
                };
                xhttp.open("GET", "products.php?" + searchByCategoryString + "&" + orderByOptionsString, true);
                xhttp.send();   
            }
            
           
            function reAddEventListeners() {               
                //Estimate cart event listeners.
                for(let i = 0; i < numberOfProducts; i++){    
                    document.getElementsByClassName("estimate-table__minus__item")[i].addEventListener("click", function () {     
                        let itemNumber = i;
                        let quantityToSet = document.getElementsByClassName("estimate-table__item-quantity")[i].innerHTML;
                        quantityToSet = checkQuantityMinAndMax(quantityToSet) - 1;
                        setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);
                    }, false);

                    document.getElementsByClassName("estimate-table__add__item")[i].addEventListener("click", function () {  
                        let itemNumber = i;
                        let quantityToSet = document.getElementsByClassName("estimate-table__item-quantity")[i].innerHTML;
                        quantityToSet = checkQuantityMinAndMax(quantityToSet) + 1;
                        setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);    
                    }, false);
                }
            }
            
            function reAddEventListenersAfterSearching() {    
                let numberOfProductsShown = document.getElementsByClassName("product-container").length; //Get the number of products shown to the user.
                
                //Header, search event listeners.        
                document.getElementById("searchButton").addEventListener("click", function () {
                    let searchByCategory = "" + document.getElementById("searchByCategory").value;
                    let orderByOptions = "" + document.getElementById("orderByOptions").value;
                    updateProductsShown("searchByCategory=" + searchByCategory, "orderByOptions=" + orderByOptions);
                }, false);


                //Product item event listeners.
                for(let i = 0; i < numberOfProductsShown; i++){ 
                    document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function (event) {           
                        event.preventDefault();
                        document.getElementsByClassName("product__minus-quantity")[i].classList.remove("change-color");
                        void document.getElementsByClassName("product__minus-quantity")[i].offsetWidth;
                        document.getElementsByClassName("product__minus-quantity")[i].classList.add("change-color");
                    }, false);

                     document.getElementsByClassName("product__minus-quantity")[i].addEventListener("click", function () {
                        adjustProductSetQuantity(i, "decrease");
                    }, false); 

                    document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function (event) {           
                        event.preventDefault();
                        document.getElementsByClassName("product__increase-quantity")[i].classList.remove("change-color");
                        void document.getElementsByClassName("product__increase-quantity")[i].offsetWidth;
                        document.getElementsByClassName("product__increase-quantity")[i].classList.add("change-color");
                     }, false);

                    document.getElementsByClassName("product__increase-quantity")[i].addEventListener("click", function () {
                        adjustProductSetQuantity(i, "increase");
                    }, false); 

                    document.getElementsByClassName("product__request-item__add")[i].addEventListener("click", function () {
                        let itemNumber = document.getElementsByClassName("product-container")[i].classList.item(2);
                        let quantityToSet = document.getElementsByClassName("product__set-quantity")[i].value;
                        quantityToSet = checkQuantityMinAndMax(quantityToSet);
                        setCart("item=" + itemNumber, "productsItem=" + i, quantityToSet);
                    }, false);
                }
            }           
        </script>
    </body>

</html>
