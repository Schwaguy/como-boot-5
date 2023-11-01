<?php
// Como Customizer
/**************************************************************************
Customizer include file
Includes all functions for the customizer with this theme
**************************************************************************/
// Customiser Load Function
if (!function_exists('themeOptions')) {
	function themeOptions($section, $variable, $fields, $options, $wp_customize) {
		foreach ($fields as $field) {
				
			// Get Field Type
			switch ($field['input']) {
				case 'text':
					$class = 'WP_Customize_Control';
					break;
				case 'textarea':
					$class = 'WP_Customize_Control';
					break;
				case 'media':
					$class = 'WP_Customize_Media_Control';
					break;
				case 'select':
					$class = 'WP_Customize_Control';
					break;
				default: 
					$class = 'WP_Customize_Control'; 
			} 
			
			// Get Sanitize Method
			switch ($field['sanitize']) {
				case 'url':
					$sanitize = 'sanitize_url';
					break;
				case 'email':
					$sanitize = 'sanitize_email'; 
					break;
				case 'text':
					$sanitize = 'sanitize_text_field';
					break;
				case 'textarea':
					$sanitize = 'sanitize_textarea_field';
					break;
				default: 
					$sanitize = '';
			} 
			$choices = ((isset($field['choices'])) ? $field['choices'] : ''); 
			$value = ((isset($options[$field['var']])) ? $options[$field['var']] : ''); 
			$var = $variable .'['. $field['var'] .']'; 
			$wp_customize->add_setting($var, array(
				'type' => $field['type'],
				'capability' => $field['capability'],
				'default' => __($field['default'], 'como'),
				'sanitize_callback' => $sanitize,
				'value' => $value
			) );
			$wp_customize->add_control(new $class(
				$wp_customize,
				$variable .'['. $field['var'] .']',
				array( 
					'label' => __($field['label'], 'como'),
					'section' => $section,
					'settings' => $variable .'['. $field['var'] .']',
					'type' => $field['input'],
					'choices' => $choices,
					'description' => $field['desc']
			)));	
		}	
	}
}
/**************************************************************************
Add theme customizer controls, settings etc.
**************************************************************************/
function como_customize_register( $wp_customize ) {
	
	/*******************************************
	Sections
	********************************************/
	
	// Display Options section
	$wp_customize->add_section( 'como_display_options' , array(
		'title' => __( 'Theme Display Options', 'como')
	) );
	
	// SEO Options Section 
	$wp_customize->add_section( 'como_seo_options', array(
		'title' => __( 'Theme Social Options', 'como' )
	));
	
	/********************
	Define generic controls
	*********************/
	
	// create class to define text input controls in Customizer
	/*class como_Customize_TextInput_Control extends WP_Customize_Control {
		public $type = 'text';
		public function render_content() {
			echo '<label>';
				echo '<span class="customize-control-title">' . esc_html( $this-> label ) . '</span>';
				echo '<input type="text" style ="width: 100%;"';
				$this->link();
				echo ' value="' . esc_html( $this->value() ) . '">';
			echo '</label>';
		}
	}
	
	// create class to define textarea controls in Customizer
	class como_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
			echo '<label>';
				echo '<span class="customize-control-title">' . esc_html( $this-> label ) . '</span>';
				echo '<textarea rows="2" style ="width: 100%;"';
				$this->link();
				echo '>' . esc_textarea( $this->value() ) . '</textarea>';
			echo '</label>';
		}
	}*/	
	
	/*******************************************
	Display Options
	********************************************/
	$wp_customize->add_section( 'como_display_options' , array(
		'title' => __( 'Theme Display Options', 'como')
	) );
	
	$comoDisplayOptions = get_option('como_theme_display_options');
	$capability = 'manage_options'; 
	$comoDisplayFields = array(
		array('label'=>'Cache Setting','type'=>'option','capability'=>$capability,'default'=>'','var'=>'como-cache-setting','input'=>'select','sanitize'=>'','desc'=>'','choices'=>array(''=>'&lt; Select &gt;','normal-caching'=>'Normal Caching (caching on)','no-caching'=>'No Caching (caching off)')),
		array('label'=>'SEO Logo','type'=>'option','capability'=>$capability,'default'=>'','var'=>'seo_logo','input'=>'media','sanitize'=>'','desc'=>''),
		array('label'=>'Login Logo','type'=>'option','capability'=>$capability,'default'=>'','var'=>'login_logo','input'=>'media','sanitize'=>'','desc'=>''),
		array('label'=>'Custom Copyright Text','type'=>'option','capability'=>$capability,'default'=>'','var'=>'footer-custom-copyright','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Custom "Leaving Site" Text','type'=>'option','capability'=>$capability,'default'=>'','var'=>'leaving-site-message','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Global Row Classes','type'=>'option','capability'=>$capability,'default'=>'','var'=>'global-row-class','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Global Content Classes','type'=>'option','capability'=>$capability,'default'=>'','var'=>'global-content-class','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Global Aside Classes','type'=>'option','capability'=>$capability,'default'=>'','var'=>'global-aside-class','input'=>'text','sanitize'=>'text','desc'=>'')
	);
	themeOptions('como_display_options', 'como_theme_display_options', $comoDisplayFields, $comoDisplayOptions, $wp_customize);
	
	/*******************************************
	Contact Options
	********************************************/
	$wp_customize->add_section( 'como_contact_options' , array(
		'title' => __( 'Theme Contact Options', 'como')
	) );
	
	$comoContactOptions = get_option('como_theme_contact_options');
	$capability = 'manage_options'; 
	$comoContactFields = array(
		array('label'=>'Contact Email Address','type'=>'option','capability'=>$capability,'default'=>'','var'=>'email','input'=>'text','sanitize'=>'email','desc'=>''),
		array('label'=>'Contact Phone Number','type'=>'option','capability'=>$capability,'default'=>'','var'=>'phone','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Vanity Phone Number','type'=>'option','capability'=>$capability,'default'=>'','var'=>'vanity-phone','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Fax Number','type'=>'option','capability'=>$capability,'default'=>'','var'=>'fax','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Location Name','type'=>'option','capability'=>$capability,'default'=>'','var'=>'locName','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Street Address','type'=>'option','capability'=>$capability,'default'=>'','var'=>'street','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Suite / Address 2','type'=>'option','capability'=>$capability,'default'=>'','var'=>'suite','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'City','type'=>'option','capability'=>$capability,'default'=>'','var'=>'city','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'State','type'=>'option','capability'=>$capability,'default'=>'','var'=>'state','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Zipcode','type'=>'option','capability'=>$capability,'default'=>'','var'=>'zip','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Country','type'=>'option','capability'=>$capability,'default'=>'','var'=>'country','input'=>'text','sanitize'=>'text','desc'=>'')
	);
	themeOptions('como_contact_options', 'como_theme_contact_options', $comoContactFields, $comoContactOptions, $wp_customize);
	
	/*******************************************
	Social Options
	********************************************/
	$wp_customize->add_section( 'como_social_options', array(
		'title' => __( 'Theme Social Options', 'como' )
	));
	
	$comoSocialOptions = get_option('como_theme_social_options'); 
	$capability = 'manage_options';
	$comoSocialNetworks = array(
		array('label'=>'Facebook Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'facebook','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'Twitter Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'twitter','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'Threads Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'threads','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'YouTube Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'youtube','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'LinkedIn Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'linkedin','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'Instagram Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'instagram','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'Pinterest Profile URL','type'=>'option','capability'=>$capability,'default'=>'','var'=>'pinterest','input'=>'text','sanitize'=>'url','desc'=>''),
		array('label'=>'Default Social Image','type'=>'option','capability'=>$capability,'default'=>'','var'=>'default_social_image','input'=>'media','sanitize'=>'','desc'=>'')
	);
	themeOptions('como_social_options', 'como_theme_social_options', $comoSocialNetworks, $comoSocialOptions, $wp_customize);
	
	/*******************************************
	SEO Options
	********************************************/
	$wp_customize->add_section( 'como_seo_options' , array(
		'title' => __( 'Theme SEO Options', 'como')
	) );
	
	$comoSeoOptions = get_option('como_theme_seo_options');
	$capability = 'manage_options'; 
	
	// Get Schema Options
	require_once('schema-info.php');
	$schemaSelect = getSchemaTypes($schemaThings, array('BioChemEntity','CreativeWork','Event','MedicalEntity','Organization','Person','Place','Product'));
	$comoSeoFields = array(
		array('label'=>'SEO Company Name','type'=>'option','capability'=>$capability,'default'=>'','var'=>'name','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'SEO Alternate Name','type'=>'option','capability'=>$capability,'default'=>'','var'=>'alternateName','input'=>'text','sanitize'=>'text','desc'=>''),
		//array('label'=>'SEO Company Type','type'=>'option','capability'=>$capability,'default'=>'','var'=>'type','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'SEO Company Type','type'=>'option','capability'=>$capability,'default'=>'','var'=>'type','input'=>'select','sanitize'=>'','desc'=>'','choices'=>$schemaSelect),
		array('label'=>'SEO Description','type'=>'option','capability'=>$capability,'default'=>'','var'=>'description','input'=>'textarea','sanitize'=>'textarea','desc'=>''),
		array('label'=>'Price Range','type'=>'option','capability'=>$capability,'default'=>'','var'=>'priceRange','input'=>'text','sanitize'=>'text','desc'=>''),
		array('label'=>'Monday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'monday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Tuesday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'tuesday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Wednesday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'wednesday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Thursday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'thursday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Friday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'friday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Saturday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'saturday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"'),
		array('label'=>'Sunday Hours','type'=>'option','capability'=>$capability,'default'=>'','var'=>'sunday','input'=>'text','sanitize'=>'text','desc'=>'include AM/PM and separate with a dash "-"')
	);
	themeOptions('como_seo_options', 'como_theme_seo_options', $comoSeoFields, $comoSeoOptions, $wp_customize);
	
	
	/*******************************************
	Color scheme
	********************************************/
	
	// main color - site title, h1, h2, h4, widget headings, nav links, footer background
	$textcolors[] = array(
		'slug' => 'como_color1',
		'default' => '#3394bf',
		'label' => __( 'Main color', 'como' )
	);
	
	// secondary color - navigation background
	$textcolors[] = array(
		'slug' => 'como_color2',
		'default' => '#183c5b',
		'label' => __( 'Secondary color', 'como' )
	);
	
	// link color
	$textcolors[] = array(
		'slug' => 'como_links_color1',
		'default' => '#3394bf',
		'label' => __( 'Links color', 'como' )
	);
	
	// link color on hover
	$textcolors[] = array(
		'slug' => 'como_links_color2',
		'default' => '#666',
		'label' => __( 'Links color (on hover)', 'como' )
	);
	
	// add settings and controls for each color
	foreach ( $textcolors as $textcolor ) {
		
		// settings
		$wp_customize->add_setting(
			$textcolor[ 'slug' ], array (
				'default' => $textcolor[ 'default' ],
				'type' => 'option'
			)
		);
		// controls
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$textcolor[ 'slug' ],
			array (
				'label' => $textcolor[ 'label' ],
				'section' => 'como_colors',
				'settings' => $textcolor[ 'slug' ]
			)
		));
	}
	
}
add_action( 'customize_register', 'como_customize_register' );
/**********************************************************************
Add controls / content to theme
**********************************************************************/
function como_display_contact_details_in_header() { ?>
	
	<address>
		
		<p class="address">
			<?php echo get_theme_mod( 'como_address_setting', 'Your address' ); ?>
		</p>
		
		<p class="tel">
			<?php echo get_theme_mod( 'como_telephone_setting', 'Your telephone number' ); ?>
		</p>
		
		<?php $email = get_theme_mod( 'como_email_setting', 'Your email address' ); ?>
		<p class="email">
			<a href="<?php echo $email; ?>">
				<?php echo $email; ?>
			</a>
		</p>
	
	</address>
	
<?php }
//add_action( 'como_in_header', 'como_display_contact_details_in_header' );
/*******************************************************************************
 add styling to theme - attaches to the wp_head hook
 ********************************************************************************/
