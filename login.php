<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page login-page">
    <?php 
            include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="login-form">

                <div class="login-form__content">
                    <div class="login-form__content__header">
                        Log In
                    </div>
                    <div class="login-form__content__body">

                        <div class="form-control">
                            <p class="form-control__label">
                                Email Address
                            </p>
                            <input class="form-control__input" placeholder="Enter your email Address"/>

                        </div>

                        <div class="form-control">
                            <p class="form-control__label">
                                Password
                            </p>
                            <div class="form-control__password">
                                <input class="form-control__input form-control__input--password" placeholder="Enter your password" type="password"/>

                                <div class="pass-visibility" id="show-pass">
                                    SHOW
                                </div>
                                <!-- <div class="pass-visibility" id="hide-pass">
                                    HIDE
                                </div> -->
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
                        <button class="btn primary-btn form-btn">
                           Login
                        </button>
                    </div>

                    <div class="login-form__content__signup">
                            <div class="button-desc">
                                New to TapBasket?
                            </div>
                            <button class="btn primary-btn form-btn">
                                Sign Up
                            </button>
                    </div>
                </div>

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