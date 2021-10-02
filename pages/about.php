<?php /* Template Name: About Page */ ?>
<?php
get_header();
?>
<?php if (have_posts()): the_post(); ?>
    <h1 class="request-form-title alert alert-info"><?php the_title(); ?></h1>
<div class="about-container">
    <?php the_content();?>
</div>
<?php endif; ?>


<?php get_footer() ?>
