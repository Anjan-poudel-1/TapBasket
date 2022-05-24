<?php
SESSION_START();
include("connection.php");
$user_id = $_SESSION['user_id'];

if(!(isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']===true) ){

    header ('location:index.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page user-dashboard-page">
         <!-- Primary nav -->
         <?php
        include './components/navbars/primary-navbar.php';
        ?>
        <div class="container page__body">
        <div class="user-dashboard">
                <?php
                  $pageName="order";
                include './components/pages/AccountSettings/userNavbar.php';
              
                ?>

                <div class="user-dashboard__content">
                  <div class="section__header">
                    <div class="section__header__heading">
                       My Orders
                    </div>
                  </div>

                  <?php
                  include "./components/pages/OrderHistory/order-history.php"; 
                  ?>
                 
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