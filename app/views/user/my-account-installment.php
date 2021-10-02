<?php
defined('ABSPATH') || exit;
include URI_THEME . "/app/jdf.php";?>
<div class="o-page__content">

    <div class="o-headline o-headline--profile"><span>لیست اقساط شما </span></div>
    <div class="c-table-orders">
        <div class="c-table-orders__head--highlighted">

            <div>شماره قسط</div>
            <div>شماره سفارش</div>
            <div>محصول</div>
            <div>نام فروشگاه</div>
            <div>مبلغ قسط</div>
            <div>وضعیت</div>
            <div>تاریخ سر رسید</div>
            <div>تاریخ پرداخت</div>
        </div>
        <div class="c-table-orders__body">
            <?php global $wpdb;
            $id_user = get_current_user_id();

            $all_installment = $wpdb->get_results("select * from {$wpdb->prefix}installments where id_user={$id_user} and id_details = {$_GET['item']}");
            ?>
            <?php foreach ($all_installment as $item): ?>

            <?php



                ?>

                <div class="table-row">
                    <div><?php echo $item->id?></div>
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
                    <div><?php echo number_format($item->price_one_installment)?>تومان </div>
                    <div><?php echo $item->status==0 ? '<span>پرداخت نشده</span>' : '<span class="c-table-orders__payment-status--ok">پرداخت شده</span>' ?></div>

                    <div><?php echo $item->day?></div>
                    <div><?php if ($item->day_pay) echo jdate("Y/n/d",strtotime($item->day_pay)) ?> </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>