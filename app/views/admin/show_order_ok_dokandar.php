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
$id_user=get_current_user_id();
$all_wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor={$id_user}");


?>


<div class="wrap">
    <h1>
        محصولات تایید شده توسط شما
    </h1>
    <div style="display: flex">
        <label for="id_order">شناسه خرید</label>
        <input type="text" class="filter_list_dokandar" id="id_order">
        <label for="name">نام و نام خانوادگی</label>
        <input type="text" class="filter_list_dokandar" id="name">
        <label for="organ">سازمان(شرکت)</label>
        <select id="organ" class="filter_list_dokandar">
            <option value="%%">سازمان</option>
            <?php
            $query = new WP_Query(array(
                'post_type' => 'organization',
                'post_status' => 'publish',
                'posts_per_page' => -1
            ));


            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                echo "<option value='$post_id'>" . get_the_title() . "</option>";
            }

            wp_reset_query();
            include URI_THEME . "/app/jdf.php";
            ?>

        </select>
        <label for="id_order">کد ملی</label>
        <input type="text" class="filter_list_dokandar" id="code_melli">
        <label for="id_order">کد پرسنلی</label>
        <input type="text" class="filter_list_dokandar" id="code_personnel">
        <label for="id_order">تلفن همراه</label>
        <input type="text" class="filter_list_order" id="mobile">
        <form action="" method="post" enctype="multipart/form-data">
            <button type="submit" name="export_excel" id="export_installment_excel" class="button-primary">خروجی اکسل
            </button>
        </form>

    </div>
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
            <th>چاپ</th>
        </tr>
        </thead>
        <tbody id="t-body">
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
                    echo get_user_by('id', $item->id_user)->display_name; ?>
                </td>

                <td>
                    <?php echo get_the_title(get_user_by('id', $item->id_user)->organ); ?>
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
                <td>
                    <?php

                     $order= wc_get_order($item->id_order);
                     echo jdate("Y-n-j H:i:s", strtotime($order->get_date_created()));

                    ?>
                </td>
                <td>
                    <?php
                    $wpdb->get_results("select * from {$wpdb->prefix}installments where id_details={$item->id} and status=1 ")
                    ?>
                    <?php echo $item->num_month?> /    <?php echo $wpdb->num_rows?>
                </td>


            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>



