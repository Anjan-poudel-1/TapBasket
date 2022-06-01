<?php
include './connection.php';
$count = 0;

if (isset($_SESSION['cart'])) {
    $cartData = $_SESSION['cart'];

    foreach ($cartData as $key => $value) {
        $count = $count + $value;
    }
}
if (!isset($_SESSION['isAuthenticated'])) {
    $_SESSION['isAuthenticated'] = False;
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = '';
}

if ($_SESSION['isAuthenticated']) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM USERS WHERE USER_ID=$user_id";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);

    while (($row = oci_fetch_object($stid)) != false) {
        // Use upper case attribute names for each standard Oracle column

        $userImage = $row->USER_IMAGE;
    }
}
$isCustomer = true;

//To find out if it is logged in by trader or customer 
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'trader') {
        $isCustomer = false;
    } else {
        $isCustomer = true;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="navbar primary-navbar">
        <div class="container primary-navbar__content">
            <div class="primary-navbar__content__left">
                <div class="primary-navbar__content__left__logo">
                    <a href="index.php">
                        <img src="./assets/images/logo-01.png" />
                    </a>

                </div>
                <div class="nav-links nav-links--desktop">
                    <a href="index.php">
                        <?php if ($isCustomer) {
                            echo 'Home';
                        } else {
                            echo 'Products';
                        } ?>
                    </a>

                </div>
                <?php
                if ($isCustomer) {
                ?>
                    <div class="nav-links nav-links--products ">
                        <div class="nav-links__products">
                            Products
                        </div>
                        <div class="nav-dropdown nav-dropdown--products">
                            <ul class="nav-dropdown__lists nav-links__products__lists">
                            <form method="POST" action="./filter.php">
                                <?php
                                $navCatSQL = "SELECT SHOP_REQUEST.CATEGORY FROM SHOP INNER JOIN SHOP_REQUEST ON SHOP.SHOP_REQUEST_ID = SHOP_REQUEST.SHOP_REQUEST_ID";
                                $navParseCat = oci_parse($conn, $navCatSQL);
                                oci_execute($navParseCat);
                                $navCatRow = oci_fetch_all($navParseCat, $navResCat);

                                for ($navIt = 0; $navIt < $navCatRow; $navIt++) {
                                    $navCategory = $navResCat['CATEGORY'][$navIt];
                                ?>
                                    
                                        <li class="nav-dropdown__lists__list">
                                            <button type="submit" name="Category[]" value="<?php echo $navCategory;?>" class="nav-cat-button"><?php echo ucfirst($navCategory); ?></button>
                                        </li>
                                    
                                <?php } ?>
                                </form>
                            </ul>

                        </div>


                    </div>
                <?php
                } ?>

                <?php
                if ($isCustomer) {
                ?>
                    <a href="maintopdeal.php" class="nav-links">
                        Deals
                    </a>
                <?php
                } else {

                ?>
                    <a href="productDiscount.php" class="nav-links nav-links--desktop">
                        Deals
                    </a>
                    <a href="products-review.php" class="nav-links nav-links--desktop">
                        Reviews
                    </a>
                <?php
                }

                ?>


            </div>

            <?php
            if ($isCustomer) {
            ?>
                <div class="primary-navbar__content__search">
                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.3399 16.7482H17.2061L16.8042 16.3607C18.2108 14.7245 19.0576 12.6003 19.0576 10.2896C19.0576 5.137 14.881 0.960419 9.72843 0.960419C4.57587 0.960419 0.399292 5.137 0.399292 10.2896C0.399292 15.4421 4.57587 19.6187 9.72843 19.6187C12.0392 19.6187 14.1634 18.7719 15.7995 17.3653L16.1871 17.7672V18.9011L23.3633 26.063L25.5018 23.9244L18.3399 16.7482ZM9.72843 16.7482C6.15465 16.7482 3.2698 13.8633 3.2698 10.2896C3.2698 6.71578 6.15465 3.83092 9.72843 3.83092C13.3022 3.83092 16.1871 6.71578 16.1871 10.2896C16.1871 13.8633 13.3022 16.7482 9.72843 16.7482Z" fill="black" />
                    </svg>
                    <form action="./filter.php" method="GET">
                        <input class="primary-navbar__content__search__field" placeholder="Search products" name="search" />
                        <input type="submit" class="nav-submit-button">
                    </form>
                </div>
            <?php
            } ?>

            <div class="primary-navbar__content__right">

            <?php
                if(!$isCustomer){
                        ?>
                            <a href="order-to-deliver.php" class="nav-links">
                                Orders
                            </a>
                        <?php
                }
            ?>

                <div class="nav-links " id="theme-change" onclick="toggleTheme()">
                    <div class="nav-links__mode" id="dark-mode">
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 9.44444C21.1744 9.44444 24.5556 12.8256 24.5556 17C24.5556 21.1744 21.1744 24.5556 17 24.5556C12.8256 24.5556 9.44444 21.1744 9.44444 17C9.44444 12.8256 12.8256 9.44444 17 9.44444ZM5.19444 18.4167C5.96889 18.4167 6.61111 17.7744 6.61111 17C6.61111 16.2256 5.96889 15.5833 5.19444 15.5833H1.41667C0.642222 15.5833 0 16.2256 0 17C0 17.7744 0.642222 18.4167 1.41667 18.4167H5.19444ZM32.5833 18.4167C33.3578 18.4167 34 17.7744 34 17C34 16.2256 33.3578 15.5833 32.5833 15.5833H28.8056C28.0311 15.5833 27.3889 16.2256 27.3889 17C27.3889 17.7744 28.0311 18.4167 28.8056 18.4167H32.5833ZM15.5833 5.19444C15.5833 5.96889 16.2256 6.61111 17 6.61111C17.7744 6.61111 18.4167 5.96889 18.4167 5.19444V1.41667C18.4167 0.642222 17.7744 0 17 0C16.2256 0 15.5833 0.642222 15.5833 1.41667V5.19444ZM24.3478 7.65C23.8 8.19778 23.8 9.10444 24.3478 9.65222C24.8956 10.2 25.8022 10.2 26.35 9.65222L28.3522 7.65C28.9 7.10222 28.9 6.19556 28.3522 5.64778C27.8044 5.1 26.8978 5.1 26.35 5.64778L24.3478 7.65ZM5.64778 26.35C5.1 26.8978 5.1 27.8044 5.64778 28.3522C6.19556 28.9 7.10222 28.9 7.65 28.3522L9.65222 26.35C10.2 25.8022 10.2 24.8956 9.65222 24.3478C9.10444 23.8 8.19778 23.8 7.65 24.3478L5.64778 26.35ZM7.65 9.65222C8.19778 10.2 9.10444 10.2 9.65222 9.65222C10.2 9.10444 10.2 8.19778 9.65222 7.65L7.65 5.64778C7.10222 5.1 6.19556 5.1 5.64778 5.64778C5.1 6.19556 5.1 7.10222 5.64778 7.65L7.65 9.65222ZM26.35 28.3522C26.8978 28.9 27.8044 28.9 28.3522 28.3522C28.9 27.8044 28.9 26.8978 28.3522 26.35L26.35 24.3478C25.8022 23.8 24.8956 23.8 24.3478 24.3478C23.8 24.8956 23.8 25.8022 24.3478 26.35L26.35 28.3522ZM15.5833 32.5833C15.5833 33.3578 16.2256 34 17 34C17.7744 34 18.4167 33.3578 18.4167 32.5833V28.8056C18.4167 28.0311 17.7744 27.3889 17 27.3889C16.2256 27.3889 15.5833 28.0311 15.5833 28.8056V32.5833Z" fill="currentColor" />
                        </svg>
                    </div>
                    <div class="nav-links__mode" id="light-mode">
                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.88 4.25143C10.5346 5.46286 10.3619 6.72 10.3619 8C10.3619 15.1771 15.8883 21.0286 22.6667 21.0286C23.8756 21.0286 25.0629 20.8457 26.207 20.48C24.5016 25.2114 20.1625 28.5714 15.1111 28.5714C8.57016 28.5714 3.2381 22.9257 3.2381 16C3.2381 10.6514 6.41143 6.05714 10.88 4.25143ZM15.1111 0C6.75683 0 0 7.15429 0 16C0 24.8457 6.75683 32 15.1111 32C23.4654 32 30.2222 24.8457 30.2222 16C30.2222 15.1771 30.1575 14.3543 30.0495 13.5771C28.4089 16 25.7105 17.6 22.6667 17.6C17.6584 17.6 13.6 13.3029 13.6 8C13.6 4.77714 15.1111 1.92 17.3994 0.182857C16.6654 0.0685713 15.8883 0 15.1111 0Z" fill="black" />
                        </svg>




                    </div>
                </div>


                <?php
                if ($isCustomer) {
                ?>
                    <div class="nav-links nav-links--desktop">
                        <a href="cart.php">

                            <div class="nav-links__cart">
                                <div class="nav-links__cart__main">
                                    <svg width="43" height="44" viewBox="0 0 43 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_8_16)">
                                            <path d="M21.0645 1.98288C25.3692 1.98288 29.4975 3.80872 32.5414 7.05899C35.5853 10.3093 37.2953 14.7178 37.2953 19.3143H39.1523C39.1523 14.1919 37.2466 9.27923 33.8545 5.6571C30.4623 2.03497 25.8617 6.10352e-05 21.0645 6.10352e-05C16.2673 6.10352e-05 11.6666 2.03497 8.27448 5.6571C4.88236 9.27923 2.97668 14.1919 2.97668 19.3143H4.83363C4.83363 14.7178 6.54366 10.3093 9.58754 7.05899C12.6314 3.80872 16.7598 1.98288 21.0645 1.98288V1.98288Z" fill="currentColor" />
                                            <path d="M26.01 25.5738L20.7262 21.2692L14.5747 21.0715L23.046 27.9431L26.01 25.5738Z" fill="currentColor" />
                                            <path d="M26.9969 31.2329L35.0382 37.7416C35.951 36.8772 36.7922 35.9301 37.5525 34.9112L30.0941 28.8756L26.9969 31.2329Z" fill="currentColor" />
                                            <path d="M13.9714 25.3146L8.98573 21.2692L3.07458 21.359L11.005 27.7788L13.9714 25.3146Z" fill="currentColor" />
                                            <path d="M38.1015 25.5174L32.5918 21.0587L26.7672 21.2102L35.0318 27.8969L38.1015 25.5174Z" fill="currentColor" />
                                            <path d="M27.1467 40.7102L28.5262 41.9501C29.7937 41.4372 31.0118 40.7946 32.1632 40.0309L30.1632 38.4112L27.1467 40.7102Z" fill="currentColor" />
                                            <path d="M15.0796 31.0721L23.0316 37.5073L25.9523 35.0071L18.0003 28.572L15.0796 31.0721Z" fill="currentColor" />
                                            <path d="M0.194946 24.0022C0.298262 24.8049 0.442298 25.601 0.626419 26.3871L1.86081 25.3502L0.194946 24.0022Z" fill="currentColor" />
                                            <path d="M14.9458 40.7966L17.8446 43.1423C19.8574 43.4712 21.904 43.4896 23.9217 43.1968L17.9126 38.3344L14.9458 40.7966Z" fill="currentColor" />
                                            <path d="M13.7839 34.9969L5.87029 28.5925L2.95679 31.0978L10.8704 37.5021L13.7839 34.9969Z" fill="currentColor" />
                                            <path d="M39.3263 21.2715L41.9716 23.7014C42.0605 22.9346 42.1126 22.1634 42.1277 21.3909L39.3263 21.2715Z" fill="currentColor" />
                                            <path d="M26.5845 35.5487L23.7335 37.7357L20.8176 39.9715L23.8273 42.4049L26.7432 40.1691L29.5942 37.9822L32.3034 35.9081L29.2937 33.4721L26.5845 35.5487Z" fill="currentColor" />
                                            <path d="M33.4408 30.2665L35.9828 32.4182L40.8614 28.6218C41.2875 27.3746 41.6086 26.0893 41.8209 24.7812L41.3838 23.9577L33.4408 30.2665Z" fill="currentColor" />
                                            <path d="M26.3128 21.1896L21.5411 21.146L23.8561 23.0121L26.3128 21.1896Z" fill="currentColor" />
                                            <path d="M8.91357 30.0377L11.8728 32.507L14.9593 30.0325L17.4882 28.1587L19.6036 26.4646L16.8488 23.9721L14.5266 25.7638L11.4352 28.1279L8.91357 30.0377Z" fill="currentColor" />
                                            <path d="M3.94531 34.0216C4.67734 35.1088 5.49834 36.1242 6.39864 37.0563L7.5951 36.0966L4.50051 33.576L3.94531 34.0216Z" fill="currentColor" />
                                            <path d="M13.892 21.0536L9.49768 21.1049L11.8391 22.799L13.892 21.0536Z" fill="currentColor" />
                                            <path d="M7.76281 26.2859L4.88104 23.5946L2.2755 25.6846L0.75415 26.905C1.10077 28.2459 1.56392 29.5494 2.13756 30.7983L2.36252 30.6178L5.38059 28.1966L7.76281 26.2859Z" fill="currentColor" />
                                            <path d="M20.9739 30.2764L24.0148 32.738L26.4451 30.7872L29.4644 28.3666L32.1904 26.1796L29.1182 23.7437L26.4211 25.905L23.4042 28.3281L20.9739 30.2764Z" fill="currentColor" />
                                            <path d="M38.2818 21.3077L33.8442 21.3051L36.0606 23.3073L38.2818 21.3077Z" fill="currentColor" />
                                            <path d="M19.7853 36.1304L16.8324 33.5986L14.4348 35.5219L11.4168 37.9431L9.3457 39.6044C10.4667 40.4074 11.6576 41.0932 12.9018 41.6524L14.4584 40.4037L17.4764 37.9825L19.7853 36.1304Z" fill="currentColor" />
                                            <path d="M2.96293 21.3536H0C0.0149838 22.1476 0.069001 22.9404 0.161829 23.7284L0.438612 23.9136L2.96293 21.3536Z" fill="currentColor" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_8_16">
                                                <rect width="42.1277" height="43.4035" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <div class="nav-links__cart__counter">
                                        <?php
                                        echo "$count";
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                <?php
                } 
                ?>


                <?php
                if (isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated']) {
                ?>
                    <!-- If logged in  -->
                    <div class="nav-links nav-links--profile nav-links--desktop">
                        <div class="nav-links__profile">
                            <!-- If user logs in -->
                            <?php
                            if (isset($userImage) && strlen($userImage) > 0) {
                                echo "<img class='navbar-profile-picture' src='./assets/images/profiles/$userImage'/>";
                            } else {

                                echo '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 0.333344C10.04 0.333344 0.333374 10.04 0.333374 22C0.333374 33.96 10.04 43.6667 22 43.6667C33.96 43.6667 43.6667 33.96 43.6667 22C43.6667 10.04 33.96 0.333344 22 0.333344ZM22 6.83334C25.5967 6.83334 28.5 9.73668 28.5 13.3333C28.5 16.93 25.5967 19.8333 22 19.8333C18.4034 19.8333 15.5 16.93 15.5 13.3333C15.5 9.73668 18.4034 6.83334 22 6.83334ZM22 37.6C16.5834 37.6 11.795 34.8267 9.00004 30.6233C9.06504 26.3117 17.6667 23.95 22 23.95C26.3117 23.95 34.935 26.3117 35 30.6233C32.205 34.8267 27.4167 37.6 22 37.6Z" fill="currentColor"/>
                            </svg>';
                            }
                            ?>

                            <div class="nav-dropdown nav-dropdown--profile <?php if (!$isCustomer) echo 'nav-dropdown--trader' ?>">
                                <ul class="nav-dropdown__lists nav-links__profile__lists">

                                    <?php
                                    if ($isCustomer) {
                                    ?>
                                        <li class="nav-dropdown__lists__list">
                                            <a href='orders.php' class="nav-dropdown__lists__list__link">
                                                <div class="nav-dropdown__lists__list__icon">
                                                    <svg width="25" height="25" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.6 29.52V9.84C1.22667 9.78667 0.866667 9.52 0.52 9.04C0.173333 8.56 0 8.04 0 7.48V2.4C0 1.78667 0.24 1.23333 0.72 0.74C1.2 0.246667 1.76 0 2.4 0H29.6C30.2133 0 30.7667 0.246667 31.26 0.74C31.7533 1.23333 32 1.78667 32 2.4V7.48C32 8.04 31.8267 8.56 31.48 9.04C31.1333 9.52 30.7733 9.78667 30.4 9.84V29.52C30.4 30.1333 30.1533 30.7 29.66 31.22C29.1667 31.74 28.6133 32 28 32H4C3.36 32 2.8 31.74 2.32 31.22C1.84 30.7 1.6 30.1333 1.6 29.52ZM4 9.88V29.6H28V9.88H4ZM29.6 7.48V2.4H2.4V7.48H29.6ZM11.2 18.28H20.8V15.88H11.2V18.28ZM4 29.6V9.88V29.6Z" fill="currentColor" />
                                                    </svg>
                                                </div>
                                                <div class="nav-dropdown__lists__list__name">
                                                    My Orders
                                                </div>
                                            </a>
                                        </li>
                                    <?php
                                    } ?>

                                    <?php
                                    if ($isCustomer) {
                                    ?>
                                        <li class="nav-dropdown__lists__list">

                                            <a href='wishlist.php' class="nav-dropdown__lists__list__link">
                                                <div class="nav-dropdown__lists__list__icon">
                                                    <svg width="25" height="24" viewBox="0 0 35 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.4625 32L15.6726 30.3847C10.9286 26.0482 7.13051 22.2647 4.27831 19.0341C1.4261 15.8035 0 12.5293 0 9.21146C0 6.59209 0.8804 4.402 2.6412 2.6412C4.402 0.8804 6.57754 0 9.1678 0C10.6521 0 12.1219 0.356526 13.5771 1.06958C15.0323 1.78263 16.3274 2.95407 17.4625 4.5839C18.7431 2.95407 20.0673 1.78263 21.4352 1.06958C22.8031 0.356526 24.2437 0 25.7572 0C28.3474 0 30.523 0.8804 32.2838 2.6412C34.0446 4.402 34.925 6.59209 34.925 9.21146C34.925 12.5293 33.4989 15.8035 30.6467 19.0341C27.7945 22.2647 23.9964 26.0482 19.2524 30.3847L17.4625 32ZM17.4625 28.5512C21.8863 24.4766 25.4661 20.9404 28.2019 17.9427C30.9377 14.945 32.3056 12.0346 32.3056 9.21146C32.3056 7.29059 31.6871 5.71169 30.4502 4.47476C29.2133 3.23784 27.6489 2.61937 25.7572 2.61937C24.302 2.61937 22.9341 3.07049 21.6535 3.97271C20.3729 4.87494 19.3251 6.17008 18.5102 7.85812H16.3711C15.5853 6.17008 14.5448 4.87494 13.2497 3.97271C11.9545 3.07049 10.5939 2.61937 9.1678 2.61937C7.24693 2.61937 5.67531 3.23784 4.45293 4.47476C3.23056 5.71169 2.61937 7.29059 2.61937 9.21146C2.61937 12.0346 3.98727 14.945 6.72306 17.9427C9.45884 20.9404 13.0387 24.4766 17.4625 28.5512Z" fill="currentColor" />
                                                    </svg>
                                                </div>
                                                <div class="nav-dropdown__lists__list__name">
                                                    My WishList
                                                </div>
                                            </a>
                                        </li>
                                    <?php
                                    } ?>






                                    <li class="nav-dropdown__lists__list">
                                        <a href='account-settings.php' class="nav-dropdown__lists__list__link">
                                            <div class="nav-dropdown__lists__list__icon">
                                                <svg width="25" height="25" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.32 32L11.52 26.96C11.0133 26.7733 10.48 26.52 9.92 26.2C9.36 25.88 8.86667 25.5467 8.44 25.2L3.72 27.36L0 20.8L4.32 17.64C4.26667 17.4 4.23333 17.1267 4.22 16.82C4.20667 16.5133 4.2 16.24 4.2 16C4.2 15.76 4.20667 15.4867 4.22 15.18C4.23333 14.8733 4.26667 14.6 4.32 14.36L0 11.2L3.72 4.64L8.44 6.8C8.86667 6.45333 9.36 6.12 9.92 5.8C10.48 5.48 11.0133 5.24 11.52 5.08L12.32 0H19.68L20.48 5.04C20.9867 5.22667 21.5267 5.47333 22.1 5.78C22.6733 6.08667 23.16 6.42667 23.56 6.8L28.28 4.64L32 11.2L27.68 14.28C27.7333 14.5467 27.7667 14.8333 27.78 15.14C27.7933 15.4467 27.8 15.7333 27.8 16C27.8 16.2667 27.7933 16.5467 27.78 16.84C27.7667 17.1333 27.7333 17.4133 27.68 17.68L32 20.8L28.28 27.36L23.56 25.2C23.1333 25.5467 22.6467 25.8867 22.1 26.22C21.5533 26.5533 21.0133 26.8 20.48 26.96L19.68 32H12.32ZM16 21.2C17.44 21.2 18.6667 20.6933 19.68 19.68C20.6933 18.6667 21.2 17.44 21.2 16C21.2 14.56 20.6933 13.3333 19.68 12.32C18.6667 11.3067 17.44 10.8 16 10.8C14.56 10.8 13.3333 11.3067 12.32 12.32C11.3067 13.3333 10.8 14.56 10.8 16C10.8 17.44 11.3067 18.6667 12.32 19.68C13.3333 20.6933 14.56 21.2 16 21.2ZM16 18.8C15.2267 18.8 14.5667 18.5267 14.02 17.98C13.4733 17.4333 13.2 16.7733 13.2 16C13.2 15.2267 13.4733 14.5667 14.02 14.02C14.5667 13.4733 15.2267 13.2 16 13.2C16.7733 13.2 17.4333 13.4733 17.98 14.02C18.5267 14.5667 18.8 15.2267 18.8 16C18.8 16.7733 18.5267 17.4333 17.98 17.98C17.4333 18.5267 16.7733 18.8 16 18.8ZM14.24 29.6H17.76L18.32 25.12C19.2 24.9067 20.0333 24.5733 20.82 24.12C21.6067 23.6667 22.32 23.12 22.96 22.48L27.2 24.32L28.8 21.44L25.04 18.68C25.1467 18.2267 25.2333 17.78 25.3 17.34C25.3667 16.9 25.4 16.4533 25.4 16C25.4 15.5467 25.3733 15.1 25.32 14.66C25.2667 14.22 25.1733 13.7733 25.04 13.32L28.8 10.56L27.2 7.68L22.96 9.52C22.3467 8.82667 21.6533 8.24667 20.88 7.78C20.1067 7.31333 19.2533 7.01333 18.32 6.88L17.76 2.4H14.24L13.68 6.88C12.7733 7.06667 11.9267 7.38667 11.14 7.84C10.3533 8.29333 9.65333 8.85333 9.04 9.52L4.8 7.68L3.2 10.56L6.96 13.32C6.85333 13.7733 6.76667 14.22 6.7 14.66C6.63333 15.1 6.6 15.5467 6.6 16C6.6 16.4533 6.63333 16.9 6.7 17.34C6.76667 17.78 6.85333 18.2267 6.96 18.68L3.2 21.44L4.8 24.32L9.04 22.48C9.68 23.12 10.3933 23.6667 11.18 24.12C11.9667 24.5733 12.8 24.9067 13.68 25.12L14.24 29.6Z" fill="currentColor" />
                                                </svg>
                                            </div>
                                            <div class="nav-dropdown__lists__list__name">
                                                Account Settings
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-dropdown__lists__list">
                                        <a class="nav-dropdown__lists__list__link" href="logout.php">
                                            <div class="nav-dropdown__lists__list__icon">
                                                <svg width="25" height="25" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.3333 14.6667H26.8L22.2667 10.1333L24.1778 8.22222L32 16.0444L24.2667 23.7778L22.3556 21.8667L26.8889 17.3333H11.3333V14.6667ZM15.6 0V2.66667H2.66667V29.3333H15.6V32H2.66667C1.95556 32 1.33333 31.7333 0.8 31.2C0.266667 30.6667 0 30.0444 0 29.3333V2.66667C0 1.95556 0.266667 1.33333 0.8 0.8C1.33333 0.266667 1.95556 0 2.66667 0H15.6Z" fill="currentColor" />
                                                </svg>
                                            </div>

                                            <div class="nav-dropdown__lists__list__name">
                                                Logout
                                            </div>

                                        </a>
                                    </li>
                                </ul>

                            </div>


                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <!-- if not logged in -->
                    <div class="nav-links nav-links--desktop">
                        <div class="nav-links__profile">

                            <a href="login.php">
                                Login
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>





</body>

</html>