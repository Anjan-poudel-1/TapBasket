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
  $mail->Username   = 'certifyapp092@gmail.com';                     //SMTP username
  $mail->Password   = 'yfjzdzvmvtqkijka';                               //SMTP password
  $mail->SMTPSecure = 'tls';

  $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  $mail->setFrom('certifyapp092@gmail.com', 'CertifyApp');

  $mail->addAddress($email);   //Add a recipient

  $mail->addReplyTo("certifyapp092@gmail.com", "CertifyApp");

  $emailUSer = "Select USERNAME from USERS WHERE EMAIL=$email";
  $stidEmail = (oci_parse($conn, $emailUSer));
  oci_execute($stidEmail, OCI_DEFAULT);
  while (($rowname = oci_fetch_object($stidEmail))) {
    $username = $rowname->USERNAME;
  }
  //Content
  $mail->isHTML(true);
  $mail->Subject = 'Verify your account';

  $mail->Body = "
   <h3 style='text-align: center; font-size: 20px;'>Thank you <b style='text-transform: uppercase;'>$username</b><br>Here is your One Time Password </h3>
  
   <h1 style='font: bold 100% sans-serif; padding:10px; width:100%; text-align: center; text-transform: uppercase;background-color:#E1A825; color:white; font-size: 18px;'>$vcode</h1>
        <p style='text-align: center;'><b>We will look forward to serve you again... HAPPY SHOPPING<b></p>     
        ";


  if ($mail->send()) {
    echo "Email sent";
  }
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
