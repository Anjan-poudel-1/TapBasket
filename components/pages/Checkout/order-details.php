<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="checkout__body__right">
                    <div class="checkout__body__right__title">
                        Order Details
                    </div>
                    <div class="checkout__body__right__body">

                        <?php
$myCart = ($_SESSION['cart']);
$subTotal= 0;
foreach ($myCart as $product_id => $quantity) {

    $sql = "SELECT * FROM PRODUCT WHERE IS_DISABLED='false' AND PRODUCT_ID=$product_id";

    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    

    while (($row = oci_fetch_object($stid)) != false) {
        // Use upper case attribute names for each standard Oracle column
        $product_name =  $row->PRODUCT_NAME;
        $product_image =  $row->PRODUCT_IMAGE;
        $qty_in_stock = $row->QUANTITY_IN_STOCK;
        $product_price = $row->PRICE;
        $shop_id = $row->SHOP_ID;

       
        $discountPrice=0;

        $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
                    $stidDiscount = oci_parse($conn, $stidDiscount);
                    oci_execute($stidDiscount);
        
        
                    while (oci_fetch($stidDiscount)) {
                        $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                        
                    }

                    $subTotal+=($product_price-$discountPrice)*$quantity;
    }
?>

<div class="checkout-product-card">
                            <div class="checkout-product-card__left">
                                <div class="checkout-product-card__left__image">
                                    <img src="assets/images/ProductImage/<?php echo $product_image ?>"/>
                                </div>
                                <div class="checkout-product-card__left__desc">
                                    <div class="checkout-product-card__left__desc__name">
                                       <?php echo $product_name?>
                                    </div>
                                    <div class="checkout-product-card__left__desc__rate">
                                    £<?php echo $product_price?>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-product-card__right">
                                <div class="checkout-product-card__right__quantity">
                                    x<?php echo $quantity?>
                                </div>
                                <div class="checkout-product-card__right__total">
                                £<?php echo $quantity*($product_price-$discountPrice)?>
                                <span>
                                 <!-- If discount data is available -->
                           <?php
                           if($discountPrice>0){
                               ?>
                           
                            <b><strike>
                            £<?php
                                echo ($product_price)* $quantity;
                           
                                ?>
                            </strike></b>
                           <?php } ?>
                            </span>
                                </div>
                            </div>

                        </div>

<?php
}



?>


                    </div>
                    <div class="checkout__body__right__subtotal">
                        <div class="checkout__body__right__subtotal__title">
                            Sub Total
                        </div>
                        <div class="checkout__body__right__subtotal__price">
                        £<?php echo $subTotal?>
                        </div>
                    </div>

                </div>
</body>
</html>