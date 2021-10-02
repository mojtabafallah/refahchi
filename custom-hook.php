<?php
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


add_action('order_customize', 'woocommerce_catalog_ordering', 40);


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('after_header_site', function () {
    echo '<div class="woocommerce-notices-wrapper">';
    wc_print_notices();
    echo '</div>';
}, 15);

add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_title', 4);

add_action('woocommerce_shop_loop_item_title', 'add_div_content', 10);

function add_div_content()
{
    global $product;?>
    <div class="c-product-box__content">
        <a href="<?php echo $product->get_permalink() ?>" class="title"><?php echo $product->get_title(); ?></a>
        <?php if ($product->get_price()): ?>
            <?php if ($product->is_on_sale()): ?>


                <span style="color: red"
                      class="price"> قیمت ویژه <?php echo number_format($product->get_sale_price()) ?> تومان </span>
                <del class="price"> قیمت نقدی <?php echo number_format($product->get_regular_price()) ?>
                    تومان
                </del>

            <?php else: ?>
                <span class="price"> قیمت نقدی <?php echo number_format($product->get_regular_price()) ?>
                                                        تومان
                                                    </span>

            <?php endif; ?>
        <?php else: ?>
            <span class="price">نا موجود</span>
        <?php endif; ?>
    </div>
    <?php

}


remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

//remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',10);


remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

add_action('custom_single_title', function () {
    the_title('<h1 class="c-product__title"><span class="fa-title">', '</span></h1><span class="c-product__guaranteed">بیش از ۱۰ نفر از خریداران این محصول را پیشنهاد داده‌اند</span>');
});

add_action('woocommerce_product_meta_start', function () {
    echo ' <div class="c-product__directory">';
});
add_action('woocommerce_product_meta_end', function () {
    echo '</div>';
});


/** get all brand one product */

add_action('show_brands', function ($product_id) {
    $brands = get_the_terms($product_id, 'brand');
    if ($brands) {
        foreach ($brands as $brand) {
            ?>
            <li><span>برند : </span> <a href="<?php echo get_term_link($brand->term_id) ?>"
                                        class="btn-link-spoiler"><?php echo $brand->name ?></a></li>
            <?php
        }
    }

});


add_action('custom_attribute', 'woocommerce_template_single_meta', 5);

/** get vendor info for single product */
add_action('woocommerce_single_product_summary', 'get_vendor', 1);

function get_vendor()
{
    global $product;

    // Get the author ID (the vendor ID)
    $vendor_id = get_post_field('post_author', $product->get_id());
    // Get the WP_User object (the vendor) from author ID
    $vendor = new WP_User($vendor_id);

    $store_info = dokan_get_store_info($vendor_id); // Get the store data
    $store_name = $store_info['store_name'];          // Get the store name
    $store_url = dokan_get_store_url($vendor_id);  // Get the store URL

    $vendor_name = $vendor->display_name;              // Get the vendor name
    $address = $vendor->billing_address_1;           // Get the vendor address
    $postcode = $vendor->billing_postcode;          // Get the vendor postcode
    $city = $vendor->billing_city;              // Get the vendor city
    $state = $vendor->billing_state;             // Get the vendor state
    $country = $vendor->billing_country;           // Get the vendor country

    echo '<div class="seller"><span> فروشنده : </span> <a href="' . $store_url . '" class="btn-link-spoiler">' . $vendor_name . '</a></div>';
}


/** get delivery */
add_action('woocommerce_single_product_summary', function () {
    echo '
                     <div class="c-product__delivery">
                        <div class="delivery-warehouse"><i class="fa fa-truck"></i><span
                                class="c-product__delivery-warehouse--no-lead-time">آماده ارسال</span></div>
                    </div>';
}, 3);


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 5);

add_action('woocommerce_before_add_to_cart_form', function () {
    echo ' <div class="c-product__add">';
});
add_action('woocommerce_after_add_to_cart_form', function () {
    echo ' </div>';
});
remove_all_actions('woocommerce_product_additional_information');
add_action('woocommerce_product_additional_information', function ($product) {
    $attributes = $product->get_attributes();

    if (!$attributes) {
        echo "ویژگی وجود ندارد";
    }
    foreach ($attributes as $attribute) {
        ?>
        <li>
            <div class="c-params__list-key"><span class="block"><?php echo $attribute['name'] ?></span></div>
            <div class="c-params__list-value">

                <?php $product_attributes = array();
                $product_attributes = explode('|', $attribute['value']);
                foreach ($product_attributes as $pa) {
                    echo '<span class="block">' . $pa . '</span>';
                } ?>


            </div>
        </li>

        <?php
    }
});

add_action('woocommerce_after_cart_item_name', function ($cart_item) {

    $product = wc_get_product($cart_item['product_id']);

    echo '<p class="c-checkout__guarantee">';
    echo $product->get_short_description();
    echo '</p>';

}, 1);



/** action vhange plan for each product */

add_action('wp_ajax_add_plan',function ()
{
    $ids=$_POST['product_id'];
    $arr_product_plan_ids=array();
    foreach ($ids as $id)
    {
        $arr_product_plan_ids[$id]=$_POST['id_plan'];

    }
});


/** action filter plans */

