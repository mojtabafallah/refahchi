<style>
    .body_report
    {
        text-align: center;
        background: white;
        border-radius: 32px;
        padding: 29px;
    }
    .factor-table {
        width: 100%;
        margin-top: 30px;
        font-size: 1rem !important;
        border-radius: 15px;
        box-shadow: 0px 0px 5px 1px #d5d5d5;
    }
    .factor-table li {
        padding: 15px;
    }
    .factor-table__row p span:last-child {
        color: gray
    }
    .factor-table li:nth-child(even) {
        background-color: #f1f1f1;
    }
    .factor-table li:nth-child(odd) {
        background-color: white !important;
    }
    .factor-table span {
        font-size: 1rem !important
    }
    .factor-table__row {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .three-item p {
        width: 35%;
        text-align: center;
    }
    .factor-title {
        display: flex;
        justify-content: center;
    }
    .factor-title p {
        margin: 0px 15px
    }
    #print-btn {
        width: 100px;
        height: 50px;
        background-color: #d2d0d0;
        font-size: 1rem !important;
        margin-top: 40px;
        cursor: pointer
    }
    .two-item p {
        width: 50%;
        text-align: center;
    }
    .print-site-info {
        display: none;
    }
    @page { size: auto;  margin: 0mm; }
    @media print {
        #adminmenuback, #adminmenuwrap {
            display: none;
        }
        #wpcontent, #wpfooter {
            margin-right: 0px !important;
        }
        .factor-table li {
            padding: 15px;
            border: 1px solid;
        }
        #print-btn {
            display: none;
        }
        #wpfooter {
            display: none;
        }
        .print-site-info {
            display: block;
            margin-bottom: 30px
        }
        .profile-page .o-page__aside {
            display: none;
        }
        .profile-page .o-page__content {
            flex: 100% !important
        }
        header {
            display: none;
        }
    }
</style>


<?php
global $wpdb;

$installment = $wpdb->get_row("select * from {$wpdb->prefix}installments where  id={$_GET['item']}");?>

<div class="container body_report">
    <div class="print-site-info">
        <img src="https://shop.mojtabafallah1.ir/wp-content/uploads/2021/06/lg.png" style="width: 100px; height: 100px" />
        <p>سایت فروشگاهی تک کالا</p>
        <hr style="margin-top: 30px"/>
    </div>
    <div class="row">
        <div class="col-12 ">
            <h1>شماره قسط: <?php echo $installment->id ?></h1>
        </div>

    </div>

    <div class="factor-title">
        <p>
            <span>
                شماره سفارش:
            </span>
            <span>
               <?php echo $installment->id_order ?>
            </span>
        </p>

    </div>
    <ul class="factor-table" id="content">
        <li class="factor-table__row three-item">
            <p>
                <span>نام فروشگاه:</span>
                <span>
                     <?php

                     $seller = get_post_field('post_author',$installment->id_product);
                     $author = get_user_by('id', $seller);
                     $vendor = dokan()->vendor->get($seller);

                     $store_info = dokan_get_store_info($author->ID);
                     if (!empty($store_info['store_name'])) { ?>
                         <span class="details">
                        <?php printf(' <a href="%s">%s</a>', $vendor->get_shop_url(), $vendor->get_shop_name()); ?>
                    </span>
                         <?php
                     } ?>
               </span>
            </p>
            <p>
                <span>نام سازمان:</span>
                <span>
                    <?php
                    $user = get_userdata($installment->id_user);
                    if ($user)
                        echo get_the_title(get_user_by('id', $installment->id_user)->organ);
                    else
                        echo "حذف شده"

                    ?>
               </span>
            </p>
            <p>
                <span>کد ملی / کد پرسنلی:</span>
                <span><?php echo get_user_by('id', $installment->id_user)->code_personnel; ?></span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>نام و نام خانوادگی خریدار: </span>
                <span><?php echo get_user_by('id', $installment->id_user)->display_name; ?></span>
            </p>
            <p>
                <span>مبلغ کل قسطی:</span>
                <span>
                    <?php

                    echo number_format($installment->total_price_installment) ?>تومان
                </span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>مبلغ قسط:</span>
                <span>
                  <?php echo number_format($installment->price_one_installment) ?>تومان
                </span>
            </p>
            <p>
                <span>نام محصول:</span>
                <span>
                    <?php echo get_the_title($installment->id_product) ?>
                </span>
            </p>
        </li>
        <li class="factor-table__row two-item ">
            <p>
                <span>تعداد</span>
                <span>
                    <?php

                    $order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id={$installment->id_details}");

                    ?>
                    <?php echo $order_detail->qty ?>
                 </span>
            </p>
            <p>
                <span>تاریخ پرداخت</span>
                <span>1400/6/21</span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>تعداد اقساط واریزی:</span>
                <span>
                        <?php
                        $aa = $wpdb->get_row("select count(id) as count_pay from {$wpdb->prefix}installments where id_details={$installment->id_details} and status=1 ");
                        echo $aa->count_pay; ?>
                  </span>
            </p>
            <p>
                <span>تعداد اقساط مانده:</span>
                <span>
                      <?php
                    echo $installment->num_installment -  $aa->count_pay;
                ?>
                  </span>
            </p>
            <p>
                <span>تاریخ سررسید:</span>
                <span>
                    <?php echo $installment->day ?>
                  </span>
            </p>
        </li>

    </ul>

    <input id="print-btn" type="button" value="چاپ" onclick="printDiv()">





</div>

<script>
    function printDiv() {
        window.print()
//        var divContents = document.getElementById("content").innerHTML;
//        var a = window.open('', '', 'height=1000, width=1000');
//        a.document.write('<html  dir="rtl">');
//        a.document.write('<body > <h1>گزارش جزئیات سفرش قسطی<br>');
//        a.document.write(divContents);
//        a.document.write('</body></html>');
//        a.document.close();
//        a.print();
    }
</script>
