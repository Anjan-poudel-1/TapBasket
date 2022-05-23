<?php
    include('connection.php');

    function generateNumericOTP($n)
    {
    $generator = "1683579024";
    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    return $result;
    }

    if(isset($_POST['emailSubmit']) && !empty($_POST['emailSubmit'])){
        $email=$_POST['email'];

        $sql= "SELECT * FROM USERS WHERE EMAIL ='$email'";
        $select = oci_parse($conn,$sql);
        oci_execute($select, OCI_NO_AUTO_COMMIT);  
        oci_commit($conn);    
        $count= oci_fetch_all($select,$res);


        $vcode=generateNumericOTP(4);
        $updateVcodeSql = "UPDATE USERS SET VCODE=:vcode WHERE EMAIL=:email";
        $stidVcodeUpdate = oci_parse($conn,$updateVcodeSql);
        oci_bind_by_name($stidVcodeUpdate, ':vcode', $vcode);
        oci_bind_by_name($stidVcodeUpdate, ':email', $email);
        oci_execute($stidVcodeUpdate, OCI_COMMIT_ON_SUCCESS);
        oci_commit($conn);
        oci_free_statement($stidVcodeUpdate);
        oci_close($conn);

       
       
        
       
       
    if($count>0){
          
            include './PHPMailer/otpindex.php';
            $email = $_POST['email'];
            $sql= "SELECT * FROM users WHERE email = '$email'";
            $select = oci_parse($conn,$sql);
            oci_execute($select, OCI_NO_AUTO_COMMIT);  
            while($row = oci_fetch_array($select, OCI_ASSOC+OCI_RETURN_NULLS)){
                header("location:otp.php?id=".$row['USER_ID']."&changePassword=true");              
            }        
    }else{
        $emailerror="This email doesnot exist";
    }

        if(trim(empty($email))){
            $emailerror="Enter your Email";
        }

    }
  

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <link rel="stylesheet" href="assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page login-page">
    <?php 
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body ">
            <div class="login-form">
                <form  method="POST" action="">
                    
                <div class="login-form__content  center_body_div">
                    <div class="login-form__content__header">
                       Please Enter the email
                    </div>
                    <div class="login-form__content__body">

                   

                        <div class="form-control">
                            <input 
                            class="form-control__input <?php 
                             if(isset($emailerror)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your Email"
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

                    <div class="login-form__content__login">
                        <input type="submit" value="Send" name="emailSubmit" class="btn primary-btn form-btn"/>      
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