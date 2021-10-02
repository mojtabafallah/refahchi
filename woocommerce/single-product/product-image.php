<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$gallery = $product->get_gallery_image_ids();


$product = wc_get_product($product->get_id());
$image_id = $product->get_image_id();
$image_url = wp_get_attachment_image_url($image_id, 'full');
?>


<div class="c-gallery__item">
    <ul class="c-gallery__options">
        <li>
            <?php
            $id_user = get_current_user_id();
            $id_product = $product->get_id();
            $fav = get_user_meta($id_user, "fav_product", true);


            if ($fav) {
                if (in_array($id_product, $fav)): ?>
                    <button class="btn-option btn-option--add-to-wish added_fav"></button>
                <?php else:?>
                    <button class="btn-option btn-option--add-to-wish removed_fav"></button>
                <?php endif;
            }else{ ?>
                <button class="btn-option btn-option--add-to-wish removed_fav"></button>
            <?php }
            ?>


        </li>
        <li>
            <button class="btn-option btn-option--social"></button>
        </li>
        <li>
            <button class="btn-option btn-option--compare"></button>
        </li>
        <li>
            <button class="btn-option btn-option--stats"></button>
        </li>
    </ul>
    <div class="c-gallery__img"><img src="<?php echo $image_url ?>" class="xzoom" alt=""></div>
</div>
<ul class="c-gallery__items">
    <?php foreach ($gallery as $glry): ?>
        <?php $src = wp_get_attachment_url($glry) ?>
        <li><img src="<?php echo $src ?>" alt=""></li>
    <?php endforeach; ?>


</ul>

