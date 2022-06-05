<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $user_id = $_SESSION['user_id'];
    ?>
    <?php if($_SESSION['user_id']!=NULL){?>
    <div class="section home-review">
    
                <div class="home-review__text">

                    <div class="home-review__text__header">
                          Review Purchased Item          
                    </div>
                    <div class="home-review__text__content">
                        You have purchased these items, review them to help other shoppers make better choices and Traders improve their products 
                    </div>

                </div>

                <?php
                    $userBoughtsql="SELECT DISTINCT(OL.PRODUCT_ID) AS PID FROM ORDERPLACE OP INNER JOIN ORDERLIST OL ON OP.ORDERPLACE_ID=OL.ORDERPLACE_ID INNER JOIN PRODUCT P ON OL.PRODUCT_ID=P.PRODUCT_ID WHERE OP.PAYMENT_STATUS='true' AND OP.USER_ID=$user_id";
                    $parseBought = oci_parse($conn, $userBoughtsql);
                    oci_execute($parseBought);
                    $BoughtRows = oci_fetch_all($parseBought, $BoughtArray);

                    $userReviewedsql="SELECT P.PRODUCT_ID AS PID FROM PRODUCT P INNER JOIN REVIEW R ON P.PRODUCT_ID=R.PRODUCT_ID WHERE R.USER_ID=$user_id";
                    $parseReviewed = oci_parse($conn, $userReviewedsql);
                    oci_execute($parseReviewed);
                    $ReviewedRows = oci_fetch_all($parseReviewed, $ReviewedArray);

                    $index=0;
                    for($i=0;$i<$BoughtRows;$i++){
                        if($ReviewedRows!=0){
                            for($j=0;$j<$ReviewedRows;$j++){
                                $reviewFlag=false;
                                if($BoughtArray['PID'][$i]==$ReviewedArray['PID'][$j]){
                                    break;
                                }else{
                                    $reviewFlag=true;
                                }
                            }
                        }else if($BoughtRows>0){
                            $reviewFlag=true;
                        }
                        if($reviewFlag){
                            $unreviewedArray[$index]=$BoughtArray['PID'][$i];
                            $index++;
                        }
                    }
                    if(!isset($_POST['skip'])){
                        $newIndex=0;
                    }else{
                        $newIndex=$_POST['skip-index']+1;
                        if($newIndex<sizeof($unreviewedArray)){
                            
                        }else{
                            $newIndex=0;
                        }
                    }
                    if($index!=0){
                    $stidReviewProduct = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=".$unreviewedArray[$newIndex];
                    $stidReview = oci_parse($conn, $stidReviewProduct);
                    oci_execute($stidReview);
                    $ProductToReview=oci_fetch_array($stidReview);
                ?>

                <div class="home-review__card">
                    <div class="home-review__card__image">
                        <img src='assets/images/ProductImage/<?php echo $ProductToReview['PRODUCT_IMAGE']?>'/>
                    </div>
                    <div class="home-review__card__content">
                        <div class="home-review__card__content__details">
                            <div class="home-review__card__content__details__name">
                                <?php echo $ProductToReview['PRODUCT_NAME']?>
                            </div>

                            <?php 
                            $discountPrice=0;

                            $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=".$unreviewedArray[$newIndex];
                            $stidDiscount = oci_parse($conn, $stidDiscount);
                            oci_execute($stidDiscount);
                            while (oci_fetch($stidDiscount)) {
                                $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                            }
                            $oldPrice=$ProductToReview['PRICE'];
                            ?>

                            <div class="home-review__card__content__details__price">
                            &#163; <?php if($discountPrice>0){?><i><strike><?php echo $oldPrice; ?></strike></i> <?php echo ($oldPrice-$discountPrice); }else{ echo $oldPrice;}?>
                            </div>
                        </div>
                        <div class="home-review__card__content__buttons">
                            <form class="home-review__card__content__buttons" method="GET" action="./product.php#review">
                                <input type="text" name="product-id" value="<?php echo $unreviewedArray[$newIndex];?>" hidden>
                                <button class="btn primary-btn review-btn" type="submit">
                                    Review
                                </button>
                            </form>

                            <form class="home-review__card__content__buttons" method="POST" action="#review-home" >
                                <input type="text" name="skip-index" value="<?php echo $newIndex; ?>" hidden>
                                <button class="btn primary-btn  review-btn" type="submit" name="skip" value="skip">
                                    Skip
                                </button>
                            </form>
                            
                        </div>
                    </div>

                </div>
                <?php }else{?>
                    <span class="no-review-left">No reviews left to give!</span>
                <?php } ?>
                    

            </div>
            <?php } ?>
</body>
</html>