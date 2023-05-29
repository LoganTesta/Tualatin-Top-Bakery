<?php
declare( strict_types = 1 );
define( 'WP_USE_THEMES', false );
require( './wordpress/wp-load.php' );
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicious baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Location | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-location">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters( '<p>', get_post( 33 )->post_title ); ?></h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="inner-wrapper">
                <div class="content">
                    <div class="content-row">
                        <div class="col-sma-7">
                            <div class="location-container">
                                <h3 class="location-container__header">Location</h3>
                                <p>1111 SW Tualatin-Sherwood Road, Tualatin, Oregon 97062</p>
                                <p>&nbsp;</p>
                                <h4>Note: this is fictional business site for a portfolio. Thanks!</h4>
                                <div class="location-container__background"></div>
                            </div>
                        </div>

                        <div class="col-sma-5">
                            <?php
                            $id = 33;
                            $page = get_post( $id );
                            $content = "" . apply_filters( 'the_content', $page->post_content );
                            echo $content;
                            ?>
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
    </body>

</html>
