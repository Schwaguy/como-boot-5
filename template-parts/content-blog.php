<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/**
 * The template part for displaying blog page
 */
the_post();
$postInfo['title'] = get_the_title();
$postInfo['date'] = get_the_date('n.d.Y');
$postInfo['permalink'] = get_the_permalink();
$postInfo['author'] = get_the_author();
$postInfo['excerpt'] = get_the_excerpt();
?>
<section class="press-release" itemscope itemtype="http://schema.org/NewsArticle">
	<header class="post-header row" id="heading-<?php the_ID(); ?>" data-toggle="collapse" data-target="#collapse-<?php the_ID(); ?>" aria-expanded="false" aria-controls="collapse-<?php the_ID(); ?>" data-parent="#press-releases">
		<div class="col-2 post-meta">
        	<p class="post-date"><?=$postInfo['date']?></p>
        </div><!-- end of .post-meta -->
		<div class="col-10 post-title-cont">
			<h2 class="post-title"><!--<a href="<?=$postInfo['permalink']?>">--><?=$postInfo['title']?><!--</a>--></h2>
		</div>
	</header><!-- /.post-header -->
	<div itemprop="description" id="collapse-<?php the_ID(); ?>" class="post-content row collapse <?php if( $pr == 0 ) echo 'show'; ?>" role="tabpanel" aria-labelledby="heading-<?php the_ID(); ?>">
		<div class="col-10 offset-2"><?=$postInfo['excerpt']?></div>
	</div><!-- /.post-content -->
    
	<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
  	<meta itemprop="dateModified" content="<?php the_modified_time('c') ?>"/>
    
</section><!-- /.blog-post -->
<?php unset($postInfo); ?>