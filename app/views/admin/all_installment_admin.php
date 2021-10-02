<?php
include URI_THEME . "/app/jdf.php";
global $wpdb;
$all_installment = $wpdb->get_results("select * from {$wpdb->prefix}installments"); ?>
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
        همه اقساط
    </h1>
    <div style="display: flex">
        <input type="hidden" id="section" value="all">
        <label for="id_order">شناسه خرید</label>
        <input type="text" class="filter_list_installment" id="id_order">
        <label for="name">نام و نام خانوادگی</label>
        <input type="text" class="filter_list_installment" id="name">
        <label for="organ">سازمان(شرکت)</label>
        <select id="organ" class="filter_list_installment">
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
        <label for="from">از تاریخ</label>
        <select id="from_day" class="filter_list_installment">
            <option value="">روز</option>
            <?php for ($i = 1; $i <= 31; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
        <select id="from_month" class="filter_list_installment">
            <option value="">ماه</option>
            <option value="1">فروردین</option>
            <option value="2">اردیبهشت</option>
            <option value="3">خرداد</option>
            <option value="4">تیر</option>
            <option value="5">مرداد</option>
            <option value="6">شهریور</option>
            <option value="7">مهر</option>
            <option value="8">آبان</option>
            <option value="9">آذر</option>
            <option value="10">دی</option>
            <option value="11">بهمن</option>
            <option value="12">اسفند</option>
        </select>
        <select id="from_year" class="filter_list_installment">
            <option value="">سال</option>

            <?php for ($i = 1400; $i <= 1430; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
        <label for="from">تا تاریخ</label>
        <select id="to_day" class="filter_list_installment">
            <option value="">روز</option>
            <?php for ($i = 1; $i <= 31; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
        <select id="to_month" class="filter_list_installment">
            <option value="">ماه</option>
            <option value="1">فروردین</option>
            <option value="2">اردیبهشت</option>
            <option value="3">خرداد</option>
            <option value="4">تیر</option>
            <option value="5">مرداد</option>
            <option value="6">شهریور</option>
            <option value="7">مهر</option>
            <option value="8">آبان</option>
            <option value="9">آذر</option>
            <option value="10">دی</option>
            <option value="11">بهمن</option>
            <option value="12">اسفند</option>
        </select>
        <select id="to_year" class="filter_list_installment">
            <option value="">سال</option>
            <?php for ($i = 1400; $i <= 1430; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div style="display: flex">
        <label for="id_order">کد ملی</label>
        <input type="text" class="filter_list_installment" id="code_melli">
        <label for="id_order">کد پرسنلی</label>
        <input type="text" class="filter_list_installment" id="code_personnel">
        <label for="id_order">تلفن همراه</label>
        <input type="text" class="filter_list_installment" id="mobile">
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
                <li><div class="caret caret-one"><?php the_title() ?></div>
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

                                            echo '<li class="caret-three"> <span class="filter_tree" data-user="' . $order_installment->id_user . '" data-product="' . $order_installment->id_product . '" data-details="' . $order_installment->id . '" > ' . get_the_title($order_installment->id_product) . '</span></li>';
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
            <th>شماره قسط</th>
            <th>شناسه خرید</th>
            <th>کد ملی</th>
            <th>کد پرسنلی</th>
            <th>نام و نام خانوادگی خریدار</th>
            <th>تلفن همراه</th>
            <th>نام شرکت</th>
            <th>نام محصول</th>
            <th>نام فروشگاه</th>
            <th>تعداد</th>
            <th>مبلغ کل خرید قسطی</th>
            <th>مبلغ قسط</th>
            <th>تعداد کل قسط</th>
            <th>تعداد پرداخت شده</th>
            <th>وضعیت پرداخت</th>
            <th>تاریخ سررسید</th>
            <th>تاریخ پرداخت</th>
            <th>زمان خرید</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody id="t-body">
        <?php

        foreach ($all_installment as $installment): ?>

            <tr>
                <td>
                    <?php echo $installment->id ?>
                </td>
                <td>
                    <?php echo $installment->id_order ?>
                </td>
                <td>
                    <?php echo get_userdata($installment->id_user)->user_login; ?>
                </td>
                <td>
                    <?php echo get_userdata($installment->id_user)->code_personnel; ?>
                </td>
                <td>
                    <?php echo get_user_by('id', $installment->id_user)->display_name; ?>
                </td>
                <td>
                    <?php echo get_userdata($installment->id_user)->mobile; ?>
                </td>
                <td>
                    <?php echo get_the_title(get_user_by('id', $installment->id_user)->organ); ?>
                </td>
                <td>
                    <?php echo get_the_title($installment->id_product) ?>
                </td>
                <td>
                    <?php

                    $seller = get_post_field('post_author',$installment->id_product);
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
                    <?php

                    $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$installment->id_details}");

                    ?>
                    <?php echo $order_detail->qty ?>
                </td>
                <td>
                    <?php

                    echo number_format($installment->total_price_installment) ?>تومان
                </td>
                <td>
                    <?php echo number_format($installment->price_one_installment) ?>تومان
                </td>
                <td>
                    <?php echo $installment->num_installment ?>
                </td>
                <td>
                    <?php
                    $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$installment->id_details} and status=1 ");
                    echo $aa->count_pay; ?>

                </td>
                <td>
                    <?php echo $installment->status == 0 ? "پرداخت نشده" : "پرداخت شده" ?>
                </td>
                <td>
                    <?php echo $installment->day ?>
                </td>
                <td>
                    <?php if (!is_null($installment->day_pay)) echo jdate("Y-n-j H:i:s", strtotime($installment->day_pay)) ?>
                </td>
                <td>
                    <?php
                    $order = wc_get_order( $installment->id_order );

                    // Get Order Dates
                    echo jdate("Y-n-j H:i:s", strtotime($order->get_date_created()));

                    ?>

                </td>
                <td>
                    <div style="display: flex">
                        <?php if ($installment->status == 0): ?>
                            <a style="margin: 10px"
                               href="<?php echo add_query_arg(['action' => 'pay', 'item' => $installment->id]) ?>">
                                <button class="button button-primary button-large" type="button">پرداخت</button>
                            </a>
                        <?php else: ?>
                            <a style="margin: 10px"
                               href="<?php echo add_query_arg(['action' => 'print', 'item' => $installment->id]) ?>">
                                <button class="button button-primary button-large" type="button">چاپ</button>
                            </a>

                        <?php endif; ?>
                    </div>
                </td>


            </tr>
        <?php endforeach; ?>


        </tbody>

    </table>
</div>
