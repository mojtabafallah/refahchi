<?php
defined('ABSPATH') || exit;
include URI_THEME . "/app/jdf.php";?>
<div class="o-page__content">

    <div class="o-headline o-headline--profile"><span>لیست اقساط شما </span></div>
    <div class="c-table-orders">
        <div class="c-table-orders__head--highlighted">
            <div>شماره سفارش</div>
            <div>محصول</div>
            <div>نام فروشگاه</div>

            <div>مبلغ </div>
            <div>وضعیت</div>
            <div>تاریخ سر رسید</div>
            <div>نمایش اقساط</div>
        </div>
        <div class="c-table-orders__body">
            <?php global $wpdb;
            $id_user = get_current_user_id();

            $all_installment = $wpdb->get_results("select * from {$wpdb->prefix}order_details where id_user={$id_user} and id_investor != 0 ");
            ?>
            <?php foreach ($all_installment as $item): ?>

                <?php



                ?>

                <div class="table-row">

                    <div><?php echo $item->id_order?></div>
                    <div><?php echo get_the_title($item->id_product)?></div>
                    <div>

                            <?php

                            $seller = get_post_field('post_author',$item->id_product);
                            $author = get_user_by('id', $seller);
                            $vendor = dokan()->vendor->get($seller);

                            $store_info = dokan_get_store_info($author->ID);
                            if (!empty($store_info['store_name'])) { ?>
                                <span class="details">
                        <?php printf(' <a href="%s">%s</a>', $vendor->get_shop_url(), $vendor->get_shop_name()); ?>
                    </span>
                                <?php
                            } ?>

                    </div>
                    <div><?php echo number_format($item->price_installment)?>تومان </div>
                    <div><?php echo $item->status==0 ? '<span>تکمیل نشده</span>' : '<span class="c-table-orders__payment-status--ok">تکمیل شده</span>' ?></div>

                    <div><?php echo $item->day_due?> هرماه </div>

                    <div>
                        <a href="<?php echo add_query_arg(['action' => 'show_list_installment', 'item' => $item->id]) ?>">
                            <span class="dashicons dashicons-visibility"></span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>