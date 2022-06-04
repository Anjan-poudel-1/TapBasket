<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="cart-page__contents__main__wrap">

        <?php

        $myCart = ($_SESSION['cart']);

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
                $product_id= $row->PRODUCT_ID;
                $shop_id = $row->SHOP_ID;
            }

            $fetchShopNameSql = "SELECT SHOP_NAME 
        FROM SHOP_REQUEST
        INNER JOIN
        SHOP ON 
        SHOP_REQUEST.SHOP_REQUEST_ID = SHOP.SHOP_REQUEST_ID
        WHERE SHOP.SHOP_ID = $shop_id";

            $stidNew = oci_parse($conn, $fetchShopNameSql);
            oci_execute($stidNew);


            while (oci_fetch($stidNew)) {
                $shop_name = oci_result($stidNew, 'SHOP_NAME');
            }

            $discountPrice = 0;

            $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
            $stidDiscount = oci_parse($conn, $stidDiscount);
            oci_execute($stidDiscount);


            while (oci_fetch($stidDiscount)) {
                $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                
            }

           

        ?>


            <div class="indi-cartitem">

                <div class="indi-cartitem__left">
                    <div class="indi-cartitem__left__image">
                        <?php
                        echo "<img src='./assets/images/ProductImage/$product_image' />";
                        ?>
                    </div>
                    <div class="indi-cartitem__left__details">

                        <div class="indi-cartitem__left__details__price mobile-view">

                            <?php
                            echo "£" . ($product_price-$discountPrice) * $quantity;
                            ?>
                             <?php
                           if($discountPrice>0){
                               ?>
                            <span class="product-card__details__price__discount-price">
                            <b><strike>
                            £<?php
                                echo ($product_price*$quantity);
                                ?>
                            </strike></b>
                            </span>
                               <?php
                           }?>
                           
                        </div>

                        <div>
                            <div class="indi-cartitem__left__details__name">
                                <?php
                                echo $product_name;
                                ?>
                            </div>
                            <div class="indi-cartitem__left__details__vendor">
                                <span class="indi-cartitem__left__details__vendor__by">Sold By : </span><?php echo  $shop_name ?>
                            </div>
                        </div>

                        <div class="indi-cartitem__left__details__other-details mobile-view">
                            <div class="indi-cartitem__right__others__mobile-functions">


                                <div class="indi-cartitem__right__quantity">

                                    <div class="indi-cartitem__right__quantity__button">
                                        <!-- Minus button -->
                                        <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                                    echo "$quantity"; ?>&type=subs">
                                            <div class="indi-cartitem__right__quantity__button__change">

                                                <svg width="10" height="4" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.5833 3.08334H0.416626V0.916672H15.5833V3.08334Z" fill="currentColor" />
                                                </svg>

                                            </div>
                                        </a>

                                        <div class="indi-cartitem__right__quantity__button__num">
                                            <?php
                                            echo $quantity;
                                            ?>
                                        </div>

                                        <!-- Plus button -->
                                        <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                                    echo $quantity ?>&type=add">
                                            <div class="indi-cartitem__right__quantity__button__change">

                                                <svg width="10" height="10" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.7832 9.08333H9.28325V15.5833H7.11658V9.08333H0.616577V6.91667H7.11658V0.416664H9.28325V6.91667H15.7832V9.08333Z" fill="currentColor" />
                                                </svg>

                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="indi-cartitem__left__details__other-details__functions">

                                    <!-- Add to wishlist  -->
                                    <div class="indi-cartitem__right__others__functions__icon">
                                        <!-- <svg width="22" height="22" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 16.0125L7.9125 15.0225C4.05 11.52 1.5 9.21 1.5 6.375C1.5 4.065 3.315 2.25 5.625 2.25C6.93 2.25 8.1825 2.8575 9 3.8175C9.8175 2.8575 11.07 2.25 12.375 2.25C14.685 2.25 16.5 4.065 16.5 6.375C16.5 9.21 13.95 11.52 10.0875 15.03L9 16.0125Z" fill="#B12525" />
                                        </svg> -->
                                        <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                        </svg>

                                    </div>

                                    <!-- Delete from cart -->
                                    <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php echo $quantity ?>&type=delete">
                                        <div class="indi-cartitem__right__others__functions__icon">
                                            <svg width="14" height="20" viewBox="0 0 18 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 20.75C1.5 22.125 2.625 23.25 4 23.25H14C15.375 23.25 16.5 22.125 16.5 20.75V5.75H1.5V20.75ZM17.75 2H13.375L12.125 0.75H5.875L4.625 2H0.25V4.5H17.75V2Z" fill="currentColor" />
                                            </svg>

                                        </div>
                                    </a>
                                </div>


                            </div>

                        </div>



                    </div>
                </div>

                <div class="indi-cartitem__right desktop-view">
                    <div class="indi-cartitem__right__others">
                        <div class="indi-cartitem__right__others__price">
                            <?php
                            echo "£" . ($product_price-$discountPrice) * $quantity;
                            ?>
                            
                        </div>
                        <div class="indi-cartitem__right__others__functions">

                            <!-- Add to wishlist  -->
                            

                            
                                <div class="indi-cartitem__right__others__functions__icon">
                                

                                <!-- FOR WISHLIST -->
                                <?php
                                    if(isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']){

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

                                if( $isInWishList){
                                    ?>
                                    <a href="cart.php?product_id=<?php echo $product_id ?>&category=wishList&type=remove">
                                <svg width="22" height="22" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 16.0125L7.9125 15.0225C4.05 11.52 1.5 9.21 1.5 6.375C1.5 4.065 3.315 2.25 5.625 2.25C6.93 2.25 8.1825 2.8575 9 3.8175C9.8175 2.8575 11.07 2.25 12.375 2.25C14.685 2.25 16.5 4.065 16.5 6.375C16.5 9.21 13.95 11.52 10.0875 15.03L9 16.0125Z" fill="#B12525" />
                                    </svg> 
                                </a>

                                    <?php

                                    
                                }
                                else{
                                    ?>
                                      <a href="cart.php?product_id=<?php echo $product_id ?>&category=wishList&type=add">
                                    <svg width="19" height="19" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                    </svg>
                                        </a>

                                    <?php
                                }

                                        ?>

                                        <!-- Filled
                                        <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                            echo "$quantity"; ?>&type=delete">
                                <svg width="22" height="22" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 16.0125L7.9125 15.0225C4.05 11.52 1.5 9.21 1.5 6.375C1.5 4.065 3.315 2.25 5.625 2.25C6.93 2.25 8.1825 2.8575 9 3.8175C9.8175 2.8575 11.07 2.25 12.375 2.25C14.685 2.25 16.5 4.065 16.5 6.375C16.5 9.21 13.95 11.52 10.0875 15.03L9 16.0125Z" fill="#B12525" />
                                    </svg> 
                                </a> -->

                                        <!-- Non-filled -->
                                        <!-- <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                            echo "$quantity"; ?>&type=delete">
                                    <svg width="19" height="19" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                    </svg>
                                        </a> -->
                                    <?php
                                    }
                                    else{
                                        ?>
                                    <svg width="19" height="19" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383" />
                                    </svg>
                                       
                                   <?php     
                                    }
                                ?>
                                

                                </div>
                                </a>

                                <!-- Delete from cart -->
                                <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                            echo "$quantity"; ?>&type=delete">
                                    <div class="indi-cartitem__right__others__functions__icon">
                                        <svg width="14" height="20" viewBox="0 0 18 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5 20.75C1.5 22.125 2.625 23.25 4 23.25H14C15.375 23.25 16.5 22.125 16.5 20.75V5.75H1.5V20.75ZM17.75 2H13.375L12.125 0.75H5.875L4.625 2H0.25V4.5H17.75V2Z" fill="currentColor" />
                                        </svg>

                                    </div>
                                </a>

                        </div>
                    </div>

                    <div class="indi-cartitem__right__quantity">
                        <div class="indi-cartitem__right__quantity__label">
                            Qty :
                        </div>
                        <div class="indi-cartitem__right__quantity__button">
                            <!-- Minus button -->
                            <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                        echo "$quantity"; ?>&type=subs">
                                <div class="indi-cartitem__right__quantity__button__change">
                                    <svg width="10" height="4" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.5833 3.08334H0.416626V0.916672H15.5833V3.08334Z" fill="currentColor" />
                                    </svg>

                                </div>
                            </a>

                            <div class="indi-cartitem__right__quantity__button__num">
                                <?php echo "$quantity" ?>
                            </div>

                            <!-- Plus button -->
                            <a href="cart.php?product_id=<?php echo $product_id ?>&qty=<?php
                                                                                        echo "$quantity"; ?>&type=add">
                                <div class="indi-cartitem__right__quantity__button__change">
                                    <svg width="10" height="10" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.7832 9.08333H9.28325V15.5833H7.11658V9.08333H0.616577V6.91667H7.11658V0.416664H9.28325V6.91667H15.7832V9.08333Z" fill="currentColor" />
                                    </svg>

                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        <?php
        }


        ?>

    </div>
</body>

</html>