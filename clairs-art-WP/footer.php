	<footer class="site-footer mt-5 py-5">
		<div class="container">
			<div class="row align-items-center gy-4">
				<div class="col-md-6">
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'nav justify-content-center justify-content-md-start',
						'depth'          => 1,
						'fallback_cb'    => false,
					]);
					?>
				</div>
				<div class="col-md-6 text-center text-md-end small">
					&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.
				</div>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
