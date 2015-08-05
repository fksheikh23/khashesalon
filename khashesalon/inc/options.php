<?php
	
	// Customizable Options Page

//This line of code and forward helps us set up the options page for Dashboard	
	
function cd_add_submenu() {
	add_submenu_page( 'options-general.php', 'Submenu', 'Submenu', 'manage_options', 'awesome-sub-menu', 'cd_display_submenu_options');
}
add_action( 'admin_menu', 'cd_add_submenu' );


function cd_add_admin_menu(){ 
	add_menu_page( 'My Options Page', 'My Options Page', 'manage_options', 'my_options_page', 'my_theme_options_page', 'dashicons-hammer', 66 );
} // My Options Page is set as the ID representing the menu item & cd_add_admin_menu is the callback for displaying the content
add_action( 'admin_menu', 'cd_add_admin_menu' );

function cd_settings_init() { 
	
	register_setting( 'theme_options', 'cd_options_settings' );
	
	add_settings_section(
		'cd_options_page_section', 
		__( 'Use this personal settings page to customize the theme', 'underscores.me' ), 
		'cd_options_page_section_callback', 
		'theme_options'
	);
	
	function cd_options_page_section_callback() { 
		echo __( 'Choose from a total of 3 customizable features of this theme that you would like to change based on your personal preference.', 'underscores.me' );
	}

// These lines of code stack up the options available for customization by users that visit the website through WordPress Dashboard

	add_settings_field( 
		'cd_text_field', 
		__('Font Color', 'underscores.me'), 
		'cd_text_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);
	
		add_settings_field( 
		'cd_checkbox_field', 
		__( 'Body Font-Size', 'underscores.me' ), 
		'cd_checkbox_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);

	add_settings_field( 
		'cd_select_field', 
		__( 'Background Color', 'underscores.me' ), 
		'cd_select_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);
	
// Creating the callback function for the text-box		
	
	function cd_text_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="text" name="cd_options_settings[cd_text_field]" value="<?php if (isset($options['cd_text_field'])) echo $options['cd_text_field']; ?>">
		<?php
	}

//Creating the callback function for the check-box	

	function cd_checkbox_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 1 ); ?>> 12px</option>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 2 ); ?>> 14px</option>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 3 ); ?>> 16px</option>
		<?php
	}
	
//Creating the callback function for the drop-down options	
		
	function cd_select_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<select name="cd_options_settings[cd_select_field]">
			<option value="1" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 1 ); ?>>Blue</option>
			<option value="2" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 2 ); ?>>Red</option>
			<option value="3" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 3 ); ?>>Black</option>
		</select>
	<?php
	}
	
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>Our Unique Options Page</h2>
			<?php
			settings_fields( 'theme_options' );
			do_settings_sections( 'theme_options' );
			submit_button();
			?>
		</form>
		<?php
	}

}

add_action( 'admin_init', 'cd_settings_init' );

//This code displays the information entered onto the front-end of the website
$text = get_option('cd_options_settings');
echo $text['cd_text_field'];
echo '<br />';
echo $text['cd_checkbox_field'];
echo '<br />';
echo $text['cd_radio_field'];
echo '<br />';
echo $text['cd_select_field'];
echo '<br />';
echo $text['cd_textarea_field'];