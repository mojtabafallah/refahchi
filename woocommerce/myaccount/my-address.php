<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __('Billing address', 'woocommerce'),
            'shipping' => __('Shipping address', 'woocommerce'),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __('Billing address', 'woocommerce'),
        ),
        $customer_id
    );
}

$oldcol = 1;
$col = 1;
?>


    <div class="o-page__content">

    <div class="profile-navbar">
        <span class="title">آدرس ها</span>
        <button class="c-profile-navbar__btn-location js-add-address-btn"><i class="fa fa-map-marked"></i></button>
    </div>


<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
    <div class="user-main">




<?php endif; ?>

<?php foreach ($get_addresses as $name => $address_title) : ?>
    <?php
    $address = wc_get_account_formatted_address($name);
    $col = $col * -1;
    $oldcol = $oldcol * -1;
    ?>
    <div class="address-section">





    <div class="profile-address-card">
            <header class="woocommerce-Address-title title">
                <div class="c-profile-address-card__desc">
                <h3><?php echo esc_html($address_title); ?></h3>
                <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>"
                   class="edit"><?php echo $address ? esc_html__('Edit', 'woocommerce') : esc_html__('Add', 'woocommerce'); ?></a>
                </div>
            </header>
            <address>
                <p class="c-checkout-address__text">
                <?php
                echo $address ? wp_kses_post($address) : esc_html_e('You have not set up this type of address yet.', 'woocommerce');
                ?>
                </p>
            </address>
        </div>
    </div>

<?php endforeach; ?>

<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
    </div>
    </div>
<?php
endif;
