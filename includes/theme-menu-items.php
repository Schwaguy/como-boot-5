<?php
/**  Add menu meta box  */
function como_add_social_menu_meta_box( $object ) {
	add_meta_box( 'custom-menu-metabox', __( 'Social Icons' ), 'como_social_menu_meta_box', 'nav-menus', 'side', 'default' );
	return $object;
}
add_filter( 'nav_menu_meta_box_object', 'como_add_social_menu_meta_box', 10, 1);
/**
 * Displays a metabox for authors menu item.
 *
 * @global int|string $nav_menu_selected_id (id, name or slug) of the currently-selected menu
 *
 * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/nav-menu.php
 * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/class-walker-nav-menu-edit.php
 * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/class-walker-nav-menu-checklist.php
 */
function como_social_menu_meta_box(){
	global $nav_menu_selected_id;
	$walker = new Walker_Nav_Menu_Checklist();
	$current_tab = 'all';
	$socialOptions = get_option('como_theme_social_options');
	$authors = (object) [
    	'ID'=>'',
    	'test2',
    	'test3',
	];
	/* set values to required item properties */
	foreach ( $authors as &$author ) {
		$author->classes = array();
		$author->type = 'custom';
		$author->object_id = $author->ID;
		$author->title = $author->nickname . ' - ' . implode(', ', $author->roles);
		$author->object = 'custom';
		$author->url = get_author_posts_url( $author->ID ); 
		$author->attr_title = $author->displayname;
		if( $author->has_cap( 'edit_users' ) ){
			$admins[] = $author;
		}
	}
	$removed_args = array( 'action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce' );
	?>
	<div id="authorarchive" class="categorydiv">
		
		<a class="nav-tab-link" data-type="tabs-panel-authorarchive-all" href="<?php if ( $nav_menu_selected_id ) echo esc_url( add_query_arg( 'authorarchive-tab', 'all', remove_query_arg( $removed_args ) ) ); ?>#tabs-panel-authorarchive-all">
					<?php _e( 'View All' ); ?>
				</a>
		
		
		<p>
			<label>Social Network:
				<select class='widefat' id="" name="" type="text">
					<option value="">-- select --</option>
					<option value="facebook">Facebook</option>
					<option value="twitter">Twitter</option>
					<option value="threads">Threads</option>
					<option value="youtube">YouTube</option>
					<option value="linkedin">LinkedIn</option>
					<option value="instagram">Instagram</option>
					<option value="pinterest">Pinterest</option>
					<option value="email">Email</option>
				</select>                
			</label>
		 </p>
		<p class="button-controls wp-clearfix">
			<span class="add-to-menu">
				<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-authorarchive-menu-item" id="submit-authorarchive" />
				<span class="spinner"></span>
			</span>
		</p>
</div>
	
<?php
}
