<?php
/**
 * @package graftee
 */
?>
<?php if ( is_singular() ): ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_content(); ?>

		<?php wp_link_pages(); ?>
	</article>

	<?php graftee_post_nav(); ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
<?php else: ?>
	<li itemscope itemtype="http://schema.org/WebPage" <?php post_class(); ?>>
		<h2>
			<?php if ( the_title( '', '', false ) != '' ): ?>
				<?php the_title( sprintf( '<a href="%s" rel="bookmark" itemprop="url">', esc_url( get_permalink() ) ), '</a>' ); ?>
			<?php else: ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" itemprop="url"><?php echo graftee_get_public_word( 'read-post' ); ?></a>
			<?php endif; ?>
			<time itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</h2>

		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'image' ) ); ?>
		<?php elseif ( file_exists( get_stylesheet_directory().'/img/default-post-thumbnail.png' ) ): ?>
			<img src="<?php echo get_stylesheet_directory_uri().'/img/default-post-thumbnail.png'; ?>" alt="" />
		<?php endif; ?>

		<p itemprop="description">
			<?php if (has_excerpt()): ?>
				<?php echo get_the_excerpt(); ?>
			<?php else: ?>
				<?php graftee_make_excerpt(); ?>
			<?php endif; ?>
		</p>
	</li>
<?php endif; ?>
