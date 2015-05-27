<?php
//This page is to create Plugin Admin setting page

//Function to register form fields
function nopkin_register_options(){
    register_setting('nopkin_options_group', 'nopkin_settings', 'nopkin_validate');
}
add_action('admin_init', 'nopkin_register_options');  // register options for the form

//Function to add link to Nopkin WP setting page under WP Settings
function nopkin_admin_links() {
	add_options_page('', 'Nopkin WP', 'manage_options', 'nopkin', 'nopkin_admin_page' );  
	//add_filter( 'plugin_action_links', 'nopkin_settings_link', 10, 2 );  
}
add_action('admin_menu', 'nopkin_admin_links');  // register admin menu hyperlinks

// Options input validation
function nopkin_validate($input) {
  return array_map('wp_filter_nohtml_kses', (array)$input);
}

//Options setting
function nopkin_admin_page() { ?>
    <h2>Nopkin WP Options</h2>
    <form method="post" action="options.php">
    <?php
    settings_fields('nopkin_options_group');
    $nopkin_options = get_option('nopkin_settings');
    ?>
    
    <p>Font Size: <input type="text" id="nopkin_wp_fontsize" name="nopkin_settings[nopkin_wp_fontsize]" value="<?php echo $nopkin_options['nopkin_wp_fontsize']; ?>" type="text" />px
    </p>
    <?php submit_button(); ?>
    </form>
<?php } ?>