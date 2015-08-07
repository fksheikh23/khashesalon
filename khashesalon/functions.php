<?php
/**
 * khashesalon functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package khashesalon
 */

if ( ! function_exists( 'khashesalon_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function khashesalon_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on khashesalon, use a find and replace
	 * to change 'khashesalon' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'khashesalon', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'khashesalon' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'khashesalon_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // khashesalon_setup
add_action( 'after_setup_theme', 'khashesalon_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function khashesalon_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'khashesalon_content_width', 640 );
}
add_action( 'after_setup_theme', 'khashesalon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function khashesalon_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'khashesalon' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'khashesalon' ),
		'id'            => 'sidebar-2',
		'description'   => __('Footer widgets area appears in the footer of the site.', 'khashesalon'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'khashesalon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function khashesalon_scripts() {
	wp_enqueue_style( 'khashesalon-style', get_stylesheet_uri() );

	wp_enqueue_script( 'khashesalon-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'khashesalon-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'khashesalon_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function load_fonts(){wp_register_style('googleFonts','http://fonts.googleapis.com/css?family=Codystar|Buda:300');wp_enqueue_style('googleFonts');}add_action('wp_print_styles', 'load_fonts');

add_filter( 'avatar_defaults', 'newgravatar' ); function newgravatar ($avatar_defaults) { $myavatar = get_stylesheet_directory_uri(). '/images/bckground3.jpg'; $avatar_defaults[$myavatar] = __('Salons Gravatar','khashesalon'); return $avatar_defaults; }
wp_list_comments( array( 'avatar_size' => '80' ) ); 

function new_excerpt_more($more) {global $post;return '<a class="moretag" href="'. get_permalink($post->ID) . '">...Read Our Full News Here</a>';}add_filter('excerpt_more', 'new_excerpt_more');

//code for a custom field, it brings up the previous custom field if required or lets users add their own
 add_action( 'loop_start', 'before_single_post_content' );
function before_single_post_content() {
if ( is_singular( 'post') ) {
$cf = get_post_meta( get_the_ID(), 'custom_field_name', true );
if( ! empty( $cf ) ) {
echo '<div class="before-content">'. $cf .'</div>';
    }
  }
}

//code for meta box regarding a featured product box 
function featured_product_of_the_week_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function featured_product_of_the_week_add_meta_box() {
	add_meta_box(
		'featured_product_of_the_week-featured-product-of-the-week',
		__( 'Featured Product of the Week', 'featured_product_of_the_week' ),
		'featured_product_of_the_week_featured_product_of_the_week_html',
		'post',
		'side',
		'high'
	);
	add_meta_box(
		'featured_product_of_the_week-featured-product-of-the-week',
		__( 'Featured Product of the Week', 'featured_product_of_the_week' ),
		'featured_product_of_the_week_featured_product_of_the_week_html',
		'page',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'featured_product_of_the_week_add_meta_box' );

function featured_product_of_the_week_featured_product_of_the_week_html( $post) {
	wp_nonce_field( '_featured_product_of_the_week_featured_product_of_the_week_nonce', 'featured_product_of_the_week_featured_product_of_the_week_nonce' ); ?>

	<p>
		<label for="featured_product_of_the_week_featured_product_of_the_week_product_name"><?php _e( 'Product Name', 'featured_product_of_the_week' ); ?></label><br>
		<textarea name="featured_product_of_the_week_featured_product_of_the_week_product_name" id="featured_product_of_the_week_featured_product_of_the_week_product_name" ><?php echo featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_product_name' ); ?></textarea>
	
	</p>	<p>
		<label for="featured_product_of_the_week_featured_product_of_the_week_price_range"><?php _e( 'Price Range', 'featured_product_of_the_week' ); ?></label><br>
		<select name="featured_product_of_the_week_featured_product_of_the_week_price_range" id="featured_product_of_the_week_featured_product_of_the_week_price_range">
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$0-20' ) ? 'selected' : '' ?>>$0-20</option>
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$20-40' ) ? 'selected' : '' ?>>$20-40</option>
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$40-60' ) ? 'selected' : '' ?>>$40-60</option>
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$60-80' ) ? 'selected' : '' ?>>$60-80</option>
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$80-100' ) ? 'selected' : '' ?>>$80-100</option>
			<option <?php echo (featured_product_of_the_week_get_meta( 'featured_product_of_the_week_featured_product_of_the_week_price_range' ) === '$100+' ) ? 'selected' : '' ?>>$100+</option>
		</select>
	</p><?php
}

function featured_product_of_the_week_featured_product_of_the_week_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['featured_product_of_the_week_featured_product_of_the_week_nonce'] ) || ! wp_verify_nonce( $_POST['featured_product_of_the_week_featured_product_of_the_week_nonce'], '_featured_product_of_the_week_featured_product_of_the_week_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['featured_product_of_the_week_featured_product_of_the_week_product_name'] ) )
		update_post_meta( $post_id, 'Product Name', esc_attr( $_POST['featured_product_of_the_week_featured_product_of_the_week_product_name'] ) );
	if ( isset( $_POST['featured_product_of_the_week_featured_product_of_the_week_price_range'] ) )
		update_post_meta( $post_id, 'Price Range', esc_attr( $_POST['featured_product_of_the_week_featured_product_of_the_week_price_range'] ) );
	else
		update_post_meta( $post_id, 'featured_product_of_the_week_featured_product_of_the_week_is_this_product_currently_in_stock_', null );
}
add_action( 'save_post', 'featured_product_of_the_week_featured_product_of_the_week_save' );

//Options Page


function theme_settings_init(){
    register_setting( 'theme_settings', 'theme_settings' );
}

function add_settings_page() {
add_menu_page( __( 'Theme Settings' ), __( 'Theme Settings' ), 'manage_options', 'settings', 'theme_settings_page');
}

add_action( 'admin_init', 'theme_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );


$color_scheme = array('default','blue','green',);


function theme_settings_page() {

if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;


global $color_scheme;
?>

<div>

<div id="icon-options-general"></div>
<h2><?php _e( 'Options Page' )  ?></h2>

<?php

if ( false !== $_REQUEST['updated'] ) : ?>
<div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( 'theme_settings' ); ?>
<?php $options = get_option( 'theme_settings' ); ?>

<table>


<tr valign="top">
<th scope="row"><?php _e( 'Custom Logo' ); ?></th>
<td><input id="theme_settings[custom_logo]" type="text" size="36" name="theme_settings[custom_logo]" value="<?php esc_attr_e( $options['custom_logo'] ); ?>" />
<label for="theme_settings[custom_logo]"><?php _e( 'Upload a Logo' ); ?></label></td>
</tr>


<tr valign="top">
<th scope="row"><?php _e( 'Color Scheme' ); ?></th>
<td><select name="theme_settings[color_scheme]">
<?php foreach ($color_scheme as $option) { ?>
<option <?php if ($options['color_scheme'] == $option ){ echo 'selected="selected"'; } ?>><?php echo htmlentities($option); ?></option>
<?php } ?>
</select>                    
<label for="theme_settings[color_scheme]"><?php _e( 'Choose Color Scheme' ); ?></label></td>
</tr>


<tr valign="top">
<th scope="row"><?php _e( 'Disable Welcome Text' ); ?></th>
<td><input id="theme_settings[extended_footer]" name="theme_settings[extended_footer]" type="checkbox" value="1" <?php checked( '1', $options['extended_footer'] ); ?> />
<label for="theme_settings[disable_related_posts]"><?php _e( 'Check this box if you would like to disable the Welcome text' ); ?></label></td>
</tr>

<!-- Option 4: Tracking Code -->
<tr valign="top">
<th scope="row"><?php _e( 'Tracking Code' ); ?></th>
<td><label for="theme_settings[tracking]"><?php _e( 'Enter your analytics tracking code' ); ?></label>
<br />
<textarea id="theme_settings[tracking]" name="theme_settings[tracking]" rows="5" cols="36"><?php esc_attr_e( $options['tracking'] ); ?></textarea></td>
</tr>

</table>

<p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
</form>

</div><!-- END wrap -->

<?php
}
//sanitize and validate
function options_validate( $input ) {
    global $select_options, $radio_options;
    if ( ! isset( $input['option1'] ) )
        $input['option1'] = null;
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
    if ( ! isset( $input['radioinput'] ) )
        $input['radioinput'] = null;
    if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
        $input['radioinput'] = null;
    $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
    return $input;
}
