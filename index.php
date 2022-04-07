<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package graftee
 */

get_header( apply_filters( 'graftee_header_param', null ) ); ?>
	<?php if ( is_singular() ): ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; // end of the loop. ?>
	<?php else : ?>
		<article id="primary" class="content-area">
			<?php if ( ( is_home() || is_front_page() ) && has_nav_menu( 'toppage' ) ): ?>
				<?php wp_nav_menu( array( 'theme_location' => 'toppage', 'container' => 'nav' ) ); ?>
			<?php endif; ?>

			<h1><?php echo graftee_get_public_word( 'article-list' ); ?></h1>

			<?php if ( have_posts() ) : ?>
				<ul>
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</article>

		<?php graftee_post_nav(); ?>
		<?php graftee_paging_nav(); ?>
	<?php endif; ?>
<?php get_footer(); ?>
