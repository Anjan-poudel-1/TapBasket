<?php
SESSION_START();
// session_destroy();
if (!(isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated'] === true)) {

    header('location:login.php');
}

if (!(isset($_SESSION['cart']))) {

    $_SESSION['cart'] = [];
}
if (!(isset($_SESSION['user_id']))) {

    $_SESSION['user_id'] = '';
}

$user_id = $_SESSION['user_id'];

include './connection.php';

$date_chosen = '';
$timing = '';
$finalPayment = false;







//For checkout form 
if (isset($_POST['submitPickDetails'])) {

    $selectedDateError = '';
    $selectedTimeError = '';
    $selectedDate = '';
    $selectedTime = '';
    $isStepOneCompleted = false;
    $errCount = 0;

    if (isset($_POST['dateSelected']) && $_POST['dateSelected']) {
        $selectedDate = $_POST['dateSelected'];
    } else {
        $errCount = 1;
        $selectedDateError = 'Please select the date';
    }

    if (isset($_POST['timing'])) {
        $selectedTime = $_POST['timing'];
    } else {
        $errCount = 1;
        $selectedTimeError = 'Please select the timing';
    }

    if ($errCount == 0) {
        $isStepOneCompleted = true;
    }
    
}


if (isset($_POST['goToCart'])) {
    header('location:cart.php');
}


?>
<?php


if (isset($_GET['collectionSlot']) && (isset($_GET['timing']) && isset($_GET['payment']) && $_GET['payment'])) {
    $myCart = $_SESSION['cart'];
    $selectedDate = $_GET['collectionSlot'];
    $tempData =  explode(",", $selectedDate)[0];
    $tempDay =  explode(",", $selectedDate)[1];
    $year = date("Y");
    $selectedTime = $_GET['timing'];
    $paymentstatus = "false";
    $selectedDate = $tempData . " " . $year;
     
     
    $selectedDate= date('Y/m/d', strtotime($selectedDate));
    $subtotal = 0;

    foreach ($myCart as $product_id => $quantity) {

        $discountPrice = 0;
        $finalprice = 0;

        $tempProductId = $product_id;
        $sqlDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$product_id";
        $stidDiscount = oci_parse($conn, $sqlDiscount);
        oci_execute($stidDiscount);


        while (oci_fetch($stidDiscount)) {
            $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
        }
        $sqlproductprice = "SELECT PRICE FROM PRODUCT WHERE PRODUCT_ID=$tempProductId";
        $stidProductPrice = oci_parse($conn, $sqlproductprice);
        oci_execute($stidProductPrice);


        while (oci_fetch($stidProductPrice)) {
            $tempPrice = oci_result($stidProductPrice, 'PRICE');
        }
        $finalprice = ($tempPrice - $discountPrice)*$quantity;
        $subtotal += $finalprice;
    }


    $insertOrderPlace = "INSERT INTO ORDERPLACE(TIMESLOT,DATE_OF_COLLECTION,DAY,PAYMENT_STATUS,USER_ID,subtotal) VALUES (:selectedTime,TO_DATE(:selecteddate, 'yyyy/mm/dd'),:tempday,:paymentstatus,:userid,:subtotal)";
    $collectionslotstid = (oci_parse($conn, $insertOrderPlace));
    oci_bind_by_name($collectionslotstid, ":userid", $user_id);
    oci_bind_by_name($collectionslotstid, ":subtotal", $subtotal);
    oci_bind_by_name($collectionslotstid, ":selecteddate", $selectedDate);
    oci_bind_by_name($collectionslotstid, ":selectedTime", $selectedTime);
    oci_bind_by_name($collectionslotstid, ":tempday", $tempDay);
    oci_bind_by_name($collectionslotstid, ":paymentstatus", $paymentstatus);
    oci_execute($collectionslotstid, OCI_NO_AUTO_COMMIT);
    oci_commit($conn);
    oci_free_statement($collectionslotstid);

    if ($insertOrderPlace) {

        $sql = "Select ORDERPLACE_ID from ORDERPLACE where 1=1 order by ORDERPLACE_ID desc";
        $select = oci_parse($conn, $sql);
        oci_execute($select, OCI_NO_AUTO_COMMIT);
        oci_commit($conn);
        $count = oci_fetch_all($select, $res);
        foreach ($res as $key => $value) {
            if ($key == "ORDERPLACE_ID")
                $orderplace_id = $value[0];
        }
        
        foreach ($myCart as $product_id => $quantity) {

            $orderlistsql = "INSERT INTO ORDERLIST(QUANTITY,ORDERPLACE_ID,PRODUCT_ID) VALUES(:quantity,:orderPlaceId,:productId)";
            $orderliststid = (oci_parse($conn, $orderlistsql));
            oci_bind_by_name($orderliststid, ":productId", $product_id);
            oci_bind_by_name($orderliststid, ":quantity", $quantity);
            oci_bind_by_name($orderliststid, ":orderPlaceId", $orderplace_id);
            oci_execute($orderliststid, OCI_NO_AUTO_COMMIT);
            oci_commit($conn);
            oci_free_statement($orderliststid);
        }
            $_SESSION['cart'] = []; 

            $sqlEndCartList = "DELETE FROM CARTLIST WHERE USER_ID=$user_id";
            $EndCartListstid = (oci_parse($conn, $sqlEndCartList));
            oci_execute($EndCartListstid, OCI_NO_AUTO_COMMIT);

            ?>
              <!-- Form here -->


              <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" id="paypal-submit" method="post" class="paypal">
    <!-- Paypal business test account email id so that you can collect the payments. -->
    <input type="hidden" name="business" value="sb-knnls16326444@business.example.com">
    <!-- Buy Now button. -->
    <input type="hidden" name="cmd" value="_xclick">
    <!-- Details about the item that buyers will purchase. -->
    <input type="hidden" name="item_name" value="3000">
    <input type="hidden" name="item_number" value="1000"> 
    <!-- //user_id -->
    <input type="hidden" name="amount" value="<?php echo  $subtotal?>">
    <!-- PUT THE PRICE IN SESSION -->
    <input type="hidden" name="currency_code" value="GBP">
    <input type="hidden" name="rm" value="2">
    <!-- URLs -->
    <input type='hidden' name='cancel_return' value='http://localhost/TapBasket/error-page.php'>
    <input type='hidden' name='return' value='http://localhost/TapBasket/success-page.php?userId=<?php echo $user_id?>&payment=true&orderId=<?php echo $orderplace_id?>'>
    <!-- payment button. -->
    <input type="image" name="submit" border="0" src="sandbox/paypal.svg" alt="Loading....Payment">
    <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
  </form>    
        <?php
        
        echo '<script>
        document.getElementById("paypal-submit").submit();
        </script>';
        $subtotal = 0;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body data-theme="default" id="get-theme">

    <div class="page checkout-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="section__header">

                <div class="section__header__heading">

                    Cart Checkout

                </div>
            </div>
            <div class="checkout__body">

                <?php
                include './components/pages/Checkout/checout-steps.php';
                ?>

                <?php
                include './components/pages/Checkout/order-details.php';
                ?>

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

<script src="app.js"></script>



</html>