function como_add_color_scheme() {
	
	/****************
	define text colors
	****************/
	$color_scheme1 = get_option( 'como_color1' );
	$color_scheme2 = get_option( 'como_color2' );
	$link_color1 = get_option( 'como_links_color1' );
	$link_color2 = get_option ( 'como_links_color2' );
	
	/**************
	add classes
	**************/
	?>
	
	<style>
	
		/* main color */
		.site-title a:link,
		.site-title a:visited,
		.site-description,
		h1,
		h2,
		h2.page-title,
		h2.post-title,
		h2 a:link,
		h2 a:visited,
		nav.main a:link,
		nav.main a:visited {
			color: <?php echo $color_scheme1; ?>;
		}
		footer {
			background: <?php echo $color_scheme1; ?>;
		}
		
		/* secondary color */
		nav.main,
		nav.main a {
			background: <?php echo $color_scheme2; ?>;
		}
		
		/* links color */
		a:link,
		a:visited,
		.sidebar a:link,
		.sidebar a:visited {
			color: <?php echo $link_color1; ?>;
		}
		
		/* links hover color */
		a:hover,
		a:active,
		.sidebar a:hover,
		.sidebar a:active {
			color: <?php echo $link_color2; ?>;
		}
	
	</style>
	
<?php }
//add_action( 'wp_head', 'como_add_color_scheme' );