add_action('wp_ajax_filter_plans', function () {


    /** price installment */
    $mega_array = array();




    /** store plan */
        foreach ($_POST['product_id'] as $id):

            $html="";





            $plans_store = get_post_meta($id, 'plans', true);
            global $wpdb;

           if ( $plans_store) {
            $array_html = array();
            $html .= "<p class='plans-store__title'>پلن فروشگاهی</p>";
               $html .='<div class="plans-store__container">';
            foreach ($plans_store as $id_plan) :

                $html .= "";

                $pln = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$id_plan}");
                if ($pln->is_active) {
                    $html .= "<div>";

                $all_data_selected_plan = WC()->session->get('selected_plan');


                $plan_id_selected = 0;
//                if (isset($all_data_selected_plan[$id])) $plan_id_selected = $all_data_selected_plan[$id];
                 $plan_id_selected = $all_data_selected_plan[$id];

                $price_cash = get_post_meta($id, '_price', true);


                $pish = $price_cash * ($pln->pishe_darsad / 100);

                $mande = $price_cash - $pish;
                $final_ghest_price = $mande + ($mande * (($pln->num_month * $pln->darsad_profit) / 100));




                $html .= '<input type="radio" data-plan_id="' . $id_plan . '" class="radio_price" data-product_id="' . $id . '" name="plan_selected_cart-' . $id . '" id="plan_selected_cart-' . $id . '" value="' . $final_ghest_price . '"';
                if ($plan_id_selected == $id_plan) $html .= "checked";
                $html .= '>';



                    $html .= "<p>";
                $html .= "قیمت(پیش پرداخت + قیمت قسطی): ";
                $html .= number_format($final_ghest_price+$pish);
                $html .= " تومان " ;
                    $html .= "</p>";
                    $html .= "<p>";
                $html .= "قیمت قسطی: ";
                $html .= number_format($final_ghest_price);
                $html .= " تومان " ;
                    $html .= "</p>";



                    $html .= '<p class="pish">';
                    $html .= "پیش پرداخت:";

                    /** calc price pish */



                    $html .= ' ( ' . number_format($pish) . ' تومان )';




                    $html .= '</p>';
                    $html .= '<p class="month">';
                    $html .= "تعداد اقساط:";
                    $html .= $pln->num_month . " ماه";
                    $html .= '</p>';

                    $html .= '<p class="price_month">';
                    $html .= "مبلغ هر قسط";
                    $kol_ghest = $final_ghest_price / $pln->num_month;


                    $html .= '( ' . number_format(($kol_ghest)) . " تومان ) ";
                    $html .= '</p>';
                    $html .= '</div>';




                }


          endforeach;
               $html .= "</div>";

            }


            /** default panel */
            $array_html = array();
            global $wpdb;
            $plan_default = $wpdb->get_results("select * from {$wpdb->prefix}plans where id_vendor =0");
            $html .= "";
            $html .= "<p class='plans-store__title'>پلن عمومی</p>";
$html .='<div class="plans-store__container">';

// group installment
           $plans_general= get_post_meta($id, 'plans_general',true);



            foreach ($plan_default as $plan) :
                if (in_array($plan->id,$plans_general)):
                if ($plan->is_active) :
                    $html .="<div>";


                    $price_cash = get_post_meta($id, '_price', true);


                    $pish = $price_cash * ($plan->pishe_darsad / 100);

                    $mande = $price_cash - $pish;
                    $final_ghest_price = $mande + ($mande * (($plan->num_month * $plan->darsad_profit) / 100));





                    $all_data_selected_plan = WC()->session->get('selected_plan');

                    $plan_id_selected = 0;
                    if (isset($all_data_selected_plan[$id])) $plan_id_selected = $all_data_selected_plan[$id];

                    $html .= '<input type="radio" data-plan_id="' . $plan->id . '" class="radio_price" data-product_id="' . $id . '" name="plan_selected_cart-' . $id . '"  id="plan_selected_cart-' . $id . '" value="' . $final_ghest_price . '"';
                    if ($plan_id_selected == $plan->id) $html .= "checked";
                    $html .= '>';



$html .= "<p>";
                    $html .= "قیمت(پیش پرداخت + قیمت قسطی): ";


                    $html .= number_format($final_ghest_price+$pish);

                    $html .= " تومان ";
                    $html .= "</p>";
                    $html .= "<p>";
                    $html .= "قیمت قسطی: ";

                    $html .= number_format($final_ghest_price);

                    $html .= " تومان " ;
                    $html .= "</p>";

                    $html .= '<p class="pish">';
                    $html .= "پیش پرداخت:";
                    $html .= ' ( ' . number_format($pish) . ' تومان )';
                    $html .= '</p>';
                    $html .= '<p class="month">';
                    $html .= "تعداد قسط:";
                    $html .= $plan->num_month . " ماه";
                    $html .= '</p>';

                    $html .= '<p class="price_month">';
                    $html .= "قیمت هر قسط";
                    $html .= '( ' . number_format($final_ghest_price / $plan->num_month)
                        . " تومان ) ";
                    $html .= '</p>';



                    $html.="</div>";




endif;

                endif;
            endforeach;
            $html.="</div>";

            $id_user = get_current_user_id();
            $wallet = get_user_meta($id_user, '_current_woo_wallet_balance', true);


            $final_price = WC()->session->get('final_price_mul_qty', array());
            if ($final_price)
                $sum_final_price = array_sum($final_price);
            else
                $sum_final_price = 0;

            $html .= '<script type="text/javascript">

    jQuery(document).ready(function ($) {

        $(".section_price_installment_r").css("display", "none")

        $("input[class=radio_price]:radio").each(function() {
    if($(this).is(":checked")) {

                    $.ajax({
                    url: "/wp-admin/admin-ajax.php",
                    type: "post",
                    data: {
                        action: "change_price_installment",
                       product_id: $(this).data("product_id"),
                       plan_id: $(this).data("plan_id"),


                    },
                    success: function (response) {
                             $(".section_price_installment-"+response.id_product).empty()
                             .append(response.html);

                         $(".section_price_installment-"+response.id_product).css("display", "flex")



                    },
                    error: function (error) {
                        console.log("error");
                        console.log(error);
                    }

                })

       }
    });
        function addCommas(nStr)
{
    nStr += \'\';
    x = nStr.split(\'.\');
    x1 = x[0];
    x2 = x.length > 1 ? \'.\' + x[1] : \'\';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, \'$1\' + \',\' + \'$2\');
    }
    return x1 + x2;
}
        $(".radio_price").on("change", function () {

            console.log("changed plan");
            console.log($(this).data("product_id"));
            console.log($(this).data("plan_id"));

          var current_wallet=' . $wallet . ';

          var sum_final=' . $sum_final_price . ';




                   $.ajax({
                    url: "/wp-admin/admin-ajax.php",
                    type: "post",
                    data: {
                        action: "change_price_installment",
                       product_id: $(this).data("product_id"),
                       plan_id: $(this).data("plan_id"),
                         wallet:sum_final
                    },
                    success: function (response) {

                        console.log(response);
                             $(".section_price_installment-"+response.id_product).empty()
                             .append(response.html);
                             
                             //hide old mande
                             $(".wallet1-price").empty();
                             $(".wallet-price").empty();

                             //update total pish

                              $("#total_pish").empty()

                             .append(addCommas( parseInt(response.total_price)))
                             .append(" </span> <span>   تومان </span>  </p>");


                              // change wallet
                              

                                $(".wallet").empty()
                             .append("<span>جمع مبلغ قسطی انتخابی</span> <span> ");
                             $(".wallet-price")
                             .append(addCommas(response.change_wallet))
                             .append(" </span> <span>   تومان </span>  </p>");

//                            $(".wallet1").empty()
//                             .append("<span>اعتبار باقی مانده</span> <span> ");
                            $(".wallet1-price")
                            .append("<span>")
                             .append(addCommas(current_wallet - response.change_wallet))
                             .append(" </span> <span>   تومان </span> ");




                             if (current_wallet - response.change_wallet<=0)
                                 {
                                      $(".wallet1").css("color", "red");
                                 }else

                                    {
                                         $(".wallet1").css("color", "black");
                                    }



                    },
                    error: function (error) {
                        console.log(error);
                    }

                });



        });

  jQuery(document).ajaxStop(function () {
        jQuery("#cash").attr("disabled",false);
    });

    jQuery(document).ajaxStart(function () {
        jQuery("#cash").attr("disabled",true);
    });





    });
</script>';



            array_push($array_html, $html);



            $mega_array[$id] = $array_html;


        endforeach;


    wp_send_json($mega_array,200);
/*****************************************/







});




