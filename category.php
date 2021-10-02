<?php get_header('blog') ?>
<div class="container-fluid">
    <div class="col-12">
        <div class="col-12 col-md-12 col-lg-4 col-xl-3">
            <div class="latest_article">
                <div class="article_custome">
                    <h4 class="latest_article_title">اخرین مقالات</h4>
                    <?php $last_post = new WP_Query([
                        'post_type' => array('post', 'organization'),
                        'posts_per_page' => 6
                    ]) ?>
                    <?php if ($last_post->have_posts()): ?>
                        <?php while ($last_post->have_posts()):$last_post->the_post(); ?>
                            <div class="latest_article_option">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>"
                                         alt="">
                                </a>
                                <h4><?php the_title() ?></h4>
                                <p><?php the_excerpt(); ?></p>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_query(); ?>
                    <?php endif; ?>
                </div>

            </div>

        </div>
        <div class="col-12 col-md-12 col-lg-8 col-xl-9">
            <div class="article_search">

                <div class="article_search_category_section">
                    <?php
                    $category = get_queried_object();



                    $paged = (get_query_var('page_val') ? get_query_var('page_val') : 1);
                    $post_cat = new WP_Query(array(
                        'posts_per_page' => 6,
                        'cat' =>  $category->term_id,
                        'orderby' => 'date',
                        'paged' => $paged,
                        'order' => 'DESC'));

                    ?>
                    <?php if ($post_cat->have_posts()): ?>
                        <?php while ($post_cat->have_posts()): $post_cat->the_post(); ?>
                            <div class="article_search_category">

                                <div class="col-12 col-md-5 col-lg-4" style="padding: 0;">
                                    <a href="<?php the_permalink() ?>">
                                        <div class="article_search_category_image_custom">

                                            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="">

                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-md-7 col-lg-8 article_search_category_title">
                                    <a href="<?php the_permalink() ?>">
                                        <h4><?php the_title() ?></h4>
                                    </a>
                                    <span><?php the_date() ?></span>
                                </div>
                                <div class="col-12 col-md-7 col-lg-8 article_search_category_info">

                                    <span class="article_title"><?php echo $category->name ?></span>
                                    <div class="article_study_custom">
                                        <span class="article_study">
                                        <div>

                                            <span class="comment"> <i
                                                        class="comment"></i> <?php $cc = get_comment_count(get_the_ID());
                                                echo $cc['approved']; ?>دیدگاه</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7 col-lg-8 article_search_category_text">
                                    <p>
                                        <?php the_excerpt(); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_query();
                        wp_reset_postdata(); ?>
                        <div class="col-12">
                            <nav class="woocommerce-pagination">

                                <ul class="page-numbers">
                                    <?php
                                    $big = 999999999;
                                    echo paginate_links(array(
                                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                        'format' => '/page/%#%',
                                        'current' => max(1, $paged),
  'type' => 'list',
                                        'show_all' => true,
                                        'total' => $post_cat->max_num_pages
                                    )); ?>

                                </ul>


                            </nav>
                        </div>
                    <?php endif; ?>


                </div>

            </div>
        </div>
    </div>
</div>
<?php get_footer('blog') ?>
