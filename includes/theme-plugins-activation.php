<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/TGM-Plugin-Activation-2.6.1/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'como_boot_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 *  <snip />
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function como_boot_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Advanced Custom Fields Pro', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		// This is an example of how to include a plugin from the WordPress Plugin Repository. 
		array(
			'name'      => 'All-in-One WP Migration',
			'slug'      => 'all-in-one-wp-migration',
			'required'  => false,
		),
		array(
			'name'               => 'All-in-One WP Migration Unlimited Extension', // The plugin name.
			'slug'               => 'all-in-one-wp-migration-unlimited-extension', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/all-in-one-wp-migration-unlimited-extension.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'      => 'Classic Editor',
			'slug'      => 'classic-editor',
			'required'  => false,
		),
		array(
			'name'      => 'Classic Widgets',
			'slug'      => 'classic-widgets',
			'required'  => false,
		),
		array(
			'name'      => 'Disable Comments',
			'slug'      => 'disable-comments',
			'required'  => false,
		),
		array(
			'name'      => 'Enable Media Replace',
			'slug'      => 'enable-media-replace',
			'required'  => false,
		),
		array(
			'name'      => 'Monster INsights',
			'slug'      => 'google-analytics-for-wordpress',
			'required'  => false,
		),
		/*array(
			'name'               => 'Google Analytics Premium', // The plugin name.
			'slug'               => 'google-analytics-premium', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/google-analytics-premium.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),*/
		array(
			'name'      => 'Obfuscate Email',
			'slug'      => 'obfuscate-email',
			'required'  => false,
		),
		array(
			'name'      => 'Password Protected',
			'slug'      => 'password-protected',
			'required'  => false,
		),
		/*array(
			'name'      => 'Post Thumbnail Editor',
			'slug'      => 'post-thumbnail-editor',
			'required'  => false,
		),*/
		array(
			'name'               => 'Post Thumbnail Editor', // The plugin name.
			'slug'               => 'post-thumbnail-editor', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/post-thumbnail-editor.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'      => 'Protect Uploads',
			'slug'      => 'protect-uploads',
			'required'  => false,
		),
		array(
			'name'      => 'Redirection',
			'slug'      => 'redirection',
			'required'  => false,
		),
		array(
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),
		array(
			'name'      => 'Resend Welcome Email',
			'slug'      => 'resend-welcome-email',
			'required'  => false,
		),
		array(
			'name'      => 'Shortcode in Menus',
			'slug'      => 'shortcode-in-menus',
			'required'  => false,
		),
		array(
			'name'      => 'Shortcode Widget',
			'slug'      => 'shortcode-widget',
			'required'  => false,
		),
		array(
			'name'      => 'Simple Custom Post Order',
			'slug'      => 'simple-custom-post-order',
			'required'  => false,
		),
		array(
			'name'      => 'Simple History',
			'slug'      => 'simple-history',
			'required'  => false,
		),
		array(
			'name'      => 'Updraft PLus',
			'slug'      => 'updraftplus',
			'required'  => false,
		),
		/*array(
			'name'               => 'Updraft Plus Premium', // The plugin name.
			'slug'               => 'updraftplus', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/plugins/updraftplus.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),*/
		array(
			'name'      => 'User Login History',
			'slug'      => 'user-login-history',
			'required'  => false,
		),
		array(
			'name'      => 'User Role Editor',
			'slug'      => 'user-role-editor',
			'required'  => false,
		),
		array(
			'name'      => 'Widget CSS Classes',
			'slug'      => 'widget-css-classes',
			'required'  => false,
		),
		array(
			'name'      => 'Wordfence Security',
			'slug'      => 'wordfence',
			'required'  => false,
		),
		array(
			'name'      => 'WP Super Cache',
			'slug'      => 'wp-super-cache',
			'required'  => false,
		),
		array(
			'name'      => 'WP Robots Txt',
			'slug'      => 'wp-robots-txt',
			'required'  => false,
		),
		array(
			'name'      => 'WP-Optimize - Clean, Compress, Cache',
			'slug'      => 'wp-optimize',
			'required'  => false,
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),
		// <snip />
	);
	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
			'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
			// <snip>...</snip>
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
		*/
	);
	tgmpa( $plugins, $config );
}