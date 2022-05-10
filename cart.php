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
    <div class="page cart-page">
        <?php
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">

        
        <div class="cart-page__contents">
            <div class="cart-page__contents__main">

                <div class="section__header">

                    <div class="section__header__heading">

                       Cart Details

                    </div>
                </div>
               <?php
               include './components/pages/Cart/main-content.php';
               ?>

            </div>
            <div class="cart-page__contents__aside">

                <?php
                    include './components/pages/Cart/cart-aside.php';
                ?>

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