//action update pish total
add_action('wp_ajax_update_total_pish',function ()
{


});




$array_product_id_and_plan_id = [];





/** add session selected_panel */
add_action('wp_ajax_change_price_installment', function () {

/** change select*/
    $array_product_id_and_plan_id1 =WC()->session->get('selected_plan',array());

    $array_product_id_and_plan_id1[$_POST['product_id']] = $_POST['plan_id'];

    WC()->session->set('selected_plan',$array_product_id_and_plan_id1);

/** end */



    global $wpdb;


    $plans_store = get_post_meta($_POST['product_id'], 'plans', true);

    $plan = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_POST['plan_id']}");


    $targeted_id = $_POST['product_id'];


    /** get qty */

    foreach (WC()->cart->get_cart() as $cart_item):

        if (in_array($targeted_id, array($cart_item['product_id'], $cart_item['variation_id']))):
            $quantity = $cart_item['quantity'];


            /**price installment array */

            $array_product_by_price_installment = WC()->session->get('total_price_installment', array());
            if (!is_array($array_product_by_price_installment)) {
                $array_product_by_price_installment = array();
            }
            $ppp = get_post_meta($targeted_id, "_price", true);

            $pish = (($ppp * ($plan->pishe_darsad / 100)));

            $price_ghest = ($ppp - $pish);

            $price_ghest1_kol = $price_ghest + ($price_ghest * ($plan->darsad_profit * $plan->num_month / 100));
            $price_ghest1_kol *= $quantity;

            $array_product_by_price_installment[$cart_item['product_id']] = $price_ghest1_kol;

            WC()->session->set('total_price_installment', $array_product_by_price_installment);

            /**  end  */


            $array_product_by_price = WC()->session->get('total_price', array());
            if (!is_array($array_product_by_price)) {
                $array_product_by_price = array();
            }


            $ppp = get_post_meta($targeted_id, "_price", true);


            $array_product_by_price[$cart_item['product_id']] = $quantity * ($ppp * ($plan->pishe_darsad / 100));


            //total price => all price pish pardakht


            WC()->session->set('total_price', $array_product_by_price);


            add_action('woocommerce_cart_updated', function () {

            }, 10, 0);

            break;
        endif;
    endforeach;


    /** @var  $html subtotal side */

    // get price base
    $price_base = get_post_meta($targeted_id, '_price', true);
    $html = "";

    $html .= "<p>";
    $html .= "مبلغ کل: ";

    $pish = (($price_base * ($plan->pishe_darsad / 100)));

    $price_ghest = ($price_base - $pish);

    $pish_kol = $quantity * $pish;
    $price_ghest1_kol = $price_ghest + ($price_ghest * ($plan->darsad_profit * $plan->num_month / 100));
    $price_ghest1_kol *= $quantity;
    $html .= number_format($pish_kol + $price_ghest1_kol) . "</br>";
    $html .= "</p>";
    $html .= "<p>";
    $html .= "پیش پرداخت: ";


    $html .= ' ( ' . number_format($quantity * $pish) . ' تومان )' . "</br>";


    $price_ghest1 = $price_ghest + ($price_ghest * ($plan->darsad_profit * $plan->num_month / 100));
    $html .= "</p>";
    $html .= "<p>";
    $html .= "جمع اقساط: ";
    $html .= ' ( ' . number_format(($quantity * $price_ghest1)) . ' تومان )' . "</br>";
    $html .= "</p>";
    $html .= "<p>";
    $html .= "مبلغ هر قسط: ";
    $html .= ' ( ' . number_format($quantity * $price_ghest1 / $plan->num_month) . ' تومان )' . "</br>";
    $html .= "</p>";

    $arr_response = array();
    $arr_response['html'] = $html;
    $arr_response['id_product'] = $_POST['product_id'];






    /**  update total pish */


    //save to session id product by plan id selected



    $plan = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_POST['plan_id']}");


    $targeted_id = $_POST['product_id'];

    foreach (WC()->cart->get_cart() as $cart_item):

        if (in_array($targeted_id, array($cart_item['product_id'], $cart_item['variation_id']))):
            $quantity = $cart_item['quantity'];

            $array_product_by_price = WC()->session->get('total_price', array());
            if (!is_array($array_product_by_price)) {
                $array_product_by_price = array();
            }


            $ppp = get_post_meta($targeted_id, "_price", true);


            $array_product_by_price[$cart_item['product_id']] = $quantity * ($ppp * ($plan->pishe_darsad / 100));


            //total price => all price pish pardakht


            WC()->session->set('total_price', $array_product_by_price);

            break;
        endif;
    endforeach;

   $arr_response['total_price'] = array_sum( WC()->session->get('total_price', 0));


   /** change wallet */

    $plan = $wpdb->get_row("select * from {$wpdb->prefix}plans where id={$_POST['plan_id']}");


    $targeted_id = $_POST['product_id'];


    /** get qty */

    foreach (WC()->cart->get_cart() as $cart_item):

        if (in_array($targeted_id, array($cart_item['product_id'], $cart_item['variation_id']))):
            $quantity = $cart_item['quantity'];


            /**price installment array */

            $array_product_by_price_installment = WC()->session->get('total_price_installment', array());
            if (!is_array($array_product_by_price_installment)) {
                $array_product_by_price_installment = array();
            }
            $ppp = get_post_meta($targeted_id, "_price", true);

            $pish = (($ppp * ($plan->pishe_darsad / 100)));

            $price_ghest = ($ppp - $pish);

            $pish_kol = $quantity * $pish;
            $price_ghest1_kol = $price_ghest + ($price_ghest * ($plan->darsad_profit * $plan->num_month / 100));
            $price_ghest1_kol *= $quantity;

            $array_product_by_price_installment[$cart_item['product_id']] = $price_ghest1_kol;

            WC()->session->set('total_price_installment', $array_product_by_price_installment);

            /**  end  */


            $array_product_by_price = WC()->session->get('total_price', array());
            if (!is_array($array_product_by_price)) {
                $array_product_by_price = array();
            }


            $ppp = get_post_meta($targeted_id, "_price", true);


            $array_product_by_price[$cart_item['product_id']] = $quantity * ($ppp * ($plan->pishe_darsad / 100));


            //total price => all price pish pardakht


            WC()->session->set('total_price', $array_product_by_price);




            break;
        endif;
    endforeach;




    $sum_total_price = array_sum(WC()->session->get('total_price_installment', 0));

