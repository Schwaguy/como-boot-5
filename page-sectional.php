<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: Page - Sectional */ ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<?php 
		if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			$pageInfo = getPageInfo($post->ID);
			$GLOBALS['postID'] = $post->ID;
			
			// Format Main Page Section
			$mainInfo = $pageInfo['main'];
			?>
			<section id="<?=$mainInfo['mainID']?>" class="page-section <?=$mainInfo['bgclass']?> <?=$mainInfo['mainClass']?> clearfix" <?=$mainInfo['sectionStyle']?>>
				<?=checkBGoverlay($mainInfo)?>
				<div class="container main">
					
				<?php	
				// If section has an aside, set columns
				if (!empty($mainInfo['mainAside'])) {
					startSidebarSection($mainInfo,'main');
				} else {
					?><div class="content-wrap <?=$mainInfo['mainClass']?> <?=$mainInfo['contentClass']?>"><?php
				}
				?>
					<?=getPageHeaderComo($post->ID, $mainInfo)?>
					<div class="content <?=$mainInfo['contentInnerClass']?>"><?php
						the_content();
					?></div>
				</div><!-- /content-wrap --><?php	
	
				// If section has an aside, add aside
				if ((!empty($mainInfo['mainAside'])) && ($mainInfo['mainAside'] != 'no-sidebar')) {
					addSectionAside($mainInfo,'main');
					/*?></div><?php*/
				} else {
					?></div><?php
				}
				?>
				<?=addSectionAdditional($mainInfo,$type='main')?>	
					
				</div><!-- /container main -->
			</section><?php
			// Get Page Sections
			if ($pageInfo['sections']) {
				foreach($pageInfo['sections'] as $section) {
					if (!empty($section['sectionTemplate'])) {
						include(locate_template('/template-parts/'. $section['sectionTemplate']));	
					} else {
						include(locate_template('/template-parts/content-none.php',true));
					}
				}
			}
			endwhile;
		else:
			include (locate_template('/template-parts/content-none.php',true));         
		endif;
	?>
</main><!-- /#content-wrap -->
			
<?php get_footer(); ?>