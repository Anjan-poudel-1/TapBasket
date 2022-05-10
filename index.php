<?php
SESSION_START();
// session_destroy();
//If cart doesnt already exists...
if(!(isset($_SESSION['cart']))){

    $_SESSION['cart']= [];

}

//YEsma chai .. after login.. check the cartlist...
//through array add every item to the local i.e. session cart
if(isset($_GET['product_id']) && isset($_GET['qty'])){

   

    $product_id = $_GET['product_id'];
   
    $quantity = $_GET['qty'];


    //To validate.... check if quantity is int>0, product is in table
    if($quantity>0 && filter_var($quantity,FILTER_VALIDATE_INT)){
        //buy the product

        //if person is logged in.. add to cartlist

        if(isset($_SESSION['isAuthenticated'])){

        }

        //Session ma ta jasari pani upload hunu paryo 
        //We are mapping index and quantity here.. the index represents productId and value represents quantity'

        //If the item is already in the cart .. update it.. else just add to cart
        if(isset($_SESSION['cart'] [$product_id])){
             $_SESSION['cart'] [$product_id] += $quantity;
        }
        else{
            $_SESSION['cart'] [$product_id] = $quantity;
        }

    }
    else{
        echo '<script>alert("Invalid input to the cart")</script>';
    }


    echo"<script>console.log('hello')</script>";

} 


?>

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

            <?php
                echo "<pre>";
                print_r($_SESSION['cart']);
                echo "</pre>";
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