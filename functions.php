<?php

use app\metabox;


include "constant.php";
include 'vendor/autoload.php';

include "app/validation.php";

add_action('after_setup_theme', 'shop_setup');
function shop_setup()
{
    add_theme_support('title-tag');
    add_theme_support('woocommerce');
    add_role('personnel', 'پرسنل');
    add_role('manager_organization', 'مدیر سازمان');
    add_role('investor', 'سرمایه گذار');
}

$role_object = get_role('manager_organization');

//// add $cap capability to this role object
//$role_object->remove_cap( 'manager_organ' );
//$role_object->remove_cap( 'read' );
//$role_object->remove_cap( 'publish_posts' );
//$role_object->remove_cap( 'edit_posts' );

$role_object->add_cap('manager_organ', true);
$role_object->add_cap('read', true);
$role_object->add_cap('publish_posts', true);
$role_object->add_cap('edit_posts', true);


/** add role investor */
$role_object1 = get_role('investor');


//$role_object1->remove_cap( 'investor' );
//$role_object1->remove_cap( 'read' );
//$role_object1->remove_cap( 'publish_posts' );
//$role_object1->remove_cap( 'edit_posts' );

//$role_object1->add_cap('investor', true);
//$role_object1->add_cap('read', true);
//$role_object1->add_cap( 'publish_posts',true );
//$role_object1->add_cap('edit_posts', true);


//$role_object->add_cap( 'delete_published_posts',true );
//$role_object->add_cap( 'manage_categories',true );
//$role_object->add_cap( 'manage_product_terms',true );


//// remove $cap capability from this role object
//$role_object->remove_cap( $capability_name );


//add_role('manager_organization', 'مدیر سازمان',[
//    'read'                      => true,
//    'publish_posts'             => true,
//    'edit_posts'                => true,
//    'delete_published_posts'    => true,
//    'edit_published_posts'      => true,
//    'delete_posts'              => true,
//    'manage_categories'         => true,
//    'moderate_comments'         => true,
//    'unfiltered_html'           => true,
//    'upload_files'              => true,
//    'edit_shop_orders'          => true,
//    'edit_product'              => true,
//    'read_product'              => true,
//    'delete_product'            => true,
//    'edit_products'             => true,
//    'publish_products'          => true,
//    'read_private_products'     => true,
//    'delete_products'           => true,
//    'delete_private_products'   => true,
//    'delete_published_products' => true,
//    'edit_private_products'     => true,
//    'edit_published_products'   => true,
//    'manage_product_terms'      => true,
//    'delete_product_terms'      => true,
//    'assign_product_terms'      => true,
//
//]);


/** add meta box slider and banner */
add_action('add_meta_boxes', array('app\metabox', 'add_slider'), 10, 10);
add_action('save_post', array('app\metabox', 'save_slider_banner'), 10);


/** add meta box installment */
add_action('add_meta_boxes', array('app\metabox', 'add_installment'), 10, 10);
add_action('save_post_product', 'app\metabox::save_data_installment');

/** installment group */
add_action('save_post_product', function ($post_id) {
    $arr_plan = [];
//    $taxonomy = get_term($post_id, "product_cat");
    $taxonomy = wp_get_post_terms($post_id,
        "g_installment"
    );
    foreach ($taxonomy as $tax) {
        $plans = get_option("taxonomy_$tax->term_id");
        $plans = unserialize($plans);


        foreach ($plans as $plan) {
            $arr_plan[] = $plan;

        }

    }
    update_post_meta($post_id, 'plans_general', $arr_plan);

});

/** all menu admin */
add_action('admin_menu', array(\app\menu::class, 'add_all_menu_admin'));


//register organ
add_action('init', array(\app\postType::class, 'organ_init'));
register_taxonomy("cate_organ",
    array("organization"),
    array("hierarchical" => true, "label" => "دسته بندی سازمان ها", "singular_label" => "دسته بندی", "rewrite" =>
        array('slug' => 'cate-organization', 'with_front' => false)));

//add meta box import personnel from excel
add_action('add_meta_boxes', array('app\metabox', 'add_person'), 10, 10);


