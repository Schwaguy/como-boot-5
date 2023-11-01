<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: Page - Sidebar */ ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<section class="page-section">
		<div class="container main page-sidebar-right">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
				global $pid;
				$pid = $post->ID;
				$layout = getLayout($pid);
				//print_r($layout);
			?>
			<div class="row <?=$layout['row']?> <?=$layout['horizontal']?>">
				<div class="content-wrap <?=$layout['content']?>">
					<?php
						echo getTitles($pid,'page');
						?><div class="content"><?php
							the_content();
						?></div>
					<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
				</div>
				<?php if ($layout['sidebar-id'] != 'no-sidebar') : ?>
				<aside class="<?=$layout['sidebar']?>">
					<div id="sidebar"><?php get_sidebar(); ?></div>  	
				</aside>
				<?php endif; ?>
			</div><!-- /.row -->
			<?php
				endwhile;
			else:
				include (locate_template('/template-parts/content-none.php',true));         
			endif; ?>
		</div><!-- /.main -->
	 </section>
</main><!-- /#content-wrap -->
<?php get_footer(); ?>