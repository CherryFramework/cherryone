<?php
/**
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features. Use a priority of 9 if wanting to run before the parent theme.
 */

/* Add the child theme setup function to the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'cherry_child_theme_setup', 11 );
function cherry_child_theme_setup() {
	// Handle content width for embeds and images.
	cherry_set_content_width( 680 );
}


/* Add to child theme footer social static area */
add_action('cherry_footer', 'cherryone_add_footer_social_static_area' );
function cherryone_add_footer_social_static_area(){
	echo '<div class="static-area-footer-social">';
		echo '<div class="container">';
			echo '<div class="row">';
				cherry_static_area( 'footer-social' );
			echo '</div>';
		echo '</div>';
	echo '</div>';
}


/* Add to child theme footer widget area */
add_action('cherry_static_area_before', "cherryone_add_footer_widget_area" );
function cherryone_add_footer_widget_area($index){
	if ( 'footer-bottom' != $index || !is_front_page()) {
		return;
	}


		cherry_get_sidebar( "sidebar-footer-4" );

}

add_action( 'init', 'cherryone_replace_breadcrumbs' );
function cherryone_replace_breadcrumbs() {
	remove_action( 'cherry_content_before', 'cherry_get_breadcrumbs', 5 );
	add_action( 'cherry_header', 'cherry_get_breadcrumbs', 99 );
}

add_filter( 'cherry_breadcrumbs_custom_args', 'cherryone_breadcrumbs_wrapper_format' );
function cherryone_breadcrumbs_wrapper_format( $args ) {
	$args['wrapper_format'] = '<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-sm-12">%s</div>
			<div class="col-md-12 col-sm-12">%s</div>
		</div>
	</div>';

	return $args;
}


