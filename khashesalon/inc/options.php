<?php

add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );

add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

function cd_add_submenu() {
	add_submenu_page( 'options-general.php', 'Submenu', 'Submenu', 'manage_options', 'my-sub-menu', 'cd_display_submenu_options');
}
add_action( 'admin_menu', 'cd_add_submenu' );

function cd_add_admin_menu(){
	add_menu_page( 'My Options Page', 'My Options Page', 'manage_options', 'my_options_page', 'my_theme_options_page', 'dashicons-hammer', 66 );
}
add_action( 'admin_menu', 'cd_add_admin_menu' );

function cd_settings_init() { 
	register_setting( 'theme_options', 'cd_options_settings' );
add_setting_section(
	'cd_options_page_section', 
	__( 'Your section description', 'underscores.me' ), 
	'cd_options_page_section_callback', 
	'theme_options'
);

function cd_options_page_section_callback() { 
	echo __( 'A description and detail about the section.', 'codediva' );
}

add_settings_field( 
	'cd_text_field', 
	__('Enter your text', 'underscores.me'), 
	'cd_text_field_render', 
	'theme_options', 
	'cd_options_page_section' 
);

add_settings_field( 
	'cd_checkbox_field', 
	__( 'Check your preference', 'underscores.me' ), 
	'cd_checkbox_field_render', 
	'theme_options', 
	'cd_options_page_section' 
);

add_settings_field( 
	'cd_radio_field', 
	__( 'Choose an option', 'underscores.me' ), 
	'cd_radio_field_render', 
	'theme_options', 
	'cd_options_page_section' 
);

add_settings_field( 
	'cd_textarea_field', 
	__( 'Enter content into the text area', 'underscores.me' ), 
	'cd_textarea_field_render', 
	'theme_options', 
	'cd_options_page_section' 
);

add_settings_field( 
	'cd_select_field', 
	__( 'Choose from the dropdown', 'underscores.me' ), 
	'cd_select_field_render', 
	'theme_options', 
	'cd_options_page_section' 
);
// Creating the callback function for the textbox
	function cd_text_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="text" name="cd_options_settings[cd_text_field]" value="<?php if (isset($options['cd_text_field'])) echo $options['cd_text_field']; ?>">
		<?php
	}

// Creating the callback function for the checkbox
	function cd_checkbox_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="checkbox" name="cd_options_settings[cd_checkbox_field]" <?php if (isset($options['cd_checkbox_field'])) checked( $options['cd_checkbox_field'], 1 ); ?> value="1">
		<?php
	}

//Creating the callback function for the radio button
	function cd_radio_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<input type="radio" name="cd_options_settings[cd_radio_field]" <?php if (isset($options['cd_radio_field'])) checked( $options['cd_radio_field'], 1 ); ?> value="1">
		<?php
	}
	
//Creating the callback function for the text area	
	function cd_textarea_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<textarea cols="40" rows="5" name="cd_options_settings[cd_textarea_field]"> 
			<?php if (isset($options['cd_textarea_field'])) echo $options['cd_textarea_field']; ?>
	 	</textarea>
		<?php
	}
	
//Creating the callback function for the select option	
	function cd_select_field_render() { 
		$options = get_option( 'cd_options_settings' );
		?>
		<select name="cd_options_settings[cd_select_field]">
			<option value="1" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 1 ); ?>>Option 1</option>
			<option value="2" <?php if (isset($options['cd_select_field'])) selected( $options['cd_select_field'], 2 ); ?>>Option 2</option>
		</select>
	<?php
	}

//Creating the option page to display on the WordPress Dashboard 	
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>My Awesome Options Page</h2>
			<?php
			settings_fields( 'theme_options' );
			do_settings_sections( 'theme_options' );
			submit_button();
			?>
		</form>
		<?php
	}

}
// Allows you to activate the plugin on WordPress
add_action( 'admin_init', 'cd_settings_init' );
?>