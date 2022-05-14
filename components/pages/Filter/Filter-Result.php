<?php
for($x = 1; $x <= 10; $x++){
echo'<div class="product-card search-card">
<div class="product-card__image search-card__image">
    <img src="assets/images/spinach.jpg" class="search-card__image__img"/>
    <div class="product-card__wishlist">
        <div class="product-card__wishlist__btn">
            <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.325 0C10.846 0 9.4265 0.662125 8.5 1.70845C7.5735 0.662125 6.154 0 4.675 0C2.057 0 0 1.9782 0 4.49591C0 7.58583 2.89 10.1035 7.2675 13.9292L8.5 15L9.7325 13.921C14.11 10.1035 17 7.58583 17 4.49591C17 1.9782 14.943 0 12.325 0ZM8.585 12.7112L8.5 12.7929L8.415 12.7112C4.369 9.18801 1.7 6.85831 1.7 4.49591C1.7 2.86104 2.975 1.63488 4.675 1.63488C5.984 1.63488 7.259 2.44414 7.7095 3.56403H9.299C9.741 2.44414 11.016 1.63488 12.325 1.63488C14.025 1.63488 15.3 2.86104 15.3 4.49591C15.3 6.85831 12.631 9.18801 8.585 12.7112Z" fill="#838383"/>
            </svg>
        </div>
        <div class="product-card__wishlist__btn product-card__wishlist__btn--clicked">
        </div>               
    </div>
</div>
<div class="product-card__details search-card-detail">
    <div class="product-card__details__name">
        Spinach Krantikari 
    </div>
    <div class="product-card__details__price">
        Rs. 100
        <span class="product-card__details__price__discount-price">
        </span>
    </div>
    <div class="product-card__details__vendor">                
        Sold By : Greengrocers
    </div>
    <div class="product-card__details__star-rating">              
        <div class="product-card__details__star-rating__stars">
            <div class="indi-star">
                <img src="assets/images/star/filled-star.svg"/>
            </div> 
                <div class="indi-star">
                <img src="assets/images/star/filled-star.svg"/>
            </div> 
            <div class="indi-star">
                <img src="assets/images/star/filled-star.svg"/>
            </div> 
            <div class="indi-star">
                <img src="assets/images/star/empty-star.svg"/>
            </div>
                <div class="indi-star">
                <img src="assets/images/star/empty-star.svg"/>
            </div>
        </div>
        <span class="product-card__details__star-rating__count">(15)</span>
    </div>
    <div class="product-card__details__cart-btn">
    <a href=
        index.php?product_id=4&qty=1>

        <button class="btn primary-btn card-btn">
            Add to Cart
        </button>
        </a>
    </div>
</div>
</div>';
}

?>