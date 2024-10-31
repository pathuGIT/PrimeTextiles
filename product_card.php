<?php
function displayProductCard($product_id, $product_title, $product_image_one, $product_price) {
    $product_image_one = $product_image_one ? $product_image_one : 'default-product.jpg';
    echo "
    <div class='product-card'>
        <div class='product-image'>
            <img src='./assets/images/products/$product_image_one' alt='$product_title'>
            <div class='overlay'>
                <a href='products.php?add_to_cart=$product_id' class='btn add-to-cart'>Add To Cart</a>
                <a href='product_details.php?product_id=$product_id' class='btn view-details'>View More</a>
            </div>
        </div>
        <div class='product-info'>
            <h4 class='product-title'>$product_title</h4>
            <div class='product-price'>\$$product_price</div>
            <div class='rating'>
                <span class='stars'>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                <span class='review-count'>(35)</span>
            </div>
        </div>
    </div>
    ";
}
?>
