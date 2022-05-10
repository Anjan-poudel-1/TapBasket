<?php
$collectionDates = [];

$now = strtotime("now");
$end_date = strtotime("+2 weeks");

while (date("Y-m-d", $now) != date("Y-m-d", $end_date)) {
    $day_index = date("w", $now);
    if ($day_index == 0 || $day_index == 1|| $day_index == 2) {
        // Print or store the weekends here
        // echo date("F j, l", $now);
         $timeDiff =  abs(strtotime("+1 day"))-abs(strtotime(date("Y-m-d", $now))); 
        
       array_push($collectionDates,date("F j, l", $now));

      // print_r($collectionDates);
      // echo $timeDiff;

        // diffabs(strtotime("+1 day"))-abs(strtotime(date("Y-m-d", $now)))


    }
    $now = strtotime(date("Y-m-d", $now) . "+1 day");
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
<div class="checkout__body__left">
                    <div class="checkout__body__left__step">
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
                                <select>
                                    <option value="">
                                        ---- Select Date here ----
                                    </option>
                                    <!-- Loop the collectionDates here... -->
                                    
                                    <option value="">
                                        Jan 19, sunday
                                    </option>
                                    <option value="">
                                       Jan 19, thursday
                                    </option>
                                    <option value="">
                                       Jan 19, thursday
                                    </option>
                                    <option value="">
                                        Jan 19, thursday
                                    </option>
                                    <option value="">
                                        Jan 19, thursday
                                    </option>
                                    <option value="">
                                        Jan 19, thursday
                                    </option>

                                </select>
                               
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
                               <div class="checkout-select-time__body__card">
                                    <input type="radio" name="timing">
                                    6:00 - 12:00
                                    </input> 
                               </div>

                               <div class="checkout-select-time__body__card">
                                <input type="radio" name="timing">
                                6:00 - 12:00
                                </input> 
                           </div>

                           <div class="checkout-select-time__body__card">
                            <input type="radio" name="timing">
                            6:00 - 12:00
                            </input> 
                       </div>
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
                                <button  class="btn primary-btn disabled-btn desktop-view" >
                                    Confirm & Continue
                                </button>
                                <button  class="btn primary-btn disabled-btn mobile-view" >
                                    Confirm
                                </button>


                            </div>
                        </div>

                    </div>
                    <div class="checkout__body__left__step checkout__body__left__step--two checkout__body__left__step--disabled">
                        
                        <div class="checkout-wrapper checkout-wrapper--disabled">
                            <div class="checkout__body__left__step__heading">
                                Payment
                            </div>
                            <div class="checkout__body__left__step__desc">
                                This is the field where you will be payment.
                            </div>
                            <div class="checkout-payment-card">
                                <input type="radio" name="payment">
                                Paypal
                            </input>
                                
    
                            </div>

                            <div class="checkout-buttons">

                                <button class="btn  clear-btn">
                                    Cancel
                                </button>
                                <button  class="btn primary-btn disabled-btn desktop-view" >
                                    Proceed to Payment
                                </button>
                                <button  class="btn primary-btn disabled-btn mobile-view" >
                                     Payment
                                </button>

                            </div>
                        </div>
                        
                    </div>

                </div>
</body>
</html>