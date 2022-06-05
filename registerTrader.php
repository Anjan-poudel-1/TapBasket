<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Register</title>
    <link rel="stylesheet" href="assets/styles/index.css">
</head>

<body data-theme="default" id="get-theme">
    <?php
    include("connection.php");
    if (isset($_POST['TraderRegisterSubmit'])) {
        $Traderemail = $_POST['Temail'];
        $name = trim($_POST['name']);
        $tradername = trim($_POST['Tname']);
        $phone = trim($_POST['phone']);
        $Traderphone = trim($_POST['Tphone']);
        $product = trim($_POST['product']);
        $addr = trim($_POST['addr']);
        $desc = trim($_POST['desc']);

   

        if (empty(trim($desc))) {
            $descerr = "Please add Product description";
        }
        if (empty(trim($addr))) {
            $addrerr = "Please enter address";
        }
        if (empty(trim($Traderemail))) {
            $emailerror = "Please enter email";
        } else {
            $Traderemail = filter_var($Traderemail, FILTER_SANITIZE_EMAIL);
            if (!filter_var($Traderemail, FILTER_VALIDATE_EMAIL)) {
                $emailerror = "Invalid email";
            }
        }

        if (empty(trim($product))) {
            $producterr = "Please enter products types";
        }
        if (empty($name)) {
            $nameerr = "Please enter name";
        }
        if(empty($tradername)){
            $Tnameerr = "Please enter name";
        }


        if (empty($phone)) {
            $phoneerr = "Please enter phone number";
        }else  if (!preg_match('/^[\+0-9\-\(\)\s]*$/', $phone)) {

            $phoneerr = "Please enter valid phone number";
        }

        if (empty($Traderphone)) {
            $Tphoneerr = "Please enter phone number";
        }else if (!preg_match('/^[\+0-9\-\(\)\s]*$/', $Traderphone)) {

            $Tphoneerr = "Please enter valid phone number";
        }
       
        
    }
    ?>
    <?php
    include("connection.php");
    if (isset($_POST['TraderRegisterSubmit'])) {
        $role = "trader";
        $Temail = $_POST['Temail'];
        $Tname = trim($_POST['Tname']);
        $Tphone = trim($_POST['Tphone']);
        $addr = trim($_POST['addr']);
        $desc = trim($_POST['desc']);


        $shopname = trim($_POST['name']);
        $shopaddress = trim($_POST['addr']);
        $shopphone = trim($_POST['phone']);
        $product = trim($_POST['product']);
        $desc = trim($_POST['desc']);
        $disable="true";

        $sql = "SELECT * FROM users WHERE email = '$Temail'";
        $select = oci_parse($conn, $sql);
        oci_execute($select, OCI_NO_AUTO_COMMIT);
        $rows = oci_fetch_all($select, $res);
        if ($rows > 0) {
            $emailerror = "this email already exist";
        } else {

            if (!empty($Temail) && !empty($Tphone) && !empty($Tname)) {
                if (!empty($shopaddress) && !empty($shopname) && !empty($shopphone) && !empty($desc) && !empty($product)) {
                    $sql = "INSERT INTO USERS(username,email,phone_no,user_role,IS_DISABLED) VALUES (:Tname,:email,:phone_no,:Traderrole,:isdisabled)";
                    $stid = (oci_parse($conn, $sql));
                    oci_bind_by_name($stid, ":Tname", $Tname);
                    oci_bind_by_name($stid, ":email", $Temail);
                    oci_bind_by_name($stid, ":phone_no", $Tphone);
                    oci_bind_by_name($stid, ":Traderrole", $role);
                    oci_bind_by_name($stid, ":isdisabled", $disable);
                    oci_execute($stid, OCI_COMMIT_ON_SUCCESS);


                    $sqlFETCH = "SELECT USER_ID FROM USERS WHERE EMAIL=:Temail";
                    $stidFETCH = oci_parse($conn,$sqlFETCH );
                    oci_bind_by_name($stidFETCH, ":Temail", $Temail);
                    
                    oci_execute($stidFETCH, OCI_COMMIT_ON_SUCCESS);

                    while (($row = oci_fetch_object($stidFETCH)) != false) {
                        $newUserID=  $row->USER_ID ;



                        $statement = "INSERT INTO SHOP_REQUEST(shop_name,shop_address,shop_contact,CATEGORY,PURPOSAL_MESSAGE,IS_APPROVED,USER_ID) VALUES (:sname,:saddress,:sphone,:product,:sdesc,'false',:user_id1)";
                        $stid = (oci_parse($conn, $statement));
                        oci_bind_by_name($stid, ":sname", $shopname);
                        oci_bind_by_name($stid, ":saddress", $shopaddress);
                        oci_bind_by_name($stid, ":sphone", $shopphone);
                        oci_bind_by_name($stid, ":product", $product);
                        oci_bind_by_name($stid, ":sdesc", $desc);
                        oci_bind_by_name($stid, ":user_id1", $newUserID);
                        oci_execute($stid, OCI_NO_AUTO_COMMIT);
                        oci_commit($conn);
                        oci_free_statement($stid);
                        oci_close($conn);

                        echo "<script> alert('Register successfull');
                        window.setTimeout(function(){
                            window.location.href = 'index.php';
                
                        });
                        </script>";
                        
                    }


                    if ($sql) {
                        include './PHPMailer/emailtrader.php';
                        include './PHPMailer/emailAdmin.php';
                      }

                     
                }
                
            }
            
        }

        
    }

    if(isset($_POST['signup_customer'])){
        header('location:registeruser.php');
    }
   
    if(isset($_POST['login'])){
        header('location:login.php');
    }

    ?>
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
                            <h3>Trader Details:</h3>
                            <div class="form-control">
                                <p class="form-control__label">Name</p>
                                <input class="form-control__input <?php
                                                                    if (isset($Tnameerr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="FirstName" name="Tname" value="<?php
                                                                            if (isset($_POST['Tname'])) {
                                                                                echo $_POST['Tname'];
                                                                            }
                                                                            ?>" />
                                <?php
                                if (isset($Tnameerr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $Tnameerr ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>



                            <div class="form-control">
                                <p class="form-control__label">
                                    Email Address
                                </p>
                                <input class="form-control__input <?php
                                                                    if (isset($emailerror)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Enter your email Address" name="Temail" value="<?php
                                                                                            if (isset($_POST['Temail'])) {
                                                                                                echo $_POST['Temail'];
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
                                                                    if (isset($Tphoneerr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="+44" name="Tphone" value="<?php
                                                                        if (isset($_POST['Tphone'])) {
                                                                            echo $_POST['Tphone'];
                                                                        }
                                                                        ?>" />

                                <?php
                                if (isset($Tphoneerr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $Tphoneerr ?>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>


                            <h3>Shop Details:</h3>

                            <div class="form-control">
                                <p class="form-control__label">Name</p>
                                <input class="form-control__input <?php
                                                                    if (isset($nameerr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Shop Name" name="name" value="<?php
                                                                            if (isset($_POST['name'])) {
                                                                                echo $_POST['name'];
                                                                            }
                                                                            ?>" />
                                <?php
                                if (isset($nameerr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $nameerr ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="form-control">
                                <p class="form-control__label">Address</p>
                                <input class="form-control__input <?php
                                                                    if (isset($nameerr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Shop Address" name="addr" value="<?php
                                                                                if (isset($_POST['addr'])) {
                                                                                    echo $_POST['addr'];
                                                                                }
                                                                                ?>" />
                                <?php
                                if (isset($addrerr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $addrerr ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="form-control">
                                <p class="form-control__label">
                                    Shop Contact Number
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
                                <p class="form-control__label">Type of Product Sold by Shop</p>
                                <input class="form-control__input <?php
                                                                    if (isset($producterr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Enter the type of product sold by shop" name="product" value="<?php
                                                                                                            if (isset($_POST['product'])) {
                                                                                                                echo $_POST['product'];
                                                                                                            }
                                                                                                            ?>" />
                                <?php
                                if (isset($producterr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $producterr ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="form-control">
                                <p class="form-control__label">Purposal Message</p>
                                <textarea class="form-control__input textArea <?php
                                                                                if (isset($descerr)) {
                                                                                    echo " form-control__input--error";
                                                                                }
                                                                                ?>" placeholder="Enter the type of product sold by shop" name="desc" value="<?php
                                                                                                        if (isset($_POST['desc'])) {
                                                                                                            echo $_POST['desc'];
                                                                                                        }
                                                                                                        ?>" rows="4" cols="50">
                            </textarea>
                                <?php
                                if (isset($descerr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $descerr ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="login-form__content__login">
                                <input type="submit" value="Registration Proposal" name="TraderRegisterSubmit" class="btn primary-btn form-btn" />

                            </div>

                            <div class="login-form__content__signup flex_container">
                                <div>
                                    <p class="button-desc">
                                        Already have an account?
                                    </p>

                                    <!-- Go to registration page -->

                                    <input type="submit" value="Log-in" class="btn primary-btn form-btn login-form__content__login" name="login">
                        
                                  
                                    <!-- <button class="btn primary-btn form-btn">
                                        Log-in

                                    </button> -->
                                    
                                </div><br>
                                <div>
                                    <p class="button-desc">
                                        Sign Up as Customer
                                    </p>

                                    <input type="submit" value="Signup as Customer" class="btn primary-btn form-btn login-form__content__login" name="signup_customer">
                                    <!-- <button class="btn primary-btn form-btn">
                                        signup as customer

                                    </button> -->
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