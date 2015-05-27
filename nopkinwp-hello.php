<?php
/*
Plugin Name: Nopkin Hello Plugin
Plugin URI: http://sangaytenzin.com
Description: Creates and displays data from mysql table.
Version: 1.0
Author: Sangay Tenzin
Author URI: http://sangaytenzin.com
License: GPL2
*/

//Add stylesheet to the plugin
function add_nopkin_css() {
	wp_enqueue_style( 'prefix-style', plugins_url('css/nopkinwp.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'add_nopkin_css' );

//Widget setting
include_once dirname( __FILE__ ) . '/widget/nopkinwp-widget.php';

//Shortcode setting
include_once dirname( __FILE__ ) . '/shortcode/nopkinwp-shortcode.php';

//Admin setting
include_once dirname( __FILE__ ) . '/admin/nopkinwp-admin.php';

//Create database table
function install_nopkin_table() {
	global $wpdb;
	$thetable= $wpdb->prefix."nopkin_wp_table";
	
	if($wpdb->get_var("SHOW TABLES LIKE '$thetable'") != $thetable) {
		$sql = "DROP table $thetable;
		CREATE TABLE $thetable (
		`entry_id` int(11) NOT NULL AUTO_INCREMENT,
		`entry_data` varchar(200) DEFAULT NULL,
		PRIMARY KEY (`entry_id`)
		)";	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql);
	}
}
register_activation_hook( __FILE__, 'install_nopkin_table' );

//Insert table data. The table data is stored in a separate datafile called data/data.txt
function install_nopkin_data() {
	global $wpdb;
	$thetable= $wpdb->prefix."nopkin_wp_table";
	$insert="INSERT INTO $thetable (entry_id, entry_data) 
	VALUES ('1','Hello World! This is Nopkin WP Plugin demo!')";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $insert);
}
register_activation_hook( __FILE__, 'install_nopkin_data');

//Remove database table when the plugin is uninstalled
function uninstall_nopkin_data() {
	global $wpdb;
	$table = $wpdb->prefix."nopkin_wp_table";
	$wpdb->query("DROP TABLE IF EXISTS $table");
}
register_deactivation_hook( __FILE__, 'uninstall_nopkin_data' );



//The plugin function
function nopkin_wp ($a) {
	global $wpdb;
	$table = $wpdb->prefix."nopkin_wp_table";
	?>
	<div class="nopkin_wp_wrapper">
		<?php
        $nopkin_options = get_option('nopkin_settings');
        ?>
        
		<style type="text/css">
			.nopkin_wp_text {
				font-size: <?php echo $nopkin_options['nopkin_wp_fontsize']; ?>px !important;
			}
        </style>
        
         <p class="nopkin_wp_text">
         <?php
        	$result = mysql_query("SELECT entry_data FROM $table");
        	while ($row = mysql_fetch_array($result) ) {
        		echo $data=$row['entry_data'];
        	}
        ?>
        </p>
        <?php if ($a=="true") { ?>
        <p class="nopkin_wp_author"> Plugin developed by Sangay </p>
        <?php } 
		?>
	</div>
<?php } ?>