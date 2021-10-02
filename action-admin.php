<?php
if (!defined('ABSPATH')) {
    exit;
}
add_action("wp_ajax_return_installment", "filter_installment");

function filter_installment()
{
    check_ajax_referer("search_installment", "nonce");
    include URI_THEME . "/app/jdf.php";
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    global $wpdb;

    $date_from = $_POST['from_y'] . '/' . $_POST['from_m'] . '/' . $_POST['from_d'];
    $date_to = $_POST['to_y'] . '/' . $_POST['to_m'] . '/' . $_POST['to_d'];
    if ($date_to == "//") $date_to = "1430/12/12";
    if ($date_from == "//") $date_from = "1400/1/1";

//    echo $_POST['section'];

    if ($_POST['section'] == "all") {
        $all_installment = $wpdb->get_results(
            "select * from {$wpdb->prefix}installments where id_order like '%{$_POST['id_order']}%' and day between '{$date_from}' and '{$date_to}'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");
    }
    if ($_POST['section'] == "month") {
        $month_now = convert(jdate("n"));
        $year_now = convert(jdate("Y"));

        $date_from = $year_now . "/" . $month_now . "/1";
        $date_to = $year_now . "/" . $month_now . "/31";

        $all_installment = $wpdb->get_results(
            "select * from {$wpdb->prefix}installments where id_order like '%{$_POST['id_order']}%' and day between '{$date_from}' and '{$date_to}'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");

    }

    if ($_POST['section'] == "payed") {
        $all_installment = $wpdb->get_results(
            "select * from {$wpdb->prefix}installments where status = 1 and id_order like '%{$_POST['id_order']}%' and day between '{$date_from}' and '{$date_to}'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");
    }

    if ($_POST['section'] == "not_payed") {
        $all_installment = $wpdb->get_results(
            "select * from {$wpdb->prefix}installments where status = 0 and id_order like '%{$_POST['id_order']}%' and day between '{$date_from}' and '{$date_to}'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");
    }


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
                           href="<?php echo add_query_arg(['action' => 'pay', 'item' => $installment->id],get_site_url() . "/wp-admin/admin.php?page=all_installment") ?>">
                            <button class="button button-primary button-large" type="button">پرداخت</button>
                        </a>
                    <?php else: ?>
                        <a style="margin: 10px"
                           href="<?php echo add_query_arg(['action' => 'print', 'item' => $installment->id],get_site_url() . "/wp-admin/admin.php?page=all_installment") ?>">
                            <button class="button button-primary button-large" type="button">چاپ</button>
                        </a>

                    <?php endif; ?>
                </div>
            </td>


        </tr>
    <?php endforeach;


}



// filter order

add_action("wp_ajax_return_order", "filter_order");

function filter_order()
{
    check_ajax_referer("search_installment", "nonce");
    include URI_THEME . "/app/jdf.php";
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    global $wpdb;

    $all_installment = $wpdb->get_results(
        "select * from {$wpdb->prefix}order_details where id_order like '%{$_POST['id_order']}%'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");



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
                <?php
                echo get_user_by('id', $installment->id_user)->display_name; ?>
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

                $seller = get_post_field('post_author', $installment->id_product);
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

                <?php echo $installment->qty ?>
            </td>
            <td>
                <?php echo $installment->darsa_profit ?>
            </td>
            <td>
                <?php
                echo number_format($installment->price_pish) ?>تومان
            </td>

            <td>
                <?php

                $get_user = get_user_meta($installment->id_investor);

                if (isset($get_user['dokan_store_name'][0])) {

                    $store_name = $get_user['dokan_store_name'][0];

                    echo($store_name);
                } else {
                    echo $installment->id_investor != 0 ? get_user_by('id', $installment->id_investor)->display_name : "ندارد";
                }


                ?>
            </td>
            <td>
                <?php echo number_format($installment->price_installment) ?>تومان
            </td>
            <td>
                <?php echo $installment->num_month ?>
            </td>
            <td>
                <?php
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$installment->id} and status=1 ");
                echo $aa->count_pay; ?>

            </td>
            <td>
                <?php echo $installment->status == 0 ? "تکمیل نشده" : "تکمیل شده" ?>
            </td>
            <td>
                <?php echo $installment->day_due ?> هر ماه
            </td>
            <td>
                <?php
                $order = wc_get_order($installment->id_order);
                echo jdate("Y/n/d", strtotime($order->get_date_created()));

                ?>

            </td>
            <td>
                <?php
                echo $order->get_status(); ?>

            </td>


        </tr>
    <?php endforeach;


}


