<?php


SESSION_START();
if(!isset($_SESSION['role'])){
    header('location:index.php');
}
if ((isset($_SESSION['role']) && $_SESSION['role'] != 'trader')) {
    header('location:index.php');
}

include('connection.php');


?>
 <?php

$product_id =  '';
$product_name =  '';
$description = '';
$image = '';
$quantity = 0;
$allergyInfo = '';
$price = 0;
$unit = '';
$is_disabled = '';

if(isset($_GET['shop-id'])){
    $shop_id = $_GET['shop-id'];
    $shop_id=(int)$shop_id;
}
$type = $_GET['type'];

if(isset($_GET['product-id'])){
    $product_id = $_GET['product-id'];
    $sqlFetch = "SELECT * from PRODUCT WHERE PRODUCT_ID = $product_id";

$stid = oci_parse($conn, $sqlFetch);
oci_execute($stid);
while (($row = oci_fetch_object($stid)) != false) {
    // Use upper case attribute names for each standard Oracle column
    $product_id =  $row->PRODUCT_ID;
    $product_name =  $row->PRODUCT_NAME;
    $description = $row->PRODUCT_DESCRIPTION;
    $image = $row->PRODUCT_IMAGE;
    $quantity = $row->QUANTITY_IN_STOCK;
    $allergyInfo = $row->ALERGYINFORMATION;
    $price = $row->PRICE;
    $unit = $row->UNIT;
    $is_disabled = $row->IS_DISABLED;
}
}





// if(isset($_POST['deleteProductDetail'])){
//     $sqli = "DELETE from PRODUCT  WHERE PRODUCT_ID=$product_id";
//     $stid = oci_parse($conn, $sqli);
//     oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
//     // header('location:myProducts.php');
// }


