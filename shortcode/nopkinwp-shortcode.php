<?php
//This page is to add shortcode eg [nopkin_wp display_author=true/false], or nopkin_wp(true/false) on template
function nopkin_wp_function( $atts ) {
	//The shortcode values are set to false if no value is passed
	if($atts['display_author']=="") $atts['display_author']="false";
	$output=nopkin_wp($atts['display_author']);
	return $output;
}
add_shortcode( 'nopkin_wp', 'nopkin_wp_function' );
?>
