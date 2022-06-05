<?php

session_start();
include("connection.php");

if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['isAuthenticated']))) {

    $_SESSION['isAuthenticated'] = false;
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = false;
}

if(isset($_GET['userId']) && isset($_GET['payment']) && $_GET['payment'] && isset($_GET['orderId']) && isset($_GET['PayerID'])){

$userId = $_GET['userId'];
$orderId = $_GET['orderId'];

$sqlUSer = "Select * from USERS WHERE USER_ID=$userId AND USER_ROLE='customer'";
$stidUser=(oci_parse($conn,$sqlUSer));
oci_execute($stidUser,OCI_DEFAULT);  


while (($rowUser = oci_fetch_object($stidUser)) != false) {
    // Use upper case attribute names for each standard Oracle column
   
    $userId= $rowUser->USER_ID;
    $name=$rowUser->USERNAME;

    $_SESSION['isAuthenticated'] = true;
    $_SESSION['user_id'] = $userId;


    $updateOrderSql = "UPDATE ORDERPLACE SET PAYMENT_STATUS='true' WHERE ORDERPLACE_ID=:ORDERPLACE_ID";
    $stidOrderUpdate = oci_parse($conn,$updateOrderSql);
    oci_bind_by_name($stidOrderUpdate, ':ORDERPLACE_ID', $orderId);
    oci_execute($stidOrderUpdate, OCI_COMMIT_ON_SUCCESS);
    oci_commit($conn);
    oci_free_statement($stidOrderUpdate);
    oci_close($conn);

    $insertPaymentSql = "INSERT INTO PAYMENT(MODE_DETAIL,ORDERPLACE_ID) VALUES('paypal',$orderId)";
    $stidInsertPayment = oci_parse($conn,$insertPaymentSql);
    oci_execute($stidInsertPayment, OCI_COMMIT_ON_SUCCESS);
    oci_commit($conn);
    oci_free_statement($stidInsertPayment);
    oci_close($conn);

// email
if($insertPaymentSql){
    // header("PHPMailer/index.php?id=".$userId."&name=".$name."&orderplaceid=".$orderId);  
    include './PHPMailer/index.php';
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
    <link rel="stylesheet" href="./assets/styles/index.css">
    <title>Success</title>
</head>
<body data-theme="default" id="get-theme">

    <div class="page home-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="success-page-container"> 
                <img src='./assets/images/succcess.png'>
                <div class="success-page-container__content">
                Thank You For your payment. Your Order <b>#<?php echo $orderId ?> </b>will be delievered soon. <br/>

                <div class="success-page-container__content__links">
                    <div>
                    <a href="index.php">
                    <button class="btn primary-btn ">
                        Go to Home
                    </button>
                    </a>
                    </div>

                    <div>
                    <a href="orders.php">
                    <button class="btn primary-outline-btn">
                        My Orders
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