<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>


    <div class="o-page__aside">
        <div class="c-profile-aside">
            <div class="c-profile-box">
                <div class="c-profile-box__header">
                    <div class="c-profile-box__avatar" style="background-image: url(<?php echo get_avatar_url(get_current_user_id());?>)"></div>
                    <button id="avatar-modal" class="c-profile-box__btn-edit"></button>
                </div>
                <?php $data_user= get_userdata(get_current_user_id());?>
                <div class="c-profile-box__username"><?php echo $data_user->display_name?></div>
                <div class="c-profile-box__tabs">
                    <a href="#" class="c-profile-box__tab c-profile-box__tab--access">تغییر رمز</a>
                    <a href="<?php echo wc_logout_url()?>" class="c-profile-box__tab c-profile-box__tab--sign-out">خروج از حساب</a>
                </div>
            </div>
            <div class="c-profile-menu">
                <div class="c-profile-menu__header">حساب کاربری شما</div>
                <ul class="c-profile-menu__items">
                    <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                        <li class="c-profile-menu__url c-profile-menu__url">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                        </li>
                    <?php endforeach; ?>


                </ul>
            </div>
        </div>
    </div>





<?php do_action( 'woocommerce_after_account_navigation' ); ?>
