<?php

defined('ABSPATH') || exit;
include URI_THEME . "/app/jdf.php";

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


// operator
global $wpdb;

//if (isset($_POST['add_plan'])) {
//
//    $wpdb->insert($wpdb->prefix . 'plans', [
//        'id_vendor' => $_POST['vendor'],
//        'pishe_darsad' => $_POST['pish_darsad'],
//        'darsad_profit' => $_POST['darsad_profit'],
//        'num_month' => $_POST['num_month']
//    ]);
//}
//
//if (isset($_POST['edit_plan'])) {
//    $active = isset($_POST['is_active']) ? 1 : 0;
//    $remove = isset($_POST['is_remove']) ? 1 : 0;
//    $wpdb->update($wpdb->prefix . 'plans',
//        [
//            'id_vendor' => $_POST['vendor'],
//            'pishe_darsad' => $_POST['pishe_darsad'],
//            'num_month' => $_POST['num_month'],
//            'darsad_profit' => $_POST['darsad_profit'],
//            'is_active' => $active,
//            'is_remove' => $remove
//        ],
//        ['id' => $_POST['id']]);
//
//}


if (isset($_GET['action'])) {
    if ($_GET['action'] == "ok") {

        $id_investor = get_current_user_id();
        global $wpdb;

        $wpdb->update($wpdb->prefix . "order_details",
            [
                'id_investor' => $id_investor
            ], ['id' => $_GET['item']]);

        $order = wc_get_order($_GET['order']);

        if ($order) {
            $order->update_status('processing', '', true);
        }
//        include 'views/admin/show_order_wait_investor.php';

        /******************************************************/


        $wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_order= {$_GET['order']}");

        foreach ($wait_order as $order) {

            /** add installment */
            $a = new \WPSH_Datebar();
            $m = $a->wp_shamsi(null, 'n', time());
            $y = $a->wp_shamsi(null, 'Y', time());
            $num = $order->num_month;
            $m++;
            // $lastid = $wpdb->insert_id;
            $day = $order->day_due;
            while ($num > 0) {

                $full_date = $y . '/' . $m . '/' . $day;
                if ($m < 12) {
                    $m++;
                } else {
                    $y++;
                    $m = 1;
                }

                $wpdb->insert($wpdb->prefix . 'installments', [
                    'id_order' => $order->id_order,
                    'id_product' => $order->id_product,
                    'total_price_installment' => $order->price_installment,
                    'num_installment' => $order->num_month,
                    'price_one_installment' => $order->price_installment / $order->num_month,
                    'id_user' => $order->id_user,
                    'status' => 0,
                    'day' => $full_date,
                    'id_details' => $order->id
                ]);
                $num--;
            }
        }


        /***********************************************************/

    } elseif ($_GET['action'] == "cancel") {

//        $order = wc_get_order($_GET['item']);
//
//        if ($order) {
//            $order->update_status('failed', '', true);
//        }
//        include 'views/admin/show_order_wait.php';
    }

} else {
//    include 'views/admin/show_order_wait_investor.php';
}


?>

<?php
global $wpdb;

$all_wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor=0");


date_default_timezone_set('Asia/Tehran');
?>

<div class="o-page__content">

    <div class="o-headline o-headline--profile"><span>محصولات خریداری شده در انتظار تایید شما </span></div>
    <div class="c-table-orders">
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
            <div>زمان تایید خرید</div>
            <div>عملیات</div>
        </div>
        <div class="c-table-orders__body">

            <?php foreach ($all_wait_order as $item): ?>

                <?php

                /** check status order wait investor */
                $order = wc_get_order($item->id_order);
//                  var_dump($item->id_order);


                if ($order->get_status() == "shipping-investor" || $order->get_status() == "processing"):
                    // var_dump("123");
                    ?>


                    <div class="table-row">
                        <div><?php echo $item->id_product ?></div>
                        <div><?php echo $item->id_order ?></div>
                        <div><?php
                            echo get_user_by('id', $item->id_user)->display_name; ?></div>
                        <div>   <?php echo get_the_title(get_user_by('id', $item->id_user)->organ); ?> </div>
                        <div><?php echo get_the_title($item->id_product) ?></div>
                        <div>
                            <?php

                            $seller = get_post_field('post_author', $item->id_product);
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

                        <div> <?php echo $item->qty ?></div>
                        <div><?php
                            $p = wc_get_product($item->id_product);
                            echo number_format($p->get_price()) ?>تومان
                        </div>

                        <div> <?php echo number_format($item->price_installment) ?>تومان</div>

                        <div> <?php echo $item->darsa_profit ?>%</div>

                        <div> <?php echo $item->num_month ?></div>
                        <div>    <?php echo number_format($item->price_pish) ?> تومان</div>
                        <div>
                            <?php echo jdate('Y-m-d H:i:s', strtotime($order->get_date_created())); ?>
                        </div>
                        <div>
                            <?php echo jdate('Y-m-d H:i:s', strtotime($order->get_date_modified())); ?>
                        </div>
                        <div>
                            <a href="<?php echo add_query_arg(['action' => 'ok', 'item' => $item->id, 'order' => $item->id_order]) ?>">
                                <button class="button button-primary button-large" type="button">قبول شود</button>
                            </a></div>
                    </div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>

</div>


