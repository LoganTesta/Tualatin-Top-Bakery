<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>About | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-about">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">About Us</h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>


            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-5">
                        <h3>About Us</h3>
                        <p>We are the best local bakery for all your baked goods.</p>
                        <p>We were founded in 2012 with a mission to provide delicious, healthy, affordable, and healthy products for our local customers!</p>
                        <p>All of our goods are baked in house with fresh ingredients.  We love working with local farmers and many of our ingredients
                            are from local suppliers!  Please feel free to <a href="contact-us.php">contact our bakery if you have product to sell!</a>
                        <p>We are located in Tualatin, Oregon.</p>
                    </div>
                    <div class="col-sma-7">
                        <div class="about-us-image-container">
                            <div class="about-us-container__background"></div>
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
                    setCurrentPage(0);
                });
            </script>
        </div>
    </body>

</html>
