<?php
/* ################## Theme Options ################## */
// Add Theme Logo
add_theme_support('custom-logo');
function como_custom_logo() {
    $output = '';
    if (function_exists('get_custom_logo'))
        $output = get_custom_logo();
    if (empty($output))
        $output = '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
    echo $output;
}
add_filter('get_custom_logo', 'custom_logo_output', 10);
function custom_logo_output( $html ){
	$html = str_replace('"custom-logo"', '"custom-logo img-fluid"', $html);
	$html = str_replace('custom-logo-link', 'custom-logo-link scroll-top-home get_custom_logo', $html);
	return $html;
}
function como_theme_menu() {
    add_theme_page(
        'Theme Options',		// The title to be displayed in the browser window for this page.
        'Theme Options',		// The text to be displayed for this menu item
        'administrator',		// Which type of users can see this menu item
        'como_theme_options',	// The unique ID - that is, the slug - for this menu item
        'como_theme_display'	// The name of the function to call when rendering this menu's page
    );
}
add_action( 'admin_menu', 'como_theme_menu' );
 
/* Make Theme Settings Page */
function como_theme_display() {
	
	wp_enqueue_media();
	
	// Registers and enqueues the required javascript.
	wp_register_script('como-image-upload', get_template_directory_uri( __FILE__ ) . '/js/como-image-uploader.js', array('jquery'));
	wp_localize_script('como-image-upload', 'meta_image',
		array(
			'title' => 'Choose or Upload an Image',
			'button' => 'Use this image',
		)
	);
	wp_enqueue_script('como-image-upload');
	
	?>
    <div class="wrap">
     
        <div id="icon-themes" class="icon32"></div>
        <h2>Theme Options</h2>
        <?php settings_errors(); ?>
         
        <?php
            if (isset($_GET['tab'])) {
                $active_tab = (isset($_GET['tab']) ? $_GET['tab'] : 'display_options');
            } else {
				$active_tab = 'display_options';
			}
			
        ?>
         
        <h2 class="nav-tab-wrapper">
            <a href="?page=como_theme_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>">Display Options</a>
            <a href="?page=como_theme_options&tab=contact_options" class="nav-tab <?php echo $active_tab == 'contact_options' ? 'nav-tab-active' : ''; ?>">Contact Options</a>
			<a href="?page=como_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Options</a>
			<a href="?page=como_theme_options&tab=seo_options" class="nav-tab <?php echo $active_tab == 'seo_options' ? 'nav-tab-active' : ''; ?>">SEO Options</a>
        </h2>
         
        <form method="post" action="options.php">
 	        <?php 
				if ($active_tab == 'contact_options') {	
					settings_fields('como_theme_contact_options');
					do_settings_sections('como_theme_contact_options');
				} elseif ($active_tab == 'social_options') {	
					settings_fields('como_theme_social_options');
					do_settings_sections('como_theme_social_options');
				} elseif ($active_tab == 'seo_options') {	
					settings_fields('como_theme_seo_options');
					do_settings_sections('como_theme_seo_options');
				} else {
					settings_fields('como_theme_display_options');
            		do_settings_sections('como_theme_display_options'); 
				}
            	submit_button(); 
			?>
        </form>
         
    </div><!-- /.wrap -->
<?php
} // end como_theme_display
 
