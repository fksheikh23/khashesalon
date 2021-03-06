<?php
/**
 * Template Name:Back-End Options Page
 *
 * @package WordPress
 * @subpackage khashesalon
 */
	
function cd_add_submenu() {
	add_submenu_page( 'options-general.php', 'Submenu', 'Submenu', 'manage_options', 'awesome-sub-menu', 'cd_display_submenu_options');
}
add_action( 'admin_menu', 'cd_add_submenu' );


function cd_add_admin_menu(){ 
	add_menu_page( 'My Options Page', 'My Options Page', 'manage_options', 'my_options_page', 'my_theme_options_page', 'dashicons-hammer', 66 );
}
add_action( 'admin_menu', 'cd_add_admin_menu' );

function cd_settings_init() { 
	
	register_setting( 'theme_options', 'cd_options_settings' );
	
	
	add_settings_section(
		'cd_options_page_section', 
		__( 'Settings to customize the theme', 'codediva' ), 
		'cd_options_page_section_callback', 
		'theme_options'
	);
	
	function cd_options_page_section_callback() { 
		echo __( 'Choose what you would like to customize or change about our theme with these three options.', 'codediva' );
	}

	
	add_settings_field( 
		'cd_text_field', 
		__('Enter your text', 'codediva'), 
		'cd_text_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);
	
		add_settings_field( 
		'cd_checkbox_field', 
		__( 'Do you want the Welcome sign to show on Homepage?', 'codediva' ), 
		'cd_checkbox_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);

	add_settings_field( 
		'cd_select_field', 
		__( 'Choose from the dropdown', 'codediva' ), 
		'cd_select_field_render', 
		'theme_options', 
		'cd_options_page_section' 
	);
	
	
	
	function cd_text_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="text" name="cd_options_settings[cd_text_field]" value="<?php if (isset($options['cd_text_field'])) echo $options['cd_text_field']; ?>">
		<?php
	}
	
	function cd_checkbox_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 1 ); ?> value="1">
		<?php
	}
	
	function cd_select_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<select name="cd_options_settings[cd_select_field]">
			<option value="1" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 1 ); ?>>Option 1</option>
			<option value="2" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 2 ); ?>>Option 2</option>
		</select>
	<?php
	}
	
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>Our Unique Customization Page</h2>
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