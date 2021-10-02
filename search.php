<?php get_header() ?>
<?php $products = new WP_Query(
    [
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $_GET['s']
    ]
) ?>
    <section class="search container">

        <div class="o-page__content">
            <article>
                <nav>
                    <ul class="c-breadcrumb">
                        <li><span> <?php echo get_bloginfo( 'name' );?></span></li>
                        <li><span><?php echo wp_count_posts('product')->publish ?>  کالا</span></li>
                    </ul>
                </nav>
                <div class="c-listing">
                    <div class="c-listing__header">
                        <ul class="c-listing__sort" data-label="مرتب‌سازی بر اساس :">
                            <li><span>مرتب سازی بر اساس :</span></li>
                            <li><a href="#" class="is-active">پربازدیدترین</a></li>
                            <li><a href="#">محبوب ترین</a></li>
                            <li><a href="#">جدیدترین</a></li>
                            <li><a href="#">پرفروش ترین</a></li>
                            <li><a href="#">ارزان ترین</a></li>
                            <li><a href="#">گران ترین</a></li>
                        </ul>
                        <ul class="c-listing__type">
                            <li>
                                <button><i class="fa fa-bars"></i></button>
                            </li>
                            <li>
                                <button class="is-active"><i class="fa fa-grip-horizontal"></i></button>
                            </li>
                        </ul>
                    </div>
                    <ul class="c-listing__items">

                        <?php if ($products->have_posts()): ?>
                            <?php while ($products->have_posts()): $products->the_post();
                                global $product; ?>
                                <li>
                                    <div class="c-product-box c-promotion-box ">

                                        <a href="<?php the_permalink(); ?>"
                                           class="c-product-box__img c-promotion-box__image"><img
                                                    src="<?php the_post_thumbnail_url('shop_catalog'); ?>"
                                                    alt="<?php the_title() ?>"></a>
                                        <div class="c-product-box__content">
                                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title() ?></a>
                                            <?php if ($product->get_price()): ?>
                                                <?php if ($product->is_on_sale()): ?>


                                                        <span style="color: red"
                                                              class="price"> قیمت ویژه <?php echo number_format($product->get_sale_price() )?> تومان </span>
                                                        <del class="price"> قیمت نقدی <?php echo number_format($product->get_regular_price() )?>
                                                            تومان
                                                        </del>
<!--                                                    --><?php //$price_install = get_post_meta(get_the_ID(), 'installment_price', true) ?>
<!--                                                    --><?php //if (!empty($price_install)): ?>
<!--                                                        <span class="price">قیمت قسطی --><?php //echo $price_install ?><!-- تومان </span>-->
<!--                                                    --><?php //endif; ?>
                                                <?php else: ?>
                                                    <span class="price"> قیمت نقدی <?php echo number_format($product->get_regular_price()) ?>
                                                        تومان
                                                    </span>
                                                    <?php $price_install = get_post_meta(get_the_ID(), 'installment_price', true) ?>
                                                    <?php if (!empty($price_install)): ?>
                                                        <span class="price">قیمت قسطی <?php echo $price_install ?> تومان </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="price">نا موجود</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="c-product-box__tags">
                                            <span class="c-tag c-tag--rate">۳.۹</span>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>محصولی یافت نشد</p>
                        <?php endif; ?>


                    </ul>
                    <div class="c-pager">
                        <ul class="c-pager__items">
                            <li><a class="c-pager__item is-active" href="#">1</a></li>
                            <li><a class="c-pager__item" href="#">2</a></li>
                            <li><a class="c-pager__item" href="#">3</a></li>
                            <li><a class="c-pager__item" href="#">4</a></li>
                            <li><a class="c-pager__item" href="#">>></a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
    </section>

<?php get_footer() ?>