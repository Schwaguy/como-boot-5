<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<div class="container main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?=getTitles($post->ID,'post')?>
			<?php the_content(); ?>
		<?php
			endwhile;
		else:
			include (locate_template('/template-parts/content-none.php',true));       
		endif; ?>
		<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
	 </div><!-- /.main -->
</main><!-- /#content-wrap -->
	
<?php get_footer(); ?>