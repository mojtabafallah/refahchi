<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>
    <section class="p-tabs">

        <ul class="c-box-tabs" role="tablist">
            <?php foreach ($product_tabs as $key => $product_tab) : ?>
                <li class="<?php echo esc_attr($key); ?>_tab c-box-tabs__tab " id="<?php echo esc_attr($key); ?>"
                    role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
                    <?php
                    switch (esc_attr($key)) {

                        case "description":

                            echo '<a id="desc"  href="#"> <i class="fa fa-glasses"></i><span>';
                            echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));
                            echo '</span></a>';
                            break;

                        case "reviews":

                            echo '<a id="comments"  href="#"> <i class="fa fa-comments"></i></i><span>';
                            echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));
                            echo '</span></a>';
                            break;


                        case "additional_information":

                            echo '<a id="params"  href="#"><i class="fa fa-tasks"></i></i><span>';
                            echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));
                            echo '</span></a>';
                            break;
                        case "seller":

                            echo '<a id="seller"  href="#"> <i class="fa fa-glasses"></i><span>';
                            echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));
                            echo '</span></a>';
                            break;

                        case "more_seller_product":

                            echo '<a id="questions1"  href="#"> <i class="fa fa-glasses"></i><span>';
                            echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key));
                            echo '</span></a>';
                            break;
                    }
                    ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <div class="c-box--tabs p-tabs__content">
            <?php foreach ($product_tabs as $key => $product_tab) : ?>


                <?php
                switch ($key) {
                    case "description":
                        ?>
                        <div class=" is-active woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                             id="desc" role="tabpanel"
                             aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php
                        break;
                    case "additional_information":
                        ?>
                        <div class=" woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                             id="params" role="tabpanel"
                             aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php
                        break;
                    case "reviews":
                        ?>
                        <div class=" woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                             id="comments" role="tabpanel"
                             aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php
                        break;
                    case "seller":
                        ?>
                        <div class=" woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                             id="seller" role="tabpanel"
                             aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php
                        break;
                    case "more_seller_product":
                        ?>
                        <div class=" woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                             id="questions1" role="tabpanel"
                             aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                        <?php
                        break;
                }
                ?>


            <?php endforeach; ?>
        </div>

        <?php do_action('woocommerce_product_after_tabs'); ?>

    </section>


<?php endif; ?>
