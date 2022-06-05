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
            My Products
    </div>
               
            </div>

            <?php
            $userId = $_SESSION['user_id'];
            $sql = "SELECT SHOP_NAME,SHOP_ID FROM SHOP_REQUEST INNER JOIN SHOP ON SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID WHERE SHOP_REQUEST.USER_ID = $userId";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);

            $numrows = oci_fetch_all($stid, $responseall);

            $response = $responseall['SHOP_NAME'];


            foreach ($response as $key => $shopName) {

                    $shop_id=$responseall['SHOP_ID'][$key];
                ?>
                <div class="shop-header">
                    <div class="shop-header__info">
                        <span class="shop-header__info__title">
                        Shop <?php echo ($key + 1)?>
                        </span> <b>(<?php echo $shopName ?>)</b>
                    </div>
                    <div class="shop-header__button">
                        <a href="myProductDetails.php?type=add&shop-id=<?php echo $shop_id?>">
                            <button class="btn primary-btn">
                                Add Product
                            </button>
                        </a>
                       
                    </div>
                </div>
                   
                <?php
                $shopId = $responseall['SHOP_ID'][$key];

                $sqlFetchProducts = "select * from PRODUCT WHERE SHOP_ID=$shopId";
                $stidFetchProducts = oci_parse($conn, $sqlFetchProducts);
                oci_execute($stidFetchProducts);

                $numrowsFetchProducts = oci_fetch_all($stidFetchProducts, $responseallFetchProducts);

                //    print_r($responseallFetchProducts);

            ?>
                <div class="product-table">
                    <table>
                        <tr>
                            <td> Id</td>
                            <td> Product Name</td>
                            <td> Description</td>
                            <td> Image</td>
                            <td> Quantity</td>
                            <td> Allerygy Information</td>
                            <td> Price</td>
                            <td> Unit</td>
                            <td> is Disabled</td>
                            <td> Action</td>
                        </tr>



                        <?php
                        foreach ($responseallFetchProducts as $key => $value) {
                            $product_ids = $responseallFetchProducts['PRODUCT_ID'];
                            $product_names = $responseallFetchProducts['PRODUCT_NAME'];
                            $product_descs = $responseallFetchProducts['PRODUCT_DESCRIPTION'];
                            $product_images = $responseallFetchProducts['PRODUCT_IMAGE'];
                            $product_stocks = $responseallFetchProducts['QUANTITY_IN_STOCK'];
                            $product_allrgyInfos = $responseallFetchProducts['ALERGYINFORMATION'];
                            $product_prices = $responseallFetchProducts['PRICE'];
                            $product_units = $responseallFetchProducts['UNIT'];
                            $product_disableds = $responseallFetchProducts['IS_DISABLED'];
                        }
                        for ($i = 0; $i < $numrowsFetchProducts; $i++) {
                        ?>
                            <tr>
                                

                                
                                <td>
                                    <?php echo $product_ids[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_names[$i] ?>
                                </td>
                                <td >
                                    <div class="limit-height">
                                    <?php echo $product_descs[$i] ?>
                                    </div>
                                  
                                </td>
                                <td>
                                    <?php echo $product_images[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_stocks[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_allrgyInfos[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_prices[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_units[$i] ?>
                                </td>
                                <td>
                                    <?php echo $product_disableds[$i] ?>
                                </td>
                                <td>
                                <a class="btn primary-btn" href="myProductDetails.php?product-id=<?php echo $product_ids[$i]?>&type=edit">
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