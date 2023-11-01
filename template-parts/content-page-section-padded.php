<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section Padded
Template part for displaying page sections with 1 column padding between 
*/
$sectionInfo = getSectionInfo($sectionInfo['id']);
$sectionStyle = (($sectionInfo['background']) ? 'style="'. $sectionInfo['background'] .'"' : '');
$bgInfo = $sectionStyle;
$overlay = checkBGoverlay($sectionInfo['id']);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['bgClass']?> <?=$sectionInfo['class']?> clearfix" <?=$sectionStyle?>>
	<?=$overlay . $staticBG?>
	<div class="section-content main">
		<div class="container main">
			<?php
			// If section has an aside, set columns 
			if (($sectionInfo['aside']) || ($sectionInfo['aside-title'])) {
				startSidebarSection($sectionInfo,'section');
			} 
		 
		 	echo getTitles($sectionInfo['id'],'section',$sectionInfo['title-link'],$sectionInfo['header-class'],$sectionInfo['title-class'],$sectionInfo['subtitle-class']);
		 	?><div class="content <?=$sectionInfo['sectionContentInnerClass']?>"><?php
			echo apply_filters('the_content', $sectionInfo['content']);
			?></div><?php
				   
		 	// If section has an aside, add aside
			if (($sectionInfo['aside']) || ($sectionInfo['aside-title'])) {
				addSectionAside($sectionInfo);
			} 
		 
		 	// Additional Content Section
			if (!empty($sectionInfo['sectionAdditionalContent'])) {	
				?><div class="section-additional-content"><?=apply_filters('the_content', $sectionInfo['sectionAdditionalContent'])?></div><!-- /section-additional-content --><?php
			}
		 
		 	?>
		</div>
	</div>
</section>