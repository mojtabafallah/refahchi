<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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

global $product;
?>
<div class="c-product__right">


    <?php do_action('woocommerce_product_meta_start'); ?>
    <ul>
        <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

            <li><?php esc_html_e('SKU:', 'woocommerce'); ?>
                <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
            </li>

        <?php endif; ?>

        <?php echo wc_get_product_category_list($product->get_id(), ', ', '<li>' . _n("<span>" . 'دسته:' . "</span>", "<span>" . 'دسته:' . "</span>", count($product->get_category_ids()), 'woocommerce') . ' ', '</li>'); ?>
        <?php do_action('show_brands', $product->get_id()); ?>

        <?php echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>'); ?>
    </ul>

    <?php do_action('woocommerce_product_meta_end'); ?>
    <div class="c-product__params">
        <ul data-title="ویژگی های محصول">
            <?php
            $attributes = $product->get_attributes();

            if (!$attributes) {
                echo "ویژگی وجود ندارد";
            }
            foreach ( $attributes as $product_attribute_key => $product_attribute ) : ?>
            <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
                <th class="woocommerce-product-attributes-item__label"></th>
                <td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
            </tr>
            <?php endforeach;



            foreach ($attributes as $product_attribute_key => $product_attribute) {

                ?>


                <li>
                <span>

                   <?php echo  wc_attribute_label( $product_attribute_key) . ": "  ?>
                    <?php
                    $fabric_values = get_the_terms( $product->get_id(), $product_attribute_key);

                    foreach ( $fabric_values as $fabric_value ) {
                        echo $fabric_value->name ;
                    }
                    ?>


 </span>
                </li>
                <?php
            }

            ?>
        </ul>


    </div>
</div>