/**save data personnel**/
//add_action('save_post_organization', array('app\metabox', 'save_person'), 10);
add_action('save_post_organization', function ($post_id) {
    $error_query = 0;
    if (isset($_POST['excel_person'])) {
        $data = "";
        require_once "app/SimpleXLSX.php";
        $str = str_replace(get_site_url(), "", $_POST['excel_person']);
        if ($xlsx = SimpleXLSX::parse(get_home_path() . $str)) {

            //   update_user_meta(1, "test", print_r($xlsx, true));


            foreach ($xlsx->rows() as $r => $row) {

                foreach ($row as $c => $cell) {

                    if ($r != 0) {

                        $data .= $cell . '#';
                    }
                }
            }

            $persons = (explode("#", $data));
            $all_personnel = array_chunk($persons, 17);
            $arr_message_error = [];

            foreach ($all_personnel as $person) {
                if (
                    check_national_code($person[0])
                    &&
                    ctype_digit($person[1]) &&
                    check_farsi($person[2]) &&
                    check_farsi($person[3]) &&
                    check_mobile($person[4]) &&
                    ctype_digit($person[9]) &&
                    bankCardCheck($person[10]) &&
                    check_sheba($person[11]) &&
                    check_farsi($person[12]) &&
                    check_farsi($person[13]) &&
                    check_farsi($person[14]) &&
                    is_numeric($person[15]) &&
                    is_numeric($person[16])
                ) {
                    wp_insert_user(
                        [
                            //code melli


                            'user_pass' => $person[0],
                            'user_login' => $person[0],

                            'user_nicename' => $person[1],
                            'first_name' => $person[2],
                            'last_name' => $person[3],
                            'role' => 'personnel'
                        ]
                    );

                    $user = get_user_by('login', $person[0]);

                    update_user_meta($user->ID, 'code_personnel', $person[1]);
                    update_user_meta($user->ID, 'mobile', $person[4]);
                    update_user_meta($user->ID, 'organ', $post_id);
                    update_user_meta($user->ID, 'credit_password', rand(100000, 999999));
                    update_user_meta($user->ID, 'obstruction', $person[5]);
                    update_user_meta($user->ID, 'obstruction_description', $person[6]);
                    update_user_meta($user->ID, 'obstruction_number', $person[7]);
                    update_user_meta($user->ID, 'name_bank', $person[8]);
                    update_user_meta($user->ID, 'account_number', $person[9]);
                    update_user_meta($user->ID, 'cart_number', $person[10]);
                    update_user_meta($user->ID, 'sheba_number', $person[11]);
                    update_user_meta($user->ID, 'branch_bank_name', $person[12]);
                    update_user_meta($user->ID, 'position_job', $person[13]);
                    update_user_meta($user->ID, 'organ_unit', $person[14]);
                    update_user_meta($user->ID, 'max_in_month', $person[16]);

                    $wallet = new \Woo_Wallet_Wallet();
                    $wallet->credit($user->ID, $person[15], "اعتبار اولیه");
                } else {
                    $error_query = 1;
                    if (!check_national_code($person[0]) && $person[0] != null) {
                        array_push($arr_message_error, ' مقدار یا فرمت ' . $person[0] . "  اشتباه است برای فیلد کد ملی");

                    }

                    if (!is_null($person[1]) && !ctype_digit($person[1])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[1] . "  اشتباه است برای فیلد کد پرسنلی ");
                    if (!is_null($person[2]) && !check_farsi($person[2])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[2] . "  اشتباه است برای فیلد نام ");
                    if (!is_null($person[3]) && !check_farsi($person[3])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[3] . "  اشتباه است برای فیلد نام خانوادگی ");
                    if (!is_null($person[4]) && !check_mobile($person[4])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[4] . "  اشتباه است برای فیلد تلفن همراه ");
                    if (!is_null($person[9]) && !ctype_digit($person[9])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[9] . "  اشتباه است برای فیلد شماره حساب ");
                    if (!is_null($person[10]) && !bankCardCheck($person[10])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[10] . "  اشتباه است برای فیلد شماره کارت ");
                    if (!is_null($person[11]) && !check_sheba($person[11])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[11] . "  اشتباه است برای فیلد شماره شبا ");
                    if (!is_null($person[12]) && !check_farsi($person[12])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[12] . "  اشتباه است برای فیلد نام شعبه ");

                    if (!is_null($person[15]) && !is_numeric($person[15])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[15] . "  اشتباه است برای فیلد اعتبار اولیه ");
                    if (!is_null($person[16]) && !is_numeric($person[16])) array_push($arr_message_error, ' مقدار یا فرمت ' . $person[16] . "  اشتباه است برای فیلد سقف ماهیانه ");


                }

            }


            update_post_meta($post_id, 'errors', serialize($arr_message_error));


        } else {
            update_post_meta($post_id, "errorxls", SimpleXLSX::parseError());
            update_post_meta($post_id, "errorxls", SimpleXLSX::parseError());
        }
    } else {

        update_post_meta($post_id, "errorxls", SimpleXLSX::parseError());

    }


}, 10);


