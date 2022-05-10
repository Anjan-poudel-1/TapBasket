<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page product-page">
        <?php
        include './components/navbars/primary-navbar.php'; 
        ?>

        <div class="container page__body">
            <div class="ProductMain">
                <div class="ProductImage-wrapper">
                    <div class="ProductImage image-1">
                        <img src="assets/images/ProductImage/Carrot1.jpg"/>
                    </div>
                </div>

                <div class="ProductDetail-wrapper">
                    <div class="ProductDetail-wrapper__name">
                        Farm Fresh Huddersfield Carrots (1Kg per Unit)
                    </div>
                    <div class="ProductDetail-wrapper__shop">
                        Sold by: <a href="#">Carrothead Company</a>
                    </div>
                    <div class="ProductDetail-wrapper__price">
                        Rs. 100
                    </div>
                    <div class="ProductDetail-wrapper__information">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eget ipsum diam. Donec sed consequat mi. Vestibulum commodo neque at odio accumsan porta ut ac ante. Nam egestas vel nisl vel pulvinar.
                        <div class="ProductDetail-wrapper__information__see-more">
                            <button class="btn primary-outline-btn card-btn">View More</button>
                        </div>
                    </div>
                </div>

                <div class="ProductCart-wrapper">
                    <div class="ProductCart-wrapper__Title">
                        Purchase Product
                    </div>
                    
                    <div class="ProductCart-wrapper__quantity">
                        <div class="ProductCart-wrapper__quantity__Title">Quantity:</div>
                        <div class="ProductCart-wrapper__quantity__Qty">
                            <div class="indi-cartitem__right__quantity__button">
                                    <!-- Minus button -->
                                <div class="indi-cartitem__right__quantity__button__change">
                                        <svg width="10" height="4" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.5833 3.08334H0.416626V0.916672H15.5833V3.08334Z" fill="currentColor"/>
                                        </svg> 
                                </div>  
                
                                <div class="indi-cartitem__right__quantity__button__num">
                                        7
                                </div> 
                                
                                    <!-- Plus button -->
                                <div class="indi-cartitem__right__quantity__button__change">
                                        <svg width="10" height="10" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.7832 9.08333H9.28325V15.5833H7.11658V9.08333H0.616577V6.91667H7.11658V0.416664H9.28325V6.91667H15.7832V9.08333Z" fill="currentColor"/>
                                        </svg>
                                        
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="ProductCart-wrapper__quantity__Stock">Out of Stock</div>
                    <div class="ProductCart-wrapper__Total">
                        <div class="ProductCart-wrapper__Total__Currency">Total Price: &nbsp; Rs. </div>
                        <div class="ProductCart-wrapper__Total__Amount">700</div>
                    </div>
                    
                    <div class="ProductCart-wrapper__buttons">
                        <div class="ProductCart-wrapper__buttons__Wishlist">
                            <button class="btn primary-outline-btn card-btn">Add to wishlist</button>
                        </div>
                        <div class="ProductCart-wrapper__buttons__Add-Cart">
                            <button class="btn primary-outline-btn card-btn">Add to Cart</button> 
                        </div>
                    </div>
                </div>

            </div>
            <?php
            include './components/pages/Product-Detail/review-section.php';
            ?>
        </div>
    </div>

     <!-- Page Footers  -->
     <?php
        include './components/resuables/page-footer.php';
    ?>

     <!-- Copyright   -->

    <?php
        include './components/resuables/copyright.php';
    ?>

    <!-- Bottom Nav -->

    <?php
    include './components/navbars/bottom-navbar.php';
    ?>
   
</body>

<script src="app.js">
   
</script>
</html>