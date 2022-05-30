<?php
if(isset($_POST['submit-review'])){
    echo("<script>alert('hello')</script>");
}

?>

<div class="Review-Section">
                <div class="Review-Section__Header">
                    Reviews and Comments
                </div>
                <div class="Review-Section__First-Row">
                    <div class="Review-Section__First-Row__Current-Rating">
                        <div class="Review-Section__First-Row__Current-Rating__Num-Rating">
                            <?php
                            $currentRatingSQL="SELECT ROUND(AVG(NO_OF_STARS),1) FROM REVIEW WHERE PRODUCT_ID= ".$id;
                            $currentRatingstid = oci_parse($conn, $currentRatingSQL);
                            oci_execute($currentRatingstid);
                            $currentRatingRows=oci_fetch_array($currentRatingstid);
                            
                            $currentRating=$currentRatingRows['ROUND(AVG(NO_OF_STARS),1)'];
                            ?>
                            <div class="Review-Section__First-Row__Current-Rating__Num-Rating__Number"><?php echo $currentRating;?></div>
                            <div class="Review-Section__First-Row__Current-Rating__Num-Rating__Max"><p>/5</p></div>
                        </div>
                        <div class="Review-Section__First-Row__Current-Rating__Star-Rating">
                            <?php
                            $roundedRating=round($currentRating);
                            if(($roundedRating-$currentRating)<0){
                                for($starCounter=0;$starCounter<$roundedRating;$starCounter++){
                                ?>
                                <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                    <img src="assets/images/star/filled-star.svg"/>
                                </div> <?php } ?>
                                <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                    <img src="assets/images/star/half-star.svg"/>
                                </div>
                                <?php
                                for($starCounter=0;$starCounter<(4-$roundedRating);$starCounter++){
                                ?>
                                <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                    <img src="assets/images/star/empty-star.svg"/>
                                </div> <?php } ?>
                            <?php
                            }else if(($roundedRating-$currentRating)==0){
                                for($starCounter=0;$starCounter<$roundedRating;$starCounter++){
                                    ?>
                                    <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                        <img src="assets/images/star/filled-star.svg"/>
                                    </div> <?php }
                                    for($starCounter=0;$starCounter<(5-$roundedRating);$starCounter++){
                                    ?>
                                    <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                        <img src="assets/images/star/empty-star.svg"/>
                                    </div> <?php }
                            }else{
                                for($starCounter=0;$starCounter<($roundedRating-1);$starCounter++){
                                    ?>
                                    <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                        <img src="assets/images/star/filled-star.svg"/>
                                    </div> <?php } ?>
                                    <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                        <img src="assets/images/star/half-star.svg"/>
                                    </div>
                                    <?php
                                    for($starCounter=0;$starCounter<(5-$roundedRating);$starCounter++){
                                    ?>
                                    <div class="indi-star Review-Section__First-Row__Current-Rating__Star-Rating__Star">
                                    <img src="assets/images/star/empty-star.svg"/>
                                </div> <?php }
                            }
                            ?> 
                        </div>
                    </div>

                    <!--Adding Review Section-->
                    <?php
                    $canReviewFlag=false;
                    if(isset($_SESSION['user_id']) && (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated'] == true)){
                        $user=$_SESSION['user_id'];
                        $checkBoughtSQL="SELECT * FROM ORDERPLACE INNER JOIN ORDERLIST ON ORDERPLACE.ORDERPLACE_ID=ORDERLIST.ORDERPLACE_ID WHERE PRODUCT_ID=$id AND USER_ID=$user";
                        $Boughtstid = oci_parse($conn, $checkBoughtSQL);
                        oci_execute($Boughtstid);
                        $BoughtRow=oci_fetch_all($Boughtstid, $BoughtRes);
                        if($BoughtRow>=1 && $BoughtRes['PAYMENT_STATUS']==true){
                            $reviewCheckSQL="SELECT * FROM REVIEW WHERE PRODUCT_ID=$id AND USER_ID=$user";
                            $ReviewCheckstid = oci_parse($conn, $reviewCheckSQL);
                            oci_execute($ReviewCheckstid);
                            $ReviewCheckRow=oci_fetch_all($ReviewCheckstid, $BoughtRes);
                            if($ReviewCheckRow<1){
                                $canReviewFlag=true;
                            }else{
                                $canReviewFlag=false;
                            }
                        }else{
                            $canReviewFlag=false;
                        }
                        
                    }else{
                        $canReviewFlag=false;
                    }
                    ?>



                    <div class="Review-Section__First-Row__Add-Review">
                        <div class="Review-Section__First-Row__Add-Review__Title">Add a Review</div>
                        <form class="Review-Section__First-Row__Add-Review__Form" type="POST">
                            <div class="Review-Section__First-Row__Add-Review__Form__Rating">
                            Select Rating:
                            <input type="checkbox" class="Review-Section__First-Row__Add-Review__Form__star-item" value="1" id="star1">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star1"> <img src="assets/images/star/filled-star.svg"> </label>
                            <input type="checkbox" class="Review-Section__First-Row__Add-Review__Form__star-item" value="2" id="star2">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star2"> <img src="assets/images/star/filled-star.svg"> </label>
                            <input type="checkbox" class="Review-Section__First-Row__Add-Review__Form__star-item" value="3" id="star3">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star3"> <img src="assets/images/star/filled-star.svg"> </label>
                            <input type="checkbox" class="Review-Section__First-Row__Add-Review__Form__star-item" value="4" id="star4">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star4"> <img src="assets/images/star/filled-star.svg"> </label>
                            <input type="checkbox" class="Review-Section__First-Row__Add-Review__Form__star-item" value="5" id="star5">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star5"> <img src="assets/images/star/filled-star.svg"> </label>
                            </div>
                            <textarea class="Review-Section__First-Row__Add-Review__Form__Review-Text" placeholder="Write your review" name="Message"></textarea>
                            <input type="submit" value="Submit Review" class="btn primary-outline-btn card-btn" name="submit-review" <?php if(!$canReviewFlag){echo "disabled";}?>>
                        </form>
                    </div>


                </div>

                <?php
                $reviewSQL="SELECT * FROM  REVIEW INNER JOIN USERS ON REVIEW.USER_ID = USERS.USER_ID WHERE REVIEW.PRODUCT_ID = ".$id;
                $reviewstid = oci_parse($conn, $reviewSQL);
                oci_execute($reviewstid);
                $reviewRows = oci_fetch_all($reviewstid, $reviewRes);

                ?>

                <div class="Review-Section__Existing-Reviews">
                    <?php 
                    for ($reviewIterator=0;$reviewIterator<$reviewRows; $reviewIterator++){
                    ?>
                    <div class="Review-Section__Existing-Reviews__One-Review">
                        <div class="Review-Section__Existing-Reviews__One-Review__Profile-pic">
                            <img src="assets/images/<?php
                            if(empty($reviewRes['USER_IMAGE'][$reviewIterator])){
                                echo 'default-profile-image.png';
                            }else{
                                echo 'profiles/'.$reviewRes['USER_IMAGE'][$reviewIterator];
                            }
                            ?>" class="Review-Section__Existing-Reviews__One-Review__Profile-pic__pic">
                        </div>
                        <div class="Review-Section__Existing-Reviews__One-Review__Review-body">
                            <div class="Review-Section__Existing-Reviews__One-Review__Review-body__Name">
                                <?php echo $reviewRes['USERNAME'][$reviewIterator]; ?>
                            </div>
                            <div class="Review-Section__Existing-Reviews__One-Review__Review-body__star-rating">
                                <?php 
                                $stars= $reviewRes['NO_OF_STARS'][$reviewIterator];
                                for($starCounter=0;$starCounter<$stars;$starCounter++){
                                ?>
                                <div class="indi-star Review-Section__Existing-Reviews__One-Review__Review-body__star-rating__Star" id="Current-star1" starnumber="1">
                                    <img src="assets/images/star/filled-star.svg"/>
                                </div>
                                <?php
                                }
                                for($starCounter=0;$starCounter<(5-$stars);$starCounter++){
                                ?>
                                <div class="indi-star Review-Section__Existing-Reviews__One-Review__Review-body__star-rating__Star" id="Current-star5" starnumber="5">
                                    <img src="assets/images/star/empty-star.svg"/>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="Review-Section__Existing-Reviews__One-Review__Review-body__text">
                                <?php echo $reviewRes['MESSAGE'][$reviewIterator]; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>