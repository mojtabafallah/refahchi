<?php
get_header('shipping');
?>
<main class="main-cart container">
    <ul class="c-checkout-steps">
        <li class="is-active summary">
            <div class="c-checkout-steps__item c-checkout-steps__item--summary" data-title="اطلاعات ارسال"></div>
        </li>
        <li class="delivery">
            <div class="c-checkout-steps__item c-checkout-steps__item--delivery" data-title="پرداخت"></div>
        </li>
        <li class="payment">
            <div class="c-checkout-steps__item c-checkout-steps__item--payment" data-title="اتمام خرید و ارسال"></div>
        </li>
    </ul>



    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>


</main>
<?php
get_footer();
?>
