<?php

$allorders = wc_get_orders(array(
    'status' => 'wc-shipping-investor',
    'type' => 'shop_order',
    'email' => '',
    'limit' => -1,
    'return' => 'ids',
));


$organization = new WP_Query(
    [
        'post_type' => 'organization',
        'posts_per_page' => '-1'
    ]
);

foreach ($allorders as $order) {
    $ord = wc_get_order($order);

    $array_final[] = $ord;

}


?>

<?php
global $wpdb;
$id_user = get_current_user_id();
$all_wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor={$id_user}");

do_action("load_details_print");



?>


<div class="o-page__content">

    <div class="o-headline o-headline--profile"><span>محصولات خریداری شده و شما تایید کرده اید </span></div>
    <div class="c-table-orders__head--highlighted">

        <div>شناسه محصول</div>
        <div>شناسه خرید</div>
        <div>نام و نام خانوادگی خریدار</div>
        <div>نام شرکت</div>
        <div>نام محصول</div>
        <div>نام فروشگاه</div>
        <div>تعداد</div>
        <div>قیمت اولیه تک محصول</div>
        <div>مبلغ قسطی تک محصول</div>
        <div>درصد سود ماهانه</div>
        <div>تعداد ماه</div>
        <div>مبلغ پیش پرداخت هر محصول</div>
        <div>زمان خرید</div>
        <div>تعداد اقساط پرداخت شده</div>
        <div>نمایش</div>
    </div>
    <div class="c-table-orders__body">
        <?php foreach ($all_wait_order as $item): ?>
            <div class="table-row">
                <div><?php echo $item->id_product ?></div>
                <div><?php echo $item->id_order ?></div>
                <div><?php
                    $user = get_userdata($item->id_user);
                    if ($user)
                        echo get_user_by('id', $item->id_user)->display_name;
                    else
                        echo "حذف شده"
                    ?></div>
                <div>         <?php
                    $user = get_userdata($item->id_user);
                    if ($user)
                        echo get_the_title(get_user_by('id', $item->id_user)->organ);
                    else
                        echo "حذف شده"

                    ?> </div>
                <div> <?php echo get_the_title($item->id_product) ?></div>

                <div>

                        <?php

                        $seller = get_post_field('post_author',$item->id_product);
                        $author = get_user_by('id', $seller);
                        $vendor = dokan()->vendor->get($seller);

                        $store_info = dokan_get_store_info($author->ID);
                        if (!empty($store_info['store_name'])) { ?>
                            <span class="details">
                        <?php printf(' <a href="%s">%s</a>', $vendor->get_shop_url(), $vendor->get_shop_name()); ?>
                    </span>
                            <?php
                        } ?>

                </div>

                <div>  <?php echo $item->qty ?></div>
                <div> <?php
                    $p = wc_get_product($item->id_product);
                    echo number_format($p->get_price()) ?>تومان
                </div>

                <div>      <?php echo number_format($item->price_installment) ?> تومان</div>

                <div>  <?php echo $item->darsa_profit ?>%</div>

                <div>   <?php echo $item->num_month ?></div>
                <div>  <?php echo number_format($item->price_pish) ?> تومان</div>
                <div>
                    <?php
                    $wpdb->get_results("select * from {$wpdb->prefix}installments where id_details={$item->id} and status=1 ")
                    ?>
                    <?php echo $item->num_month ?> / <?php echo $wpdb->num_rows ?>
                </div>
                <div>
                    <a href="<?php echo add_query_arg(['action' => 'show_details', 'item' => $item->id]) ?>">
                        <span class="dashicons dashicons-visibility"></span>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

</div>



