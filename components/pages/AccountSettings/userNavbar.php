<?php

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM USERS WHERE USER_ID=$user_id";
$stid = oci_parse($conn,$sql);
oci_execute($stid);

while (($row = oci_fetch_object($stid)) != false) {
    // Use upper case attribute names for each standard Oracle column
    $user_name= $row->USERNAME ;
    $user_email =  $row->EMAIL; 
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
<div class="user-dashboard__menu">
                    <div class="user-dashboard__menu__profile-details">
                        <div>
                        <div class="user-dashboard__menu__profile-details__name">
                            <?php
                            if(isset($user_name))
                                echo $user_name;
                            ?>
                        </div>
                        <div class="user-dashboard__menu__profile-details__email">
                            <?php
                            if(isset($user_email))
                                echo $user_email;
                            ?>
                        </div>
                        </div>
                        <div class="mobile-view" style="cursor: pointer;">
                        <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.3333 14.6667H26.8L22.2667 10.1333L24.1778 8.22222L32 16.0444L24.2667 23.7778L22.3556 21.8667L26.8889 17.3333H11.3333V14.6667ZM15.6 0V2.66667H2.66667V29.3333H15.6V32H2.66667C1.95556 32 1.33333 31.7333 0.8 31.2C0.266667 30.6667 0 30.0444 0 29.3333V2.66667C0 1.95556 0.266667 1.33333 0.8 0.8C1.33333 0.266667 1.95556 0 2.66667 0H15.6Z" fill="currentColor"/>
</svg>

                        </div>

                    </div>
                    <div class="user-dashboard__menu__nav">
                        <a href="orders.php">

                        <div class="user-dashboard__menu__nav__list 
                        <?php
                         if($pageName && $pageName=="order")  
                         echo"user-dashboard__menu__nav__list--active"?>
                         ">


                            <div class="user-dashboard__menu__nav__list__icon">
                                <svg width="18" height="18" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.6 29.52V9.84C1.22667 9.78667 0.866667 9.52 0.52 9.04C0.173333 8.56 0 8.04 0 7.48V2.4C0 1.78667 0.24 1.23333 0.72 0.74C1.2 0.246667 1.76 0 2.4 0H29.6C30.2133 0 30.7667 0.246667 31.26 0.74C31.7533 1.23333 32 1.78667 32 2.4V7.48C32 8.04 31.8267 8.56 31.48 9.04C31.1333 9.52 30.7733 9.78667 30.4 9.84V29.52C30.4 30.1333 30.1533 30.7 29.66 31.22C29.1667 31.74 28.6133 32 28 32H4C3.36 32 2.8 31.74 2.32 31.22C1.84 30.7 1.6 30.1333 1.6 29.52ZM4 9.88V29.6H28V9.88H4ZM29.6 7.48V2.4H2.4V7.48H29.6ZM11.2 18.28H20.8V15.88H11.2V18.28ZM4 29.6V9.88V29.6Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="user-dashboard__menu__nav__list__details">
                                <div class="user-dashboard__menu__nav__list__details__name desktop-view">
                                    My Orders
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__name mobile-view">
                                    Orders
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__sub">
                                    Purchase Hiistory
                                </div>
                            </div>
                            <div class="user-dashboard__menu__nav__list__arrow">
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 7L3.8671 4.1329L1 1.2658" stroke="#7A7585" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                        </div>
                        </a>
                        
                        <a href="wishlist.php">
                        <div class="user-dashboard__menu__nav__list
                        <?php
                         if($pageName && $pageName=="wishlist")  
                         echo"user-dashboard__menu__nav__list--active"?>
                        ">
                            <div class="user-dashboard__menu__nav__list__icon">
                                <svg width="18" height="19" viewBox="0 0 35 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.4625 32L15.6726 30.3847C10.9286 26.0482 7.13051 22.2647 4.27831 19.0341C1.4261 15.8035 0 12.5293 0 9.21146C0 6.59209 0.8804 4.402 2.6412 2.6412C4.402 0.8804 6.57754 0 9.1678 0C10.6521 0 12.1219 0.356526 13.5771 1.06958C15.0323 1.78263 16.3274 2.95407 17.4625 4.5839C18.7431 2.95407 20.0673 1.78263 21.4352 1.06958C22.8031 0.356526 24.2437 0 25.7572 0C28.3474 0 30.523 0.8804 32.2838 2.6412C34.0446 4.402 34.925 6.59209 34.925 9.21146C34.925 12.5293 33.4989 15.8035 30.6467 19.0341C27.7945 22.2647 23.9964 26.0482 19.2524 30.3847L17.4625 32ZM17.4625 28.5512C21.8863 24.4766 25.4661 20.9404 28.2019 17.9427C30.9377 14.945 32.3056 12.0346 32.3056 9.21146C32.3056 7.29059 31.6871 5.71169 30.4502 4.47476C29.2133 3.23784 27.6489 2.61937 25.7572 2.61937C24.302 2.61937 22.9341 3.07049 21.6535 3.97271C20.3729 4.87494 19.3251 6.17008 18.5102 7.85812H16.3711C15.5853 6.17008 14.5448 4.87494 13.2497 3.97271C11.9545 3.07049 10.5939 2.61937 9.1678 2.61937C7.24693 2.61937 5.67531 3.23784 4.45293 4.47476C3.23056 5.71169 2.61937 7.29059 2.61937 9.21146C2.61937 12.0346 3.98727 14.945 6.72306 17.9427C9.45884 20.9404 13.0387 24.4766 17.4625 28.5512Z" fill="currentColor"/>
                                </svg>

                            </div>
                            <div class="user-dashboard__menu__nav__list__details">
                                <div class="user-dashboard__menu__nav__list__details__name desktop-view">
                                    My WishList
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__name mobile-view">
                                     WishList
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__sub">
                                    Saved Items
                                </div>
                            </div>
                            <div class="user-dashboard__menu__nav__list__arrow">
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 7L3.8671 4.1329L1 1.2658" stroke="#7A7585" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                        </div>
                        </a>

                        <a href="account-settings.php">

                        
                        <div class="user-dashboard__menu__nav__list
                        <?php
                         if($pageName && $pageName=="settings")  
                         echo"user-dashboard__menu__nav__list--active"?>
                        ">
                            <div class="user-dashboard__menu__nav__list__icon">
                            <svg width="18" height="18" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.32 32L11.52 26.96C11.0133 26.7733 10.48 26.52 9.92 26.2C9.36 25.88 8.86667 25.5467 8.44 25.2L3.72 27.36L0 20.8L4.32 17.64C4.26667 17.4 4.23333 17.1267 4.22 16.82C4.20667 16.5133 4.2 16.24 4.2 16C4.2 15.76 4.20667 15.4867 4.22 15.18C4.23333 14.8733 4.26667 14.6 4.32 14.36L0 11.2L3.72 4.64L8.44 6.8C8.86667 6.45333 9.36 6.12 9.92 5.8C10.48 5.48 11.0133 5.24 11.52 5.08L12.32 0H19.68L20.48 5.04C20.9867 5.22667 21.5267 5.47333 22.1 5.78C22.6733 6.08667 23.16 6.42667 23.56 6.8L28.28 4.64L32 11.2L27.68 14.28C27.7333 14.5467 27.7667 14.8333 27.78 15.14C27.7933 15.4467 27.8 15.7333 27.8 16C27.8 16.2667 27.7933 16.5467 27.78 16.84C27.7667 17.1333 27.7333 17.4133 27.68 17.68L32 20.8L28.28 27.36L23.56 25.2C23.1333 25.5467 22.6467 25.8867 22.1 26.22C21.5533 26.5533 21.0133 26.8 20.48 26.96L19.68 32H12.32ZM16 21.2C17.44 21.2 18.6667 20.6933 19.68 19.68C20.6933 18.6667 21.2 17.44 21.2 16C21.2 14.56 20.6933 13.3333 19.68 12.32C18.6667 11.3067 17.44 10.8 16 10.8C14.56 10.8 13.3333 11.3067 12.32 12.32C11.3067 13.3333 10.8 14.56 10.8 16C10.8 17.44 11.3067 18.6667 12.32 19.68C13.3333 20.6933 14.56 21.2 16 21.2ZM16 18.8C15.2267 18.8 14.5667 18.5267 14.02 17.98C13.4733 17.4333 13.2 16.7733 13.2 16C13.2 15.2267 13.4733 14.5667 14.02 14.02C14.5667 13.4733 15.2267 13.2 16 13.2C16.7733 13.2 17.4333 13.4733 17.98 14.02C18.5267 14.5667 18.8 15.2267 18.8 16C18.8 16.7733 18.5267 17.4333 17.98 17.98C17.4333 18.5267 16.7733 18.8 16 18.8ZM14.24 29.6H17.76L18.32 25.12C19.2 24.9067 20.0333 24.5733 20.82 24.12C21.6067 23.6667 22.32 23.12 22.96 22.48L27.2 24.32L28.8 21.44L25.04 18.68C25.1467 18.2267 25.2333 17.78 25.3 17.34C25.3667 16.9 25.4 16.4533 25.4 16C25.4 15.5467 25.3733 15.1 25.32 14.66C25.2667 14.22 25.1733 13.7733 25.04 13.32L28.8 10.56L27.2 7.68L22.96 9.52C22.3467 8.82667 21.6533 8.24667 20.88 7.78C20.1067 7.31333 19.2533 7.01333 18.32 6.88L17.76 2.4H14.24L13.68 6.88C12.7733 7.06667 11.9267 7.38667 11.14 7.84C10.3533 8.29333 9.65333 8.85333 9.04 9.52L4.8 7.68L3.2 10.56L6.96 13.32C6.85333 13.7733 6.76667 14.22 6.7 14.66C6.63333 15.1 6.6 15.5467 6.6 16C6.6 16.4533 6.63333 16.9 6.7 17.34C6.76667 17.78 6.85333 18.2267 6.96 18.68L3.2 21.44L4.8 24.32L9.04 22.48C9.68 23.12 10.3933 23.6667 11.18 24.12C11.9667 24.5733 12.8 24.9067 13.68 25.12L14.24 29.6Z" fill="currentColor"/>
                            </svg>

                            </div>
                            <div class="user-dashboard__menu__nav__list__details">
                                <div class="user-dashboard__menu__nav__list__details__name desktop-view">
                                   Account Settings
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__name mobile-view">
                                   Settings
                                </div>
                                <div class="user-dashboard__menu__nav__list__details__sub">
                                   Settings 
                                </div>
                            </div>
                            <div class="user-dashboard__menu__nav__list__arrow">
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 7L3.8671 4.1329L1 1.2658" stroke="#7A7585" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                        </div>
                        </a>

                        <a href="logout.php">
                        <div class="user-dashboard__menu__nav__list user-dashboard__menu__nav__list--logout">
                            <div class="user-dashboard__menu__nav__list__icon">
                            <svg width="18" height="18" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.3333 14.6667H26.8L22.2667 10.1333L24.1778 8.22222L32 16.0444L24.2667 23.7778L22.3556 21.8667L26.8889 17.3333H11.3333V14.6667ZM15.6 0V2.66667H2.66667V29.3333H15.6V32H2.66667C1.95556 32 1.33333 31.7333 0.8 31.2C0.266667 30.6667 0 30.0444 0 29.3333V2.66667C0 1.95556 0.266667 1.33333 0.8 0.8C1.33333 0.266667 1.95556 0 2.66667 0H15.6Z" fill="currentColor"/>
</svg>


                            </div>

                            <div class="user-dashboard__menu__nav__list__details">
                                <div class="user-dashboard__menu__nav__list__details__name desktop-view">
                                    Logout
                                </div>
                            </div>
                            
                        </div>
                        </a>


                    </div>

                </div> 
</body>
</html>