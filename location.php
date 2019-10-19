<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
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
                    <h2 class="header__subtitle">Location/Hours</h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>


            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-7">
                        <div class="location-container">
                            <h3 class="location-container__header">Location</h3>
                            <p>4422 SW Tualatin-Sherwood Road, Tualatin, Oregon 97062</p>
                            <div class="location-container__background"></div>
                        </div>
                    </div>
         
                    <div class="col-sma-5">
                        <h3>Hours</h3>
                        <p>We are the best local bakery for all your baked goods.</p>

                        <p>Monday-Friday 7:00 AM-8:00 PM</p>
                        <p>Saturday 8:00 AM-8:00 PM</p>
                        <p>Sunday 8:00 AM-5:00 PM</p>
                    </div>
                </div>
            </div>
            <?php include 'assets/include/message-content.php'; ?>
            <?php include 'assets/include/footer-content.php'; ?>
            <script type="text/javascript" src="assets/javascript/javascript-functions.js"></script>
            <script type="text/javascript" src="assets/javascript/vue-functions.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(1);
                });
            </script>
        </div>
    </body>

</html>
