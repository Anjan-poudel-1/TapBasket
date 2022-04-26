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

    <div class="page home-page">

        <?php 
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">

            <!-- Banner Section -->

            <?php
                include './components/pages/home/banner.php';
            ?>

            <!-- Top Deals Section -->
            <?php
                include './components/pages/home/top-deals.php';
            ?>

            <!-- Home Review Section -->
            <?php
             include './components/pages/home/home-review.php';
            ?>
         

            <!-- Featured products -->
           <?php
                include './components/pages/home/featured-products.php';
           ?>


            <!-- AD section -->
            <?php
                include './components/pages/home/home-ad.php';
           ?>


             <!-- Best Sellers Section -->
             <?php
                include './components/pages/home/best-sellers.php';
           ?>
           
        
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