<?php
// Search Box Shortcode
function searchbar_func($atts) {
	$a = shortcode_atts(array(
		'icon' => 'fa fa-search fa-regular fa-magnifying-glass'	
	), $atts );
	$form = '<form role="search" method="get" id="searchform" action="'. home_url( '/' ) .'">
		<div>
			<div class="search-wrap"><label for="s"><span class="screen-reader-text sr-only">'. insertStringText('Search:','como-boot') .'</span><input type="text" value="" name="s" class="s" placeholder="'. insertStringText('Search','como-boot') .'..." aria-label="Search" /></label> <button type="submit" class="searchsubmit" role="button" aria-label="Search Submit"><i class="'. $a['icon'] .'" aria-hidden="true"></i><span class="sr-only">Search Submit</span></button></div>
		</div>
	</form>';
	return $form;
}
add_shortcode('searchbar', 'searchbar_func');
// Menu Search Box Shortcode
function menu_searchbar_func($atts) {
	$a = shortcode_atts(array(
		'icon' => 'fa fa-search fa-regular fa-magnifying-glass',
		'text' => ''
	), $atts );
	$form = '<div class="menu-search"><form role="search" method="get" action="'. home_url( '/' ) .'" class="searchform search-dropdown">
		<div class="search-wrap"><label for="s"><span class="screen-reader-text sr-only">'. insertStringText('Search:','como-boot') .'</span><input type="text" value="" name="s" class="s" placeholder="'. insertStringText('Search','como-boot') .'..." aria-label="Search Input" /></label> <button type="submit" class="searchsubmit" aria-label="Search Submit Button" role="button"><i class="'. $a['icon'] .'"></i></button></div>
	</form><span class="search-toggle" role="button" aria-label="Search Toggle">'. ((!empty($a['text'])) ? $a['text'] : '<i class="'. $a['icon'] .'"></i>') .'<span class="sr-only">Search Toggle</span></span></div>';
	return $form;
}
add_shortcode('menu_searchbar', 'menu_searchbar_func');
//add_theme_support( 'html5', array( 'search-form' ) );
add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu( $items, $args ) {
    if( $args->theme_location == 'header-menu' )
        return '<li class="menu-item nav-search mobile-only">' . get_search_form(false) . '</li>'. $items;
    return $items;
}