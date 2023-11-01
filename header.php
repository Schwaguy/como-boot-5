<?php defined('ABSPATH') or die('No Hackers!'); ?>
<!DOCTYPE html>
<html <?=language_attributes()?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 	<title><?php wp_title(); ?></title>
 	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
 	<meta name="author" content="josh@comocreative.com">
   	<meta name="revisit-after" content="7 days">
	  
	<?php
	  $cacheOptions = checkCacheOption();
	  if ($cacheOptions == 'no-caching') : 
	?>
		<!-- Discourage Browser Caching -->  
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> 
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
	<?php endif; ?>  
 	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
 	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?><?php do_action('body_start_tag_attributes'); ?>>
	<a id="skip-nav" class="skip-link screenreader-text sr-only" href="#content-wrap" title="Skip Navigation" aria-label="Skip Navigation">Skip Navigation</a>
	<div id="page-wrapper">
	<div id="top" class="anchor"></div>
    <header id="masthead" class="container clearfix">
		<?php
			if (is_active_sidebar('sidebar-header-1')) {
				echo '<div id="header-widget">';
				dynamic_sidebar('sidebar-header-1');
				echo '</div>';
			}
			if (is_active_sidebar('sidebar-header-2')) {
				echo '<div id="header-widget">';
				dynamic_sidebar('sidebar-header-2');
				echo '</div>';
			}
		?>
		<nav id="mainNav" class="navbar navbar-expand-lg hoverable hide-sub-onBlur page-fade slider-nav">
			<span class="navbar-brand">
				<?php 
					if ( has_custom_logo() ) {
						como_custom_logo(); 
					} else { 
						?>
						<a href="<?=get_home_url()?>" class="imgLink" id="main-logo-link" aria-label="<?=get_bloginfo('name')?> Home" role="button">
							<span class="masthead-title home-title"><?=get_bloginfo('name')?></span><br>
							<span class="masthead-subtitle"><?=get_bloginfo('description')?></span>
						</a>
						<?php
					}
				?>
			</span>
			<button id="nav-icon" class="navbar-toggle navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle Navigation">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="sr-only"><?=insertStringText('Toggle Navigation','ascentage-theme')?></span>
			</button>
			<?php
				wp_nav_menu(array(
					'menu'				=> 'header-menu',
					'theme_location'	=> 'header-menu',
					'container'			=> 'div',
					'container_class'   => 'collapse navbar-collapse',
					'container_id'      => 'navbarCollapse',
					'menu_class'        => 'nav navbar-nav ml-auto mr-0 slider-nav hide-sub-onBlur',
					'fallback_cb' 		=> '__return_false',
					'items_wrap' 		=> '<ul id="%1$s" class="navbar-nav %2$s" rile="menu">%3$s</ul>',
					'depth' 			=> 3,
					'walker' 			=> new bootstrap_5_wp_nav_menu_walker()
				));
			?>
		</nav>
    </header>