// display all notices after saving post
add_action('admin_notices', 'show_admin_notices', 0);

// your custom save_post aciton
add_action('save_post_organization', 'custom_save_post', 20);

function custom_save_post($post_id)
{
    $errors = get_post_meta($post_id, "errors", true);
    $errors = unserialize($errors);

    foreach ($errors as $error) {
        store_error_in_notices_option($error);
    }

    delete_post_meta($post_id, "errors");

}

function store_error_in_notices_option($m)
{
    if (!empty($m)) {
        // store error notice in option array
        $notices = get_option('my_error_notices');
        $notices[] = $m;
        update_option('my_error_notices', $notices);
    }
}

function show_admin_notices()
{
    $notices = get_option('my_error_notices');
    if (empty($notices)) {
        return;
    }
    // print all messages
    foreach ($notices as $key => $m) {
        echo '<div class="error"><p>' . $m . '</p></div>';
    }

    delete_option('my_error_notices');
}


//add meta box manger organ
add_action('add_meta_boxes', 'app\metabox::add_metabox_manager_organization', 10, 10);
add_action('save_post_organization', array('app\metabox', 'save_post_manager'), 10);

/** add tax brand */

function add_brand_tax()
{
    register_taxonomy(
        'brand',
        'product',
        array(
            'hierarchical' => true,
            'label' => 'برند',
            'query_var' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'attraction')
        )
    );
}

add_action('init', 'add_brand_tax');


/** add tax group installment */

function add_group_installment()
{

    register_taxonomy(
        'g_installment',
        'product',
        array(
            'hierarchical' => true,
            'label' => 'گروه بندی قسطی',
            'query_var' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'attraction')
        )
    );
}

add_action('init', 'add_group_installment');

// add meta field
function mj_taxonomy_add_custom_meta_field()
{

    global $wpdb;
    $plan_general = $wpdb->get_results("select * from {$wpdb->prefix}plans where id_vendor=0");
    echo ' <label > برای این گروه پلن انتخاب کنید</label>';
    foreach ($plan_general as $plan):

        ?>
        <div class="form-field">
            <label for="plan-<?php echo $plan->id ?>"> <?php echo ' پیش پرداخت ' . $plan->pishe_darsad . "% | " . " تعداد قسط " . $plan->num_month . " | " . " درصد سود هر ماه " . $plan->darsad_profit . "%" ?> </label>
            <input type="checkbox" name="plans[]" id="plan-<?php echo $plan->id ?>" value="<?php echo $plan->id ?>">


        </div>

    <?php
    endforeach;

}

add_action('g_installment_add_form_fields', 'mj_taxonomy_add_custom_meta_field', 10, 2);


//edit page meta
function mj_taxonomy_edit_custom_meta_field($term)
{

    $t_id = $term->term_id;
    $term_meta = get_option("taxonomy_$t_id");
    $id_plan = unserialize($term_meta);
    global $wpdb;
    $plan_general = $wpdb->get_results("select * from {$wpdb->prefix}plans where id_vendor=0");
    foreach ($plan_general as $plan):

        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
            </th>
            <td>
                <input type="checkbox" name="plans[]" id="plan-<?php echo $plan->id ?>"
                       value="<?php echo $plan->id ?>" <?php echo in_array($plan->id, $id_plan) ? "checked" : "" ?> >
                <p class="description"><?php echo ' پیش پرداخت ' . $plan->pishe_darsad . "% | " . " تعداد قسط " . $plan->num_month . " | " . " درصد سود هر ماه " . $plan->darsad_profit . "%" ?></p>
            </td>
        </tr>
    <?php
    endforeach;

}

