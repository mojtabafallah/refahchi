<?php

$allorders = wc_get_orders(array(
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
if ($organization->have_posts()):
    while ($organization->have_posts()):
        $organization->the_post();
        $id_manager = get_post_meta(get_the_ID(), 'id_manager_organization', true);
        if ($id_manager == get_current_user_id()) {
            $all_personnel = get_users([
                'meta_key' => 'organ',
                'meta_value' => get_the_ID()
            ]);
            break;
        }
    endwhile;
    $array_final = array();

    foreach ($all_personnel as $personnel) {
        foreach ($allorders as $order) {
            $ord = wc_get_order($order);
//               var_dump($personnel->id);
//$ord->get_date_created()

            if ($ord->get_user_id() == $personnel->ID) {
                $array_final[] = $ord;
            }
        }
    }

endif;

?>


    <div class="wrap">
        <h1>
            تمامی سفارشات پرسنل شما
        </h1>

        <table class="widefat">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>نام و نام خانوادگی خریدار</th>
                <th>نام شرکت</th>
                <th>مبلغ قسطی</th>
                <th>مبلغ پیش پرداخت</th>
                <th>محصولات</th>

                <th>زمان خرید</th>

                <th>وضعیت سفارش</th>
            </tr>
            <?php

            foreach ($array_final as $item): ?>


                <?php if ($item->get_parent_id() == 0): ?>
                    <tr>
                        <td><?php echo $item->get_id() ?></td>
                        <td><?php
                            echo get_user_by('id', $item->get_user_id())->display_name; ?></td>
                        <td>
                            <?php echo get_the_title(get_user_by('id', $item->get_user_id())->organ); ?>
                        </td>
                        <td>

                            <?php echo number_format($item->get_total()); ?> تومان

                        </td>
                        <td>

                            <?php               $metadata = $item->get_meta_data();
                            foreach ($metadata as $data)
                            {
                                if ($data->key =="_price_pish_total")
                                {
                                    echo number_format($data->value) . " تومان";
                                }

                            } ?>

                        </td>

                        <td>
                            <?php foreach ($item->get_items() as $product): ?>

                                <?php echo $product->get_data()['name'] . '(' . $product->get_data()['quantity'] . ')' ; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php
                            $a=new WPSH_Core();



                            echo $a->wp_shamsi(null, 'l d F Y', strtotime( $item->get_date_created()));?>

                        </td>


                        <td>
                      <?php echo  $item->get_status()?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>


            </thead>
        </table>
    </div>


<?php

