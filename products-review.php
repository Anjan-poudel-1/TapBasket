<?php
SESSION_START();
if ((isset($_SESSION['role']) && $_SESSION['role'] == 'customer')) {
    header('location:index.php');
}
$userId= $_SESSION['user_id'];
include('connection.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Details</title>
    <link rel="stylesheet" href="./assets/styles/index.css">

</head>
<body data-theme="default" id="get-theme">

    <div class="page home-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

<div class="container page__body">


<div class="trader-header"> 
    <div class="trader-header__title">
    Products Review
    </div>
</div>

<?php
$TraderReviewSQL="SELECT R.NO_OF_STARS AS STAR, R.MESSAGE AS MSG, R.USER_ID AS REVIEWER_ID, P.PRODUCT_NAME AS PNAME, P.PRODUCT_IMAGE AS PIMAGE 
                    FROM SHOP_REQUEST SR 
                    INNER JOIN SHOP S ON SR.SHOP_REQUEST_ID=S.SHOP_REQUEST_ID 
                    INNER JOIN PRODUCT P ON S.SHOP_ID=P.SHOP_ID 
                    INNER JOIN REVIEW R ON P.PRODUCT_ID=R.PRODUCT_ID 
                    WHERE SR.USER_ID=$userId";
$TraderReviewParse = oci_parse($conn, $TraderReviewSQL);
oci_execute($TraderReviewParse);
$nrowsTraderReview = oci_fetch_all($TraderReviewParse, $TraderReviewRes);
?>
<div class="Trader-Review">
    <?php
    for($TReviewIt=0; $TReviewIt<$nrowsTraderReview; $TReviewIt++){
        $pName= $TraderReviewRes['PNAME'][$TReviewIt];
        $pImage= $TraderReviewRes['PIMAGE'][$TReviewIt];
        $reviewer= $TraderReviewRes['REVIEWER_ID'][$TReviewIt];
        $msg=$pName= $TraderReviewRes['MSG'][$TReviewIt];
        $starsNo=$pName= $TraderReviewRes['STAR'][$TReviewIt];

        $reviewerSQL="SELECT USERNAME FROM USERS WHERE USER_ID=$reviewer";
        $reviewerstid = oci_parse($conn, $reviewerSQL);
        oci_execute($reviewerstid);
        $reviewerRows=oci_fetch_array($reviewerstid);

        $reviewerName=$reviewerRows['USERNAME'];
    ?>
    <div class="Trader-Review__One Review">
        <table border="1px solid black">
            
        </table>
    </div>
    <?php
    }
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
</body>
<script src="app.js">

</script>

</html>