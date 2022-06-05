<?php
session_start();

if ((isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated'] !== true)) {

    header('location:index.php');
}

include './connection.php';

$user_id= $_SESSION['user_id'];


//For moving to cart
//YEsma chai .. after login.. check the cartlist...
//through array add every item to the local i.e. session cart
if (isset($_GET['product_id']) && isset($_GET['qty'])) {

    $product_id = $_GET['product_id'];

    $quantity = $_GET['qty'];


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




        // For wishList

if (isset($_GET['category']) && isset($_GET['product_id']) && isset($_GET['type']) && isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {

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
    <title>WishList</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body data-theme="default" id="get-theme">
    <div class="page user-dashboard-page">
        <!-- Primary nav -->
        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="user-dashboard">
                <?php
                $pageName = "wishlist";
                include './components/pages/AccountSettings/userNavbar.php';

                ?>
                <div class="user-dashboard__content">

                    <div class="section__header">

                        <div class="section__header__heading">

                            My WishLists

                        </div>

                    </div>

                    <div class="user-dashboard__content__wishListPage">

                        <?php

            $sql = "SELECT * FROM WISHLIST WHERE USER_ID=$user_id";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);

            $numrows = oci_fetch_all($stid, $response);


            // echo($nrows);
            // $count=0;

            if($numrows==0){
                    echo "<div>No Saved Items</div>";
            }
            else{

               

                for ($i = 0; $i < $numrows; $i++) {
                   
                
                   
                $product_id = $response['PRODUCT_ID'][$i];


                $sqlNew = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=$product_id";
                $stidNew = oci_parse($conn,$sqlNew );
                oci_execute($stidNew);
    
                while (($row = oci_fetch_object($stidNew)) != false) {
                    // Use upper case attribute names for each standard Oracle column
                    $product_name=  $row->PRODUCT_NAME ;
                    $product_desc =  $row->PRODUCT_DESCRIPTION; 
                    $product_image=$row->PRODUCT_IMAGE;
                    $product_stock =$row->QUANTITY_IN_STOCK;
                    $price=$row->PRICE;
                    $shop_id= $row->SHOP_ID;
                    $discountPrice = 0;

                    $fetchShopNameSql = "SELECT SHOP_NAME 
                        FROM SHOP_REQUEST
                        INNER JOIN
                        SHOP ON 
                        SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
                        WHERE SHOP.SHOP_ID = $shop_id";

                    $stidNew1 = oci_parse($conn, $fetchShopNameSql);
                    oci_execute($stidNew1);


                    while (oci_fetch($stidNew1)) {
                        $shop_name = oci_result($stidNew1, 'SHOP_NAME');
                    }

                    $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
                    $stidDiscount = oci_parse($conn, $stidDiscount);
                    oci_execute($stidDiscount);


                    while (oci_fetch($stidDiscount)) {
                        $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                        
                    }
                    
                }


                    ?>
                        <div class="product-card">
        
                            <div class="product-card__image">
        
        
                                <!-- //image -->
                                <?php
                                echo "<img src='assets/images/ProductImage/$product_image' />";
                                ?>
        
        
        
                                <div class="product-card__wishlist">
        
                                    <!-- Change  wishlist from here -->
        
        
                                    <!-- If logged in  -->
                                    <?php
                                    if (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {
                                    ?>
                                        <?php
                                        $isInWishList = false;
                                        $user_id = $_SESSION['user_id'];
                                        $sqlNew = "SELECT PRODUCT_ID FROM WISHLIST WHERE USER_ID='$user_id'";
                                        $stidNew = oci_parse($conn, $sqlNew);
                                        oci_execute($stidNew, OCI_DEFAULT);
                                        oci_commit($conn);
                                        $numrows = oci_fetch_all($stidNew, $response);
                                        foreach ($response as $key => $value) {
                                            foreach ($value as $arrkey => $arrvalue) {
                                                if ($arrvalue == $product_id) {
                                                    $isInWishList = true;
                                                }
                                            }
                                        }
                                        ?>
        
                                        <!-- EMPTY -->
                                        <?php
                                        if ($isInWishList) {
                                        ?>
                                            <div class="product-card__wishlist__btn product-card__wishlist__btn--clicked">
                                                <a href="wishList.php?category=wishList&product_id=<?php echo $product_id?>&type=remove">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9 16.0125L7.9125 15.0225C4.05 11.52 1.5 9.21 1.5 6.375C1.5 4.065 3.315 2.25 5.625 2.25C6.93 2.25 8.1825 2.8575 9 3.8175C9.8175 2.8575 11.07 2.25 12.375 2.25C14.685 2.25 16.5 4.065 16.5 6.375C16.5 9.21 13.95 11.52 10.0875 15.03L9 16.0125Z" fill="#B12525" />
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="product-card__wishlist__btn">
                                            <a href="index.php?category=wishList&product_id=<?php echo $product_id?>&type=add">
                                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                                </svg>
                                            </a>
                                            </div>
        
                                        <?php
                                        } ?>
        
        
        
        
        
                                        <!-- iF NOT AUTHORSED -->
                                    <?php
                                    } else {
                                    ?>
                                        <div class="product-card__wishlist__btn">
        
                                            <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                            </svg>
        
                                        </div>
        
                                    <?php
                                    }
                                    ?>
        
        
        
                                </div>
        
                            </div>
                            <div class="product-card__details">
        
                                <div class="product-card__details__name">
                                    <?php
                                    echo $product_name;
                                    ?>
        
                                </div>
        
                                <div class="product-card__details__price">
                                    <b>£<?php
                                        echo ($price-$discountPrice);
                                        ?></b>
        
                                        <!-- If discount data is available -->
                                   <?php
                                   if($discountPrice>0){
                                       ?>
                                    <span class="product-card__details__price__discount-price">
                                    <b><strike>
                                    £<?php
                                        echo ($price);
                                        ?>
                                    </strike></b>
                                    </span>
                                       <?php
                                   }?>
                                    
        
        
                                </div>
                                <div class="product-card__details__vendor">
        
                                    Sold By : <?php
                                                echo $shop_name
                                                ?>
        
        
                                </div>
        
                                <div class="product-card__details__star-rating">
                                <?php
                            $currentRatingSQL="SELECT ROUND(AVG(NO_OF_STARS),1) FROM REVIEW WHERE PRODUCT_ID= ".$product_id;
                            $currentRatingstid = oci_parse($conn, $currentRatingSQL);
                            oci_execute($currentRatingstid);
                            $currentRatingRows=oci_fetch_array($currentRatingstid);
                            
                            $currentRating=$currentRatingRows['ROUND(AVG(NO_OF_STARS),1)'];
                        ?>
                            <div class="product-card__details__star-rating__stars">
                            <?php
                                $roundedRating=round($currentRating);
                                if(($roundedRating-$currentRating)<0){
                                    for($starCounter=0;$starCounter<$roundedRating;$starCounter++){
                            ?>
                                <div class="indi-star">
                                    <img src="assets/images/star/filled-star.svg" />
                                </div>
                            <?php } ?>
                                <div class="indi-star half-star">
                                    <img src="assets/images/star/half-star.svg"/>
                                </div>
                                <?php
                                for($starCounter=0;$starCounter<(4-$roundedRating);$starCounter++){
                                ?>
                                <div class="indi-star">
                                    <img src="assets/images/star/empty-star.svg" />
                                </div>
                                <?php } ?>
                                <?php
                                }else if(($roundedRating-$currentRating)==0){
                                    for($starCounter=0;$starCounter<$roundedRating;$starCounter++){
                                        ?>
                                        <div class="indi-star">
                                            <img src="assets/images/star/filled-star.svg"/>
                                        </div> <?php }
                                        for($starCounter=0;$starCounter<(5-$roundedRating);$starCounter++){
                                        ?>
                                        <div class="indi-star">
                                            <img src="assets/images/star/empty-star.svg"/>
                                        </div> <?php }
                                }else{
                                    for($starCounter=0;$starCounter<($roundedRating-1);$starCounter++){
                                        ?>
                                        <div class="indi-star">
                                            <img src="assets/images/star/filled-star.svg"/>
                                        </div> <?php } ?>
                                        <div class="indi-star half-star">
                                        <img src="assets/images/star/half-star.svg"/>
                                    </div>
                                        <?php
                                        for($starCounter=0;$starCounter<(5-$roundedRating);$starCounter++){
                                        ?>
                                        <div class="indi-star">
                                        <img src="assets/images/star/empty-star.svg"/>
                                    </div> <?php }
                                }
                                ?>
                                    </div>
                                    <span class="product-card__details__star-rating__count">(<?php if($currentRating!=null){echo $currentRating;} else{echo "NA";} ?>)</span>
                                </div>
        
                                <?php
        
                                if ($product_stock != 0) {
                                ?>
                                    <div class="product-card__details__cart-btn">
        
                                        <a href=<?php
                                                echo "wishList.php?product_id=$product_id&qty=1";
                                                ?>>
        
        
                                            <button class="btn primary-btn card-btn">
                                                Move to Cart
                                            </button>
                                        </a>
        
        
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="product-card__details__cart-btn">
        
                                        <button class="btn danger-btn card-btn" onclick="function outOfStock(){alert('ITEM OUT OF STOCK!')};outOfStock()">
                                            Out of Stock
                                        </button>
        
                                    </div>
        
                                <?php
                                }
                                ?>
        
                            </div>
        
                        </div>
        
                    <?php
                    }
                    ?>

          <?php  }

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