<div class="wrap">
    <h1>
         تعریف پلن های قسطی فروشگاه
    </h1>
    <a href="<?php echo add_query_arg(['action' => 'add']) ?>" class="button">ثبت پلن جدید </a>
    <table class="widefat">
        <thead>
        <tr>
            <th>شناسه</th>
            <th>میزان پیش پرداخت</th>
            <th>تعداد اقساط</th>
            <th>فروشنده</th>
            <th>درصد سود در هر ماه</th>
            <th>تاریخ سر رسید</th>

            <th>فعال</th>
            <th>حذف شده</th>
            <th>عملیات</th>
        </tr>
        <?php
        global $wpdb;
        $plans = $wpdb->get_results("select * from {$wpdb->prefix}plans where id_vendor != 0");


        foreach ($plans as $plan): ?>
            <tr>
                <td><?php echo $plan->id ?></td>
                <td><?php echo $plan->pishe_darsad ?></td>
                <td><?php echo $plan->num_month ?></td>
                <td><?php echo get_user_by('id',$plan->id_vendor )->display_name ?></td>
                <td><?php echo $plan->darsad_profit?>%</td>
                <td><?php echo $plan->due_date?>ام هر ماه</td>

                <td><?php echo $plan->is_active==1 ? "فعال" : "غیر فعال" ?></td>
                <td><?php echo $plan->is_remove==1 ? "حذف شده" : "-" ?></td>
                <td>
                    <a href="<?php echo add_query_arg(['action' => 'delete', 'item' => $plan->id]) ?>"><span class="dashicons dashicons-trash"></span></a>
                    <a href="<?php echo add_query_arg(['action' => 'edit', 'item' => $plan->id]) ?>"><span class="dashicons dashicons-edit"></span></a>
                </td>
            </tr>
        <?php endforeach; ?>




        </thead>
    </table>
</div>
