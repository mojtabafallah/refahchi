<?php

$allorders = wc_get_orders(array(
    'status' => 'wc-shipping-progress',
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
if ($organization->have_posts()):
    while ($organization->have_posts()):
        $organization->the_post();
        $id_manager = get_post_meta(get_the_ID(), 'id_manager_organization', true);
        if ($id_manager == get_current_user_id()) {
            $all_personnel = get_users([
                'meta_key' => 'organ',
                'meta_value' => get_the_ID()
            ]);
            break;
        }
    endwhile;
    $array_final = array();

    foreach ($all_personnel as $personnel) {
        foreach ($allorders as $order) {
            $ord = wc_get_order($order);
//               var_dump($personnel->id);
//$ord->get_date_created()

            if ($ord->get_user_id() == $personnel->ID) {
                $array_final[] = $ord;
            }
        }
    }

endif;

?>


    <div class="wrap">
        <h1>
            سفارشات پرسنل در انتظار تایید شما
        </h1>

        <table class="widefat">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>نام و نام خانوادگی خریدار</th>
                <th>نام شرکت</th>
                <th>مبلغ قسطی</th>
                <th>مبلغ پیش پرداخت</th>
                <th>محصولات</th>
                <th>زمان خرید</th>
                <th>سقف پرداخت قسط ماهیانه</th>
                <th>در حال پرداخت قسط در ماه(+این سفارش)</th>


                <th>عملیات</th>
            </tr>
            <?php

            foreach ($array_final as $item): ?>


                <?php if ($item->get_parent_id() == 0): ?>

                    <tr>
                        <td><?php echo $item->get_id() ?></td>
                        <td><?php
                            echo get_user_by('id', $item->get_user_id())->display_name; ?></td>
                        <td>
                            <?php echo get_the_title(get_user_by('id', $item->get_user_id())->organ); ?>
                        </td>
                        <td>

                            <?php echo number_format($item->get_total()); ?> تومان

                        </td>
                        <td>

                            <?php $metadata = $item->get_meta_data();
                            foreach ($metadata as $data) {
                                if ($data->key == "_price_pish_total") {
                                    echo number_format($data->value) . " تومان";
                                }

                            } ?>

                        </td>

                        <td>
                            <?php foreach ($item->get_items() as $product): ?>
                                <?php echo $product->get_data()['name'] . '(' . $product->get_data()['quantity'] . ')'; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php
                            $a = new WPSH_Core();
                            echo $a->wp_shamsi(null, 'l d F Y', strtotime($item->get_date_created())); ?>

                        </td>
                        <td>
                            <?php
                            echo number_format(get_user_by('id', $item->get_user_id())->max_in_month); ?> تومان
                        </td>
                        <td>
                            <?php
                            global $wpdb;
                            $all_order_ok = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_user = {$item->get_user_id()} AND id_investor <> 0 AND status = 0 ");
                            $prices_installment = 0;
                            $sum_num_month = 0;
                            foreach ($all_order_ok as $order) {
                                $prices_installment += $order->price_installment;
                                $sum_num_month += $order->num_month;

                            }




                            //get price installment
                            $detail_order = $wpdb->get_results("select price_installment,num_month from {$wpdb->prefix}order_details where id_order={$item->get_id()} ");
                            $sum_price_installment = 0;
                            foreach ($detail_order as $detail) {
                                $sum_price_installment += $detail->price_installment / $detail->num_month;
                            }




                            if ($sum_num_month) echo number_format($sum_price_installment+($prices_installment / $sum_num_month)) . ' تومان'; else echo 0;


                            ?>

                        </td>


                        <td>

                            <div style="display: flex">
                                <a style="margin: 10px"
                                   href="<?php echo add_query_arg(['action' => 'cancel', 'item' => $item->get_id()]) ?>">
                                    <button class="button button-primary button-large" type="button">رد شود</button>
                                </a>
                                <a style="margin: 10px"
                                   href="<?php echo add_query_arg(['action' => 'ok', 'item' => $item->get_id()]) ?>">
                                    <button class="button button-primary button-large" type="button">قبول شود</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>


            </thead>
        </table>
    </div>


<?php

