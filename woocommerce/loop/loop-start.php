<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="o-page__content">
    <article>
        <nav>
            <ul class="c-breadcrumb">
                <li><span><?php echo get_bloginfo( 'name' );?></span></li>
                <li><span><?php echo wp_count_posts('product')->publish ?>  کالا</span></li>
            </ul>
        </nav>
        <div class="c-listing">
            <div class="c-listing__header">

                    <ul class="c-listing__sort" data-label="مرتب‌سازی بر اساس :">
                        <li><span>مرتب سازی بر اساس :</span></li>
                        <?php do_action('order_customize');?>
                    </ul>

                <ul class="c-listing__type">
                    <li>
                        <button><i class="fa fa-bars"></i></button>
                    </li>
                    <li>
                        <button class="is-active"><i class="fa fa-grip-horizontal"></i></button>
                    </li>
                </ul>
            </div>


            <ul class="products c-listing__items columns-<?php echo esc_attr(wc_get_loop_prop('columns')); ?>">
