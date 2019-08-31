<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Deux
 */
?>
		<?php do_action( 'deux_content_after' ); ?>
	</div><!-- #content -->

	<?php do_action( 'deux_footer_before' ) ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action( 'deux_footer' ) ?>
	</footer><!-- #colophon -->

	<?php do_action( 'deux_footer_after' ) ?>

</div><!-- #page -->

<?php do_action( 'deux_site_after' ) ?>

<?php wp_footer(); ?>

</body>
</html>
