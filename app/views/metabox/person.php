<div class="wrap">
    <h1>وارد کردن اطلاعات پرسنل</h1>
    <input type="text" name="excel_person" id="excel">
    <a href="#" id="excel-upload" class="button">انتخاب فایل اکسل</a>

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