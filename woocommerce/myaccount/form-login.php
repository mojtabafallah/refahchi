<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

        <section class="account-box">
            <div class="register-logo">
                <a href="<?php echo get_site_url() ?>">
                    <img src="<?php echo get_option("logo_site") ?>">
                </a>
            </div>
            <div class="register login">
                <div class="headline">ورود به <?php echo get_bloginfo( 'name' );?></div>
                <div class="content">
                    <form class="woocommerce-form woocommerce-form-login login" method="post">

                        <?php do_action('woocommerce_login_form_start'); ?>


                        <label for="username">ایمیل یا شماره موبایل</label>
                        <input type="text" placeholder="پست الکترونیک یا شماره موبایل خود را وارد نمایید"
                               class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                               id="username"
                               autocomplete="username"
                               value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>


                        <label for="password">کلمه عبور</label>
                        <input placeholder="کلمه عبور خود را وارد نمایید"
                               class="" type="password" name="password"
                               id="password" autocomplete="current-password"/>


                        <?php do_action('woocommerce_login_form'); ?>

                        <div class="acc-agree">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                                   type="checkbox" id="rememberme" value="forever"/>

                            <label for="rememberme"><span>مرا به خاطر داشته باش</span></label>
                        </div>


                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>

                        <button type="submit" name="login"><i class="fa fa-unlock"></i> ورود به <?php echo get_bloginfo( 'name' );?></button>


                        <?php do_action('woocommerce_login_form_end'); ?>

                    </form>

                    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

                </div>

                <div class="u-column2 col-2">

                    <h2><?php esc_html_e('Register', 'woocommerce'); ?></h2>

                    <form method="post"
                          class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >

                        <?php do_action('woocommerce_register_form_start'); ?>

                        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span
                                            class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                       name="username"
                                       id="reg_username" autocomplete="username"
                                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                            </p>

                        <?php endif; ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span
                                        class="required">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text"
                                   name="email"
                                   id="reg_email" autocomplete="email"
                                   value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                        </p>

                        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                            class="required">*</span></label>
                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text"
                                       name="password" id="reg_password" autocomplete="new-password"/>
                            </p>

                        <?php else : ?>

                            <p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

                        <?php endif; ?>

                        <?php do_action('woocommerce_register_form'); ?>

                        <p class="woocommerce-form-row form-row">
                            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                            <button type="submit"
                                    class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit"
                                    name="register"
                                    value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                        </p>

                        <?php do_action('woocommerce_register_form_end'); ?>

                    </form>

                </div>

            </div>
            <?php endif; ?>


                <div class="foot login-foot">
                    <span>کاربر جدید هستید؟</span>
                    <a href="/register-user">ثبت نام در <?php echo get_bloginfo( 'name' );?></a>
                </div>

        </section>


