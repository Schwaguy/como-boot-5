<?php
@ini_set( 'upload_max_size' , '512M' );
@ini_set( 'post_max_size', '512M');
@ini_set( 'max_execution_time', '300' );
/* Include theme updater. */
require_once dirname( __FILE__ ) . '/includes/updater.php';
// Bootstrap Walker class
require_once dirname( __FILE__ ) . '/assets/bootstrap/class-wp-bootstrap-navwalker.php';
require_once dirname( __FILE__ ) . '/assets/bootstrap/class-wp-bootstrap-navwalker-tabhover.php';
require_once dirname( __FILE__ ) . '/assets/bootstrap/class-wp-bootstrap-navwalker-accessible.php';
// Declare Global Variables for Footer
$GLOBALS['footScript'] = ''; 
$GLOBALS['page-modals'] = ''; 

add_action('body_start_tag_attributes', function() {
	if (!is_singular()) {
		return; // an archive or a 404
	}
    $post = get_post();
	$postPermalink = get_the_permalink($post->ID);
    $postinfo = array('permalink'=>$postPermalink, 'slug'=>basename($postPermalink));
    if (!$postinfo) {
        return; // no meta value
    }
	$permalink = esc_attr($postinfo['permalink']);
	$slug = esc_attr($postinfo['slug']);
    print ' data-page-permalink="' . $permalink . '" data-page-slug="'. $slug .'"';
});


