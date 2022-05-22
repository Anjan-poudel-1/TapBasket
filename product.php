<?php
include 'connection.php';
SESSION_START();

if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if(isset($_GET['product-id'])){
        $id=$_GET['product-id'];
        
        $query="SELECT * FROM PRODUCT WHERE PRODUCT_ID=".$id;
        $result=oci_parse($conn, $query);
        oci_execute($result);
        $row=oci_fetch_array($result);
    }?>
    <title><?php echo $row['PRODUCT_NAME'].' | TapBasket'; ?></title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page product-page">
        <?php
        include './components/navbars/primary-navbar.php'; 
        ?>
        <?php
         if(isset($_POST['more'])){
             $more=$_POST['more'];
         }else{
             $more="Less";
         }
        ?>

        <div class="container page__body">

        <?php
        if(isset($_GET['product-id'])){
            $id=$_GET['product-id'];
            
            $query="SELECT * FROM PRODUCT WHERE PRODUCT_ID=".$id;
            $result=oci_parse($conn, $query);
            oci_execute($result);
            $row=oci_fetch_array($result);

            $query2="SELECT SHOP_NAME 
            FROM SHOP_REQUEST
            INNER JOIN
            SHOP ON 
            SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
            WHERE SHOP.SHOP_ID =". $row['SHOP_ID'];
            $result2=oci_parse($conn, $query2);
            oci_execute($result2);
            $row2=oci_fetch_array($result2);
        }

        //Wishlist
        if (isset($_GET['product-id']) && isset($_GET['category']) && isset($_GET['type'])) {

            $wishlist_proId = $_GET['product-id'];
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

        //Testing if in wishlist
        if(isset($_SESSION['user_id'])){
            $isInWishList = false;
            $user_id=$_SESSION['user_id'];;
            $sqlNew = "SELECT PRODUCT_ID FROM WISHLIST WHERE USER_ID='$user_id'";
            $stidNew = oci_parse($conn, $sqlNew);
            oci_execute($stidNew, OCI_DEFAULT);
            oci_commit($conn);
            $numrows = oci_fetch_all($stidNew, $response);
            foreach ($response as $key => $value) {
                foreach ($value as $arrkey => $arrvalue) {
                    if ($arrvalue == $id) {
                        $isInWishList = true;
                    }
                }
            }    
        }   
        ?>

        <?php
        
        ?>
            <div class="ProductMain">
                <div class="ProductImage-wrapper">
                    <div class="ProductImage image-1">
                        <img src="assets/images/ProductImage/<?php echo $row['PRODUCT_IMAGE'];?>"/>
                    </div>
                </div>

                <div class="ProductDetail-wrapper">
                    <div class="ProductDetail-wrapper__name">
                    <?php echo $row['PRODUCT_NAME']?>
                    </div>
                    <div class="ProductDetail-wrapper__shop">
                        Sold by: <a href="#"><?php echo $row2['SHOP_NAME']?></a>
                    </div>
                    <div class="ProductDetail-wrapper__price">
                        &#163;<?php echo $row['PRICE']?>
                    </div>
                    <div class="ProductDetail-wrapper__information">
                    <?php
                    if($more=="Less"){
                        $viewButtonText="More";
                        $str=$row['PRODUCT_DESCRIPTION'];
                        $words=str_word_count($str,2);
                        $pos=array_keys($words);
                        echo substr($str,0,$pos[30]).'...';
                    }
                    else{
                        $viewButtonText="Less";
                        echo $row['PRODUCT_DESCRIPTION'];
                    ?>
                    <div class="ProductDetail-wrapper__information__AllegryHeader">
                        Allergy Information
                    </div>
                    <div class="ProductDetail-wrapper__information__AllegryInfo"><?php if(empty($row['ALERGYINFORMATION'])){ echo "No Allergy Information Found.";}else{ echo $row['ALERGYINFORMATION'] ;} ?></div>
                    <?php }
                    ?>
                        <form class="ProductDetail-wrapper__information__see-more" method="POST">
                            <button class="btn primary-outline-btn card-btn" type="submit" name="more" value="<?php echo $viewButtonText?>">View <?php echo $viewButtonText;?></button>
                        </form>
                    </div>
                </div>

                <div class="ProductCart-wrapper">
                    <div class="ProductCart-wrapper__Title">
                        Purchase Product
                    </div>
                    
                    <div class="ProductCart-wrapper__quantity">
                        <div class="ProductCart-wrapper__quantity__Title">Quantity:</div>
                        <div class="ProductCart-wrapper__quantity__Qty">
                            <form class="indi-cartitem__right__quantity__button" method="POST">
                                    <!-- Minus button -->
                                <button class="indi-cartitem__right__quantity__button__change product-cart-qty-button" type="submit" name="qty-button" value="minus">
                                        <svg width="10" height="4" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.5833 3.08334H0.416626V0.916672H15.5833V3.08334Z" fill="currentColor"/>
                                        </svg> 
                                </button>  
                
                                <div class="indi-cartitem__right__quantity__button__num">
                                        <?php
                                        if(!isset($_POST['qty-button'])){
                                            $qty=1;
                                        }else
                                        if(isset($_POST['qty-button'])){
                                            $qtyAction=$_POST['qty-button'];
                                            if($qtyAction=="minus"){
                                                if($_POST['qty']>1){
                                                    $qty=$_POST['qty']-1;
                                                }else{
                                                    $qty=1;
                                                }
                                            }
                                            if($qtyAction=="plus"){
                                                $qty=$_POST['qty']+1;
                                            }
                                        }
                                        echo $qty;
                                        ?>
                                        <input type="text" name="qty" value="<?php echo $qty?>" hidden>
                                </div> 
                                
                                    <!-- Plus button -->
                                <button class="indi-cartitem__right__quantity__button__change product-cart-qty-button" type="submit" name="qty-button" value="plus">
                                        <svg width="10" height="10" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.7832 9.08333H9.28325V15.5833H7.11658V9.08333H0.616577V6.91667H7.11658V0.416664H9.28325V6.91667H15.7832V9.08333Z" fill="currentColor"/>
                                        </svg>
                                        
                                </button> 
                            </form>
                        </div>
                    </div>
                    <div class="ProductCart-wrapper__quantity__Stock Stock-Hide">Out of Stock</div>
                    <div class="ProductCart-wrapper__Total">
                        <div class="ProductCart-wrapper__Total__Currency">Total Price: &nbsp;&#163;</div>
                        <div class="ProductCart-wrapper__Total__Amount"><?php echo ($row['PRICE']*$qty)?></div>
                    </div>
                    
                    <div class="ProductCart-wrapper__buttons">
                        <?php if($isInWishList){
                            ?>
                        <a href="product.php?product-id=<?php echo $id; ?>&category=wishList&type=remove">
                            <div class="ProductCart-wrapper__buttons__Wishlist">
                                <button class="btn primary-outline-btn card-btn">Remove from wishlist</button>
                            </div>
                        </a>
                        <?php }else{?>
                            <a href="product.php?product-id=<?php echo $id; ?>&category=wishList&type=add">
                                <div class="ProductCart-wrapper__buttons__Wishlist">
                                    <button class="btn primary-outline-btn card-btn">Add to wishlist</button>
                                </div>
                            </a>
                            <?php } ?>
                        <form class="ProductCart-wrapper__buttons__Add-Cart" method="POST">
                            <input name="product_id" hidden value="<?php echo $id ?>">
                            <input name="quantity" hidden value="<?php echo $qty ?>">
                            <button class="btn primary-outline-btn card-btn" type="submit">Add to Cart</button> 
                        </form>
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