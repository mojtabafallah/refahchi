<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);
?>
<?php $data_user = get_userdata(get_current_user_id()); ?>
    <div class="user-main">
        <div class="private-info">
            <div class="o-headline o-headline--profile"><span>اطلاعات شخصی</span></div>
            <div class="private-info--table">
                <div class="private-info--row">
                    <div class="private-info--col"><span class="col-title">نام و نام خانوادگی</span><span
                                class="col-value"><?php echo $data_user->first_name . ' ' . $data_user->last_name ?></span>
                    </div>
                    <div class="private-info--col"><span class="col-title">پست الکترونیک :</span><span
                                class="col-value"><?php echo $data_user->user_email; ?></span></div>
                </div>
                <div class="private-info--row">
                    <div class="private-info--col"><span class="col-title">شماره تلفن همراه:</span><span
                                class="col-value"> <?php echo get_user_meta(get_current_user_id(), 'mobile', true) ?> </span>
                    </div>
                    <div class="private-info--col"><span class="col-title">کد ملی:</span><span
                                class="col-value">  <?php echo $data_user->nickname ?> </span></div>
                </div>

                <div class="c-profile-stats__action"><a href="#" class="btn-link-spoiler btn-link-spoiler--edit"><i
                                class="fa fa-pen"></i> ویرایش اطلاعات شخصی</a></div>
            </div>
        </div>
        <div class="mywish-list">
            <div class="o-headline o-headline--profile"><span>لیست علاقه‌مندی‌ها</span></div>
            <div class="c-profile-recent-fav">
                <div class="c-profile-recent-fav__content">
                    <?php $ids_product_fav = get_user_meta(get_current_user_id(), "fav_product", true);
                    ?>

                    <?php global $product;
                    if ($ids_product_fav) {


                        foreach ($ids_product_fav as $id):
                            $product_f = wc_get_product($id);
                            if ($product_f):
                                ?>
                                <div class="wishlit-item" data-idproduct="<?php echo $id ?>">
                                    <a target="_blank"
                                       href="<?php echo $product_f->get_permalink() ?>"><?php echo $product_f->get_image() ?></a>
                                    <div class="wishlit-item__title">
                                        <a target="_blank"
                                           href="<?php echo $product_f->get_permalink() ?>"><?php echo $product_f->get_name() ?></a>
                                        <span class="out-stock"><?php echo $product_f->get_price() ?></span>
                                    </div>
                                    <button class="remove_fav_btn2"><span
                                                class="dashicons dashicons-trash remove_fav_btn1"
                                                data-idproduct="<?php echo $id ?>"></span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php endforeach;
                    } ?>


                </div>

            </div>
        </div>
    </div>


<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
