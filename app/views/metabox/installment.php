<div class="wrap">

    <?php
    $price=0;
    if (get_post_meta($post->ID, '_price', true)) :
        $price = get_post_meta($post->ID, '_regular_price', true);


    endif;

    global $wpdb;


    // Get the author ID (the vendor ID)
    $vendor_id = get_post_field('post_author', get_the_ID());


    $plans = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}plans where id_vendor={$vendor_id}");


    ?>
    <table class="widefat">
        <thead>
        <tr>
            <th>انتخاب</th>
            <th>درصد پیش پرداخت</th>
            <th>تعداد اقساط</th>
            <th>درصد سود هر ماه</th>
            <th>فروشنده</th>
            <th>قیمت نقدی</th>
            <th>قیمت قسطی</th>
            <th>تاریخ سر رسید</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $plans_product = get_post_meta($post->ID, 'plans', true);

        $all_id_plan_product_current = array();

        if ($plans_product) {

            foreach ($plans_product as $key) {
                $all_id_plan_product_current[] = $key;
            }
        }

        ?>



        <?php foreach ($plans as $plan): ?>

            <tr <?php
            if (in_array($plan->id, $all_id_plan_product_current)): echo "style='background-color:red;'"; endif; ?>>
                <td><input type="checkbox" name="plan_selected-<?php echo $plan->id ?>"
                           value="<?php echo $plan->id ?>" <?php if (in_array($plan->id, $all_id_plan_product_current)): echo "checked"; endif; ?>>
                </td>
                <td><span><?php echo $plan->pishe_darsad ?></span> <span>%</span></td>
                <td>
                    <span><?php echo $plan->num_month ?></span> <span>ماه</span>
                </td>
                <td>
                    <span><?php echo $plan->darsad_profit ?></span> <span>% هر ماه</span>
                </td>
                <td>
                    <?php $users = get_user_by('id', $plan->id_vendor);

                    echo $users->first_name;
                    ?>
                </td>
                <td>

                    <?php echo $price ? $price : "نامعلوم"; ?>
                </td>
                <td>

                    <input readonly type="text" value="<?php


                    $pish = $price * ($plan->pishe_darsad / 100);
                    $ghest = $price - $pish;
                    $ghest_by_profit = $ghest + ($ghest * (($plan->num_month * $plan->darsad_profit) / 100));
                    $final_price_ghest = $ghest_by_profit + $pish;
                    echo intval($final_price_ghest);




                    ?>" name="price_installment-<?php echo $plan->id ?>">


                </td>
                <td>
                    <?php echo $plan->due_date ?  $plan->due_date . " ام هر ماه" : "نا مشخص"  ?>

                </td>


            </tr>

        <?php endforeach; ?>


        </tbody>
    </table>

</div>
