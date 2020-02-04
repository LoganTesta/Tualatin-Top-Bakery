<?php
declare(strict_types=1);
define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Tualatin Top Bakery</title>
        <?php wp_head(); ?><!-- Allow WordPress plugins to use CSS and JavaScript. -->
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-index">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">Fresh Quality Baked Goods!</h2>
                </div>
            </header>
            <?php include 'assets/include/navigation-content.php'; ?>
            <div class="content index-content">
                <div class="inner-wrapper">
                    <div class="content-row no-content-row-padding">
                        <div class="col-sma-5">
                            <h3>Welcome to Tualatin Top Bakery!</h3>
                            <p>We specialize in fresh healthy and tasty baked goods!  You can find everything from house-made bread to delicious 
                                cakes and pies!</p>
                            <h4>Products Include:</h4>
                            <ul class="index-content__baked-items-list">
                                <li class="index-content__baked-items-list__list-item">House made whole wheat and white bread</li>
                                <li class="index-content__baked-items-list__list-item">Variety of Excellent Cakes
                                <li class="index-content__baked-items-list__list-item">Assorted Delicious Pies</li>
                                <li class="index-content__baked-items-list__list-item">Scones</li>
                                <li class="index-content__baked-items-list__list-item">Muffins</li>
                            </ul>
                            <p>Got a special order?  Need catering for an event?  Fill out our <a href="contact-us.php">contact form here</a> or give us a 
                                call at 503-224-4444.  Note: we need 3+ days advance notice for catering events to ensure customer satisfaction.</p>
                        </div>
                        <div class="col-sma-7">
                            <div class="item-container">
                                <div class="item-container__background one"></div>
                            </div>
                        </div>
                    </div>
                    <div class="content-row">
                        <div class="col-sma-12">&nbsp;</div>
                        <h3 class="index-content__h3">Recent Blog Posts</h3>
                        <div class="content-row index-blog-posts" id="indexBlogPosts">
                            <?php
                            global $post;
                            $args = array('posts_per_page' => 3);
                            $postsToDisplay = get_posts($args);
                            foreach ($postsToDisplay as $post) : setup_postdata($post);
                                ?>      
                                <div class="col-sma-4">
                                    <div class="index-blog-post">
                                        <a href="blog.php#<?php the_title(); ?>"><h4 class="index-blog__title"><?php the_title(); ?></h4></a>
                                        <div class="index-blog__categories"><?php
                                            $categories = get_the_category();
                                            $h = 0;
                                            foreach ($categories as $category) {
                                                $h++;
                                            }
                                            $h = $h - 1;

                                            $i = 0;
                                            foreach ($categories as $category) {
                                                $result = "";
                                                if ($i < $h) {
                                                    $result .= $category->name . ", ";
                                                } else {
                                                    $result .= $category->name;
                                                }
                                                echo $result;
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                            <div class="index-blog__author-and-name">
                                                <div class="index-blog__author">By <?php the_author(); ?><span class="index-blog__author__extra-text">, </span></div>
                                                <div class="index-blog__date"><?php the_date(); ?></div>
                                            </div>
                                        <div class="index-blog__image"><a href="blog.php#<?php the_title(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a></div>
                                        <div class="index-blog__content"><?php the_excerpt(); ?></div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="content-row">
                        <div class="col-sma-12">
                            <div class="testimonials-wrapper">
                                <h3 class="index-content__h3">Customers Love Us!</h3>
                                <?php
                                $content = "" . do_shortcode('[general_testimonials]');
                                echo $content;
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
                });
            </script>
        </div>
        <?php wp_footer(); ?><!-- Allow WordPress plugins to use CSS and JavaScript. -->
    </body>

</html>
