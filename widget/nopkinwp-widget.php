<?php 
//This page is to add Plugin widget

// Register and load the widget
function nopkin_load_widget() {
	register_widget( 'nopkin_widget' );
}
add_action( 'widgets_init', 'nopkin_load_widget' );

// Creating the widget 
class nopkin_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
		// Base ID of your widget
		'nopkin_widget', 
		
		// Widget name will appear in UI
		__('Nopkin WP', 'nopkin_widget_desc'), 
		
		// Widget description
		array( 'description' => __( 'Displays a simple Hello text from mysql table', 'nopkin_widget_desc' ), ) 
		);
	}
	
	// Creating widget front-end
	public function widget($args, $instance ) {
		echo $args['before_widget'];
		
		$display_author = $instance['display_author'] ? 'true' : 'false';
		$nopkin_widget_title = $instance['nopkin_widget_title'];
		
		// This is where you run the code and display the output
		echo "<h2>".$nopkin_widget_title."</h2>";
		nopkin_wp ($display_author);
		echo $args['after_widget'];
	}
				
	// Widget setting backend 
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'nopkin_widget_title' => '' ) );
        $text = format_to_edit($instance['nopkin_widget_title']); ?>
		<p>
        Title:<br />
		<input class="text" type="text" id="<?php echo $this->get_field_id('nopkin_widget_title'); ?>" name="<?php echo $this->get_field_name('nopkin_widget_title'); ?>" value ="<?php echo $text; ?>"/> 
		</p>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['display_author'], 'on'); ?> id="<?php echo $this->get_field_id('display_author'); ?>" name="<?php echo $this->get_field_name('display_author'); ?>" /> 
		Display Author 
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['display_author'] = $new_instance['display_author'];
		$instance['nopkin_widget_title'] = $new_instance['nopkin_widget_title'];
		return $instance;
	}
} 


