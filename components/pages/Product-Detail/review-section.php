<?php
if(isset($_POST['submit-review'])){

    //Logic...
    $review_message = '';
    //Only if star-rataing is given... submit the review

    if(isset($_POST['star-rating'])){
        $rating = $_POST['star-rating'];
        echo("<script>alert('Your review  of $rating stars has been submitted!')</script>");
    }
    else{
        echo("<script>alert('Please Provide rating!')</script>");
    }

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
                        <form class="Review-Section__First-Row__Add-Review__Form" method="POST" action="./product.php?product-id=<?php echo $id;?>">
                            <div class="Review-Section__First-Row__Add-Review__Form__Rating">
                            Select Rating:
<<<<<<< HEAD
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
=======
                            <input type="radio" class="Review-Section__First-Row__Add-Review__Form__star-item" name="star-rating" value="1" id="star1"  onchange="changeRating(1)" required>
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star1"  > <img src="assets/images/star/filled-star.svg" id="star-number1" > </label>
                            <input type="radio" class="Review-Section__First-Row__Add-Review__Form__star-item" name="star-rating" value="2" id="star2"  onchange="changeRating(2)">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star2"> <img src="assets/images/star/filled-star.svg" id="star-number2"> </label>
                            <input type="radio" class="Review-Section__First-Row__Add-Review__Form__star-item" name="star-rating" value="3" id="star3"  onchange="changeRating(3)">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star3"> <img src="assets/images/star/filled-star.svg" id="star-number3"> </label>
                            <input type="radio" class="Review-Section__First-Row__Add-Review__Form__star-item" name="star-rating" value="4" id="star4" onchange="changeRating(4)">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star4"> <img src="assets/images/star/filled-star.svg" id="star-number4"> </label>
                            <input type="radio" class="Review-Section__First-Row__Add-Review__Form__star-item" name="star-rating" value="5" id="star5"  onchange="changeRating(5)">
                            <label class="Review-Section__First-Row__Add-Review__Form__star-label" for="star5"> <img src="assets/images/star/filled-star.svg" id="star-number5"> </label>
                            </div>
                            <textarea class="Review-Section__First-Row__Add-Review__Form__Review-Text" placeholder="Write your review" name="message" required style="color: black;"></textarea>
                            <input hidden type="text" name="product-id" value="<?php echo $id;?>">
                            <input hidden type="text" name="user-id" value="<?php echo $user;?>">
                            <input type="submit" value="Submit Review" class="btn primary-outline-btn card-btn" name="submit-review" id="submit-review" <?php if(!$canReviewFlag){echo "disabled";}?>>
>>>>>>> new-dev
                        </form>
                    </div>

                    <?php if(isset($_POST['submit-review'])){
                        $message=$_POST['message'];
                        $NoOfStar=$_POST['star-rating'];
                        $reviewUser=$_POST['user-id'];
                        $reviewProduct=$_POST['product-id'];

                        if($canReviewFlag){

                        $addReviewsql="INSERT INTO REVIEW (MESSAGE,NO_OF_STARS,PRODUCT_ID,USER_ID) VALUES ('$message',$NoOfStar, $reviewProduct, $reviewUser) ";
                        $insertReviewstid = oci_parse($conn, $addReviewsql);
                        oci_execute($insertReviewstid);
                        }
                    }
                    ?>

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
            
            <script>
                let stars = document.getElementsByClassName('star-number');

changeRating = (value)=>{

    for(let i = 1; i<=5;i++){
        currentMax = document.getElementById('star-number'+i);
        if(i>value){
            currentMax.style.opacity=0.4;
        }
        else{
            currentMax.style.opacity=1;
        }
    }
    
    

}

            </script>