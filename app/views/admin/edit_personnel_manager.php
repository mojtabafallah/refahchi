<div class="wrap">

    <h1>ویرایش پرسنل</h1><span><?php echo $user->first_name?></span> <span><?php echo $user->last_name?></span>

    <form action="" method="post">
        <table class="form-table">

            <tr valign="top">
                <th scope="row">
                    کد ملی
                </th>
                <td>
                    <label>

                        <input type="text" readonly name="code_melli" value="<?php echo $user->user_login ?>">
                        نکته: نام کاربری و کلمه عبور برای ورود به سامانه کد ملی می باشد
                    </label>
                </td>

            </tr>
            <tr valign="top">
                <th scope="row">
                    کد پرسنلی
                </th>
                <td>
                    <input type="text" name="code_personnel" value="<?php echo $user->code_personnel ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    نام
                </th>
                <td>
                    <input type="text" name="name" value="<?php echo $user->first_name ?>">
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">
                    نام خانوادگی
                </th>
                <td>
                    <input type="text" name="family" value="<?php echo $user->last_name ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    تلفن همراه
                </th>
                <td>
                    <input type="number" name="mobile" value="<?php echo $user->mobile ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    رمز اعتبار
                </th>
                <td>
                    <input type="text" name="credit_password" value="<?php echo $user->credit_password ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    انسداد
                </th>
                <td>
                    <input type="checkbox" name="obstruction" <?php echo $user->obstruction == 1 ? "checked" : "" ?>>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    دلیل انسداد
                </th>
                <td>
                    <textarea name="obstruction_description" id="" cols="50"
                              rows="5"><?php echo $user->obstruction_description ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    شماره نامه انسداد
                </th>
                <td>
                    <input type="text" name="obstruction_number" value="<?php echo $user->obstruction_number ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    نام بانک
                </th>
                <td>
                    <input type="text" name="name_bank" value="<?php echo $user->name_bank ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    شماره حساب
                </th>
                <td>
                    <input type="text" name="account_number" value="<?php echo $user->account_number ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    شماره کارت
                </th>
                <td>
                    <input type="text" name="cart_number" value="<?php echo $user->cart_number ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    شماره شبای بانکی
                </th>
                <td>
                    <input type="text" name="sheba_number" value="<?php echo $user->sheba_number ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    شعبه بانک
                </th>
                <td>
                    <input type="text" name="branch_bank_name" value="<?php echo $user->branch_bank_name ?>">
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">
                    سمت
                </th>
                <td>
                    <input type="text" name="position_job" value="<?php echo $user->position_job?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    واحد سازمانی
                </th>
                <td>
                    <input type="text" name="organ_unit" value="<?php echo $user->organ_unit?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                   اعتبار فعلی
                </th>
                <td>
                    <?php echo $user->_current_woo_wallet_balance != null ? number_format($user->_current_woo_wallet_balance) . " تومان " : 0 ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                   افزایش اعتبار
                </th>
                <td>
                    <input type="text" name="add_wallet">
              
                </td>

            </tr>
            <tr valign="top">
                <th scope="row">
                    توضیحات افزایش اعتبار
                </th>
                <td>
                    <textarea name="add_wallet_description" id="" cols="30" rows="10"></textarea>

                </td>

            </tr>
            <tr valign="top">
                <th scope="row">
                    کاهش اعتبار
                </th>
                <td>
                    <input type="text" name="sub_wallet">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    توضیحات کاهش اعتبار
                </th>
                <td>
                    <textarea name="sub_wallet_description" id="" cols="30" rows="10"></textarea>

                </td>

            </tr>
            <tr valign="top">
                <th scope="row">
                    میزان سقف خرید ماهانه
                </th>
                <td>
                    <input type="text" name="max_month" value="<?php echo $user->max_in_month?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">

                </th>
                <td>
                    <button type="submit" name="edit_personnel" class="button">ویرایش</button>

                </td>
            </tr>



        </table>
    </form>
</div>
