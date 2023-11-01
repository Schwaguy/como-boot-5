<?php defined('ABSPATH') or die('No Hackers!'); ?>
 	<footer id="site-footer">
    	<div id="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-4 col-lg-3 left">
						<?php if (is_active_sidebar('sidebar-footer-1')) { dynamic_sidebar('sidebar-footer-1'); } ?>
					</div>
					<div class="col-12 col-sm-12 col-md-4 col-lg-3 center">
						<?php if (is_active_sidebar('sidebar-footer-2')) { dynamic_sidebar('sidebar-footer-2'); } ?>
					</div>
					<div class="col-12 col-sm-12 col-md-4 col-lg-3 left">
						<?php if (is_active_sidebar('sidebar-footer-3')) { dynamic_sidebar('sidebar-footer-3'); } ?>
					</div>
				</div>
			</div>
		</div>
		<div id="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 left">
						<?php if (is_active_sidebar('sidebar-footer-4')) { dynamic_sidebar('sidebar-footer-4'); } ?>
						<p id="copyright">Copyright &copy; <?=date('Y')?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
					</div>
					<div class="col-12 col-sm-12 col-md-6 right">
						<?php if (is_active_sidebar('sidebar-footer-5')) { dynamic_sidebar('sidebar-footer-5'); } ?>
					</div>
				</div>
			</div>
		</div>
        <?php if (is_active_sidebar('sidebar-footer-schema')) { dynamic_sidebar('sidebar-footer-schema'); } ?>
    </footer>
	<a href="#top" id="link-top" class="d-flex align-items-center justify-content-center icon-link scroll-top" title="Back to Top" aria-label="Back to Top" role="button"><i class="fal fa-angle-up"></i></a>
    </div><!-- /#page-wrapper -->
	
	<?php
		if(!empty($GLOBALS['page-modals'])) { echo $GLOBALS['page-modals']; }
		$pID = get_queried_object_id();
		if (!empty($modals = get_post_meta($pID, 'comoModalCode', true))) { echo $modals; }
		wp_footer();
		if(!empty($GLOBALS['footScript'])) { echo $GLOBALS['footScript']; }
		if (!empty($scripts = get_post_meta($pID, 'comoFooterScrips', true))) { echo '<script type="text/javascript">'. $scripts .'</script>'; }
	?>
   
  </body>
</html>