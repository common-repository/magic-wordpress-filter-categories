<?php
/*  
	Plugin Name: Magic Wordpress Filter Categories
	Description: It create search filter for each category. Generates a multi-level (multiple select boxes) AJAX populated category dropdown widget. Perfect for blogs with large numbers of categories where you must filter your blog posts for multiple selection filter categories and subcategories.
	Version: 1.0
	Author: Dechigno (Prima Posizione Srl)
	Author URI: http://www.prima-posizione.it/

*/
define( "TITLE_FCPILLOW_LONG" 	, "Magic Wordpress Filter Categories");
define( "TITLE_FCPILLOW_SHORT"	, "Filter Category");
define( "POWERED_FCPILLOW_BY"	, "PHP");
define( "LINK_FCPILLOW_ADMIN"	, "http://www.webmasterpoint.org/php/");
define( "NAME_FCPILLOW_DIR"		, "magic-wordpress-filter-categories");

/************************************************************/
/*		admin_init is triggered before any other hook 		*/
/*			when a user access the admin area.  			*/
/*		  This hook doesn't provide any parameters,			*/
/*			 so it can only be used to callback				*/
/*		  		   a specified function. 					*/
/************************************************************/
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );		

require( WP_PLUGIN_DIR . '/'.NAME_FCPILLOW_DIR.'/widget.php' );
wp_enqueue_script('jquery');
wp_enqueue_style('css',  WP_PLUGIN_URL . '/magic-wordpress-filter-categories/css/style.css');
function fc_admin_init() {
	global $current_user;
	get_currentuserinfo();

	if ($current_user->user_level <  8) { //if not admin, die with message
		wp_die( __('You are not allowed to access this part of the site') );
	}
}
add_action('admin_init', 'fc_admin_init');

/* Function that registers our widget. */
function fc_load_widgets() {
	register_widget( 'WpFilterCategory' );
}
add_action( 'widgets_init', 'fc_load_widgets' );

/************************************************************/
/*			The function register_activation_hook 	 		*/
/*		  		(introduced in WordPress 2.0)	 			*/
/*		 	  registers a plugin function to be				*/
/*			   run when the plugin is activated. 			*/
/************************************************************/
function wtc_activate() {}

/************************************************************/
/*			The function register_deactivation_hook	 		*/
/*		  		(introduced in WordPress 2.0)	 			*/
/*		 	  registers a plugin function to be				*/
/*			   run when the plugin is deactivated. 			*/
/************************************************************/

function wtc_deactivate() {}

/************************************************************/
/*	  The wp_footer action is triggered near the </body> 	*/
/*	     tag of the user's template by the wp_footer()	 	*/
/*		  function. Although this is theme-dependent,		*/
/*		    it is one of the most essential theme  			*/
/*		   hooks, so it is fairly widely supported. 		*/
/************************************************************/
function wtc_footer(){
	echo '<p style="text-align: center">Powered by <a href="'.LINK_FCPILLOW_ADMIN.'" target="_blank">'.POWERED_FCPILLOW_BY.'</a> Webmasterpoint.org</p>';
}
add_action( 'wp_footer', 'wtc_footer' );
add_action( 'wtc_active', 'wtc_activate' );
add_action( 'wtc_deactive', 'wtc_deactivate' );
register_activation_hook(__FILE__, 'wtc_activate');
register_deactivation_hook(__FILE__, 'wtc_deactivate');
?>