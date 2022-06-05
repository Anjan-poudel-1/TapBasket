<?php 
include './connection.php';
$invoicesql= "SELECT * FROM ORDERPLACE 
            INNER JOIN USERS ON ORDERPLACE.USER_ID= USERS.USER_ID           
            WHERE ORDERPLACE_ID=". $_GET['order-id'] ." 
            ORDER BY ORDERPLACE_ID DESC"; 
$result=oci_parse($conn, $invoicesql);
        oci_execute($result);
        $row=oci_fetch_array($result);

     $user_id = $_SESSION['user_id'];
 ?>          

    <div class="customer-section">
        <div class="container page__body">
            <div class="invoice-print">
                <div class="section__header"> 
                    <div class="section__header__heading"> 
                        Invoice 
                    </div>  
                </div>
                <div class="invoice-headings">
                    <div class="invoice-headings__subheading">   
                        Order Number: 
                     </div>
                    <div class="invoice-headings__number"> 
                        <?php
                        echo $row['ORDERPLACE_ID'];
                        ?>
                    </div>
    
                </div>
                
                 <!--Customer Details Section-->
                <div class="detail-body-section">
                    <div class="invoice-subheading">   
                        Customer Details 
                    </div>
                    
                    <div class="details-section">
                        <div class="details-section__body">
                            <div class="invoice-customer-section__heading headingbold">
                                Customer Name: 
                            </div>
                            <div class="invoice-customer-section__description">
                            <?php
                            echo $row['USERNAME'];
                            ?>
                            </div>
                        </div>

                        <div class="details-section__body">
                            <div class="invoice-customer-section__heading headingbold">
                                Customer Email: 
                            </div>
                            <div class="invoice-customer-section__description">
                                <?php
                                echo $row['EMAIL'];
                                ?>
                                
                            </div>
                        </div>

                        <div class="details-section__body">
                            <div class="invoice-customer-section__heading headingbold">
                                Customer Contact Number: 
                            </div>
                            <div class="invoice-customer-section__description">
                                <?php
                             echo $row['PHONE_NO'];
                                ?>
                            
                            </div>
                        </div>

                    </div>  
                </div>
<?php
$detailsql= "SELECT * FROM ORDERLIST
            INNER JOIN PRODUCT ON ORDERLIST.PRODUCT_ID= PRODUCT.PRODUCT_ID 
            WHERE ORDERLIST.ORDERPLACE_ID=". $_GET['order-id'];
$stid = oci_parse($conn, $detailsql);
oci_execute($stid);
$nrows = oci_fetch_all($stid, $res);

$paymentsql="SELECT * FROM ORDERPLACE WHERE ORDERPLACE_ID=".$_GET['order-id'];
$paymentstid= oci_parse($conn, $paymentsql);
oci_execute($paymentstid);
while (oci_fetch($paymentstid)) {
    $paymentstatus = oci_result($paymentstid, 'PAYMENT_STATUS'); 
}

