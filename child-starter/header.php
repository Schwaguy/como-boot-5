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
	  
 	<meta name="author" content="https://comocreative.com">
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
<?php 
	if (is_home() || !is_front_page()) {
		$pID = get_queried_object_id();
		$parentID = wp_get_post_parent_id($pID);
		$grandparentID = wp_get_post_parent_id($parentID);
		$custheader = '';
		$defaultHeaderImg = 92;
		
		$comoHeadImg = (isset($postMeta['comoheadbg-img'][0]) ? get_post_meta($pID,'comoheadbg-img',true) : (isset($parentMeta['comoheadbg-img'][0]) ? $parentMeta['comoheadbg-img'][0] : (isset($grandparentMeta['comoheadbg-img'][0]) ? $grandparentMeta['comoheadbg-img'][0] : '')));	
			
		$comoHeadClass = (isset($postMeta['comoheadbg-class'][0]) ? $postMeta['comoheadbg-class'][0] : (isset($parentMeta['comoheadbg-class'][0]) ? $parentMeta['comoheadbg-class'][0] : (isset($grandparentMeta['comoheadbg-class'][0]) ? $grandparentMeta['comoheadbg-class'][0] : '')));
		
		if ((is_singular('jobpost')) || (is_post_type_archive('jobpost'))) {
			$parentTitle = 'About';
			$pageTitle = 'Careers';
			$comoHeadImg = $defaultHeaderImg;
		} elseif (is_singular('document')) {
			$parentTitle = 'Our Science';
			$pageTitle = 'Publications';
		} elseif (is_search()) {
			$parentTitle = 'Search';
			$pageTitle = 'Results';
		} else {
			$parentTitle = ($grandparentID ? get_the_title($grandparentID) : ($parentID ? get_the_title($parentID) : ''));
			$pageTitle = get_the_title($pID);
			if (empty($comoHeadImg)) { $comoHeadImg = $defaultHeaderImg; }
			//$comoHeadImg = 200;
		}
		
		$subtitle = get_post_meta($pID,'pagesubtitle',true);
		$secondSubtitle = get_post_meta($post->ID,'pagesubtitle2',true);
		$subtitleClass = ''; 
		if (!empty($parentTitle))  {
			$parentTitle = '<div class="subpage-parent-title">'. $parentTitle .'</div>';	
		} elseif (!empty($subtitle)) {
			$parentTitle = '<div class="subpage-parent-title">'. $subtitle .'</div>';
			$subtitleClass = 'no-subtitle'; 
		} else {
			$parentTitle = ''; 
		}
		
		$comoHeadImg = wp_get_attachment_image($comoHeadImg, 'full', false, array('class'=>'img-responsive img-fluid img-subpage-header'));
	}
?>
	
<body <?php if (isset($subtitleClass)) { body_class($subtitleClass); } else { body_class(); } ?><?php do_action('body_start_tag_attributes'); ?>>
	<a id="skip-nav" class="skip-link screenreader-text sr-only" href="#content-wrap" title="Skip Navigation" aria-label="Skip Navigation">Skip Navigation</a>
	<div id="page-wrapper">
		
	<div id="top" class="anchor"></div>
    <header id="masthead" class="clearfix animated slideInDown">
		<div class="container no-mobile">	
			<div id="top-bar" class="row">
				<div class="header-widget col-12" id="social-widget">
					<?php if (is_active_sidebar('sidebar-header-1')) { dynamic_sidebar('sidebar-header-1'); } ?>
				</div>
			</div>
		</div>
		<div class="container nav-container">
			<nav id="mainNav" class="navbar navbar-expand-lg hoverable slider-nav">
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
					<span class="sr-only"><?=insertStringText('Toggle Navigation','child-theme')?></span>
				</button>
				<?php
					wp_nav_menu(array(
						'menu'				=> 'header-menu',
						'theme_location'	=> 'header-menu',
						'container'			=> 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'navbarCollapse',
						'menu_class'        => 'nav navbar-nav ml-auto mr-0 slider-nav',
						'fallback_cb' 		=> '__return_false',
						'items_wrap' 		=> '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
						'depth' 			=> 3,
						'walker' 			=> new bootstrap_5_wp_nav_menu_walker()
					));
				?>
			</nav>
			<span class="target"></span>
		</div>
	</header>
	<?php if (is_home() || !is_front_page()) : ?>
		<section class="como-page-head">
			<div id="subpage-header" class="head-image <?=$comoHeadClass?>">
				<?=$comoHeadImg?>
				<header class="title-container" role="heading">
					<div class="container">
						<?php if (!empty(get_post_meta($pID,'comoheadbg-content',true))) { echo '<div class="subpage-header-content-wrap">'; } ?>
						<div class="title-wrap animated fadeInUp">
							<?=$parentTitle?>
						</div>
						<?php if (!empty(get_post_meta($pID,'comoheadbg-content',true))) : ?>
							<div class="subpage-header-content animated fadeInUp"><?=apply_filters('the_content', get_post_meta($pID,'comoheadbg-content',true))?></div>
						<?php endif; ?>
						<?php if (!empty(get_post_meta($pID,'comoheadbg-content',true))) { echo '</div><!-- /subpage-header-content-wrap -->'; } ?>
					</div>
				</header>
			</div> 
		</section>
	<?php endif ?>