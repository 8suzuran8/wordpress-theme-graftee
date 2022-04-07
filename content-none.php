<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package graftee
 */
?>
<p><?php echo graftee_get_public_word( 'not-found' ); ?></p>

<?php the_widget( 'WP_Widget_Recent_Posts', '', array( 'before_widget' => '', 'after_widget' => '', 'before_title' => '<h1 class="widgettitle">', 'after_title' => '</h1>' ) ); ?>

<h1><?php echo graftee_get_public_word( 'search-article' ); ?></h1>

<?php get_search_form(); ?>