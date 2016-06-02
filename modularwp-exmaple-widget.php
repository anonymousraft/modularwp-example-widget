<?php
/*
Plugin Name: ModularWP Example Widget
Plugin URI: http://modularwp.com/
Description: Simple example of a WordPress widget
Version: 1.0
Author: Alex Mansfield
Author URI: http://modularwp.com/
License: GPLv2 or later
Text Domain: examplewidget
*/

/**
 * Registers the widget
 */
function mdlrwp_widget_register() {
	register_widget( 'MDLRWP_Example_Widget' );
}
add_action( 'widgets_init', 'mdlrwp_widget_register' );

/**
 * Defines the widget class
 */
class MDLRWP_Example_Widget extends WP_Widget {

	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct(
			'mdlrwp-example-widget', // Base ID
			__( 'ModularWP Example Widget', 'examplewidget' ), // Title
			array( 'description' => __( 'Simple example of a WordPress widget.', 'examplewidget' ) )
		);
	}

	/**
	 * Displays the widget content on the front end
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {

		// Collects from widget input fields.
		$title_unfiltered = ( !empty( $instance['title'] ) ) ? sanitize_text_field( $instance['title'] ) : '';
		$title_filtered = apply_filters( 'widget_title', $title_unfiltered, $instance, $this->id_base );
		$title = !empty( $title_filtered ) ? $args['before_title'] . $title_filtered . $args['after_title'] : '';
		$content = ( !empty( $instance['content'] ) ) ? sanitize_text_field( $instance['content'] ) : '';

		// Displays widget output.
		echo $args['before_widget'];
		echo $title;
		echo wpautop( $content );
		echo $args['after_widget'];
	}

	/**
	 * Updates the settings when the widget instance is saved
	 *
	 * @param  array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param  array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	 public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['content'] = sanitize_text_field( $new_instance['content'] );

		return $instance;
	}

	/**
	 * Displays the widget settings form on the back end
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance['title'] = !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$instance['content'] = !empty( $instance['content'] ) ? esc_attr( $instance['content'] ) : '';
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'examplewidget' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php _e( 'Content:', 'examplewidget' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('content') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['content'] ); ?>" />
			</p>
		<?php
	}
}
