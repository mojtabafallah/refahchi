<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($upsells) : ?>




    <section class="product-wrapper container">

        <?php
        $heading = apply_filters('woocommerce_product_upsells_products_heading', __('You may also like&hellip;', 'woocommerce'));

        if ($heading) :
            ?>
            <div class="headline">
                <h3>خریداران این محصول، محصولات زیر را هم خریده‌اند</h3></div>
        <?php endif; ?>
        <div id="vpslider" class="swiper-container">
            <div class="product-box swiper-wrapper">
                <?php //woocommerce_product_loop_start(); ?>

                <?php foreach ($upsells as $upsell) : ?>
                    <div class="product-item swiper-slide">
                        <?php
                        $post_object = get_post($upsell->get_id());

                        setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                        wc_get_template_part('content', 'product');
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="vpslider-nbtn" class="slider-nbtn swiper-button-next"></div>
            <div id="vpslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
        </div>

        <?php// woocommerce_product_loop_end(); ?>

    </section>

<?php
endif;

wp_reset_postdata();
