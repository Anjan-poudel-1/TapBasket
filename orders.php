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
                include './components/pages/AccountSettings/userNavbar.php';
                
                ?>
                <div class="user-dashboard__content">
                
                    <div class="section__header">

                        <div class="section__header__heading">
                    
                            My Orders
                    
                        </div>
                    </div>
                    <div class= "order_history">
                        Your order history and purchase information
                    </div>
                        <div class="order_filter">
                                <select>
                                    <option value="">
                                        Order Filter
                                        All Orders
                                    </option>
                                    <option value="">
                                        7 days
                                    </option>
                                    <option value="">
                                        15 days
                                    </option>
                                    <option value="">
                                       1 month
                                    </option>
                                    <option value="">
                                        3 months
                                    </option>
                                </select>  
                            </div>
                            <div class="order_history_table">
				                <table>
						            <tr>
                                        <th>Order No</th>
                                        <th>Order Place</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Show Order</th>
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

          <!--Bottom Nav-->
          <?php
            include './components/navbars/bottom-navbar.php';
          ?>
</body>
<script src="app.js">
   
</script>
</html>