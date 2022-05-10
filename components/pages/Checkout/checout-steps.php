<?php
$collectionDates = [];

$now = strtotime("now");
$end_date = strtotime("+2 weeks");

while (date("Y-m-d", $now) != date("Y-m-d", $end_date)) {
    $day_index = date("w", $now);
    if ($day_index == 0 || $day_index == 1|| $day_index == 2) {
        // Print or store the weekends here
        // echo date("F j, l", $now);
         $timeDiff =  abs(strtotime(date("Y-m-d", $now)))-abs(strtotime("+1 day")); 

       array_push($collectionDates,[date("F j, l", $now)=>$timeDiff]);


    }
    $now = strtotime(date("Y-m-d", $now) . "+1 day");
}

// print_r($collectionDates);


if(isset($_POST['submitPickDetails'])){

    $selectedDateError ='';
    $selectedTimeError ='';
    $selectedDate = '';
    $selectedTime = '';
    $isStepOneCompleted=false;
    $errCount=0;

    if(isset($_POST['dateSelected']) && $_POST['dateSelected']){
        $selectedDate = $_POST['dateSelected'];
    }
    else{
        $errCount=1;
        $selectedDateError ='Please select the date';
    }

    if(isset($_POST['timing'])){
        $selectedTime = $_POST['timing'];
    }
    else{
        $errCount=1;
        $selectedTimeError ='Please select the timing';
    }

    if( $errCount==0){
        $isStepOneCompleted=true;
    }

}
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
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero totam ad optio quo ipsum molestias in 
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
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero totam ad optio quo ipsum molestias in 
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
                                <a href="cart.php">
                                <button class="btn  clear-btn desktop-view">
                                    Back to cart
                                </button>
                                </a>
                                <a href="cart.php">
                                <button class="btn  clear-btn mobile-view">
                                    Back
                                </button>
                                </a>
                                <input type="submit" value=" Confirm & Continue"  class="btn primary-btn  desktop-view" name="submitPickDetails">
                                  
                                </input>
                                <input  type="submit" value=" Confirm "   class="btn primary-btn  mobile-view" name="submitPickDetails">
                                    
                                </input>


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
                                <button  class="btn primary-btn  desktop-view" >
                                    Proceed to Payment
                                </button>
                                <button  class="btn primary-btn  mobile-view" >
                                     Payment
                                </button>

                            </div>
                        </div>
                        
                    </div>

                </div>
</body>
</html>