<?php
SESSION_START();
if(!isset($_SESSION['role'])){
    header('location:index.php');
}
if ((isset($_SESSION['role']) && $_SESSION['role'] != 'trader')) {
    header('location:index.php');
}

include('connection.php');

if(isset($_GET['type'])){
    $type=$_GET['type'];
}
if(isset($_GET['product-id'])){
    $product_id=$_GET['product-id'];
    $product_id = (int)$product_id;
}



?>
<?php
$product_name =  '';
$price = 0;
$discount_price = 0;
$userId = $_SESSION['user_id'];
if(isset($product_id)){
    $sql = "SELECT PRODUCT_NAME,PRICE,DISCOUNT_RATE FROM PRODUCT P INNER JOIN DISCOUNT D ON D.PRODUCT_ID=P.PRODUCT_ID AND P.PRODUCT_ID=$product_id";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    while (($row = oci_fetch_object($stid)) != false) {
        $product_name =  $row->PRODUCT_NAME;
        $price = $row->PRICE;
        $discount_price= $row->DISCOUNT_RATE;
    }

}

if (isset($_POST['saveDiscountDetail'])) {

    $product_name =  $_POST['product_name'];
    $discount_price = $_POST['discount_price'];
    $errCount=0;

    $sqlGetProductId = "SELECT PRODUCT_ID,PRICE FROM PRODUCT WHERE PRODUCT_NAME=:product_name";
    $stidGetProductId = oci_parse($conn, $sqlGetProductId);
    oci_bind_by_name($stidGetProductId, ':product_name',$product_name);
    oci_execute($stidGetProductId);
    while (($row = oci_fetch_object($stidGetProductId)) != false) {
      
        $input_product_id = $row->PRODUCT_ID;
        $act_price = $row->PRICE;
      
    }

    $sqlCheckDiscount = "SELECT PRICE,P.PRODUCT_ID FROM PRODUCT P INNER JOIN DISCOUNT D ON D.PRODUCT_ID=P.PRODUCT_ID WHERE P.PRODUCT_NAME=:product_name";
    $stidCheckDiscount = oci_parse($conn, $sqlCheckDiscount);
    oci_bind_by_name($stidCheckDiscount, ':product_name',$product_name);
    oci_execute($stidCheckDiscount);
    while (($row = oci_fetch_object($stidCheckDiscount)) != false) {
        $discounted_price = $row->PRICE;
        $input_product_id = $row->PRODUCT_ID;
       
    }
    
    if (empty(trim($product_name))) {
        $product_name_error = "Please provide product name";
        $errCount++;
    }else{
        //If discount already exists
        if(isset($discounted_price) && isset($type) && $type=='add'){
            $product_name_error = "Discount already exists for the data";
            $errCount++;
        }
    }
    
    if (empty($discount_price)) {
        $discount_price_err = "Please enter discount price for the product";
        $errCount++;
    } else {
        if ($discount_price <= 0) {
            $discount_price_err = "Price cannot be zero or less";
            $errCount++;
        }
        //Also check if discount price exceeds product price
        if(isset($act_price) && $discount_price>=$act_price){
            $discount_price_err = "Discount Price Should not be greater than product price";
            $errCount++;
        }
    }
    if ($errCount == 0 && $type =='edit') {
        //If  no errors... connect to database,, update data 

        $sqliUpdateDiscount = "UPDATE DISCOUNT SET DISCOUNT_RATE=:discount_price WHERE PRODUCT_ID=$product_id";

        $stidUpdateDiscount = oci_parse($conn, $sqliUpdateDiscount);
        oci_bind_by_name($stidUpdateDiscount, ':discount_price', $discount_price);
        
        oci_execute($stidUpdateDiscount, OCI_COMMIT_ON_SUCCESS);

         echo ("<script>Product Updated</script>");
         header('location:productDiscount.php');
    }
    if($errCount==0 && $type =='add'){
        
        //$shop_id
        $sqliInsertDiscount = "INSERT INTO DISCOUNT(DISCOUNT_RATE,PRODUCT_ID) 
        VALUES(:discount_rate,:product_id)";
        
        $stidInsertDiscount = oci_parse($conn, $sqliInsertDiscount);
        echo $discount_price;
        echo $input_product_id;
       
        oci_bind_by_name($stidInsertDiscount, ':discount_rate', $discount_price);
        oci_bind_by_name($stidInsertDiscount, ':product_id', $input_product_id);
        oci_execute($stidInsertDiscount, OCI_COMMIT_ON_SUCCESS);

        echo ("<script>Product Inserted</script>");
         header('location:myProducts.php');

    }
}

