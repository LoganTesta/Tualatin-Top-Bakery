<?php
declare(strict_types=1);
define('WP_USE_THEMES', false);
require('./wordpress/wp-blog-header.php');
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>News and Events | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-news-and-events">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(39)->post_title); ?></h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-5">
                        <?php
                        $id = 39;
                        $page = get_post($id);
                        $content = "&nbsp;" . apply_filters('the_content', $page->post_content);
                        echo $content;
                        ?>
                        <div class="news-events-items">
                            <div class="event-container one">
                                <div class="event-container__title">3 Hour Discount Buffet</div>
                                <div class="event-container__image"></div>
                                <div class="event-container__date">May 8, 2019</div>
                                <div class="event-container__body-text">All prices marked down 20%!  Come try our tasty treats on discount!</div>
                            </div>
                            <div class="event-container two">
                                <div class="event-container__title">Kids Cupcake Party</div>
                                <div class="event-container__image"></div>
                                <div class="event-container__date">1st Wednesday of the month, all day.  </div>
                                <div class="event-container__body-text">
                                    All kids 12 and under invited for a free cupcake!</div>
                            </div>
                            <div class="event-container three">
                                <div class="event-container__title">Learn How to Make Cherry Pie.</div>
                                <div class="event-container__image"></div>
                                <div class="event-container__date">June 8, 2019</div>
                                <div class="event-container__body-text">Free ingredients and 1-hour lesson!</div>
                            </div>
                            <div class="event-container four">
                                <div class="event-container__title">Baked Goods Assortment Sampling Buffet</div>
                                <div class="event-container__image"></div>
                                <div class="event-container__date">July 20, 2019</div>
                                <div class="event-container__body-text">
                                    Curious to try something new that you've been wondering about? Now's your chance! 
                                    We are holding a sampling event for you to try bites from our excellent, wide-ranging assortment of baked goods.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sma-7">
                        <div class="events-image-container">
                            <div class="events-container__background"></div>
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
                    setCurrentPage(4);
                });
            </script>
        </div>
    </body>

</html>
