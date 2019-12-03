<?php declare(strict_types = 1);
define('WP_USE_THEMES', false);
require('./wp-blog-header.php');


?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Blog | Tualatin Top Bakery</title>	   
        <?php include '../assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-blog">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include '../assets/include/logo.php'; ?>
                    <?php include '../assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">Blog</h2>
                </div>
            </header>

            <?php include '../assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-6">
                        <h3>Blog</h3>
                        <p>Read our comments and news from time to time.</p>
                        <div class="blog-posts">
                            <?php
                            global $post;
                            $args = array('posts_per_page' => 10);
                            $postsToDisplay = get_posts($args);
                            foreach ($postsToDisplay as $post) : setup_postdata($post);
                                ?>                                                       
                                <div class="blog-post">
                                    <h4 class="blog-post__title"><?php the_title(); ?></h4>
                                    <div class="blog__date"><?php the_date(); ?></div>
                                    <div class="blog__image"><?php the_post_thumbnail(); ?></div>
                                    <div class="blog-post__content"><?php the_content(); ?></div>
                                    <div class="clear-both"></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-sma-6">
                        <div class="blog-image-container">
                            <div class="blog-container__background"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../assets/include/message-content.php'; ?>
            <?php include '../assets/include/footer-content.php'; ?>
            <script type="text/javascript" src="../assets/javascript/javascript-functions.js"></script>
            <script type="text/javascript" src="../assets/javascript/vue-functions.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setCurrentPage(6);
                });
            </script>
        </div>
    </body>

</html>