<?php
SESSION_START();
// session_destroy();
//If cart doesnt already exists...
if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = false;
}

include('./connection.php');

if( (isset($_SESSION['role']) && $_SESSION['role']=='trader')){
header('location:./myProducts.php');
}

//YEsma chai .. after login.. check the cartlist...
//through array add every item to the local i.e. session cart
if (isset($_POST['add-product'])) {

    $product_id = $_POST['product_id'];
    $quantity = 1;


    //To validate.... check if quantity is int>0, product is in table
    if ($quantity > 0 && filter_var($quantity, FILTER_VALIDATE_INT)) {
        //if quantity is positive interger, proceed too buy


        //We will be checking the stock availability from database. 
        $fetchquantityinStockSql = "SELECT QUANTITY_IN_STOCK FROM PRODUCT
        WHERE PRODUCT_ID = $product_id";

        $stidNew = oci_parse($conn, $fetchquantityinStockSql);
        oci_execute($stidNew);

        while (oci_fetch($stidNew)) {
            $qty_in_stock = oci_result($stidNew, 'QUANTITY_IN_STOCK');
        }
        $currentItemInCart = 0;
        if (isset($_SESSION['cart'][$product_id])) {
            $currentItemInCart = $_SESSION['cart'][$product_id];
        }


        //We have fetched current quantity of item in our cart and quantity total in stock.
        //User should not be able to keep items in cart more than it is in stock.

        if ($qty_in_stock <= $currentItemInCart) {

            //If item in stock=item in cart. User should not be able to add more

            echo "<script>alert('You have already kept $qty_in_stock of it in your cart for this product. ITEM OUT OF STOCK!')</script>";
        } else {

            if (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {

                $user_id = $_SESSION['user_id'];

                $sqlCheckIfAlreadyICart = "SELECT PRODUCT_ID,QUANTITY FROM CARTLIST WHERE USER_ID=:user_id AND PRODUCT_ID=:product_id";
                $stidCheckIfAlreadyICart = oci_parse($conn, $sqlCheckIfAlreadyICart);
                oci_bind_by_name($stidCheckIfAlreadyICart, ':user_id', $user_id);
                oci_bind_by_name($stidCheckIfAlreadyICart, ':product_id', $product_id);
                oci_execute($stidCheckIfAlreadyICart);


                while (($row = oci_fetch_object($stidCheckIfAlreadyICart)) != false) {

                    $isProductAlreadyPresent = $row->PRODUCT_ID;
                    $currentQuantity = $row->QUANTITY;
                }

                if (isset($isProductAlreadyPresent) && $isProductAlreadyPresent) {

                    //update quantity
                    $sqlUpdateCart = "UPDATE CARTLIST 
         
            SET quantity=:quantity
          
           WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id";

                    $stidUpdateCart  = oci_parse($conn, $sqlUpdateCart);
                    $tempQuantity = $quantity + $currentQuantity;
                    oci_bind_by_name($stidUpdateCart, ':quantity', $tempQuantity);
                    oci_execute($stidUpdateCart, OCI_COMMIT_ON_SUCCESS);
                } else {

                    //else insert
                    $sqlInsertCart = "INSERT INTO CARTLIST(USER_ID,PRODUCT_ID,QUANTITY) VALUES ($user_id,$product_id,$quantity)";
                    $stidInsert = oci_parse($conn, $sqlInsertCart);
                    oci_execute($stidInsert, OCI_COMMIT_ON_SUCCESS);
                }
            }

            //Session ma ta jasari pani upload hunu paryo 
            //We are mapping index and quantity here.. the index represents productId and value represents quantity'

            //If the item is already in the cart .. update it.. else just add to cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }
    } else {
        echo '<script>alert("Invalid input to the cart")</script>';
    }
}


//For wishList 
if (isset($_GET['category']) && isset($_GET['product_id']) && isset($_GET['type']) && isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {

    $wishlist_proId = $_GET['product_id'];
    $wishlist_category = $_GET['category'];
    $wishlist_type = $_GET['type'];

    if ($wishlist_type == 'remove') {
        $sqlRemove = "DELETE FROM  WISHLIST WHERE USER_ID=" . $_SESSION['user_id'] . " AND PRODUCT_ID=" . $wishlist_proId;
        $stidWishListRemove = oci_parse($conn, $sqlRemove);
        oci_execute($stidWishListRemove, OCI_COMMIT_ON_SUCCESS);
    }
    if ($wishlist_type == 'add') {
        $sqlInsert = 'INSERT INTO WISHLIST(USER_ID,PRODUCT_ID) VALUES (:userI_id,:product_id)';
        $stidWishList = oci_parse($conn, $sqlInsert);
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