<?php
/*
Plugin Name: Widget Featured Content
Plugin URI: http://webmasterninja.wordpress.com
Description: Add featured content on your sidebar widget with thumbnail above title and content.
Author: Jayson Antipuesto
Author URI: http://webmasterninja.wordpress.com
Version: 1.0.0
Text Domain: jay-featured-content
*/

add_action( 'widgets_init', 'jay_init' );

function jay_init() {
	register_widget( 'jay_widget' );
}

class jay_widget extends WP_Widget
{

    public function __construct()
    {
        $widget_details = array(
            'classname' => 'jay_widget',
            'description' => 'Creates a featured item consisting of a title, image, description and link.'
        );

        parent::__construct( 'jay_widget', 'Featured Item Widget', $widget_details );

        add_action('admin_enqueue_scripts', array($this, 'jay_assets'));
    }


public function jay_assets()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jay-media-upload', plugin_dir_url(__FILE__) . 'jay-media-upload.js', array('jquery'));
    wp_enqueue_style('thickbox');
}


    public function widget( $args, $instance )
    {
		$hide_title = $instance['hide_title'] ? 'on' : 'off';

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) && $hide_title == 'off' ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		?>

		<div class="jay-featured-img-wrapper">
		<a href='<?php echo esc_url( $instance['link_url'] ) ?>'  title='<?php echo esc_html( $instance['link_title'] ) ?>'><img src='<?php echo $instance['image'] ?>' alt='<?php echo esc_html( $instance['link_title'] ) ?>' title='<?php echo esc_html( $instance['link_title'] ) ?>' class='jay-featured-img' width='300' height='300'></a>
		</div>

		<h4 class='jay-link'>
			<a href='<?php echo esc_url( $instance['link_url'] ) ?>'  title='<?php echo esc_html( $instance['link_title'] ) ?>'><?php echo esc_html( $instance['link_title'] ) ?></a>
		</h4>

		<p class='jay-description'>
			<?php echo esc_html( $instance['description'] ); ?> <span class="read-btn">... <a href='<?php echo esc_url( $instance['link_url'] ) ?>'  title='<?php echo esc_html( $instance['link_title'] ) ?>'>read more</a></span>
		</p>

		<?php

		echo $args['after_widget'];
    }

	public function update( $new_instance, $old_instance ) {
		$instance['hide_title'] = $new_instance['hide_title'];

	    return $new_instance;
	}

    public function form( $instance )
    {
		$hide_title = isset( $instance['hide_title'] ) ? esc_attr( $instance['hide_title']) : 'on';

		$title = '';
	    if( !empty( $instance['title'] ) ) {
	        $title = $instance['title'];
	    }

	    $description = '';
	    if( !empty( $instance['description'] ) ) {
	        $description = $instance['description'];
	    }

	    $link_url = '';
	    if( !empty( $instance['link_url'] ) ) {
	        $link_url = $instance['link_url'];
	    }

	    $link_title = '';
	    if( !empty( $instance['link_title'] ) ) {
	        $link_title = $instance['link_title'];
	    }

		$image = '';
		if(isset($instance['image']))
		{
		    $image = $instance['image'];
		}
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" ><?php echo esc_attr( $description ); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'link_url' ); ?>"><?php _e( 'Link URL:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'link_title' ); ?>"><?php _e( 'Link Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link_title' ); ?>" name="<?php echo $this->get_field_name( 'link_title' ); ?>" type="text" value="<?php echo esc_attr( $link_title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
        </p>

		<p>
		    <input class="checkbox" type="checkbox" <?php checked($instance['hide_title'], 'on'); ?> id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>" />
		    <label for="<?php echo $this->get_field_id('hide_title'); ?>">Hide widget title?</label>
		</p>
    <?php
    }
}