/* ##################### Styles & Scripts ##################### */
// Add Version time stamp to CSS and JS files if set to No-Cache
function versionStamp(){
    return time();
}
add_action('admin_bar_menu', 'add_toolbar_items', 999);
function add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'como-theme-options',
		'title' => 'Theme Options',
		'href'  => '/wp-admin/themes.php?page=como_theme_options',
        'meta'  => array(
            'title' => __('Theme Options'),            
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'como-theme-display-options',
        'parent' => 'como-theme-options',
        'title' => 'Display Options',
        'href'  => '/wp-admin/themes.php?page=como_theme_options&tab=display_options',
        'meta'  => array(
            'title' => __('Display Options'),
            'target' => '',
            'class' => 'como_menu_item_class'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'como-theme-contact-options',
        'parent' => 'como-theme-options',
        'title' => 'Contact Options',
        'href'  => '/wp-admin/themes.php?page=como_theme_options&tab=contact_options',
        'meta'  => array(
            'title' => __('Contact Options'),
            'target' => '',
            'class' => 'como_menu_item_class'
        ),
    ));
	$admin_bar->add_menu( array(
        'id'    => 'como-theme-social-options',
        'parent' => 'como-theme-options',
        'title' => 'Social Options',
        'href'  => '/wp-admin/themes.php?page=como_theme_options&tab=social_options',
        'meta'  => array(
            'title' => __('Social Options'),
            'target' => '',
            'class' => 'como_menu_item_class'
        ),
    ));
	$admin_bar->add_menu( array(
        'id'    => 'como-theme-seo-options',
        'parent' => 'como-theme-options',
        'title' => 'SEO Options',
        'href'  => '/wp-admin/themes.php?page=como_theme_options&tab=seo_options',
        'meta'  => array(
            'title' => __('SEO Options'),
            'target' => '',
            'class' => 'como_menu_item_class'
        ),
    ));
} 
// Remove Emoji Scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
// Remove Block CSS
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );
function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
} 
// Remove WordPress Version
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
function shapeSpace_remove_version_scripts_styles($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
// Function to Check Cache Theme Setting
if (!function_exists('checkCacheOption')) {
	function checkCacheOption() {
		if (get_option('como_theme_display_options')) {
			$displayOptions = get_option('como_theme_display_options');
			$cacheOptions = ((isset($displayOptions['como-cache-setting'])) ? $displayOptions['como-cache-setting'] : 'normal-caching');	
		} else {
			$cacheOptions = 'normal-caching'; 
		}
		return $cacheOptions;
	}
}
// Add Como Strap Styles to Header
function como_enqueue_style() {
	$cacheOptions = checkCacheOption(); 
		
	wp_enqueue_style('bootstrap', trailingslashit(get_template_directory_uri() ) . 'assets/bootstrap/css/como-custom-boot.min.css', false, '5.0.2');
	//wp_enqueue_style('fontawesome', trailingslashit(get_template_directory_uri() ) . 'fonts/fontawesome-pro-5.12.1-web/css/all.min.css', false, '5.12.1');
	wp_enqueue_style('fontawesome', trailingslashit(get_template_directory_uri() ) . 'fonts/fontawesome-pro-6.4.2-web/css/all.min.css', false, '6.4.2');

	if ( is_child_theme() ) {
        // load parent stylesheet first if this is a child theme
		if ($cacheOptions == 'no-caching') {
			wp_enqueue_style( 'parent-stylesheet', trailingslashit( get_template_directory_uri() ) . 'style.combined.min.css?v='. versionStamp(), false );
		} else {
			wp_enqueue_style( 'parent-stylesheet', trailingslashit( get_template_directory_uri() ) . 'style.combined.min.css', false );
		}
    }
    // load active theme stylesheet in both cases
    if ($cacheOptions == 'no-caching') {
		wp_enqueue_style( 'theme-stylesheet', get_stylesheet_uri() .'?v='. versionStamp(), false );
	} else {
		wp_enqueue_style( 'theme-stylesheet', get_stylesheet_uri(), false ); 
	}
}
add_action( 'wp_enqueue_scripts', 'como_enqueue_style', 2 );
// Add Como Strap Scripts to footer
function como_scripts_footer() {
	$cacheOptions = checkCacheOption();
	if ($cacheOptions == 'no-caching') {
		wp_enqueue_script('comostrap', trailingslashit(get_template_directory_uri()) .'js/como-strap.min.combined.js?v='. versionStamp(), array('jquery'), null, true);
	} else {
		wp_enqueue_script('comostrap', trailingslashit(get_template_directory_uri()) .'js/como-strap.min.combined.js', array('jquery'), null, true);	
	}
}
add_action( 'wp_enqueue_scripts', 'como_scripts_footer', 1 );
/* ##################### Navigation Menus ##################### */
// Define Default Menus
function register_como_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
	  'bottom-menu' => __( 'Bottom Menu' ),
	  'sitemap-menu' => __( 'Sitemap Menu' )
    )
  );
}
add_action( 'init', 'register_como_menus' );
// Add "dropdown-menu" class to submenu for Bootstrap
class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  	function start_lvl(&$output, $depth=0, $args = array()) {
    	$indent = str_repeat("\t", $depth);
    	$output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
  	}
}
// Add "dropdown" class to parent menu item if it has a dropdown
function menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'dropdown';
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'menu_set_dropdown', 10, 2 );
// Theme Options
require_once dirname( __FILE__ ) . '/includes/theme-options.php';
// Theme Images
require_once dirname( __FILE__ ) . '/includes/theme-images.php';
// Theme Widgets
require_once dirname( __FILE__ ) . '/includes/theme-widgets.php';
// Theme Menu Items
//require_once dirname( __FILE__ ) . '/includes/theme-menu-items.php';
// Section Pages
require_once dirname( __FILE__ ) . '/includes/sectional-page-repeater.php';
// Search Functions
require_once dirname( __FILE__ ) . '/includes/theme-search.php';
// Modal 
require_once dirname( __FILE__ ) . '/includes/theme-modal.php';
// Footer Scripts 
require_once dirname( __FILE__ ) . '/includes/theme-footer-scripts.php';
// Customizer 
require_once dirname( __FILE__ ) . '/includes/customizer.php';
// Recommended Plugins
require_once dirname( __FILE__ ) . '/includes/theme-plugins-activation.php';
/* ##################### Misc ##################### */
// Add Page Slug to Body Class
if (!function_exists('add_slug_body_class')) {
	function add_slug_body_class( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
		return $classes;
	}
	add_filter( 'body_class', 'add_slug_body_class' );
}
// Clean Link Title
if (!function_exists('cleanLinkTitle')) {
	function cleanLinkTitle($linkTitle) {
		$linkTitle = strip_tags($linkTitle);
		$linkTitle = str_replace(" ", "-", $linkTitle); // Replaces all spaces with hyphens.
		$linkTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $linkTitle); // Removes special chars.
		$linkTitle = preg_replace('/[ \t\n\r]+/', '-', $linkTitle);
		$linkTitle = preg_replace('/[ _]+/', '-', $linkTitle);
		$linkTitle = preg_replace('/-+/', '-', $linkTitle); // Replaces multiple hyphens with single one.
		$linkTitle = strtolower($linkTitle);
		return $linkTitle;
	}
}
// Custom Admin Stylesheet
add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
}
// Allow html tags in excerpt
function wpse_allowedtags() {
    return '<br>,<em>,<ul>,<ol>,<li>,<a>,<p>';
}
// Add Parallax Scrolling to Home section background (if specified)
function add_parallax_scripts() {
	//echo '<script src="'. trailingslashit( get_template_directory_uri()) .'js/parallax.js-1.4.2/parallax.min.js"></script>';
	//echo '<script src="'. trailingslashit( get_template_directory_uri()) .'js/parallax.js-1.5.0/parallax.min.js"></script>';
}
// Get Meta item ID by Meta Key
if (!function_exists('get_mid_by_key')) {
	function get_mid_by_key( $post_id, $meta_key ) {
		global $wpdb;
		$mid = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $meta_key) );
		if( $mid != '' )
			return (int)$mid;
		return false;
	}
}
// Get an attachment ID given a URL
if (!function_exists('get_attachment_id')) {
	function get_attachment_id( $url ) {
		$attachment_id = 0;
		$dir = wp_upload_dir();
		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
			$file = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				)
			);
			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta = wp_get_attachment_metadata( $post_id );
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}
		}
		return $attachment_id;
	}
}
/* Filter the "read more" excerpt string link to the post. */
function wpdocs_excerpt_more( $more ) {
    return sprintf( ' ... <a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More &#8250;', 'textdomain' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );
// Format Phone Number for Phone Link
if (!function_exists('formatPhoneLink')) {
	function formatPhoneLink($phoneNum,$ccode=1) {
		$phoneNum = $phoneNum;
		$phoneNum = preg_replace("/[^0-9]/", "", $phoneNum); 
		$phoneNum = '+'. $ccode . $phoneNum;
		return $phoneNum;
	}
}
// Customize Read More Link
function et_excerpt_more($more) {
    global $post;
    return '<a href="'. get_permalink($post->ID) . '" class="read-more">Read More</a>';
}
add_filter('excerpt_more', 'et_excerpt_more');
// Add Excerpts to Pages
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
/**
 * Add All Custom Post Types to search
 * Returns the main $query.
 * @access      public
 * @since       1.0
 * @return      $query
*/
function rc_add_cpts_to_search($query) {
	if( is_search() ) {
		// Get post types
		$post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
		$searchable_types = array();
		// Add available post types
		if( $post_types ) {
			foreach( $post_types as $type) {
				$searchable_types[] = $type->name;
			}
		}
		$searchable_types[] = 'nav_menu_item';
		$query->set( 'post_type', $searchable_types );
	}
	return $query;
}
add_action( 'pre_get_posts', 'rc_add_cpts_to_search' );
/* Woo Commerce Support */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
// Print String into Variable Function
if (!function_exists('insertStringText')) {
	function insertStringText($text,$txtdomain) {
		return __($text,$txtdomain);
	}
}
// Obfuscate Email Addresses
if (!function_exists('getObfuscatedEmailAddress')) {
	function getObfuscatedEmailAddress($email) {
		$alwaysEncode = array('.', ':', '@');
		$result = '';
		// Encode string using oct and hex character codes
		for ($i = 0; $i < strlen($email); $i++) {
			// Encode 25% of characters including several that always should be encoded
			if (in_array($email[$i], $alwaysEncode) || mt_rand(1, 100) < 25) {
				if (mt_rand(0, 1)) {
					$result .= '&#' . ord($email[$i]) . ';';
				} else {
					$result .= '&#x' . dechex(ord($email[$i])) . ';';
				}
			} else {
				$result .= $email[$i];
			}
		}
		return $result;
	}
}
if (!function_exists('getObfuscatedEmailLink')) {
	function getObfuscatedEmailLink($email, $params = array()) {
		if (!is_array($params)) {
			$params = array();
		}
		// Tell search engines to ignore obfuscated uri
		if (!isset($params['rel'])) {
			$params['rel'] = 'nofollow';
		}
		//$display = ((!isset($params['display'])) ? $params['display'] : false);
		$neverEncode = array('.', '@', '+'); // Don't encode those as not fully supported by IE & Chrome
		$urlEncodedEmail = '';
		for ($i = 0; $i < strlen($email); $i++) {
			// Encode 25% of characters
			if (!in_array($email[$i], $neverEncode) && mt_rand(1, 100) < 25) {
				$charCode = ord($email[$i]);
				$urlEncodedEmail .= '%';
				$urlEncodedEmail .= dechex(($charCode >> 4) & 0xF);
				$urlEncodedEmail .= dechex($charCode & 0xF);
			} else {
				$urlEncodedEmail .= $email[$i];
			}
		}
		$obfuscatedEmail = getObfuscatedEmailAddress($email);
		$obfuscatedEmailUrl = getObfuscatedEmailAddress('mailto:' . $urlEncodedEmail);
		$link = '<a href="' . $obfuscatedEmailUrl . '"';
		foreach ($params as $param => $value) {
			if ($param != 'content') {
				$link .= ' ' . $param . '="' . htmlspecialchars($value). '"';
			}
		}
		$link .= ' class="emailLink" aria-label="Send email" title="Send email">'. ((isset($params['content'])) ? ((!empty($params['content'])) ? $params['content'] : $obfuscatedEmail) : $obfuscatedEmail) .'</a>';
		return $link;
	}
}

// Leaving Site Text: [leaving-site-text custom='']
class Leaving_Site_Text_Shortcode {
	static function init() {
		add_shortcode('leaving-site-text', array(__CLASS__, 'handle_shortcode'));
	}
	static function handle_shortcode($atts) {
		if (!is_admin()) {
			$custom = (isset($atts['custom']) ? $atts['custom'] : false);
			$output = ($custom ? esc_attr($custom) : ((get_option('como_theme_display_options')['leaving-site-message']) ? esc_attr(get_option('como_theme_display_options')['leaving-site-message']) : 'You are about to leave this website.  Please confirm to continue.'));
			return $output;
		}
	}
}
Leaving_Site_Text_Shortcode::init();

// Allow fields to be added below the title and above the editor
if (!function_exists('ai_edit_form_after_title')) {
	function ai_edit_form_after_title() {
		global $post, $wp_meta_boxes;
		do_meta_boxes( get_current_screen(), 'after_title', $post );
		unset( $wp_meta_boxes['post']['after_title'] );
	}
	add_action( 'edit_form_after_title', 'ai_edit_form_after_title' );
}

// get Select Options
if (!function_exists('getSelectOptions')) {
	function getSelectOptions($options,$selected,$includeBlank=false) {
		$output = ''; 
		$output = (($includeBlank) ? '<option value="">&lt; select option &gt;</option>' : ''); 
		foreach ($options as $key => $value) {
			$output .= '<option value="'. $key .'"'. (($key == $selected) ? ' selected="selected"' : '') .'>'. $value .'</option>';
		}
		return $output;
	}
}

// Add Subtitle field to pages
if (!function_exists('pagesubtitle_create_post_meta_box')) {
	add_action( 'admin_menu', 'pagesubtitle_create_post_meta_box' );
	add_action( 'save_post', 'pagesubtitle_save_post_meta_box', 10, 2 );
	function pagesubtitle_create_post_meta_box() {
		add_meta_box( 'pagesubtitle-meta-box', 'Page Title/Subtitle Settings', 'pagesubtitle_post_meta_box', 'page', 'after_title', 'high' );
	}
	function pagesubtitle_post_meta_box( $object, $box ) { ?>
		<?php
			$titleMeta = get_post_meta($object->ID);
			$headerOptions = array('h1'=>'H1 Heading', 'h2'=>'H2 Heading', 'h3'=>'H3 Heading', 'h4'=>'H4 Heading', 'div'=>'DIV Element', 'p'=>'Paragraph Element');
		?>
		<div class="row como-admin">
			<div class="col col-12 col-lg-8">
				<p><em>These settings pertain to the main page header only.  The default main title element is h1, but can be overridden here.</em></p>
			</div>
			<div class="col col-12 col-lg-4">
				<div class="row">
					<label class="col-12 col-lg-5"><p>Main Title Element</p></label>
					<div class="col-12 col-lg-7 input-col">
						<p>
							<select id="pagetitle-element" name="pagetitle-element">
								<?=getSelectOptions($headerOptions,$titleMeta['pagetitle-element'][0],true)?>
							</select>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row como-admin">
			<div class="col col-12 col-lg-8">
				<p><input name="pagesubtitle" id="pagesubtitle" placeholder="Main Subtitle" tabindex="2" style="width: 97%;" value="<?php echo esc_html($titleMeta['pagesubtitle'][0]); ?>" /></p>
			</div>
			<div class="col col-12 col-lg-4">
				<div class="row">
					<label class="col-12 col-lg-5"><p>Subtitle Element</p></label>
					<div class="col-12 col-lg-7 input-col">
						<p>
							<select id="pagesubtitle-element" name="pagesubtitle-element">
								<?=getSelectOptions($headerOptions,$titleMeta['pagesubtitle-element'][0],true)?>
							</select>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row como-admin">
			<div class="col col-12 col-lg-8">
				<p><input name="pagesubtitle2" id="pagesubtitle2" placeholder="Secondary Subtitle" tabindex="2" style="width: 97%;" value="<?php echo esc_html($titleMeta['pagesubtitle2'][0]); ?>" /></p>
			</div>
			<div class="col col-12 col-lg-4">
				<div class="row">
					<label class="col-12 col-lg-5"><p>Secondary Subtitle Element</p></label>
					<div class="col-12 col-lg-7 input-col">
						<p>
							<select id="pagesubtitle2-element" name="pagesubtitle2-element">
								<?=getSelectOptions($headerOptions,$titleMeta['pagesubtitle2-element'][0],true)?>
							</select>
						</p>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="pagesubtitle_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
	<?php }
	function pagesubtitle_save_post_meta_box( $post_id, $post ) {
		if (isset($_POST['pagesubtitle_meta_box_nonce'])) {
			if ( !wp_verify_nonce( $_POST['pagesubtitle_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
				return $post_id;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			// Specify Meta Variables to be Updated
			$metaVars = array('pagetitle-element','pagesubtitle','pagesubtitle-element','pagesubtitle2','pagesubtitle2-element');
			// Update Meta Variables
			foreach ($metaVars as $var) {
				if(isset($_POST[$var])) {
					update_post_meta($post_id, $var, $_POST[$var]);
				}
			}
		}
	}
}
// Add Subtitle field to Posts
if (!function_exists('postsubtitle_create_post_meta_box')) {
	add_action( 'admin_menu', 'postsubtitle_create_post_meta_box' );
	add_action( 'save_post', 'postsubtitle_save_post_meta_box', 10, 2 );
	function postsubtitle_create_post_meta_box() {
		add_meta_box( 'postsubtitle-meta-box', 'Post Subtitle', 'postsubtitle_post_meta_box', 'post', 'after_title', 'high' );
	}
	function postsubtitle_post_meta_box( $object, $box ) { ?>
		<p><input name="postsubtitle" id="postsubtitle" width="100%" tabindex="2" style="width: 97%;" value="<?php echo esc_html( get_post_meta( $object->ID, 'postsubtitle', true ), 1 ); ?>" /></p>
		<input type="hidden" name="postsubtitle_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
	<?php }
	function postsubtitle_save_post_meta_box( $post_id, $post ) {
		if (isset($_POST['postsubtitle_meta_box_nonce'])) {
			if ( !wp_verify_nonce( $_POST['postsubtitle_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
				return $post_id;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			// Specify Meta Variables to be Updated
			$metaVars = array('postsubtitle');
			// Update Meta Variables
			foreach ($metaVars as $var) {
				if(isset($_POST[$var])) {
					update_post_meta($post_id, $var, $_POST[$var]);
				}
			}
		}
	}
}
/* Get Page/Post Title & Subtitle (if it has one) */
function getTitles($postID='', $titleType='', $titleLink='', $headClass='', $mtClass='', $stClass='', $st2Class='', $override=array()) {
	$output = '';
	if ($titleType == 'section') {
		$headerClass = 'section-header';
		//$titleElemment = 'h2';
		$titleElemment = ((isset($override['title'])) ? $override['title'] : 'h2');
		$titleClass = 'section-title';
		//$subtitleElemment = 'h3';
		$subtitleElemment = ((isset($override['subtitle'])) ? $override['subtitle'] : 'h3');
		$subtitleClass = 'section-subtitle';
	} elseif ($titleType == 'page') {
		$headerClass = 'page-header';
		//$titleElemment = 'h2';
		$titleElemment = ((isset($override['title'])) ? $override['title'] : 'h1');
		$titleClass = 'page-title';
		//$subtitleElemment = 'h3';
		$subtitleElemment = ((isset($override['subtitle'])) ? $override['subtitle'] : 'h2');				  
		$subtitleClass = 'page-subtitle';
		$subtitle2Elemment = ((isset($override['subtitle2'])) ? $override['subtitle2'] : 'h3');				  
		$subtitle2Class = 'page-second-subtitle';
	} else {
		$headerClass = 'post-header';
		//$titleElemment = 'h2';
		$titleElemment = ((isset($override['title'])) ? $override['title'] : 'h1');
		$titleClass = 'post-title';
		//$subtitleElemment = 'h3';
		$subtitleElemment = ((isset($override['subtitle'])) ? $override['subtitle'] : 'h2');				  
		$subtitleClass = 'post-subtitle';
	}
	if ($titleType == 'post') {
		$subtitle = get_post_meta($postID,'postsubtitle',true);
	} else {
		$subtitle = get_post_meta($postID,'pagesubtitle',true);
		$subtitle2 = get_post_meta($postID,'pagesubtitle2',true);
	}
	$h1Class = (($subtitle) ? 'has-subtitle' : '');
	$output .= '<header class="'. $headerClass .' '. $headClass .'">';
	if (!empty($titleLink)) { $output .= '<a href="'. $titleLink .'">'; }
	$output .= '<'. $titleElemment .' class="'. $titleClass .' '. $h1Class .' '. $mtClass .'">'. get_the_title($postID) .'</'. $titleElemment .'>';
	if (!empty($titleLink)) { $output .= '</a>'; }
	if (isset($subtitle)) { $output .= '<'. $subtitleElemment .' class="'. $subtitleClass .' '. $stClass .'">'. $subtitle .'</'. $subtitleElemment .'>'; }
	if (isset($subtitle2)) { $output .= '<'. $subtitle2Elemment .' class="'. $subtitle2Class .' '. $st2Class .'">'. $subtitle2 .'</'. $subtitle2Elemment .'>'; }
	$output .= '</header>';
	return $output;
}
/* Format Section Title & Subtitle (if it has one) */
if (!function_exists('formatSectionTitles')) {
	//function formatSectionTitles($title='', $subtitle='', $subtitle2='', $titleLink='', $headerClass='', $mtClass='', $stClass='', $st2Class='', $titleType='section', $reverse=false, $headerOverride=false) {
	function formatSectionTitles($title='', $subtitle='', $subtitle2='', $titleLink='', $headerClass='', $mtClass='', $stClass='', $st2Class='', $titleType='section', $titleElement='', $subtitleElement='', $subtitle2Element='', $reverse=false, $headerOverride=false) {
		$output = '';
		
		
		//pagetitle-element','pagesubtitle','pagesubtitle-element','pagesubtitle2','pagesubtitle2-element
		
		if ((!empty($title)) || (!empty($subtitle))) {
			if ($titleType == 'section') {
				$headerClass .= ' section-header';
				$titleElemment = 'h2';
				$titleClass = 'section-title';
				$subtitleElemment = 'h3';
				$subtitleClass = 'section-subtitle';
			} elseif ($titleType == 'page') {
				$headerClass .= ' page-header';
				$titleElemment = (($titleElement) ? $titleElement : 'h1');
				$titleClass = 'page-title';
				$subtitleElemment = (($subtitleElement) ? $subtitleElement : 'h2');
				$subtitleClass = 'page-subtitle';
				$subtitle2Elemment = (($subtitle2Element) ? $subtitle2Element : 'h3');
				$subtitle2Class = 'page-second-subtitle';
			} else {
				$headerClass  = 'post-header';
				$titleElemment = 'h1';
				$titleClass = 'post-title';
				$subtitleElemment = 'h2';
				$subtitleClass = 'post-subtitle';
			}
			
			if ($headerOverride) {
				$titleElemment = $headerOverride;
			}
			
			if ($subtitle) { $subtitle = '<'. $subtitleElemment .' class="'. $subtitleClass .' '. $stClass .'">'. htmlspecialchars_decode($subtitle) .'</'. $subtitleElemment .'>'; }
			if ($subtitle2) { $subtitle2 = '<'. $subtitle2Elemment .' class="'. $subtitle2Class .' '. $st2Class .'">'. htmlspecialchars_decode($subtitle2) .'</'. $subtitle2Elemment .'>'; }
			$h1Class = (($subtitle) ? 'has-subtitle' : '');
			$output .= '<header class="'. $headerClass .'" role="heading">';
			if ($reverse) {
				if ($subtitle) { $output .= $subtitle; }
				if (!empty($titleLink)) { $output .= '<a href="'. $titleLink .'">'; }
				$output .= '<'. $titleElemment .' class="'. $titleClass .' '. $h1Class .' '. $mtClass .'">'. htmlspecialchars_decode($title) .'</'. $titleElemment .'>';
				if (!empty($titleLink)) { $output .= '</a>'; }
				if ($subtitle2) { $output .= $subtitle2; }
			} else {
				if (!empty($titleLink)) { $output .= '<a href="'. $titleLink .'">'; }
				$output .= '<'. $titleElemment .' class="'. $titleClass .' '. $h1Class .' '. $mtClass .'">'. htmlspecialchars_decode($title) .'</'. $titleElemment .'>';
				if (!empty($titleLink)) { $output .= '</a><!-- -->'; }
				if ($subtitle) { $output .= $subtitle; }
				if ($subtitle2) { $output .= $subtitle2; }
			}
			$output .= '</header>';
		}
		return $output;
	}
}

if (!function_exists('getPageHeaderComo')) {
	function getPageHeaderComo($pID, $mainInfo) {
		
		// Get Title Info
		$mainTitle = get_the_title($pID);
		$mainTitleElement = get_post_meta($pID,'pagetitle-element',true);
		$mainSubtitle = get_post_meta($pID,'pagesubtitle',true);
		$mainSubtitleElement = get_post_meta($pID,'pagesubtitle-element',true);
		$secondSubtitle = get_post_meta($pID,'pagesubtitle2',true);	 
		$secondSubtitleElement = get_post_meta($pID,'pagesubtitle2-element',true);
		
		$mainHeader = formatSectionTitles($title=$mainTitle, $subtitle=$mainSubtitle, $subtitle2=$secondSubtitle, $titleLink=$mainInfo['titleLink'], $headerClass=$mainInfo['headerClass'], $mtClass=$mainInfo['titleClass'], $stClass=$mainInfo['subtitleClass'], $st2Class=$mainInfo['subtitle2Class'], $titleType='page', $titleElement=$mainTitleElement, $subtitleElement=$mainSubtitleElement, $subtitle2Element=$secondSubtitleElement, $reverse=false, $headerOverride=false);	 
					 
		return $mainHeader;
	}
}

// Add Menu Embed Shortcode
// [menu name='' class='']
function print_menu_shortcode($atts, $content = null) {
	extract(shortcode_atts(array( 'name' => null, 'class' => null ), $atts));
	return wp_nav_menu( array( 'menu' => $name, 'menu_class' => $atts['class'], 'echo' => false ) );
}
add_shortcode('menu', 'print_menu_shortcode');
if (!function_exists('customExcerpt')) {
	function customExcerpt($text, $max_length = 140, $cut_off = '...', $keep_word = false) {
		if(strlen($text) <= $max_length) {
			return $text;
		}
		if(strlen($text) > $max_length) {
			if($keep_word) {
				$text = substr($text, 0, (int)$max_length + 1);
				if($last_space = strrpos($text, ' ')) {
					$text = substr($text, 0, $last_space);
					$text = rtrim($text);
					$text .=  $cut_off;
				}
			} else {
				$text = substr($text, 0, $max_length);
				$text = rtrim($text);
				$text .=  $cut_off;
			}
		}
		return $text;
	}
}
// Allow Editors to Edit Privacy Policy Page
add_action('map_meta_cap', 'custom_manage_privacy_options', 1, 4);
function custom_manage_privacy_options($caps, $cap, $user_id, $args) {
  if ('manage_privacy_options' === $cap) {
    $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
    $caps = array_diff($caps, [ $manage_name ]);
  }
  return $caps;
}
// Show Sidebar with Shortcode [get_sidebar name='']
function sidebar_shortcode($atts, $content="null"){
	extract(shortcode_atts(array('name' => ''), $atts));
  	ob_start();
  	get_sidebar($name);
  	$sidebar= ob_get_contents();
  	ob_end_clean();
  	return $sidebar;
}
add_shortcode('get_sidebar', 'sidebar_shortcode');
// Add Sidebar Select to CMS
class PageSidebarSelect {
	public function __construct() {
		add_action( 'admin_init', array($this, 'sidebarMetaBox'));
		add_action( 'save_post', array($this, 'saveSidebar'));
	}
	public function sidebarMetaBox() {
		$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : '');
		if ($post_id) {
			$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
			if (strpos($template_file, 'sidebar') !== false) {
				//add_meta_box('sidebar-meta', 'Sidebar', array(&$this, 'sidebarMetaOptions'), 'post', 'side', 'low');
				add_meta_box('sidebar-meta', 'Sidebar', array(&$this, 'sidebarMetaOptions'), 'page', 'side', 'low');
			}
		}
	}
	public function sidebarMetaOptions() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		$custom = get_post_custom($post->ID);
		$sidebar = (isset($custom['sidebar']) ? strtolower($custom['sidebar'][0]) : '');
		$horizontalClass = (isset($custom['horizontalClass']) ? strtolower($custom['horizontalClass'][0]) : '');
	?>
    	<select name="sidebar" style="width: 100%">
			<?php
				$nosbSel = '';
				$parentSel = '';
				$defaultSel = '';
				if ($sidebar == 'no-sidebar') {
					$nosbSel = 'selected="selected"';
				} elseif ($sidebar == 'parent') {
					if (wp_get_post_parent_id($post->ID)) {
						$p = wp_get_post_parent_id($post->ID);
						$parentPost = get_post_custom($p);
						$parentSB = strtolower($parentPost['sidebar'][0]);
						$parentSel = 'selected="selected"';
					}
				} else {
					$defaultSel = 'selected="selected"';
				}
			?>
			<option value="" <?=$defaultSel?>>Default Sidebar</option>
			<option value="parent" <?=$parentSel?>>Parent Sidebar</option>
			<?php
				foreach ($GLOBALS['wp_registered_sidebars'] as $sb) {
					?>
					<?php
					if ((!strpos($sb['id'], 'footer')) && (!strpos($sb['id'], 'header'))) {
						$sbSelected = (($sidebar==$sb['id']) ? 'selected="selected"' : '');
						?>
						<option value="<?=$sb['id']?>" <?=$sbSelected?>><?=$sb['name']?></option>
					<?php
					}
				}
			?>
			<option value="no-sidebar" <?=$nosbSel?>>No Sidebar</option>
		</select>
		<div class="form-section">
			<h4>Column Settings</h4>
			<select name="horizontalClass" class="horizontalClass"  style="width: 100%">
				<?php 
					foreach ($GLOBALS['horizontalOptions'] as $key=>$value) {
						echo '<option value="'. $key .'" '. (($key==$horizontalClass) ? ' selected="selected"' : '') .'>'. $value .'</option>'; 
					}
				?>
			</select>
			<?php
				$layoutDisplay = (($horizontalClass == 'global') ? 'hide' : '');
				$rowClasses = (isset($custom['rowClasses']) ? $custom['rowClasses'][0] : '');
				$contentClasses = (isset($custom['contentClasses']) ? $custom['contentClasses'][0] : '');
				$sidebarClasses = (isset($custom['sidebarClasses']) ? $custom['sidebarClasses'][0] : '');
			?>
			<div class="layout-settings <?=$layoutDisplay?>">
				<p><label>Main Row Classes</label><br><input type="text" name="rowClasses" value="<?=$rowClasses?>" style="width: 100%;"></p>
				<p><label>Content Column Classes</label><br><input type="text" name="contentClasses" value="<?=$contentClasses?>" style="width: 100%;"></p>
				<p><label>Sidebar Column Classes</label><br><input type="text" name="sidebarClasses" value="<?=$sidebarClasses?>" style="width: 100%;"></p>
			</div>
		</div>
		<input type="hidden" name="pagesidebar_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		<script type="text/javascript">
			jQuery(document).ready(function( $ ){
				$('body').on('change', '.horizontalClass', function() {
					var $thisValue = $(this).val();
					var $layoutSettings = $(this).parent('.form-section').find('.layout-settings');
					
					console.log('$thisValue: '+ $thisValue);
					
					// Show/Hide Sidebar column Width Form
					if ($thisValue === 'global') {
						$layoutSettings.addClass('hide');
					} else {
						$layoutSettings.removeClass('hide');
					}
				});
			});
		</script>
    <?php
	}
	public function saveSidebar(){
		global $post;
		if (isset($_POST['pagesidebar_meta_box_nonce'])) {
			if ( !wp_verify_nonce($_POST['pagesidebar_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
				return $post_id;
			if ( !current_user_can( 'edit_post', $post->ID ) )
				return $post_id;
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
				return $post_id;
			} else {
				update_post_meta($post->ID, 'sidebar', $_POST['sidebar']);
				update_post_meta($post->ID, 'horizontalClass', $_POST['horizontalClass']);
				update_post_meta($post->ID, 'rowClasses', $_POST['rowClasses']);
				update_post_meta($post->ID, 'contentClasses', $_POST['contentClasses']);
				update_post_meta($post->ID, 'sidebarClasses', $_POST['sidebarClasses']);
			}
		}
	}
}
$sidebar = new PageSidebarSelect();
// Get Layout Information
if (!function_exists('getLayout')) {
	function getLayout($pid) {
		$horizontalClass = ''; 
		$rowClasses = ''; 
		$contentClasses = ''; 
		$sidebarClasses = ''; 
		$layout = get_option('como_theme_display_options');
		$meta = get_post_meta($pid);
		
		//print_r($meta);
		
		if ($meta['sidebar'] != 'no-sidebar') {
			$horizontalClass = (isset($meta['horizontalClass']) ? $meta['horizontalClass'][0] : '');
			if ($horizontalClass == 'global') {
				$horizontalClass = ''; 
				$rowClasses = (isset($layout['global-row-class']) ? $layout['global-row-class'] : '');
				$contentClasses = (isset($layout['global-content-class']) ? $layout['global-content-class'] : 'col col-12 col-xs-12 col-sm-12 col-md-8 col-lg-9');
				$sidebarClasses = (isset($layout['global-aside-class']) ? $layout['global-aside-class'] : 'col col-12 col-xs-12 col-sm-12 col-md-4 col-lg-3');
			} else {
				$horizontalClass = (!empty($horizontalClass) ? $horizontalClass : '');
				$rowClasses = (isset($meta['rowClasses']) ? $meta['rowClasses'][0] : '');
				$contentClasses = (isset($meta['contentClasses']) ? $meta['contentClasses'][0] : '');
				$sidebarClasses = (isset($meta['sidebarClasses']) ? $meta['sidebarClasses'][0] : '');
			}
		}
		$layoutArray = array(
			'horizontal' => $horizontalClass,
			'row' => $rowClasses,
			'content' => $contentClasses,
			'sidebar' => $sidebarClasses,
			'sidebar-id' => $meta['sidebar'][0]
		);
		return $layoutArray;
	}
}
// Remove http / https and www from string
if (!function_exists('remove_http')) {
	function remove_http($url) {
	   $disallowed = array('http://www.','https://www.','http://','https://','www.');
	   foreach($disallowed as $d) {
		  if(strpos($url, $d) === 0) {
			 return str_replace($d, '', $url);
		  }
	   }
	   return $url;
	}
}
// Mobile Social Shortcode [mobileIcons facebook='' twitter='' threads='' linkedin='' youtube='' pinterest='' email='']
if (!function_exists('mobileSocial')) {
	function mobileSocial($atts) {
		$socialicons = array(
			'facebook' => '<i class="fab fa-brands fa-facebook-f"></i>',
			'twitter' => '<i class="fab fa-brands fa-x-twitter"></i>',
			'threads' => '<i class="fab fa-brands fa-threads"></i>',
			'linkedin' => '<i class="fab fa-brands fa-linkedin-in"></i>',
			'youtube' => '<i class="fab fa-brands fa-youtube"></i>',
			'pinterest' => '<i class="fab fa-brands fa-pinterest-p"></i>',
			'email' => '<i class="fas fa-solid fa-envelope"></i>'
		);
		$icons = '';
		$icons = '<div id="mobileShare" class="mobile-icons">';
		if (function_exists('pf_show_link')) { $icons .= pf_show_link(); }
		$socialOptions = get_option('como_theme_social_options');
		$obj_id = get_queried_object_id();
		$current_url = get_permalink( $obj_id );
		$title = get_the_title($obj_id);
		$excerpt = get_the_excerpt($obj_id);
		$image = ((has_post_thumbnail($obj_id)) ? get_the_post_thumbnail_url($obj_id, 'medium') : '');
		$networks = array(
			'facebook'=>array(
				'url'=>'https://www.facebook.com/sharer/sharer.php?u='. $current_url,
				'icon'=>'<i class="fab fa-brands fa-facebook-f"></i>',
				'follow-title'=>'Follow us on Facebook',
				'share-title'=>'Share on Facebook'
			),
			'twitter'=>array(
				'url'=>'https://twitter.com/intent/tweet?text='. $title .' '. $current_url,
				'icon'=>'<i class="fab fa-brands fa-x-twitter"></i>',
				'follow-title'=>'Follow us on Twitter',
				'share-title'=>'Tweet This'
			),
			'threads'=>array(
				'url'=>'https://threads.net',
				'icon'=>'<i class="fab fa-brands fa-threads"></i>',
				'follow-title'=>'Follow us on Threads',
				'share-title'=>'Thread This'
			),
			'linkedin'=>array(
				'url'=>'https://www.linkedin.com/shareArticle?mini=true&url='. $current_url .'&title='. $title .'&summary='. $excerpt,
				'icon'=>'<i class="fab fa-brands fa-linkedin-in"></i>',
				'follow-title'=>'Connect on LinkedIn',
				'share-title'=>'Share on LinkedIn'
			),
			'youtube'=>array(
				'url'=>'https://youtube.com',
				'icon'=>'<i class="fab fa-brands fa-youtube"></i>',
				'follow-title'=>'Follow us on YouTube',
				'share-title'=>'Follow us on YouTube'
			),
			'pinterest'=>array(
				'url'=>'https://pinterest.com/pin/create/button/?url='. $image .'&media='. $current_url .'&description='. $title,
				'icon'=>'<i class="fab fa-brands fa-pinterest-p"></i>',
				'follow-title'=>'Visit us on Pinterest',
				'share-title'=>'Share on Pinterest'
			),
			'email'=>array(
				'url'=>'mailto:?&subject='. $title .'&body='. $current_url,
				'icon'=>'<i class="fas fa-solid fa-envelope"></i>',
				'follow-title'=>'Email Us',
				'share-title'=>'Email This'
			)
		);
		foreach ($networks as $key => $val) {
			if (isset($atts[$key])) {
				if (!empty($atts[$key])) {
					$url = (($key == 'email') ? getObfuscatedEmailAddress($atts[$key]) : $atts[$key]);
					$title = $val['follow-title']; 
				} elseif (isset($socialOptions[$key])) {
					if (!empty($socialOptions[$key])) {
						$url = $socialOptions[$key];
						$url = (($key == 'email') ? 'mailto:'.getObfuscatedEmailAddress($socialOptions[$key]) : $socialOptions[$key]);
						$title = $val['follow-title'];
					} else {
						$url = $val['url'];
						$title = $val['share-title'];
					}
				}
				$icons .= ((isset($url)) ? '<a href="'. $url .'" target="_blank" title="'. $title .'" class="socialLink '. $key .'">'. $val['icon'] .'</a>' : '');
			}
		}	
		$icons .= '</div>';
		return $icons;
	}
	add_shortcode('mobileIcons', 'mobileSocial');
}
/**
 * Opens a specified metabox (id) by default for the current user.
 * User settings for the specified metabox are reset after reload. Other metabox settings will apply.
 * @author Hendrik Schuster <contact@deviantdev.com>
 * @param  string $postType  The (custom_)post_type 
 * @param  int    $metaBoxID The distinct metabox id
 */
function dd_open_metabox_by_default( $postType, $metaBoxID ) {
	$optionUserID = get_current_user_id();
	$optionName = 'closedpostboxes_' . $postType;
	$optionValue = get_user_option( $optionName, $optionUserID );
	$optionValue = is_array( $optionValue ) ? $optionValue : array();
	if( ( $key = array_search( $metaBoxID, $optionValue ) ) !== false ) {
		unset( $optionValue[$key] );
		update_user_option( $optionUserID, $optionName, $optionValue, true );
	}
}
/**
 * Closes a specified metabox (id) by default for the current user.
 * User settings for the specified metabox are reset after reload. Other metabox settings will apply.
 * @author Hendrik Schuster <contact@deviantdev.com>
 * @param  string $postType  The (custom_)post_type 
 * @param  int    $metaBoxID The distinct metabox id
 */
function dd_close_metabox_by_default( $postType, $metaBoxID ) {
	$optionUserID = get_current_user_id();
	$optionName = 'closedpostboxes_' . $postType;
	$optionValue = get_user_option( $optionName, $optionUserID );
	$optionValue = is_array( $optionValue ) ? $optionValue : array();
	if( !in_array( $metaBoxID, $optionValue ) ) {
		update_user_option( $optionUserID, $optionName, array_merge( $optionValue, array( $metaBoxID ) ), true );
	}
}
/**
* Hide Draft Pages from the menu
*/
if (!function_exists('filter_draft_pages_from_menu')) {
	function filter_draft_pages_from_menu ($items, $args) {
		foreach ($items as $ix => $obj) {
			if (!is_user_logged_in () && 'draft' == get_post_status ($obj->object_id)) {
				unset ($items[$ix]);
			}
		}
		return $items;
	}
	add_filter ('wp_nav_menu_objects', 'filter_draft_pages_from_menu', 10, 2);
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
	if (in_array('current-menu-item', $classes) ){
		$classes[] = 'active-menu-item ';
	}
	return $classes;
}
function is_tree($pid) {
	global $post;
	$ancestors = get_post_ancestors($post->$pid);
	//$root = count($ancestors) - 1;
	//$parent = (($root> 0) ? $ancestors[$root] : 0);
	if(is_page() && (is_page($pid) || $post->post_parent == $pid || in_array($pid, $ancestors))) {
		return true;
	} else {
		return false;
	}
};
// Retrieve Template Name
function getTemplateName( $page_id = null ) {
    if ( ! $template = get_page_template_slug( $page_id ) )
        return;
    if ( ! $file = locate_template( $template ) )
        return;
    $data = get_file_data(
        $file,
        array(
            'Name' => 'Template Name',
        )
    );
    return $data['Name'];
}
// Check Even Odd Tool
if (!function_exists('checkEvenOdd')) {
	function checkEvenOdd($number) {
		if($number % 2 == 0){
			return "even"; 
		} else {
			return "odd";
		}
	}
}
// Check if Pgae Exists
if (!function_exists('checkPageExists')) {
	function checkPageExists($post_title) {
		$exists = false;
		if (get_page_by_title($post_title) === null) {
			$exists = false;
		} else {
			$exists = true;
		}
		return $exists;
	}
}