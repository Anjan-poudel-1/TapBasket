<?php
$collectionDates = [];

$now = strtotime("now");
$end_date = strtotime("+2 weeks");

while (date("Y-m-d", $now) != date("Y-m-d", $end_date)) {
    $day_index = date("w", $now);
    if ($day_index == 3 || $day_index == 4|| $day_index == 5) {
        // Print or store the weekends here
        // echo date("F j, l", $now);
         $timeDiff =  abs(strtotime(date("Y-m-d", $now)))-abs(strtotime("+1 day")); 

       array_push($collectionDates,[date("F j, l", $now)=>$timeDiff]);


    }
    $now = strtotime(date("Y-m-d", $now) . "+1 day");
}

// print_r($collectionDates);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="checkout__body__left
<?php
if(isset($isStepOneCompleted) && $isStepOneCompleted ){
    echo "checkout__body__left--completed";
}
?>
">
                    <div class="checkout__body__left__step">
                        <form method="POST" >
                        
                        <div class="checkout__body__left__step__heading">
                             Choose Collection Slot
                        </div>
                        <div class="checkout__body__left__step__desc">
                            This is the field where you will be choosing collection slots.
                        </div>

                        <div class="checkout__body__left__step__sub checkout-select-date">
                            <div class="checkout-title checkout-select-date__title">
                                 Date of Collection :
                            </div>
                            <div class="checkout-desc">
                               Choose the day of the collection here:
                            </div>
                            <div class="checkout-body checkout-select-date__body">
                            
                                <select name="dateSelected">
                                    <option value="">
                                        ---- Select Date here ----
                                    </option>
                                    <!-- Loop the collectionDates here... -->
                                    <?php
                                        foreach($collectionDates as $key=>$dates){

                                            foreach($dates as $day=>$diff){
                                                $isDisabled = '';
                                                $isSelected = '';

                                                if($diff<0){
                                                    $isDisabled = 'disabled';
                                                }
                                                if($selectedDate==$day){
                                                    $isSelected = 'selected';
                                                }
                                                echo "<option $isSelected ".$isDisabled." value='".$day."'>".$day."</option>";
                                            }
                                        }
                                    ?>
                                   

                                </select>
                                <!-- Error show  -->
                             <?php
                                if(isset($selectedDateError)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $selectedDateError ?>
                                     </div> 
                                    <?php
                                        }
                                ?>
                               
                            </div>
                        </div>


                        <div class="checkout__body__left__step__sub checkout-select-time">
                            <div class="checkout-title checkout-select-time__title">
                                 Time of Collection :
                            </div>
                            <div class="checkout-desc">
                                Select the time of collection
                            </div>
                            <div class="checkout-body checkout-select-time__body">
                              
                                    
                                    
                                <label for="morning">
                                <div class="checkout-select-time__body__card" >
                                <input type="radio"
                                <?php
                                    if(isset($selectedTime) && $selectedTime=="morning")
                                    echo "checked";
                                ?>
                                 name="timing" value="morning" id="morning"> 6:00 - 12:00
                                </input>
                               </div>
                               </label>

                               <label for="afternoon">
                                <div class="checkout-select-time__body__card" >
                                <input type="radio"
                                <?php
                                    if(isset($selectedTime) && $selectedTime=="afternoon")
                                    echo "checked";
                                ?>
                                 name="timing" value="afternoon" id="afternoon"> 12:00 - 3:00
                                </input>
                               </div>
                               </label>

                               <label for="evening">
                                <div class="checkout-select-time__body__card" >
                                <input type="radio"
                                <?php
                                    if(isset($selectedTime) && $selectedTime=="evening")
                                    echo "checked";
                                ?>
                                 name="timing" value="evening" id="evening"> 3:00 - 6:00
                                </input>
                               </div>
                               </label>

                                   <!-- Error show  -->
                             <?php
                                if(isset($selectedTimeError)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $selectedTimeError ?>
                                     </div> 
                                    <?php
                                        }
                                ?>



                            </div>

                            <div class="checkout-buttons">
                               
                                <input type="submit" value="Back to Cart" name="goToCart" class="btn  clear-btn desktop-view"/>
                                  
                               
                                
                                <input type="submit" class="btn  clear-btn mobile-view"  value="Back" name="goToCart" />
                                    
                                
                                <input type="submit" value=" Confirm & Continue"  class="btn primary-btn  desktop-view" name="submitPickDetails"/>
                                  
                                <input  type="submit" value=" Confirm "   class="btn primary-btn  mobile-view" name="submitPickDetails"/>
                  

                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="checkout__body__left__step checkout__body__left__step--two 
                    <?php
                    if(!(isset($isStepOneCompleted) && $isStepOneCompleted))
                        echo "checkout__body__left__step--disabled";
                    ?>
                    ">
                        
                        <div class="checkout-wrapper
                        <?php
                    if(!(isset($isStepOneCompleted) && $isStepOneCompleted))
                        echo "checkout-wrapper--disabled";
                    ?>
                         ">
                            <div class="checkout__body__left__step__heading">
                                Payment
                            </div>
                            <div class="checkout__body__left__step__desc">
                                This is the field where you will be payment.
                            </div>
                            <label for="paypal">
                            <div class="checkout-payment-card">
                                <input type="radio" name="payment" id="paypal">
                               
                                </input>
                            </div>
                            </label>

                            <div class="checkout-buttons">

                            <a href="cart.php">
                                <button class="btn  clear-btn">
                                    Cancel
                                </button>
                                </a>
                                
                                <!-- <form method="POST" >
                                <input type="submit" value=" Proceed to Payment"  class="btn primary-btn  desktop-view" name="paymentsubmit"/>
                                  
                                <input  type="submit" value="Payment"   class="btn primary-btn  mobile-view" name="paymentsubmit"/>
                                </form> -->
                                <a href="checkout.php?collectionSlot=<?php echo $selectedDate ?>&timing=<?php echo $selectedTime?>&payment=true">
                                <button  class="btn primary-btn  desktop-view" name="paymentsubmit">
                                    Proceed to Payment
                                </button>
                                </a>
                                <button  class="btn primary-btn  mobile-view" name="paymentsubmit">
                                     Payment
                                </button>

                               

                            </div>
                        </div>
                        
                    </div>

                </div>
</body>
</html>















