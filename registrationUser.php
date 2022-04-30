<?php
  if(isset($_POST['userRegisterSubmit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rpassword = $_POST['Rpassword'];
    $fname=trim($_POST['fname']);
    $lname=trim($_POST['lname']);
    $phone=trim($_POST['phone']);

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

    if($password!=$rpassword){
        $rpassworderr="please recheck the password";
    }

    if(empty($fname)){
        $fnameerr="Please enter first name";
    }

    if(empty($lname)){
        $lnameerr="Please enter last name";
    }
    if(empty($phone)){
        $phoneerr="Please enter phone number";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
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
                       Sign Up
                    </div>
                    <div class="login-form__content__body">

                       <div class="grid_container form-control">

                        <div>
                        <p class="form-control__label">First Name</p>
                            <input class="form-control__input <?php 
                             if(isset($fnameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="FirstName" name="fname"  value="<?php
                            if(isset( $_POST['lname'])){
                                echo $_POST['lname'];
                            }
                            ?>"/>
                             <?php
                                if(isset($fnameerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $fnameerr ?>
                                     </div> 
                                    <?php
                                        }
                                ?> 
                        </div>
                        <div>
                            <p class="form-control__label">Last Name</p>
                            <input class="form-control__input <?php 
                             if(isset($lnameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="LastName" name="lname"  value="<?php
                            if(isset( $_POST['lname'])){
                                echo $_POST['lname'];
                            }
                            ?>"/>
                             <?php
                                if(isset($lnameerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $lnameerr
                                     ?>
                                     </div> 
                                    <?php
                                        }
                                ?>
                        </div>        
                                
                        </div>        
                        

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
                                Phone Number
                            </p>
                            <input 
                            class="form-control__input <?php 
                             if(isset($phoneerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="+977" name="phone" value="<?php
                            if(isset( $_POST['phone'])){
                                echo $_POST['phone'];
                            }
                            ?>"/>
                            
                            <?php
                                if(isset($phoneerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $phoneerr ?>
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

                        <div class="form-control">
                            <p class="form-control__label">
                              Conform  Password
                            </p>
                            <div class="form-control__password">
                                <input id="password-field" class="form-control__input form-control__input
                                
                                <?php 
                             if(isset($rpassworderr)){
                                 echo " form-control__input--error";
                             }
                            ?>
                                
                                "
                                 placeholder="Re-enter password"
                                  type="password"
                                  name="Rpassword"
                                  id="pass-input"
                                  value="<?php
                                    if(isset( $_POST['Rpassword'])){
                                        echo $_POST['Rpassword'];
                                    }
                                    ?>"
                                  
                                  />

                                  <!-- Error show  -->
                                  <?php
                                if(isset($rpassworderr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $rpassworderr ?>
                                     </div> 
                         <?php
                        }
                        ?>
                                
                            
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
                        <input type="submit" value="Sign-Up" name="userRegisterSubmit" class="btn primary-btn form-btn"/>
                         
                    </div>

                    <div class="login-form__content__signup grid_container">
                    <div>
                            <p class="button-desc">
                               Already have an account?
                    </p><br>
                            
                            <!-- Go to registration page -->
                            
                            <button class="btn primary-btn form-btn">
                            Log-in
                                
                            </button>
                    </div>
                    <div>
                            <p class="button-desc">
                              Sell Product on TapBasket?
                    </p><br>
                            <button class="btn primary-btn form-btn">
                            Register as Trader
                                
                            </button>
                    </div>
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