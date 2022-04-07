<?php
/**
 * The template for displaying all single posts.
 *
 * @package graftee
 */

get_header( apply_filters( 'graftee_header_param', null ) ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'single' ); ?>
	<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