/** end */

    $arr_response['change_wallet']=$sum_total_price;





    wp_send_json($arr_response, 200);

});


add_action('wp_ajax_set_type_cart', function () {
    if (isset($_POST['type_cart'])) {
        if ($_POST['type_cart'] == "cash") {
            WC()->session->set('type_cart', 'cash_cart');
            return "cghanged";
        }
        if ($_POST['type_cart'] == "installment") {
            WC()->session->set('type_cart', 'installment_cart');
            return "cghanged";
        }
    }
    return "notttt";
});


add_filter('woocommerce_calculated_total', function ($total, $cart) {

  //  WC()->session->__unset('auth');
//    WC()->session->__unset( 'total_price' );
 //   WC()->session->__unset( 'final_price_mul_qty' );
    $type_cart = WC()->session->get('type_cart', "cash_cart");

    if ($type_cart == "installment_cart") {
        $c = 0;
        $array_product = WC()->session->get('total_price_installment', 0);


        if ($array_product) {
            if (is_array($array_product)) {
                foreach ($array_product as $id_product => $price_product):
                    $c += $price_product;
                endforeach;
            }
        }

        $cart->subtotal = $c;
        return $cart->subtotal;
    }
    return $cart->subtotal;

}, 50, 2);

/** remove item from cart */