// filter order dokandar

add_action("wp_ajax_return_list_dokandar", "filter_order_dokandar");

function filter_order_dokandar()
{
    check_ajax_referer("search_installment", "nonce");
    include URI_THEME . "/app/jdf.php";
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    global $wpdb;
    $id_user=get_current_user_id();
    $all_installment = $wpdb->get_results(
        "select * from {$wpdb->prefix}order_details where id_investor={$id_user} and id_order like '%{$_POST['id_order']}%'  and id_user in 
           (select id from {$wpdb->users} where display_name like '%{$_POST['name']}%' and id in 
               ( select user_id from {$wpdb->usermeta} where meta_key='organ' and  meta_value like  '{$_POST['organ']}' and user_id in 
                (select user_id from {$wpdb->usermeta} where meta_key='code_personnel' and  meta_value like  '%{$_POST['code_personnel']}%' and user_id in 
                  ( select user_id from {$wpdb->usermeta} where meta_key='mobile' and  meta_value like  '%{$_POST['mobile']}%' and user_id in 
                   ( select ID from {$wpdb->users} where   user_login like  '%{$_POST['code_melli']}%' ))  )))  ");



    foreach ($all_installment as $item): ?>
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
            <td></td>
            <td>
                <?php
                $wpdb->get_results("select * from {$wpdb->prefix}installments where id_details={$item->id} and status=1 ")
                ?>
                <?php echo $item->num_month?> /    <?php echo $wpdb->num_rows?>
            </td>


        </tr>
    <?php endforeach;


}



//filter tree installment
add_action("wp_ajax_return_installment_tree", "filter_installment_tree");

function filter_installment_tree()
{
    check_ajax_referer("search_installment", "nonce");
    include URI_THEME . "/app/jdf.php";
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    global $wpdb;


    $all_installment = $wpdb->get_results("select * from {$wpdb->prefix}installments where id_product = {$_POST['product']} and id_user= {$_POST['user']} and id_details={$_POST['details']}");





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
                <?php if (!is_null($installment->day_pay)) echo jdate("Y-n-j H:i:s", strtotime($installment->day_pay)); else echo  "-"?>
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
                           href="<?php echo add_query_arg(['action' => 'pay', 'item' => $installment->id],get_site_url() . "/wp-admin/admin.php?page=all_installment") ?>">
                            <button class="button button-primary button-large" type="button">پرداخت</button>
                        </a>
                    <?php else: ?>
                        <a style="margin: 10px"
                           href="<?php echo add_query_arg(['action' => 'print', 'item' => $installment->id],get_site_url() . "/wp-admin/admin.php?page=all_installment") ?>">
                            <button class="button button-primary button-large" type="button">چاپ</button>
                        </a>

                    <?php endif; ?>
                </div>
            </td>


        </tr>
    <?php endforeach;


}


//filter tree order
add_action("wp_ajax_return_order_tree", "filter_order_tree");

function filter_order_tree()
{
    check_ajax_referer("search_installment", "nonce");
    include URI_THEME . "/app/jdf.php";
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    global $wpdb;


    $all_installment = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_product = {$_POST['product']} and id_user= {$_POST['user']} and id={$_POST['details']}");





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
                <?php
                echo get_user_by('id', $installment->id_user)->display_name; ?>
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

                $seller = get_post_field('post_author', $installment->id_product);
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

                <?php echo $installment->qty ?>
            </td>
            <td>
                <?php echo $installment->darsa_profit ?>
            </td>
            <td>
                <?php
                echo number_format($installment->price_pish) ?>تومان
            </td>

            <td>
                <?php

                $get_user = get_user_meta($installment->id_investor);

                if (isset($get_user['dokan_store_name'][0])) {

                    $store_name = $get_user['dokan_store_name'][0];

                    echo($store_name);
                } else {
                    echo $installment->id_investor != 0 ? get_user_by('id', $installment->id_investor)->display_name : "ندارد";
                }


                ?>
            </td>
            <td>
                <?php echo number_format($installment->price_installment) ?>تومان
            </td>
            <td>
                <?php echo $installment->num_month ?>
            </td>
            <td>
                <?php
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$installment->id} and status=1 ");
                echo $aa->count_pay; ?>

            </td>
            <td>
                <?php echo $installment->status == 0 ? "تکمیل نشده" : "تکمیل شده" ?>
            </td>
            <td>
                <?php echo $installment->day_due ?> هر ماه
            </td>
            <td>
                <?php
                $order = wc_get_order($installment->id_order);
                echo jdate("Y/n/d", strtotime($order->get_date_created()));

                ?>

            </td>
            <td>
                <?php
                echo $order->get_status(); ?>

            </td>


        </tr>

    <?php endforeach;


}


