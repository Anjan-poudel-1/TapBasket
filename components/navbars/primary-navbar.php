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

                        <img src="./assets/images/logo-01.png"/>

                    </div>

                    <div class="nav-links nav-links--desktop">
                    <a href="index.php">
                    Home
                    </a>
                        
                    </div>

                    <div class="nav-links nav-links--products ">



                        <div class="nav-links__products">
                            Products

                        </div>

                        <div class="nav-dropdown nav-dropdown--products">

                            <ul class="nav-dropdown__lists nav-links__products__lists">
                                
                                <li class="nav-dropdown__lists__list">
                                    Fish Monger
                                </li>
                                <li class="nav-dropdown__lists__list">
                                    Green Grocesser
                                </li>
                                <li class="nav-dropdown__lists__list">
                                    Aru koi 
                                </li>
                                <li class="nav-dropdown__lists__list">
                                    Mero pasal
                                </li>
                                <li class="nav-dropdown__lists__list">
                                    New shop
                                </li>

                            </ul>

                       
                        </div>
                        
                        
                    </div>

                    <div class="nav-links ">
                         Deals
                        
                    </div>



                </div>

                <div class="primary-navbar__content__search">

                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.3399 16.7482H17.2061L16.8042 16.3607C18.2108 14.7245 19.0576 12.6003 19.0576 10.2896C19.0576 5.137 14.881 0.960419 9.72843 0.960419C4.57587 0.960419 0.399292 5.137 0.399292 10.2896C0.399292 15.4421 4.57587 19.6187 9.72843 19.6187C12.0392 19.6187 14.1634 18.7719 15.7995 17.3653L16.1871 17.7672V18.9011L23.3633 26.063L25.5018 23.9244L18.3399 16.7482ZM9.72843 16.7482C6.15465 16.7482 3.2698 13.8633 3.2698 10.2896C3.2698 6.71578 6.15465 3.83092 9.72843 3.83092C13.3022 3.83092 16.1871 6.71578 16.1871 10.2896C16.1871 13.8633 13.3022 16.7482 9.72843 16.7482Z" fill="black"/>
                    </svg>

                    <input class="primary-navbar__content__search__field" placeholder="Search products,shop or keyword"/>


                </div>

                <div class="primary-navbar__content__right">

                    <div class="nav-links " id="theme-change" onclick="toggleTheme()">
                        <div class="nav-links__mode" id="dark-mode">
                            <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 9.44444C21.1744 9.44444 24.5556 12.8256 24.5556 17C24.5556 21.1744 21.1744 24.5556 17 24.5556C12.8256 24.5556 9.44444 21.1744 9.44444 17C9.44444 12.8256 12.8256 9.44444 17 9.44444ZM5.19444 18.4167C5.96889 18.4167 6.61111 17.7744 6.61111 17C6.61111 16.2256 5.96889 15.5833 5.19444 15.5833H1.41667C0.642222 15.5833 0 16.2256 0 17C0 17.7744 0.642222 18.4167 1.41667 18.4167H5.19444ZM32.5833 18.4167C33.3578 18.4167 34 17.7744 34 17C34 16.2256 33.3578 15.5833 32.5833 15.5833H28.8056C28.0311 15.5833 27.3889 16.2256 27.3889 17C27.3889 17.7744 28.0311 18.4167 28.8056 18.4167H32.5833ZM15.5833 5.19444C15.5833 5.96889 16.2256 6.61111 17 6.61111C17.7744 6.61111 18.4167 5.96889 18.4167 5.19444V1.41667C18.4167 0.642222 17.7744 0 17 0C16.2256 0 15.5833 0.642222 15.5833 1.41667V5.19444ZM24.3478 7.65C23.8 8.19778 23.8 9.10444 24.3478 9.65222C24.8956 10.2 25.8022 10.2 26.35 9.65222L28.3522 7.65C28.9 7.10222 28.9 6.19556 28.3522 5.64778C27.8044 5.1 26.8978 5.1 26.35 5.64778L24.3478 7.65ZM5.64778 26.35C5.1 26.8978 5.1 27.8044 5.64778 28.3522C6.19556 28.9 7.10222 28.9 7.65 28.3522L9.65222 26.35C10.2 25.8022 10.2 24.8956 9.65222 24.3478C9.10444 23.8 8.19778 23.8 7.65 24.3478L5.64778 26.35ZM7.65 9.65222C8.19778 10.2 9.10444 10.2 9.65222 9.65222C10.2 9.10444 10.2 8.19778 9.65222 7.65L7.65 5.64778C7.10222 5.1 6.19556 5.1 5.64778 5.64778C5.1 6.19556 5.1 7.10222 5.64778 7.65L7.65 9.65222ZM26.35 28.3522C26.8978 28.9 27.8044 28.9 28.3522 28.3522C28.9 27.8044 28.9 26.8978 28.3522 26.35L26.35 24.3478C25.8022 23.8 24.8956 23.8 24.3478 24.3478C23.8 24.8956 23.8 25.8022 24.3478 26.35L26.35 28.3522ZM15.5833 32.5833C15.5833 33.3578 16.2256 34 17 34C17.7744 34 18.4167 33.3578 18.4167 32.5833V28.8056C18.4167 28.0311 17.7744 27.3889 17 27.3889C16.2256 27.3889 15.5833 28.0311 15.5833 28.8056V32.5833Z" fill="currentColor"/>
                            </svg>
                        </div >
                        <div class="nav-links__mode" id="light-mode">
                            <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.88 4.25143C10.5346 5.46286 10.3619 6.72 10.3619 8C10.3619 15.1771 15.8883 21.0286 22.6667 21.0286C23.8756 21.0286 25.0629 20.8457 26.207 20.48C24.5016 25.2114 20.1625 28.5714 15.1111 28.5714C8.57016 28.5714 3.2381 22.9257 3.2381 16C3.2381 10.6514 6.41143 6.05714 10.88 4.25143ZM15.1111 0C6.75683 0 0 7.15429 0 16C0 24.8457 6.75683 32 15.1111 32C23.4654 32 30.2222 24.8457 30.2222 16C30.2222 15.1771 30.1575 14.3543 30.0495 13.5771C28.4089 16 25.7105 17.6 22.6667 17.6C17.6584 17.6 13.6 13.3029 13.6 8C13.6 4.77714 15.1111 1.92 17.3994 0.182857C16.6654 0.0685713 15.8883 0 15.1111 0Z" fill="black"/>
                            </svg>
                                
                                
                                
                                
                        </div >

                    </div>
                   


                    <div class="nav-links nav-links--desktop">
                        <div class="nav-links__cart">
                        <div class="nav-links__cart__main">

                            <svg width="43" height="44" viewBox="0 0 43 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_8_16)">
                                <path d="M21.0645 1.98288C25.3692 1.98288 29.4975 3.80872 32.5414 7.05899C35.5853 10.3093 37.2953 14.7178 37.2953 19.3143H39.1523C39.1523 14.1919 37.2466 9.27923 33.8545 5.6571C30.4623 2.03497 25.8617 6.10352e-05 21.0645 6.10352e-05C16.2673 6.10352e-05 11.6666 2.03497 8.27448 5.6571C4.88236 9.27923 2.97668 14.1919 2.97668 19.3143H4.83363C4.83363 14.7178 6.54366 10.3093 9.58754 7.05899C12.6314 3.80872 16.7598 1.98288 21.0645 1.98288V1.98288Z" fill="currentColor"/>
                                <path d="M26.01 25.5738L20.7262 21.2692L14.5747 21.0715L23.046 27.9431L26.01 25.5738Z" fill="currentColor"/>
                                <path d="M26.9969 31.2329L35.0382 37.7416C35.951 36.8772 36.7922 35.9301 37.5525 34.9112L30.0941 28.8756L26.9969 31.2329Z" fill="currentColor"/>
                                <path d="M13.9714 25.3146L8.98573 21.2692L3.07458 21.359L11.005 27.7788L13.9714 25.3146Z" fill="currentColor"/>
                                <path d="M38.1015 25.5174L32.5918 21.0587L26.7672 21.2102L35.0318 27.8969L38.1015 25.5174Z" fill="currentColor"/>
                                <path d="M27.1467 40.7102L28.5262 41.9501C29.7937 41.4372 31.0118 40.7946 32.1632 40.0309L30.1632 38.4112L27.1467 40.7102Z" fill="currentColor"/>
                                <path d="M15.0796 31.0721L23.0316 37.5073L25.9523 35.0071L18.0003 28.572L15.0796 31.0721Z" fill="currentColor"/>
                                <path d="M0.194946 24.0022C0.298262 24.8049 0.442298 25.601 0.626419 26.3871L1.86081 25.3502L0.194946 24.0022Z" fill="currentColor"/>
                                <path d="M14.9458 40.7966L17.8446 43.1423C19.8574 43.4712 21.904 43.4896 23.9217 43.1968L17.9126 38.3344L14.9458 40.7966Z" fill="currentColor"/>
                                <path d="M13.7839 34.9969L5.87029 28.5925L2.95679 31.0978L10.8704 37.5021L13.7839 34.9969Z" fill="currentColor"/>
                                <path d="M39.3263 21.2715L41.9716 23.7014C42.0605 22.9346 42.1126 22.1634 42.1277 21.3909L39.3263 21.2715Z" fill="currentColor"/>
                                <path d="M26.5845 35.5487L23.7335 37.7357L20.8176 39.9715L23.8273 42.4049L26.7432 40.1691L29.5942 37.9822L32.3034 35.9081L29.2937 33.4721L26.5845 35.5487Z" fill="currentColor"/>
                                <path d="M33.4408 30.2665L35.9828 32.4182L40.8614 28.6218C41.2875 27.3746 41.6086 26.0893 41.8209 24.7812L41.3838 23.9577L33.4408 30.2665Z" fill="currentColor"/>
                                <path d="M26.3128 21.1896L21.5411 21.146L23.8561 23.0121L26.3128 21.1896Z" fill="currentColor"/>
                                <path d="M8.91357 30.0377L11.8728 32.507L14.9593 30.0325L17.4882 28.1587L19.6036 26.4646L16.8488 23.9721L14.5266 25.7638L11.4352 28.1279L8.91357 30.0377Z" fill="currentColor"/>
                                <path d="M3.94531 34.0216C4.67734 35.1088 5.49834 36.1242 6.39864 37.0563L7.5951 36.0966L4.50051 33.576L3.94531 34.0216Z" fill="currentColor"/>
                                <path d="M13.892 21.0536L9.49768 21.1049L11.8391 22.799L13.892 21.0536Z" fill="currentColor"/>
                                <path d="M7.76281 26.2859L4.88104 23.5946L2.2755 25.6846L0.75415 26.905C1.10077 28.2459 1.56392 29.5494 2.13756 30.7983L2.36252 30.6178L5.38059 28.1966L7.76281 26.2859Z" fill="currentColor"/>
                                <path d="M20.9739 30.2764L24.0148 32.738L26.4451 30.7872L29.4644 28.3666L32.1904 26.1796L29.1182 23.7437L26.4211 25.905L23.4042 28.3281L20.9739 30.2764Z" fill="currentColor"/>
                                <path d="M38.2818 21.3077L33.8442 21.3051L36.0606 23.3073L38.2818 21.3077Z" fill="currentColor"/>
                                <path d="M19.7853 36.1304L16.8324 33.5986L14.4348 35.5219L11.4168 37.9431L9.3457 39.6044C10.4667 40.4074 11.6576 41.0932 12.9018 41.6524L14.4584 40.4037L17.4764 37.9825L19.7853 36.1304Z" fill="currentColor"/>
                                <path d="M2.96293 21.3536H0C0.0149838 22.1476 0.069001 22.9404 0.161829 23.7284L0.438612 23.9136L2.96293 21.3536Z" fill="currentColor"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_8_16">
                                <rect width="42.1277" height="43.4035" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>
                                

                                <div class="nav-links__cart__counter">
                                    0
                                </div>
                        </div>
                       

                        </div>
                    </div>


                <div class="nav-links nav-links--profile nav-links--desktop">

                    <div class="nav-links__profile">

                        <!-- If user logs in -->
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 0.333344C10.04 0.333344 0.333374 10.04 0.333374 22C0.333374 33.96 10.04 43.6667 22 43.6667C33.96 43.6667 43.6667 33.96 43.6667 22C43.6667 10.04 33.96 0.333344 22 0.333344ZM22 6.83334C25.5967 6.83334 28.5 9.73668 28.5 13.3333C28.5 16.93 25.5967 19.8333 22 19.8333C18.4034 19.8333 15.5 16.93 15.5 13.3333C15.5 9.73668 18.4034 6.83334 22 6.83334ZM22 37.6C16.5834 37.6 11.795 34.8267 9.00004 30.6233C9.06504 26.3117 17.6667 23.95 22 23.95C26.3117 23.95 34.935 26.3117 35 30.6233C32.205 34.8267 27.4167 37.6 22 37.6Z" fill="currentColor"/>
                        </svg>

                        <div class="nav-dropdown nav-dropdown--profile">

                            <ul class="nav-dropdown__lists nav-links__profile__lists">
                                
                                <li class="nav-dropdown__lists__list">
                                    <a href='account-settings.php' class="nav-dropdown__lists__list__link">
                                        <div class="nav-dropdown__lists__list__icon">

                                            I
                                        </div>

                                         <div class="nav-dropdown__lists__list__name">

                                            Account Settings
                                        </div>
                                    </a>

                                </li>
                                <li class="nav-dropdown__lists__list">
                                    <a href='../../account-settings.html' class="nav-dropdown__lists__list__link">
                                        <div class="nav-dropdown__lists__list__icon">

                                            I
                                        </div>

                                         <div class="nav-dropdown__lists__list__name">

                                            My Orders
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-dropdown__lists__list">
                                   
                                    <a href='../../account-settings.html' class="nav-dropdown__lists__list__link">
                                        <div class="nav-dropdown__lists__list__icon">

                                            I
                                        </div>

                                         <div class="nav-dropdown__lists__list__name">

                                            My WishList
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-dropdown__lists__list">
                                    <a href='../../account-settings.html' class="nav-dropdown__lists__list__link">
                                        <div class="nav-dropdown__lists__list__icon">

                                            I
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

                 <!-- if not logged in -->
                <!-- <div class="nav-links nav-links--desktop">

                    <div class="nav-links__profile">
                       

                      <a href="login.php">
                            Login
                        </a> -->
                    </div>
                </div> 

                </div>


            


   
   
   
   
            </body>
</html>