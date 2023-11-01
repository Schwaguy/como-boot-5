<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
	$pid = get_queried_object_id();
	$sidebar = get_post_meta($pid, 'sidebar', true);
	if ($sidebar == 'no-sidebar') {
		// No Sidebar
	} elseif (!empty($sidebar)) {
		if ($sidebar == 'parent') {
			if (wp_get_post_parent_id($pid)) {
				$p = wp_get_post_parent_id($pid);
				$parentPost = get_post_custom($p);
				$sidebar = strtolower($parentPost['sidebar'][0]);
			}
		} else {
			$sidebar = strtolower($sidebar);
		}
		dynamic_sidebar($sidebar);
	} else { // Default Sidebars
		if (!dynamic_sidebar('sidebar-main')) {?>
			<!--...-->
		<?php	
		}
	}
?>	
<?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-main') ) : ?>
<?php //endif; ?>