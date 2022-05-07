<?php
  if(isset($_POST['ContactUsSubmit'])){
    $email = $_POST['email'];
    $name=trim($_POST['name']);
    $subject=trim($_POST['subject']);
    $desc=trim($_POST['desc']);


    if(empty(trim($desc))){
        $descerr="Please add Product description";
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

    if(empty(trim($subject))){
        $subjecterr = "enter the subject to contact us";
    }
    if(empty($name)){
        $nameerr="Please enter name";
    }


  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
                       Contact Us
                    </div>
                    <div class="login-form__content__body">
                      
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
                      <p class="form-control__label">Subject</p>
                            <input class="form-control__input <?php 
                             if(isset($subjecterr)){
                                 echo " form-control__input--error";
                             }
                            ?>" placeholder="Message type" name="subject"  value="<?php
                            if(isset( $_POST['subject'])){
                                echo $_POST['subject'];
                            }
                            ?>"/>
                             <?php
                                if(isset($subjecterr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $subjecterr ?>
                                     </div> 
                                    <?php
                                        }
                                ?> 
                        </div>

                        <div class="form-control">
                      <p class="form-control__label">Message</p>
                            <textarea class="form-control__input textArea <?php 
                             if(isset($descerr)){
                                 echo " form-control__input--error";
                             }
                            ?>"  name="desc"  value="<?php
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
                        <input type="submit" value="Submit" name="ContactUsSubmit" class="btn primary-btn form-btn"/>
                         
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