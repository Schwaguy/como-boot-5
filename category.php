<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php get_header(); ?>
<div id="content-wrap" aria-label="main" role="main">
	<div class="container main">
		<section class="page-section">
			<div class="row justify-content-center">
				<?php 
					$sidebar = 'sidebar-main';
					if (is_active_sidebar($sidebar)) {
						?><div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 col-xl-9"><?php
					} else {
						?><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><?php	
					}
						if ( have_posts() ) {
							getTitles($post->ID,'post','','','');
							while ( have_posts() ) {
								if (is_front_page() && is_home()) { // Default homepage
									include(locate_template('/template-parts/content-blog.php',true));
								} elseif (is_front_page()) { // static homepage
									the_post();
									the_content();
								} elseif (is_home()) { // blog page
									include(locate_template('/template-parts/content-blog.php',true));
								} elseif (is_single()) { // single post page
									include_once(locate_template('/template-parts/content-single.php',true));
								} else { //everything else
									the_post();
									the_content();
								}
							}
						} else {
							include_once(locate_template('/template-parts/content-none.php',true));         
						}
					?>
					<?php
						if (is_home()) { // Blog page
							echo '<div id="pagination">'. paginate_links() .'</div>';
						}
					?>
					<?php if( !is_home() && !is_page() && !is_search() ) { ?>
						<div class="post-data">
							<?php the_tags( __( 'Tagged with:', 'como' ) . ' ', ', ', '<br />' ); ?>
							<?php printf( __( 'Posted in %s', 'como' ), get_the_category_list( ', ' ) ); ?>
						</div><!-- end of .post-data -->
						<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
					<?php } ?>
				</div>
				<?php
					if (is_active_sidebar($sidebar)) {
						?><aside class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3"><?php
						get_sidebar($sidebar);
						?></aside><?php
					} 
				?>  	
			</div>
		</section>
	</div><!-- /.container -->
</div><!-- /#content-wrap -->
<?php get_footer(); ?>