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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products</title>
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
    Discount Deals
    </div>
    <a href="productDiscountDetails.php?type=add">
        
    <div class="btn primary-btn trader-header__button">
    
    Add Data
    </div>
    
    </a>
</div>

<?php
 $userId = $_SESSION['user_id'];
 $sql = "SELECT 
 P.PRODUCT_ID AS ID, PRODUCT_NAME AS Product,PRICE,DISCOUNT_RATE AS DISCOUNT
 FROM PRODUCT P 
 INNER JOIN 
 DISCOUNT D ON 
 D.PRODUCT_ID = P.PRODUCT_ID  
 INNER JOIN SHOP S 
 ON P.SHOP_ID=S.SHOP_ID 
 INNER JOIN SHOP_REQUEST SR
 ON SR.SHOP_REQUEST_ID = S.SHOP_REQUEST_ID
 WHERE SR.USER_ID = $userId";

            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
            $numrows = oci_fetch_all($stid, $responseall);
            
                // print_r($responseall);


                if($numrows>0){
                        ?>
<div class="product-table">
                        <table border="1">
                        <tr>
                            <td> Id</td>
                            <td> Product Name</td>
                            <td> Actual Price</td>
                            <td> Discount Price</td>
                            <td> Action</td>
                        </tr>
                        <?php
                            for($i =0 ; $i<$numrows;$i++){
                            $product_id = $responseall['ID'][$i];
                            $product_name = $responseall['PRODUCT'][$i];
                            $product_price = $responseall['PRICE'][$i];
                            $product_discount = $responseall['DISCOUNT'][$i];

                            ?>
                            <tr>
                                <td><?php echo $product_id ?></td>
                            <td><?php echo  $product_name ?></td>
                            <td> <?php echo '£'.$product_price ?></td>
                            <td> <?php echo '£'.$product_discount?></td>
                            <td> 
                            <a class="btn primary-btn" href="productDiscountDetails.php?product-id=<?php echo $product_id?>&type=edit">
                                View/Edit
                            </a>
                            </td>
                            </tr>

                            <?php

                            }

                        ?>
                        </table>
</div>

                 <?php       
                }
                else{
                    //Empty discount datas
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