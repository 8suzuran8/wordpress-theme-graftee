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
	<?php
		comment_form();
		if ( have_comments() ) :
	?>
	<p><?php comments_number(); ?></p>
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>
	<?php
		paginate_comments_links();
		endif;
	?>
<?php endif; ?>
<?php endif; ?>