?>
                <!--Order Details Section-->
                    <div class="invoice-subheading">
                        Order Details
                    </div>
                    <div class="order-payment-container">
                    <div class="order-details">
                        <div class="order__body__right">
                            <div class="order__body__right__body">

                            <?php 
                            $total= 0;
                            for ($j = 0; $j < $nrows; $j++){
                                $productid =$res['PRODUCT_ID'][$j];
                                $name =$res['PRODUCT_NAME'][$j];
                                $image =$res['PRODUCT_IMAGE'][$j];
                                $price =$res['PRICE'][$j];
                                $quantity =$res['QUANTITY'][$j];
                                
                                
                            ?>
                                <div class="invoice-product-card">
                                    <div class="invoice-product-card__left">
                                        <div class="invoice-product-card__left__image">
                                            <img src="assets/images/ProductImage/<?php echo $image;?>"/>
                                        </div>
                                        <div class="invoice-product-card__left__desc">
                                            <div class="checkout-product-card__left__desc__name">
                                            <?php 
                                            echo $name;
                                            ?>
                                            </div>
                                            <div class="invoice-product-card__left__desc__rate">
                                             £
                                    
                                            <?php
                                            $oldPrice=$res['PRICE'][$j];
                                            $discountPrice=0;
                                            $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$productid";
                                            $stidDiscount = oci_parse($conn, $stidDiscount);
                                                    oci_execute($stidDiscount);
                                                    while (oci_fetch($stidDiscount)) {
                                                        $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');               
                                                        }
                                            if($discountPrice>0){?><i><strike><?php echo $oldPrice; 
                                                ?></strike></i> <?php echo ($oldPrice-$discountPrice); 
                                            }else{ echo $price;}
                                            ?>
                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-product-card__right">
                                        <div class="invoice-product-card__right__quantity">
                                            x 
                                        <?php 
                                        echo $quantity;
                                        ?>
                                        </div>
                                        <div class="invoice-product-card__right__total">
                                        £
                                        <?php
                                        $subtotal=($price-$discountPrice)*$quantity;  
                                        echo number_format(($subtotal),2);
                                        $total+= $subtotal; 
                                        ?>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                            }
                            ?>
                                

                                <div class="order__body__right__subtotal">
                                    <div class="order__body__right__subtotal__title">
                                        Sub Total
                                    </div>
                                    <div class="order__body__right__subtotal__price">
                                     £
                                     <?php
                                     echo $total; 
                                     ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <!--Payment Details Section-->
                <div class="order-details">
                    <div class="invoice-subheading">
                        Payment Details
                    </div>
                    <div class="payment-details">
                        <div class="payment-details__subheading">
                            Order Total
                        </div>
                        <div class="payment-details__number"> 
                        £
                        <?php
                         echo $total; 
                         ?>            
                        </div>
                    </div>
                    
                    <div class="invoice-paymentmode">
                        <?php 
                        
                        if ($paymentstatus =="true"){
    
                            echo "Paid Via PayPal";
                        }
                        else{?>
                        <span style="color:red;">Order Cancelled </span>
                        <?php 

                        }?>
                        
                    </div>
                </div>
            </div>

<?php
 $date= $row['DATE_OF_COLLECTION'];
 $time= $row['TIMESLOT'];
 
?>


            <!--Collection Details Section-->
            <div class="detail-body-section">
                <div class="invoice-subheading">   
                    Collection Details 
                 </div>
                
                <div class="details-section">
                    <div class="details-section__body">
                        <div class="invoice-customer-section__heading headingbold">
                            Date of Collection: 
                        </div>
                        <div class="invoice-customer-section__description">
                            <?php
                            echo $date; 
                            ?>
                        </div>
                    </div>

                    <div class="details-section__body">
                        <div class="invoice-customer-section__heading headingbold">
                            Time of Collection: 
                        </div>
                        <div class="invoice-customer-section__description">
                            <?php
                            switch ($time) {
                                case "morning": 
                                    echo '6:00 - 12:00';
                                    break;
                                
                                case "afternoon":
                                    echo '12:00 - 13:00';
                                    break;
                                
                                case "evening":
                                    echo "15:00 - 18:00";
                                    break;
                            }

                            ?>
                        </div>
                    </div>

                    <div class="details-section__body">
                        <div class="invoice-customer-section__heading headingbold">
                            Collection Location: 
                        </div>
                        <div class="invoice-customer-section__description">
                           Cleckhudderfax Central, Cleckhudderfax, Leeds, United Kingdom
                        </div>
                    </div>

                </div>  
            </div>
        </div>
            

            

            
            

           

            <!--Location-->
            <div class="invoice-subheading">   
                Collect your Order at:
             </div>
            <div class="location-section">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4214.166951628822!2d-1.7896147353595446!3d53.64481247373158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487962132bcdb7bb%3A0x653c3a498c896a17!2sHuddersfield%2C%20UK!5e0!3m2!1sen!2snp!4v1649555480070!5m2!1sen!2snp"  height="200" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
                
            
                
               

                
                    
                

        </div>
    </div>
  