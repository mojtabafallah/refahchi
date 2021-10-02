<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<?php
//WC()->session->__unset( 'final_price_mul_qty' );


$plan_selected = WC()->session->get('selected_plan', 'no_select');


$type_cart = WC()->session->get('type_cart', 'cash_cart');

//var_dump(WC()->session->get('final_price_mul_qty', '1'));
//echo "</br>";
//echo "</br>";
//var_dump( WC()->session->get('total_price_installment', array(1, 2)));
//var_dump(WC()->session->get('total_price_installment', '1'));

//var_dump(WC()->session->get('total_price', '1'));
//var_dump((WC()->session->get('final_price_mul_qty', 1)));
//var_dump((WC()->session->get('data_id_product_id_plan', 1)));
//var_dump(WC()->session->get('type_cart', "cash_cart"));


?>

<div class="c-checkout__header ">
    <span class="c-checkout__header-title">ارسال عادی</span>
    <span class="c-checkout__header-extra-info"> (<?php echo WC()->cart->get_cart_contents_count(); ?> کالا)</span>
    <span class="c-checkout__header-delivery-cost"> هزینه ارسال: رایگان </span>
    <p>نوع سبد خرید را انتخاب نمایید: </p>
    <div>
        <label for="cash"> پرداخت نقدی </label><input type="radio" id="cash"
                                                      name="type_order" <?php if ($type_cart == "cash_cart") echo "checked" ?>>

        <?php if (is_user_logged_in()):

            $user = wp_get_current_user(); // getting & setting the current user
            $roles = $user->get_role_caps(); // obtaining the role
            if (array_key_exists("personnel", $roles)) {
                ?>

                <label for="installment"> پرداخت قسطی </label><input type="radio" id="installment"
                                                                     name="type_order" <?php if ($type_cart == "installment_cart") echo "checked" ?>>
                <?php
            }
        endif ?>
    </div>
</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>
    <ul class="c-checkout__items">
        <div>
            <?php do_action('woocommerce_before_cart_contents'); ?>
            <?php
            /**
             * define array id product installment for ajax
             */
            $arr_product_id_installment = array();
            $arr_no_plan = array();
            //var_dump($arr_product_id_installment);
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);


            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);


            ?>
            <div class="c-checkout__row  <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                <div class="c-checkout__col--thumb">
                    <?php
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                    if (!$product_permalink) {
                        echo $thumbnail; // PHPCS: XSS ok.
                    } else {
                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                    }
                    ?>
                </div>
                <div class="c-checkout__col--desc">
                    <!--title item-->
                    <?php
                    if (!$product_permalink) {
                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                    } else {
                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                    }

                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);


                    // Meta data.
                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.


                    // Backorder notification.
                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                    }


                    ?>


                    <div class="c-checkout__col--information">
                        <div class="c-checkout__col c-checkout__col--counter">
                            <div class="c-cart-item__quantity-row">

                                <div class="c-quantity-selector">
                                    <button type="button" class="c-quantity-selector__add"><i
                                                class="fa fa-plus"></i>
                                    </button>
                                    <?php
                                    if ($_product->is_sold_individually()) {
                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name' => "cart[{$cart_item_key}][qty]",
                                                'input_value' => $cart_item['quantity'],
                                                'max_value' => $_product->get_max_purchase_quantity(),
                                                'min_value' => '1',
                                                'product_name' => $_product->get_name(),
                                            ),
                                            $_product,
                                            false
                                        );
                                    }

                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                    ?>

                                    <?php
                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="c-quantity-selector__remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-trash"></i></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'woocommerce'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>

                            </div>

                        </div>
                        <!--subtotal-->
                        <div class="c_checkout__container checkout-price">

                            <div class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">

                                <div class="c-checkout__col c-checkout__col--price">


                                    <?php


                                    echo '<div class="section_price_installment_r  section_price_installment-' . $_product->get_id() . '">';


                                    echo '</div>';

                                    echo '<div class="total-left-section">';

                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                    echo "</div>";
                                    ?>
                                </div>
                            </div>
                            <div class="c-checkout__col price_section c-checkout__col--price"
                                 data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">


                                <?php


                                //  $type_cart = WC()->session->get('type_cart', 'cash_cart');


                                /** price installment */
                                echo '<div class="plan-store plan-store-' . $cart_item['product_id'] . '">';
                                $plans_store = get_post_meta($cart_item['product_id'], 'plans', true);

                                global $wpdb;
                                if ($plans_store) {
                                    $arr_product_id_installment [] = $cart_item['product_id'];

                                } else {

                                    $arr_product_id_installment [] = $cart_item['product_id'];
                                }
                                ?>
                            </div>
                        </div>


                        <?php


                        /** price cash */
                        echo '<div class="section-center">';
                        echo '<span>قیمت نقدی</span>';
                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                        /** end cash */
                        echo "</div>";


                        ?>
                    </div>

                </div>


            </div>
        </div>


        <?php
        } ?>
        <?php endforeach; ?>
        <?php do_action('woocommerce_cart_contents'); ?>
        <tr>
            <td colspan="6" class="actions">
                <!--coupons-->
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon coupon-styles">
                        <p class="coupon-styles__title">کوپن‌ها</p>
                        <div class="coupon-styles__input-container">
                            <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input
                                    type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                                    placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>"/>
                            <button type="submit" class="button" name="apply_coupon"
                                    value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                        </div>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>
                <?php } ?>
                <!--end coupons-->
                <button type="submit" class="button" name="update_cart"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </td>
        </tr>
        <?php do_action('woocommerce_after_cart_contents'); ?>

        </li>
    </ul>


    <!--    sub total -->
    <div class="c-checkout__to-shipping-sticky">

        <?php do_action('woocommerce_before_cart_collaterals'); ?>

        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>


        <div class="c-checkout__to-shipping-price-report details-installment"
             style=" <?php echo $type_cart == 'installment_cart' ? 'display:block' : 'display:none' ?>">
            <!--            <div class="overlay"><div>CENTERED ICON</div></div>-->
            <?php
            $id_user = get_current_user_id();
            $wallet = get_user_meta($id_user, '_current_woo_wallet_balance', true);

            $final_price = WC()->session->get('total_price_installment', array());

            if ($final_price)
                $sum_final_price = array_sum($final_price);
            else
                $sum_final_price = 0;

            ?>
            <div>
                <p>
                    <span>مبلغ اعتبار اصلی</span>
                <div><span><?php echo $wallet ? number_format($wallet) : 0 ?></span> <span>تومان</span></div>
                </p>
            </div>
            <div>
                <p class="wallet">
                    <span>جمع مبلغ قسطی انتخابی</span>
                <div class="wallet-price"><span>  <?php echo number_format($sum_final_price) ?>   </span>
                    <span>   تومان </span></div>
                </p>
            </div>
            <div>
                <p class="wallet1">
                    <span>اعتبار باقی مانده</span>
                <div class="wallet1-price">
                    <span>  <?php echo $wallet ? number_format($wallet - $sum_final_price) : 0 ?>   </span>
                    <span>   تومان </span>
                </div>
                </p>
            </div>


        </div>

        <div class="c-checkout__to-shipping-price-report details-installment"
             style=" <?php echo $type_cart == 'installment_cart' ? 'display:block' : 'display:none' ?>">


            <p>
            <div class="pish-pardakht-price">
                <span>مجموع مبلغ پیش پرداخت: </span>
            </div>
            <div>
                <?php
                $price_pish = WC()->session->get('total_price', array());

                ?>

                <span id="total_pish"><?php if ($price_pish != 0) echo number_format(intval(array_sum($price_pish))) ?></span>
            </div>
            </p>
        </div>


    </div>


    <?php do_action('woocommerce_after_cart'); ?>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>