if(isset($_POST['deleteDiscountDetail'])){
    $sqlDelete = "DELETE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
    $stidDelete = oci_parse($conn, $sqlDelete);
    oci_execute($stidDelete);
    header('location:productDiscount.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Details</title>
    <link rel="stylesheet" href="./assets/styles/index.css">

</head>
<body data-theme="default" id="get-theme">

    <div class="page home-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

<div class="container page__body">


<div class="trader-header"> 
    <div class="trader-header__title">
    Discount Detail
    </div>
   
</div>


  <form method="POST" action="">
  <div class="form-control">
                <p class="form-control__label">
                    Product Name
                </p>
                <?php
                if($type=='edit'){
                    ?>
                      <input readonly class="form-control__input <?php
                                                    if (isset($product_name_error)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Enter the product name" name="product_name" value="<?php
                                                                                            if ($product_name) {
                                                                                                echo $product_name;
                                                                                            }
                                                                                            ?>" />
                    <?php
                }else{
                    ?>
                    <select style="width: 100%;" name="product_name" class="form-control__input <?php
                                                    if (isset($product_name_error)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Enter the product name" name="product_name" value="<?php
                                                                                            if ($product_name) {
                                                                                                echo $product_name;
                                                                                            }
                                                                                            ?>">
                        <option value="">
                            Select product 
                        </option>
                        <?php
                            $sqlGetItems = "SELECT PRODUCT_ID,PRODUCT_NAME FROM PRODUCT P INNER JOIN SHOP S ON S.SHOP_ID=P.SHOP_ID INNER JOIN SHOP_REQUEST SR ON SR.SHOP_REQUEST_ID=S.SHOP_REQUEST_ID WHERE SR.USER_ID=$userId";
                            $stidGetItems = oci_parse($conn, $sqlGetItems);
                            oci_execute($stidGetItems, OCI_COMMIT_ON_SUCCESS); 
                            
                            $numrows = oci_fetch_all($stidGetItems, $responseall);
                            for($i = 0 ;$i<$numrows;$i++){
                                ?>
                                <option <?php if($product_name==$responseall['PRODUCT_NAME'][$i]) echo 'selected'?> value="<?php echo $responseall['PRODUCT_NAME'][$i] ?>">
                                    <?php echo $responseall['PRODUCT_NAME'][$i] ?>
                                </option>
                                <?php
                            }
                            
                            
                        ?>
                    </select>
                    <?php 
                    
                    }
                    ?>
              
                <!-- Error show  -->
                <?php
                if (isset($product_name_error)) {
                ?>
                    <div class="input-error">
                        <?php echo $product_name_error ?>
                    </div>
                <?php
                }
                ?>

            </div>


            <?php
            if($type=="edit"){
                ?>
 <div class="form-control">
                <p class="form-control__label">
                    Product Price (£)
                </p>
       
                <input readonly class="form-control__input" placeholder="Enter the product price" name="product_price" value="<?php
                                                                                            if ($price) {
                                                                                                echo $price;
                                                                                            }
                                                                                            ?>" />
                

            </div>
                <?php
            }
            ?>
           


            <div class="form-control">
                <p class="form-control__label">
                    Discount Price (£)
                </p>
       
                <input class="form-control__input <?php
                                                    if (isset($discount_price_err)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" type="number" step="0.01" placeholder="Enter the discount price for the product" name="discount_price" value="<?php
                                                                                            if ($discount_price) {
                                                                                                echo $discount_price;
                                                                                            }
                                                                                            ?>" />
                <!-- Error show  -->
                <?php
                if (isset($discount_price_err)) {
                ?>
                    <div class="input-error">
                        <?php echo $discount_price_err ?>
                    </div>
                <?php
                }
                ?>

            </div>


            <div class="account-settings__user-details__others__flex">
                <?php 
                if($type=='add'){

                ?>
                   <input type="submit" value="Add data" name="saveDiscountDetail" class="btn primary-btn form-btn" />
                
                <?php
                
                }
                else{?>
                <input type="submit" value="Update data" name="saveDiscountDetail" class="btn primary-btn form-btn" />
                <input type="submit" value="Delete data" name="deleteDiscountDetail" class="btn danger-btn form-btn" />
                <?php
                }
                ?>
                
             
               
            </div>


</form>
           


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