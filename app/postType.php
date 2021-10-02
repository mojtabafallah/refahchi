<?php


namespace app;


class postType
{

    public static function organ_init()
    {
        $labels = array(
            'name' => _x('سازمان ها', 'Post type general name', 'textdomain'),
            'singular_name' => _x('سازمان', 'Post type singular name', 'textdomain'),
            'menu_name' => _x('سازمان ها', 'Admin Menu text', 'textdomain'),
            'name_admin_bar' => _x('سازمان', 'Add New on Toolbar', 'textdomain'),
            'add_new' => __('افزودن جدید', 'textdomain'),
            'add_new_item' => __('افزودن سازمان جدید', 'textdomain'),
            'new_item' => __('سازمان جدید', 'textdomain'),
            'edit_item' => __('ویرایش سازمان', 'textdomain'),
            'view_item' => __('نمایش سازمان', 'textdomain'),
            'all_items' => __('همه سازمان ها', 'textdomain'),
            'search_items' => __('جستجو سازمان', 'textdomain'),
            'parent_item_colon' => __('سازمان مادر:', 'textdomain'),
            'not_found' => __('سازمانی پیدا نشد.', 'textdomain'),
            'not_found_in_trash' => __('سازمانی در سطل زباله پیدا نشد.', 'textdomain'),
            'featured_image' => _x('عکس سازمان', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
            'set_featured_image' => _x('تنظیم عکس سازمان', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'remove_featured_image' => _x('حذف عکس سازمان', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'use_featured_image' => _x('استفاده از یک عکس', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
            'archives' => _x('آرشیو سازمان', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
            'insert_into_item' => _x('قرار دادن در سازمان', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
            'uploaded_to_this_item' => _x('آپلود در این سازمان', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
            'filter_items_list' => _x('فیلتر لیست سازمان ها', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
            'items_list_navigation' => _x('پیمایش لیست سازمان', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
            'items_list' => _x('لیست سازمان ها', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'organization'),

            "map_meta_cap" => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 1,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('organization', $args);
    }

}