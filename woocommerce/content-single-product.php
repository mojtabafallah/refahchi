<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div class="container">
    <nav>
        <?php $args = array(
            'delimiter' => '/'
        );
        woocommerce_breadcrumb( $args );
        ?>

    </nav>
    <article class="c-product">

        <section id="product-<?php the_ID(); ?>" <?php wc_product_class('c-product__info', $product); ?>>


            <div class="c-product__headline">
                <?php do_action('custom_single_title'); ?>
            </div>
            <div class="c-product__attributes">

                <?php do_action("custom_attribute"); ?>


                <div class="c-product__summary">
                    <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 40
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 3
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 5
                     * @hooked get_vendor - 1 in custom
                     * @hooked  delivery - 2 in custom
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    do_action('woocommerce_single_product_summary');
                    ?>

                </div>

            </div>
            <aside class="c-product__feature">

                <a class="i-item" href="#"> <img src="<?php echo URL_THEME ?>/assets/images/icon/i2.svg" alt=""> <span>پشتیبانی ۲۴ ساعته</span>
                </a>
                <a class="i-item" href="#"> <img src="<?php echo URL_THEME ?>/assets/images/icon/i3.svg" alt="">
                    <span>امکان پرداخت در محل</span> </a>

                <a class="i-item" href="#"> <img src="<?php echo URL_THEME ?>/assets/images/icon/i5.svg" alt="">
                    <span>ضمانت اصل بودن کالا</span> </a>
            </aside>
        </section>
        <section class="c-product__gallery">
            <div class="c-product__special-deal hidden">
                <div class="c-counter--special-deal"></div>
            </div>
            <div class="c-product__status-bar c-product__status-bar--out-of-stock hidden">ناموجود</div>
            <div class="c-gallery">

                <?php
                /**
                 * Hook: woocommerce_before_single_product_summary.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
                ?>
            </div>
        </section>
    </article>
    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 9
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>
<?php do_action('woocommerce_after_single_product'); ?>
