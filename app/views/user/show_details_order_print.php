<style>
    .body_report {
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

    @page {
        size: auto;
        margin: 0mm;
    }

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
include URI_THEME . "/app/jdf.php";
$allorders = wc_get_orders(array(
    'status' => 'wc-shipping-investor',
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

foreach ($allorders as $order) {
    $ord = wc_get_order($order);

    $array_final[] = $ord;

}


?>

<?php
global $wpdb;
$id_user = get_current_user_id();
$order_detail = $wpdb->get_row("select * from {$wpdb->prefix}order_details where id_investor={$id_user} and id={$_GET['item']}"); ?>

<div class="container body_report">
    <div class="print-site-info">
        <img src="<?php echo get_option("logo_site") ?>" style="width: 100px; height: 100px">

        <p> ???????? <?php echo get_bloginfo('name'); ?></p>
        <hr style="margin-top: 30px"/>
    </div>
    <div class="row">
        <div class="col-12 ">
            <h1>?????????? ??????????: <?php echo $order_detail->id ?></h1>
        </div>

    </div>

    <div class="factor-title">
        <p>
            <span>
                ?????????? ????????????:
            </span>
            <span>
                <?php echo $order_detail->id_order ?>
            </span>
        </p>

    </div>
    <ul class="factor-table" id="content">
        <li class="factor-table__row three-item">
            <p>
                <span>?????? ??????????????:</span>
                <span>
                    <?php


                    $user = get_userdata($order_detail->id_user);
                    if ($user) {
                        $author_id = get_post_field('post_author', $order_detail->id_product);
                        $display_name = get_the_author_meta('display_name', $author_id);
                        echo $display_name;
                    } else
                        echo "?????? ??????"

                    ?>
               </span>
            </p>
            <p>
                <span>?????? ????????????:</span>
                <span>
                    <?php
                    $user = get_userdata($order_detail->id_user);
                    if ($user)
                        echo get_the_title(get_user_by('id', $order_detail->id_user)->organ);
                    else
                        echo "?????? ??????"

                    ?>
               </span>
            </p>
            <p>
                <span>???? ?????? / ???? ????????????:</span>
                <span>
                    <?php

                    $user = get_userdata($order_detail->id_user);
                    if ($user)
                        echo get_user_by('id', $order_detail->id_user)->user_login;
                    else
                        echo "?????? ??????"

                    ?>
                </span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>?????????? ??????: </span>
                <span>
                      <?php echo $order_detail->id_order ?>
                </span>
            </p>
            <p>
                <span>???????? ???????? ????????????:</span>
                <span>
                    <?php echo number_format($order_detail->price_pish) ?> ??????????
                </span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>???????? ??????:</span>
                <span>
                    <?php echo number_format($order_detail->price_installment / $order_detail->num_month) ?> ??????????
                </span>
            </p>
            <p>
                <span>?????????? ???????? ??????????:</span>
                <span>
                    <?php echo number_format($order_detail->price_installment) ?> ??????????
                </span>
            </p>
        </li>
        <li class="factor-table__row two-item ">
            <p>
                <span>?????????? ??????????</span>
                <span>
                    <?php echo $order_detail->num_month ?> ??????
                 </span>
            </p>
            <p>
                <span>?????????? ????????</span>
                <span>
                    <?php
                    $installment_details = $wpdb->get_row("select * from {$wpdb->prefix}installments where id_order = {$order_detail->id_order}");
                    echo $installment_details->day;
                    ?>

                </span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>?????????? ?????????? ?????????? ?????? ???? ????????:</span>
                <span>
                  <?php

                  $installment_details1 = $wpdb->get_row("select count(id) as count1 from {$wpdb->prefix}installments where id_order = {$order_detail->id_order} and status =1");

                  echo $installment_details1->count1; ?> ??????
                  </span>
            </p>
            <p>
                <span>?????????? ?????????? ??????????:</span>
                <span>
                    <?php

                    $installment_details = $wpdb->get_row("select count(id) as count1 from {$wpdb->prefix}installments where id_order = {$order_detail->id_order} and status =0");

                    echo $installment_details->count1; ?> ??????
                  </span>
            </p>
            <p>
                <span>?????????? ???????????? ??????????:</span>
                <span>
                    <?php echo $order_detail->day_due ?>  ???? ??????
                  </span>
            </p>
        </li>
        <li class="factor-table__row two-item">
            <p>
                <span>???????? ?????????? ????????????:</span>
                <span>
                        <?php echo number_format(($order_detail->price_installment / $order_detail->num_month) * $installment_details1->count1) ?> ??????????
                    </span>
            </p>
            <p>
                <span>???????? ?????????? ??????????:</span>
                <span>
                        <?php echo number_format(($order_detail->price_installment / $order_detail->num_month) * $installment_details->count1) ?> ??????????
                    </span>
            </p>
        </li>
        <li class="factor-table__row two-item" >
            <p>
                <span>?????????? ?????????? ??????:</span>

            </p>
        </li>

        <?php

        $installment_details = $wpdb->get_results("select * from {$wpdb->prefix}installments where id_order = {$order_detail->id_order} and status =1");

        foreach ($installment_details as $intallment_item):?>
            <li class="factor-table__row two-item">
                <p>
                    <span>?????????? ??????:</span>
                    <span><?php    echo $intallment_item->id; ?></span>

                </p>
                <p>
                    <span>?????????? ??????:</span>
                    <span><?php    echo $intallment_item->number_doc; ?></span>

                </p>
                <p>
                    <span>??????????????:</span>
                    <span><?php    echo $intallment_item->description_pay; ?></span>

                </p>
                <p>
                    <span>?????????? ????????????:</span>
                    <span><?php    echo jdate( "Y-m-d", strtotime($intallment_item->day_pay)); ?></span>

                </p>

            </li>


        <?php endforeach;
        ?>


    </ul>

    <input id="print-btn" type="button" value="??????" onclick="printDiv()">

    <!--
  <div class="row ">
         <div class="col-6">
             <p>?????????? ??????????:<?php echo $order_detail->id_order ?> </p>
         </div>
         <div class="col-6">
             <p>?????????? ??????????:<?php echo $order_detail->id_product ?> </p>
         </div>
         <div class="col-12">
             <p>?????? ??????????: <?php echo get_the_title($order_detail->id_product) ?> </p>
             <p>?????????? ????????: <?php echo $order_detail->qty ?> </p>
             <p>?????? ????????????: <?php echo number_format($order_detail->price_pish) ?> ?????????? </p>
             <p>???????? ????????: <?php echo number_format($order_detail->price_installment) ?> ?????????? </p>
             <p>???????? ??????: <?php echo $order_detail->darsa_profit ?> % </p>
             <p>?????????? ??????????: <?php echo $order_detail->num_month ?> ?????? </p>
             <p>?????? ?? ?????? ???????????????? ????????????: <?php
    $user = get_userdata($order_detail->id_user);
    if ($user)
        echo get_user_by('id', $order_detail->id_user)->display_name;
    else
        echo "?????? ??????"
    ?>
             </p>

             <p>?????? ????????????:     <?php
    $user = get_userdata($order_detail->id_user);
    if ($user)
        echo get_the_title(get_user_by('id', $order_detail->id_user)->organ);
    else
        echo "?????? ??????"

    ?>  </p>
             <p>?????????? ?????????? ???????????? ??????
                 <?php
    $wpdb->get_results("select * from {$wpdb->prefix}installments where id_details={$order_detail->id} and status=1 ")
    ?>
                 <?php echo $order_detail->num_month ?> / <?php echo $wpdb->num_rows ?>
             </p>
             <p>???????? ???? ???????? ???????????? ??????: <?php echo number_format(($order_detail->price_installment / $order_detail->num_month) * $wpdb->num_rows) ?> ?????????? </p>
             <p>???????? ???????? ??????????: <?php echo number_format($order_detail->price_installment - (($order_detail->price_installment / $order_detail->num_month) * $wpdb->num_rows)) ?> ?????????? </p>




         </div>
     </div>

 -->


</div>

<script>
    function printDiv() {
        window.print()
//        var divContents = document.getElementById("content").innerHTML;
//        var a = window.open('', '', 'height=1000, width=1000');
//        a.document.write('<html  dir="rtl">');
//        a.document.write('<body > <h1>?????????? ???????????? ???????? ????????<br>');
//        a.document.write(divContents);
//        a.document.write('</body></html>');
//        a.document.close();
//        a.print();
    }
</script>