<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $(".section_price_installment_r").hide();


        if ($('#installment').is(':checked') == true) {

            $(".total-left-section").hide();
            $(".section-center").hide();
            $(".section_price_installment_r").show();
            $('.cash-price-report').hide();
            $("#cash").attr("disabled", true);
            console.log("type cart installment");

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'post',
                data: {
                    action: 'set_type_cart',
                    type_cart: 'installment'
                },
                success: function (response) {

                    $('.overlay').fadeOut();

                    console.log(response);


                },
                error: function (error) {
                    console.log("error");
                    console.log(error);
                }
            });


            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'post',
                data: {
                    action: 'filter_plans',
                    product_id: [<?php foreach ($arr_product_id_installment as $item) echo $item . ',' ?>],

                },
                success: function (response) {
                    <?php foreach ($arr_product_id_installment as $item): ?>
                    $(".plan-store-<?php echo $item?>")
                        .empty()
                        .append(response[<?php echo $item?>]);

                    <?php endforeach?>

                },
                error: function (error) {
                    console.log("error");
                    console.log(error);
                }
            });
        }

        $("#installment").on("change", function () {

            $(".details-installment").show();

            $("#cash").attr("disabled", true);
            $(".total-left-section").hide();
            $(".section-center").hide();

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'post',
                data: {
                    action: 'filter_plans',
                    product_id: [<?php foreach ($arr_product_id_installment as $item) echo $item . ',' ?>]
                },
                success: function (response) {
                    <?php foreach ($arr_product_id_installment as $item): ?>
                    $(".plan-store-<?php echo $item?>")
                        .empty()
                        .append(response[<?php echo $item?>]);
                    <?php endforeach?>

                },
                error: function (error) {
                    console.log("error");
                    console.log(error);
                }
            });


            if ($('#installment').is(':checked') == true) {

                //  $("#cash").attr("disabled",true);

                $('.cash-price-report').hide();

                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'post',
                    data: {
                        action: 'set_type_cart',
                        type_cart: 'installment'
                    },
                    success: function (response) {

                        console.log(response);


                    },
                    error: function (error) {
                        console.log("error");
                        console.log(error);
                    }
                });

                console.log("changed type cart installment");
            }
        });


        $("#cash").on("change", function () {
            $(".details-installment").hide();
            $(".section_price_installment_r").hide();
            $('.cash-price-report').show();

            if ($('#cash').is(':checked') == true) {

                $(".total-left-section").show();
                $(".section-center").show();
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'post',
                    data: {
                        action: 'set_type_cart',
                        type_cart: 'cash'
                    },
                    success: function (response) {

                        console.log(response);


                    },
                    error: function (error) {
                        console.log("error");
                        console.log(error);
                    }
                });


                console.log("changed111 type cart cash");

                $(".plan-store , .section_price_installment_r").empty();
//                $(".section_price_installment_r").css('display', 'none');
            }
        });


    });

</script>
