<?php
/**
 * The template for displaying search results pages.
 *
 * @package graftee
 */

get_header( apply_filters( 'graftee_header_param', null ) ); ?>
	<article id="primary" class="content-area">
		<?php if (array_key_exists('onlycomments', $_GET) && $_GET['onlycomments'] == 1): ?>
			<h1><?php echo graftee_get_public_word( 'article-list' ); ?></h1>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<ul>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'search' ); ?>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</article>

	<?php graftee_post_nav(); ?>
	<?php graftee_paging_nav(); ?>
<?php get_footer(); ?>
