<div class="wrap">
    <h1>
        افراد سازمان
    </h1>
    <div style="display:flex;">
        <label for="code_melli">کد ملی</label>
        <input type="text" id="code_melli_personnel" class="filter_personnel">
        <label for="name">نام</label>
        <input type="text" id="name_personnel" class="filter_personnel">
        <label for="family">فامیلی</label>
        <input type="text" id="family_personnel" class="filter_personnel">

    </div>
    <a class="button" href="<?php echo add_query_arg(['action' => 'add']) ?>">ثبت پرسنل جدید </a>
    <table class="widefat">
        <thead>
        <tr>
            <th>شناسه</th>
            <th>کد ملی</th>
            <th>کد پرسنلی</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>تلفن همراه</th>
            <th>رمز اعتبار</th>
            <th>انسداد</th>
            <th>دلیل انسداد</th>
            <th>شماره نامه انسداد</th>
            <th>نام بانک</th>
            <th>شماره حساب</th>
            <th>شماره کارت</th>
            <th>شماره شبای بانکی</th>
            <th> شعبه بانک</th>
            <th>نام سازمان</th>
            <th>مدیر سازمان</th>
            <th>سمت</th>
            <th>اعتبار</th>
            <th>واحد سازمانی</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody id="t-body-personnel">
        <?php

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
                                <a href="<?php echo add_query_arg(['action' => 'delete', 'item' => $user->ID]) ?>"><span
                                            class="dashicons dashicons-trash"></span></a>
                                <a href="<?php echo add_query_arg(['action' => 'edit', 'item' => $user->ID]) ?>"><span
                                            class="dashicons dashicons-edit"></span></a>
                            </td>
                        </tr>
                    <?php endif; ?>

            <?php
            endforeach;
        endforeach; ?>

        </tbody>
    </table>
</div>