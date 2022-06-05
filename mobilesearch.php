<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/styles/index.css">

</head>

<body data-theme="default" id="get-theme">

    <div class="page home-page">

        <?php
        include './components/navbars/primary-navbar.php';
        ?>

        <div class="container page__body">
            <div class="primary-navbar__content__search mobile-search-bar">
                <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.3399 16.7482H17.2061L16.8042 16.3607C18.2108 14.7245 19.0576 12.6003 19.0576 10.2896C19.0576 5.137 14.881 0.960419 9.72843 0.960419C4.57587 0.960419 0.399292 5.137 0.399292 10.2896C0.399292 15.4421 4.57587 19.6187 9.72843 19.6187C12.0392 19.6187 14.1634 18.7719 15.7995 17.3653L16.1871 17.7672V18.9011L23.3633 26.063L25.5018 23.9244L18.3399 16.7482ZM9.72843 16.7482C6.15465 16.7482 3.2698 13.8633 3.2698 10.2896C3.2698 6.71578 6.15465 3.83092 9.72843 3.83092C13.3022 3.83092 16.1871 6.71578 16.1871 10.2896C16.1871 13.8633 13.3022 16.7482 9.72843 16.7482Z" fill="black" />
                </svg>
                <form action="./filter.php" method="GET">
                    <input class="primary-navbar__content__search__field" placeholder="Search products" name="search" />
                    <input type="submit" class="nav-submit-button">
                </form>
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