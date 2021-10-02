<?php
defined('ABSPATH') || exit;
include URI_THEME . "/app/jdf.php";?>
<div class="o-page__content">

    <div class="o-headline o-headline--profile"><span>لیست کالاهای درخواستی </span></div>
    <div class="c-table-orders">
        <div class="c-table-orders__head--highlighted">

            <div>آیدی</div>
            <div>نام محصول</div>
            <div>توضیحات</div>
            <div>دسته بندی</div>
            <div>توضیحات</div>
            <div>وضعیت</div>
        </div>
        <div class="c-table-orders__body">
            <?php global $wpdb;
            $id_user = get_current_user_id();

            $product_request = $wpdb->get_results("select * from {$wpdb->prefix}request_product where id_user={$id_user}");
            ?>
            <?php foreach ($product_request as $item): ?>


                <div class="table-row">
                    <div><?php echo $item->id?></div>
                    <div><?php echo $item->name_product?></div>
                    <div><?php echo get_the_category_by_ID( $item->id_category);  ?></div>
                    <div>
                        <?php echo $item->description?>



                    </div>
                    <div>
                        <?php if ($item->status==0) echo "بررسی نشده"?>
                        <?php if ($item->status==1) echo "در فروشگاه قرار گرفت"?>
                        <?php if ($item->status==2) echo "امکان قرار گرفتن کالا در فروشگاه وجود ندارد"?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>