/** filter personnel hook */
add_action("wp_ajax_return_personnel", "filter_personnel_ajax");
function filter_personnel_ajax()
{


    check_ajax_referer("search_installment", "nonce");


    $id_manger_organ = get_current_user_id();

    $args = array(
        'meta_key' => 'id_manager_organization',
        'meta_value' => $id_manger_organ,
        'post_type' => 'organization',
        'post_status' => 'any',
        'posts_per_page' => -1
    );
    $organs = get_posts($args);


    $users = get_users(['role' => 'personnel']);


    foreach ($organs as $organ):
        foreach ($users as $user): ?>
            <?php if ($user->organ == $organ->ID): ?>
                <?php if ((strpos($user->user_login, $_POST['code_melli']) !== false) || $_POST['code_melli'] == null): ?>
                    <?php if ((strpos($user->first_name, $_POST['name']) !== false) || $_POST['name'] == null): ?>
                        <?php if ((strpos($user->last_name, $_POST['family']) !== false) || $_POST['family'] == null): ?>

                            <tr>
                                <td><?php echo $user->ID ?></td>
                                <td><?php echo $user->user_login ?></td>
                                <td><?php echo $user->code_personnel ?></td>
                                <td><?php echo $user->first_name ?></td>
                                <td><?php echo $user->last_name ?></td>
                                <td><?php echo $user->mobile ?></td>
                                <td><?php echo $user->credit_password ?></td>
                                <td><?php echo $user->obstruction ?></td>
                                <td><?php echo $user->obstruction_description ?></td>
                                <td><?php echo $user->obstruction_number ?></td>
                                <td><?php echo $user->name_bank ?></td>
                                <td><?php echo $user->account_number ?></td>
                                <td><?php echo $user->cart_number ?></td>
                                <td><?php echo $user->sheba_number ?></td>
                                <td><?php echo $user->branch_bank_name ?></td>
                                <td><?php echo get_the_title($user->organ) ?></td>

                                <td><?php echo get_user_by('id', get_post_meta($user->organ, 'id_manager_organization', true))->user_login ?></td>


                                <td><?php echo $user->position_job ?></td>
                                <td><?php echo $user->_current_woo_wallet_balance != null ? number_format($user->_current_woo_wallet_balance) : 0 ?>
                                    تومان
                                </td>

                                <td><?php echo $user->organ_unit ?></td>
                                <td>
                                    <a href="<?php echo add_query_arg(['action' => 'delete', 'item' => $user->ID], get_site_url() . "/wp-admin/admin.php?page=manage_personnel_manger") ?>"><span
                                                class="dashicons dashicons-trash"></span></a>
                                    <a href="<?php echo add_query_arg(['action' => 'edit', 'item' => $user->ID], get_site_url() . "/wp-admin/admin.php?page=manage_personnel_manger") ?>"><span
                                                class="dashicons dashicons-edit"></span></a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php
        endforeach;
    endforeach;


}


