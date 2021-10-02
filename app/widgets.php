<?php

class  footer_widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct("footer-widget", "Footer Widget");
    }

    function widget($args, $instance)
    {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo $args['after_widget'];
    }

    function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'عنوان', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">عنوان</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }
}

function register_footer_widget()
{
    register_widget("footer_widget");
}

add_action("widgets_init", "register_footer_widget");