<div class="warp">
    <h1>پرداخت اقساط بصورت جمعی</h1>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    انتخاب فایل اکسل
                </th>
                <td>
                    <input type="text" name="excel_pay" id="excel">
                    <a href="#" id="excel-upload" class="button">انتخاب فایل اکسل</a>

                </td>

            </tr>

            <tr valign="top">
                <th scope="row">

                </th>
                <td>
                    <input class="button button-primary" type="submit" name="btn_pay_excel" value="پرداخت">
                </td>

            </tr>

        </table>
    </form>


</div>

<script>
    jQuery(document).ready(function (e) {
        // e.preventDefault();
        jQuery('#excel-upload').click(function () {
            var upload = wp.media({
                title: 'انتخاب فایل اکسل پرسنل', //Title for Media Box
                multiple: false //For limiting multiple image
            })
                .on('select', function () {
                    var select = upload.state().get('selection');
                    var attach = select.first().toJSON();
                    console.log(attach.id); //the attachment id of image
                    console.log(attach.url); //url of image
                    jQuery('input#excel').attr('value', attach.url);
                })
                .open();
        });

    });
</script>