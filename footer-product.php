<div class="jump-to-up">
    <i class="fa fa-chevron-up"></i> <span> بازگشت به بالا </span>
</div>
<footer>
    <section class="footer container">
        <div class="icon">

            <div class="icon-item">
                <a href="#">
                    <img src="<?php echo URL_THEME ?>/assets/images/icon/2.svg" alt="">
                    <span>پرداخت در محل</span>
                </a>
            </div> <!--icon-item-->

            <div class="icon-item">
                <a href="#">
                    <img src="<?php echo URL_THEME ?>/assets/images/icon/3.svg" alt="">
                    <span>پشتیبانی ۲۴ ساعته</span>
                </a>
            </div> <!--icon-item-->
            <div class="icon-item">
                <a href="#">
                    <img src="<?php echo URL_THEME ?>/assets/images/icon/5.svg" alt="">
                    <span>ضمانت اصل بودن کالا</span>
                </a>
            </div> <!--icon-item-->
        </div>
        <div class="footer-content">
            <div class="shop-help">

                <?php
                if (is_active_sidebar("footer-1")): ?>
                    <?php dynamic_sidebar('footer-1') ?>
                <?php endif; ?>





            </div>
            <div class="customer-service">
                <?php if (is_active_sidebar("footer-2")): ?>
                    <?php dynamic_sidebar('footer-2') ?>
                <?php endif; ?>
            </div>

            <div class="newsletter">
                <h3 class="head">از تخفیف ها و جدیدترین های شاپ با خبر باشید</h3>
                <div class="content">
                    <form action="#">
                        <input type="text">
                        <button type="submit">ارسال</button>
                    </form>
                    <h3 class="head">ما را در شبکه های اجتماعی دنبال کنید</h3>
                    <div class="social">
                        <a target="_blank" href="https://www.instagram.com/refahchi/"><i class="fa fa-instagram"></i></a>
                        <a target="_blank" href="https://www.linkedin.com/in/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87-%D8%A7%DB%8C%D9%86%D8%AA%D8%B1%D9%86%D8%AA%DB%8C-%D8%B1%D9%81%D8%A7%D9%87-%DA%86%DB%8C-a69195222"><i class="fa fa-linkedin"></i></a>
                        <a target="_blank" href=""><i class="fa fa-facebook-square"></i></a>
                        <a target="_blank" href=""><i class="fa fa-google-plus-square"></i></a>
                    </div>
                </div>
            </div>
            <div class="cert">
                <h3 class="head">مجوزهای فروشگاه</h3>
                <div class="image">
                    <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=233671&amp;Code=uNuBd4GcmsRlnifyc5Pi"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=233671&amp;Code=uNuBd4GcmsRlnifyc5Pi" alt="" style="cursor:pointer" id="uNuBd4GcmsRlnifyc5Pi"></a>
                    <img src="<?php echo URL_THEME ?>/assets/images/cert/samandehi.png" alt="">
                </div>
            </div>
        </div> <!-- footer-content -->



        <div class="copyright">
            <p>استفاده از مطالب  <?php echo get_bloginfo( 'name' );?> فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است. کلیه حقوق
                این سایت متعلق به <?php echo get_bloginfo( 'name' );?> می‌باشد.</p>
        </div>

    </section>
</footer>
<?php wp_footer(); ?>

<script src="<?php echo URL_THEME  ?>/assets/js/jquery.min.js"></script>
<script>
    jQuery(function () {
        jQuery.each(window.jQueryQ || [], function (i, a) {
            setTimeout(function () {
                jQuery.apply(this, a);
            }, 0);
        });
    });
</script>
<script src="<?php echo URL_THEME  ?>/assets/vendor/swiper/js/swiper.min.js"></script>
<script src="<?php echo URL_THEME  ?>/assets/vendor/slicknav/jquery.slicknav.min.js"></script>
<script src="<?php echo URL_THEME  ?>/assets/vendor/jquery.countdown.min.js"></script>
<script src="<?php echo URL_THEME  ?>/assets/vendor/elevatezoom.js"></script>
<script src="<?php echo URL_THEME  ?>/assets/vendor/persianumber.min.js"></script>
<script src="<?php echo URL_THEME  ?>/assets/js/script.js"></script>

</body>
</html>