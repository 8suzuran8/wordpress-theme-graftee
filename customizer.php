<?php
/**
 * The customizer
 *
 * @package graftee
 */

if ( ! function_exists( 'graftee_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see graftee_custom_header_setup().
 */
function graftee_header_style() {
	$background_color = get_theme_mod( 'background_color' );

	if ( $background_color ) {
	?>
	<style>
		#comments,
		html {
			background-color: #<?php echo $background_color; ?>;
		}
	</style>
	<?php
	}

	$header_backgroundcolor = get_theme_mod( 'header_backgroundcolor' );

	if ( $header_backgroundcolor ) {
	?>
	<style>
		body > header,
		body > header h1,
		body > footer,
		body > aside h2,
		body > aside caption,
		body > main > article > ul > li[itemtype="http://schema.org/WebPage"] h2 {
			background-color: <?php echo $header_backgroundcolor; ?>;
		}

		body > footer,
		body > main article header h2,
		body > main article h1,
		body > main article h2,
		body > main article h3,
		body > main article h4,
		body > main article h5,
		body > main article h6 {
			border-color: <?php echo $header_backgroundcolor; ?>;
		}
	</style>
	<?php
	}

	if ( has_header_image() ) {
	?>
	<style>
		<?php echo graftee_get_header_image_style(); ?>
	</style>
	<?php
	}

	$header_text_color = get_theme_mod( 'header_textcolor' );

	if ( $header_text_color ) {
	?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( $header_text_color && $header_text_color != 'blank' ) :
	?>
			body > header,
			body > header h1,
			body > footer,
			body > aside h2,
			body > aside caption,
			body > main > article > ul > li[itemtype="http://schema.org/WebPage"] h2 {
				color: #<?php echo $header_text_color; ?>;
			}
		<?php
			// If the user has set a custom color for the text use that
			else :
		?>
			body > header,
			body > header h1,
			body > footer,
			body > aside h2,
			body > aside caption,
			body > main > article > ul > li[itemtype="http://schema.org/WebPage"] h2 {
				color: #fff;
			}
		<?php endif; ?>
			</style>
		<?php
	}
}
endif;
