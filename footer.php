<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package graftee
 */
?>
	</main>

	<?php get_sidebar( 'sidebar-1' ); ?>

	<footer role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
		<?php if ( has_nav_menu( 'secondary' ) ): ?>
			<nav>
				<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
			</nav>
		<?php endif; ?>

		<?php get_sidebar( 'footer' ); ?>

		<?php echo graftee_get_footer_html(); ?>
		<a href="#"><?php echo graftee_get_public_word( 'to-the-top' ); ?></a>
	</footer>

	<?php wp_footer(); ?>

</body>
</html>
