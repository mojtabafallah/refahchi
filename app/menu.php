<?php


namespace app;

use XLSXWriter;

class menu
{
    public static function add_all_menu_admin()
    {
        //manage slider and banner
        add_menu_page(
            'مدیریت اسلایدر و بنرها',
            'مدیریت اسلایدر و بنرها',
            'manage_options',
            'manage_slider',
            function () {
                menu::manage_slider_admin();
            }
        );


        $notification_count = 2;
        add_menu_page(
            'پلن های فروشگاهی (ادمین)',
            'پلن های فروشگاهی (ادمین)',
            'manage_options',
            'setting_plans',
            function () {
                menu::show_plan_admin();
            }
        );

        add_menu_page(
            'مدیریت سفارشات قسطی(ادمین)',
            'مدیریت سفارشات قسطی(ادمین)',
            'manage_options',
            'manage_order_installment',
            function () {
                menu::manage_order_installment_admin();
            }
        );

        add_menu_page(
            'کالاهای درخواستی کاربران',
            'کالاهای درخواستی کاربران(ادمین)',
            'manage_options',
            'manage_request_product',
            function () {
                menu::manage_request_product();
            }
        );


        add_menu_page(
            'پلن های فروشگاه من',
            'پلن های فروشگاه من',
            'dokandar',
            'setting_my_plans',
            function () {
                menu::show__my_plan();
            }
        );

        add_menu_page(
            'مدیریت قسطها',
            'مدیریت قسط ها',
            'manage_options',
            'all_installment',
            function () {
                menu::show_all_installment();
            }
        );
        add_submenu_page(
            "all_installment",
            "قسط های این ماه",
            "اقساط این ماه",
            "manage_options",
            "installment_this_month",
            function () {
                menu::show_installment_this_month();
            }
        );

        add_submenu_page(
            "all_installment",
            "قسط های پرداخت شده",
            "قسط های پرداخت شده",

//            $notification_count ? sprintf('قسط های پرداخت شده <span class="awaiting-mod">%d</span>', $notification_count) : '',
            "manage_options",
            "installment_payed",
            function () {
                menu::show_installment_payed();
            }
        );

        add_submenu_page(
            "all_installment",
            "قسط های پرداخت نشده",
            "قسط های پرداخت نشده",
            "manage_options",
            "installment_not_payed",
            function () {
                menu::show_installment_not_payed();
            }
        );

        add_submenu_page(
            "all_installment",
            "پرداخت بصورت جمعی",
            "پرداخت بصورت جمعی",
            "manage_options",
            "installment_pay_excel",
            function () {
                menu::installment_pay_by_excel();
            }
        );


        /** dokandar menu */

        add_menu_page(
            'سفارشات اقساطی',
            'سفارشات اقساطی',
            'dokandar',
            'wait_order_installment_dokandar',
            function () {
                menu::show_order_wait_dokandar();
            }
        );

        add_submenu_page(
            'wait_order_installment_dokandar',
            'تایید شده',
            'تایید شده',
            'dokandar',
            'ok_order_installment_dokandar',
            function () {
                menu::show_order_ok_dokandar();
            }
        );


        /** manager organ */
        add_menu_page(
            'سفارشات',
            'سفارشات',
            'manager_organ',
            'manage_order',
            function () {
                menu::show__all_oreder_pesonnell_for_manger();

            }
        );

        add_submenu_page(
            'manage_order',
            ' در حال انتظار',
            'در حال انتظار',
            'manager_organ',
            'wait_order',
            function () {
                menu::show_order_wait_ok();
            });


        add_menu_page(
            'مدیریت پرسنل من',
            'مدیریت پرسنل من',
            'manager_organ',
            'manage_personnel_manger',
            function () {
                menu::show_personnel_manager();

            }
        );


        /** menu investor */
        add_menu_page(
            'سفارشات',
            'سفارشات',
            'investor',
            'manage_order_installment_investor',
            function () {
                // menu::show__all_oreder_pesonnell_for_manger();
            }
        );

        add_submenu_page(
            'manage_order_installment_investor',
            ' در حال انتظار',
            'در حال انتظار',
            'investor',
            'wait_order_installment_investor',
            function () {
                menu::show_order_wait_investor();
            });

        add_submenu_page(
            'manage_order_installment_investor',
            'تایید شده',
            'تایید شده',
            'investor',
            'ok_order_installment_investor',
            function () {
                menu::show_order_wait_ok_investor();
            });


        add_menu_page(
            'افراد سازمان(ادمین)',
            'افراد سازمان(ادمین)',
            'manage_options',
            'personnel_show',
            function () {
                menu::show_person();
            }

        );

        add_submenu_page('personnel_show',
            'افزودن یک پرسنل',
            'افزودن',
            'manage_options',
            'personnel_show&action=add',
            function () {
                menu::show_person();
            });

        add_menu_page(
            'پلن های عمومی',
            'پلن های عمومی',
            'manage_options',
            'plans_default',
            function () {
                menu::show_default_plan();

            }
        );


        /** setting theme */
        add_menu_page("تنظیمات قالب",
            'تنظیمات قالب',
            'manage_options',
            'setting_theme',
            function () {
                menu::show_setting_theme();
            });


//        add_submenu_page('setting_theme', 'تنظیمات منو اصلی', 'منو', 'manage_options', 'setting_menu', array(panel::class, 'load_menu_panel'));
//        add_submenu_page('setting_theme', 'تنظیمات اسلایدر', 'اسلایدر', 'manage_options', 'setting_slider', array(panel::class, 'load_slider_panel'));

    }

