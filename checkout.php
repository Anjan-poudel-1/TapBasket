<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    
    <div class="page checkout-page">

        <?php 
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="section__header">

                <div class="section__header__heading">

                  Cart Checkout

                </div>
            </div>
            <div class="checkout__body">

               <?php
               include './components/pages/Checkout/checout-steps.php';
               ?>

                <?php
               include './components/pages/Checkout/order-details.php';
               ?>

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

<script src="app.js"></script>
</html>