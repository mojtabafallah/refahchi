<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}

$twenty_twenty_one_comment_count = get_comments_number();
?>

<div id="comments"
     class="comments-area default-max-width <?php echo get_option('show_avatars') ? 'show-avatars' : ''; ?>">

    <?php
    if (have_comments()) :
        ;
        ?>
        <h2 class="comments-title">
            <?php if ('1' === $twenty_twenty_one_comment_count) : ?>
                <?php esc_html_e('1 comment', 'twentytwentyone'); ?>
            <?php else : ?>
                <?php
                printf(
                /* translators: %s: Comment count number. */
                    esc_html(_nx('%s comment', '%s comments', $twenty_twenty_one_comment_count, 'Comments title', 'twentytwentyone')),
                    esc_html(number_format_i18n($twenty_twenty_one_comment_count))
                );
                ?>
            <?php endif; ?>
        </h2><!-- .comments-title -->

        <div class="comment_reply">

            <?php
            wp_list_comments(
                array(
                    'avatar_size' => 60,
                    'style' => 'div',
                    'short_ping' => true,
                    'walker' => new comment_walker

                )
            );
            ?>

        </div>


        <!-- .comment-list -->

        <?php
        the_comments_pagination(
            array(
                'before_page_number' => esc_html__('Page', 'twentytwentyone') . ' ',
                'mid_size' => 0,
                'prev_text' => sprintf(
                    ' <span class="nav-prev-text"></span>'

                ),
                'next_text' => sprintf(
                    '<span class="nav-next-text"></span>'


                ),
            )
        );
        ?>

        <?php if (!comments_open()) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'twentytwentyone'); ?></p>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    comment_form(
            array(

                'logged_in_as' => null,
                'comment_field'=>
                    '<div class="col-12 col-md-6" style="padding: 0;"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></div><div class="col-12 col-md-6" style="padding-left: 0;">',
                  'submit_field'         => '%1$s %2$s</div>',

            )

    );
    ?>

</div><!-- #comments -->
