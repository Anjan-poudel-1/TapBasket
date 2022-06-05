<?php
session_start();
if((isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']===True) ){

    header ('location:index.php');
}
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
        $sql = "SELECT * FROM USERS WHERE email = '$email' AND password ='$password' AND IS_DISABLED='false'";

        $stid=(oci_parse($conn,$sql));
        oci_execute($stid, OCI_NO_AUTO_COMMIT);  
        oci_commit($conn);
       
        //Here $res is the response fetched..... 
        $count= oci_fetch_all($stid,$res);
   
       
        if ($count==1) {
            foreach ($res as $key => $value) {
                if($key=="USER_ID"){
                    $user_id=$value[0];
                }
                if($key=="USER_ROLE"){
                    $_SESSION['role'] = $value[0];
                }
            }
            $_SESSION['isAuthenticated']=true;
            $_SESSION['user_id']=$user_id;
            $passworderr = "";
            $emailerror = "";

            //Here set up the cart after logging in.... 

            $sql="SELECT * FROM CARTLIST WHERE USER_ID=$user_id";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);

            $nrows = oci_fetch_all($stid, $res);

            for ($i = 0; $i < $nrows; $i++) {
                $product_id = $res['PRODUCT_ID'][$i];
                $quantity= $res['QUANTITY'][$i];

                //If the item is already in the cart, we update the item from cartlist
                if(isset($_SESSION['cart'][$product_id])){
                    $updateCartListSql ="UPDATE CARTLIST 
         
                    SET QUANTITY=:quantity
                  
                   WHERE USER_ID=$user_id AND PRODUCT_ID=$product_id" ;
                    $stidUpdate = oci_parse($conn,$updateCartListSql);
                    oci_bind_by_name($stidUpdate, ':quantity', $_SESSION['cart'][$product_id]);
                    oci_execute($stidUpdate, OCI_COMMIT_ON_SUCCESS);
                }
                else{
                    $_SESSION['cart'][$product_id] = $quantity;
                    $insertCartListSql ="INSERT INTO  CARTLIST() VALUES()";
                    
                    $stidinsert = oci_parse($conn,$insertCartListSql);
                    oci_bind_by_name($stidinsert, ':quantity', $_SESSION['cart'][$product_id]);
                    oci_execute($stidinsert, OCI_COMMIT_ON_SUCCESS);
                }

            }

            header ('location:index.php');
        }else {
            $_SESSION['isAuthenticated']= false;
            $passworderr = "Invalid Credential";
        }
        oci_free_statement($stid);
        oci_close($conn);
  }
}

if(isset($_POST['signup'])){
    header('location:registeruser.php');
}

if(isset($_POST['registerastrader'])){
    header('location:registerTrader.php');
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
                        <a href="forgetPassword.php">
                            <div>
                                Forgot password?
                            </div>
                    </a>
                        </div>
                    
                        
                    </div>

                    <div class="login-form__content__login">
                        <input type="submit" value="Login" name="LoginSubmit" class="btn primary-btn form-btn"/>
                         
                    </div>

       
                    <div class="login-form__content__signup flex_container">
                                <div>
                                    <p class="button-desc">
                                        User Account
                                    </p>

                                    <!-- Go to login page -->

                                
                            <input type="submit" value="User Register" class="btn primary-btn form-btn login-form__content__login" name="signup">
                        
                                    
                                   
                                </div>
                                <div>
                                    <p class="button-desc">
                                        Sell Product on TapBasket?
                                    </p>

                                    <input type="submit" value="Register as Trader" class="btn primary-btn form-btn login-form__content__login" name="registerastrader">
                                   
                                  
                                    
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