function ss_cart_updated($cart_item_key, $cart)
{

    $product_id = $cart->cart_contents[$cart_item_key]['product_id'];


    $arr_total_price = WC()->session->get('total_price', '0');
    if($arr_total_price !=0)
    {
        unset($arr_total_price[$product_id]);
    }



    WC()->session->set('total_price', $arr_total_price);

    $arr_total_price_installment = WC()->session->get('total_price_installment', '0');
    if ($arr_total_price_installment !=0)
    {
        unset($arr_total_price_installment[$product_id]);
    }

    WC()->session->set('total_price_installment', $arr_total_price_installment);








    $array_final_price = WC()->session->get('final_price_mul_qty', 0);
    unset($array_final_price[$product_id]);
    WC()->session->set('final_price_mul_qty', $array_final_price);
}

add_action('woocommerce_remove_cart_item', 'ss_cart_updated', 10, 2);


/** after checkout */

add_action('woocommerce_after_checkout_billing_form', 'QuadLayers_callback_function');
function QuadLayers_callback_function()
{
    include "app/views/user/checkout_table.php";
}


/**
 * Remove all possible fields
 **/
function wc_remove_checkout_fields($fields)
{

    // Billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_phone']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);

    // Shipping fields
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_phone']);
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_first_name']);
    unset($fields['shipping']['shipping_last_name']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);

    // Order fields
    unset($fields['order']['order_comments']);

    return $fields;
}

//add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );


add_filter('woocommerce_billing_fields', 'wc_unrequire_wc_phone_field');
function wc_unrequire_wc_phone_field($fields)
{
//    $fields['billing_company']['required'] = true;
    $fields['billing_phone']['required'] = false;

    return $fields;
}


/** remove all class checkout field */
add_filter('woocommerce_form_field_country', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_state', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_textarea', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_checkbox', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_password', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_text', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_email', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_tel', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_number', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_select', 'clean_checkout_fields_class_attribute_values', 20, 4);
add_filter('woocommerce_form_field_radio', 'clean_checkout_fields_class_attribute_values', 20, 4);
function clean_checkout_fields_class_attribute_values($field, $key, $args, $value)
{
    if (is_checkout()) {
        // remove "form-row"
        $field = str_replace(array('<p class="form-row ', '<p class="form-row'), array('<p class="', '<p class="'), $field);
    }

    return $field;
}

add_filter('woocommerce_checkout_fields', 'custom_checkout_fields_class_attribute_value', 20, 1);
function custom_checkout_fields_class_attribute_value($fields)
{
    $fields['billing']['billing_company']['label'] = 'نام سازمان';
    foreach ($fields as $fields_group_key => $group_fields_values) {
        foreach ($group_fields_values as $field_key => $field) {
            // Remove other classes (or set yours)
            $fields[$fields_group_key][$field_key]['class'] = array();
        }
    }

    return $fields;
}

/** end */

/** add class to filed  */


add_filter('woocommerce_form_field_args', 'wc_form_field_args', 10, 3);

function wc_form_field_args($args, $key, $value = null)
{

    /*********************************************************************************************/
    /**
     *
     * $defaults = array(
     * 'type'              => 'text',
     * 'label'             => '',
     * 'description'       => '',
     * 'placeholder'       => '',
     * 'maxlength'         => false,
     * 'required'          => false,
     * 'id'                => $key,
     * 'class'             => array(),
     * 'label_class'       => array(),
     * 'input_class'       => array(),
     * 'return'            => false,
     * 'options'           => array(),
     * 'custom_attributes' => array(),
     * 'validate'          => array(),
     * 'default'           => '',
     * );
     * /*********************************************************************************************/

// Start field type switch case

    switch ($args['type']) {

        case "select" :  /* Targets all select input type elements, except the country and state select input types */
            $args['class'][] = 'form-group form-row-first'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag
            $args['input_class'] = array('form-control', 'input-lg'); // Add a class to the form input itself
            //$args['custom_attributes']['data-plugin'] = 'select2';
            $args['label_class'] = array('control-label');
            $args['custom_attributes'] = array('data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',); // Add custom data attributes to the form input itself
            break;

        case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
            $args['class'][] = 'country';
            $args['label_class'] = array('control-label');
            break;

        case "state" : /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */
            $args['class'][] = 'form-group form-row-last'; // Add class to the field's html element wrapper
            $args['input_class'] = array('form-control', 'input-lg'); // add class to the form input itself
            //$args['custom_attributes']['data-plugin'] = 'select2';
            $args['label_class'] = array('control-label');
            $args['custom_attributes'] = array('data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',);
            break;


        case "password" :
        case "text" :
        case "email" :
        case "tel" :
        case "number" :
            $args['class'][] = 'form-group form-row-first';
            //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
            $args['input_class'] = array('form-control', 'input-lg');
            $args['label_class'] = array('control-label');
            break;

        case 'textarea' :
            $args['input_class'] = array('form-control', 'input-lg');
            $args['label_class'] = array('control-label');
            break;

        case 'checkbox' :
            break;

        case 'radio' :
            break;

        default :
            $args['class'][] = 'form-group';
            $args['input_class'] = array('form-control', 'input-lg');
            $args['label_class'] = array('control-label');
            break;
    }

    return $args;
}


/** change label */

//add_filter('woocommerce_checkout_fields', 'change_label_billing');
//
//function change_label_billing($fields)
//{
//
//    $fields['billing']['billing_company']['placeholder'] = "سازمان";
//    return $fields;
//}

add_action('woocommerce_thankyou', 'clear_session_wc', 10, 1);

function clear_session_wc($order_id)
{

    WC()->session->__unset('total_price');

    WC()->session->__unset('total_price_installment');
    WC()->session->__unset('selected_plan');

    WC()->session->__unset('type_cart');
    WC()->session->__unset('auth');

}

add_action('woocommerce_checkout_order_review', function () {


});

/** auth */

add_action('wp_ajax_wp_auth_account', function () {
    $password = get_user_meta(get_current_user_id(), 'credit_password', true);
    if ($password == $_POST['password']) {
        WC()->session->set('auth', "ok");
    } else {
        WC()->session->set('auth', "error");
    }

});

/** end auth */


add_filter('woocommerce_payment_complete_order_status', 'rfvc_update_order_status', 10, 2);

function rfvc_update_order_status($order_status, $order_id)
{


    $order = new WC_Order($order_id);

    if ('processing' == $order_status && ('on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status)) {

        return 'completed';

    }

    return $order_status;
}

/** nav menu register */
 register_nav_menu(
     'main_menu',
     'منو اصلی سایت'
 );

/** walker menu */
class My_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ($depth==0)
        {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"dropdown2\" >\n";
        }elseif ($depth==1)
        {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"megamenu\" >\n";
        }else
        {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"\" >\n";
        }

    }




}




