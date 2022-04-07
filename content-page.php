<?php
  /**
   * @package graftee
   */
?>
<?php if (array_key_exists('foriframe', $_GET) && $_GET['foriframe'] == 1): ?>
	<?php comments_template(); ?>
<?php else: ?>
<article>
	<?php if ( ( is_home() || is_front_page() ) && has_nav_menu( 'toppage' ) ): ?>
		<?php wp_nav_menu( array( 'theme_location' => 'toppage', 'container' => 'nav' ) ); ?>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php wp_link_pages(); ?>
</article>

<?php graftee_post_nav(); ?>

<?php if ( ( comments_open() || get_comments_number() ) ) : ?>
	<script>
		<?php
			// If comments are open or we have at least one comment, load up the comment template
			$iframe = '<iframe class="foriframe" src="' . graftee_get_comments_url() . '" scrolling="no"></iframe>';
			echo 'document.write(\'' . $iframe . '\')';
		?>
	</script>
	<noscript>
		<a href="<?php echo graftee_get_comments_url(); ?>"><?php echo graftee_get_public_word( 'comment' ); ?></a>
	</noscript>
<?php endif; ?>
<?php endif; ?>