add_filter('comment_form_defaults', 'wpsites_modify_comment_form');
function wpsites_modify_comment_form($arg) {

	$arg = wp_parse_args( $arg );
	if ( ! isset( $arg['format'] ) )
		$arg['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $arg['format'];
	$commenter = wp_get_current_commenter();

	$arg['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . __( 'Name:', 'cherry' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' />';
	$arg['fields']['email'] = '<p class="comment-form-email"><input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . __( 'E-mail:', 'cherry' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>';
	$arg['fields']['url'] =  '<p class="comment-form-url"><input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . __( 'Website:', 'cherry' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';
    $arg['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . __( 'Comment:', 'cherry' ) . '" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></p>';

    return $arg;
}




/**
 * Cherry Wizard and Cherry Data Manager add-ons.
 */

// Assign register plugins function to appropriate filter.
add_filter( 'cherry_theme_required_plugins',     'cherry_child_register_plugins' );

// Assign options filter to apropriate filter.
add_filter( 'cherry_data_manager_export_options', 'cherry_child_options_to_export' );

// Assign option id's filter to apropriate filter.
add_filter( 'cherry_data_manager_options_ids',    'cherry_child_options_ids' );

// Assign cherry_child_menu_meta to aproprite filter.
add_filter( 'cherry_data_manager_menu_meta',      'cherry_child_menu_meta' );

// Add custom child theme assets
add_action( 'wp_enqueue_scripts', 'cherry_child_theme_assets' );

/**
 * Register required plugins for theme.
 *
 * Plugins registered by this function will be automatically installed by Cherry Wizard.
 *
 * Notes:
 * - Slug parameter must be the same with plugin key in array
 * - Source parameter supports 3 possible values:
 *   a) cherry    - plugin will be downloaded from cherry plugins repository
 *   b) wordpress - plugin will be downloaded from wordpress.org repository
 *   c) path      - plugin will be downloaded by provided path
 *
 * @param  array $plugins Default array of required plugins (empty).
 * @return array          New array of required plugins.
 */
function cherry_child_register_plugins( $plugins ) {

	$plugins = array(
		'contact-form-7' => array(
			'name'    => 'Contact Form 7',
			'slug'    => 'contact-form-7',
			'source'  => 'wordpress'
		),
		'cherry-shortcodes' => array(
			'name'         => 'Cherry Shortcodes', 
			'slug'         => 'cherry-shortcodes', 
			'source'       => 'cherry-free'
		),
		'cherry-shortcodes-templater' => array(
			'name'         => 'Cherry shortcodes templater', 
			'slug'         => 'cherry-shortcodes-templater', 
			'source'       => 'cherry-free'
		),
		'cherry-simple-slider' => array(
			'name'         => 'Cherry simple slider', 
			'slug'         => 'cherry-simple-slider', 
			'source'       => 'cherry-free'
		),
		'cherry-portfolio' => array(
			'name'         => 'Cherry portfolio', 
			'slug'         => 'cherry-portfolio', 
			'source'       => 'cherry-free'
		),
		'cherry-testimonials' => array(
			'name'         => 'Cherry testimonials', 
			'slug'         => 'cherry-testimonials', 
			'source'       => 'cherry-free'
		),
		'cherry-team' => array(
			'name'         => 'Cherry team', 
			'slug'         => 'cherry-team', 
			'source'       => 'cherry-free'
		),
		'cherry-social' => array(
			'name'         => 'Cherry social', 
			'slug'         => 'cherry-social', 
			'source'       => 'cherry-free'
		),
		'cherry-grid' => array(
			'name'         => 'Cherry grid', 
			'slug'         => 'cherry-grid', 
			'source'       => 'cherry-free'
		),
		'cherry-charts' => array(
			'name'         => 'Cherry charts', 
			'slug'         => 'cherry-charts', 
			'source'       => 'cherry-free'
		)
	);

	return $plugins;
}

/**
 * Pass own options to export (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options Default options to export.
 * @return array          Filtered options to export.
 */
function cherry_child_options_to_export( $options ) {

	/**
	 * Example:
	 *
	 * $options[] = 'woocommerce_default_country';
	 * $options[] = 'woocommerce_currency';
	 * $options[] = 'woocommerce_enable_myaccount_registration';
	 */

	return $options;
}

/**
 * Pass some own options (which contain page ID's) to export function,
 * if needed (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * With this filter you need pass only options, which contain page ID's and it's would be rewrited with new ID's on import.
 * Standrd options should passed via 'cherry_data_manager_export_options' filter.
 *
 * WARNING #2
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options_ids Default array.
 * @return array              Result array.
 */
function cherry_child_options_ids( $options_ids ) {

	/**
	 * Example:
	 *
	 * $options_ids[] = 'woocommerce_cart_page_id';
	 * $options_ids[] = 'woocommerce_checkout_page_id';
	 */

	return $options_ids;
}

/**
 * Pass additional nav menu meta atts to import function.
 *
 * By default all nav menu meta fields are passed to XML file,
 * but on import processed only default fields, with this filter you can import your own custom fields.
 *
 * @param  array $extra_meta Ddditional menu meta fields to import.
 * @return array             Filtered meta atts array.
 */
function cherry_child_menu_meta( $extra_meta ) {

	/**
	 * Example:
	 *
	 * $extra_meta[] = '_cherry_megamenu';
	 */

	return $extra_meta;
}

/**
 * Include custom assets
 */
function cherry_child_theme_assets() {
	wp_enqueue_script( 'cherry_child_script', get_stylesheet_directory_uri() . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', '', '4.3' );
}


add_filter( 'cherry_menu_toogle_endpoint', 'cherryone_menu_toogle_endpoint' );
function cherryone_menu_toogle_endpoint($arg){

	$arg = 500;

	return $arg;
}


/**
 * Additional data for grid shortode templater
 */
add_filter( 'cherry_templater_macros_buttons', 'cherryone_grid_macros', 10, 2 );
add_filter( 'cherry_grid_shortcode_data_callbacks', 'cherryone_testi_grid_callbacks', 10, 2 );

/**
 * Add testi author macros button to shortcode templater
 *
 * @param  array   $buttons    existing buttons array
 * @param  string  $shortcode  shortcode name
 */
function cherryone_grid_macros( $buttons, $shortcode ) {

	if ( 'cherry_grid' != $shortcode ) {
		return $buttons;
	}

	$buttons['testi_author'] = array(
		'id'    => 'testi_author',
		'value' => __( 'Author (Testimonials only)', 'cherry-grid' ),
		'open'  => '%%TESTIAUTHOR%%',
		'close' => ''
	);

	return $buttons;

}

add_action( 'wp_head', 'cherryone_add_custom_meta' );
function cherryone_add_custom_meta(){
	echo '<meta name = "format-detection" content = "telephone=no" />';
}

/**
 * Add callback function for testi author
 *
 * @param  array $data callbacks array
 * @param  array $atts shortcode atts
 */
function cherryone_testi_grid_callbacks( $data, $atts ) {

	$data['testiauthor'] = 'cherryone_get_testi_author';

	return $data;
}

/**
 * Get tesimponials author
 */
function cherryone_get_testi_author() {

	global $post;
	$meta      = get_post_meta( $post->ID, '_cherry_testimonial', true );
	$grid_meta = get_post_meta( $post->ID, '_cherry_grid', true );

	if ( empty( $meta['name'] ) ) {
		return false;
	}
	$format = '<div class="cherry-grid_testi_auth"><a href="%2$s"%3$s>%1$s</a></div>';
	$link   = get_permalink();
	$name   = $meta['name'];


	$style  = !empty( $grid_meta['item_color'] ) ? ' style="color:' . esc_attr( $grid_meta['item_color'] ) . ';"' : '';

	return sprintf( $format, $name, $link, $style );

}
