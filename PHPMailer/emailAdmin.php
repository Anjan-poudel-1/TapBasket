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

    $mail->setFrom('shahirabina652@gmail.com', 'Rabina');

    $mail->addAddress('tapbasket1@gmail.com');   //Add a recipient

    $mail->addReplyTo("tapbasket1@gmail.com", "TapBasket");
    //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Veryfy New Trader Account';
  
     $mail->Body="
   <h1 style='font: bold 100% sans-serif; padding:10px; width:50%;  text-transform: uppercase;background-color:#E1A825; color:white; font-size: 18px;'>You Have new shop request</h1> 
   
   <p style=' font-size: 18px;'>Trader name: $Tname</p>
   <p style=' font-size: 18px;'>Shop name:  $shopname</p>
   <p style=' font-size: 18px;'>Product type:  $product</p>  
   <p style=' font-size: 18px;'>Purposal mesage:  $desc</p> 
   <a href='http://localhost/TapBasket/phpMailer/AdminRequestApprove.php?email=".$Temail."&name=".$Tname."'>Approve Request</a>



        ";

  if($mail->send()){
    echo "Email sent";
  }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";


    // <form method='POST' action=''>
    // <input  style=' padding: 15px 32px;
    // text-align: center; background-color:#E1A825; color:white;  border: none;border-radius: 12px; ' type='submit' value='Verify account' name='verifytraderaccount' class='btn primary-btn form-btn' />
    // </form>
}