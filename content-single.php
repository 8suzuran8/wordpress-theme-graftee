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