add_action('g_installment_edit_form_fields', 'mj_taxonomy_edit_custom_meta_field', 10, 2);


// save meta group installment
function mj_save_taxonomy_custom_meta_field($term_id)
{
    if (isset($_POST['plans'])) {

        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $plan_group = $_POST['plans'];
        $id_plan = [];
        foreach ($plan_group as $item) {
            if (isset ($item)) {
                array_push($id_plan, $item);
            }
        }
        // Save the option array.
        update_option("taxonomy_$t_id", serialize($id_plan));
    } else {
        $t_id = $term_id;
        update_option("taxonomy_$t_id", serialize([]));
    }

}

add_action('edited_g_installment', 'mj_save_taxonomy_custom_meta_field', 10, 2);
add_action('create_g_installment', 'mj_save_taxonomy_custom_meta_field', 10, 2);


/** add custom hook */
show_admin_bar(true);


function custom_pre_get_posts($query)
{
    if ($query->is_main_query() && !$query->is_feed() && !is_admin() && is_category()) {
        $query->set('page_val', get_query_var('paged'));
        $query->set('paged', 0);
    }
}

add_action('pre_get_posts', 'custom_pre_get_posts');


/** add status wait ok organ */
// Register new status
function register_awaiting_shipment_order_status()
{
    register_post_status('wait_ok_organ', array(
        'label' => 'در حال انتظار تایید سازمان',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('در حال انتظار تایید سازمان (%s)', 'در حال انتظار تایید سازمان (%s)')
    ));
}

add_action('init', 'register_awaiting_shipment_order_status');


// Register New Order Statuses
function wpex_wc_register_post_statuses()
{
    register_post_status('wc-shipping-progress', array(
        'label' => 'در انتظار تایید مدیر',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('تایید مدیر (%s)', 'تایید مدیر (%s)', 'text_domain')
    ));
}

add_filter('init', 'wpex_wc_register_post_statuses');

// Add New Order Statuses to WooCommerce
function wpex_wc_add_order_statuses($order_statuses)
{
    $order_statuses['wc-shipping-progress'] = _x('انتظار تایید مدیر', 'WooCommerce Order status', 'text_domain');
    return $order_statuses;
}

add_filter('wc_order_statuses', 'wpex_wc_add_order_statuses');


// Register New Order Statuses
function wpex_wc_register_investor()
{
    register_post_status('wc-shipping-investor', array(
        'label' => 'در انتظار تامین کالا',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('تامین کالا (%s)', 'تامین کالا (%s)', 'text_domain')
    ));
}

add_filter('init', 'wpex_wc_register_investor');

// Add New Order Statuses to WooCommerce
function wpex_wc_add_order_investor($order_statuses)
{
    $order_statuses['wc-shipping-investor'] = _x('انتظار تامین کالا', 'WooCommerce Order status', 'text_domain');
    return $order_statuses;
}

add_filter('wc_order_statuses', 'wpex_wc_add_order_investor');


/** add status return to store */


// Register New Order Statuses
function wpex_wc_register_return_store()
{
    register_post_status('wc-return-store', array(
        'label' => 'کنترل مجدد فروشگاه',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('کنترل مجدد فروشگاه (%s)', 'کنترل مجدد فروشگاه (%s)', 'text_domain')
    ));
}

add_filter('init', 'wpex_wc_register_return_store');

// Add New Order Statuses to WooCommerce
function wpex_wc_add_order_return_store($order_statuses)
{
    $order_statuses['wc-return-store'] = _x('کنترل مجدد فروشگاه', 'WooCommerce Order status', 'text_domain');
    return $order_statuses;
}

add_filter('wc_order_statuses', 'wpex_wc_add_order_return_store');


function action_woocommerce_payment_complete($order_id)
{
    if (!$order_id) return;
    $order = wc_get_order($order_id);
    $order->update_status('wc-shipping-progress');
}

;

add_action('woocommerce_payment_complete', 'action_woocommerce_payment_complete', 10, 3);


include "custom-hook.php";


