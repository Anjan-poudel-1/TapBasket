<?php
  if(isset($_POST['TraderRegisterSubmit'])){
    $email = $_POST['email'];
    $name=trim($_POST['name']);
    $phone=trim($_POST['phone']);
    $product=trim($_POST['product']);
    $addr=trim($_POST['addr']);
    $desc=trim($_POST['desc']);


    if(empty(trim($desc))){
        $descerr="Please add Product description";
    }
    if(empty(trim($addr))){
        $addrerr = "Please enter address";
    }
    if(empty(trim($email))){
        $emailerror = "Please enter email";
    }
    else{
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailerror = "Invalid email";
        }
    }

    if(empty(trim($product))){
        $producterr = "Please enter products types";
    }
    if(empty($name)){
        $nameerr="Please enter name";
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
    <title>Trader Register</title>
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
                    <h3>Trader Details:</h3>
                       <div class="form-control">
                      <p class="form-control__label">Name</p>
                            <input class="form-control__input <?php 
                             if(isset($nameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="FirstName" name="name"  value="<?php
                            if(isset( $_POST['name'])){
                                echo $_POST['name'];
                            }
                            ?>"/>
                             <?php
                                if(isset($nameerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $nameerr ?>
                                     </div> 
                                    <?php
                                        }
                                ?> 
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

                        <h3>Shop Details:</h3>
                                
                        <div class="form-control">
                      <p class="form-control__label">Name</p>
                            <input class="form-control__input <?php 
                             if(isset($nameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="Shop Name" name="name"  value="<?php
                            if(isset( $_POST['name'])){
                                echo $_POST['name'];
                            }
                            ?>"/>
                             <?php
                                if(isset($nameerr)){
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
                             if(isset($nameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="Shop Address" name="addr"  value="<?php
                            if(isset( $_POST['addr'])){
                                echo $_POST['addr'];
                            }
                            ?>"/>
                             <?php
                                if(isset($addrerr)){
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
                      <p class="form-control__label">Type of Product Sold by Shop</p>
                            <input class="form-control__input <?php 
                             if(isset($producterr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="Enter the type of product sold by shop" name="product"  value="<?php
                            if(isset( $_POST['product'])){
                                echo $_POST['product'];
                            }
                            ?>"/>
                             <?php
                                if(isset($producterr)){
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
                            <textarea class="form-control__input <?php 
                             if(isset($descerr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="Enter the type of product sold by shop" name="desc"  value="<?php
                            if(isset( $_POST['desc'])){
                                echo $_POST['desc'];
                            }
                            ?>" rows="4" cols="50">
                            </textarea>
                             <?php
                                if(isset($descerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $descerr ?>
                                     </div> 
                                    <?php
                                        }
                                ?> 
                        </div>

                    <div class="login-form__content__login">
                        <input type="submit" value="Send Proposal For Registration" name="TraderRegisterSubmit" class="btn primary-btn form-btn"/>
                         
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
                              Sign Up as Customer
                    </p><br>
                            <button class="btn primary-btn form-btn">
                            signup as customer
                                
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