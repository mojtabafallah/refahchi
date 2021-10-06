<?php get_header('main') ?>


<article class="main-article">
    <!--<div class="main-slider">
        <a class="slide-item" href="#" target="_blank" style="background-image: url(assets/images/slider/slide9.jpg)"> </a>
    </div>-->
    <div id="mainslider" class="main-slider swiper-container">


        <div class="swiper-wrapper">

            <?php $products = new WP_Query(
                array(
                    'post_type' => array('post', 'product', 'page'),
                    'posts_per_page' => -1,
                )

            );
            if ($products->have_posts()):?>


                <?php while ($products->have_posts()):$products->the_post(); ?>

                    <?php if (get_post_meta(get_the_ID(), 'enable_slider', true) == "on"): ?>

                        <a href="<?php the_permalink(); ?>" target="_blank" class="slide-item swiper-slide"
                           style="background-image: url(<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>)"> </a>
                    <?php endif; ?>
                <?php endwhile;
                ?>
            <?php endif ?>

        </div>


        <div id="mslider-nbtn" class="swiper-button-next"></div>
        <div id="mslider-pbtn" class="swiper-button-prev"></div>
        <div class="swiper-pagination mainslider-btn"></div>
    </div>


    <aside class="c-adplacement">
        <?php


        if ($products->have_posts()): ?>
            <?php while ($products->have_posts()):

                $products->the_post();
                ?>
                <?php if (get_post_meta(get_the_ID(), 'enable_banner', true) == "on"):


                if (get_post_meta(get_the_ID(), 'position_banner', true) == 1): ?>
                    <a href="<?php the_permalink(); ?>"><img
                                src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
                <?php endif ?>


                <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 2): ?>
                <a href="<?php the_permalink(); ?>"><img
                            src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
            <?php endif ?>


            <?php endif ?>
            <?php endwhile; ?>
        <?php endif; ?>


    </aside>


</article>
<div class="clear"></div>

<?php
global $product;
$special = new WP_Query([
    'post_type' => "product",
    'posts_per_page' => "-1",
    'meta_query' => WC()->query->get_meta_query(),
    'post__in' => array_merge(array(0), wc_get_product_ids_on_sale())
]);
if ($special->have_posts()): ?>

    <div class="c-swiper-specials--incredible">
        <section class="icontainer">
            <a href="#" class="specials__title">
                <img src="<?php echo URL_THEME ?>/assets/images/d9b15d68.png" alt="پیشنهاد شگفت‌انگیز">
                <div class="specials__btn">مشاهده همه</div>
            </a>
            <div class="swiper--specials">
                <div id="inc-slider" class="swiper-container">
                    <div class="product-box swiper-wrapper">


                        <?php while ($special->have_posts()): $special->the_post(); ?>


                            <?php if ($product->is_on_sale()): ?>


                                <div class="product-item swiper-slide">
                                    <a href="<?php the_permalink(); ?>"><img
                                                src="<?php echo get_the_post_thumbnail_url() ?>" alt=""></a>
                                    <a class="title" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                                    <div class="inc-product-price">
                                        <del><?php echo number_format($product->get_regular_price()) ?>تومان</del>
                                        <div class="c-price__discount-oval"><span>
                                                <?php
                                                $a = 100 - (100 * $product->get_sale_price()) / $product->get_regular_price();
                                                echo intval($a); ?>
                                                ٪</span></div>
                                        <span class="price"><?php echo number_format($product->get_price()); ?> </span>تومان
                                    </div>
                                    <?php if ($product->get_date_on_sale_from()): ?>
                                        <div class="c-product-box__amazing">
                                            <?php
                                            $date_to = $product->get_date_on_sale_to();

                                            $date_to = date('Y/m/d h:i:s', strtotime($date_to));


                                            ?>
                                            <div class="c-product-box__timer" data-countdown="<?php echo $date_to ?>">
                                                ۱۲:۵۲:۳۹
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div><!--item-->


                            <?php endif; ?>


                        <?php endwhile; ?>


                    </div>
                </div>
        </section>
    </div>
<?php endif; ?>

<section class="image-row container">


    <?php if ($products->have_posts()): ?>
        <?php while ($products->have_posts()):
            $products->the_post(); ?>
            <?php if (get_post_meta(get_the_ID(), 'enable_banner', true) == "on"):


            if (get_post_meta(get_the_ID(), 'position_banner', true) == 3):?>
                <a href="<?php the_permalink(); ?>"><img
                            src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
            <?php endif ?>


            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 4): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>

            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 5): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>

            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 6): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>


        <?php endif ?>
        <?php endwhile; ?>
    <?php endif; ?>

</section>


