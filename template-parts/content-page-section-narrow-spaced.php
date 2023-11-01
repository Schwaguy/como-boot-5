<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section - Narrow Spaced
The default template part for displaying page sections 
*/
$sectionInfo = getSectionInfo($sectionInfo['id']);
$sectionStyle = (($sectionInfo['background']) ? 'style="'. $sectionInfo['background'] .'"' : '');
$bgInfo = $sectionStyle;
$overlay = checkBGoverlay($sectionInfo['id']);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['bgClass']?> <?=$sectionInfo['class']?> clearfix" <?=$bgInfo?>>
	<?=$overlay?>
	<div class="section-content main">
		<div class="container main">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-11 outer-wrap">
					<div class="inner-wrap">
						<?=formatSectionContent($sectionInfo,'section')?>
					</div><!-- /inner-wrap -->
				</div><!-- /outer-wrap -->
			</div><!-- /row -->
		</div>
	</div>
</section>