    private static function show_setting_theme()
    {
        if (isset($_POST['save_setting_theme'])) {
            update_option("logo_site", $_POST['url_logo']);
            update_option("address", $_POST['address']);
            update_option("tel", $_POST['tel']);
            update_option("description_site", $_POST['content_editor_description']);
        }
        include "views/menu/setting_theme.php";
    }


    public static function show_person()
    {

        /** handel action personnel **/

        if (isset($_GET['action'])) {

            if ($_GET['action'] == "add") {
                if (isset($_POST['register_personnel'])) {
                    wp_insert_user(
                        [
                            //code melli
                            'user_pass' => $_POST['code_melli'],
                            'user_login' => $_POST['code_melli'],
                            'user_nicename' => $_POST['name'],
                            'first_name' => $_POST['name'],
                            'last_name' => $_POST['family'],
                            'role' => 'personnel'

                        ]
                    );
                    $user = get_user_by('login', $_POST['code_melli']);
                    $obstruction = isset($_POST['obstruction']) ? 1 : 0;
                    update_user_meta($user->ID, 'code_personnel', $_POST['code_personnel']);
                    update_user_meta($user->ID, 'mobile', $_POST['mobile']);
                    update_user_meta($user->ID, 'organ', $_POST['organ_id']);
                    update_user_meta($user->ID, 'credit_password', $_POST['credit_password']);
                    update_user_meta($user->ID, 'obstruction', $obstruction);
                    update_user_meta($user->ID, 'obstruction_description', $_POST['obstruction_description']);
                    update_user_meta($user->ID, 'obstruction_number', $_POST['obstruction_number']);
                    update_user_meta($user->ID, 'name_bank', $_POST['name_bank']);
                    update_user_meta($user->ID, 'account_number', $_POST['account_number']);
                    update_user_meta($user->ID, 'cart_number', $_POST['cart_number']);
                    update_user_meta($user->ID, 'sheba_number', $_POST['sheba_number']);
                    update_user_meta($user->ID, 'branch_bank_name', $_POST['branch_bank_name']);
                    update_user_meta($user->ID, 'position_job', $_POST['position_job']);
                    update_user_meta($user->ID, 'organ_unit', $_POST['organ_unit']);
                }
                include "views/admin/add_personnel_admin.php";
            }


            if ($_GET['action'] == "edit") {
                if (isset($_POST['edit_personnel'])) {

                    $user = get_user_by('login', $_POST['code_melli']);
                    $obstruction = isset($_POST['obstruction']) ? 1 : 0;
                    update_user_meta($user->ID, 'first_name', $_POST['name']);
                    update_user_meta($user->ID, 'last_name', $_POST['family']);
                    update_user_meta($user->ID, 'code_personnel', $_POST['code_personnel']);
                    update_user_meta($user->ID, 'mobile', $_POST['mobile']);
                    update_user_meta($user->ID, 'organ', $_POST['organ_id']);
                    update_user_meta($user->ID, 'credit_password', $_POST['credit_password']);
                    update_user_meta($user->ID, 'obstruction', $obstruction);
                    update_user_meta($user->ID, 'obstruction_description', $_POST['obstruction_description']);
                    update_user_meta($user->ID, 'obstruction_number', $_POST['obstruction_number']);
                    update_user_meta($user->ID, 'name_bank', $_POST['name_bank']);
                    update_user_meta($user->ID, 'account_number', $_POST['account_number']);
                    update_user_meta($user->ID, 'cart_number', $_POST['cart_number']);
                    update_user_meta($user->ID, 'sheba_number', $_POST['sheba_number']);
                    update_user_meta($user->ID, 'branch_bank_name', $_POST['branch_bank_name']);
                    update_user_meta($user->ID, 'position_job', $_POST['position_job']);
                    update_user_meta($user->ID, 'organ_unit', $_POST['organ_unit']);


                }
                $user = get_user_by('id', $_GET['item']);

                $user_meta = get_user_meta($_GET['item']);

                include "views/admin/edit_personnel_admin.php";
            }
            if ($_GET['action'] == "delete") {
                wp_delete_user($_GET['item']);
                include "views/menu/show_personnal.php";
            }

        } else {
            include "views/menu/show_personnal.php";
        }


    }

