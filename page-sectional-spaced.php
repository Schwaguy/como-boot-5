<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: Page - Sectional Spaced */ ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
           
   	<?php
		$introsection = $post->ID;
		$thispage = $introsection;
		$sectionInfo = getSectionInfo($introsection);
		$sectionStyle = (($sectionInfo['background']) ? 'style="'. $sectionInfo['background'] .'"' : '');
		
		echo '<section id="'. $sectionInfo['sectionID'] .'" class="page-section '. $sectionInfo['bgClass'] .' '. $sectionInfo['class'] .' clearfix" '. $sectionStyle .'><div class="container main">';
		
		$overlay = checkBGoverlay($mainInfo);
		echo $overlay;
					
		// If section has an aside, set columns
		if (($sectionInfo['aside']) || ($sectionInfo['aside-title'])) {
			$colLeft = calculateColumns($sectionInfo,'narrow');
			echo '<div class="row justify-content-around '. $sectionInfo['row-class'] .'">
					<div class="content-wrap col-'. $colLeft['XXS'] .' col-xxs-'. $colLeft['XXS'] .' col-xs-'. $colLeft['XS'] .' col-sm-'. $colLeft['SM'] .' col-md-'. $colLeft['MD'] .' col-lg-'. $colLeft['LG'] .' col-xl-'. $colLeft['XL'] .' col-xxl-'. $colLeft['XXL'] .' '. $sectionInfo['content-class'] .'">';
		} else {
			echo '<div class="row justify-content-center content-wrap '. $sectionInfo['class'] .'"><div class="col-12 col-md-11 '. $sectionInfo['content-class'] .'">';
		}
	?>
				
	<?=getTitles($introsection,'section',$sectionInfo['title-link'],$sectionInfo['header-class'],$sectionInfo['title-class'],$sectionInfo['subtitle-class'])?>
	<div class="content <?=$mainInfo['contentInnerClass']?>"><?php
		the_content();
	?></div>
				
    <?php
		// If section has an aside, add aside
		if (($sectionInfo['aside']) || ($sectionInfo['aside-title'])) {
			$sectionAside = addSectionAside($sectionInfo);
			echo $sectionAside;
		} else {
			echo '</div></div>';
		}
		echo '</div>';
		addSectionAdditional($mainInfo,$type='main');
		echo '</section>';
			endwhile;
    	else:
        	include (locate_template('/template-parts/content-none.php',true));         
    	endif;
	?>
   
    <?php
    $args = array(
            'child_of' => $thispage,
            'parent' => $thispage,
            'hierarchical' => 0,
            'sort_column' => 'menu_order',
            'sort_order' => 'asc',
            'post_status' => 'publish'
    );
   
    $sections = get_pages($args);
    $enableParallax = false;
    if ($sections) {
		foreach($sections as $section) {
			$sectionInfo['id'] = $section->ID;
			$sectionInfo['template'] = get_post_meta($sectionInfo['id'], '_wp_page_template', true);
			include(($sectionInfo['template'])?(locate_template($sectionInfo['template'])):(locate_template('/template-parts/content-none.php',true)));
			unset($sectionInfo);
		}
	}
    ?>
</main><!-- /#content-wrap -->
<?php get_footer(); ?>