if (isset($_POST['savePRoductDetail'])) {

    $product_name =$_POST['product_name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $allergyInfo = $_POST['allergyInfo'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    if(isset($type) && $type=='edit'){
        $is_disabled = $_POST['is_disabled'];
    }
    $errCount=0;
 


    if (empty(trim($product_name))) {
        $product_name_error = "Please enter product name";
        $errCount++;
    }
    if (empty(trim($description))) {
        $descriptionerr = "Please provide Description";
        $errCount++;
    }
    if (empty(trim($image))) {
        $imageerr = "Please select the image";
        $errCount++;
    }


    if (empty($quantity)) {
        $quantityerr = "Please enter the quantity in stock";
        $errCount++;
    } else {
        if ($quantity <= 0) {
            $quantityerr = "Quantity cannot be zero or less";
        }
    }

    if (empty($price)) {
        $priceerr = "Please enter price of the product";
        $errCount++;
    } else {
        if ($price <= 0) {
            $priceerr = "Price cannot be zero or less";
        }
    }
    if ($errCount == 0 && $type =='edit') {
        //If  no errors... connect to database,, update data 

        $sqli = "UPDATE PRODUCT SET PRODUCT_NAME=:product_name1,PRODUCT_DESCRIPTION=:description1,PRODUCT_IMAGE=:image1,QUANTITY_IN_STOCK=:quantity1,ALERGYINFORMATION=:allergyInfo1,PRICE=:price1,UNIT=:unit1,IS_DISABLED=:isdissable WHERE PRODUCT_ID=$product_id";

        $stid = oci_parse($conn, $sqli);
        oci_bind_by_name($stid, ':product_name1', $product_name);
        oci_bind_by_name($stid, ':description1', $description);
        oci_bind_by_name($stid, ':image1', $image);
        oci_bind_by_name($stid, ':quantity1', $quantity);
        oci_bind_by_name($stid, ':isdissable', $is_disabled);
        oci_bind_by_name($stid, ':allergyInfo1', $allergyInfo);
        oci_bind_by_name($stid, ':price1', $price);
        oci_bind_by_name($stid, ':unit1', $unit);

        oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

        echo ("<script>Product Updated</script>");
         header('location:myProducts.php');
    }
    if($errCount==0 && $type =='add'){
        // $userId = $_SESSION['user_id'];
        //$shop_id
        $sqli = "INSERT INTO PRODUCT(PRODUCT_NAME,PRODUCT_DESCRIPTION,PRODUCT_IMAGE,QUANTITY_IN_STOCK,ALERGYINFORMATION,PRICE,UNIT,SHOP_ID,IS_DISABLED) 
        VALUES(:product_name,:description1,:image1,:quantity,:allergyInfo,:price,:unit,:shop_id,'false')";
        
        $stid = oci_parse($conn, $sqli);
       
        oci_bind_by_name($stid, ':product_name', $product_name);
        oci_bind_by_name($stid, ':description1', $description);
        oci_bind_by_name($stid, ':allergyInfo', $allergyInfo);
        oci_bind_by_name($stid, ':image1', $image);
        oci_bind_by_name($stid, ':quantity', $quantity);
        oci_bind_by_name($stid, ':price', $price);
        oci_bind_by_name($stid, ':unit', $unit);
        oci_bind_by_name($stid, ':shop_id', $shop_id);
        oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

        echo ("<script>Product Inserted</script>");
          header('location:myProducts.php');

    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body data-theme="default" id="get-theme">

    <div class="page">
        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
        <div class="user-dashboard__content">
                
                <div class="section__header">

                    <div class="section__header__heading">
                
                        <?php 
                        if($type=='edit'){
                            echo 'Edit';
                        }else{
                            echo 'Add';
                        } ?>
                        Product
                
                    </div>
                
                </div>
               
                <form method="POST" action="">


            <div class="form-control">
                <p class="form-control__label">
                    Product Name
                </p>
                <input class="form-control__input <?php
                                                    if (isset($product_name_error)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Enter the product name" name="product_name" value="<?php
                                                                                            if ($product_name) {
                                                                                                echo $product_name;
                                                                                            }
                                                                                            ?>" />
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


            <div class="form-control">
                <p class="form-control__label">
                    Description
                </p>
                <textarea rows="5" style="resize:vertical;" class="form-control__input <?php
                                                    if (isset($descriptionerr)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Enter the product Description" name="description" ><?php if ($description) {echo trim($description);
                                                                                                    }
                                                                                                    ?>
                </textarea>
                <!-- Error show  -->
                <?php
                if (isset($descriptionerr)) {
                ?>
                    <div class="input-error">
                        <?php echo $descriptionerr ?>
                    </div>
                <?php
                }
                ?>

            </div>


            <div class="form-control ">
                <p class="form-control__label">
                    Image
                </p>
                <input class="form-control__input <?php
                                                    if (isset($imageerr)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Image for the product" name="image" value="<?php
                                                                                                if ($image) {
                                                                                                    echo $image;
                                                                                                }
                                                                                                ?>" />
                <!-- Error show  -->
                <?php
                if (isset($imageerr)) {
                ?>
                    <div class="input-error">
                        <?php echo $imageerr ?>
                    </div>
                <?php
                }
                ?>

            </div>



            <div class="form-control ">
                <p class="form-control__label">
                    Quantity
                </p>
                <input type="number"  class="form-control__input <?php
                                                    if (isset($quantityerr)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Quantity in stock of the product" name="quantity" value="<?php
                                                                                                if ($quantity) {
                                                                                                    echo $quantity;
                                                                                                }
                                                                                                ?>" />
                <!-- Error show  -->
                <?php
                if (isset($quantityerr)) {
                ?>
                    <div class="input-error">
                        <?php echo $quantityerr ?>
                    </div>
                <?php
                }
                ?>

            </div>
            <div class="form-control ">
                <p class="form-control__label">
                    Allergy Information
                </p>
                <input class="form-control__input" 
                placeholder="Allergy Information for the product" 
                name="allergyInfo" value="<?php
                                                                                                if ($allergyInfo) {
                                                                                                    echo $allergyInfo;
                                                                                                }
                                                                                                ?>" />
               

            </div>


            <div class="form-control ">
                <p class="form-control__label">
                    Product Price
                </p>
                <input step="0.01" class="form-control__input  <?php
                                                    if (isset($priceerr)) {
                                                        echo " form-control__input--error";
                                                    }
                                                    ?>" placeholder="Price of the product" type="number" name="price" value="<?php
                                                                                                if ($price) {
                                                                                                    echo $price;
                                                                                                }
                                                                                                ?>" />
                <!-- Error show  -->
                <?php
                if (isset($priceerr)) {
                ?>
                    <div class="input-error">
                        <?php echo $priceerr ?>
                    </div>
                <?php
                }
                ?>

            </div>


            <div class="form-control ">
                <p class="form-control__label">
                    Product Unit (gm/kg/pcs)
                </p>
                <input class="form-control__input" placeholder="Unit of the product" name="unit" value="<?php
                                                                                                if ($unit) {
                                                                                                    echo $unit;
                                                                                                }
                                                                                                ?>" />
                

            </div>

<?php
if($type=='edit'){
    ?>
            <div class="form-control ">
                <p class="form-control__label">
                    Is Disabled
                </p>
                <input class="form-control__input"  name="is_disabled" value="<?php
                                                                                                if ($is_disabled) {
                                                                                                    echo $is_disabled;
                                                                                                }
                                                                                                ?>" />
                

            </div>
    <?php
}
?>
           


            <div class="account-settings__user-details__others__flex">
                <?php 
                if($type=='add'){

                ?>
                   <input type="submit" value="Add data" name="savePRoductDetail" class="btn primary-btn form-btn" />
                
                <?php
                
                }
                else{?>
                <input type="submit" value="Update data" name="savePRoductDetail" class="btn primary-btn form-btn" />
                <!-- <input type="submit" value="Delete data" name="deleteProductDetail" class="btn danger-btn form-btn" /> -->
                <?php
                }
                ?>
                
             
               
            </div>



        </form>

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