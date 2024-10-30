<?php 
class WpFilterCategory extends WP_Widget {
	function WpFilterCategory() {
		// widget actual processes
		parent::WP_Widget(false, $name = 'Magic Wordpress Filter Categories');	
	}

	function form($instance) {
		// outputs the options form on admin
	    $title = esc_attr($instance['title']);
	    $id_content = esc_attr($instance['id_content']);
	    ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id_content'); ?>"><?php _e('Id Contenuto (#):'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('id_content'); ?>" name="<?php echo $this->get_field_name('id_content'); ?>" type="text" value="<?php echo $id_content; ?>" />
		</p>
	    <?php 
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title'] 		= strip_tags( $new_instance['title'] );
		$instance['id_content'] = strip_tags( $new_instance['id_content'] );
        return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		$title 		= apply_filters('widget_title', $instance['title']);
		$id_content = $instance['id_content'];
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'orderby'                  => 'id',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'taxonomy'                 => 'category',
			'pad_counts'               => false
		);
        $categories = get_categories( $args );
        
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                  <?php 
                  	foreach ( $categories as $category ){
                  		if( !$category->category_parent ){
	                  		echo "<div class=\"filter_search_widget\">";
	                  		echo "<h1><input type=\"checkbox\" name=\"filter_category\" class=\"filter_category_input\" value=\"".$category->term_id."\" />".$category->name."</h1>";
	                  		echo "<ul>";
	                  		$args = array(
								'parent' => $category->term_id
							);
	                  		$subcategories = get_categories( $args );
	                  		foreach ( $subcategories as $subcategory  )
								echo "<li><input type=\"checkbox\" name=\"filter_category\" class=\"filter_category_input\" value=\"".$subcategory->term_id."\" />".$subcategory->name." ( ".$subcategory->count." )</li>";
							echo "</ul>";
							echo "</div>";
						}
					}
                  	
                  ?>
              <?php echo $after_widget; ?>
        	<script type="text/javascript">
        	var loading_box = "<div id=\"filter_search_loading\">Ricerca in corso...<br /><br /><img src=\"<?php echo WP_PLUGIN_URL ?>/magic-wordpress-filter-categories/ajax-loader.gif\" alt=\"\" /></div>";
        	var id_content = "<?php echo $id_content;?>";
        	var filter_selected = new Array();
        	if( id_content != "" ){
	        	jQuery(document).ready(function(){
	        		jQuery(".filter_category_input:checked").each(function(){
	        			filter_selected.push( jQuery(this).attr("value") );
	        		});
	        		jQuery(".filter_category_input").click(function(){
	        			jQuery("#" + id_content).html( loading_box );
	        			filter_selected = new Array();
		        		jQuery(".filter_category_input:checked").each(function(){
		        			filter_selected.push( jQuery(this).attr("value") );
		        		});
		        		
		        		jQuery.post("<?php echo WP_PLUGIN_URL . "/magic-wordpress-filter-categories/ajax/";?>query.php", { categories: filter_selected } ,function( response ){
		        			var html_content = response;
		        			jQuery("#" + id_content).html( jQuery(html_content).find("#"+id_content).html() );
		        		});
	        		});
	        	});
        	}else{
        		jQuery(document).ready(function(){
        			jQuery(".filter_search_widget").css("display", "none");
        		});
        	}
        	</script>  
        <?php
	}
}
?>