/*count view*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 بازدید";
    }
    return $count.' بازدید';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('بازدید');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

/** add field image to brand */

add_action( 'brand_edit_form_fields', 'extra_tax_fields', 10, 2);


//add extra fields to custom taxonomy edit form callback function
function extra_tax_fields($tag) {
    //check for existing taxonomy meta for term ID
//    var_dump($tag);
    $t_id = $tag->term_id;
    $term_meta = get_option( "img_$t_id");
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_Image_url">عکس برند</label></th>
        <td>
            <a href="#" id="img-upload"> انتخاب عکس</a>



            <img src="<?php echo $term_meta?>" alt="" id="img-src">
            <input type="text" name="image-brand" id="img" size="3" style="width:60%;" value="<?php echo $term_meta?>"><br />
            <span class="description"><?php _e('عکس انتخابی در قسمت برندهای ویژه نمایش داده می شود'); ?></span>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function (e) {
            // e.preventDefault();
            jQuery('#img-upload').click(function () {
                var upload = wp.media({
                    title: 'انتخاب عکس برای برند', //Title for Media Box
                    multiple: false //For limiting multiple image
                })
                    .on('select', function () {
                        var select = upload.state().get('selection');
                        var attach = select.first().toJSON();
                        console.log(attach.id); //the attachment id of image
                        console.log(attach.url); //url of image
                        jQuery('img#img-src').attr('src', attach.url);
                        jQuery('input#img').attr('value', attach.url);
                    })
                    .open();
            });

        });
    </script>



    <?php
}

/** save image brand */

add_action( 'edited_brand', 'save_extra_taxonomy_fileds', 10, 2);

function save_extra_taxonomy_fileds( $term_id ,$tt)
{




    if ( isset( $_POST['image-brand'] ) ) {

        $termid = $term_id;
        $cat_meta = get_option( "img_$termid");
        if ($cat_meta !== false ) {
         //  update_user_meta(1,"img_$termid",$_POST['image-brand']);
            update_option(  "img_$termid",$_POST['image-brand']  );
        }else{

            add_option(  "img_$termid",$_POST['image-brand'] ,  '', 'yes'  );
        }
    }


}

	class comment_walker extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

		// constructor – wrapper for the comments list
		function __construct() { ?>

<div class="comment_reply">

		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			<section class="child-comments comments-list col-12">

		<?php }

		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		// start_el – HTML for comment template
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} else {
				$tag = 'article';
				$add_below = 'comment';
			} ?>

			       <div class="col-12 col-sm-4">
                            <div class="comment_reply_image">
                               <?php echo get_avatar( $comment, 65, '[default gravatar URL]', 'Author’s gravatar' ); ?>
                                <span class="date">
						          <a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>

                                </span>
                                 <time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php comment_date('jS F Y') ?>, <a href="#comment-<?php comment_ID() ?>" itemprop="url"><?php comment_time() ?></a></time>
                            </div>
                  </div>
                  <div class="col-12 col-sm-8" style="padding: 0;">
                            <div class="comment_answer">
                                <p>
                                <?php comment_text() ?>

                                </p>
                                <button><?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></button>
                            </div>

                  </div>




		<?php }

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>



		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>

		</div>

		<?php }

	}




function filter_comment_form_submit_button( $submit_button, $args ) {
    $submit_before = '<button type="submit">';
    $submit_after = '</button>';
    return $submit_before . "ارسال نظر" . $submit_after;
};
add_filter( 'comment_form_submit_button', 'filter_comment_form_submit_button', 10, 2 );






