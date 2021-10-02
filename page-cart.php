<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
        <section class="main-cart container">
            <div class="o-page__content">
                <div class="o-headline">
                    <div id=""><span class="c-checkout-text">لیست خرید</span></div>
                </div>

                <div class="c-checkout">
                    <?php the_content(); ?>
                </div>
            </div>


            <aside class="o-page__aside">
                <div class="c-checkout-aside">
                    <div class="c-checkout-summary">
                        <ul class="c-checkout-summary__summary">


                            <li>
                                <span style="font-size: 1.1em;padding-right: 10px;">ارسال عادی</span>
                                <span style="font-size: 1.1em;padding-right: 10px;">رایگان</span>
                            </li>
                            <li class="has-devider">
                                <span> مبلغ پیش پرداخت </span>
                                <span> <?php if(WC()->session->get('total_price', array()) != 0) echo number_format(array_sum(WC()->session->get('total_price', array())));?> تومان </span>
                            </li>
                            <li class="pd-10">
                                <span> <i class="fa fa-money"></i> اعتبار شما:</span>
                                <span> <?php echo  get_user_meta(get_current_user_id(), '_current_woo_wallet_balance', true) ?  number_format(get_user_meta(get_current_user_id(), '_current_woo_wallet_balance', true)) : 0 ;?> تومان </span>
                            </li>
                        </ul>
                        <div class="c-checkout-summary__main">
                            <div class="c-checkout-summary__content">
                                <div><span> کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی را تکمیل کنید.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-checkout-feature-aside">
                        <ul>
                            <li class="c-checkout-feature-aside__item c-checkout-feature-aside__item--guarantee">هفت روز
                                ضمانت تعویض
                            </li>
                            <li class="c-checkout-feature-aside__item c-checkout-feature-aside__item--cash">پرداخت در
                                محل با کارت بانکی
                            </li>
                            <li class="c-checkout-feature-aside__item c-checkout-feature-aside__item--express">تحویل
                                اکسپرس
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>