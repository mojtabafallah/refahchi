<div class="row">
    <div class="col-12">
        <img width="100" src="<?php  echo get_post_meta($post->ID, 'image_slider_banner',true) ?>" id="img-src" >
        <a href="#" id="img-upload">افزودن عکس</a><br>
    </div>
</div>

<input type="hidden" name="image_slider" id="img" value="<?php  echo get_post_meta($post->ID, 'image_slider_banner',true) ?>">
<label for="slider_check">فعال بودن در اسلایدر</label>
<input class="form-field" type="checkbox" name="slider_check"
       id="slider_check" <?php  echo get_post_meta($post->ID, 'enable_slider',true) == "on" ? "checked" : '' ?>>
<label for="banner_check">فعال بودن در بنر</label>


<input type="checkbox" name="banner_check" id="banner_check"  <?php  echo get_post_meta($post->ID, 'enable_banner',true) == "on" ? "checked" : '' ?>>

<select name="position_banner" id="position_banner">
    <option value="1"<?php if(get_post_meta($post->ID,'position_banner',true)==1) echo "selected"?>>بالا کنار اسلایدر 1</option>
    <option value="2"<?php if(get_post_meta($post->ID,'position_banner',true)==2) echo "selected"?>>بالا کنار اسلایدر 2</option>
    <option value="3"<?php if(get_post_meta($post->ID,'position_banner',true)==3) echo "selected"?>>قسمت اول (1)</option>
    <option value="4"<?php if(get_post_meta($post->ID,'position_banner',true)==4) echo "selected"?>>قسمت اول (2)</option>
    <option value="5"<?php if(get_post_meta($post->ID,'position_banner',true)==5) echo "selected"?>>قسمت اول (3)</option>
    <option value="6"<?php if(get_post_meta($post->ID,'position_banner',true)==6) echo "selected"?>>قسمت اول (4)</option>
    <option value="7"<?php if(get_post_meta($post->ID,'position_banner',true)==7) echo "selected"?>>قسمت دوم (1)</option>
    <option value="8"<?php if(get_post_meta($post->ID,'position_banner',true)==8) echo "selected"?>>قسمت دوم (2)</option>
    <option value="9"<?php if(get_post_meta($post->ID,'position_banner',true)==9) echo "selected"?>>قسمت دوم (3)</option>
    <option value="10"<?php if(get_post_meta($post->ID,'position_banner',true)==10) echo "selected"?>>قسمت دوم (4)</option>
    <option value="11"<?php if(get_post_meta($post->ID,'position_banner',true)==11) echo "selected"?>>قسمت سوم</option>
    <option value="12"<?php if(get_post_meta($post->ID,'position_banner',true)==12) echo "selected"?>>قسمت چهارم (1)</option>
    <option value="13"<?php if(get_post_meta($post->ID,'position_banner',true)==13) echo "selected"?>>قسمت چهارم (2)</option>

</select>



<script>
    jQuery(document).ready(function (e) {
        // e.preventDefault();
        jQuery('#img-upload').click(function () {
            var upload = wp.media({
                title: 'انتخاب عکس برای بنر و اسلایدر', //Title for Media Box
                multiple: false //For limiting multiple image
            })
                .on('select', function () {
                    var select = upload.state().get('selection');
                    var attach = select.first().toJSON();
                    console.log(attach.id); //the attachment id of image
                    console.log(attach.url); //url of image
                    jQuery('img#img-src').attr('src', attach.url);
                    jQuery('input#img').attr('value', attach.url);
                })
                .open();
        });

    });
</script>