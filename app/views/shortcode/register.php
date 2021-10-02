<?php get_header("shop"); ?>

<section class="account-box">
    <div class="register-logo">
        <a href="<?php echo get_site_url() ?>">
            <img src="<?php echo get_option("logo_site") ?>">
        </a>
    </div>
    <div class="register">
        <div class="headline">ثبت‌نام در <?php echo get_bloginfo( 'name' );?></div>
        <div class="content">
            <span class="hint">اگر قبلا با ایمیل ثبت‌نام کرده‌اید، نیاز به ثبت‌نام مجدد با شماره همراه ندارید</span>
            <form action="" method="post">
                <label for="mobtel">پست الکترونیک یا شماره موبایل</label>
                <input id="mobtel" name="user_name" type="text" placeholder="پست الکترونیک یا شماره موبایل خود را وارد نمایید">
                <label for="pwd">کلمه عبور</label>
                <input id="pwd" name="password" type="password" placeholder="کلمه عبور خود را وارد نمایید">
                <div class="acc-agree">
                    <input id="chkbox" type="checkbox">
                    <label for="chkbox">
                        <?php ?>
                        <a href="<?php echo get_the_privacy_policy_link(); echo get_privacy_policy_url()?>">حریم خصوصی</a>
                        <span>و</span>
                        <a href="#">شرایط و قوانین</a>
                        <span> استفاده از سرویس های سایت <?php echo get_bloginfo( 'name' );?> را مطالعه نموده و با کلیه موارد آن موافقم.</span>
                    </label>
                </div>
                <button name="register_user" type="submit"><i class="fa fa-user-plus"></i> ثبت نام در <?php echo get_bloginfo( 'name' );?></button>
            </form>
        </div>
        <div class="foot">
            <span>قبلا در <?php echo get_bloginfo( 'name' );?> ثبت‌نام کرده‌اید؟</span>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">وارد شوید</a>
        </div>
    </div>
</section>


<?php get_footer("shop") ?>

