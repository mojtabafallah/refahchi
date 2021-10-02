<?php
global $wpdb;
$plan = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}plans WHERE id={$_GET['item']}");
$all_vendor = get_users(['dokan_enable_selling' => 'yes', 'role' => 'seller']);
?>
<div class="wrap">
    <h1>ویرایش پلن</h1>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">شناسه</th>
                <td>
                    <input type="text" name="id" readonly value="<?php echo $plan->id ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">میزان پیش پرداخت</th>
                <td>
                    <input type="number" name="pishe_darsad" value="<?php echo $plan->pishe_darsad ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">تعداد قسط</th>
                <td>
                    <input type="number" name="num_month" value="<?php echo $plan->num_month ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">درصد سود</th>
                <td>
                    <input type="number" step="any" name="darsad_profit" value="<?php echo $plan->darsad_profit ?>">
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">فروشنده</th>
                <td>
                    <select name="vendor" id="vendor">
                        <?php foreach ($all_vendor as $vendor): ?>
                            <option value="<?php echo $vendor->ID ?>" <?php echo $vendor->ID == $plan->id_vendor ? "selected" : "" ?> ><?php echo $vendor->display_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">روز سر رسید</th>
                <td>
                    <select name="day" id="day">
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i ?>" <?php echo $i == $plan->due_date ? "selected" : "" ?>><?php echo $i ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">فعال</th>
                <td>
                    <input type="checkbox" value="فعال"
                           name="is_active" <?php echo $plan->is_active ? "checked" : "" ?>>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">حذف شده</th>
                <td>
                    <input type="checkbox" value="حذف شده"
                           name="is_remove" <?php echo $plan->is_remove ? "checked" : "" ?>>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"></th>
                <td>
                    <input type="submit" name="edit_plan" class="button" value="ویرایش">
                </td>
            </tr>
        </table>
    </form>
</div>
