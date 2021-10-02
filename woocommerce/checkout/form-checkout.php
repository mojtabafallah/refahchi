<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) : ?>

        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="co6-set" id="customer_details">


            <!--            form inpormation person-->
            <div class="col-6">
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>


            <!--            form add information-->

            <!--            <div class="col-2">-->
            <!--                --><?php ////do_action( 'woocommerce_checkout_shipping' ); ?>
            <!--            </div>-->
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>

    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

    <div class="auth-container">
    <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

    <?php do_action('woocommerce_checkout_before_order_review'); ?>



    <?php
    $id_user = get_current_user_id();
    $wallet = get_user_meta($id_user, '_current_woo_wallet_balance', true);
    $total = WC()->session->get('total_price_installment');
    if ($total) {
        $total = array_sum($total);
    }
    $ob = get_user_meta(get_current_user_id(), 'obstruction', true);

    $ob_description = get_user_meta(get_current_user_id(), 'obstruction_description', true);
    $ob_number = get_user_meta(get_current_user_id(), 'obstruction_number', true);

    /** check type cart */
    $type_cart = WC()->session->get('type_cart', 'cash_cart');
    if ($type_cart != "cash_cart") :
        /** check ob */
    if (!$ob):

        /** check value wallet */

    if ($wallet >= $total):
        $password = WC()->session->get('auth', 'error');



        $type_cart = WC()->session->get('type_cart', 'cash_cart');

        /** check ok password */
    if ($password == "ok"):
        ?>
        <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>
    <?php do_action('woocommerce_checkout_after_order_review'); ?>
    <?php else: ?>


        <label for="password_wallet">کلمه عبور اعتبار حساب خود را وارد کنید</label>
    <input class=" input-text form-control input-lg" type="password" id="password_wallet"
           name="password_installment">
        <p style="
    width: 10%;
" class="c-checkout__to-shipping-link" id="btn_auth">احراز هویت</p>

</div>


        <script>
            jQuery(document).ready(function ($) {


                $("#btn_auth").on('click', function () {
                    var password1 = $("#password_wallet").val();
                    console.log(password1);
                    $.ajax(
                        {
                            url: "/wp-admin/admin-ajax.php",
                            type: "post",
                            data: {
                                action: "wp_auth_account",
                                password: password1

                            },
                            success: function (response) {
                                location.reload();


                            },
                        }
                    );



                });


            })
        </script>


    <?php endif;

    /** end check ok password */


    ?>
    <?php else: ?>
        <div style="color: red">
            <p>اعتبار شما کافی نمی باشد</p>
            <span>مقدار جمع فاکتور</span><?php echo $total ?> <span>تومان</span>
            <span>مقدار کیف پول</span> <?php echo $wallet ?><span>تومان</span>
        </div>

    <?php endif;
    /** end check value wallet */
    ?>

    <?php else: ?>
        <div style="color: red">
            <p>حساب شما مسدود شده است به دلیل:</p>
            <p><?php echo $ob_description ?></p>
            <p>شماره:</p>
            <p><?php echo $ob_number ?></p>
        </div>
    <?php endif;
    /** end check ob */
    ?>
    <?php else: ?>

        <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>

        <?php do_action('woocommerce_checkout_after_order_review'); ?>
    <?php endif; /** end check type cart */ ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