/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init()
{
    register_sidebar(array(
        'name' => "قسمت اول فوتر",
        'id' => 'footer-1',
        'description' => "مدیریت قسمت اول فوتر",
        'before_widget' => '
<li id="%1$s" class="widget %2$s">',
        'after_widget' => '
</li>',
        'before_title' => '<h3 class="head">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'wpdocs_theme_slug_widgets_init');

/**
 * Add a sidebar.
 */
function init_footer_section2()
{
    register_sidebar(array(
        'name' => "قسمت دوم فوتر",
        'id' => 'footer-2',
        'description' => "مدیریت قسمت دوم فوتر",
        'before_widget' => '
<li id="%1$s" class="widget %2$s">',
        'after_widget' => '
</li>',
        'before_title' => '<h3 class="head">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'init_footer_section2');

/**
 * Add a sidebar.
 */
function init_footer_section_offs()
{
    register_sidebar(array(
        'name' => "قسمت تخفیفات و شبکه های اجتماعی",
        'id' => 'footer-3',
        'description' => "مدیریت قسمت شبکه های اجتماعی و خبرنامه",
        'before_widget' => '
<li id="%1$s" class="widget %2$s">',
        'after_widget' => '
</li>',
        'before_title' => '<h3 class="head">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'init_footer_section_offs');

/**
 * Add a sidebar.
 */
function init_footer_section_cert()
{
    register_sidebar(array(
        'name' => "قسمت مجوزها",
        'id' => 'footer-4',
        'description' => "مدیریت قسمت مجوز ها",
        'before_widget' => '
<li id="%1$s" class="widget %2$s">',
        'after_widget' => '
</li>',
        'before_title' => '<h3 class="head">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'init_footer_section_cert');

include "app/widgets.php";


/** add short codes */
add_action('init', 'do_output_buffer');
function do_output_buffer()
{

    ob_start();
}

add_shortcode('register-form', array('app\shortCode', 'register_form'));

/** add style file */
function add_theme_scripts()
{

    wp_enqueue_style("font-awesome.min", URL_THEME . '/assets/vendor/fontawesome/font-awesome.min.css', false, '1.1', 'all');
    wp_enqueue_style("swiper.min", URL_THEME . '/assets/vendor/swiper/css/swiper.min.css', false, '1.1', 'all');


    wp_enqueue_style("slicknav.min", URL_THEME . '/assets/vendor/slicknav/slicknav.min.css', false, '1.1', 'all');
    wp_enqueue_style("main.min", URL_THEME . '/assets/css/main.css', false, '1.1', 'all');
    wp_enqueue_style("mediaq.min", URL_THEME . '/assets/css/mediaq.css', false, '1.1', 'all');


    wp_enqueue_script("jquery.min", URL_THEME . '/assets/js/jquery.min.js');

    wp_enqueue_script("swiper.min", URL_THEME . '/assets/vendor/swiper/js/swiper.min.js');

    wp_enqueue_script("slicknav.min", URL_THEME . '/assets/vendor/slicknav/jquery.slicknav.min.js');
    wp_enqueue_script("countdown.min", URL_THEME . '/assets/vendor/jquery.countdown.min.js');
    wp_enqueue_script("persianumber.min", URL_THEME . '/assets/vendor/persianumber.min.js');

    wp_enqueue_script("script", URL_THEME . '/assets/js/script.js');


}


add_action('wp_enqueue_scripts', 'add_theme_scripts');


/** add style shipping file */
function add_theme_scripts_shipping()
{
    wp_enqueue_style("font-awesome.min", URL_THEME . '/assets/vendor/fontawesome/font-awesome.min.css', false, '1.1', 'all');
    wp_enqueue_style("font-awesome.min", URL_THEME . '/assets/css/main.css"', false, '1.1', 'all');
    wp_enqueue_style("font-awesome.min", URL_THEME . '/assets/css/mediaq.css', false, '1.1', 'all');


}

add_action('wp_enqueue_scripts', 'add_theme_scripts_shipping');


/** add script to admin */
function my_enqueue($hook)
{

    wp_enqueue_script('my_custom_script', URL_THEME . '/assets/js/script_2.js');

    wp_localize_script("my_custom_script", "my_custom_script_nonce", array(
        "ajaxurl" => admin_url("admin-ajax.php"),
        "sec_nonce" => wp_create_nonce("search_installment")
    ));

}

add_action('admin_enqueue_scripts', 'my_enqueue');


/******/




include "action-admin.php";

