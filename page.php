<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<section class="page-section">
		<div class="container main content">
			<div class="row page-content">
				<div class="col-12 col-md-12 col-lg-12 content-wrap">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?=getTitles($post->ID,'page')?>
						<div class="content"><?php
							the_content();
						?></div>
					<?php
						endwhile;
					else:
						include (locate_template('/template-parts/content-none.php',true));         
					endif; ?>
					<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
				</div>
			</div>
		 </div><!-- /.main -->
	</section>
</main><!-- /#content-wrap -->
<?php get_footer(); ?>