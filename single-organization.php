<?php get_header('blog'); ?>

<div class="container-fluid main_container">
    <div class="article_section_custom_1">

        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="col-12 col-lg-7">
                    <div class="article">
                        <div class="article_title">
                            <h1><?php the_title() ?></h1>
                            <div class="author">
                                <span>نویسنده :</span>
                                <span><?php the_author() ?></span>
                            </div>
                            <div class="date">
                                <span>تاریخ :</span>
                                <span> <?php the_date() ?></span><i class="fa fa-clock-o"></i>
                            </div>
                        </div>

                        <div class="article_author">
                            <?php $all_cate = wp_get_post_categories(get_the_ID());

                            ?>


                            <div class="category">
                                <span>دسته بندی :</span>
                                <?php
                                $args = array(
                                    'taxonomy' => 'cate_organ',
                                    'orderby' => 'name',
                                    'order' => 'ASC'
                                );

                                $cats = get_the_terms(get_the_ID(),"cate_organ");

                             

                                foreach ($cats as $cat) {
                                    $term = get_term($cat);
                                    ?>
                                    <a href="/cate_organ/<?php echo $term->slug ?>">
                                        <?php echo $term->name; ?>
                                    </a>
                                    <?php
                                }
                                ?>


                            </div>


                        </div>
                        <div class="article_image_2">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" alt="">
                        </div>
                        <div class="article_content">
                            <?php the_content(); ?>
                        </div>

                        <div class="blockquoteSection">
                            <blockquote>
                                <?php the_excerpt(); ?>
                            </blockquote>
                        </div>

                        <div class="stick">

                            <div>
                                <?php the_tags(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="comment_section">
                        <?php

                        comments_template();


                        ?>
                    </div>


                </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <div class="article_related_post">
            <div class="article_related_post_title">
                <h4>مطالب مرتبط </h4>

            </div>
            <?php


            $relate = new WP_Query([
                'post_type' => ['post', 'organization'],
                'orderby' => 'date',
                'posts_per_page' => 4,

            ]);
            ?>
            <?php if ($relate->have_posts()): ?>
                <?php while ($relate->have_posts()): $relate->the_post(); ?>
                    <div class="article_related_post_custom">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>" alt="">
                        </a>
                        <div class="article_related_post_custom_info">
                            <a href="<?php the_permalink(); ?>">
                                <span><?php the_title(); ?></span>
                            </a>
                            <span><?php the_date() ?><span class="fa fa-clock-o"></span></span>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="article_related_post_custom">

                    <div class="article_related_post_custom_info">
                        <span>مطلبی وجود ندارد</span>


                    </div>
                </div>
            <?php endif; ?>


        </div>


    </div>

</div>

<?php get_footer('blog') ?>
