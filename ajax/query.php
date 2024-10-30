<?php 
require('../../../../wp-config.php');

global $wpdb;
if( count($_POST["categories"]) > 0 ){
	query_posts( array( 'orderby' => 'date', 'order' => 'DESC', 'category__and' => $_POST["categories"] ) );
	if ( have_posts() )
		the_post();
		
		rewind_posts();

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archives.php and that will be used instead.
	 */
	 get_template_part( 'index', 'index' );
}else{
	query_posts( "orderby=date&order=DESC" );
	if ( have_posts() )
		the_post();
		
		rewind_posts();

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archives.php and that will be used instead.
	 */
	 get_template_part( 'index', 'index' );
};
?>