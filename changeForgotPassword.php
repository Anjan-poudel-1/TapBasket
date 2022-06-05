<?php
include('connection.php');
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    if (isset($_POST['changePassword'])) {
        $errCount = 0;
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if (empty(trim($confirmPassword))) {
            $confirmPasswordErr = "Please enter  password";
            $errCount++;
        } else if ($newPassword != $confirmPassword) {
            $confirmPasswordErr = "Password must match";
            $errCount++;
        }

        if (empty(trim($newPassword))) {
            $newPasswordErr = "Please enter new password";
            $errCount++;
        } else if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $newPassword)) {
            $newPasswordErr = "password must contain Minimum eight characters, at least one lowercase, one uppercase letter and one number";
            $errCount++;
        }

        if ($errCount == 0) {
            $Passwordnew = md5($newPassword);
            $sqli = "UPDATE USERS 
        SET PASSWORD=:newpassword WHERE USER_ID='$user_id'";

            $stid = oci_parse($conn, $sqli);
            oci_bind_by_name($stid, ':newpassword', $Passwordnew);
            oci_execute($stid, OCI_COMMIT_ON_SUCCESS);


            if ($sqli) {
                $sql = "SELECT * FROM USERS WHERE USER_ID=$user_id";
                $select = oci_parse($conn, $sql);
                oci_execute($select, OCI_NO_AUTO_COMMIT);
                $rows = oci_fetch_all($select, $res);

                foreach ($res as $key => $value) {
                    if ($key == "EMAIL")
                        $email = $value[0];
                }
                $to = $email;
                $sender = "shahirabina652@gmail.com";
                $subject = "Security alert";

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $header = 'Your password was changed. ';
                if (mail($to, $subject, $header)) {
                }
            }
            echo "<script> alert('Password Changed');
        window.setTimeout(function(){
            window.location.href = 'login.php';

        });
        </script>";
        } else {
            // echo "Couldnot enter the data in database";
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
    <title>Account Settings</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body data-theme="default" id="get-theme">
    <div class="page login-page">

        <!-- Primary nav -->
        <?php
        include './components/navbars/primary-navbar.php';
        ?>
        <div class="container page__body">
            <div class="login-form">
                <form method="POST" action="">

                    <div class="login-form__content  center_body_div">
                        <div class="login-form__content__header">
                            New Password
                        </div>
                        <div class="login-form__content__body">



                            <div class="form-control">
                                <input class="form-control__input <?php
                                                                    if (isset($newPasswordErr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Enter New Password" name="newPassword" type="password" value="<?php
                                                                                                                                            if (isset($_POST['newPassword'])) {
                                                                                                                                                echo $_POST['newPassword'];
                                                                                                                                            }
                                                                                                                                            ?>" />
                                <!-- Error show  -->
                                <?php
                                if (isset($newPasswordErr)) {
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
                                </p>
                                <input class="form-control__input <?php
                                                                    if (isset($confirmPasswordErr)) {
                                                                        echo " form-control__input--error";
                                                                    }
                                                                    ?>" placeholder="Confirm password" name="confirmPassword" type="password" value="<?php
                                                                                                                                                if (isset($_POST['confirmPassword'])) {
                                                                                                                                                    echo $_POST['confirmPassword'];
                                                                                                                                                }
                                                                                                                                                ?>" />
                                <!-- Error show  -->
                                <?php
                                if (isset($confirmPasswordErr)) {
                                ?>
                                    <div class="input-error">
                                        <?php echo $confirmPasswordErr ?>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="login-form__content__login">
                                <input type="submit" value="Reset Password" name="changePassword" class="btn primary-btn form-btn" />
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