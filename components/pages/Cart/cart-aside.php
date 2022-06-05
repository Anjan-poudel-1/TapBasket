<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="cart-aside">
        <div class="section__header">

            <div class="section__header__heading">

                Cart Summary

            </div>
        </div>

        <div class="cart-aside__body">
            <?php

            $myCart = ($_SESSION['cart']);
            $subtotal = 0;

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
                    $discountPrice = 0;

                    $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
                    $stidDiscount = oci_parse($conn, $stidDiscount);
                    oci_execute($stidDiscount);
        
        
                    while (oci_fetch($stidDiscount)) {
                        $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                        
                    }
                }

                $subtotal += ($product_price-$discountPrice) * $quantity;

            ?>

                <div class="cart-aside__body__list">

                    <div class="cart-aside__body__list__desc">
                        <?php
                        echo $product_name;
                        ?>
                        <span class="cart-aside__body__list__desc__number">(<?php echo $quantity ?>)</span>
                    </div>

                    <div class="cart-aside__body__list__price">
                        <?php
                        echo "£" . ($product_price-$discountPrice) * $quantity;
                        ?>
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

            <?php
            }


            ?>





            <div class="cart-aside__body__subtotal">
                <div class="cart-aside__body__subtotal__heading">
                    Sub Total :
                </div>

                <div class="cart-aside__body__subtotal__price">
                    <?php
                    echo "£" . $subtotal;
                    ?>
                </div>

            </div>

        </div>

        <div class="cart-aside__checkout">
            <?php
            if ($count > 20) {
            ?>
                <button class="btn primary-btn disabled-btn">

                    Checkout
                </button>
            <?php  } else {
            ?>
                <a href="checkout.php">
                    <button class="btn primary-btn ">

                        Checkout
                    </button>
                </a>
            <?php
            }
            ?>

        </div>
    </div>
</body>

</html>