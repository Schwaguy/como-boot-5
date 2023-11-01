<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section Full - Title Separate Contained
The default template part for displaying page sections 
*/
$sectionInfo = getSectionInfo($section);
$overlay = checkBGoverlay($sectionInfo);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['sectionClass']?> <?=$sectionInfo['bgclass']?> clearfix" <?=$sectionInfo['sectionStyle']?>>
	<?=$overlay?>
	<div class="section-content">
		<div class="main">
			<div class="title-wrap">
				<div class="container">
				<?php
				echo formatSectionTitles($sectionInfo['sectionTitle'], $sectionInfo['sectionSubtitle'], '', $sectionInfo['sectionTitleLink'], $sectionInfo['sectionHeaderClass'], $sectionInfo['sectionTitleClass'], $sectionInfo['sectionSubtitleClass'], '', 'section');
				?></div><!-- /container -->
			</div><!-- /title-wrap -->
			<?=formatSectionContent($sectionInfo,'section',false,false,false);?>
		</div>
	</div>
</section>