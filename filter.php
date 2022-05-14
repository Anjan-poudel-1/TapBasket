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
                    asjbdsajhsh
                </div>
                <div class="filter-result-container__right">

                    <div class="filter-page__Top-Row">

                        <div class="filter-page__Top-Row__Res-Num">Showing 10 Results for "Spinach"</div>
                        <div class="filter-page-categories"></div>
                    
                        <div class="filter-page__Top-Row__Sort">
                            <div class="filter-page__Top-Row__Sort__Sort-Title">Sort By:</div>
                            <div class="filter-page__Top-Row__Sort__Sort-Dropdown">
                                <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Button">
                                    Name <svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.833313 0.333313L4.99998 4.49998L9.16665 0.333313H0.833313Z" class="filter-page__Top-Row__Sort__Sort-Dropdown__Button__Icon"/>
                                    </svg>
                                </button>
                                <div class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content">
                                    <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options" id="Filter-Name">Name</button>
                                    <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options" id="Filter-Newest">Newest First</button>
                                    <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options" id="Filter-Price-High-Low">Price: High to Low</button>
                                    <button class="filter-page__Top-Row__Sort__Sort-Dropdown__Dropdown-Content__Options" id="Filter-Price-Low-High">Price: Low to High</button>
                                </div>
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