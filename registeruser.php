<?php
$errorcount = 0;
include("connection.php");
$errCount = 0;
function generateNumericOTP($n)
{
    $generator = "1683579024";
    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    return $result;
}
if(isset($_POST['login'])){
    header('location:login.php');
}
if(isset($_POST['registerastrader'])){
    header('location:registerTrader.php');
}



if (isset($_POST['userRegisterSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rpassword = $_POST['Rpassword'];
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $pattern = "/^[\+0-9\-\(\)\s]*$/";


    if (!preg_match("/^[\+0-9\-\(\)\s]*$/", $phone)) {
        $phoneerr = "Please enter valid phone number";

        $errCount = 1;
    }
    if (empty(trim($email))) {
        $emailerror = "Please enter email";
        $errCount = 1;
    } else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailerror = "Invalid email";
            $errCount = 1;
        }
    }

    if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
        $passworderr = "Password must contain minimum eight characters, at least one lowercase, one uppercase letter and one number";
        $errCount = 1;
    }

    if (empty(trim($password))) {
        $passworderr = "Please enter password";
        $errCount = 1;
    }

    if ($password != $rpassword) {
        $rpassworderr = "Passwords do not match";
        $errCount = 1;
    }

    if (empty($fname)) {
        $fnameerr = "Please enter first name";
        $errCount = 1;
    }

    if (empty($lname)) {
        $lnameerr = "Please enter last name";
        $errCount = 1;
    }
    if (empty($phone)) {
        $phoneerr = "Please enter phone number";
        $errCount = 1;
    }
}
?>
<?php
include("connection.php");
if (isset($_POST['userRegisterSubmit'])) {
    $role = "customer";
    $IS_DISABLED = 'true';
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $vcode = generateNumericOTP(4);

    $fullname = $fname . " " . $lname;
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $select = oci_parse($conn, $sql);
    oci_execute($select, OCI_NO_AUTO_COMMIT);
    $rows = oci_fetch_all($select, $res);
    if ($rows > 0) {
        $emailerror = "this email already exist";
        $errCount = 1;
    } else {
        if ($errCount == 0) {
            $sqli = "INSERT INTO USERS(username,email,password,vcode,phone_no,user_role,IS_DISABLED) VALUES (:fullname,:email,:userpassword,:vcode,:phone_no,:userrole,:is_disable)";
            $stid = (oci_parse($conn, $sqli));
            oci_bind_by_name($stid, ":fullname", $fullname);
            oci_bind_by_name($stid, ":email", $email);
            oci_bind_by_name($stid, ":userpassword", $password);
            oci_bind_by_name($stid, ":is_disable", $IS_DISABLED);
            oci_bind_by_name($stid, ":phone_no", $phone);
            oci_bind_by_name($stid, ":userrole", $role);
            oci_bind_by_name($stid, ":vcode", $vcode);
            oci_execute($stid, OCI_NO_AUTO_COMMIT);
            oci_commit($conn);
            oci_free_statement($stid);
            oci_close($conn);

            if ($sqli) {
               include './PHPMailer/otpindex.php';
                $email = $_POST['email'];
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $select = oci_parse($conn, $sql);
                oci_execute($select, OCI_NO_AUTO_COMMIT);
                while ($row = oci_fetch_array($select, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    header("location:otp.php?id=" . $row['USER_ID']);
                }
            }
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
                <form method="POST" action="">
                    <div class="login-form__content">
                        <div class="login-form__content__header">
                            Sign Up
                        </div>
                        <div class="login-form__content__body">

                            <div class="flex_container form-control">

                                <div class="flex_item">
                                    <p class="form-control__label">First Name</p>
                                    <input class="form-control__input <?php
                                                                        if (isset($fnameerr)) {
                                                                            echo " form-control__input--error";
                                                                        }
                                                                        ?>" placeholder="FirstName" name="fname" value="<?php
                                                                            if (isset($_POST['fname'])) {
                                                                                echo $_POST['fname'];
                                                                            }
                                                                            ?>" />
                                    <?php
                                    if (isset($fnameerr)) {
                                    ?>
                                        <div class="input-error">
                                            <?php echo $fnameerr ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="flex_item">
                                    <p class="form-control__label">Last Name</p>
                                    <input class="form-control__input <?php
                                                                        if (isset($lnameerr)) {
                                                                            echo " form-control__input--error";
                                                                        }
                                                                        ?>" placeholder="LastName" name="lname" value="<?php
                                                                            if (isset($_POST['lname'])) {
                                                                                echo $_POST['lname'];
                                                                            }
                                                                            ?>" />
                                    <?php
                                    if (isset($lnameerr)) {
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
                                <input class="form-control__input <?php
                                                                    if (isset($emailerror)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Enter your email Address" name="email" value="<?php
                                                                                            if (isset($_POST['email'])) {
                                                                                                echo $_POST['email'];
                                                                                            }
                                                                                            ?>" />
                                <!-- Error show  -->
                                <?php
                                if (isset($emailerror)) {
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
                                <input class="form-control__input <?php
                                                                    if (isset($phoneerr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="+44" name="phone" value="<?php
                                                                        if (isset($_POST['phone'])) {
                                                                            echo $_POST['phone'];
                                                                        }
                                                                        ?>" />

                                <?php
                                if (isset($phoneerr)) {
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
                                if (isset($passworderr)) {
                                    echo " form-control__input--error";
                                }
                                ?>
                                
                                " placeholder="Enter your password" type="password" name="password" id="pass-input" value="<?php
                                                                                                                            if (isset($_POST['password'])) {
                                                                                                                                echo $_POST['password'];
                                                                                                                            }
                                                                                                                            ?>" />

                                    <!-- Error show  -->
                                    <?php
                                    if (isset($passworderr)) {
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
                                    Confirm Password
                                </p>
                                <div class="form-control__password">
                                    <input id="password-field" class="form-control__input form-control__input
                                
                                <?php
                                if (isset($rpassworderr)) {
                                    echo " form-control__input--error";
                                }
                                ?>
                                
                                " placeholder="Re-enter password" type="password" name="Rpassword" id="pass-input" value="<?php
                                                                                                                            if (isset($_POST['Rpassword'])) {
                                                                                                                                echo $_POST['Rpassword'];
                                                                                                                            }
                                                                                                                            ?>" />

                                    <!-- Error show  -->
                                    <?php
                                    if (isset($rpassworderr)) {
                                    ?>
                                        <div class="input-error">
                                            <?php echo $rpassworderr ?>
                                        </div>
                                    <?php
                                    }
                                    ?>


                                </div>


                            </div>

                            <div class="login-form__content__login">



                                <input type="submit" value="Sign-Up" name="userRegisterSubmit" class="btn primary-btn form-btn" />

                                </a>
                            </div>

                            <div class="login-form__content__signup flex_container">
                                <div>
                                    <p class="button-desc">
                                        Already have an account?
                                    </p>

                                    <!-- Go to login page -->

                                
                            <input type="submit" value="Login" class="btn primary-btn form-btn login-form__content__login" name="login">
                        
                                    
                                   
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