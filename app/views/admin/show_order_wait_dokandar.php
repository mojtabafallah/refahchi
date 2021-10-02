<?php
global $wpdb;

$all_wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor=0");

?>
<?php


$array_all_sub_order = [];
foreach ($all_wait_order as $order_wait) {

    /** check status order wait investor */
    $order = wc_get_order($order_wait->id_order);


    $seller = get_post_field('post_author', $order_wait->id_product);


    if ($seller == get_current_user_id()) {

        if ($order->get_status() == "on-hold"):

            $array_all_sub_order[] =
                wc_get_orders(
                    [
                        'parent' => $order_wait->id_order
                    ]
                );
        endif;
    }


}

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
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($all_wait_order as $order_wait) {

            /** check status order wait investor */
            $order = wc_get_order($order_wait->id_order);


            $seller = get_post_field('post_author', $order_wait->id_product);


            if ($seller == get_current_user_id()) {

                if ($order->get_status() == "on-hold"):

                    ?>
                    <tr>
                        <td>
                            <?php echo $order_wait->id_product ?>
                        </td>
                        <td>
                            <?php echo $order_wait->id_order ?>
                        </td>
                        <td><?php
                            echo get_user_by('id', $order_wait->id_user)->display_name; ?>
                        </td>

                        <td>
                            <?php echo get_the_title(get_user_by('id', $order_wait->id_user)->organ); ?>
                        </td>
                        <td>
                            <?php echo get_the_title($order_wait->id_product) ?>
                        </td>
                        <td>
                            <?php echo $order_wait->qty ?>
                        </td>
                        <td>
                            <?php
                            $p = wc_get_product($order_wait->id_product);
                            echo number_format($p->get_price()) ?>تومان
                        </td>
                        <td>
                            <?php echo number_format($order_wait->price_installment) ?>تومان
                        </td>
                        <td>
                            <?php echo $order_wait->darsa_profit ?>%
                        </td>
                        <td>
                            <?php echo $order_wait->num_month ?>
                        </td>
                        <td>
                            <?php echo number_format($order_wait->price_pish) ?> تومان
                        </td>
                        <td></td>
                        <td>
                            <a href="<?php echo add_query_arg(['action' => 'cancel', 'item' => $order_wait->id, 'order' => $order_wait->id_order]) ?>"><button class="button button-primary button-large"  type="button">رد کردن به سرمایه گذار </button></a>
                            <a href="<?php echo add_query_arg(['action' => 'ok', 'item' => $order_wait->id, 'order' => $order_wait->id_order]) ?>"><button class="button button-primary button-large"  type="button">قبول شود</button></a>
                        </td>


                    </tr>
                <?php
                endif;
            }


        }
?>
        </tbody>
    </table>
</div>