/** add pish price to meta data order */
add_action('woocommerce_checkout_create_order', 'before_checkout_create_order', 20, 2);
function before_checkout_create_order( $order, $data ) {
    $price_pish = WC()->session->get('total_price', array());
    $order->update_meta_data( '_price_pish_total', array_sum(WC()->session->get('total_price', array())) );
}


/** add data order for each product to table custom */

add_action('dokan_checkout_update_order_meta', function ($order_id) {



    global $wpdb;
    $order=wc_get_order($order_id);
$arr_product_plan=WC()->session->get("selected_plan",array());


    $items = $order->get_items();

//    exit();

    foreach ($items as $i)
    {

        $product = $i->get_product();
        $id_plan=$arr_product_plan[$product->get_id()];
        $plan=$wpdb->get_row("select * from {$wpdb->prefix}plans where id={$id_plan}");
        $pish=$product->get_price() *($plan->pishe_darsad/100);


        $mande = $product->get_price() - $pish;

        $ghest_by_profit = $mande * (($plan->num_month * $plan->darsad_profit) / 100);

        $final_ghest_price = $mande + ($mande * (($plan->num_month * $plan->darsad_profit) / 100));

        /** get qty */
// Set here your product ID (or variation ID)
        $targeted_id = $product->get_id();

// Loop through cart items
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            if( in_array( $targeted_id, array($cart_item['product_id'], $cart_item['variation_id']) )){
            $quantity =  $cart_item['quantity'];
            break; // stop the loop if product is found
            }
        }


/** insert order details
 */



       $wpdb->insert($wpdb->prefix.'order_details',[
            'id_order'=>$order_id,
            'id_product'=>$product->get_id(),
            'qty'=>$quantity,
            'price_pish'=>$pish,
            'num_month'=>$plan->num_month,
            'price_installment'=>$final_ghest_price,
            'darsa_profit'=>$plan->darsad_profit,
            'id_user'=>$order->get_user_id(),
           'day_due'=>$plan->due_date
        ]);





    }


}, 10, 1);

add_action('woocommerce_checkout_update_order_meta', function ($order_id) {
//add_action('woocommerce_new_order', function ($order_id) {





   // if (!$order_post->have_posts())

        global $wpdb;
        $order=wc_get_order($order_id);
        $arr_product_plan=WC()->session->get("selected_plan",array());


        $items = $order->get_items();

        // get all id seller

    $author=[];



        foreach ($items as $item)
        {

            $product = $item->get_product();
           $id_target= $product->get_id();

            $post_obj    = get_post( $id_target ); // The WP_Post object
            $post_author = $post_obj->post_author;
            if (!in_array($post_author,$author))
            {
                array_push($author,$post_author);

            }

        }


//check if one seller

    if(count($author) == 1)
    {



        foreach ($items as $i)
        {



            $product = $i->get_product();
            $id_plan=$arr_product_plan[$product->get_id()];
            $plan=$wpdb->get_row("select * from {$wpdb->prefix}plans where id={$id_plan}");
            $pish=$product->get_price() *($plan->pishe_darsad/100);


            $mande = $product->get_price() - $pish;

            $ghest_by_profit = $mande * (($plan->num_month * $plan->darsad_profit) / 100);

            $final_ghest_price = $mande + ($mande * (($plan->num_month * $plan->darsad_profit) / 100));

            /** get qty */

            $targeted_id = $product->get_id();


            foreach ( WC()->cart->get_cart() as $cart_item ) {
                if( in_array( $targeted_id, array($cart_item['product_id'], $cart_item['variation_id']) )){
                    $quantity =  $cart_item['quantity'];
                    break; // stop the loop if product is found
                }
            }


            /** insert order details
             */



            $wpdb->insert($wpdb->prefix.'order_details',[
                'id_order'=>$order_id,
                'id_product'=>$product->get_id(),
                'qty'=>$quantity,
                'price_pish'=>$pish,
                'num_month'=>$plan->num_month,
                'price_installment'=>$final_ghest_price,
                'darsa_profit'=>$plan->darsad_profit,
                'id_user'=>$order->get_user_id(),
                'day_due'=>$plan->due_date

            ]);






        }
    }





}, 10, 1);


/** add tab installment */

