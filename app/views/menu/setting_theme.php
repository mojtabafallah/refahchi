<div class="wrap">
    <h1>تنظیمات قالب</h1>
    <form action="" method="post">
        <input type="hidden" value="0" name="vendor">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">لوگو سایت</th>
                <td>
                    <?php $logo = get_option('logo_site'); ?>
                    <img id="logo" src="<?php echo $logo?>" alt="">

                    <input type="text" name="url_logo" id="url_logo" value="<?php echo $logo?>">
                    <p href="#" id="select_logo"> انتخاب لوگو</p>
                </td>

            </tr>
            <tr valign="top">
                <th scope="row">آدرس شما</th>
                <td>
                    <?php $address = get_option('address'); ?>
                    <textarea name="address" id="" cols="30" rows="10"><?php echo $address?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">تلفن شما</th>
                <td>
                    <?php $tel = get_option('tel'); ?>
                    <input type="tel" name="tel" value="<?php echo $tel?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">توضیحات شما</th>
                <td>
                    <?php $description = get_option('description_site'); ?>
                    <?php wp_editor($description, 'content_editor_description'); ?>
                </td>
            </tr>


            <tr valign="top">
                <th scope="row"></th>
                <td>
                    <input type="submit" name="save_setting_theme" class="button" value="ذخیره تنظیمات">
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    jQuery(document).ready(function (e) {
        // e.preventDefault();
        jQuery('#select_logo').click(function () {
            console.log("srkj");
            var upload = wp.media({
                title: 'انتخاب لوگو برای سایت شما', //Title for Media Box
                multiple: false //For limiting multiple image
            })
                .on('select', function () {
                    var select = upload.state().get('selection');
                    var attach = select.first().toJSON();
                    console.log(attach.id); //the attachment id of image
                    console.log(attach.url); //url of image
                    jQuery('img#logo').attr('src', attach.url);
                    jQuery('input#url_logo').attr('value', attach.url);
                })
                .open();
        });

    });
</script>
