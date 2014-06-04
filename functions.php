<?php
/**
 * Mobius theme functions and definitions
 *
 * Other functions are attached to action and filter hooks in WordPress to change core functionality.
 *
 * Layout Functions:
 *
 * st_above_header
 * st_header_open
 * st_top_bar
 * st_logo
 * st_header_close
 * st_below_header
 * st_navbar
 * st_before_content
 * st_after_content
 * st_before_comments
 * st_after_comments
 * st_before_footer
 * st_footer
 * st_footernav
 * st_after_footer
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, smpl_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage smpl
 * @since smpl 0.1
 */

// Add suppport for WooCommerce
// http://docs.woothemes.com/documentation/plugins/woocommerce/woocommerce-codex/theming/

add_theme_support( 'woocommerce' );


// Disable WooCommerce CSS
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Move WooCommerce LESS/CSS to theme directory for editing
function breeze_enqueue_woocommerce_style(){
    wp_register_style( 'woocommerce', get_stylesheet_directory_uri() . '/woocommerce/woocommerce.css' );
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'breeze_enqueue_woocommerce_style' );



// Remove default WooCommerce Wrappers

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'breeze_content_wrap', 10);
add_action('woocommerce_after_main_content', 'breeze_content_wrap_close', 10);

// Dynamic content width based on a "Shop" sidebar
// Create a sidebar under Appearance >> Theme Options >> Sidebars with a named value of "sidebar-shop"

function breeze_woocommerce_content_width() {
	global $post;
	if (is_woocommerce()) {
		// get default content width from theme settings
		$content_grid = ot_get_option('content_width');

		// woocommerce sidebar name (sidebar-shop.php)
		$active_sidebar = 'sidebar-shop';

		// check for custom field sidebars => false to force wide page
		$wide = get_post_meta($post->ID, "sidebars", $single = true) ==  "false";

		// pass sixteen columns
		if ( !is_active_sidebar($active_sidebar) || $wide ) {
			$content_grid = '16';
		}
		// let woocommerce handle featured images in content
		remove_filter('the_content','skeleton_thumbnailer');

		$columns = apply_filters('skeleton_get_grid', $content_grid, 1);
		return $columns;
	}
}
add_filter('skeleton_set_colwidth', 'breeze_woocommerce_content_width', 10, 1);


/*-----------------------------------------------------------------------------------*/
/* Filter Available Font Families
/*-----------------------------------------------------------------------------------*/

	function breeze_font_families( $array, $field_id ) {

	    $array = array(
				'helvetica'  => '"HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif',
				'arial' 	 => 'Arial, Helvetica, sans-serif',
				'georgia' 	 => 'Constantia, "Lucida Bright", Lucidabright, "Lucida Serif", Lucida, "DejaVu Serif", "Bitstream Vera Serif", "Liberation Serif", Georgia, serif',
				'cambria' 	 => 'Cambria, "Hoefler Text", Utopia, "Liberation Serif", "Nimbus Roman No9 L Regular", Times, "Times New Roman", serif',
				'tahoma' 	 => 'Tahoma, Verdana, Segoe, sans-serif',
				'palatino' 	 => '"Palatino Linotype", Palatino, Baskerville, Georgia, serif',
				'droidsans'  => '"Droid Sans", sans-serif',
				'droidserif' => '"Droid Serif", serif',
				'roboto' 	 => '"Roboto", sans-serif',
				'opensans' 	 => '"Open Sans", sans-serif',
				'titillium' 	 => '"Titillium Web", sans-serif'
	    );
	  	return $array;
	}

	add_filter( 'ot_recognized_font_families', 'breeze_font_families', 10, 2 );

	function breeze_google_fonts() {
		$typography_fields = array(
			'header_typography',
			'tagline_typography',
			'body_typography',
			'h1_typography',
			'h2_typography',
			'h3_typography',
			'h4_typography'
			);

		$faces = array();
		foreach ($typography_fields as $value) {
			$faces[] = ot_get_option($value);
		}
		// Droid Sans
		$font = "droidsans";
		$font = (bool)strpos(serialize($faces),$font);
		if($font){
			echo "<link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>";
		}
		// Droid Serif
		$font = "droidserif";
		$font = (bool)strpos(serialize($faces),$font);
		if($font){
			echo "<link href='//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>";
		}
		// Titillium
		$font = "titillium";
		$font = (bool)strpos(serialize($faces),$font);
		if($font){
			echo "<link href='//fonts.googleapis.com/css?family=Titillium+Web:400,300,200,400italic,600,700' rel='stylesheet' type='text/css'>";
		}
		// Open Sans
		$font = "opensans";
		$font = (bool)strpos(serialize($faces),$font);
		if($font){
			echo "<link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,300,600,700,800' rel='stylesheet' type='text/css'>";
		}
		// Roboto
		$font = "roboto";
		$font = (bool)strpos(serialize($faces),$font);
		if($font){
			echo "<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,300italic,400italic,500,700,900' rel='stylesheet' type='text/css'>";
		}
	}
	add_action('wp_head','breeze_google_fonts',10);
