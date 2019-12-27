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
        <title>Recipes | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-recipes">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle"><?php echo apply_filters('<p>', get_post(37)->post_title); ?></h2>
                </div>
            </header>
            <?php include 'assets/include/navigation-content.php'; ?>
            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-12">
                        <div class="recipies-header">
                            <?php
                            $id = 37;
                            $page = get_post($id);
                            $content = "&nbsp;" . apply_filters('the_content', $page->post_content);
                            echo $content;
                            ?>
                        </div>
                        <div class="recipes content-row">
                            <div class="col-sma-6 col-lar-4">
                                <div class="recipe-container one">
                                    <div class="recipe__title">Chocolate Cupcakes</div>
                                    <div id="recipeCont1">
                                        <recipe-component></recipe-component>
                                    </div>
                                    <div class="recipe__description">Every one loves a good cupcake!
                                        <div class="recipe-more-info--one">
                                            <div class="recipe-more-info__button" v-on:click="show=!show">More Info</div>
                                            <transition name="recipeShowMoreInfo">
                                                <div class="recipe-more-info-text" v-if="show">
                                                    <h3 class="recipe__subheading">Ingredients</h3>
                                                    <ul class="bulleted-list">
                                                        <li>flour</li>
                                                        <li>water</li> 
                                                        <li>butter</li>
                                                        <li>salt</li>
                                                        <li>eggs</li>
                                                        <li>sugar</li>
                                                        <li>cocoa</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Items</h3>
                                                    <ul class="bulleted-list">
                                                        <li>Cupcake platter</li>
                                                        <li>Large Bowl</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Steps</h3>
                                                    <p>Preheat the oven.</p>
                                                    <p>Mix the ingredients</p>
                                                    <p>Pour mix into cupcake containers</p>
                                                    <p>Bake in oven</p>
                                                    <p>Carefully remove from oven and let sit for a while to cool.</p>
                                                    <p>Makes 1 dozen.  Enjoy!</p>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sma-6 col-lar-4">
                                <div class="recipe-container two">
                                    <div class="recipe__title">Chocolate Fudge Brownies</div>
                                    <div id="recipeCont2">
                                        <recipe-component></recipe-component>
                                    </div>
                                    <div class="recipe__description">Time for some brownies!
                                        <div class="recipe-more-info--two">
                                            <div class="recipe-more-info__button" v-on:click="show=!show">More Info</div>
                                            <transition name="recipeShowMoreInfo">
                                                <div class="recipe-more-info-text" v-if="show">     
                                                    <h3 class="recipe__subheading">Ingredients</h3>
                                                    <ul class="bulleted-list">
                                                        <li>flour</li>
                                                        <li>water</li> 
                                                        <li>butter</li>
                                                        <li>salt</li>
                                                        <li>eggs</li>
                                                        <li>sugar</li>
                                                        <li>cocoa</li>
                                                        <li>vanilla</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Items</h3>
                                                    <ul class="bulleted-list">
                                                        <li>Baking pan</li>
                                                        <li>Large Bowl</li>
                                                        <li>spatula</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Steps</h3>
                                                    <p>Preheat the oven.</p>
                                                    <p>Mix the ingredients</p>
                                                    <p>Pour mix onto the baking pan</p>
                                                    <p>Bake in oven</p>
                                                    <p>Carefully remove from oven and let sit for a while to cool.</p>
                                                    <p>Makes 1 dozen.  Enjoy!</p>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sma-6 col-lar-4">
                                <div class="recipe-container three">
                                    <div class="recipe__title">Cinnamon Swirl Bread</div>
                                    <div id="recipeCont3">
                                        <recipe-component></recipe-component>
                                    </div>
                                    <div class="recipe__description">Perfect on a cool fall day.                                  
                                        <div class="recipe-more-info--three">
                                            <div class="recipe-more-info__button" v-on:click="show=!show">More Info</div>
                                            <transition name="recipeShowMoreInfo">
                                                <div class="recipe-more-info-text" v-if="show">
                                                    <h3 class="recipe__subheading">Ingredients</h3>
                                                    <ul class="bulleted-list">
                                                        <li>flour</li>
                                                        <li>water</li> 
                                                        <li>butter</li>
                                                        <li>salt</li>
                                                        <li>eggs</li>
                                                        <li>sugar</li>
                                                        <li>cinnamon</li>
                                                        <li>milk</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Items</h3>
                                                    <ul class="bulleted-list">
                                                        <li>Baking platter</li>
                                                        <li>Large Bowl</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Steps</h3>
                                                    <p>Preheat the oven.</p>
                                                    <p>Mix the ingredients</p>
                                                    <p>Pour mix onto the baking pan</p>
                                                    <p>Bake in oven</p>
                                                    <p>Carefully remove from oven and let sit for a while to cool.</p>
                                                    <p>Makes 1 loaf.  Enjoy!</p>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sma-6 col-lar-4">
                                <div class="recipe-container four">
                                    <div class="recipe__title">Angel Cake</div>
                                    <div id="recipeCont4">
                                        <recipe-component></recipe-component>
                                    </div>
                                    <div class="recipe__description">Light and fluffy.  Goes well with strawberries.
                                        <div class="recipe-more-info--four">
                                            <div class="recipe-more-info__button" v-on:click="show=!show">More Info</div>
                                            <transition name="recipeShowMoreInfo">
                                                <div class="recipe-more-info-text" v-if="show">                                                                                      
                                                    <h3 class="recipe__subheading">Ingredients</h3>
                                                    <ul class="bulleted-list">
                                                        <li>flour</li>
                                                        <li>water</li>
                                                        <li>salt</li>
                                                        <li>egg whites</li>
                                                        <li>sugar</li>
                                                        <li>vanilla</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Items</h3>
                                                    <ul class="bulleted-list">
                                                        <li>tube pan</li>
                                                        <li>large bowl</li>
                                                        <li>... and more</li>
                                                    </ul>
                                                    <h3 class="recipe__subheading">Steps</h3>
                                                    <p>Preheat the oven.</p>
                                                    <p>Mix the ingredients</p>
                                                    <p>Pour mix into the tube pan</p>
                                                    <p>Bake in oven</p>
                                                    <p>Carefully remove from oven and let sit for a while to cool.</p>
                                                    <p>Makes 1 cake.  Enjoy!</p>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
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
                    setCurrentPage(3);
                });
            </script>
        </div>
    </body>

</html>



