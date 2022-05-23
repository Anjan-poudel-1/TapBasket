<?php
SESSION_START();
// session_destroy();
if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = '';
}
include('./connection.php');

//yesma chai... its about updating the cart... 
//here type can be add, subs, delete, 
if (isset($_GET['product_id']) && isset($_GET['qty']) && isset($_GET['type'])) {

    $product_id = $_GET['product_id'];
    $quantity = $_GET['qty'];
    $type = $_GET['type'];
    //Checking stock of product
    $sql = "SELECT * FROM PRODUCT WHERE IS_DISABLED='false' AND PRODUCT_ID=$product_id";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);

    while (($row = oci_fetch_object($stid)) != false) {

        $qty_in_stock = $row->QUANTITY_IN_STOCK;
    }



    //To validate.... check if quantity is int>0, product is in table
    if ($quantity > 0 && filter_var($quantity, FILTER_VALIDATE_INT)) {

        //if person is logged in.. change in db as well

        if (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {

            $user_id = $_SESSION['user_id'];

            

               
                
                if($type=="add"){
                    if($quantity >= $qty_in_stock) {
                        echo "<script>alert('Item out of stock! You already have max. $quantity in cart')</script>";
                    }
                    else{
                        $toUpdateQuantity =  $_SESSION['cart'][$product_id]+1;
                        $updateCartListSql ="UPDATE CARTLIST 
         
                        SET QUANTITY=:quantity
                      
                       WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id" ;
                        $stidUpdate = oci_parse($conn,$updateCartListSql);
                        oci_bind_by_name($stidUpdate, ':quantity',$toUpdateQuantity);
                        oci_execute($stidUpdate, OCI_COMMIT_ON_SUCCESS);
                    }
                }

                if($type=="subs"){
                    if($quantity<= 0) {
                        echo "<script>alert('Item out of stock! You already have max. $quantity in cart')</script>";
                    }
                    else{
                        $toUpdateQuantity = $_SESSION['cart'][$product_id]-1;
                        $updateCartListSql ="UPDATE CARTLIST 
         
                        SET QUANTITY=:quantity
                      
                       WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id" ;
                        $stidUpdate = oci_parse($conn,$updateCartListSql);
                        oci_bind_by_name($stidUpdate, ':quantity',$toUpdateQuantity);
                        oci_execute($stidUpdate, OCI_COMMIT_ON_SUCCESS);
                    }
                }

                if($type=="delete"){
                    $updateCartListSql ="DELETE FROM CARTLIST 
                       WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id" ;
                      $stidUpdate = oci_parse($conn,$updateCartListSql);
                      oci_execute($stidUpdate, OCI_COMMIT_ON_SUCCESS);
                }
               

        }


        //Session ma ta jasari pani upload hunu paryo 
        //We are mapping index and quantity here.. the index represents productId and value represents quantity'


        if (isset($_SESSION['cart'][$product_id])) {

            switch ($type) {
                case "add":
                    //Check if the item is at stock limit.. 
                    if ($quantity >= $qty_in_stock) {
                        echo "<script>alert('Item out of stock! You already have max. $quantity in cart')</script>";
                    } else {
                        $_SESSION['cart'][$product_id] = $quantity + 1;
                    }


                    break;
                case "subs":
                    if ($_SESSION['cart'][$product_id] == 1) {
                        echo '<script>alert("Cannot order less than 1 item. You can delete the item if you wish to remove it.")</script>';
                    } else {
                        $_SESSION['cart'][$product_id] = $quantity - 1;
                    }

                    break;
                case "delete":
                    $tempCart = $_SESSION['cart'];
                    unset($tempCart[$product_id]);
                    $_SESSION['cart'] = $tempCart;
                    break;
                default:
                    echo '<script>alert("Invalid input")</script>';
            }
        }
    } else {
        echo '<script>alert("Invalid input to the cart")</script>';
    }





    echo "<script>console.log('hello')</script>";
}

//Yo chai about wishList .. only if user is logged in 
//here type = add, delete . category=wishlist , product_id
if (isset($_GET['category']) && isset($_GET['product_id']) && isset($_GET['type'])) {

    $wishlist_proId = $_GET['product_id'];
    $wishlist_category = $_GET['category'];
    $wishlist_type = $_GET['type'];

    if($wishlist_type=='remove'){
        $sqlRemove ="DELETE FROM  WISHLIST WHERE USER_ID=".$_SESSION['user_id']." AND PRODUCT_ID=".$wishlist_proId; 
        $stidWishListRemove = oci_parse($conn,$sqlRemove);
        oci_execute($stidWishListRemove, OCI_COMMIT_ON_SUCCESS);

    }
    if($wishlist_type=='add'){
        $sqlInsert = 'INSERT INTO WISHLIST(USER_ID,PRODUCT_ID) VALUES (:userI_id,:product_id)';
        $stidWishList = oci_parse($conn,$sqlInsert);
        oci_bind_by_name($stidWishList, ':userI_id', $_SESSION['user_id']);
        oci_bind_by_name($stidWishList, ':product_id', $wishlist_proId);
        oci_execute($stidWishList, OCI_COMMIT_ON_SUCCESS);
    }
}

?>




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

            <?php

            if (count($_SESSION['cart']) == 0) {
                echo
                "<div class='empty-data empty-state'>Your Cart Is Empty</div>";
            } else {

            ?>

                <?php
                 if(($count) > 20) {
                    echo "<div class='cart-excess-message'>Cart has more than 20 items! Plese edit the cart before you checkout.</div>";
                 }
                ?>


                <div class="cart-page__contents">

               

                    <div class="cart-page__contents__main">

                        <div class="section__header">

                            <div class="section__header__heading">

                                Cart Details

                            </div>
                        </div>

                        <?php

                        // echo "<pre>";
                        //     print_r($_SESSION['cart']);
                        // echo "</pre>";

                        ?>


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
            <?php
            }
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