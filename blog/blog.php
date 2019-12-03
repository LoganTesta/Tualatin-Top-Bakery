<?php
declare(strict_types=1);
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
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
        <link rel="icon" type="image/png" href="../assets/images/favicon.png" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="../assets/css/main-styles.css?mod=12022019V3" />
        <link rel="stylesheet" type="text/css" href="assets/css/print-styles.css?mod=07052019" media="print" />
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>  <!--Vuejs -->
        <script src="https://unpkg.com/vue-router@3.0.1/dist/vue-router.js"></script> <!-- Vue.js router capabilities. -->
    </head>

    <body class="page-blog">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <div class="inner-wrapper">
                        <div class="logo">
                            <a href="../index.php"><img src="../assets/images/logo.png" alt="Tualatin Top Bakery Logo."></a>
                        </div>
                    </div>
                    <h1 class="main-title"><a class="main-title__title" href="../index.php">Tualatin Top Bakery</a></h1>
                    <h2 class="header__subtitle">Blog</h2>
                </div>
            </header>

            <nav class="nav desktop-nav" id="desktop-nav">
                <div class="inner-wrapper">
                    <ul>
                        <li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../about.php">About</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../location.php">Location</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../products.php">Products</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../recipes.php">Recipes</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../news-and-events.php">News/Events</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../careers.php">Careers</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../blog/blog.php">Blog</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../contact-us.php">Contact Us</a></li>
                        </li>
                    </ul>
                </div>
            </nav>
            <nav class="nav mobile-nav">
                <div id="dropdownButton"></div>
                <div id="dropdownContent">
                    <ul>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../about.php">About</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../location.php">Location</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../products.php">Products</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../recipes.php">Recipes</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../news-and-events.php">News/Events</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../careers.php">Careers</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../blog/blog.php">Blog</a></li>
                        <li class="nav__nav-item"><a class="nav__nav-link" href="../contact-us.php">Contact Us</a></li>
                    </ul>
                </div>
            </nav>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-6">
                        <h3>Blog</h3>
                        <p>Read our comments and news from time to time.</p>
                        <a class="nav__nav-link" href="../about.php">About US</a>
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
