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


if(isset($_GET['email']) && isset($_GET['name'])){
   
    $Temail = $_GET['email'];

    $Tname=$_GET['name'];
    $PASSWORD='Password1';

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

    $mail->addAddress($Temail);   //Add a recipient

    $mail->addReplyTo("shahirabina652@gmail.com", "Rabina");
    //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Trader Account';
  
     $mail->Body="
   <h1 style='font: bold 100% sans-serif; padding:10px; width:50%; text-align: center; text-transform: uppercase;background-color:#E1A825;color:white; font-size: 18px;'>Trader Registration Successfull</h1>
   <P style=' font-size: 15px;'>Dear $Tname,<br>
   Your Registration as a trader has been accepted.<br> 
   Credentials are provided below:</P> 
   
    <p style=' font-size: 15px;'>Trader email: $Temail</p>
   <p style=' font-size: 15px;'>Password: $PASSWORD</p>
   <p style=' font-size: 15px;'> You will be able to change your password once you log in to our interface.</p> 
   <p style=' font-size: 15px;'> Thank You,<br>
   TapBasket</p>
         ";

 
  if($mail->send()){
    echo "You have accepted this email address";
    
    header("location:../updateuser.php?email=$Temail");
  }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}
    
}