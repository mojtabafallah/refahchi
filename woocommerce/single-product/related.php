<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($related_products) : ?>

    <section class="product-wrapper container">


        <?php
        $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));

        if ($heading) :
            ?>
            <div class="headline">
                <h3><?php echo esc_html($heading); ?></h3>
            </div>
        <?php endif; ?>

        <div id="pslider" class="swiper-container">
            <div class="product-box swiper-wrapper">
                <?php foreach ($related_products as $related_product) : ?>
                    <div class="product-item swiper-slide">


                        <?php
                        $post_object = get_post($related_product->get_id());

                        setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                        //            wc_get_template_part('content', 'product');
                        global $product;

                        ?>
                        <a href="<?php echo get_the_permalink() ?>"><img
                                    src="<?php echo get_the_post_thumbnail_url() ?>"
                                    alt=""></a>
                        <a class="title" href="<?php echo get_the_permalink() ?>"><?php the_title() ?></a>

                        <?php if ($product->get_price()): ?>
                            <?php if ($product->is_on_sale()): ?>
                                <span class="price">
                               <?php echo 'قیمت ویژه' . $product->get_sale_price(); ?> تومان
                             </span>
                                <span class="price">
                                <del>
                                    <?php echo 'قیمت محصول' . number_format($product->get_regular_price()); ?>تومان
                                </del>
                            </span>

                            <?php else: ?>
                                <span class="price">

                                    <?php echo 'قیمت محصول' . number_format( $product->get_regular_price()); ?>تومان

                            </span>
                                <?php
                                if (!empty(get_post_meta($product->get_id(), 'installment_price', true))) {
                                    ?>
                                    <span class="price">
                                    <?php
                                    echo 'قیمت قسطی' . get_post_meta($product->get_id(), 'installment_price', true) . 'تومان';
                                    ?>
                                </span>
                                <?php } ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="price">
                            ناموجود
                        </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div id="pslider-nbtn" class="slider-nbtn swiper-button-next"></div>

                <div id="pslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
            </div>
        </div>


    </section>
<?php
endif;

wp_reset_postdata();
