<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*
Template Name: Full-Width Page
*/
?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<section class="page-section">
		<div class="main">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 content-wrap">
					<?=getTitles($post->ID,'page')?>
					<div class="content"><?php the_content(); ?></div>
				</div>
			</div>
			<?php
			endwhile;
			else:
				include (locate_template('/template-parts/content-none.php',true));     
			endif; ?>
			<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
		</div>
	</section>
</main><!-- /#content-wrap -->
	
<?php get_footer(); ?>