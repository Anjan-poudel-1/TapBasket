<?php
include('connection.php');
  if(isset($_GET['id'])){
      $id=$_GET['id'];
      $sql= "SELECT * FROM users WHERE userid = '$id'";
      $select = oci_parse($conn,$sql);
      oci_execute($select, OCI_NO_AUTO_COMMIT);          
      while($row = oci_fetch_array($select, OCI_ASSOC+OCI_RETURN_NULLS)){
       $otp=$row['vcode'];
      }

      $vcode=$_POST['otp'];

      if($otp==$vcode){
          //user_id='';
          //isAuthenticated=true
        //header ('location:index.php');
      }else{
        header ('location:otp.php');
          $otperror='Please enter the correct otp';
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
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
                       Please Enter the otp Send in the email
                    </div>
                    <div class="login-form__content__body">

                   

                        <div class="form-control">
                            <input 
                            class="form-control__input <?php 
                             if(isset($otperror)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your OTP"
                             name="otp"
                             value="<?php
                                    if(isset( $_POST['otp'])){
                                        echo $_POST['otp'];
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($otperror)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $otperror ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>

                    <div class="login-form__content__login">
                        <input type="submit" value="Send" name="otpSubmit" class="btn primary-btn form-btn"/>      
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