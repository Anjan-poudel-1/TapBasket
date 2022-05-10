<?php
session_start();
?>
<?php
include("connection.php");
  if(isset($_POST['LoginSubmit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty(trim($email))){
        $emailerror = "Please enter email";
    }
    else{
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailerror = "Invalid email";
        }
    }

    if(empty(trim($password))){
        $passworderr = "Please enter password";
    }

    if(!empty($email) && !empty($password)){
        $password=md5($password);
        $sql = "SELECT * FROM USERS WHERE email = '$email' AND password ='$password'";

        $stid=(oci_parse($conn,$sql));
        oci_execute($stid, OCI_NO_AUTO_COMMIT);  
        oci_commit($conn);
       
        $count= oci_fetch_all($stid,$sql);
        // $count=oci_num_rows($stid);
        if ($count==1) {
            $_SESSION['email']=$email;
            header ('location:index.php');
        }else {
            $_SESSION['error']= 'User not recognised';
            header ('location:login.php');
        }
        oci_free_statement($stid);
        oci_close($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page login-page">
    <?php 
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="login-form">
                <form  method="POST" action="">
                <div class="login-form__content">
                    <div class="login-form__content__header">
                        Log In
                    </div>
                    <div class="login-form__content__body">

                   

                        <div class="form-control">
                            <p class="form-control__label">
                                Email Address
                            </p>
                            <input 
                            class="form-control__input <?php 
                             if(isset($emailerror)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your email Address"
                             name="email"
                             value="<?php
                                    if(isset( $_POST['email'])){
                                        echo $_POST['email'];
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($emailerror)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $emailerror ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>

                        <div class="form-control">
                            <p class="form-control__label">
                                Password
                            </p>
                            <div class="form-control__password">
                                <input id="password-field" class="form-control__input form-control__input--password 
                                
                                <?php 
                             if(isset($passworderr)){
                                 echo " form-control__input--error";
                             }
                            ?>
                                
                                "
                                 placeholder="Enter your password"
                                  type="password"
                                  name="password"
                                  id="pass-input"
                                  value="<?php
                                    if(isset( $_POST['password'])){
                                        echo $_POST['password'];
                                    }
                                    ?>"
                                  
                                  />

                                  <!-- Error show  -->
                                  <?php
                                if(isset($passworderr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $passworderr ?>
                                     </div> 
                         <?php
                        }
                        ?>
                             
                                
                                <div class="pass-visibility" id="show-pass">
                                    SHOW
                                </div>
                                <div class="pass-visibility" id="hide-pass">
                                    HIDE
                                </div>
                            </div>
                            
                        </div>

                        <div class="login-form__content__body__other">

                            <div>
                               <input type="checkbox" id="remember-me"/> <span id="remember-me-text"> Remember me</span>
                            </div>
                            <div>
                                Forgot password?
                            </div>

                        </div>
                    
                        
                    </div>

                    <div class="login-form__content__login">
                        <input type="submit" value="Login" name="LoginSubmit" class="btn primary-btn form-btn"/>
                         
                    </div>

                    <div class="login-form__content__signup">
                            <div class="button-desc">
                                New to TapBasket?
                            </div>
                            
                            <!-- Go to registration page -->
                            
                            <button class="btn primary-btn form-btn">
                                Sign Up
                            </button>
                    </div>
                </div>
                </form>

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