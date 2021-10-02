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


?>


<div class="wrap">
    <h1>
        محصولات خریداری شده در انتظار تایید شما
    </h1>

    <table class="widefat">
        <thead>
        <tr>
            <th>شناسه محصول</th>
            <th>شناسه خرید</th>
            <th>نام و نام خانوادگی خریدار</th>
            <th>نام شرکت</th>
            <th>نام محصول</th>
            <th>تعداد</th>
            <th>قیمت اولیه تک محصول</th>
            <th>مبلغ قسطی تک محصول</th>
            <th>درصد سود ماهانه</th>
            <th>تعداد ماه</th>
            <th>مبلغ پیش پرداخت هر محصول</th>
            <th>زمان خرید</th>
            <th>تعداد اقساط پرداخت شده</th>
            <th>نمایش</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($all_wait_order as $item): ?>

            <tr>
                <td>
                    <?php echo $item->id_product ?>
                </td>
                <td>
                    <?php echo $item->id_order ?>
                </td>
                <td><?php
                    $user = get_userdata($item->id_user);
                    if ($user)
                        echo get_user_by('id', $item->id_user)->display_name;
                    else
                        echo "حذف شده"
                    ?>
                </td>

                <td>

                    <?php
                    $user = get_userdata($item->id_user);
                    if ($user)
                        echo get_the_title(get_user_by('id', $item->id_user)->organ);
                    else
                        echo "حذف شده"

                    ?>
                </td>
                <td>
                    <?php echo get_the_title($item->id_product) ?>
                </td>
                <td>
                    <?php echo $item->qty ?>
                </td>
                <td>
                    <?php
                    $p = wc_get_product($item->id_product);
                    echo number_format($p->get_price()) ?>تومان
                </td>
                <td>
                    <?php echo number_format($item->price_installment) ?>تومان
                </td>
                <td>
                    <?php echo $item->darsa_profit ?>%
                </td>
                <td>
                    <?php echo $item->num_month ?>
                </td>
                <td>
                    <?php echo number_format($item->price_pish) ?> تومان
                </td>
                <td></td>
                <td>
                    <?php
                    $wpdb->get_results("select * from {$wpdb->prefix}installments where id_details={$item->id} and status=1 ")
                    ?>
                    <?php echo $item->num_month ?> / <?php echo $wpdb->num_rows ?>
                </td>
                <td>
                    <a href="<?php echo add_query_arg(['action' => 'show_details', 'item' => $item->id]) ?>">
                        <span class="dashicons dashicons-visibility"></span>
                    </a>
                </td>


            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>



