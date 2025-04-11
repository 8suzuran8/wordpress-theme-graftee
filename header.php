<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package graftee
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="<?php if ( is_search() ): ?>http://schema.org/SearchResultsPage<?php else: ?>http://schema.org/WebPage<?php endif; ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta itemprop="about" content="<?php echo wp_get_document_title(); ?>">
<base target="_parent">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php $graftee_advanced_settings_font_size = get_theme_mod( 'graftee_advanced_settings_font_size', null ); ?>
	<?php if ( !is_null( $graftee_advanced_settings_font_size ) && $graftee_advanced_settings_font_size === true ): ?>
		<input type="radio" name="change-font-size-button" value="05" id="change-font-size-button-05" hidden>
		<input type="radio" name="change-font-size-button" value="1" id="change-font-size-button-1" hidden checked>
		<input type="radio" name="change-font-size-button" value="2" id="change-font-size-button-2" hidden>
	<?php endif; ?>
	<?php wp_body_open(); ?>

	<header role="banner" itemscope itemtype="http://schema.org/WPHeader">
		<?php $graftee_advanced_settings_disabled_use_title = get_theme_mod( 'graftee_advanced_settings_disabled_use_title', null ); ?>
		<?php if ( is_null( $graftee_advanced_settings_disabled_use_title ) || $graftee_advanced_settings_disabled_use_title !== true ): ?>
			<h1 role="heading" itemprop="description">
				<?php echo graftee_get_header_h1_text(); ?>
			</h1>
		<?php endif; ?>

		<?php graftee_blogname(); ?>

		<a class="skip-link" href="#content"><?php echo graftee_get_public_word( 'skip-to-content' ); ?></a>
		<?php if ( !is_null( $graftee_advanced_settings_font_size ) && $graftee_advanced_settings_font_size === true ): ?>
			<section>
				<h2><?php echo graftee_get_public_word( 'change-font-size-button-title' ); ?></h2>
				<ul>
					<li><label for="change-font-size-button-05"><?php echo graftee_get_public_word( 'change-font-size-button-05' ); ?></label>
					<li><label for="change-font-size-button-1"><?php echo graftee_get_public_word( 'change-font-size-button-1' ); ?></label>
					<li><label for="change-font-size-button-2"><?php echo graftee_get_public_word( 'change-font-size-button-2' ); ?></label>
				</ul>
			</section>
		<?php endif; ?>
	</header>

	<?php if ( has_nav_menu( 'primary' ) ): ?>
		<nav role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<input type="checkbox" id="menu-toggle" itemscope itemtype="http://schema.org/IgnoreAction">
			<h2><label for="menu-toggle"><?php echo graftee_get_public_word( 'primary-menu' ); ?></label></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav>
	<?php endif; ?>

	<?php graftee_breadcrumb(); ?>

	<main id="content" role="main" itemprop="mainContentOfPage">
