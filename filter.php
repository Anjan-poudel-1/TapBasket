<?php
include('connection.php');
if(isset($_SESSION['user_id']) && isset($_SESSION['isAuthenticated'])){
    $user_id=$_SESSION['user_id'];
}
else{
    $nameFlag=false;
    $HLPriceFlag=false;
    $LHPriceFlag=false;
    $_SESSION['isAuthenticated']=false;
    $search=$_GET['search'];
    $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_NAME LIKE '%$search%'";
    

    if(isset($_POST['Category'])){
        $Cat=$_POST['Category'];

        if(isset($_GET['search'])){
            $sql = "SELECT * FROM PRODUCT INNER JOIN SHOP ON PRODUCT.SHOP_ID=SHOP.SHOP_ID INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID=SHOP_REQUEST.SHOP_REQUEST_ID WHERE (PRODUCT.PRODUCT_NAME LIKE '%$search%') AND (SHOP_REQUEST.CATEGORY='".$Cat[0]."'";
            for($CatIterator=1; $CatIterator < count($Cat); $CatIterator++){
                $sql =$sql . " OR SHOP_REQUEST.CATEGORY='".$Cat[$CatIterator]."'";
            }
            $sql=$sql . ")";
              
        }else{
            $sql="SELECT * FROM PRODUCT INNER JOIN SHOP ON PRODUCT.SHOP_ID=SHOP.SHOP_ID INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID=SHOP_REQUEST.SHOP_REQUEST_ID WHERE AND (SHOP_REQUEST.CATEGORY='".$Cat[0]."'";
            for($CatIterator=1; $CatIterator < count($Cat); $CatIterator++){
                $sql =$sql . " OR SHOP_REQUEST.CATEGORY='".$Cat[$CatIterator]."'";
            }
            $sql=$sql . ")";
        }
    }

    if(isset($_POST['sort'])){
        $sort=$_POST['sort'];
        if($sort=="Name"){
            $nameFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRODUCT_NAME";
        }else if($sort=="PriceHL"){
            $HLPriceFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRICE DESC";
        }else if($sort=="PriceLH"){
            $LHPriceFlag=true;
            $sql=$sql. " ORDER BY PRODUCT.PRICE";
        }
    }

    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    $nrows = oci_fetch_all($stid, $res);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body data-theme="default" id="get-theme">
    <div class="page filter-page">
       <?php
        include './components/navbars/primary-navbar.php'; 
        ?>
        <div class="container page__body">
            <div class="filter-result-container">
                <div class="filter-result-container__left">
                    <div class="Categories-filter-page">
                        <div class="Categories-filter-page__Header">
                            Categories
                        </div>
                        <form class="Categories-filter-page__Form" method="POST">
                            <?php
                                $queryCat = "SELECT SHOP_REQUEST.CATEGORY FROM SHOP INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID = SHOP_REQUEST.SHOP_REQUEST_ID";
                                $parseCat = oci_parse($conn, $queryCat);
                                oci_execute($parseCat);
                                $nrowsCat = oci_fetch_all($parseCat, $resCat);

                                for ($j = 0; $j < $nrowsCat; $j++){
                                $category= $resCat['CATEGORY'][$j];
                            ?>
                            <input type="checkbox" value="<?php echo $category?>" name="Category[]" <?php
                            if(isset($_POST['Category'])){
                                for($CheckIterator=0; $CheckIterator<count($Cat);$CheckIterator++){
                                    if($Cat[$CheckIterator]==$category){
                                        echo ' checked ';
                                    }
                                }
                            }
                            ?>> 
                            <label for="Categories-1"><?php echo $category?></label><br>
                            <?php } ?>
                            <br><input type="submit" value="Apply" class="btn primary-outline-btn">
                        </form>
                    </div>
                </div>
                <div class="filter-result-container__right">

                    <div class="filter-page__Top-Row">

                        <div class="filter-page__Top-Row__Res-Num">Showing <?php echo $nrows;?> Results for "<?php echo $_GET['search'];?>"</div>
                        <div class="filter-page-categories">
                        </div>
                    
                        <div class="filter-page__Top-Row__Sort">
                            <div class="filter-page__Top-Row__Sort__Sort-Title">Sort By:</div>
                            <div class="filter-page__Top-Row__Sort__Sort-Dropdown">
                                <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Button">
                                    <?php 
                                    if(isset($_POST['sort'])){
                                        switch($sort){
                                            case "Name":
                                                echo "Name";
                                                break;
                                            case "PriceHL":
                                                echo "Price: High to Low";
                                                break;
                                            case "PriceLH":
                                                echo "Price: Low to High";
                                        }
                                    }else{
                                        echo "Name";
                                    }
                                    ?>
                                    <svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.833313 0.333313L4.99998 4.49998L9.16665 0.333313H0.833313Z" class="filter-page__Top-Row__Sort__Sort-Dropdown__Button__Icon"/>
                                    </svg>
                                </button>
                                    <form method="POST" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content">
                                        <button type="submit" name="sort" value="Name" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($nameFlag){echo "disabled";}?>>Name</button>
                                        <button type="submit" name="sort" value="PriceHL" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($HLPriceFlag){echo "disabled";}?>>Price: High to Low</button>
                                        <button type="submit" name="sort" value="PriceLH" class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options"<?php if($LHPriceFlag){echo "disabled";}?>>Price: Low to High</button>
                                    </form>
                            </div>
                        </div>

                    </div>

                    <hr class="filter-page__Line">
                    <div class="filter-page__Result">
                        <?php include './components/pages/Filter/Filter-Result.php';?>
                    </div>
                </div>
            </div>
        </div>

     <!-- Page Footers  -->
     <?php
        include './components/resuables/page-footer.php';
    ?>

     <!-- Copyright   -->

    <?php
        include './components/resuables/copyright.php';
    ?>

    <!-- Bottom Nav -->

    <?php
    include './components/navbars/bottom-navbar.php';
    ?>
   
</body>

<script src="app.js">
   
</script>
</html>