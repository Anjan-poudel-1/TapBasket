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