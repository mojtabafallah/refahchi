<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;
global $wpdb;
?>
<div class="c-price original <?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php echo $product->get_price_html(); ?></div>
<div class="c-price original <?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">


</div>
<div>
    <?php
     include URI_THEME . "/app/jdf.php";
    global $product;

    echo ' آخرین بروز رسانی  ' .jdate("F j, Y, g:i a", strtotime($product->get_date_modified()->date('F j, Y, g:i a'))) . '';
    ?>
</div>

