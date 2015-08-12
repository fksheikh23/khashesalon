<?php
/* 
 * Plugin Name: Khashe Widget
 * Plugin URI: http://underscores.me
 * Description: A widget plugin for a custom post
 * Author: Khashe Salon
 * Version: 1.0 
 */
 
//enqueues the plugin css sheet

function khashe_stylesheet() {
	wp_enqueue_style( 'style', plugins_url( '/khashewidget/style.css', __FILE__ ) );
}
add_action( 'template_redirect', 'khashe_stylesheet' );
?>

<?php
//creates a new testimonials custom post type
add_action( 'init', 'testimonials_post_type' );
function testimonials_post_type() {
    $labels = array(
//labels the items in the custom post type
        'name' => 'Khashes Testimonials',
        'singular_name' => 'Testimonial',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimonial',
        'edit_item' => 'Edit Testimonial',
        'new_item' => 'New Testimonial',
        'view_item' => 'View Testimonial',
        'search_items' => 'Search Testimonials',
        'not_found' =>  'No Testimonials found',
        'not_found_in_trash' => 'No Testimonials in the trash',
        'parent_item_colon' => '',
    );
 
    register_post_type( 'testimonials', array(
//registers the custom post type
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'exclude_from_search' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 10,
        'supports' => array( 'editor', 'thumbnail' ),
        'register_meta_box_cb' => 'testimonials_meta_boxes', 
    ) );
}

//creates a metabox within this custom post that allows users to display info such as the clients name, service recieved, and their link
function testimonials_meta_boxes() {
    add_meta_box( 'testimonials_form', 'Testimonial Details', 'testimonials_form', 'testimonials', 'normal', 'high' );
}
 
function testimonials_form() {
    $post_id = get_the_ID();
    $testimonial_data = get_post_meta( $post_id, '_testimonial', true );
    $client_name = ( empty( $testimonial_data['client_name'] ) ) ? '' : $testimonial_data['client_name'];
    $source = ( empty( $testimonial_data['source'] ) ) ? '' : $testimonial_data['source'];
    $link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];
 
    wp_nonce_field( 'testimonials', 'testimonials' );
    ?>
    <p>
        <label>Client's Name (optional)</label><br />
        <input type="text" value="<?php echo $client_name; ?>" name="testimonial[client_name]" size="40" />
    </p>
    <p>
        <label>Service Recieved</label><br />
        <input type="text" value="<?php echo $source; ?>" name="testimonial[source]" size="40" />
    </p>
    <p>
        <label>Feedback</label><br />
        <input type="text" value="<?php echo $link; ?>" name="testimonial[link]" size="40" />
    </p>
    <?php
}

