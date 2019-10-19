<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Delicius baked goods featured including bread, cookies, pastries, pies, cakes, and more." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="bakery, bread, whole wheat, cookies, scones, pastries, cupcakes, cakes, pies, Oregon" />
        <title>Products | Tualatin Top Bakery</title>	   
        <?php include 'assets/include/document-head-components.php'; ?>
    </head>

    <body class="page-products">
        <div class="body-wrapper">
            <header>
                <div class="inner-wrapper">
                    <?php include 'assets/include/logo.php'; ?>
                    <?php include 'assets/include/header-content.php'; ?>
                    <h2 class="header__subtitle">Products</h2>
                </div>
            </header>

            <?php include 'assets/include/navigation-content.php'; ?>


            <div class="content">
                <div class="content-row inner-wrapper">
                    <div class="col-sma-12 products-wrapper">
                        <div class="products-header">
                            <h3>Products</h3>
                            <p>Learn more about the baked goods we sell.  Baked fresh daily.</p>
                        </div>
                        <div class="products content-row">
                            <div class="col-sma-6">
                                <div class="product-container one">
                                    <div class="product__title">Whole Wheat Loaf</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$3</div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our delicious and wholesome house-made whole wheat 
                                            bread, baked fresh daily.  One of our staples and customer favorites!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container two">
                                    <div class="product__title">White Bread Loaf</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$2</div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our delicious and fluffy house-made white bread, baked 
                                            fresh daily.  One of our staples and customer favorites!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container three">
                                    <div class="product__title">Scone</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$2/each</div>   
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Light and fluffy and flaky.  We are always trying new 
                                            varieties of scones including some seasonal.  We often have blueberry, vanilla, chocolate scones, 
                                            and many more, so come on in and see what we're baking this week!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container four">
                                    <div class="product__title">Chocolate Cake</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$15 or $2.50/slice</div>  
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Our signature crisp, fluffy chocolate cake with a light 
                                            layer of house-made chocolate fudge on top!  Yum!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container five">
                                    <div class="product__title">Cherry Pie (and assorted pies)</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$12 or $2.50/slice</div> 
                                    <div class="product__description">
                                        <p>Assorted wide variety of pies here at Tualatin Top Bakery!</p>
                                        <p class="no-padding-bottom">We sell cherry pie year round and other pies we sell depending
                                        on the season include blueberry, pumpkin, banana cream pie, chocolate cream pie, and more!</p></div>
                                </div>
                            </div>
                            <div class="col-sma-6">
                                <div class="product-container six">
                                    <div class="product__title">Blueberry Muffins</div>
                                    <div class="product__background-container">
                                        <div class="product__background"></div>
                                    </div>
                                    <div class="product__price">$2/each</div> 
                                    <div class="product__description">
                                        <p class="no-padding-bottom">Made with lots of blueberries and a hint of sugar.</p></div>
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
                    setCurrentPage(2);
                });
            </script>
        </div>
    </body>

</html>
