<?php 
$myordersql= "SELECT * FROM ORDERPLACE 
            WHERE ORDERPLACE.USER_ID = $user_id
            ORDER BY ORDERPLACE_ID DESC"; 
            
$orderStid = oci_parse($conn, $myordersql);
oci_execute($orderStid);
$orderRows = oci_fetch_all($orderStid, $orderRes);


?>
  
  <div class="order-history-description">
            Your order history and purchase information    
        </div>

        
        
            <?php 
            for ($j=0; $j<$orderRows; $j++){
            
            ?>
            <div class="order-history">
               <div class="order-history__details">
                   <table class="order-history__details__table" >
                       <tr>
                           <th>Order No</th>
                           <th> Status</th>
                           <th> Total</th>
                           <th> Collection Date</th>
                           <th> Collection Slot</th>
                       </tr>

                       <tr>
                           <td><?php echo $orderRes['ORDERPLACE_ID'][$j]?></td>
                           <td><?php
                           if($orderRes['PAYMENT_STATUS'][$j]=="true")
                           {
                               echo 'Completed';
                           }else{
                               echo 'Incomplete';
                           }
                            ?> </td>
                           <td> £
                               <?php
                               echo $orderRes['SUBTOTAL'][$j]
                               ?>
                           </td>
                           <td> <?php
                               echo $orderRes['DATE_OF_COLLECTION'][$j]
                               ?></td>
                           <td> <?php
                            switch ($orderRes['TIMESLOT'][$j]) {
                                case "morning": 
                                    echo '6:00 - 12:00';
                                    break;
                                
                                case "afternoon":
                                    echo '12:00 - 13:00';
                                    break;
                                
                                case "evening":
                                    echo "15:00 - 18:00";
                                    break;
                            } ?></td>
                       </tr>

                   </table>
                   <table class="order-history__details__smallTable" >
                       <tr>
                           <th>Order No</th> 
                           <td><?php echo $orderRes['ORDERPLACE_ID'][$j]?></td>
                        </tr>
                        <tr>
                           <th> Status</th> 
                           <td><?php
                           if($orderRes['PAYMENT_STATUS'][$j]=="true")
                           {
                               echo 'Completed';
                           }else{
                               echo 'Incomplete';
                           }
                            ?> </td>
                        </tr>
                        <tr>
                           <th> Total</th> 
                           <td> £
                               <?php
                               echo $orderRes['SUBTOTAL'][$j]
                               ?>
                           </td>
                        </tr>
                        <tr>
                           <th> Collection Date</th>
                           <td> <?php
                               echo $orderRes['DATE_OF_COLLECTION'][$j]
                               ?></td>
                        </tr>
                           <th> Collection Slot</th>
                           <td> <?php
                            switch ($orderRes['TIMESLOT'][$j]) {
                                case "morning": 
                                    echo '6:00 - 12:00';
                                    break;
                                
                                case "afternoon":
                                    echo '12:00 - 13:00';
                                    break;
                                
                                case "evening":
                                    echo "15:00 - 18:00";
                                    break;
                            } ?></td>
                       </tr>

                   </table>
               </div>
                    
                 
                <div class="showorder">
                    
                    <a href="./invoice.php?order-id=<?php echo $orderRes['ORDERPLACE_ID'][$j]; ?>" 
                   >View Invoice</a>
                               
                </div>
            </div>
            <?php
            }
            ?>
          
        
            
