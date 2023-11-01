<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section - Title Full
The default template part for displaying page sections 
*/
$sectionInfo = getSectionInfo($section);
$overlay = checkBGoverlay($sectionInfo);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['sectionClass']?> <?=$sectionInfo['bgclass']?> clearfix" <?=$sectionInfo['sectionStyle']?>>
	<?=$overlay?>
	<div class="section-content">
		<div class="container main">
			<div class="row justify-content-center">
				<div class="col-12">
					<?php echo formatSectionTitles($sectionInfo['sectionTitle'], $sectionInfo['sectionSubtitle'], '', $sectionInfo['sectionTitleLink'], $sectionInfo['sectionHeaderClass'], $sectionInfo['sectionTitleClass'], $sectionInfo['sectionSubtitleClass'], '', 'section'); ?>
				</div>
			</div>
			
			<?php
			// If section has an aside, set columns 
			if (($sectionInfo['sectionAside'] != 'no-sidebar') || (!empty($sectionInfo['sectionAside']))) {
				startSidebarSection($sectionInfo,'section');
			} else {
				?>
				<div class="row <?=((!empty($sectionInfo['rowAlignment'])) ? $sectionInfo['rowAlignment'] : 'justify-content-center')?>">
					<div class="<?=((!empty($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : 'col-12')?> content-wrap <?=$sectionInfo['sectionContentClass']?>">
				<?php
			}
		 	
		 	?><div class="content <?=$sectionInfo['sectionContentInnerClass']?>"><?php
				$content = html_entity_decode($sectionInfo['sectionContent']);
				echo apply_filters('the_content', $content);
			?></div>
			</div><!-- /content-wrap --><?php	   
		 
			// If section has an aside, add aside
			if ((!empty($sectionInfo['sectionAside'])) && ($sectionInfo['sectionAside'] != 'no-sidebar')) {	
				addSectionAside($sectionInfo,'section');
			} 
		 	
			// Additional Content Section
			if (isset($sectionInfo['sectionAdditionalContent'])) {
				if (!empty($sectionInfo['sectionAdditionalContent'])) {	
					?><div class="section-additional-content"><?=apply_filters('the_content', $sectionInfo['sectionAdditionalContent'])?></div><!-- /section-additional-content --><?php
				}
			}
		 
			?>
		</div><!-- /containet.main -->
	</div><!-- /section-content -->
</section>