    public static function show_plan_admin()
    {
        global $wpdb;

        if (isset($_POST['add_plan'])) {

            $wpdb->insert($wpdb->prefix . 'plans', [
                'id_vendor' => $_POST['vendor'],
                'pishe_darsad' => $_POST['pish_darsad'],
                'darsad_profit' => $_POST['darsad_profit'],
                'num_month' => $_POST['num_month'],
                'due_date' => $_POST['day_due']
            ]);
        }

        if (isset($_POST['edit_plan'])) {
            $active = isset($_POST['is_active']) ? 1 : 0;
            $remove = isset($_POST['is_remove']) ? 1 : 0;
            $wpdb->update($wpdb->prefix . 'plans',
                [
                    'id_vendor' => $_POST['vendor'],
                    'pishe_darsad' => $_POST['pishe_darsad'],
                    'num_month' => $_POST['num_month'],
                    'darsad_profit' => $_POST['darsad_profit'],
                    'due_date' => $_POST['day'],
                    'is_active' => $active,
                    'is_remove' => $remove
                ],
                ['id' => $_POST['id']]);

        }


        if (isset($_GET['action'])) {
            if ($_GET['action'] == "add") {
                include 'views/admin/add_plan_installment.php';

            } elseif ($_GET['action'] == "edit") {
                include 'views/admin/edit_plan_installment.php';

            } elseif ($_GET['action'] == "delete") {

                /**  delete all plan from product */

                $all_products = new \WP_Query([
                    'post_type' => 'product',
                    'status' => 'publish'
                ]);
                if ($all_products->have_posts()) {
                    while ($all_products->have_posts()) {
                        $all_products->the_post();
                        $plans = get_post_meta(get_the_ID(), 'plans', true);
                        unset($plans[$_GET['item']]);
                        update_post_meta(get_the_ID(), 'plans', $plans);

                    }
                }

                $plans = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_GET['item']}");
                if ($plans->is_remove == 0)
                    $wpdb->update($wpdb->prefix . 'plans', ['is_remove' => 1], ['id' => $_GET['item']]);
                elseif ($plans->is_remove == 1)
                    $wpdb->delete($wpdb->prefix . 'plans', ['id' => $_GET['item']]);
                include 'views/admin/plan_installment.php';
            }

        } else {
            include 'views/admin/plan_installment.php';
        }


    }

    public static function show_default_plan()
    {
        global $wpdb;

        if (isset($_POST['add_plan_default'])) {

            $wpdb->insert($wpdb->prefix . 'plans', [
                /**  id_vendor 0 => default  */
                'id_vendor' => 0,
                'pishe_darsad' => $_POST['pish_darsad'],
                'num_month' => $_POST['num_month'],
                'darsad_profit' => $_POST['darsad_profit'],
                'due_date' => $_POST['day_due']
            ]);
        }

        if (isset($_POST['edit_plan_default'])) {
            $active = isset($_POST['is_active']) ? 1 : 0;
            $remove = isset($_POST['is_remove']) ? 1 : 0;
            $wpdb->update($wpdb->prefix . 'plans',
                [
                    'id_vendor' => 0,
                    'pishe_darsad' => $_POST['pishe_darsad'],
                    'num_month' => $_POST['num_month'],
                    'darsad_profit' => $_POST['darsad_profit'],
                    'due_date' => $_POST['day'],
                    'is_active' => $active,
                    'is_remove' => $remove
                ],
                ['id' => $_POST['id']]);

        }


        if (isset($_GET['action'])) {
            if ($_GET['action'] == "add") {
                include 'views/admin/add_plan_default_installment.php';

            } elseif ($_GET['action'] == "edit") {
                include 'views/menu/edit_plan_default_installment.php';

            } elseif ($_GET['action'] == "delete") {
                $plans = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_GET['item']}");
                if ($plans->is_remove == 0)
                    $wpdb->update($wpdb->prefix . 'plans', ['is_remove' => 1], ['id' => $_GET['item']]);
                elseif ($plans->is_remove == 1)
                    $wpdb->delete($wpdb->prefix . 'plans', ['id' => $_GET['item']]);
                include 'views/menu/show_default_plans.php';
            }

        } else {
            include 'views/menu/show_default_plans.php';
        }
    }

    private static function show__my_plan()
    {
        global $wpdb;

        if (isset($_POST['add_plan'])) {

            $wpdb->insert($wpdb->prefix . 'plans', [
                'id_vendor' => get_current_user_id(),
                'pishe_darsad' => $_POST['pish_darsad'],
                'darsad_profit' => $_POST['darsad_profit'],
                'num_month' => $_POST['num_month'],
                'due_date' => $_POST['day_due']
            ]);
        }

        if (isset($_POST['edit_plan'])) {
            $active = isset($_POST['is_active']) ? 1 : 0;
            $remove = isset($_POST['is_remove']) ? 1 : 0;
            $wpdb->update($wpdb->prefix . 'plans',
                [
                    'id_vendor' => get_current_user_id(),
                    'pishe_darsad' => $_POST['pishe_darsad'],
                    'num_month' => $_POST['num_month'],
                    'darsad_profit' => $_POST['darsad_profit'],
                    'due_date' => $_POST['day'],
                    'is_active' => $active,
                    'is_remove' => $remove
                ],
                ['id' => $_POST['id']]);

        }


        if (isset($_GET['action'])) {
            if ($_GET['action'] == "add") {
                include 'views/admin/add_my_plan_installment.php';

            } elseif ($_GET['action'] == "edit") {
                include 'views/admin/edit_my_plan_installment.php';

            } elseif ($_GET['action'] == "delete") {
                $plans = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_GET['item']}");
                if ($plans->is_remove == 0)
                    $wpdb->update($wpdb->prefix . 'plans', ['is_remove' => 1], ['id' => $_GET['item']]);
                elseif ($plans->is_remove == 1)
                    $wpdb->delete($wpdb->prefix . 'plans', ['id' => $_GET['item']]);
                include 'views/admin/my_plan_installment.php';
            }

        } else {
            include 'views/admin/my_plan_installment.php';
        }


    }

    private static function show_order_wait_ok()
    {

        global $wpdb;

        if (isset($_POST['add_plan'])) {

            $wpdb->insert($wpdb->prefix . 'plans', [
                'id_vendor' => $_POST['vendor'],
                'pishe_darsad' => $_POST['pish_darsad'],
                'darsad_profit' => $_POST['darsad_profit'],
                'num_month' => $_POST['num_month']
            ]);
        }

        if (isset($_POST['edit_plan'])) {
            $active = isset($_POST['is_active']) ? 1 : 0;
            $remove = isset($_POST['is_remove']) ? 1 : 0;
            $wpdb->update($wpdb->prefix . 'plans',
                [
                    'id_vendor' => $_POST['vendor'],
                    'pishe_darsad' => $_POST['pishe_darsad'],
                    'num_month' => $_POST['num_month'],
                    'darsad_profit' => $_POST['darsad_profit'],
                    'is_active' => $active,
                    'is_remove' => $remove
                ],
                ['id' => $_POST['id']]);

        }


        if (isset($_GET['action'])) {
            if ($_GET['action'] == "ok") {


                $order = wc_get_order($_GET['item']);

                if ($order) {
                    $order->update_status('on-hold', '', true);
                }


                include 'views/admin/show_order_wait.php';

            } elseif ($_GET['action'] == "cancel") {

                $order = wc_get_order($_GET['item']);


                /** return price canceled */


                if ($order) {
                    if ($order->get_status() != 'failed') {
                        $wallet = new \Woo_Wallet_Wallet();
                        $wallet->credit($order->get_customer_id(), $order->get_total(), "تایید نشدن سفارش");
                        $order->update_status('failed', '', true);
                    }

                }
                include 'views/admin/show_order_wait.php';
            }

        } else {
            include 'views/admin/show_order_wait.php';
        }

    }

    private static function show_order_wait_investor()
    {

        //mo to end point
    }

    private static function show_order_wait_ok_investor()
    {
        //move to my account

    }

    private static function show_order_wait_dokandar()
    {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "ok") {

                $id_investor = get_current_user_id();
                global $wpdb;

                $wpdb->update($wpdb->prefix . "order_details",
                    [
                        'id_investor' => $id_investor
                    ], ['id_order' => $_GET['order']]);

                $order = wc_get_order($_GET['order']);

                if ($order) {
                    $order->update_status('processing', '', true);
                }


                /******************************************************/


                $wait_order = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_order= {$_GET['order']}");

                foreach ($wait_order as $order) {
                    /** add installment */
                    $a = new \WPSH_Datebar();
                    $m = $a->wp_shamsi(null, 'n', time());
                    $y = $a->wp_shamsi(null, 'Y', time());
                    $m++;
                    $num = $order->num_month;
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
                include 'views/admin/show_order_wait_dokandar.php';

            } elseif ($_GET['action'] == "cancel") {

                $order = wc_get_order($_GET['order']);

                if ($order) {
                    $order->update_status('shipping-investor', '', true);
                }

                /** send sms for all investor */

                $args = array(
                    'role' => 'investor',
                    'orderby' => 'user_nicename',
                    'order' => 'ASC'
                );
                $users = get_users($args);


                foreach ($users as $user) {


                    $url = 'http://www.0098sms.com/sendsmslink.aspx';
                    $data = array(
                        'FROM' => '30005367',
                        'TO' => $user->mobile,
                        'TEXT' => 'با سلام ' . $user->display_name . ' یک سفارش برای سرمایه گذاری در پنل شما قرار گرفت. ',
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


                include 'views/admin/show_order_wait_dokandar.php';
            }

        } else {
            include 'views/admin/show_order_wait_dokandar.php';

        }


    }

    private static function show_order_ok_dokandar()
    {
        if (isset($_POST['export_excel'])) {
            global $wpdb;

            include URI_THEME . "/app/jdf.php";
            $id_user = get_current_user_id();
            $statement = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_investor={$id_user}");

            $arr_final = [];

            $arr_final[] = array(
                'شناسه محصول',
                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد',
                'وضعیت',
                'قیمت اولیه محصول تکی',
                'مبلغ قسطی تک محصول',
                'درصد سود ماهیانه',
                'تعداد ماه',
                'مبلغ پیش پرداخت هر محصول',
                'زمان خرید'
            );


            foreach ($statement as $s) {
                $p = wc_get_product($s->id_product);
//                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
//                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "تکمیل نشده" : "تکمیل شده";
                $order=wc_get_order($s->id_order);
                $date_order= jdate("Y-n-j H:i:s", strtotime($order->get_date_created()));
                //$wpdb->get_results("select * from {$wpdb->prefix}installments where id_investor={$id_user} and  id_details={$s->id} and status=1 ");
                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));
                $arr_final[] = array(
                    $s->id_product,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $s->qty,
                    $status,
                    number_format($p->get_price()),
                    number_format($s->price_installment),
                    $s->darsa_profit,
                    $s->num_month,
                    number_format($s->price_pish),
                    $date_order,




                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }

        include "views/admin/show_order_ok_dokandar.php";


    }

    private static function show_personnel_manager()
    {
        /** handel action personnel **/

        if (isset($_GET['action'])) {

            if ($_GET['action'] == "add") {
                if (isset($_POST['register_personnel'])) {

                    wp_insert_user(
                        [
                            //code melli
                            'user_pass' => $_POST['code_melli'],
                            'user_login' => $_POST['code_melli'],
                            'user_nicename' => $_POST['name'],
                            'first_name' => $_POST['name'],
                            'last_name' => $_POST['family'],
                            'role' => 'personnel'

                        ]
                    );

                    /** @var  $id_organ  get id oran for this manager */


                    $args = array(
                        'meta_key' => 'id_manager_organization',
                        'meta_value' => get_current_user_id(),
                        'post_type' => 'organization',
                        'post_status' => 'any',
                        'posts_per_page' => -1
                    );
                    $query = new \WP_Query($args);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            $id_organ = get_the_ID();
                        }
                    }
                    wp_reset_query();


                    $user = get_user_by('login', $_POST['code_melli']);
                    $obstruction = isset($_POST['obstruction']) ? 1 : 0;
                    update_user_meta($user->ID, 'code_personnel', $_POST['code_personnel']);
                    update_user_meta($user->ID, 'mobile', $_POST['mobile']);
                    update_user_meta($user->ID, 'organ', $id_organ);
                    update_user_meta($user->ID, 'credit_password', $_POST['credit_password']);
                    update_user_meta($user->ID, 'obstruction', $obstruction);
                    update_user_meta($user->ID, 'obstruction_description', $_POST['obstruction_description']);
                    update_user_meta($user->ID, 'obstruction_number', $_POST['obstruction_number']);
                    update_user_meta($user->ID, 'name_bank', $_POST['name_bank']);
                    update_user_meta($user->ID, 'account_number', $_POST['account_number']);
                    update_user_meta($user->ID, 'cart_number', $_POST['cart_number']);
                    update_user_meta($user->ID, 'sheba_number', $_POST['sheba_number']);
                    update_user_meta($user->ID, 'branch_bank_name', $_POST['branch_bank_name']);
                    update_user_meta($user->ID, 'position_job', $_POST['position_job']);
                    update_user_meta($user->ID, 'organ_unit', $_POST['organ_unit']);
                    update_user_meta($user->ID, 'max_in_month', $_POST['max_month']);
                    //  update_user_meta($user->ID, '_current_woo_wallet_balance', $_POST['wallet']);
                    $wallet = new \Woo_Wallet_Wallet();

                    $wallet->credit($user->ID, $_POST['wallet'], 'اعتبار اولیه');
                }


                include "views/admin/add_personnel_admin_manager.php";
            }


            if ($_GET['action'] == "edit") {
                if (isset($_POST['edit_personnel'])) {

                    $user = get_user_by('login', $_POST['code_melli']);
                    $obstruction = isset($_POST['obstruction']) ? 1 : 0;
                    update_user_meta($user->ID, 'first_name', $_POST['name']);
                    update_user_meta($user->ID, 'last_name', $_POST['family']);
                    update_user_meta($user->ID, 'code_personnel', $_POST['code_personnel']);
                    update_user_meta($user->ID, 'mobile', $_POST['mobile']);
                    update_user_meta($user->ID, 'credit_password', $_POST['credit_password']);
                    update_user_meta($user->ID, 'obstruction', $obstruction);
                    update_user_meta($user->ID, 'obstruction_description', $_POST['obstruction_description']);
                    update_user_meta($user->ID, 'obstruction_number', $_POST['obstruction_number']);
                    update_user_meta($user->ID, 'name_bank', $_POST['name_bank']);
                    update_user_meta($user->ID, 'account_number', $_POST['account_number']);
                    update_user_meta($user->ID, 'cart_number', $_POST['cart_number']);
                    update_user_meta($user->ID, 'sheba_number', $_POST['sheba_number']);
                    update_user_meta($user->ID, 'branch_bank_name', $_POST['branch_bank_name']);
                    update_user_meta($user->ID, 'position_job', $_POST['position_job']);
                    update_user_meta($user->ID, 'organ_unit', $_POST['organ_unit']);
                    update_user_meta($user->ID, 'max_in_month', $_POST['max_month']);

                    if ($_POST['add_wallet']) {
                        $wallet = new \Woo_Wallet_Wallet();
                        $wallet->credit($user->ID, $_POST['add_wallet'], $_POST['add_wallet_description']);
                    }
                    if ($_POST['sub_wallet']) {
                        $wallet = new \Woo_Wallet_Wallet();
                        $wallet->debit($user->ID, $_POST['sub_wallet'], $_POST['sub_wallet_description']);
                    }


//                    update_user_meta($user->ID, '_current_woo_wallet_balance', $_POST['wallet']);


                }

                $user = get_user_by('id', $_GET['item']);

                $user_meta = get_user_meta($_GET['item']);


                include "views/admin/edit_personnel_manager.php";
            }
            if ($_GET['action'] == "delete") {
                wp_delete_user($_GET['item']);
                include "views/menu/show_personnal_manager.php";
            }

        } else {
            include "views/menu/show_personnal_manager.php";
        }
    }

    private static function show__all_oreder_pesonnell_for_manger()
    {
        include "views/admin/all_order_prsonnel_manger.php";
    }

    /**
     *
     * method show all installment personnel
     *
     */

    private static function show_all_installment()
    {
        if (isset($_POST['export_excel'])) {
            global $wpdb;

            include URI_THEME . "/app/jdf.php";

            $statement = $wpdb->get_results("select * from {$wpdb->prefix}installments");

            $arr_final = [];

            $arr_final[] = array(
                'شماره قسط',

                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد',
                'مبلغ کل خرید قسطی',
                'مبلغ قسط',
                'تعداد کل قسط',
                'تعداد پرداخت شده',
                'وضعیت',
                'تاریخ سررسید',
                'تاریخ پرداخت');;

            foreach ($statement as $s) {
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "پرداخت نشده" : "پرداخت شده";
                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));
                $arr_final[] = array(
                    $s->id,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $order_detail->qty,
                    number_format($s->total_price_installment) . 'تومان',
                    number_format($s->price_one_installment) . 'تومان',
                    $s->num_installment,
                    $aa->count_pay,
                    $status,
                    $s->day,
                    $date
                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }
        if (isset($_POST['btn_pay'])) {
            global $wpdb;
            $wpdb->update("{$wpdb->prefix}installments",
                [
                    'description_pay' => $_POST['description_pay'],
                    'number_doc' => $_POST['number_doc_pay'],
                    'day_pay' => date("Y-m-d H:i:s"),
                    'status' => 1
                ],
                [
                    'id' => $_POST['id']
                ]);
            /** send sms for pay  */
            $user = $wpdb->get_row("select id_user from {$wpdb->prefix}installments where id={$_POST['id']}");

            $mobile = get_user_by('id', $user->id_user)->mobile;
            $name = get_user_by('id', $user->id_user)->display_name;

            $url = 'http://www.0098sms.com/sendsmslink.aspx';
            $data = array(
                'FROM' => '30005367',
                'TO' => $mobile,
                'TEXT' => 'با سلام ' . $name . ' قسط شماره ' . $_POST['id'] . 'پرداخت شد',
                'USERNAME' => 'smsr8636',
                'PASSWORD' => '88656645',
                'DOMAIN' => '0098',
            );

// use key 'http' even if you send the request to https://...
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
            header('Location: /wp-admin/admin.php?page=all_installment');
//            var_dump($result);

        }

        if (isset($_GET['action'])) {
            if ($_GET['action'] == "print") {
                include "views/admin/show_payed_print.php";
                exit();
            }
            if ($_GET['action'] == "pay") {
                include "views/admin/pay_installment_admin.php";
            } else {
                include "views/admin/all_installment_admin.php";
            }
        } else {
            include "views/admin/all_installment_admin.php";
        }

    }

    private static function show_installment_this_month()
    {
        if (isset($_POST['export_excel'])) {


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

            $all_installment = $wpdb->get_results("select * from {$wpdb->prefix}installments");
            $month_now = convert(jdate("n"));
            $year_now = convert(jdate("Y"));

            $arr_installment_this_month = [];
            foreach ($all_installment as $item):
                $day = $item->day;
                $arr_day = explode("/", $day);

                if (intval($arr_day[1]) == intval($month_now) && intval($arr_day[0]) == intval($year_now)) {

                    array_push($arr_installment_this_month, $item);

                }
            endforeach;


            $arr_final = [];

            $arr_final[] = array(
                'شماره قسط',

                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد',
                'مبلغ کل خرید قسطی',
                'مبلغ قسط',
                'تعداد کل قسط',
                'تعداد پرداخت شده',
                'وضعیت',
                'تاریخ سررسید',
                'تاریخ پرداخت');;

            foreach ($arr_installment_this_month as $s) {
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "پرداخت نشده" : "پرداخت شده";
                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));
                $arr_final[] = array(
                    $s->id,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $order_detail->qty,
                    number_format($s->total_price_installment) . 'تومان',
                    number_format($s->price_one_installment) . 'تومان',
                    $s->num_installment,
                    $aa->count_pay,
                    $status,
                    $s->day,
                    $date
                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }
        if (isset($_POST['btn_pay'])) {
            global $wpdb;
            $wpdb->update("{$wpdb->prefix}installments",
                [
                    'description_pay' => $_POST['description_pay'],
                    'number_doc' => $_POST['number_doc_pay'],
                    'day_pay' => date("Y-m-d H:i:s"),
                    'status' => 1
                ],
                [
                    'id' => $_POST['id']
                ]);
        }
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "print") {
                include "views/admin/show_payed_print.php";
                exit();
            }
            if ($_GET['action'] == "pay") {
                include "views/admin/pay_installment_admin.php";
            } else {
                include "views/admin/show_installment_this_month.php";
            }
        } else {
            include "views/admin/show_installment_this_month.php";
        }


    }

    private static function show_installment_payed()
    {

        if (isset($_POST['export_excel'])) {
            global $wpdb;

            include URI_THEME . "/app/jdf.php";

            $statement = $wpdb->get_results("select * from {$wpdb->prefix}installments where status=1");

            $arr_final = [];

            $arr_final[] = array(
                'شماره قسط',

                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد',
                'مبلغ کل خرید قسطی',
                'مبلغ قسط',
                'تعداد کل قسط',
                'تعداد پرداخت شده',
                'وضعیت',
                'تاریخ سررسید',
                'تاریخ پرداخت');;

            foreach ($statement as $s) {
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "پرداخت نشده" : "پرداخت شده";
                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));
                $arr_final[] = array(
                    $s->id,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $order_detail->qty,
                    number_format($s->total_price_installment) . 'تومان',
                    number_format($s->price_one_installment) . 'تومان',
                    $s->num_installment,
                    $aa->count_pay,
                    $status,
                    $s->day,
                    $date
                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }

        if (isset($_GET['action'])) {
            if ($_GET['action'] == "print") {
                include "views/admin/show_payed_print.php";
                exit();
            }
            if ($_GET['action'] == "pay") {
                include "views/admin/pay_installment_admin.php";
            } else {
                include "views/admin/show_installment_payed.php";
            }
        } else {
            include "views/admin/show_installment_payed.php";
        }

    }

    private static function show_installment_not_payed()
    {
        if (isset($_POST['export_excel'])) {
            global $wpdb;

            include URI_THEME . "/app/jdf.php";

            $statement = $wpdb->get_results("select * from {$wpdb->prefix}installments where status=0");

            $arr_final = [];

            $arr_final[] = array(
                'شماره قسط',

                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد',
                'مبلغ کل خرید قسطی',
                'مبلغ قسط',
                'تعداد کل قسط',
                'تعداد پرداخت شده',
                'وضعیت',
                'تاریخ سررسید',
                'تاریخ پرداخت');;

            foreach ($statement as $s) {
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "پرداخت نشده" : "پرداخت شده";
                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));
                $arr_final[] = array(
                    $s->id,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $order_detail->qty,
                    number_format($s->total_price_installment) . 'تومان',
                    number_format($s->price_one_installment) . 'تومان',
                    $s->num_installment,
                    $aa->count_pay,
                    $status,
                    $s->day,
                    $date
                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }
        if (isset($_POST['btn_pay'])) {
            global $wpdb;
            $wpdb->update("{$wpdb->prefix}installments",
                [
                    'description_pay' => $_POST['description_pay'],
                    'number_doc' => $_POST['number_doc_pay'],
                    'day_pay' => date("Y-m-d H:i:s"),
                    'status' => 1
                ],
                [
                    'id' => $_POST['id']

                ]);
        }
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "pay") {
                include "views/admin/pay_installment_admin.php";
            } else {
                include "views/admin/show_installment_not_payed.php";
            }
        } else {
            include "views/admin/show_installment_not_payed.php";
        }
    }

    private static function manage_order_installment_admin()
    {

        if (isset($_POST['export_excel'])) {
            global $wpdb;

            include URI_THEME . "/app/jdf.php";

            $statement = $wpdb->get_results("select * from {$wpdb->prefix}order_details");

            $arr_final = [];

            $arr_final[] = array(
                'شماره',
                'شناسه خرید',
                'نام خریدار',
                'کد ملی',
                'موبایل',
                'نام سازمان',
                'نام محصول',
                'تعداد محصول',
                'درصد سودماهانه',
                'مبلغ پیش پرداخت',
                'نام سرمایه گذار',
                'مبلغ کل خرید قسطی',
                'تعداد کل قسط',
                'تعداد پرداخت شده',
                'وضعیت',
                'تاریخ سر رسید',
                'زمان خرید',
                'وضعیت سفارش');

            foreach ($statement as $s) {
                $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$s->id_details} and status=1 ");
                $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$s->id_details}");
                $status = $s->status == 0 ? "تکمیل نشده" : "تکمیل شده";


                if (!is_null($s->day_pay)) $date = jdate("Y-n-j H:i:s", strtotime($s->day_pay));

                $get_user = get_user_meta($s->id_investor);

                if (isset($get_user['dokan_store_name'][0])) {

                    $store_name = $get_user['dokan_store_name'][0];


                } else {
                    $store_name = $s->id_investor != 0 ? get_user_by('id', $s->id_investor)->display_name : "ندارد";
                }


                $order = wc_get_order($s->id_order);
                $date_order = jdate("Y/n/d", strtotime($order->get_date_created()));
                $order_status = $order->get_status();
                $arr_final[] = array(
                    $s->id,
                    $s->id_order,
                    get_user_by('id', $s->id_user)->display_name,
                    get_user_by('id', $s->id_user)->user_login,
                    get_user_by('id', $s->id_user)->mobile,
                    get_the_title(get_user_by('id', $s->id_user)->organ),
                    get_the_title($s->id_product),
                    $s->qty,
                    $s->darsa_profit,
                    number_format($s->price_pish) . 'تومان',
                    $store_name,
                    $s->price_installment,
                    $s->num_month,
                    $aa->count_pay,
                    $status,
                    $s->day_due,
                    $date_order,
                    $order_status


                );
            }


            include_once('xlsxwriter.class.php');


            // # set the destination file
            $fileLocation = date("Y-m-d H:i:s") . '.xlsx';

            // # prepare the data set
            $data = $arr_final;

            // # call the class and generate the excel file from the $data
            $writer = new XLSXWriter();
            $writer->writeSheet($data);
            $writer->writeToFile($fileLocation);


            // # prompt download popup
            header('Content-Description: File Transfer');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . basename($fileLocation));
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: ' . filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }


        include "views/admin/show_list_order_installment_admin.php";

    }

    private static function manage_request_product()
    {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "ok") {
                global $wpdb;
                $wpdb->update($wpdb->prefix . 'request_product',
                    ['status' => 1],
                    ['id' => $_GET['item']]);

            } elseif ($_GET['action'] == "cancel") {

                global $wpdb;
                $wpdb->update($wpdb->prefix . 'request_product',
                    ['status' => 2],
                    ['id' => $_GET['item']]);


            } else {
                include "views/admin/show_list_product_request.php";
            }
            include "views/admin/show_list_product_request.php";
        } else {
            include "views/admin/show_list_product_request.php";
        }


    }


    private static function installment_pay_by_excel()
    {


        if (isset($_POST['btn_pay_excel'])) {
            if (isset($_POST['excel_pay'])) {


                require_once "SimpleXLSX.php";

                $data = "";

                $str = str_replace(get_site_url(), "", $_POST['excel_pay']);
                if ($xlsx = \SimpleXLSX::parse(get_home_path() . $str)) {

                    //   update_user_meta(1, "test", print_r($xlsx, true));


                    foreach ($xlsx->rows() as $r => $row) {

                        foreach ($row as $c => $cell) {

                            if ($r != 0) {

                                $data .= $cell . '#';
                            }
                        }
                    }

                    $persons = (explode("#", $data));
                    $list_installments = array_chunk($persons, 5);
                    $arr_message_error = [];

                    global $wpdb;

                    $count_ok = 0;


                    foreach ($list_installments as $installment1) {

                        if ($installment1[0] != "") {

                            $status = $wpdb->update($wpdb->prefix . "installments",
                                [
                                    "day_pay" => date("Y-m-d H:i:s"),
                                    "description_pay" => $installment1[3],
                                    "number_doc" => $installment1[4],
                                    "status" => 1
                                ],
                                [
                                    "id" => $installment1[0],
                                    "id_order" => $installment1[1],
                                    "price_one_installment" => $installment1[2]
                                ]);
                            if (!$status) {
                                echo '<div class="error"><p>قسط با شماره  ' . $installment1[0] . 'پرداخت نشد  </p></div>';
                            } else {
                                $count_ok++;

                            }


                        }

                    }
                    echo '<div class="notice notice-success is-dismissible"><p>تعداد ' . $count_ok . 'قسط پرداخت شد</p></div>';


                } else {
                    echo \SimpleXLSX::parseError();

                }
            }

        }
        include "views/admin/pay_installment_by_excel.php";
    }

    private static function manage_slider_admin()
    {
        include "views/admin/manage_slider.php";
    }


}