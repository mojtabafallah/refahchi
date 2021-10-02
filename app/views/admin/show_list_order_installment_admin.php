<?php
global $wpdb;
$arr_order_installment = $wpdb->get_results("select * from {$wpdb->prefix}order_details");
?>
<style>
    ul, #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-left: 6px;
        margin-right: 10px
    }

    .caret-down::before {
        -ms-transform: rotate(90deg); /* IE 9 */
        -webkit-transform: rotate(90deg); /* Safari */
    ' transform: rotate(90 deg);
    }

    .nested {
        display: none;
    }

    .active {
        display: block;
    }

    .caret-one {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        font-size: 1.2rem !important;
        margin-top: 12px
    }

    .caret-two {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        font-size: 1rem !important;
        margin: 5px 0px;
        margin-left: 50px
    }

    .caret-three {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 10px;
        margin: 5px 0px;
        margin-left: 50px
    }

    .caret-three-container {
        margin: 25px 0px
    }
</style>
<div class="wrap">
    <h1>
        مدیریت سفارشات اقساطی
    </h1>
    <div style="display: flex">
        <input type="hidden" id="section" value="month">
        <label for="id_order">شناسه خرید</label>
        <input type="text" class="filter_list_order" id="id_order">
        <label for="name">نام و نام خانوادگی</label>
        <input type="text" class="filter_list_order" id="name">
        <label for="organ">سازمان(شرکت)</label>
        <select id="organ" class="filter_list_order">
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

            ?>

        </select>
        <label for="id_order">کد ملی</label>
        <input type="text" class="filter_list_order" id="code_melli">
        <label for="id_order">کد پرسنلی</label>
        <input type="text" class="filter_list_order" id="code_personnel">
        <label for="id_order">تلفن همراه</label>
        <input type="text" class="filter_list_order" id="mobile">
        <form action="" method="post" enctype="multipart/form-data">
            <button type="submit" name="export_excel" id="export_installment_excel" class="button-primary">خروجی اکسل
            </button>
        </form>

    </div>
    <div style="direction: ltr">
        <?php
        $query = new WP_Query(array(
            'post_type' => 'organization',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));


        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            ?>
            <ul id="myUL">
                <li>
                    <div class="caret caret-one"><?php the_title() ?></div>
                    <ul class="nested">
                        <?php
                        global $wpdb;
                        $showed_user = [];
                        $installment_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor <> 0");
                        foreach ($installment_order as $order) {

                            $id_user = $order->id_user;
                            if (get_user_by('id', $order->id_user)->organ == get_the_ID()) {

                                if (!in_array($order->id_user, $showed_user)) {
                                    echo "<li class='caret-two'><span class='caret'>" . get_user_by('id', $order->id_user)->display_name . "(" . get_userdata($order->id_user)->user_login . ")";
                                    echo '   <ul class="nested caret-three-container">';
                                    foreach ($installment_order as $order_installment) {
                                        if ($order->id_user == $order_installment->id_user) {

                                            echo '<li class="caret-three"> <span class="filter_tree_order" data-user="' . $order_installment->id_user . '" data-product="' . $order_installment->id_product . '" data-details="' . $order_installment->id . '" > ' . get_the_title($order_installment->id_product) . '</span></li>';
                                        }

                                    }
                                    echo '</ul>';

                                    array_push($showed_user, $order->id_user);
                                }


                            }


                        }
                        ?>

                    </ul>
                </li>
            </ul>
            <?php
        }

        wp_reset_query();

        ?>
    </div>
    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function () {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }
    </script>
    <table class="widefat">
        <thead>
        <tr>
            <th>شماره</th>
            <th>شناسه خرید</th>
            <th>کد ملی</th>
            <th>کد پرسنلی</th>
            <th>نام و نام خانوادگی خریدار</th>
            <th>تلفن همراه</th>
            <th>نام شرکت</th>
            <th>نام محصول</th>
            <th>نام فروشگاه</th>
            <th>تعداد</th>
            <th>درصد سود هر ماه</th>
            <th>مبلغ پیش پرداخت</th>
            <th>نام سرمایه گذار</th>
            <th>مبلغ کل خرید قسطی</th>
            <th>تعداد کل قسط</th>
            <th>تعداد پرداخت شده</th>
            <th>وضعیت</th>
            <th>تاریخ سررسید</th>
            <th>زمان خرید</th>
            <th>وضعیت سفارش</th>
        </tr>
        </thead>
        <tbody id="t-body">
        <?php
        include URI_THEME . "/app/jdf.php";

        foreach ($arr_order_installment as $order): ?>

            <tr>
                <td>
                    <?php echo $order->id ?>
                </td>
                <td>
                    <?php echo $order->id_order ?>
                </td>
                <td>
                    <?php echo get_userdata($order->id_user)->user_login; ?>
                </td>
                <td>
                    <?php echo get_userdata($order->id_user)->code_personnel; ?>
                </td>
                <td>
                    <?php
                    echo get_user_by('id', $order->id_user)->display_name; ?>
                </td>
                <td>
                    <?php echo get_userdata($order->id_user)->mobile; ?>
                </td>
                <td>
                    <?php echo get_the_title(get_user_by('id', $order->id_user)->organ); ?>
                </td>
                <td>
                    <?php echo get_the_title($order->id_product) ?>
                </td>

                <td>
                    <?php

                    $seller = get_post_field('post_author', $order->id_product);
                    $author = get_user_by('id', $seller);
                    $vendor = dokan()->vendor->get($seller);

                    $store_info = dokan_get_store_info($author->ID);
                    if (!empty($store_info['store_name'])) { ?>
                        <span class="details">
                        <?php printf(' <a href="%s">%s</a>', $vendor->get_shop_url(), $vendor->get_shop_name()); ?>
                    </span>
                        <?php
                    } ?>
                </td>
                <td>

                    <?php echo $order->qty ?>
                </td>
                <td>
                    <?php echo $order->darsa_profit ?>
                </td>
                <td>
                    <?php
                    echo number_format($order->price_pish) ?>تومان
                </td>

                <td>
                    <?php

                    $get_user = get_user_meta($order->id_investor);

                    if (isset($get_user['dokan_store_name'][0])) {

                        $store_name = $get_user['dokan_store_name'][0];

                        echo($store_name);
                    } else {
                        echo $order->id_investor != 0 ? get_user_by('id', $order->id_investor)->display_name : "ندارد";
                    }


                    ?>
                </td>
                <td>
                    <?php echo number_format($order->price_installment) ?>تومان
                </td>
                <td>
                    <?php echo $order->num_month ?>
                </td>
                <td>
                    <?php
                    $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$order->id} and status=1 ");
                    echo $aa->count_pay; ?>

                </td>
                <td>
                    <?php echo $order->status == 0 ? "تکمیل نشده" : "تکمیل شده" ?>
                </td>
                <td>
                    <?php echo $order->day_due ?> هر ماه
                </td>
                <td>
                    <?php
                    $order = wc_get_order($order->id_order);
                    echo jdate("Y/n/d", strtotime($order->get_date_created()));

                    ?>

                </td>
                <td>
                    <?php
                    echo $order->get_status(); ?>

                </td>


            </tr>
        <?php endforeach; ?>


        </tbody>

    </table>
</div>