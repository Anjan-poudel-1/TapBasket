<?php
include 'connection.php';

for ($i = 0; $i < $nrows; $i++) {

?>
    <div class="product-card search-card">


        <div class="product-card__image search-card__image">


            <!-- //image -->
            <?php
            $product_name = $res['PRODUCT_NAME'][$i];
            $product_id = $res['PRODUCT_ID'][$i];
            $product_image = $res['PRODUCT_IMAGE'][$i];
            $product_stock = $res['QUANTITY_IN_STOCK'][$i];
            $price = $res['PRICE'][$i];
            $shop_id = $res['SHOP_ID'][$i];
            $discountPrice = 0;

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

            $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
            $stidDiscount = oci_parse($conn, $stidDiscount);
            oci_execute($stidDiscount);


            while (oci_fetch($stidDiscount)) {
                $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
            }


            ?>
            <a href="product.php?product-id=<?php echo $res['PRODUCT_ID'][$i]; ?>">
                <?php
                echo '<img src="assets/images/ProductImage/' . $product_image . '" class="search-card__image__img"/>';
                ?>
            </a>


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
                            <a href="index.php?category=wishList&product_id=<?php echo $product_id ?>&type=remove">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 16.0125L7.9125 15.0225C4.05 11.52 1.5 9.21 1.5 6.375C1.5 4.065 3.315 2.25 5.625 2.25C6.93 2.25 8.1825 2.8575 9 3.8175C9.8175 2.8575 11.07 2.25 12.375 2.25C14.685 2.25 16.5 4.065 16.5 6.375C16.5 9.21 13.95 11.52 10.0875 15.03L9 16.0125Z" fill="#B12525" />
                                </svg>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="product-card__wishlist__btn">
                            <a href="index.php?category=wishList&product_id=<?php echo $product_id ?>&type=add">
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
        <div class="product-card__details search-card-detail">

            <div class="product-card__details__name">
                <a href="product.php?product-id=<?php echo $res['PRODUCT_ID'][$i]; ?>">
                    <?php
                    echo $product_name;
                    ?>
                </a>
            </div>

            <div class="product-card__details__price">
                <b>£<?php
                    echo ($price - $discountPrice);
                    ?></b>

                <!-- If discount data is available -->
                <?php
                if ($discountPrice > 0) {
                ?>
                    <span class="product-card__details__price__discount-price">
                        <b><strike>
                                £<?php
                                    echo ($price);
                                    ?>
                            </strike></b>
                    </span>
                <?php
                } ?>



            </div>
            <div class="product-card__details__vendor">

                Sold By : <?php
                            echo $shop_name
                            ?>


            </div>

            <div class="product-card__details__star-rating">
                <?php
                $currentRatingSQL = "SELECT ROUND(AVG(NO_OF_STARS),1) FROM REVIEW WHERE PRODUCT_ID= " . $product_id;
                $currentRatingstid = oci_parse($conn, $currentRatingSQL);
                oci_execute($currentRatingstid);
                $currentRatingRows = oci_fetch_array($currentRatingstid);

                $currentRating = $currentRatingRows['ROUND(AVG(NO_OF_STARS),1)'];
                ?>
                <div class="product-card__details__star-rating__stars">
                    <?php
                    $roundedRating = round($currentRating);
                    if (($roundedRating - $currentRating) < 0) {
                        for ($starCounter = 0; $starCounter < $roundedRating; $starCounter++) {
                    ?>
                            <div class="indi-star">
                                <img src="assets/images/star/filled-star.svg" />
                            </div>
                        <?php } ?>
                        <div class="indi-star half-star">
                            <img src="assets/images/star/half-star.svg" />
                        </div>
                        <?php
                        for ($starCounter = 0; $starCounter < (4 - $roundedRating); $starCounter++) {
                        ?>
                            <div class="indi-star">
                                <img src="assets/images/star/empty-star.svg" />
                            </div>
                        <?php } ?>
                        <?php
                    } else if (($roundedRating - $currentRating) == 0) {
                        for ($starCounter = 0; $starCounter < $roundedRating; $starCounter++) {
                        ?>
                            <div class="indi-star">
                                <img src="assets/images/star/filled-star.svg" />
                            </div> <?php }
                                for ($starCounter = 0; $starCounter < (5 - $roundedRating); $starCounter++) {
                                    ?>
                            <div class="indi-star">
                                <img src="assets/images/star/empty-star.svg" />
                            </div> <?php }
                            } else {
                                for ($starCounter = 0; $starCounter < ($roundedRating - 1); $starCounter++) {
                                    ?>
                            <div class="indi-star">
                                <img src="assets/images/star/filled-star.svg" />
                            </div> <?php } ?>
                        <div class="indi-star half-star">
                            <img src="assets/images/star/half-star.svg" />
                        </div>
                        <?php
                                for ($starCounter = 0; $starCounter < (5 - $roundedRating); $starCounter++) {
                        ?>
                            <div class="indi-star">
                                <img src="assets/images/star/empty-star.svg" />
                            </div> <?php }
                            }
                                    ?>
                </div>

                <span class="product-card__details__star-rating__count">(<?php if ($currentRating != null) {
                                                                                echo $currentRating;
                                                                            } else {
                                                                                echo "NA";
                                                                            } ?>)</span>

            </div>

            <?php

            if ($product_stock != 0) {
            ?>
                <div class="product-card__details__cart-btn">

                    <form method="POST">
                        <input name="product_id" hidden value=<?php echo $product_id ?>>
                        <input name="qty" hidden value="1">
                        <input type="submit" name="add-product" value="Add to Cart" class="btn primary-btn card-btn" />
                    </form>


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