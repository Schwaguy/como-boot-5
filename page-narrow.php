<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: Page - Narrow */ ?>
<?php get_header(); ?>
<div id="content-wrap" aria-label="main" role="main">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-11">
				<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$pageInfo = getPageInfo($post->ID);
					$GLOBALS['postID'] = $post->ID;
					// Format Main Page Section
					$mainInfo = $pageInfo['main'];
					?><section id="<?=$mainInfo['mainID']?>" class="page-section <?=$mainInfo['bgclass']?> <?=$mainInfo['mainClass']?> clearfix" <?=$mainInfo['sectionStyle']?>><?php
					// If section has an aside, set columns
					if (!empty($mainInfo['mainAside'])) {
						startSidebarSection($pageInfo,'main');
						?><!--<div class="row <?=((!empty($mainInfo['rowAlignment'])) ? $mainInfo['rowAlignment'] : 'justify-content-center')?> <?=$mainInfo['rowClass']?>">
							<div class="content-wrap <?=$mainInfo['contentColumns']?> content <?=$mainInfo['contentClass']?>">--><?php
					} else {
						?><div class="content-wrap <?=$mainInfo['mainClass']?> <?=$mainInfo['contentClass']?>"><?php
					}
						$mainTitle = get_the_title($post->ID);
						$mainSubtitle = get_post_meta($post->ID,'pagesubtitle',true);
						$secondSubtitle = get_post_meta($post->ID,'pagesubtitle2',true);	   
						$mainHeader = formatSectionTitles($mainTitle, $mainSubtitle, $secondSubtitle, $mainInfo['titleLink'], $mainInfo['headerClass'], $mainInfo['titleClass'], $mainInfo['subtitleClass'], $mainInfo['subtitle2Class'], 'page');
						echo $mainHeader;
						?><div class="content"><?php
							the_content();
						?></div>
					</div><!-- /content-wrap --><?php
								// If section has an aside, add aside
					if ((!empty($mainInfo['mainAside'])) && ($mainInfo['mainAside'] != 'no-sidebar')) {
						addSectionAside($mainInfo,'main');
						//echo $sectionAside;
					} 
					?></section><?php
					endwhile;
				else:
					include (locate_template('/template-parts/content-none.php',true));         
				endif;
				?>
			</div>
		</div>
	</div>
</div><!-- /#content-wrap -->
			
<?php get_footer(); ?>