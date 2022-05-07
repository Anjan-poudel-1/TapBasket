<?php
  if(isset($_POST['userPasswordUpdate'])){
    
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if(empty(trim($password))){
        $passwordErr = "Please enter password";
    }
    if(empty(trim($newPassword))){
        $newPasswordErr = "Please enter new password";
    }
    if(empty(trim($confirmPassword))){
        $confirmPasswordErr = "Please enter  password";
    }
    else{
        if($newPassword!=$confirmPassword){
            $confirmPasswordErr="Password must match";
        }
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
<div class="account-settings__reset__body">

<form method="POST" action="">

<div class="form-control">
<p class="form-control__label">
    Current Password
</p>
<input 
class="form-control__input <?php 
 if(isset($passwordErr)){
     echo " form-control__input--error";
 }
?>"
 placeholder="Enter your current password"
 name="password"
 type="password"
 value="<?php
        if(isset( $_POST['password'])){
            echo $_POST['password'];
        }
        ?>"
 />
 <!-- Error show  -->
 <?php
    if(isset($passwordErr)){
        ?>
        <div class="input-error"> 
        <?php echo $passwordErr ?>
         </div> 
        <?php
            }
    ?>

</div>

<div class="form-control">
<p class="form-control__label">
    New Password
</p>
<input 
class="form-control__input <?php 
 if(isset($newPasswordErr)){
     echo " form-control__input--error";
 }
?>"
 placeholder="Enter your full name"
 name="newPassword"
 type="password"
 value="<?php
        if(isset( $_POST['newPassword'])){
            echo $_POST['newPassword'];
        }
        ?>"
 />
 <!-- Error show  -->
 <?php
    if(isset($newPasswordErr)){
        ?>
        <div class="input-error"> 
        <?php echo $newPasswordErr ?>
         </div> 
        <?php
            }
    ?>

</div>

<div class="form-control">
<p class="form-control__label">
    Re-enter  password
</p>
<input 
class="form-control__input <?php 
 if(isset($confirmPasswordErr)){
     echo " form-control__input--error";
 }
?>"
 placeholder="Confirm password"
 name="confirmPassword"
 type="password"
 value="<?php
        if(isset( $_POST['confirmPassword'])){
            echo $_POST['confirmPassword'];
        }
        ?>"
 />
 <!-- Error show  -->
 <?php
    if(isset($confirmPasswordErr)){
        ?>
        <div class="input-error"> 
        <?php echo $confirmPasswordErr ?>
         </div> 
        <?php
            }
    ?>

</div>
<div class="account-settings__reset__body__button">
<input type="submit" value="Reset Password" name="userPasswordUpdate" class="btn primary-btn form-btn"/>

</div>
</form>

</div>
</body>
</html>