function como_initialize_theme_options() {
    // If the theme options don't exist, create them.
    if( false == get_option( 'como_theme_display_options' ) ) {  
        add_option( 'como_theme_display_options' );
    } // end if
 
    // Register Display Settings Section
    add_settings_section(
        'como_theme_display_options',         // ID used to identify this section and with which to register options
        'Display Options',                  // Title to be displayed on the administration page
        'como_general_options_callback', 	// Callback used to render the description of the section
        'como_theme_display_options'     	// Page on which to add this section of options
    );
	
	// Add Cache / No Cache Option
	add_settings_field(
		'como-cache-setting',
		'Cache Setting',
		'como_select_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'como-cache-setting',
			'Cache settings for site - Meant to be used for Development and New Launches',
			array('normal-caching'=>'Normal Caching (caching on)','no-caching'=>'No Caching (caching off)')
        )
	);
	
	// Add SEO Logo Option
	add_settings_field(
		'como_seo_logo',					// ID used to identify the field throughout the theme 
		'SEO Logo', 						// The label to the left of the option interface element
		'display_como_seo_logo_element',	// The name of the function responsible for rendering the option interface 
		'como_theme_display_options', 		// The page on which this option will be displayed
		'como_theme_display_options',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
            'Select logo for SEO Schema Structured Data'
        )
	);
	
	// Add Custom Login Logo Option
	add_settings_field(
		'como_login_logo',					// ID used to identify the field throughout the theme 
		'Login Logo', 						// The label to the left of the option interface element
		'display_como_login_logo_element',	// The name of the function responsible for rendering the option interface 
		'como_theme_display_options', 		// The page on which this option will be displayed
		'como_theme_display_options',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
            'Select custom logo for WordPress Login Page'
        )
	);
	
	// Add Custom Footer Copyright Field
	add_settings_field(
		'footer-custom-copyright',
		'Custom Copyright Text',
		'como_text_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'footer-custom-copyright',
			'Custom footer copyright language to override default'
        )
	);
	
	// Add Custom "Leaving Site" Message Field
	add_settings_field(
		'leaving-site-message',
		'Custom "Leaving Site" Text',
		'como_text_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'leaving-site-message',
			'Custom "Leaving Site" text for popup if ised (.confirm-link)'
        )
	);
	
	// Add Global Row Class
	add_settings_field(
		'global-row-class',
		'Global Row Classes',
		'como_text_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'global-row-class',
			'Global Content Row Classes that may be applied to all subpages that contain asides'
        )
	);
	
	// Add Global Content Class
	add_settings_field(
		'global-content-class',
		'Global Content Classes',
		'como_text_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'global-content-class',
			'Global Content Column Classes that may be applied to all subpages that contain asides'
        )
	);
	
	// Add Global Aside Class
	add_settings_field(
		'global-aside-class',
		'Global Aside Classes',
		'como_text_callback',
		'como_theme_display_options',
		'como_theme_display_options',
		array(
			'como_theme_display_options',
			'global-aside-class',
			'Global Aside Column Classes that may be applied to all subpages that contain asides'
        )
	);
	register_setting( 'como_theme_display_options', 'como_theme_display_options');
	
	// Register Contact Settings Section 
    if( false == get_option( 'como_theme_contact_options' ) ) {  
        add_option( 'como_theme_contact_options' );
    }
	add_settings_section(
        'como_theme_contact_options',	// ID used to identify this section and with which to register options
        'Contact Options',              	// Title to be displayed on the administration page
        'como_contact_options_callback', // Callback used to render the description of the section
        'como_theme_contact_options'		// Page on which to add this section of options
    );
	
	// Add Email Address Option
	add_settings_field(
		'email',
		'Contact Email Address',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'email',
			'Add Contact Email'
        )
	);
	
	// Add Phone Option
	add_settings_field(
		'phone',
		'Contact Phone Number',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'phone',
			'Add Phone Number (Separate multiple numbers with "/")'
        )
	);
	
	// Add Vanity Phone Option
	add_settings_field(
		'vanity-phone',
		'Vanity Phone Number',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'vanity-phone',
			'Add Vanity Phone Number'
        )
	);
	
	// Add Fax Option
	add_settings_field(
		'fax',
		'Contact Fax Number',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'fax',
			'Add Fax Number (Separate multiple numbers with "/")'
        )
	);
	
	// Add Location Name Option
	add_settings_field(
		'locName',
		'Location Name',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'locName',
			'Add Location Name'
        )
	);
	
	// Add Street Option
	add_settings_field(
		'street',
		'Street Address',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'street',
			'Add Street Address'
        )
	);
	
	// Add Suite Option
	add_settings_field(
		'suite',
		'Suite / Address 2',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'suite',
			'Add Suite / Address 2'
        )
	);
	
	// Add City Option
	add_settings_field(
		'city',
		'City',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'city',
			'Add City'
        )
	);
	
	// Add State Option
	add_settings_field(
		'state',
		'State',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'state',
			'Add State'
        )
	);
	
	// Add Zipcode Option
	add_settings_field(
		'zip',
		'Zipcode',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'zip',
			'Add Zipcode'
        )
	);
	
	// Add Country Option
	add_settings_field(
		'country',
		'Country',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'country',
			'Add Country'
        )
	);
	
	/*
	// Add Lattitude Option
	add_settings_field(
		'lattitude',
		'Lattitude',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'lattitude',
			'Add Lattitude'
        )
	);
	
	// Add Longitude Option
	add_settings_field(
		'longitude',
		'Longitude',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'longitude',
			'Add Longitude'
        )
	);
	
	// Add Google Map Link
	add_settings_field(
		'google_map_link',
		'Google Map Link',
		'como_text_callback',
		'como_theme_contact_options',
		'como_theme_contact_options',
		array(
			'como_theme_contact_options',
			'google_map_link',
			'Add Google Map Link'
        )
	);*/
	register_setting( 'como_theme_contact_options', 'como_theme_contact_options', 'como_theme_sanitize_contact_options');
	
	// Register Social Settings Section 
    if( false == get_option( 'como_theme_social_options' ) ) {  
        add_option( 'como_theme_social_options' );
    }
	add_settings_section(
        'como_theme_social_options',	// ID used to identify this section and with which to register options
        'Social Options',              	// Title to be displayed on the administration page
        'como_social_options_callback', // Callback used to render the description of the section
        'como_theme_social_options'		// Page on which to add this section of options
    );
	
	// Add Facebook URL Option
	add_settings_field(
		'facebook',						// ID used to identify the field throughout the theme 
		'Facebook Profile Url', 		// The label to the left of the option interface element
		'como_text_callback',		// The name of the function responsible for rendering the option interface 
		'como_theme_social_options', 	// The page on which this option will be displayed
		'como_theme_social_options',	// The name of the section to which this field belongs
		array(
			'como_theme_social_options',
			'facebook',
            'Add Facebook URL'
        )
	);
	
	// Add Twitter URL Option
	add_settings_field(
		'twitter',						
		'Twitter X Profile Url',
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'twitter',
            'Add Twitter X URL'
        )
	);
	
	// Add Threads URL Option
	add_settings_field(
		'threads',						
		'Threads Profile Url',
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'threads',
            'Add Threads URL'
        )
	);
	
	// Add YouTube URL Option
	add_settings_field(
		'youtube',
		'YouTube Profile Url', 
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'youtube',
            'Add YouTube URL'
        )
	);
	
	// Add LinkeIn URL Option
	add_settings_field(
		'linkedin',
		'LinkedIn Profile Url', 
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'linkedin',
			'Add LinkedIn URL'
        )
	);
	
	// Add Instagram URL Option
	add_settings_field(
		'instagram',
		'Instagram Profile Url',
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'instagram',
			'Add Pnstagram URL'
        )
	);
	
	// Add Pinterest URL Option
	add_settings_field(
		'pinterest',
		'Pinterest Profile Url',
		'como_text_callback',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'como_theme_social_options',
			'pinterest',
			'Add Pinterest URL'
        )
	);
	
	// Add Default Social Image Option
	add_settings_field(
		'default_social_image',
		'Default Social Image',
		'display_como_default_social_image_element',
		'como_theme_social_options',
		'como_theme_social_options',
		array(
			'Select default image for social sharing'
		)
	);
	register_setting( 'como_theme_social_options', 'como_theme_social_options', 'como_theme_sanitize_social_options');
	
	// Register SEO Settings Section 
    if( false == get_option( 'como_theme_seo_options' ) ) {  
        add_option( 'como_theme_seo_options' );
    }
	add_settings_section(
        'como_theme_seo_options',	// ID used to identify this section and with which to register options
        'SEO Options',              	// Title to be displayed on the administration page
        'como_seo_options_callback', // Callback used to render the description of the section
        'como_theme_seo_options'		// Page on which to add this section of options
    );
	
	// Add Company Name Option
	add_settings_field(
		'name',
		'SEO Company Name',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'name',
			'Add Company Name'
        )
	);
	
	// Add Alretnate Name Option
	add_settings_field(
		'alternateName',
		'SEO Alretnate Name',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'alternateName',
			'Add Alternate Name (if desired)'
        )
	);
	
	// Add Company Type Option
	/*add_settings_field(
		'type',
		'SEO Company Type',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'type',
			'Add Company Type'
        )
	);*/
	
	// Add Company Type Option
	require_once('schema-info.php');
	$schemaSelect = getSchemaTypes($schemaThings, array('BioChemEntity','CreativeWork','Event','MedicalEntity','Organization','Person','Place','Product'));
	add_settings_field(
		'type',
		'SEO Company Type',
		'como_select_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'type',
			'Select Company Type',
			$schemaSelect
        )
	);
	
	// Add Description Option
	add_settings_field(
		'description',
		'SEO Description',
		'como_textarea_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'description',
			'Add Company Description'
        )
	);
	
	// Add Price Range Option
	add_settings_field(
		'priceRange',
		'Price Range',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'priceRange',
			'Add Price Range'
        )
	);
	
	// Add Monday Hours Option
	add_settings_field(
		'monday',
		'Monday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'monday',
			'Add Monday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Tuesday Hours Option
	add_settings_field(
		'tuesday',
		'Tuesday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'tuesday',
			'Add Tuesday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Wednesday Hours Option
	add_settings_field(
		'wednesday',
		'Wednesday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'wednesday',
			'Add Wednesday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Thursday Hours Option
	add_settings_field(
		'thursday',
		'Thursday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'thursday',
			'Add Thursday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Friday Hours Option
	add_settings_field(
		'friday',
		'Friday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'friday',
			'Add Friday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Saturday Hours Option
	add_settings_field(
		'saturday',
		'Saturday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'saturday',
			'Add Saturday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	// Add Sunday Hours Option
	add_settings_field(
		'sunday',
		'Sunday Hours',
		'como_text_callback',
		'como_theme_seo_options',
		'como_theme_seo_options',
		array(
			'como_theme_seo_options',
			'sunday',
			'Add Sunday Hours (include AM/PM and separate with a dash "-")'
        )
	);
	register_setting( 'como_theme_seo_options', 'como_theme_seo_options', 'como_theme_sanitize_seo_options');
     
} // end como_initialize_theme_options
add_action('admin_init', 'como_initialize_theme_options');
function como_general_options_callback() {
    echo '<p>Content Customizations may be made here.</p>';
} // end como_general_options_callback
function como_social_options_callback() {
    echo '<p>Provide the URL to the social networks you\'d like to display.</p>';
} // end como_social_options_callback
function como_contact_options_callback() {
    echo '<p>Contact options may be entered here.</p>';
} // end como_social_options_callback
function como_seo_options_callback() {
    echo '<p>SEO options may be entered here.</p>';
} // end como_social_options_callback
 
function checkContactOptions () {
	$globalVar = ((get_option('como_theme_contact_options')) ? 'como_theme_contact_options' : 'como_theme_social_options');
	return $globalVar;
}
// Text Field Callback
function como_text_callback($args){
	$options = get_option($args[0]);
    $val = ((isset($options[$args[1]])) ? $options[$args[1]] : ''); 
	?><input type="text" id="<?=$args[1]?>" name="<?=$args[0]?>[<?=$args[1]?>]" value="<?=$val?>" class="settings-input" /><br><label for="<?=$args[1]?>" class="como-label"><?=$args[2]?></label><?php
}
// Textarea Callback
function como_textarea_callback($args){
	$options = get_option($args[0]);
    $val = ((isset($options[$args[1]])) ? $options[$args[1]] : ''); 
	?><textarea id="<?=$args[1]?>" name="<?=$args[0]?>[<?=$args[1]?>]" class="settings-input"><?=$val?></textarea><br><label for="<?=$args[1]?>" class="como-label"><?=$args[2]?></label><?php
}
// Select Field Callback
function como_select_callback($args){
	$options = get_option($args[0]);
    $val = ((isset($options[$args[1]])) ? $options[$args[1]] : '');
	$selOptions = $args[3];
	?>
	<select id="<?=$args[1]?>" name="<?=$args[0]?>[<?=$args[1]?>]" class="settings-input" />
		<option value="">&lt; Select &gt;</option>
	<?php
		foreach($selOptions as $k=>$v) {
			$selected = (($k == $val) ? ' selected="selected"' : '');
			?><option value="<?=$k?>"<?=$selected?>><?=$v?></option><?php
		}
	?>	
	</select>
	<br><label for="<?=$args[1]?>" class="como-label"><?=$args[2]?></label><?php
}
// Default Social Image
function display_como_default_social_image_element($args) {
	$options = get_option('como_theme_social_options');
    $image = ((isset($options['default_social_image'])) ? $options['default_social_image'] : false); 
	if ($image) {
		$img_src = wp_get_attachment_image_src($image, 'medium');
		$have_social_img = is_array($img_src);
		$uploadClass = 'hide';
		$removeClass = ''; 
	} else {
		$have_social_img = false;
		$uploadClass = '';
		$removeClass = 'hide';
	}
	?>
	<!-- Your image container, which can be manipulated with js -->
	<div class="img-container img-preview">
		<?php if ( $image ) : ?>
			<img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" />
		<?php endif; ?>
	</div>
	<input class="url-file" id="default_social_image" name="como_theme_social_options[default_social_image]" type="hidden" value="<?=$image?>" />
	<p><a href="#" class="<?=$uploadClass?> como-upload-image"><?php esc_html_e('Upload Image', 'como' ); ?></a>
	<a href="#" class="<?=$removeClass?> como-remove-image"><?php esc_html_e('Remove Image', 'como' ); ?></a></p>
	<label for="default_social_image" class="como-label"><?=$args[0]?></label>
	<?php
}
function display_como_login_logo_element($args) {
	$options = get_option('como_theme_display_options');
    $logo = ((isset($options['login_logo'])) ? $options['login_logo'] : false); 
	if ($logo) {
		$img_src = wp_get_attachment_image_src($logo, 'medium');
		$have_header_img = is_array($img_src);
		$uploadClass = 'hide';
		$removeClass = ''; 
	} else {
		$have_header_img = false;
		$uploadClass = '';
		$removeClass = 'hide';
	}
	?>
	<!-- Your image container, which can be manipulated with js -->
	<div class="img-container img-preview">
		<?php if ( $logo ) : ?>
			<img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" />
		<?php endif; ?>
	</div>
	<input class="url-file" id="login_logo" name="como_theme_display_options[login_logo]" type="hidden" value="<?=$logo?>" />
	<p><a href="#" class="<?=$uploadClass?> como-upload-image"><?php esc_html_e('Upload Image', 'como' ); ?></a>
	<a href="#" class="<?=$removeClass?> como-remove-image"><?php esc_html_e('Remove Image', 'como' ); ?></a></p>
	<label for="login_logo" class="como-label"><?=$args[0]?></label>
	<?php
}
function display_como_seo_logo_element($args) {
	$options = get_option('como_theme_display_options');
    $seologo = ((isset($options['seo_logo'])) ? $options['seo_logo'] : false); 
	if ($seologo) {
		$img_src = wp_get_attachment_image_src($seologo, 'medium');
		$have_header_img = is_array($img_src);
		$uploadClass = 'hide';
		$removeClass = ''; 
	} else {
		$have_header_img = false;
		$uploadClass = '';
		$removeClass = 'hide';
	}
	?>
	<!-- Your image container, which can be manipulated with js -->
	<div class="img-container img-preview">
		<?php if ( $seologo ) : ?>
			<img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" />
		<?php endif; ?>
	</div>
	<input class="url-file" id="seo_logo" name="como_theme_display_options[seo_logo]" type="hidden" value="<?=$seologo?>" />
	<p><a href="#" class="<?=$uploadClass?> como-upload-image"><?php esc_html_e('Upload Image', 'como' ); ?></a>
	<a href="#" class="<?=$removeClass?> como-remove-image"><?php esc_html_e('Remove Image', 'como' ); ?></a></p>
	<label for="seo_logo" class="como-label"><?=$args[0]?></label>
	<?php
}
// Sanitize Contact Options
function como_theme_sanitize_contact_options($input) {
    $output = array();
    foreach ($input as $key=>$val) {
		if(isset($input[$key])) {
			if ($key == 'email') {
				$output[$key] = sanitize_email($input[$key]);
			} elseif ($key == 'phone') {
				$output[$key] = $input[$key];
			} else {
            	$output[$key] = $input[$key];
			}
        }  
    } 
    return apply_filters( 'como_theme_sanitize_contact_options', $output, $input );
} // end como_theme_sanitize_contact_options
// Sanitize SEO Options
function como_theme_sanitize_seo_options($input) {
    $output = array();
    foreach ($input as $key=>$val) {
		if(isset($input[$key])) {
			if ($key == 'email') {
				$output[$key] = sanitize_email($input[$key]);
			} elseif ($key == 'phone') {
				$output[$key] = $input[$key];
			} else {
            	$output[$key] = $input[$key];
			}
        }  
    } 
    return apply_filters( 'como_theme_sanitize_seo_options', $output, $input );
} // end como_theme_sanitize_seo_options
// Sanitize Social Links
function como_theme_sanitize_social_options($input) {
    $output = array();
    foreach ($input as $key=>$val) {
		if(isset($input[$key])) {
			if ($key == 'email') {
				$output[$key] = sanitize_email($input[$key]);
			} elseif ($key == 'phone') {
				$output[$key] = $input[$key];
			} elseif ($key == 'default_social_image') {
				$output[$key] = $input[$key];
			} else {
            	$output[$key] = esc_url_raw(strip_tags(stripslashes($input[$key])));
			}
        }  
    } 
    return apply_filters( 'como_theme_sanitize_social_options', $output, $input );
} // end como_theme_sanitize_social_options
// Display Custom Login Logo
function change_my_wp_login_image() {
	$loginImg = false; 
	
	// Look For Login Image set in Theme Settings
	$options = get_option('como_theme_display_options');
	if (isset($options['login_logo'])) {
		if (!empty($options['login_logo'])) {
			$img_src = wp_get_attachment_image_src($options['login_logo'], 'medium');
			$loginImg = $img_src[0];
		}
	}
	if (!$loginImg) {
		// Look for Uploaded Login Image
		if (file_exists(get_stylesheet_directory() ."/images/login-logo.png")) {
			$loginImg = get_stylesheet_directory_uri() ."/images/login-logo.png";	
		} else {
			$loginImg = get_bloginfo('template_url')."/images/login-logo-como.png";	
		}
	}
	echo "<style>
	body.login #login h1 a {
		background: url(". $loginImg .") 0 0 no-repeat transparent;
		background-position: center center;
		background-size: contain;
		height:300px;
		width:300px; }
	</style>";
}
add_action("login_head", "change_my_wp_login_image");
// Show Social Icon with Shortcode [showSocial network='' icon='']
function showSocial_shortcode($atts, $content="null"){
	$a = shortcode_atts( array(
		'network' => (isset($atts['network']) ? $atts['network'] : ''),
		'icon' => (isset($atts['icon']) ? $atts['icon'] : '')
	), $atts );
	$network = strtolower($a['network']);
	$icon = $a['icon'];
	$socialOptions = get_option('como_theme_social_options');
	
	$obj_id = get_queried_object_id();
	$current_url = get_permalink( $obj_id );
	$title = get_the_title($obj_id);
	$excerpt = get_the_excerpt($obj_id);
	$image = ((has_post_thumbnail($obj_id)) ? get_the_post_thumbnail_url($obj_id, 'medium') : '');
	
	$socialLink = ''; 
	switch ($network) {
		case 'facebook':
			$url = ((!empty($socialOptions['facebook'])) ? $socialOptions['facebook'] : 'https://www.facebook.com/sharer/sharer.php?u='. $current_url); 
			$title = ((!empty($socialOptions['facebook'])) ? 'Visit us on Facebook' : 'Share on Facebook'); 
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="facebook icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-facebook-f') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'twitter':
			$url = ((!empty($socialOptions['twitter'])) ? $socialOptions['twitter'] : 'https://twitter.com/intent/tweet?text='. $title .' '. $current_url);
			$title = ((!empty($socialOptions['twitter'])) ? 'Visit us on Twitter' : 'Share on Twitter');
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="twitter icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-x-twitter') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'threads':
			$url = ((!empty($socialOptions['threads'])) ? $socialOptions['threads'] : 'https://www.threads.net');
			$title = ((!empty($socialOptions['threads'])) ? 'Visit us on Threads' : 'Share on Threads');
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="threads icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-threads') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;	
		case 'youtube':
			$url = ((!empty($socialOptions['youtube'])) ? $socialOptions['youtube'] : 'https://youtube.com'); 
			$title = ((!empty($socialOptions['youtube'])) ? 'Visit us on Youtube' : 'Visit Youtube'); 
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="youtube icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-youtube') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'linkedin':
			$url = ((!empty($socialOptions['linkedin'])) ? $socialOptions['linkedin'] : 'https://www.linkedin.com/shareArticle?mini=true&url='. $current_url .'&title='. $title .'&summary='. $excerpt); 
			$title = ((!empty($socialOptions['linkedin'])) ? 'Visit us on LinkedIn' : 'Share on LinkedIn'); 
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="linkedin icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-linkedin-in') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'instagram':
			$url = ((!empty($socialOptions['instagram'])) ? $socialOptions['instagram'] : 'https://www.instagram.com/?url='. $image .'&media='. $current_url .'&description='. $title); 
			$title = ((!empty($socialOptions['instagram'])) ? 'Visit us on Instagram' : 'Share on Instagram'); 
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="instagram icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-instagram') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'pinterest':
			$url = ((!empty($socialOptions['pinterest'])) ? $socialOptions['pinterest'] : 'https://pinterest.com/pin/create/button/?url='. $image .'&media='. $current_url .'&description='. $title); 
			$title = ((!empty($socialOptions['pinterest'])) ? 'Visit us on Pinterest' : 'Share on Pinterest'); 
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="pinterest icon-link" role="button"><i class="'. (!empty($icon) ? $icon : 'fab fa-brands fa-pinterest-p') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
		case 'email':
			$url = ((!empty($socialOptions['email'])) ? 'mailto:'. $socialOptions['email'] : 'mailto:?&subject='. $title .'&body='. $current_url); 
			$title = ((!empty($socialOptions['email'])) ? 'Email Us' : 'Share with Email');
			$socialLink = '<a href="'. $url .'" target="_blank" title="'. $title .'" aria-label="'. $title .'" class="email icon-link" role="button"><i class="'. (!empty($icon) ? $icons : 'fas fa-solid fa-envelope') .'"></i><span class="sr-only">'. $title .'</span></a>';
			break;
	}
	
	if (!empty($socialLink)) {
    	return $socialLink;
	}
}
add_shortcode('showSocial', 'showSocial_shortcode');

// Show Phone with Shortcode [showphone link=true/false show=normal/vanity/both]
function showphone_shortcode($atts, $content="null"){
	extract(shortcode_atts(array('link' => false, 'show' => 'normal'), $atts));
  	$output = showSitePhone($atts['link'], $atts['show']);
	return $output;
}
add_shortcode('showphone', 'showphone_shortcode');
function showSitePhone($link=false, $show='nomral') {
	$optVar = checkContactOptions();
	$contact = get_option($optVar);
	$phone = $contact['phone'];
	$vanity = $contact['vanity-phone'];
	$showPhone = (($show == 'vanity') ? ((!empty($vanity)) ? $vanity : $phone) : (($show == 'both') ? ((!empty($vanity)) ? $vanity .' ('. $phone.')' : $phone)  : $phone)); 
	$output = (($link==true) ? '<a href="tel:'. formatPhoneLink($phone,1) .'" class="phoneLink" role="button" aria-label="Call '. $phone .'">'. $showPhone .'</a>' : $showPhone);
	return($output);
}

// Show Fax with Shortcode [showfax]
add_shortcode('showfax', 'showfax_shortcode');
function showfax_shortcode($atts, $content="null"){
	$options = get_option('como_theme_contact_options');
	$output = $options['fax'];
	return $output;
}

// Show Email with Shortcode [showemail link=true/false content=text to override display]
function showemail_shortcode($atts, $content="null"){
	extract(shortcode_atts(array('link' => false), $atts));
  	$output = showSiteEmail($atts['link'], $atts['class'], $content);
	return $output;
}
add_shortcode('showemail', 'showemail_shortcode');
function showSiteEmail($link=false, $class='', $content='') {
	$optVar = checkContactOptions();
	$contact = get_option($optVar);
	$email = $contact['email'];
	$output = (($link==true) ? getObfuscatedEmailLink($email, $params = array('content'=>$content, 'class'=>$class))  : getObfuscatedEmailAddress($email));
	return($output);
}
// Show Address with Shortcode [showaddress part='']
function showaddress_shortcode($atts, $content="null"){
	$a = shortcode_atts( array(
		'part' => $atts['part']
	), $atts );
	//extract(shortcode_atts(array('part' => false), $atts));
	$address = get_option('como_theme_contact_options');
	$output = ''; 
	if ($a['part']) {
		$output = $address[$a['part']];
	} else {
		$output .= ((!empty($address['street'])) ? $address['street'] .'<br>' : '');
		$output .= ((!empty($address['suite'])) ? $address['suite'] .'<br>' : '');
		$output .= ((!empty($address['city'])) ? $address['city'] .', ' : '');
		$output .= ((!empty($address['state'])) ? $address['state'] .' ' : '');
		$output .= ((!empty($address['zip'])) ? $address['zip'] : ' ');
		$output .= ((!empty($address['country'])) ? ' '. $address['country'] : ' ');
	}
	return($output);
}
add_shortcode('showaddress', 'showaddress_shortcode');
// Show Shema Markup
function showSchema_shortcode() {
	// Get Values
	$optVar = checkContactOptions();
	$contact = get_option($optVar);
	$display = get_option('como_theme_display_options');
	$seo = get_option('como_theme_seo_options');
	$social = get_option('como_theme_social_options');
	
	// Get Site Logo
	$siteLogo_id = (($display['seo_logo']) ? $display['seo_logo'] : get_theme_mod('custom_logo'));
	$siteLogo = wp_get_attachment_image_src($siteLogo_id , 'full');
	if ($siteLogo) {
		$siteLogo = $siteLogo[0];
	} else {
		$siteLogo = ''; 
	}
	
	// Get SEO Image
	$serImgID = (isset($social['default_social_image']) ? $social['default_social_image'] : '');
	if ($serImgID) {
		$seoImage = wp_get_attachment_image_src($serImgID, 'full');
		$seoImage = $seoImage[0];
	} else {
		$seoImage = '';
	}
	
	// Get Phone Numbers
	$phoneNumbers = '';
	if (strpos($contact['phone'],'/')) {
		$phoneNumbers = '"contactPoint": [';
		$phNumbers = explode('/'.$contact['phone']);
		$phCount = count($phNumbers);
		for ($p=0;$p<$phCount;$p++) {
			$phoneNumbers .= '{
				"@type": "ContactPoint",
				"telephone": "'. formatPhoneLink($phNumbers[$p]) .'"			 
			}';
			$phoneNumbers .= (($p==($phCount-1)) ? ',' : '');
		}
		$phoneNumbers .= ']';
	} else {
		$phoneNumbers = '"telephone": "'. formatPhoneLink($contact['phone']) .'"';
	}
	
	// Get Address
	$address = ''; 
	if ((!empty($contact['street'])) || !empty($contact['city'])) {
		$address .= '"address": { "@type": "PostalAddress",';
		$addArray = array();
		$addArray[] = ((!empty($contact['street'])) ? '"streetAddress": "'. $contact['street'] .'"' : null);
		$addArray[] = ((!empty($contact['city'])) ? '"addressLocality": "'. $contact['city'] .'"' : null);
		$addArray[] = ((!empty($contact['state'])) ? '"addressRegion": "'. $contact['state'] .'"' : null);
		$addArray[] = ((!empty($contact['zip'])) ? '"postalCode": "'. $contact['zip'] .'"' : null);
		$addArray[] = ((!empty($contact['country'])) ? '"addressCountry": "'. $contact['country'] .'"' : null);
		$address .= implode(',',array_filter($addArray));
		$address .= '},';
	}
	
	// Get Social Links
	$sameAs = ''; 
	if(!empty($social)) {
		$sameAs .= '"sameAs": [';
		$cntSocial = count($social); 
		$sameAsArray = array();
		foreach ($social as $socialLink) {
			$sameAsArray[] .= (!empty($socialLink) ? '"'. $socialLink .'"' : ''); 
		}
		$sameAs .= implode(',',array_filter($sameAsArray));
		$sameAs .= '],';
	}
	
	// Build Structured Data JSON
	$output = '<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  '. ((!empty($seo['type'])) ? '"@type": "'. $seo['type'] .'",' : '') .'
		  '. ((!empty($seo['name'])) ? '"name": "'. $seo['name'] .'",' : '') .'
		  '. ((!empty($seo['alternateName'])) ? '"alternateName": "'. $seo['alternateName'] .'",' : '') .'
		  "url": "'. get_site_url() .'",
		  "logo": "'. $siteLogo .'",
		  '. ((!empty($seo['description'])) ? '"description": "'. $seo['description'] .'",' : '') .'
		  '. ((!empty($seoImage)) ? '"image": "'. $seoImage .'",' : '') .'
		  '. ((!empty($seo['priceRange'])) ? '"priceRange": "'. $seo['priceRange'] .'",' : '') .'
		  '. $address .'
		  '. $sameAs .'
		  '. $phoneNumbers .' 
		}
	</script>'; 
	return($output);
}
add_shortcode('showSchema', 'showSchema_shortcode');
if (!function_exists('getGlobalLayout')) {
	function getGlobalLayout() {
		$globalOptions = get_option('como_theme_display_options');
		$globalLayout = array(
			'row' => (isset($globalOptions['global-row-class']) ? $globalOptions['global-row-class'] : ''),
			'content' => (isset($globalOptions['global-content-class']) ? $globalOptions['global-content-class'] : 'col-9'),
			'aside' => (isset($globalOptions['global-aside-class']) ? $globalOptions['global-aside-class'] : 'col-3')
		);
		return $globalLayout;
	}
}