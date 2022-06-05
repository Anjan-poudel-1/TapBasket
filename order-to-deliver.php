<?php
SESSION_START();
if(!isset($_SESSION['role'])){
    header('location:index.php');
}
if ((isset($_SESSION['role']) && $_SESSION['role'] != 'trader')) {
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
    Orders To Deliver
    </div>
    <!-- <div class="btn primary-btn trader-header__button">
    Add Data
    </div> -->
</div>
<?php
$TraderOrderSQL="SELECT DISTINCT(OP.ORDERPLACE_ID) AS ORDER_ID, OP.DATE_OF_COLLECTION AS COLLECTION_DATE, OP.TIMESLOT AS  TIME_SLOT 
FROM ORDERPLACE OP 
INNER JOIN ORDERLIST OL ON OP.ORDERPLACE_ID=OL.ORDERPLACE_ID 
INNER JOIN PRODUCT P ON OL.PRODUCT_ID=P.PRODUCT_ID
INNER JOIN SHOP S ON P.SHOP_ID=S.SHOP_ID
INNER JOIN SHOP_REQUEST SR ON S.SHOP_REQUEST_ID=SR.SHOP_REQUEST_ID
WHERE SR.USER_ID = $userId";
$TraderOrderParse = oci_parse($conn, $TraderOrderSQL);
oci_execute($TraderOrderParse);
$nrowsTraderOrder = oci_fetch_all($TraderOrderParse, $TraderOrderRes);
?>
<div class="trader-order">
    <div class="trader-order__one-order">
        <?php for($orderIt=0; $orderIt<$nrowsTraderOrder;$orderIt++){
            $orderid=$TraderOrderRes['ORDER_ID'][$orderIt];
            $collectionDate=$TraderOrderRes['COLLECTION_DATE'][$orderIt];
            $collectionTime=$TraderOrderRes['TIME_SLOT'][$orderIt];
            ?>
        <table class="Order-table" border="1px solid black">
            <tr>
                <th>Order No</th>
                <th>Collection Date</th>
                <th>Collection Slot</th>
                <td rowspan="2" class="Order-table__Details"><form method="POST"><button type="submit" name="details" class="Order-table__Details__button" value="<?php echo $orderid;?>">View Details</button></form></td>
            </tr>
            <tr>
                <td><?php echo $orderid; ?></td>
                <td><?php echo $collectionDate; ?></td>
                <td><?php switch($collectionTime){
                    case "morning":
                        echo "6:00 - 12:00";
                        break;
                    case "afternoon":
                        echo "12:00 - 15:00";
                        break;
                    case "evening":
                        echo "15:00 - 18:00";
                        break;
                } ?></td>
            </tr>
            <tr <?php if(isset($_POST['details'])){
                if($orderid==$_POST['details']){
                    echo 'style="display: default;"';
                }else{
                    echo 'style="display: none;"';
                }
            }else{
                echo 'style="display: none;"';
            }
            ?>> 
                <td colspan="4">
                    <?php
                    $TraderOrderDetailSQL="SELECT P.PRODUCT_ID AS PID, P.PRODUCT_NAME AS PNAME, P.PRODUCT_IMAGE AS PIMAGE, P.PRICE AS PRICE, OL.QUANTITY AS QTY
                    FROM ORDERPLACE OP 
                    INNER JOIN ORDERLIST OL ON OP.ORDERPLACE_ID=OL.ORDERPLACE_ID 
                    INNER JOIN PRODUCT P ON OL.PRODUCT_ID=P.PRODUCT_ID
                    INNER JOIN SHOP S ON P.SHOP_ID=S.SHOP_ID
                    INNER JOIN SHOP_REQUEST SR ON S.SHOP_REQUEST_ID=SR.SHOP_REQUEST_ID
                    WHERE SR.USER_ID = $userId AND OP.ORDERPLACE_ID=$orderid";
                    $TraderOrderDetailParse = oci_parse($conn, $TraderOrderDetailSQL);
                    oci_execute($TraderOrderDetailParse);
                    $nrowsTraderOrderDetail = oci_fetch_all($TraderOrderDetailParse, $TraderOrderDetailRes);
                    ?>
                    <table class="Order-table__detail-table" border="1px solid black">
                        <tr>
                            <th class="Order-table__detail-table__dCol1">S.No</th>
                            <th class="Order-table__detail-table__dCol2">Product Image</th>
                            <th class="Order-table__detail-table__dCol3">Product ID</th>
                            <th class="Order-table__detail-table__dCol4">Product Name</th>
                            <th class="Order-table__detail-table__dCol5">Ordered Qty</th>
                            <th class="Order-table__detail-table__dCol6">Earnings</th>
                        </tr>
                        <?php
                        $orderTotal=0;
                        for($orderProductIt=0;$orderProductIt<$nrowsTraderOrderDetail;$orderProductIt++){
                            $pID=$TraderOrderDetailRes['PID'][$orderProductIt];
                            $pName=$TraderOrderDetailRes['PNAME'][$orderProductIt];
                            $pImage=$TraderOrderDetailRes['PIMAGE'][$orderProductIt];
                            $price=$TraderOrderDetailRes['PRICE'][$orderProductIt];
                            $qty=$TraderOrderDetailRes['QTY'][$orderProductIt];
                        ?>
                        <tr>
                            <td><?php echo ($orderProductIt+1)?></td>
                            <td class="table-img-container"><img src="assets/images/ProductImage/<?php echo $pImage; ?>" class="Order-table__detail-table__pImage"></td>
                            <td><?php echo $pID; ?></td>
                            <td class="review-left-align"><?php echo $pName; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>£ <?php $totalPrice= $price * $qty;
                            $orderTotal+=$totalPrice;
                            echo $totalPrice;?></td>
                        </tr>
                        <?php } ?>
                        <tr style="font-weight: bold";>
                            <td colspan="5" style="padding-right:10px; text-align: right;">Total Earnings from this order:</td>
                            <td>£ <?php echo $orderTotal;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php } ?>
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