/*
* Step 1. Add Link (Tab) to My Account menu
*/
add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
function misha_log_history_link( $menu_links ){



    $user = wp_get_current_user(); // getting & setting the current user
    $roles = $user->get_role_caps(); // obtaining the role
    if ( array_key_exists("personnel",$roles))
    {
        $menu_links = array_slice( $menu_links, 0, 5, true )
            + array( 'installment' => 'لیست قسط ها' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    }
    return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'installment', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_installment_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
    if (isset($_GET['action']))
    {
        if ($_GET['action']=="show_list_installment" && isset($_GET['item']))
        {
            include "app/views/user/my-account-installment.php";

        }else
        {
            include "app/views/user/my-account-order-installment.php";
        }

    }else
    {
        include "app/views/user/my-account-order-installment.php";
    }
}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.

//add request product

/*
* Step 1. Add Link (Tab) to My Account menu
*/
add_filter ( 'woocommerce_account_menu_items', 'tab_link_request_list', 40 );
function tab_link_request_list( $menu_links ){



    $user = wp_get_current_user(); // getting & setting the current user
    $roles = $user->get_role_caps(); // obtaining the role
    if ( array_key_exists("personnel",$roles))
    {
        $menu_links = array_slice( $menu_links, 0, 5, true )
            + array( 'request_list' => 'کالاهای درخواستی' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    }
    return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint_request_list' );
function misha_add_endpoint_request_list() {

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'request_list', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_request_list_endpoint', 'misha_my_account_endpoint_request_list' );
function misha_my_account_endpoint_request_list() {

            include "app/views/user/list_product_request.php";

}


/** add menu list order wait installment */

/*
* Step 1. Add Link (Tab) to My Account menu
*/
add_filter ( 'woocommerce_account_menu_items', 'add_menu_list_order_wait_installment_investor', 40 );

function add_menu_list_order_wait_installment_investor( $menu_links ){

    $user = wp_get_current_user(); // getting & setting the current user
    $roles = $user->get_role_caps(); // obtaining the role
    if ( array_key_exists("investor",$roles))
    {
        $menu_links = array_slice( $menu_links, 0, 5, true )
            + array( 'listorderwaitinvestor' => 'لیست سفارشات قسطی در حال انتظار' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    }
    return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint_list_order_wait_investor' );
function misha_add_endpoint_list_order_wait_investor() {

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'listorderwaitinvestor', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_listorderwaitinvestor_endpoint', 'list_order_installment_wait_endpoint_content' );

function list_order_installment_wait_endpoint_content() {


    include "app/views/user/list-order-wait-installment.php";

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.







/** add menu list order ok installment */

/*
* Step 1. Add Link (Tab) to My Account menu
*/
add_filter ( 'woocommerce_account_menu_items', 'add_menu_list_order_ok_installment_investor', 40 );

function add_menu_list_order_ok_installment_investor( $menu_links ){

    $user = wp_get_current_user(); // getting & setting the current user
    $roles = $user->get_role_caps(); // obtaining the role
    if ( array_key_exists("investor",$roles))
    {

        $menu_links = array_slice( $menu_links, 0, 6, true )
            + array( 'listorderokinvestor' => 'لیست سفارشات قسطی تایید شده' )
            + array_slice( $menu_links, 5, NULL, true );

        return $menu_links;
    }
    return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint_list_order_ok_investor' );
function misha_add_endpoint_list_order_ok_investor() {

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'listorderokinvestor', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_listorderokinvestor_endpoint', 'list_order_installment_ok_endpoint_content' );

function list_order_installment_ok_endpoint_content() {


    include "app/views/user/list-order-ok-installment.php";

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.




remove_action("woocommerce_before_shop_loop_item_title","woocommerce_show_product_loop_sale_flash",10);


add_action("custom_sale","woocommerce_show_product_loop_sale_flash",10);

add_filter("woocommerce_sale_flash",function ( $output_html, $post, $product)
    {
    return  '<div class="onsale">
        <span>حراج</span>
            <div class="arrow-up"></div>
    </div>';
},10,3);

/** favorite */
add_action("wp_ajax_add_to_fav",function ()
{
    $fav=get_user_meta($_POST['id_user'],"fav_product",true);
    if (!$fav)
    {
        $fav=[];
    }
//    wp_send_json($fav);
//    wp_send_json(!in_array($_POST['id_product'],$fav));
    if(!in_array($_POST['id_product'],$fav))
    {
        array_push($fav,$_POST['id_product']);
//        $fav[]=$_POST['id_product'];
//        wp_send_json($_POST['id_product']);
//        wp_send_json(in_array($_POST['id_product'],$fav));
//        wp_send_json($fav,200);
//        wp_send_json($fav[0],200);
//        wp_send_json(gettype($fav),200);
        update_user_meta($_POST['id_user'],"fav_product",$fav);
        wp_send_json("add",200);
    }
    $fav = array_diff($fav, array($_POST['id_product']));
    update_user_meta($_POST['id_user'],"fav_product",$fav);
    wp_send_json("remove",200);

});

add_action("wp_ajax_remove_product_from_list_fav",function()
{

    $fav=get_user_meta(get_current_user_id(),"fav_product",true);
    if (!$fav)
    {
        $fav=[];
    }

    $fav = array_diff($fav, array($_POST['id_product']));
    update_user_meta(get_current_user_id(),"fav_product",$fav);
    wp_send_json("remove",200);

});


add_action("load_details_print",function ()
{
    //operator
    if(isset($_GET['action']))
    {
        if ($_GET['action']=="show_details")
        {
            include 'app/views/user/show_details_order_print.php';
            exit();
        }
    }else{
        // include 'views/admin/show_order_ok_investor.php';
    }
});


/** send sms manager for order */
// define the woocommerce_thankyou callback
function action_woocommerce_thankyou( $order_get_id ) {
    // make action magic happen here...

    $order = new WC_Order( $order_get_id );
    $user_id = $order->get_user_id();

    $organ= get_user_by('id', $user_id)->organ;

    $id_manager=get_post_meta($organ,"id_manager_organization",true);
    $mobile= get_user_by('id', $id_manager)->mobile;




    $url = 'http://www.0098sms.com/sendsmslink.aspx';
    $data = array(
        'FROM' => '30005367',
        'TO' => $mobile,
        'TEXT' => "سلام پرسنل شما خرید کرده است.",
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


};

// add the action
add_action( 'woocommerce_thankyou', 'action_woocommerce_thankyou', 10, 1 );

