<?php
  /**
   * @package graftee
   */
?>
<?php if (array_key_exists('foriframe', $_GET) && $_GET['foriframe'] == 1): ?>
	<?php comments_template(); ?>
<?php else: ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>

	<?php wp_link_pages(); ?>

	<footer>
		<time itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>

		<?php
			$categories_list = get_the_category_list();
			if ( $categories_list && graftee_categorized_blog() ) {
				echo graftee_get_public_word( 'category' );
				echo $categories_list;
			}

			$tags_list = get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' );
			if ( $tags_list ) {
				echo graftee_get_public_word( 'tag' );
				echo $tags_list;
			}
		?>
	</footer>
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