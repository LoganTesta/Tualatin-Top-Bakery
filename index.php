<?php
declare( strict_types = 1 );
define( 'WP_USE_THEMES', false );
require( './wordpress/wp-load.php' );
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Tualatin Top Bakery</title>
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
            <div class="inner-wrapper">
                <div class="content index-content">
                    <div class="content-row no-content-row-padding">
                        <div class="col-sma-5">
                            <h3>Welcome to Tualatin Top Bakery!</h3>
                            <p>We specialize in fresh healthy and tasty baked goods!  You can find everything from house-made bread to delicious 
                                cakes and pies!</p>
                            <ul class="index-content__baked-items-list">
                                <li class="index-content__baked-items-list__list-item">Fresh bread daily</li>
                                <li class="index-content__baked-items-list__list-item">Delicious Cakes and Pies</li>
                                <li class="index-content__baked-items-list__list-item">Scones, Muffins, and more!</li>
                            </ul>
                            <p>Got a special order?  Need catering for an event?  Fill out our <a href="contact-us.php">contact form here</a> or give us a 
                                call at 503-224-4444.</p>
                        </div>
                        <div class="col-sma-7">
                            <div class="item-container">
                                <div class="item-container__background zero"></div>
                            </div>
                        </div>
                    </div>
                    <div class="content-row">
                        <h3 class="index-content__h3">Recent Blog Posts</h3>
                        <div class="content-row index-blog-posts" id="indexBlogPosts">
                            <?php
                            global $post;
                            $args = array( 'posts_per_page' => 3 );
                            $postsToDisplay = get_posts( $args );
                            foreach ( $postsToDisplay as $post ) : setup_postdata( $post );
                                ?>      
                                <div class="col-sma-4">
                                    <div class="index-blog-post">
                                        <a href="blog.php#<?php the_title(); ?>"><h4 class="index-blog__title"><?php the_title(); ?></h4></a>
                                        <div class="index-blog__categories"><?php
                                            $categories = get_the_category();
                                            $h = 0;
                                            foreach ( $categories as $category ) {
                                                $h++;
                                            }
                                            $h = $h - 1;

                                            $i = 0;
                                            foreach ( $categories as $category ) {
                                                $result = "";
                                                if ( $i < $h ) {
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
                        <h3 class="index-content__h3">Wholesome Breads, Rich Cakes and Pies, and More!</h3>
                        <div class="col-vsm-6 col-sma-3">
                            <div class="index-product-container zero">
                                <div class="index-product-container__background-wrapper">
                                    <div class="index-product-container__background">
                                        <a class="index-product-container__link" href="products.php"><span class="sr-only">Whole Wheat Loaf</span></a>
                                    </div>
                                </div>
                                <div class="index-product-container__background-layer">
                                    <a class="index-product-container__link" href="products.php"><span class="sr-only">Whole Wheat Loaf</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-vsm-6 col-sma-3">
                            <div class="index-product-container one">
                                <div class="index-product-container__background-wrapper">
                                    <div class="index-product-container__background">
                                        <a class="index-product-container__link" href="products.php"><span class="sr-only">Cherry Pie</span></a>
                                    </div>
                                </div>
                                <div class="index-product-container__background-layer">
                                    <a class="index-product-container__link" href="products.php"><span class="sr-only">Cherry Pie</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-vsm-6 col-sma-3">
                            <div class="index-product-container two">
                                <div class="index-product-container__background-wrapper">
                                    <div class="index-product-container__background">
                                        <a class="index-product-container__link" href="products.php"><span class="sr-only">Scones</span></a>
                                    </div>
                                </div>
                                <div class="index-product-container__background-layer">
                                    <a class="index-product-container__link" href="products.php"><span class="sr-only">Scones</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-vsm-6 col-sma-3">
                            <div class="index-product-container three">
                                <div class="index-product-container__background-wrapper">
                                    <div class="index-product-container__background">
                                        <a class="index-product-container__link" href="products.php"><span class="sr-only">Blueberry Pie</span></a>
                                    </div>
                                </div>
                                <div class="index-product-container__background-layer">
                                    <a class="index-product-container__link" href="products.php"><span class="sr-only">Blueberry Pie</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-row">
                        <div class="col-sma-12">
                            <?php
                            $id = 29;
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
                document.addEventListener( "DOMContentLoaded", function () {
                    setCurrentPage( 0 );
                } );
            </script>
        </div>
    </body>

</html>
