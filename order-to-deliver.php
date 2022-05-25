<?php
SESSION_START();
if ((isset($_SESSION['role']) && $_SESSION['role'] == 'customer')) {
    header('location:index.php');
}

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

<div class="trader-order">
    <div class="trader-order__one-order">
        <table border="1px solid black">
            <tr>
                <th>Order No</th>
                <th>Collection Date</th>
                <th>Collection Slot</th>
                <th>Earnings</th>
                <th rowspan="2">View Details</th>
            </tr>
            <tr>
                <td>1234</td>
                <td>May 25,2022</td>
                <td>12:00 - 13:00</td>
                <td>£ 2.57</td>
            </tr>
        </table>
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
</body>
<script src="app.js">

</script>

</html>