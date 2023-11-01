<?php
/* ##################### Widgets ##################### */
// Sidebars
if ( function_exists('register_sidebar') ) {
	add_action( 'widgets_init', 'como_widgets_init' );
	function como_widgets_init() {
		
		// Main Sidebar Widget		
		register_sidebar( array(
			'name' => __( 'Main Sidebar Widget Area', 'como-strap' ),
			'id' => 'sidebar-main',
			'description' => __( 'Main Widget Area', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		) );
		
		// Header Widgets		
		register_sidebar( array(
			'name' => __( 'Header Widget Area 1', 'como-strap' ),
			'id' => 'sidebar-header-1',
			'description' => __( 'Header Widget Area 1', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name' => __( 'Header Widget Area 2', 'como-strap' ),
			'id' => 'sidebar-header-2',
			'description' => __( 'Header Widget Area 2', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		) );
		// Footer Widgets		
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #1', 'como-strap' ),
			'id' => 'sidebar-footer-1',
			'description' => __( 'Footer Widget Area #1', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #2', 'como-strap' ),
			'id' => 'sidebar-footer-2',
			'description' => __( 'Footer Widget Area #2', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #3', 'como-strap' ),
			'id' => 'sidebar-footer-3',
			'description' => __( 'Footer Widget Area #3', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #4', 'como-strap' ),
			'id' => 'sidebar-footer-4',
			'description' => __( 'Footer Widget Area #4', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #5', 'como-strap' ),
			'id' => 'sidebar-footer-5',
			'description' => __( 'Footer Widget Area #5', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #6', 'como-strap' ),
			'id' => 'sidebar-footer-6',
			'description' => __( 'Footer Widget Area #6', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer Widget Area #7', 'como-strap' ),
			'id' => 'sidebar-footer-7',
			'description' => __( 'Footer Widget Area #7', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
		) );
		
		// Hidden Footer Schema Widget		
		register_sidebar( array(
			'name' => __( 'Footer Hidden Schema Widget', 'como-strap' ),
			'id' => 'sidebar-footer-schema',
			'description' => __( 'Footer Hidden Schema Widget', 'como-strap' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s hide">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
		) );
	}
}
// Como Widgets
// Feed Widget
// Register and load the widget
function como_social_icon_load_widget() {
    register_widget( 'como_social_icon_widget' );
}
add_action( 'widgets_init', 'como_social_icon_load_widget' );
 
// Creating the widget 
class como_social_icon_widget extends WP_Widget {
	function __construct() {
		parent::__construct('como_social_icon_widget',	__('Social Icon Widget', 'como'),array( 'description' => __( 'Displays a Social Icon Widget.  Social URLs can be configured in Theme Options.  If not set, these will default to sharing links (where applicable)', 'como' ), ) 
		);
	}
 
	// Creating widget front-end
	public function widget( $args, $instance ) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
    	//$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    	$socialNetwork = (isset($instance['socialNetwork']) ? $instance['socialNetwork'] : '');
		$socialOptions = get_option('como_theme_social_options');
		
		$obj_id = get_queried_object_id();
		$current_url = get_permalink( $obj_id );
		$title = get_the_title($obj_id);
		$excerpt = get_the_excerpt($obj_id);
		$image = ((has_post_thumbnail($obj_id)) ? get_the_post_thumbnail_url($obj_id, 'medium') : '');
		switch ($socialNetwork) {
			case 'facebook':
				$url = ((isset($options['facebook'])) ? $options['facebook'] : ((isset($socialOptions['facebook'])) ? $socialOptions['facebook'] : 'https://www.facebook.com/sharer/sharer.php?u='. $current_url)); 
				$title = ((!empty($socialOptions['facebook'])) ? 'Visit us on Facebook' : 'Share on Facebook'); 
				$socialLink = '<a href="'. $url .'" target=_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="facebook icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-facebook-f') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'twitter':
				$url = ((isset($options['twitter'])) ? $options['twitter'] : ((isset($socialOptions['twitter'])) ? $socialOptions['twitter'] : 'https://twitter.com/intent/tweet?text='. $title .' '. $current_url)); 
				$title = ((!empty($socialOptions['twitter'])) ? 'Visit us on Twitter' : 'Share on Twitter'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="twitter icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-x-twitter') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'threads':
				$url = ((isset($options['threads'])) ? $options['threads'] : ((isset($socialOptions['threads'])) ? $socialOptions['threads'] : 'https://threads.net')); 
				$title = ((!empty($socialOptions['threads'])) ? 'Visit us on Threads' : 'Share on Threads'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="threads icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-threads') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'youtube':
				$url = ((isset($options['youtube'])) ? $options['youtube'] : ((isset($socialOptions['youtube'])) ? $socialOptions['youtube'] : 'https://youtube.com')); 
				$title = ((!empty($socialOptions['youtube'])) ? 'Visit us on Youtube' : 'Visit Youtube'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="youtube icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-youtube') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'linkedin':
				$url = ((isset($options['linkedin'])) ? $options['linkedin'] : ((isset($socialOptions['linkedin'])) ? $socialOptions['linkedin'] : 'https://www.linkedin.com/shareArticle?mini=true&url='. $current_url .'&title='. $title .'&summary='. $excerpt)); 
				$title = ((!empty($socialOptions['linkedin'])) ? 'Visit us on LinkedIn' : 'Share on LinkedIn'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="linkedin icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-linkedin-in') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'instagram':
				$url = ((isset($options['instagram'])) ? $options['instagram'] : ((isset($socialOptions['instagram'])) ? $socialOptions['instagram'] : 'https://www.instagram.com/?url='. $current_url .'&title='. $title .'&summary='. $excerpt)); 
				$title = ((!empty($socialOptions['instagram'])) ? 'Visit us on Instagram' : 'Share on Instagram'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="instagram icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-instagram') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'pinterest':
				$url = ((isset($options['pinterest'])) ? $options['pinterest'] : ((isset($socialOptions['pinterest'])) ? $socialOptions['pinterest'] : 'https://pinterest.com/pin/create/button/?url='. $image .'&media='. $current_url .'&description='. $title)); 
				$title = ((!empty($socialOptions['pinterest'])) ? 'Visit us on Pinterest' : 'Share on Pinterest'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" role="button" class="pinterest icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fab fa-brands fa-pinterest-p') .'"></i><span class="sr-only">'. $title .'</span></a>';
				break;
			case 'email':
				$url = ((isset($options['email'])) ? 'mailto:'. $options['email'] .'&subject=Website Inquiry' : ((isset($socialOptions['email'])) ? 'mailto:'. $socialOptions['email'] : 'mailto:?&subject='. $title .'&body='. $current_url)); 
				$title = ((!empty($socialOptions['email'])) ? 'Email Us' : 'Share with Email'); 
				$socialLink = '<a href="'. $url .'" target="_blank" title="Email This" class="email icon-link"><i class="'. (!empty($instance['faIcon']) ? $instance['faIcon'] : 'fas fa-solid fa-envelope') .'"></i></a>';
				break;
		}
		
		// Before widget code, if any
    	echo (isset($before_widget) ? $before_widget : '');
   
    	// PART 2: The title and the text output
    	/*if (!empty($title)) {
      		echo $before_title . $title . $after_title;
		}*/
    	if (!empty($socialNetwork)) {
      		echo $socialLink;
		}
   
    	// After widget code, if any  
    	echo (isset($after_widget) ? $after_widget : '');
	}
	// Widget Backend 
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
     	$title = $instance['title'];
     	$socialNetwork = (isset($instance['socialNetwork']) ? $instance['socialNetwork'] : ''); 
		$faIcon = (isset($instance['faIcon']) ? $instance['faIcon'] : ''); 
		?>
		<!-- Widget Title field -->
		<p><label for="<?=$this->get_field_id('title')?>">Title: <em>For admin purposes only - does not display on front-end</em> <input class="widefat" id="<?=$this->get_field_id('title')?>" name="<?=$this->get_field_name('title')?>" type="text" value="<?=$title?>" /></label></p>
      	
     	<!-- Social Platform Field -->
     	<p>
      		<label for="<?=$this->get_field_id('text')?>">Social Network:
        		<select class='widefat' id="<?=$this->get_field_id('socialNetwork')?>" name="<?=$this->get_field_name('socialNetwork')?>" type="text">
					<option value="">-- select --</option>
					<option value="facebook" <?=($socialNetwork=='facebook') ? 'selected' : ''?>>Facebook</option>
					<option value="twitter" <?=($socialNetwork=='twitter') ? 'selected' : ''?>>Twitter</option>
					<option value="threads" <?=($socialNetwork=='threads') ? 'selected' : ''?>>Threads</option>
					<option value="youtube" <?=($socialNetwork=='youtube') ? 'selected' : ''?>>YouTube</option>
					<option value="linkedin" <?=($socialNetwork=='linkedin') ? 'selected' : ''?>>LinkedIn</option>
					<option value="instagram" <?=($socialNetwork=='instagram') ? 'selected' : ''?>>Instagram</option>
					<option value="pinterest" <?=($socialNetwork=='pinterest') ? 'selected' : ''?>>Pinterest</option>
					<option value="email" <?=($socialNetwork=='email') ? 'selected' : ''?>>Email</option>
        		</select>                
      		</label>
     	</p>
		
		<!-- Font Awesome Custom Icon Field -->
		<p><label for="<?=$this->get_field_id('faIcon')?>">Font Awesome Icon: <input class="widefat" id="<?=$this->get_field_id('faIcon'); ?>" name="<?=$this->get_field_name('faIcon'); ?>" type="text" value="<?=$faIcon?>" /></label><div class"como-note">Paste full Font Awesome 6.4.2 icon CSS class to override default icon</div></p>
      	
     	<?php 
	}
     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
    	$instance['title'] = $new_instance['title'];
    	$instance['socialNetwork'] = $new_instance['socialNetwork'];
		$instance['faIcon'] = $new_instance['faIcon'];
    	return $instance;
	}
} // Class como_social_icon_widget ends here
// Shortcode to display widget [widget widget_name="Your_Custom_Widget"]
/*function widget($atts) {
	global $wp_widget_factory;
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    $widget_name = wp_specialchars($widget_name);
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('widget','widget');*/
// Display Widget ID
add_action('in_widget_form', 'spice_get_widget_id');
function spice_get_widget_id($widget_instance) {
	// Check if the widget is already saved or not.
	if ($widget_instance->number=="__i__"){
		echo "<p><strong>Widget ID is</strong>: Please save the widget</p>"   ;
	}  else {
		echo "<p><strong>Widget ID is: </strong>" .$widget_instance->id. "</p>";
	}
}