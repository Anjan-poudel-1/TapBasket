<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page login-page">
        <?php 
            include './components/navbars/primary-navbar.php';
        ?>
        <div class="container page__body">
            <div class="invoice-page__contents__main">
                <div class="section__header">
                    <div class="section__header__heading">
                        Invoice
                    </div>
                    <div class="section__header__subheading">
                        Order No: 000001 
                    </div>
                </div>
                <div class="customer_details">
                    <div class="invoice__body__left__title">
                     Customer Details
                    </div>
                    <div class= "customer_body">
                        Customer Name: 
                        Customer Email:
                        Customer Contact Number: 
                    </div>
                </div>
            </div>
            
                    <div class="checkout__body__right__title">
                        Order Details
                    </div>
                   
                        <div class="checkout-product-card">
                            <div class="checkout-product-card__left">
                                <div class="checkout-product-card__left__image">
                                    <img src="assets/images/spinach.jpg"/>
                                </div>
                                <div class="checkout-product-card__left__desc">
                                    <div class="checkout-product-card__left__desc__name">
                                        Spinach Kranrikari
                                    </div>
                                    <div class="checkout-product-card__left__desc__rate">
                                        Rs.112
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-product-card__right">
                                <div class="checkout-product-card__right__quantity">
                                    x5
                                </div>
                                <div class="checkout-product-card__right__total">
                                    Rs.1000
                                </div>
                            </div>

                        </div>

                        <div class="checkout-product-card">
                            <div class="checkout-product-card__left">
                                <div class="checkout-product-card__left__image">
                                    <img src="assets/images/spinach.jpg"/>
                                </div>
                                <div class="checkout-product-card__left__desc">
                                    <div class="checkout-product-card__left__desc__name">
                                        Spinach Kranrikari
                                    </div>
                                    <div class="checkout-product-card__left__desc__rate">
                                        Rs.112
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-product-card__right">
                                <div class="checkout-product-card__right__quantity">
                                    x5
                                </div>
                                <div class="checkout-product-card__right__total">
                                    Rs.1000
                                </div>
                            </div>

                        </div>


                        <div class="checkout-product-card">
                            <div class="checkout-product-card__left">
                                <div class="checkout-product-card__left__image">
                                    <img src="assets/images/spinach.jpg"/>
                                </div>
                                <div class="checkout-product-card__left__desc">
                                    <div class="checkout-product-card__left__desc__name">
                                        Spinach Kranrikari
                                    </div>
                                    <div class="checkout-product-card__left__desc__rate">
                                        Rs.112
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-product-card__right">
                                <div class="checkout-product-card__right__quantity">
                                    x5
                                </div>
                                <div class="checkout-product-card__right__total">
                                    Rs.1000
                                </div>
                            </div>

                        </div>


                        <div class="checkout-product-card">
                            <div class="checkout-product-card__left">
                                <div class="checkout-product-card__left__image">
                                    <img src="assets/images/spinach.jpg"/>
                                </div>
                                <div class="checkout-product-card__left__desc">
                                    <div class="checkout-product-card__left__desc__name">
                                        Spinach Kranrikari
                                    </div>
                                    <div class="checkout-product-card__left__desc__rate">
                                        Rs.112
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-product-card__right">
                                <div class="checkout-product-card__right__quantity">
                                    x5
                                </div>
                                <div class="checkout-product-card__right__total">
                                    Rs.1000
                                </div>
                            </div>     
        </div>
    </div>
         
    <!-- Page Footers -->
    <?php
        include './components/resuables/page-footer.php';
    ?>
    <!-- Copyright  -->

    <?php
        include './components/resuables/copyright.php';
    ?>

    <!--Bottom Nav-->

<?php
include './components/navbars/bottom-navbar.php';
?>
</body>

<script src="app.js">
   
</script>

</html>