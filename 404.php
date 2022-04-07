<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package graftee
 */

get_header( apply_filters( 'graftee_header_param', null ) ); ?>
	<article class="error-404 not-found">
		<?php get_template_part( 'content', 'none' ); ?>
	</article>
<?php get_footer(); ?>
