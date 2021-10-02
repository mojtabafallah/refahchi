<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
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

defined( 'ABSPATH' ) || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) );

?>

<article>
    <h2 class="c-params__headline">

        <?php if ( $heading ) : ?>
            <?php echo esc_html( $heading ); ?>
        <?php endif; ?>

        <span><?php the_title()?></span>
    </h2>
    <section>
        <h3 class="c-params__title">مشخصات کلی</h3>
        <ul class="c-params__list">
        <?php
        $attributes=$product->get_attributes();
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
    </section>
</article>




