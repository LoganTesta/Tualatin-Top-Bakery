<?php
declare( strict_types = 1 );
define( 'WP_USE_THEMES', false );
require( './wordpress/wp-load.php' );
session_start();


if ( isset( $_SESSION["orderBy"]) === false ) {
    $_SESSION["orderBy"] = "date";
}
if ( isset( $_SESSION["order"] ) === false ) {
    $_SESSION["order"] = "desc";
}


if ( isset( $_GET["orderby"] ) ) {
    $_SESSION["orderBy"] = htmlspecialchars( $_GET["orderby"] );
}

if ( isset( $_GET["order"] ) && htmlspecialchars( $_GET["order"] ) === "toggle" ) {
    if ( $_SESSION["order"] === "desc" ) {
        $_SESSION["order"] = "asc";
    } else if ( $_SESSION["order"] === "asc" ) {
        $_SESSION["order"] = "desc";
    }
}

$orderByOutputText = "";
$orderText = "";
if ( $_SESSION["order"] === "asc" ){
    if ( $_SESSION["orderBy"] === "date" ) {
        $orderText = ": oldest to newest";
    } else if ( $_SESSION["orderBy"] === "title" ) {
        $orderText = ": A - Z";
    }
    else {
        $orderText = " (ascending)";
    }
} else if ( $_SESSION["order"] === "desc" ){
    if ( $_SESSION["orderBy"] === "date" ) {
        $orderText = ": newest to oldest";
    } else if ( $_SESSION["orderBy"] === "title" ) {
        $orderText = ": Z - A";
    } else {
        $orderText = " (descending)";
    }
} else {
   $orderText = ""; 
}
$orderByOutputText = "Order by " . $_SESSION["orderBy"] . $orderText . "";
        
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicious baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Blog | Tualatin Top Bakery</title>	
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-blog">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters( '<p>', get_post( 43 )->post_title ); ?></h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>

            <div class="inner-wrapper">
                <div class="content">
                    <div class="content-row no-content-row-padding">
                        <div class="col-sma-12">
                            <div class="blog-page__content-text">
                                <?php
                                $id = 43;
                                $page = get_post( $id );
                                $content = "" . apply_filters( 'the_content', $page->post_content );
                                echo $content;
                                ?>
                            </div>
                            <div id="blogControls" class="blog-controls">
                                <form class="blog-controls__control" id="blogControlForm0" method="get" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] ); ?>">
                                    <div class="input-container">
                                        <button class="blog-controls__button" id="blogControlButton0" name="blogControlButton0" type="submit">Order By Date</button>                          
                                    </div>
                                </form>
                                <form class="blog-controls__control" id="blogControlForm1" method="get" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] ); ?>">
                                    <div class="input-container">
                                        <button class="blog-controls__button" id="blogControlButton1" name="blogControlButton1" type="submit">Order By Title</button>                          
                                    </div>
                                </form>  
                                <?php echo "<div class='blog-posts__message'>" . $orderByOutputText . "</div>"; ?>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                    <div class="content-row no-content-row-padding">
                        <div class="col-sma-12">
                            <div class="blog-posts-container" id="blogPostsContainer">
                                <div class="blog-posts" id="blogPosts">
                                    <?php
                                    $args = array( 'posts_per_page' => -1, 'orderby' => $_SESSION["orderBy"], 'order' => $_SESSION["order"] );
                                    $postsToDisplay = get_posts( $args );
                                    foreach ( $postsToDisplay as $post ) : setup_postdata( $post );
                                        ?>                                                       
                                        <div  id="<?php the_title(); ?>" class="blog-post">
                                            <h4 class="blog__title"><?php the_title(); ?></h4>
                                            <div class="blog__image"><?php the_post_thumbnail( 'medium_rect_crop' ); ?></div>
                                            <div class="blog__categories"><?php
                                                $categories = get_the_category();
                                                $numberOfCategories = 0;
                                                foreach ( $categories as $category ) {
                                                    $numberOfCategories++;
                                                }

                                                $i = 0;
                                                foreach ( $categories as $category ) {
                                                    $result = "";
                                                    if ( $i < $numberOfCategories - 1 ) {
                                                        $result .= $category->name . ", ";
                                                    } else {
                                                        $result .= $category->name;
                                                    }
                                                    echo $result;
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                            <div class="blog__author">By: <?php the_author(); ?></div>
                                            <div class="blog__date"><?php the_date(); ?></div>                                      
                                            <div class="blog__content"><?php the_content(); ?></div>
                                            <div class="clear-both"></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
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
                    setCurrentPage(7);
                });
            </script>
            <script type="text/javascript">

                //Use AJAX to update the page without reloading the page.
                document.getElementById("blogControlForm0").addEventListener("submit", function (event) {
                    updateServerResponse(event, "orderby=date&order=toggle");
                }, false);

                document.getElementById("blogControlForm1").addEventListener("submit", function (event) {
                    updateServerResponse(event, "orderby=title&order=toggle");
                }, false);

                function updateServerResponse(event, actionString) {
                    event.preventDefault();
                    let xhttp = new XMLHttpRequest();

                    xhttp.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) {
                            let parser = new DOMParser();
                            let ajaxDocument = parser.parseFromString(this.responseText, "text/html");

                            let blogPostsContainer = ajaxDocument.getElementsByClassName("blog-posts")[0];
                            let blogPostsMessage = ajaxDocument.getElementsByClassName("blog-posts__message")[0];

                            document.getElementsByClassName("blog-posts")[0].innerHTML = " " + blogPostsContainer.innerHTML;
                            document.getElementsByClassName("blog-posts__message")[0].innerHTML = " " + blogPostsMessage.innerHTML;
                        }
                    };

                    xhttp.open("GET", "blog.php?" + actionString, true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send();
                }
            </script>
        </div>
    </body>

</html>
