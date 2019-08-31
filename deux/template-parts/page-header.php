<?php
/**
 * Template part for displaying page header
 */
?>
<div class="page-header">
	<?php if ($image = deux_get_page_header_image()): ?>
		<div class="page-header-image" style="background-image:url(<?php echo esc_url($image); ?>);"></div>
	<?php endif ?>
	<div class="deux-container clearfix">
		<?php
		if ( ! is_singular() ) {
			the_archive_title( '<h1 class="page-title">', '</h1>' );
		} elseif ( is_page() ) {
			printf( '<div class="page-title">%s</div>', single_post_title( '', false ) );
		} else {
			printf( '<h1 class="page-title">%s</h1>', single_post_title( '', false ) );
		}
		deux_site_breadcrumb();
		?>
	</div>
</div>