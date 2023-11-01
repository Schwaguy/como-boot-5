<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section - Title Separate
The default template part for displaying page sections 
*/
$sectionInfo = getSectionInfo($section);
$overlay = checkBGoverlay($sectionInfo);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['sectionClass']?> <?=$sectionInfo['bgclass']?> clearfix" <?=$sectionInfo['sectionStyle']?>>
	<?=$overlay?>
	<div class="section-content">
		<div class="container main">
			<?php
			// If section has an aside, set columns 
			if (($sectionInfo['sectionAside'] != 'no-sidebar') || (!empty($sectionInfo['sectionAside']))) {
				startSidebarSection($sectionInfo,'section');
			} else {
				?>
				<div class="row <?=((!empty($sectionInfo['rowAlignment'])) ? $sectionInfo['rowAlignment'] : 'justify-content-center')?>">
					<div class="<?=((!empty($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : 'col-12 col-lg-11')?> content-wrap">
				<?php
			}
		 
			echo formatSectionTitles($sectionInfo['sectionTitle'], $sectionInfo['sectionSubtitle'], $sectionInfo['sectionTitleLink'], $sectionInfo['sectionHeaderClass'], $sectionInfo['sectionTitleClass'], $sectionInfo['sectionSubtitleClass'], 'section');
			$content = html_entity_decode($sectionInfo['sectionContent']);
			
			?><div class="content <?=$sectionInfo['sectionContentInnerClass']?>"><?
			echo apply_filters('the_content', $content);
			?></div><?php
			// If section has an aside, add aside
			if ((!empty($sectionInfo['sectionAside'])) && ($sectionInfo['sectionAside'] != 'no-sidebar')) {	
				addSectionAside($sectionInfo,'section');
			} else {
				?>
					</div>
				</div>
				<?php
			}
			
			// Additional Content Section
			if (isset($sectionInfo['sectionAdditionalContent'])) {
				if (!empty($sectionInfo['sectionAdditionalContent'])) {	
					?><div class="section-additional-content"><?=apply_filters('the_content', $sectionInfo['sectionAdditionalContent'])?></div><!-- /section-additional-content --><?php
				}
			}
			
			?>
		</div>
	</div>
</section>