/** add field mobile when creat user */
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');
add_action("user_new_form", "custom_user_profile_fields");
function custom_user_profile_fields($user)
{

    ?>
    <table class="form-table">
        <tr>
            <th scope="row">شماره همراه:</th>
            <td><input type="text" size="32" name="mobile"
                       value="<?php if ($user != "add-new-user") echo esc_attr(get_the_author_meta('mobile', $user->ID)); ?>"/>
            </td>
        </tr>
    </table>
    <?php
}

function save_custom_user_profile_fields($user_id)
{
    # again do this only if you can
    if (!current_user_can('manage_options'))
        return false;

    # save my custom field
    update_usermeta($user_id, 'mobile', $_POST['mobile']);
}

add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');


/** send sms not ok and for me send sms :-)  */

date_default_timezone_set('Asia/Tehran');

add_filter('cron_schedules', function ($schedules) {
    $schedules['ten_sec'] = array(
        'interval' => 86400,
        'display' => __('Twelve Minutes')
    );
    return $schedules;
});

// after 2 day wait to list list wait investor status changed return to store

if (!wp_next_scheduled('w4dev_one_minute_event')) {
    wp_schedule_event(time(), 'daily', 'w4dev_one_minute_event');
}


add_action('w4dev_one_minute_event', function () {

    /** wait 2 day order after change status order to return store  */

    global $wpdb;

    $all_wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor=0");

    foreach ($all_wait_order as $item):


        /** check status order wait investor */
        $order = wc_get_order($item->id_order);
//                  var_dump($item->id_order);
        //            var_dump($order->get_status());
        if ($order->get_status() == "shipping-investor"):
            $date_modify = $order->get_date_created();

            $now = time(); // or your date as well
            $your_date = strtotime($date_modify);
            $datediff = $now - $your_date;

            $days_diff = round($datediff / (60 * 60 * 24));
            if ($days_diff == 2) {
                $order = new WC_Order($item->id_order);
                $order->update_status('return-store', 'بازگشت به فروشگاه برای کنترل مجدد');
            }


        endif;
    endforeach;

    /** send sms pay installment today */

    include URI_THEME . "/app/jdf.php";
    $date_today = jdate('Y/n/d');
    $installment_today = $wpdb->get_results("select * from {$wpdb->prefix}installments where day={$date_today}");
    foreach ($installment_today as $installment) {
        $mobile = get_user_by('id', $installment->id_user)->mobile;
        $url = 'http://www.0098sms.com/sendsmslink.aspx';
        $data = array(
            'FROM' => '30005367',
            'TO' => $mobile,
            'TEXT' => "سلام موعد قسط شما فرا رسیده است",
            'USERNAME' => 'smsr8636',
            'PASSWORD' => '88656645',
            'DOMAIN' => '0098',
        );


        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }

    }

    // send sms 5 day for pay


    $date_5 = date('Y/m/d', strtotime(time() . ' + 5 days'));
    $date_today = jdate('Y/n/d', $date_5);
    $installment_today = $wpdb->get_results("select * from {$wpdb->prefix}installments where day={$date_today}");
    foreach ($installment_today as $installment) {
        $mobile = get_user_by('id', $installment->id_user)->mobile;
        $url = 'http://www.0098sms.com/sendsmslink.aspx';
        $data = array(
            'FROM' => '30005367',
            'TO' => $mobile,
            'TEXT' => "سلام 5 روز مانده تا پرداخت  قسط شما",
            'USERNAME' => 'smsr8636',
            'PASSWORD' => '88656645',
            'DOMAIN' => '0098',
        );


        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }

    }


});


