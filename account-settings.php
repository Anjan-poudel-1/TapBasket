<?php
SESSION_START();
include("connection.php");

if(!(isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']===true) ){

    header ('location:index.php');
}


?>

<?php

$email = '';
$userName='';
$phone='';
$gender='';
$dob='';
$userImage ='';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM USERS WHERE USER_ID=$user_id";
$stid = oci_parse($conn,$sql );
oci_execute($stid);



while (($row = oci_fetch_object($stid)) != false) {
    // Use upper case attribute names for each standard Oracle column
    $userName=  $row->USERNAME ;
    $email =  $row->EMAIL; 
    $phone=$row->PHONE_NO;
    $gender =$row->GENDER;
    $dob=$row->DOB;
    $userImage= $row->USER_IMAGE;
   
    $date=date_create($dob);
    $dob= date_format($date,'Y-m-d');
    
}

  if(isset($_POST['userProfileUpdate'])){
    $email = $_POST['email'];
    $userName=trim($_POST['userName']);
    $phone=trim($_POST['phoneNumber']);
    $gender=trim($_POST['gender']);
    $dob=trim($_POST['dob']);
    $errCount=0;


    // $password = $_POST['password'];
    // $newPassword = $_POST['newPassword'];
    // $confirmPassword = $_POST['confirmPassword'];

    // if(empty(trim($password))){
    //     $passworderr = "Please enter password";
    // }
    // if(empty(trim($newPassword))){
    //     $passworderr = "Please enter new password";
    // }


    // if($newPassword!=$confirmPassword){
    //     $confirmPassworderr="please must match";
    // }

    if(empty(trim($email))){
        $emailerror = "Please enter email";
        $errCount++;
    }
    else{
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailerror = "Invalid email";
            $errCount++;
        }
    }
    if(empty(trim($dob))){
        $doberr = "Please provide DOB";
        $errCount++;
    }
    if(empty(trim($gender))){
        $gendererr = "Please select your gender";
        $errCount++;
    }


    if(empty($userName)){
        $userNameerr="Please enter your name";
        $errCount++;
    }

    if(empty($phone)){
        $phoneNumbererror="Please enter phone number";
        $errCount++;
    }
    if(empty($gender)){
        $gendererr="Please seslect your gender";
        $errCount++;
    }
    if(empty($dob)){
        $doberr="Please enter your DOB";
        $errCount++;
    }
    else{
        //check .. aja ko vanda pachi ko date ta haina?
        // $date=date_create($dob);
        // $dob= date_format($date,'YYYY-MM-DD');
    }


    if($errCount==0){
        //If  no errors... connect to database,, update data 

        $sqli="UPDATE USERS 
         
         SET username=:userName,email=:email,phone_no=:phone,gender=:gender,DOB=TO_DATE(:DOB,'YYYY-MM-DD')
       
        WHERE USER_ID=$user_id";

    $stid = oci_parse($conn,$sqli);
    oci_bind_by_name($stid, ':userName', $userName);
    oci_bind_by_name($stid, ':email', $email);
    oci_bind_by_name($stid, ':phone', $phone);
    oci_bind_by_name($stid, ':gender', $gender);
   
    oci_bind_by_name($stid, ':DOB', $dob);

    oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
    header ('location:account-settings.php');
    // echo("<script>location.href = 'http://localhost/TapBasket/account-settings.php'</script>");

    }




  }
?>

<?php

    if(isset($_POST['uploadfile'])){
        if(isset($_FILES['image-upload'])){
            $file_name = $_FILES['image-upload']['name'];
            $file_size = $_FILES['image-upload']['size'];
            $file_tmp = $_FILES['image-upload']['tmp_name'];

            $folder = "assets/images/profiles/".$file_name;

            if (move_uploaded_file($file_tmp, $folder))  {
                $msg = "Image uploaded successfully";
                $sqli="UPDATE USERS 
         
                SET user_image=:fileName
              
               WHERE USER_ID=$user_id";
       
           $stid = oci_parse($conn,$sqli);
           oci_bind_by_name($stid, ':fileName', $file_name);
           oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
           header ('location:account-settings.php');

            }else{
                $msg = "Failed to upload image";
          }


        }
    }



?>
<?php
  if(isset($_POST['userPasswordUpdate'])){
    $errCount=0;
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $sql= "SELECT * FROM USERS WHERE USER_ID=$user_id";
    $select = oci_parse($conn,$sql);
    oci_execute($select, OCI_NO_AUTO_COMMIT);
    $rows= oci_fetch_all($select,$res);

    foreach ($res as $key => $value) {
        if($key=="PASSWORD")
        $recentpass=$value[0];   
    }
    if(md5($password) != $recentpass){
        $passwordErr = "This password doesnot matches the previous password";
        $errCount++;
    }
    if(empty(trim($confirmPassword))){
        $confirmPasswordErr = "Please enter  password";
        $errCount++;
    }else if($newPassword!=$confirmPassword){
            $confirmPasswordErr="Password must match";
            $errCount++;
    }
    
    if(empty(trim($password))){
        $passwordErr = "Please enter password";
        $errCount++;
    }
    if(empty(trim($newPassword))){
        $newPasswordErr = "Please enter new password";
        $errCount++;
    }else if(!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $newPassword)) {
        $newPasswordErr="password must contain Minimum eight characters, at least one lowercase, one uppercase letter and one number";
        $errCount++;
    }

    if($errCount==0){
        $Passwordnew=md5($newPassword);
        $TraderPassword1=md5($newPassword);
        $sqli="UPDATE USERS 
        SET PASSWORD=:newpassword WHERE USER_ID='$user_id'";
          
         $stid = oci_parse($conn,$sqli);
         $temp=$_SESSION['role'];
         if($temp=='customer'){
            oci_bind_by_name($stid, ':newpassword', $Passwordnew);
         }else{
            oci_bind_by_name($stid, ':newpassword', $TraderPassword1);
         }
      
         oci_execute($stid, OCI_COMMIT_ON_SUCCESS); 
        //  echo '<script>alert("Password Changed")</script>'; 
        // header ('location:logout.php');

   
        echo "<script> alert('Password Changed');
        window.setTimeout(function(){
            window.location.href = 'logout.php';

        });
        </script>";
       
    }else{
        // echo "Couldnot enter the data in database";
    }

  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page user-dashboard-page">
    
        <!-- Primary nav -->
        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="user-dashboard">
                <?php
                 $pageName="settings";
                 $isCustomer &&
                include './components/pages/AccountSettings/userNavbar.php';
                
                ?>
                <div class="user-dashboard__content">
                
                    <div class="section__header">

                        <div class="section__header__heading">
                    
                            Account Settings
                    
                        </div>
                    
                    </div>
                   
                   <?php
                    include './components/pages/AccountSettings/personalDetails.php';
                   ?>

                    <div class="account-settings__reset">

                        <div class="section__header">

                            <div class="section__header__heading">
                        
                               Reset Password
                        
                            </div>
                        
                        </div>

                        <?php
                            include './components/pages/AccountSettings/resetPassword.php';
                        ?>

                        

                    </div>

                </div> 

            </div>
        </div>




    </div>

    <!-- Page Footers -->
    <?php
     
        include './components/resuables/page-footer.php';
    ?>

      <!-- Copyright  -->
      <?php
            include './components/resuables/copyright.php';
          ?>

          <!--Bottom Nav-->
          <?php
            include './components/navbars/bottom-navbar.php';
          ?>
    
</body>
<script src="app.js">
   
</script>

</html>