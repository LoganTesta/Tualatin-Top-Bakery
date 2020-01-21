<?php
declare(strict_types=1);
define('WP_USE_THEMES', false);
require('./wordpress/wp-load.php');

$specialQuery = false;
$blogPostQuery = "";

$orderBy = "";
$order = "";
if ($_GET["orderby"] != null) {
    $specialQuery = true;
    $orderBy = htmlspecialchars($_GET["orderby"]);
}
if ($_GET["order"] != null) {
    $specialQuery = true;
    $order = htmlspecialchars($_GET["order"]);
}

if ($specialQuery) {
    $blogPostQuery = '?orderby=' . $orderBy . '&order=' . $order;
} else {
    $blogPostQuery = "";
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Blog | Tualatin Top Bakery</title>	
        <?php wp_head(); ?><!-- Allow WordPress plugins to use CSS and JavaScript. -->
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-blog">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(43)->post_title); ?></h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-12">
                        <div class="blog-posts-container" id="blogPostsContainer">
                            <?php
                            $id = 43;
                            $page = get_post($id);
                            $content = "&nbsp;" . apply_filters('the_content', $page->post_content);
                            echo $content;
                            ?>

                            <div class="blog-posts" id="blogPosts">
                                <div class="blog-controls">
                                    <a class="blog-controls__control" href="?orderby=title&order=asc">Order By Oldest</a>
                                    <a class="blog-controls__control" href="?orderby=title&order=desc">Order By Newest</a>
                                </div>
                                <?php
                                $postsToDisplay = get_posts($args . '' . $blogPostQuery);
                                foreach ($postsToDisplay as $post) : setup_postdata($post);
                                    ?>                                                       
                                    <div class="blog-post">
                                        <h4 class="blog-post__title"><?php the_title(); ?></h4>
                                        <div class="blog__categories"><?php
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
                                        <div class="blog__date"><?php the_date(); ?></div>
                                        <div class="blog__image"><?php the_post_thumbnail('medium_rect_crop'); ?></div>
                                        <div class="blog__content"><?php the_content(); ?></div>
                                        <div class="clear-both"></div>
                                    </div>
                                <?php endforeach; ?>
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
                    setCurrentPage(6);
                });
            </script>
        </div>
        <?php wp_footer(); ?><!-- Allow WordPress plugins to use CSS and JavaScript. -->
    </body>

</html>
