<?php /* Template Name: Request product */ ?>
<?php get_header();
     $isFormValidate = true;
     $isFormSubmit = false;?>

<?php if (isset($_POST['btn_product_save']))
{
    if (isset($_POST['name_product'] )&& isset($_POST['category']))
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix."request_product",
            [
                'id_user'=>get_current_user_id(),
                'name_product'=>$_POST['name_product'],
                'id_category'=>$_POST['category'],
                'description'=>$_POST['description_product']

            ]
        );
        $isFormSubmit = true;
    } else {
        $isFormValidate = false;
    }
}?>

   <h1 class="request-form-title alert alert-info">فرم درخواست سفارش کالا</h1>

    <div class="request-form container">



        <?php if (is_user_logged_in()): ?>


            <?php
                echo !$isFormValidate ?  '<h1 class="request-form-title alert alert-error">برخی از مقادیر ناقص میباشد!</h1>' : '' ;
                echo  $isFormSubmit ?  '<h1 class="request-form-title alert alert-success">درخواست شما با موفقیت ثبت شد</h1>' : '';
             ?>

            <form action="" id="request_form" method="post">
                <div class="request-form__form-group-radio">
                    <h3 class="request-form__form-group-radio__title">نوع محصول را انتخاب کنید</h3>
                    <hr>

                    <div class="request-form__form-group-radio__form-container">
                        <?php

                        $taxonomy = 'product_cat';
                        $orderby = 'name';
                        $show_count = 0;      // 1 for yes, 0 for no
                        $pad_counts = 0;      // 1 for yes, 0 for no
                        $hierarchical = 1;      // 1 for yes, 0 for no
                        $title = '';
                        $empty = 0;

                        $args = array(
                            'taxonomy' => $taxonomy,
                            'orderby' => $orderby,
                            'show_count' => $show_count,
                            'pad_counts' => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li' => $title,
                            'hide_empty' => $empty
                        );
                        $all_categories = get_categories($args);
                        foreach ($all_categories as $cat) {
                            if ($cat->category_parent == 0) {

                                $category_id = $cat->term_id;
                                echo '<div class="radio-container"><span>'.$cat->name.'</span> <input type="radio" name="category" value="'.$cat->term_id.'"></div>';

                                $args2 = array(
                                    'taxonomy' => $taxonomy,
                                    'child_of' => 0,
                                    'parent' => $category_id,
                                    'orderby' => $orderby,
                                    'show_count' => $show_count,
                                    'pad_counts' => $pad_counts,
                                    'hierarchical' => $hierarchical,
                                    'title_li' => $title,
                                    'hide_empty' => $empty
                                );
                                $sub_cats = get_categories($args2);
                                if ($sub_cats) {
                                    foreach ($sub_cats as $sub_category) {
                                        echo $sub_category->name;
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="request-form__product-name">
                    <h3 class="request-form__product-name__title">نام محصول را وارد کنید</h3>
                    <hr>
                    <input placeholder="نام محصول" class="request-form__product-name__input" type="text" name="name_product" id="name_product">
                </div>
                <div class="request-form__product-name">
                    <h3 class="request-form__product-name__title">توضیحات را وارد کنید</h3>
                    <hr>
                    <textarea  class="request-form__product-name__input"  name="description_product" id="name_product"> </textarea>
                </div>
                <button type="submit" class="request-form-submit" name="btn_product_save">ثبت درخواست</button>
            </form>
        <?php else:?>
        <div class="form-login-request-container">
            <p class="form-login-request">
                 برای درخواست کالای قسطی باید حتما </p>
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">وارد شوید </a>
        </div>


        <?php endif ?>
    </div>

<?php get_footer() ?>

