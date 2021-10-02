<?php
global $wpdb;
$installment=$wpdb->get_row("select * from {$wpdb->prefix}installments where id={$_GET['item']}")
?>
<div class="wrap">
    <h1>پرداخت قسط شماره <?php echo $_GET['item']?></h1>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">شناسه</th>
                <td>
                    <input type="text" name="id" readonly value="<?php echo $installment->id ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">توضیحات پرداخت</th>
                <td>
                    <textarea name="description_pay" id="description_pay" cols="30" rows="10"></textarea>

                </td>
            </tr>

            <tr valign="top">
                <th scope="row">شماره سند پرداخت</th>
                <td>
                    <input type="number" name="number_doc_pay" >
                </td>
            </tr>




            <tr valign="top">
                <th scope="row"></th>
                <td>
                    <input type="submit" name="btn_pay" class="button" value="پرداخت">
                </td>
            </tr>
        </table>
    </form>
</div>
