<?php
global $wpdb;
$product_request= $wpdb->get_results("select * from {$wpdb->prefix}request_product");
?>

<div class="wrap">
    <h1>
        مدیریت کالاهای درخواستی
    </h1>

    <table class="widefat">
        <thead>
        <tr>
            <th>شماره</th>
            <th>کاربر درخواست کننده </th>
            <th>نام محصول درخواستی</th>
            <th>دسته بندی</th>
            <th>توضیحات</th>
            <th>عملیات</th>

        </tr>
        </thead>
        <tbody id="t-body">
        <?php


        foreach ($product_request as $product): ?>

            <tr>
                <td>
                    <?php echo $product->id ?>
                </td>

                <td>
                    <?php echo get_userdata($product->id_user)->user_login; ?>
                </td>
                <td>
                    <?php echo $product->name_product ?>
                </td>
                <td>
                    <?php echo get_the_category_by_ID( $product->id_category )
?>
                </td>



                <td>
                    <?php echo $product->description
                    ?>
                </td>
                <td>
                    <?php if($product->status == 0):?>
                    <a style="margin: 10px"
                       href="<?php echo add_query_arg(['action' => 'ok', 'item' => $product->id]) ?>">
                        <button class="button button-primary button-large" type="button">در فروشگاه قرار گرفته شد</button>
                    </a>
                    <a style="margin: 10px"
                       href="<?php echo add_query_arg(['action' => 'cancel', 'item' => $product->id]) ?>">
                        <button class="button button-primary button-large" type="button">امکان قرار دادن کالا وجود ندارد</button>
                    </a>
                    <?php elseif ($product->status == 1):?>
                    در فروشگاه درج شد
                    <?php elseif ($product->status == 2):?>
                    امکان درج کالا وجود ندارد

                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>


        </tbody>

    </table>
</div>