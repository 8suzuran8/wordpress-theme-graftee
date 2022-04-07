<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package graftee
 */

if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}
?>

<aside id="widget1" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar( 'footer' ); ?>
</aside>
