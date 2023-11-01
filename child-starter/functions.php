<?php
// Add Scripts 
global $is_IE;
if($is_IE) {
	add_action( 'wp_enqueue_scripts', 'load_child_ie_scripts' );
} else {
	add_action( 'wp_enqueue_scripts', 'load_child_scripts' );
}
function load_child_scripts() {
	wp_register_script('child-scripts', get_stylesheet_directory_uri().'/js/child.js', array('jquery'), '', true );
	wp_enqueue_script('child-scripts');
	load_home_scripts();
}
function load_child_ie_scripts() {
	wp_register_script('child-scripts', get_stylesheet_directory_uri().'/js/child.ie.js', array('jquery'), '', true );
	wp_enqueue_script('child-scripts');
	load_home_scripts();
}
function load_home_scripts() {
	wp_register_script('home-scripts', get_stylesheet_directory_uri().'/js/child-home.js', array('jquery'), '', true );
	if ( is_front_page() ) {
		wp_enqueue_script('home-scripts');
  	}
}
// Add Custom Image Sizes
//add_action( 'after_setup_theme', 'child_img_sizes' );
function child_img_sizes() {
	add_image_size( 'image-large-square', 800, 800, true ); // (cropped)
	//add_image_size( 'team-image-large', 400); 
	add_image_size( 'team-image-small', 250, 275, true ); // (cropped) 
}
//add_filter( 'image_size_names_choose', 'child_img_sizes_choose' );
function child_img_sizes_choose( $sizes ) {
    $custom_sizes = array(
        'image-large-square' => 'Large Square'
    );
    return array_merge( $sizes, $custom_sizes );
}
/*
// Add Rewrite Rules for Science/Publications Page
add_filter('rewrite_rules_array','wp_insertMyRewriteRules');
add_filter('query_vars','wp_insertMyRewriteQueryVars');
add_filter('init','flushRules');  
function flushRules(){
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
function wp_insertMyRewriteRules($rules) {
    $newrules = array();
    $newrules['about/careers/page/([^/]*)'] = 'index.php?pagename=about/careers/page/$matches[1]&pganchor=open-positions';
	//$newrules['pipeline/therapeutic-areas/([^/]*)'] = 'index.php?pagename=pipeline/therapeutic-areas&pganchor=$matches[1]';
	return $newrules + $rules;
}
function wp_insertMyRewriteQueryVars($vars) {
	array_push($vars, 'pganchor');
    return $vars;
}
function add_anchor_script_to_footer() {
    echo "<script> 
		jQuery(document).ready(function($) {
			var target = '". get_query_var('pganchor') ."';
			var menuItem = ''; 
			if (target !== '') {
				target = '#". get_query_var('pganchor') ."';
				menuItem = $('.aside-menu').find('.". get_query_var('pganchor') ."');	
				
				$('.aside-menu .menu-item').not($(menuItem)).removeClass('active-menu-item');
				$(menuItem).addClass('active-menu-item');
				
				$(target).addClass('current-anchor');
				
				$('html, body').animate({
					scrollTop: $(target).offset().top - 115
				}, 1, 'easeInOutExpo');
			} 
			return false;
		});
	</script>";
}
//add_action('wp_footer', 'add_anchor_script_to_footer', 100);
*/
// Sidebars
if ( function_exists('register_sidebar') ) {
	//add_action( 'widgets_init', 'child_widgets_init' );
	function child_widgets_init() {
		// Home News	
		/*register_sidebar( array(
			'name' => __( 'Home News Widget', 'child' ),
			'id' => 'sidebar-home-news',
			'description' => __( 'Home News Widget', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		
		// Our Company Sidebar	
		register_sidebar( array(
			'name' => __( 'Our Company Sidebar', 'child' ),
			'id' => 'sidebar-company',
			'description' => __( 'Our Company Sidebar', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		
		// Product Candidates Sidebar	
		register_sidebar( array(
			'name' => __( 'Product Candidates Sidebar', 'child' ),
			'id' => 'sidebar-products',
			'description' => __( 'Product Candidates Sidebar', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		
		// Science Sidebar	
		register_sidebar( array(
			'name' => __( 'Science Sidebar', 'child' ),
			'id' => 'sidebar-science',
			'description' => __( 'Science Sidebar', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		
		// Investors/Media Sidebar	
		register_sidebar( array(
			'name' => __( 'Investors/Media Sidebar', 'child' ),
			'id' => 'sidebar-ir',
			'description' => __( 'Investors/Media Sidebar', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		// Careers Sidebar	
		register_sidebar( array(
			'name' => __( 'Careers Sidebar', 'child' ),
			'id' => 'sidebar-careers',
			'description' => __( 'Careers Sidebar', 'child' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
		*/
	}
}
