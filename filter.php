<?php
SESSION_START();
include('./connection.php');
if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = false;
}

    $nameFlag=false;
    $HLPriceFlag=false;
    $LHPriceFlag=false;

    $search='';
    if(isset($_GET['search'])){
        $search=$_GET['search'];
    }
    $sql = "SELECT * FROM PRODUCT INNER JOIN SHOP ON PRODUCT.SHOP_ID=SHOP.SHOP_ID INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID=SHOP_REQUEST.SHOP_REQUEST_ID WHERE PRODUCT.IS_DISABLED='false' AND (LOWER(PRODUCT.PRODUCT_NAME) LIKE LOWER('%$search%')) OR (LOWER(SHOP_REQUEST.CATEGORY) LIKE LOWER('%$search%'))";

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

    if(isset($_POST['Category'])){
        $Cat=$_POST['Category'];

        if(isset($_GET['search'])){

            $sql = "SELECT * FROM PRODUCT INNER JOIN SHOP ON PRODUCT.SHOP_ID=SHOP.SHOP_ID INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID=SHOP_REQUEST.SHOP_REQUEST_ID WHERE PRODUCT.IS_DISABLED='false' AND (LOWER(PRODUCT.PRODUCT_NAME) LIKE LOWER('%$search%')) AND (LOWER(SHOP_REQUEST.CATEGORY)=LOWER('".$Cat[0]."'))";
            for($CatIterator=1; $CatIterator < count($Cat); $CatIterator++){
                $sql =$sql . " OR (SHOP_REQUEST.CATEGORY='".$Cat[$CatIterator]."')";
            }
            // $sql=$sql . ")";
              
        }else{

            $sql="SELECT * FROM PRODUCT INNER JOIN SHOP ON PRODUCT.SHOP_ID=SHOP.SHOP_ID INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID=SHOP_REQUEST.SHOP_REQUEST_ID WHERE PRODUCT.IS_DISABLED='false' AND (SHOP_REQUEST.CATEGORY='".$Cat[0]."')";
            for($CatIterator=1; $CatIterator < count($Cat); $CatIterator++){
                $sql =$sql . " OR (SHOP_REQUEST.CATEGORY='".$Cat[$CatIterator]."')";
            }
            // $sql=$sql . ")";

        }}

    if(isset($_POST['sort'])){
        $sort=$_POST['sort'];
        if($sort=="Name"){
            $nameFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRODUCT_NAME";
        }else if($sort=="PriceHL"){
            $HLPriceFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRICE DESC";
        }else if($sort=="PriceLH"){
            $LHPriceFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRICE";
        }
    }

    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    $nrows = oci_fetch_all($stid, $res);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page filter-page">
       <?php
        include './components/navbars/primary-navbar.php'; 
        ?>
        <div class="container page__body">
            <div class="filter-result-container">
                <div class="filter-result-container__left">
                    <div class="Categories-filter-page">
                        <div class="Categories-filter-page__Header">
                            Categories
                        </div>
                        <form class="Categories-filter-page__Form" method="POST">
                            <?php
                                $queryCat = "SELECT SHOP_REQUEST.CATEGORY FROM SHOP INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID = SHOP_REQUEST.SHOP_REQUEST_ID";
                                $parseCat = oci_parse($conn, $queryCat);
                                oci_execute($parseCat);
                                $nrowsCat = oci_fetch_all($parseCat, $resCat);

                                for ($j = 0; $j < $nrowsCat; $j++){
                                $category= $resCat['CATEGORY'][$j];
                            ?>
                            <input type="checkbox" value="<?php echo $category?>" name="Category[]" <?php
                            if(isset($_POST['Category'])){
                                for($CheckIterator=0; $CheckIterator<count($Cat);$CheckIterator++){
                                    if($Cat[$CheckIterator]==$category){
                                        echo ' checked ';
                                    }
                                }
                            }
                            ?>> 
                            <label for="Categories-1"><?php echo ucfirst($category);?></label><br>
                            <?php } ?>
                            
                            <br><input type="submit" value="Apply" class="btn primary-outline-btn">
                            <input type="text" name="sort" value="<?php if(isset($_POST['sort'])){
                                echo $_POST['sort'];
                            } ?>" hidden>
                        </form>
                    </div>
                </div>
                <div class="filter-result-container__right">

                    <div class="filter-page__Top-Row">

                        <div class="filter-page__Top-Row__Res-Num">Showing <?php echo $nrows;?> Results<?php if(isset($_GET['search'])){echo ' for "'.$_GET['search'].'"';}?></div>
                        <div class="filter-page__Top-Row__Categories">
                            <button class="filter-page__Top-Row__Categories__dropdown-button">Categories</button>
                            <form class="Categories-filter-page__Form dropdown-form" method="POST">
                            <?php
                                $queryCat = "SELECT SHOP_REQUEST.CATEGORY FROM SHOP INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID = SHOP_REQUEST.SHOP_REQUEST_ID";
                                $parseCat = oci_parse($conn, $queryCat);
                                oci_execute($parseCat);
                                $nrowsCat = oci_fetch_all($parseCat, $resCat);

                                for ($j = 0; $j < $nrowsCat; $j++){
                                $category= $resCat['CATEGORY'][$j];
                            ?>
                            <input type="checkbox" value="<?php echo $category?>" name="Category[]" <?php
                            if(isset($_POST['Category'])){
                                for($CheckIterator=0; $CheckIterator<count($Cat);$CheckIterator++){
                                    if($Cat[$CheckIterator]==$category){
                                        echo ' checked ';
                                    }
                                }
                            }
                            ?>> 
                            <label for="Categories-1"><?php echo ucfirst($category);?></label><br>
                            <?php } ?>
                            
                            <br><input type="submit" value="Apply" class="btn primary-outline-btn">
                            <input type="text" name="sort" value="<?php if(isset($_POST['sort'])){
                                echo $_POST['sort'];
                            } ?>" hidden>
                        </form>
                        </div>
                    
                        <div class="filter-page__Top-Row__Sort">
                            <div class="filter-page__Top-Row__Sort__Sort-Title">Sort By:</div>
                            <div class="filter-page__Top-Row__Sort__Sort-Dropdown">
                                <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Button">
                                    <?php 
                                    if(isset($_POST['sort'])){
                                        switch($sort){
                                            case "Name":
                                                echo "Name";
                                                break;
                                            case "PriceHL":
                                                echo "Price: High to Low";
                                                break;
                                            case "PriceLH":
                                                echo "Price: Low to High";
                                                break;
                                            default:
                                            echo "Name";
                                        }
                                    }else{
                                        echo "Default";
                                    }
                                    ?>
                                    <svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.833313 0.333313L4.99998 4.49998L9.16665 0.333313H0.833313Z" class="filter-page__Top-Row__Sort__Sort-Dropdown__Button__Icon"/>
                                    </svg>
                                </button>
                                    <form method="POST" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content">
                                        <button type="submit" name="sort" value="Name" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($nameFlag){echo "disabled";}?>>Name</button>
                                        <button type="submit" name="sort" value="PriceHL" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($HLPriceFlag){echo "disabled";}?>>Price: High to Low</button>
                                        <button type="submit" name="sort" value="PriceLH" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($LHPriceFlag){echo "disabled";}?>>Price: Low to High</button>
                                        <?php
                                            $queryCat = "SELECT SHOP_REQUEST.CATEGORY FROM SHOP INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID = SHOP_REQUEST.SHOP_REQUEST_ID";
                                            $parseCat = oci_parse($conn, $queryCat);
                                            oci_execute($parseCat);
                                            $nrowsCat = oci_fetch_all($parseCat, $resCat);

                                            for ($j = 0; $j < $nrowsCat; $j++){
                                            $category= $resCat['CATEGORY'][$j];
                                        ?>
                                        <input hidden type="checkbox" value="<?php echo $category?>" name="Category[]" <?php
                                        if(isset($_POST['Category'])){
                                            for($CheckIterator=0; $CheckIterator<count($Cat);$CheckIterator++){
                                                if($Cat[$CheckIterator]==$category){
                                                    echo ' checked ';
                                                }
                                            }
                                        }?>>
                                        
                                    <?php }
                                        ?>
                                    </form>
                            </div>
                        </div>

                    </div>

                    <hr class="filter-page__Line">
                    <div class="filter-page__Result">
                        <?php include './components/pages/Filter/Filter-Result.php';?>
                    </div>
                </div>
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