//saves the entered testimonial data from the custom post type and meta box
add_action( 'save_post', 'testimonials_save_post' );
function testimonials_save_post( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
 
    if ( ! empty( $_POST['testimonials'] ) && ! wp_verify_nonce( $_POST['testimonials'], 'testimonials' ) )
        return;
 
    if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
    }
 
    if ( ! wp_is_post_revision( $post_id ) && 'testimonials' == get_post_type( $post_id ) ) {
        remove_action( 'save_post', 'testimonials_save_post' );
 
        wp_update_post( array(
            'ID' => $post_id,
            'post_title' => 'Testimonial - ' . $post_id
        ) );
 
        add_action( 'save_post', 'testimonials_save_post' );
    }
 
    if ( ! empty( $_POST['testimonial'] ) ) {
        $testimonial_data['client_name'] = ( empty( $_POST['testimonial']['client_name'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['client_name'] );
        $testimonial_data['source'] = ( empty( $_POST['testimonial']['source'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['source'] );
        $testimonial_data['link'] = ( empty( $_POST['testimonial']['link'] ) ) ? '' : esc_url( $_POST['testimonial']['link'] );
 
        update_post_meta( $post_id, '_testimonial', $testimonial_data );
    } else {
        delete_post_meta( $post_id, '_testimonial' );
    }
}


 //customizes the column to display the meta-info we want
add_filter( 'manage_edit-testimonials_columns', 'testimonials_edit_columns' );
function testimonials_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'testimonial' => 'Testimonial',
        'testimonial-client-name' => 'Client\'s Name',
        'testimonial-source' => 'Business/Site',
        'testimonial-link' => 'Link',
        'author' => 'Posted by',
        'date' => 'Date'
    );
 
    return $columns;
}
 

add_action( 'manage_posts_custom_column', 'testimonials_columns', 10, 2 );
function testimonials_columns( $column, $post_id ) {
    $testimonial_data = get_post_meta( $post_id, '_testimonial', true );
    switch ( $column ) {
        case 'testimonial':
            the_excerpt();
            break;
        case 'testimonial-client-name':
            if ( ! empty( $testimonial_data['client_name'] ) )
                echo $testimonial_data['client_name'];
            break;
        case 'testimonial-source':
            if ( ! empty( $testimonial_data['source'] ) )
                echo $testimonial_data['source'];
            break;
        case 'testimonial-link':
            if ( ! empty( $testimonial_data['link'] ) )
                echo $testimonial_data['link'];
            break;
    }
}

function get_testimonial( $posts_per_page = 1, $orderby = 'none', $testimonial_id = null ) {
	$args = array(
		'posts_per_page' => (int) $posts_per_page,
		'post_type' => 'testimonials',
		'orderby' => $orderby,
		'no_found_rows' => true,

	);
	if ( $testimonial_id )
		$args['post__in'] = array( $testimonial_id );

	$query = new WP_Query( $args  );

	$testimonials = '';
	if ( $query->have_posts() ) { 
	
	$testimonials .='<div id="wraptext">';
		while ( $query->have_posts() ) : $query->the_post();
			$post_id = get_the_ID();
			$testimonial_data = get_post_meta( $post_id, '_testimonial', true );
			$client_name = ( empty( $testimonial_data['client_name'] ) ) ? '' : $testimonial_data['client_name'];
			$source = ( empty( $testimonial_data['source'] ) ) ? '' : ' - ' . $testimonial_data['source'];
			$link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];
			$cite = ( $link ) ? '<a href="' . esc_url( $link ) . '" target="_blank">' . $client_name . $source . '</a>' : $client_name . $source;
			
			$testimonials .= '<aside class="testimonial">';
			$testimonials .= '<span class="quote">&lsquo;</span>';
			$testimonials .= '<div class="entry-testimonials">';
			$testimonials .= '<p class="testimonial-text">' . get_the_content() . '<span></span></p>';
			$testimonials .= '<p class="testimonial-client-name"><cite>' . $cite . '</cite>';
			$testimonials .= '</div>';
			$testimonials .= '</aside>';
			?>
			<?php
		endwhile;
	$testimonials .='</div>';
		wp_reset_postdata();
	}

	return $testimonials;
}


//creates the widget that will display the custom post type: testimonials
class Testimonial_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array( 'classname' => 'testimonial_widget', 'description' => 'Display testimonial post type' );
        parent::__construct( 'testimonial_widget', 'Testimonials', $widget_ops );
    }
 
 //displays the content on the sidebar
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $posts_per_page = (int) $instance['posts_per_page'];
        $orderby = strip_tags( $instance['orderby'] );
        $testimonial_id = ( null == $instance['testimonial_id'] ) ? '' : strip_tags( $instance['testimonial_id'] );
 
        echo $args['before_widget']; 
 
        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;
 
        echo get_testimonial( $posts_per_page, $orderby, $testimonial_id );
 
        echo $args['$after_widget'];
    }
 
 //this code updates the widget if there is any change to the entered data
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
        $instance['orderby'] = strip_tags( $new_instance['orderby'] );
        $instance['testimonial_id'] = ( null == $new_instance['testimonial_id'] ) ? '' : strip_tags( $new_instance['testimonial_id'] );
 
        return $instance;
    }
 
 //form that is created in the widget bar for users to enter their information in
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 
        'title' => '', 'posts_per_page' => '1', 'orderby' => 'none', 'testimonial_id' => null ) );
        $title = strip_tags( $instance['title'] );
        $posts_per_page = (int) $instance['posts_per_page'];
        $orderby = strip_tags( $instance['orderby'] );
        $testimonial_id = ( null == $instance['testimonial_id'] ) ? '' : strip_tags( $instance['testimonial_id'] );
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
 
        <p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of Testimonials: </label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />
        </p>
 
        <p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Order By</label>
        <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
            <option value="none" <?php selected( $orderby, 'none' ); ?>>None</option>
            <option value="ID" <?php selected( $orderby, 'ID' ); ?>>ID</option>
            <option value="date" <?php selected( $orderby, 'date' ); ?>>Date</option>
            <option value="modified" <?php selected( $orderby, 'modified' ); ?>>Modified</option>
            <option value="rand" <?php selected( $orderby, 'rand' ); ?>>Random</option>
        </select></p>
 
        <p><label for="<?php echo $this->get_field_id( 'testimonial_id' ); ?>">Testimonial ID</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'testimonial_id' ); ?>" name="<?php echo $this->get_field_name( 'testimonial_id' ); ?>" type="text" value="<?php echo $testimonial_id; ?>" /></p>
        <?php
    }
}
 
add_action( 'widgets_init', 'register_testimonials_widget' );
function register_testimonials_widget() {
    register_widget( 'Testimonial_Widget' );
    

}