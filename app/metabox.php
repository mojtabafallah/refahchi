<?php

namespace app;

class metabox
{

//slider and banner
    public static function add_slider($post, $post_type)
    {


        add_meta_box(
            'post_of_slider',

            'اسلایدر و بنر',
            function ($post, $post_type) {


                view::render('metabox/slider', $post);
            }
            ,

            array('post', 'product','page'),
            'side'
        );


    }


    public static function save_slider_banner($post_id)
    {

        if (!empty($_POST['image_slider'])) {
            update_post_meta($post_id, 'image_slider_banner', $_POST['image_slider']);
            if (isset($_POST['slider_check'])) {
                update_post_meta($post_id, 'enable_slider', $_POST['slider_check']);
            } else {
                update_post_meta($post_id, 'enable_slider', 'off');
            }
            if (isset($_POST['banner_check'])) {
                update_post_meta($post_id, 'enable_banner', $_POST['banner_check']);
            } else {
                update_post_meta($post_id, 'enable_banner', 'off');
            }
            if (isset($_POST['position_banner'])) {
                update_post_meta($post_id, 'position_banner', $_POST['position_banner']);
            }
        } else {

            //add_action('admin_notices', array('app\message', 'add_slider'));
        }


    }


    /** installment */

    public static function add_installment($post, $post_type)
    {
        add_meta_box(
            'price_installment',

            'قیمت قسطی',
            function ($post, $post_type) {


                view::render('metabox/installment', $post);
            }
            ,
            'product',
            'advanced'
        );
    }

    public static function save_data_installment($post_id)
    {

        global $wpdb;

        $all_plan_for_update_meta = $wpdb->get_results("select * from {$wpdb->prefix}plans ");
        $plans_arr = array();


        foreach ($all_plan_for_update_meta as $plan_for_update) {
            if (isset($_POST['plan_selected-' . $plan_for_update->id])) {

               // $price_arr[] = $_POST['price_installment-' . $plan_for_update->id];


                $plans_arr[] = $_POST['plan_selected-' . $plan_for_update->id];


            }
          //  $complete_arr = array_combine($plans_arr, $price_arr);
            update_post_meta($post_id, 'plans', $plans_arr);
        }




    }


//person

    public static function add_person($post, $post_type)
    {
        add_meta_box(
            'person_import',

            'وارد کردن پرسنل',
            function ($post, $post_type) {

                view::render_person('metabox/person', $post);
            }
            ,
            'organization',
            'advanced'
        );
    }


//    public static function save_person($post_id)
//    {
//
//        wp_insert_user(
//            [
//                //code melli
//                'user_pass' => "147",
//                'user_login' => "147",
//                'user_nicename' =>"147",
//                'first_name' => "159",
//                'last_name' => "215",
//                'role' => 'personnel'
//            ]
//        );
//
//        if (isset($_POST['excel_person'])) {
//            $data = "";
//            $xslx =  SimpleXLSX::parseData(file_get_contents("https://github.com/shuchkin/simplexlsx/blob/master/examples/books.xlsx"));
//            if ($xslx) {
//
//                foreach ($xslx->rows() as $r => $row) {
//                    foreach ($row as $c => $cell) {
//                        if ($r != 0) $data .= $cell . '#';
//                    }
//                }
//                $persons = (explode("#", $data));
//                $all_personnel = array_chunk($persons, 15);
//                foreach ($all_personnel as $person) {
//                    wp_insert_user(
//                        [
//                            //code melli
//                            'user_pass' => $person[0],
//                            'user_login' => $person[0],
//                            'user_nicename' => $person[1],
//                            'first_name' => $person[2],
//                            'last_name' => $person[3],
//                            'role' => 'personnel'
//                        ]
//                    );
//
//                    $user = get_user_by('login', $person[0]);
//
//                    update_user_meta($user->ID, 'code_personnel', $person[1]);
//                    update_user_meta($user->ID, 'mobile', $person[4]);
//                    update_user_meta($user->ID, 'organ', $post_id);
//                    update_user_meta($user->ID, 'credit_password', rand(100000, 999999));
//                    update_user_meta($user->ID, 'obstruction', $person[5]);
//                    update_user_meta($user->ID, 'obstruction_description', $person[6]);
//                    update_user_meta($user->ID, 'obstruction_number', $person[7]);
//                    update_user_meta($user->ID, 'name_bank', $person[8]);
//                    update_user_meta($user->ID, 'account_number', $person[9]);
//                    update_user_meta($user->ID, 'cart_number', $person[10]);
//                    update_user_meta($user->ID, 'sheba_number', $person[11]);
//                    update_user_meta($user->ID, 'branch_bank_name', $person[12]);
//                    update_user_meta($user->ID, 'position_job', $person[13]);
//                    update_user_meta($user->ID, 'organ_unit', $person[14]);
//
////                    $wallet=new \Woo_Wallet_Wallet();
////                    $wallet->credit($user->ID,$person[15],"اعتبار اولیه");
//                }
//                update_post_meta($post_id, 'import_person', 1);
//            } else {
//                update_post_meta($post_id, 'import_person', SimpleXLSX::parseError());
//            }
//
//        }
//    }


//manager organization
    public static function add_metabox_manager_organization($post, $post_type)
    {
        add_meta_box('menager_organization', 'تعیین مدیر سازمان', function ($post, $post_type) {
            include "views/metabox/set_manager_organization.php";
        }, 'organization');
    }

    public static function save_post_manager($post_id)
    {

        if (!empty($_POST['all_role_manager_organ'])) {

            update_post_meta($post_id, 'id_manager_organization', $_POST['all_role_manager_organ']);
        }


    }


}