<div class="c-swiper-specials--incredible c-swiper-specials--fresh">
    <section class="icontainer">
        <a href="#" class="specials__title">
            <img src="<?php echo URL_THEME ?>/assets/images/8af90c4b.png" alt="پیشنهاد شگفت‌انگیز1">
            <div class="specials__btn">مشاهده همه</div>
        </a>
        <div class="swiper--specials">
            <div id="sp-slider" class="swiper-container">
                <div class="product-box swiper-wrapper">
                    <?php $tax_query[] = array(
                        'taxonomy' => 'product_visibility',
                        'field' => 'name',
                        'terms' => 'featured',
                        'operator' => 'IN', // or 'NOT IN' to exclude feature products
                    );
                    $featured_query = new WP_Query(array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'posts_per_page' => 10,
                        'order' => 'desc',
                        'tax_query' => $tax_query // <===
                    ));


                    if ($featured_query->have_posts()) :

                        while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                            <div class="product-item swiper-slide">
                                <a href="<?php the_permalink(); ?>"><img
                                            src="<?php echo get_the_post_thumbnail_url() ?>"
                                            alt=""></a>
                                <a class="title" href="<?php the_permalink(); ?>"><?php the_title() ?></a>

                                <?php if ($product->is_on_sale()): ?>
                                    <div class="inc-product-price">
                                        <del><?php echo number_format($product->get_regular_price()) ?>تومان</del>
                                        <div class="c-price__discount-oval"><span>
                                                <?php
                                                $a = 100 - (100 * $product->get_sale_price()) / $product->get_regular_price();
                                                echo intval($a); ?>
                                                ٪</span></div>
                                        <span class="price"><?php echo number_format($product->get_price()); ?> </span>تومان
                                    </div>
                                    <?php if ($product->get_date_on_sale_from()): ?>
                                        <div class="c-product-box__amazing">
                                            <?php
                                            $date_to = $product->get_date_on_sale_to();

                                            $date_to = date('Y/m/d h:i:s', strtotime($date_to));


                                            ?>
                                            <div class="c-product-box__timer" data-countdown="<?php echo $date_to ?>">
                                                ۱۲:۵۲:۳۹
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="inc-product-price">
                                        <span class="price"><?php echo number_format($product->get_price()) ?></span>
                                        تومان
                                    </div>
                                <?php endif; ?>


                            </div><!--item-->
                        <?php endwhile;

                    else:
                        echo "no product";


                    endif; ?>


                </div>
            </div>
    </section>
</div>


<section class="product-wrapper container">
    <div class="headline">
        <h3>آخرین مقالات</h3></div>
    <?php

    $last_post = new WP_Query([
        'type_post' => 'post',
        'pots_per_page' => 10,
        'orderby' => "date",
        'order' => "desc"
    ])

    ?>
    <div id="pslider" class="swiper-container">
        <div class="product-box swiper-wrapper">

            <?php
            if ($last_post->have_posts()):
                while ($last_post->have_posts()) :
                    $last_post->the_post();
                    ?>
                    <div class="product-item swiper-slide">
                        <a href="<?php the_permalink() ?>"><img src="<?php echo get_the_post_thumbnail_url() ?>" alt=""></a>
                        <a class="title" href="<?php the_permalink() ?>"><?php the_title(); ?></a> <span
                                class="price"> </span>
                    </div>

                <?php
                endwhile;
            endif;
            ?>


        </div>
        <div id="pslider-nbtn" class="slider-nbtn swiper-button-next"></div>
        <div id="pslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
    </div>

</section>
<section class="image-row container">
    <?php if ($products->have_posts()): ?>
        <?php while ($products->have_posts()):
            $products->the_post(); ?>
            <?php if (get_post_meta(get_the_ID(), 'enable_banner', true) == "on"):


            if (get_post_meta(get_the_ID(), 'position_banner', true) == 7):?>
                <a href="<?php the_permalink(); ?>"><img
                            src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
            <?php endif ?>


            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 8): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>

            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 9): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>

            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 10): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>


        <?php endif ?>
        <?php endwhile; ?>
    <?php endif; ?>
    <!--    <a href="#"><img src="--><?php //echo URL_THEME ?><!--/assets/images/1000005395.jpg" alt=""></a>-->
    <!--    <a href="#"><img src="--><?php //echo URL_THEME ?><!--/assets/images/1000019673.jpg" alt=""></a>-->
    <!--    <a href="#"><img src="--><?php //echo URL_THEME ?><!--/assets/images/1000009159.jpg" alt=""></a>-->
    <!--    <a href="#"><img src="--><?php //echo URL_THEME ?><!--/assets/images/1816.jpg" alt=""></a>-->
