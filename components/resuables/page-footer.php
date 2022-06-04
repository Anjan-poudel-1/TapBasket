<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class=" page-footer">
        <div class="container">

        <div class="page-footer-wrapper">

        
        <div class="page-footer__desc">

            <div class="page-footer__desc__logo">
                <img src="./assets/images/logo-01.png"/>
            </div>
            <div class="page-footer__desc__content">
            The most convinent way to shop for locally produced products. Bought to you by the traders of Cleckhudderfax. Shop from anywhere, at any time.

            </div>

        </div>

        <?php
         if($isCustomer){
         ?>
        <div class=" page-footer__quick-links">
            <div class="page-footer__quick-links__header">
                Quick Links
            </div>
            <div class="page-footer__quick-links__links">
                <ul>
                    <a href="index.php">
                    <li>
                        Home
                    </li>
                    </a>
                    <a href="filter.php">
                    <li>
                        Products
                    </li>
                    </a>
                    <a href="maintopdeal.php">
                    <li>
                        Top deals
                    </li>
                    </a>
                </ul>

            </div>
        </div>
        <?php
         }
        ?>

        <div class="page-footer__map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4214.166951628822!2d-1.7896147353595446!3d53.64481247373158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487962132bcdb7bb%3A0x653c3a498c896a17!2sHuddersfield%2C%20UK!5e0!3m2!1sen!2snp!4v1649555480070!5m2!1sen!2snp" width="350" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>


        </div>

       
    
        </div>

    </div>
</body>
</html>