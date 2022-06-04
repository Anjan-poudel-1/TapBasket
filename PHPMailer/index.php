<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'shahirabina652@gmail.com';                     //SMTP username
    $mail->Password   = 'pvuqycpoyfymxhan';                               //SMTP password
    $mail->SMTPSecure = 'tls';
    
    $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('shahirabina652@gmail.com', 'Rabina');
    $getemail="select EMAIL from USERS where USER_ID=$userId";
    $emailid=(oci_parse($conn,$getemail));
    oci_execute($emailid, OCI_NO_AUTO_COMMIT);  
    oci_commit($conn);
   
    //Here $res is the response fetched..... 
    $count= oci_fetch_all($emailid,$res);
   
    if ($count==1) {
        foreach ($res as $key => $value) {
            if($key=="EMAIL"){
                $email=$value[0];
            }
        }
    }
  
    $mail->addAddress($email);   //Add a recipient

    $mail->addReplyTo("shahirabina652@gmail.com", "Rabina");
      
    $emailUSer = "Select USERNAME,EMAIL from USERS WHERE USER_ID=$userId";
    $stidEmail=(oci_parse($conn,$emailUSer));
    oci_execute($stidEmail,OCI_DEFAULT);  
    while (($rowname = oci_fetch_object($stidEmail))) {
        $username= $rowname->USERNAME;
        
    }
    //Content
    $mail->isHTML(true);    
    $mail->Subject = 'TAPBASKET INVOICE';
  
    $sqlEmailSelect="SELECT distinct (p.PRODUCT_NAME), sum(QUANTITY) as Quantity, o.PRODUCT_ID FROM ORDERLIST o, PRODUCT p WHERE o.PRODUCT_ID=p.PRODUCT_ID AND o.product_id=o.product_id AND o.ORDERPLACE_ID=$orderId group by o.PRODUCT_ID,p.PRODUCT_NAME";
    $stiEmailSelect=oci_parse($conn,$sqlEmailSelect);
    oci_execute($stiEmailSelect,OCI_NO_AUTO_COMMIT);  

 
   $mail->Body="
   <h3 style='text-align: center; font-size: 20px;'>Thank you <b style='text-transform: uppercase;'>$username</b> for Choosing TapBasket<br>Here is your Invoice Detail </h3>
  
   <h1 style='font: bold 100% sans-serif; padding:10px; width:100%; text-align: center; text-transform: uppercase;background-color:#E1A825; color:white; font-size: 18px;'>Invoice Details</h1>
<br>
    <table border=1 style='border-collapse: collapse; width:70%; text-align:center;margin-right:auto;margin-left:auto; font-size: 15px;'>
    <thead>
        <tr style=' color:white; background-color:#E1A825; font-weight:bold;'>
        <th style=' padding: 15px;'>Product Name</th>   
        <th style=' padding: 15px;'>Quantity</th>
        <th style=' padding: 15px;'>Price</th>
        </tr>   
    </thead>
    <tbody>
   
    ";
    $totalPrice=0;
     while($row=oci_fetch_array($stiEmailSelect, OCI_ASSOC+OCI_RETURN_NULLS)){
        
        $disselect='select DISCOUNT_RATE from DISCOUNT where product_id='.$row['PRODUCT_ID'];
        $stidis=oci_parse($conn,$disselect);
        oci_execute($stidis,OCI_NO_AUTO_COMMIT); 

        // $discount=0;
        while($disrow=oci_fetch_array($stidis,OCI_ASSOC+OCI_RETURN_NULLS)){
        $discount=0;
        $discount=$disrow['DISCOUNT_RATE'];
        // echo $row['PRODUCT_ID'];
        // echo $discount;

        $selectprice='select price from Product where product_id='.$row['PRODUCT_ID'];
        $stiPrice=oci_parse($conn,$selectprice);
        oci_execute($stiPrice,OCI_NO_AUTO_COMMIT); 
        
        while($rows=oci_fetch_array($stiPrice, OCI_ASSOC+OCI_RETURN_NULLS)){
            $priceWithdiscount=($rows['PRICE']*$row['QUANTITY'])-($discount*$row['QUANTITY']);
            $totalPrice=$totalPrice+$priceWithdiscount;
             $mail->Body .="  <tr>
            <td style=' padding: 15px;'>".$row['PRODUCT_NAME']."</td>
            <td style=' padding: 15px;'>".$row['QUANTITY']."</td>
            <td style=' padding: 15px;'>".$priceWithdiscount."</td>
            </tr>
          ";  
        }  
    }  
           }
        

        $mail->Body .="
        <tr>
        <td colspan='3' style='padding: 15px;'>Total price =&nbsp; £".$totalPrice."</td>
        </tr>
        </tbody>
        </table>
        <p style='text-align: center;'><b>We will look forward to serve you again... HAPPY SHOPPING<b></p>
        
        ";
        // <img src='./dark_logo.jpeg' alt='Logo' width='100' height='100' style='margin-left: auto;
        // margin-right: auto;'>
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";


    
}