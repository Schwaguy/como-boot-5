<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/**
 * The template part for displaying single blog post
 */
the_post();
?>
<section class="single-post" itemscope itemtype="http://schema.org/NewsArticle">
	<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
	<header class="post-header-wrap">
        <?=getTitles(get_the_ID(),'post')?>
        <div class="post-meta">
        	<p class="post-date-author"><?php the_date('','<span class="post-date">','</span>'); ?> &nbsp;|&nbsp; <span itemprop="author" itemscope itemtype="https://schema.org/Person"><span class="post-author" itemprop="name"><?php the_author(); ?></span></span></p>
        </div><!-- end of .post-meta -->
	</header><!-- /.post-header-wrap -->
	<div class="post-content" itemprop="description">
		<?php the_content( __( 'Read more &#8250;', 'como-strap' ) ); ?>
	</div><!-- /.page-content -->
    
    <div class="navigation">
		<div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
		<div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
	</div>
	<!-- /.navigation -->
    
	<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
  	<meta itemprop="dateModified" content="<?php the_modified_time('c') ?>"/>
    
</section><!-- /.single-post -->