</section>
<section class="product-wrapper container">
    <div class="headline">
        <h3>محصولات پربازدید اخیر</h3></div>
    <div id="vpslider" class="swiper-container">

        <div class="product-box swiper-wrapper">
            <?php

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'meta_key' => 'post_views_count',

                'ignore_sticky_posts' => 1,
                'posts_per_page' => '12'

            );


            $the_query = new WP_Query($args); ?>

            <?php if ($the_query->have_posts()) : ?>

                <?php while ($the_query->have_posts()) :
                    $the_query->the_post(); ?>
                    <div class="product-item swiper-slide">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
                        </a>
                        <a class="title" href="<?php the_permalink(); ?>"><?php the_title() ?> </a>
                        <span class="price"><?php echo number_format($product->get_price()) ?> تومان</span>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>

        <div id="vpslider-nbtn" class="slider-nbtn swiper-button-next"></div>
        <div id="vpslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
    </div>
</section>

<section class="image-row container">
    <?php if ($products->have_posts()): ?>
        <?php while ($products->have_posts()):
            $products->the_post(); ?>
            <?php if (get_post_meta(get_the_ID(), 'enable_banner', true) == "on"):


            if (get_post_meta(get_the_ID(), 'position_banner', true) == 11):?>
                <a href="<?php the_permalink(); ?>"><img
                            src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
            <?php endif ?>

        <?php endif ?>
        <?php endwhile; ?>
    <?php endif; ?>
</section>


<section class="product-wrapper container">
    <div class="headline two-headline">
        <h3>منتخب جدیدترین کالاها</h3> <a href="#">مشاهده همه</a></div>
    <div id="newpslider" class="swiper-container">
        <div class="product-box swiper-wrapper">

            <?php $new_product = new WP_Query(
                [
                    'post_type' => 'product',
                    'post_per_page' => 10,
                    'orderby' => 'date',
                    'order' => 'desc'

                ]
            ) ?>

            <?php if ($new_product->have_posts()): ?>
                <?php while ($new_product->have_posts()): $new_product->the_post();
                    global $product; ?>
                    <div class="product-item swiper-slide">
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url() ?>"
                                                                 alt=""></a> <a class="title"
                                                                                href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        <?php if ($product->get_price()): ?>
                            <span class="price"><?php echo number_format($product->get_price()) ?> تومان </span>
                        <?php endif; ?>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                محصولی یافت نشد.
            <?php endif; ?>


        </div>
        <div id="newpslider-nbtn" class="slider-nbtn swiper-button-next"></div>
        <div id="newpslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
    </div>
</section>

<?php
$args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 10,
);
$best_sell = new WP_Query($args);
?>


<section class="product-wrapper container">
    <div class="headline">
        <h3>محصولات پرفروش</h3></div>
    <div id="mostpslider" class="swiper-container">
        <div class="product-box swiper-wrapper">
            <?php if ($best_sell->have_posts()): ?>
                <?php while ($best_sell->have_posts()): $best_sell->the_post();
                    global $product; ?>
                    <div class="product-item swiper-slide">
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url() ?>"
                                                                 alt=""></a> <a class="title"
                                                                                href="<?php the_permalink(); ?>"><?php the_title() ?>
                        </a> <span class="price"><?php echo number_format($product->get_price()) ?> تومان</span></div>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div id="mostpslider-nbtn" class="slider-nbtn swiper-button-next"></div>
        <div id="mostpslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
    </div>
</section>
<section class="image-row container">
    <?php
    if ($products->have_posts()): ?>
        <?php while ($products->have_posts()):

            $products->the_post();
            ?>
            <?php if (get_post_meta(get_the_ID(), 'enable_banner', true) == "on"):


            if (get_post_meta(get_the_ID(), 'position_banner', true) == 12): ?>
                <a href="<?php the_permalink(); ?>"><img
                            src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
            <?php endif ?>


            <?php if (get_post_meta(get_the_ID(), 'position_banner', true) == 13): ?>
            <a href="<?php the_permalink(); ?>"><img
                        src="<?php echo get_post_meta(get_the_ID(), 'image_slider_banner', true) ?>" alt=""></a>
        <?php endif ?>


        <?php endif ?>
        <?php endwhile; ?>
    <?php endif; ?>

</section>
<section class="product-wrapper container">
    <div class="headline">
        <h3>برندهای ویژه</h3></div>
    <div id="brandslider" class="swiper-container">
        <div class="product-box swiper-wrapper">

            <?php

            $terms = get_terms(array(
                'taxonomy' => 'brand',
                'hide_empty' => false,
            ));


            foreach ($terms as $term) {
                $termid = $term->term_id;
                $imgbrand = get_option("img_$termid");
                if ($imgbrand) {
                    ?>
                    <div class="product-item swiper-slide">
                        <a href="brand/<?php echo $term->slug ?>"><img src="<?php echo $imgbrand ?>" alt=""></a>
                    </div>
                    <?php

                }
            }

            ?>


        </div>
        <div id="brandslider-nbtn" class="slider-nbtn swiper-button-next"></div>
        <div id="brandslider-pbtn" class="slider-pbtn swiper-button-prev"></div>
    </div>
</section>

<?php get_footer() ?>
