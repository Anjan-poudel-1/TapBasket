

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/index.css">
    <title>Error page</title>
</head>
<body data-theme="default" id="get-theme">

    <div class="page home-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="success-page-container"> 
                <img src='./assets/images/failed.png'>
                <div class="success-page-container__content">
                Sorry, your payment couldnot be recorded. Your Order is cancelled. <br/>

                <div class="success-page-container__content__links">
                    <div>
                    <a href="index.php">
                    <button class="btn primary-btn ">
                        Go to Home
                    </button>
                    </a>
                    </div>

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