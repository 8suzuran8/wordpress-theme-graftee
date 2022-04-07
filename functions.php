<?php
/**
 * graftee functions and definitions
 *
 * @package graftee
 */

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function graftee_wp(){
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'graftee_wp' );

if ( ! function_exists( 'graftee_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function graftee_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on graftee, use a find and replace
		 * to change 'graftee' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'graftee', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'メインメニュー', 'graftee' ),
			'secondary' => __( 'フッターメニュー', 'graftee' ),
			'toppage' => __( 'トップページメニュー', 'graftee' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'graftee_custom_background_args', array(
			'default-color' => 'f3f3f3',
			'default-image' => '',
		) ) );

		add_theme_support( 'title-tag' );

		// add_theme_support( 'custom-logo' );
	}
} // end of graftee_setup
add_action( 'after_setup_theme', 'graftee_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function graftee_widgets_init() {
	register_sidebar( array(
		'name'		=> __( 'サイドバー', 'graftee' ),
		'id'		=> 'sidebar-1',
		'description'	=> '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h2 class="widget-title">',
		'after_title'	=> '</h2>',
	) );

	register_sidebar( array(
		'name'		=> __( 'フッターバー', 'graftee' ),
		'id'		=> 'footer',
		'description'	=> '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '',
		'after_title'	=> '',
	) );
}

add_action( 'widgets_init', 'graftee_widgets_init' );

function graftee_get_public_word( $type, $use_settings = true ) {
	if ( $use_settings ) {
		$option = get_theme_mod( 'graftee_advanced_settings_' . $type );
		if ( !in_array( $option, array( '', false ) ) ) {
			return $option;
		}
	}

	if ( has_filter( 'graftee_get_public_word_full' ) ) {
		return apply_filters( 'graftee_get_public_word_full', '', $type );
	}

	$result = '';
	switch ( $type ) {
		case 'article-list':
			$result = __( '記事の一覧', 'graftee' );
			break;
		case 'n-comments':
			$result = __( '%d件のコメント', 'graftee' );
			break;
		case 'older-comments':
			$result = __( '過去のコメント', 'graftee' );
			break;
		case 'newer-comments':
			$result = __( '最新コメント', 'graftee' );
			break;
		case 'close-comments':
			$result = __( 'コメントは締め切られました', 'graftee' );
			break;
		case 'comment':
			$result = __( 'コメント', 'graftee' );
			break;
		case 'name':
			$result = __( 'お名前', 'graftee' );
			break;
		case 'email':
			$result = __( 'メールアドレス', 'graftee' );
			break;
		case 'not-found':
			$result = __( '本文が見つかりません', 'graftee' );
			break;
		case 'search-article':
			$result = __( '記事の検索', 'graftee' );
			break;
		case 'read-post':
			$result = __( '記事を読む', 'graftee' );
			break;
		case 'category':
			$result = __( '<h2>カテゴリー</h2>', 'graftee' );
			break;
		case 'tag':
			$result = __( '<h2>タグ</h2>', 'graftee' );
			break;
		case 'to-the-top':
			$result = __( '上部へ', 'graftee' );
			break;
		case 'skip-to-content':
			$result = __( '本文へ移動', 'graftee' );
			break;
		case 'primary-menu':
			$result = __( 'メニュー', 'graftee' );
			break;
		case 'search-result':
			$result = __( '検索結果：%s', 'graftee' );
			break;
		case 'n-posts':
			$result = __( '%d件の投稿', 'graftee' );
			break;
		case '404':
			$result = __( '404 Not found', 'graftee' );
			break;
		case 'this-article':
			$result = __( 'この記事', 'graftee' );
			break;
		case 'not-found2':
			$result = __( '見つかりません', 'graftee' );
			break;
		case 'n-pages':
			$result = __( '%dページ', 'graftee' );
			break;
		case 'change-font-size-button-05':
			$result = __( '小', 'graftee' );
			break;
		case 'change-font-size-button-1':
			$result = __( '中', 'graftee' );
			break;
		case 'change-font-size-button-2':
			$result = __( '大', 'graftee' );
			break;
		case 'change-font-size-button-title':
			$result = __( '文字サイズ', 'graftee' );
			break;
	}

	return apply_filters( 'graftee_get_public_word', $result, $type );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function graftee_advanced_settings_checkbox_validate( $checked ) {
	if ( $checked ) {
		return true;
	}

	return false;
}

function graftee_advanced_settings_word_validate( $checked ) {
	return $checked;
}

function graftee_multiple_header_images_validate( $checked ) {
	return $checked;
}

function graftee_multiple_header_images_animation_type_validate( $type ) {
	return $type;
}

function graftee_advanced_settings_text_validate( $text ) {
	return $text;
}

function graftee_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'graftee_site_title_img', array(
		'transport'	    => 'refresh',
		'sanitize_callback' => 'graftee_advanced_settings_text_validate',
		'placeholder' => 'URL',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_site_title_img', array(
		'label'	   => __( 'サイトのタイトル画像URL', 'graftee' ),
		'type'     => 'text',
		'section'  => 'title_tagline',
		'settings' => 'graftee_site_title_img',
		'default'  => '',
	) ) );

	$wp_customize->add_setting( 'background_color' , array(
		'default'           => null,
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_setting( 'header_backgroundcolor', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_backgroundcolor', array(
		'settings' => 'header_backgroundcolor',
		'label'	   => __( 'ヘッダー背景色', 'graftee' ),
		'section'  => 'colors',
	) ) );

	$wp_customize->add_setting( 'multiple_header_images', array(
		'sanitize_callback' => 'graftee_multiple_header_images_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'multiple_header_images', array(
		'settings' => 'multiple_header_images',
		'label' => __( '全てのヘッダー画像を表示(5枚以上設定した場合のみ)', 'graftee' ),
		'section' => 'header_image',
		'default' => false,
		'type' => 'checkbox',
	) ) );

	$wp_customize->add_setting( 'multiple_header_images_animation_type', array(
		'sanitize_callback' => 'graftee_multiple_header_images_animation_type_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'multiple_header_images_animation_type', array(
		'settings' => 'multiple_header_images_animation_type',
		'label' => __( 'ヘッダー画像のアニメーション', 'graftee' ),
		'section' => 'header_image',
		'type' => 'select',
		'default' => 1,
		'choices' => array(
			1 => __( '右から左に流れる', 'graftee' ),
			2 => __( '左から右に流れる', 'graftee' ),
			3 => __( '上から下に流れる', 'graftee' ),
			4 => __( '下から上に流れる', 'graftee' ),
		),
	) ) );

	$wp_customize->add_section( 'graftee_advanced_settings' , array(
		'title'	   => sprintf( __( '%s設定', 'graftee' ), wp_get_theme() ),
		'priority' => 121,
	) );

	$wp_customize->add_setting( 'graftee_advanced_settings_breadcrumbs', array(
		'transport'	    => 'postMessage',
		'sanitize_callback' => 'graftee_advanced_settings_checkbox_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_breadcrumbs', array(
		'label'	   => __( 'パンくずリストを使用する', 'graftee' ),
		'type'	   => 'checkbox',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_breadcrumbs',
	) ) );

	$wp_customize->add_setting( 'graftee_advanced_settings_font_size', array(
		'transport'	    => 'refresh',
		'sanitize_callback' => 'graftee_advanced_settings_checkbox_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_font_size', array(
		'label'	   => __( '文字サイズボタンを表示する', 'graftee' ),
		'type'	   => 'checkbox',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_font_size',
	) ) );

	$wp_customize->add_setting( 'graftee_advanced_settings_disabled_use_title', array(
		'transport'	    => 'refresh',
		'sanitize_callback' => 'graftee_advanced_settings_checkbox_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_disabled_use_title', array(
		'label'	   => __( 'タイトルの使用を無効にする', 'graftee' ),
		'type'	   => 'checkbox',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_disabled_use_title',
	) ) );

	$wp_customize->add_setting( 'graftee_advanced_settings_disabled_stylecss', array(
		'transport'	    => 'postMessage',
		'sanitize_callback' => 'graftee_advanced_settings_checkbox_validate',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_disabled_stylecss', array(
		'label'	   => __( 'style.cssを無効にする', 'graftee' ),
		'type'	   => 'checkbox',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_disabled_stylecss',
		'default'  => 0,
	) ) );

	$wp_customize->add_setting( 'graftee_advanced_settings_add_css', array(
		'transport'	    => 'postMessage',
		'sanitize_callback' => 'graftee_advanced_settings_text_validate',
		'placeholder' => 'URL',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_add_css', array(
		'label'	   => __( 'CSSファイルを追加する', 'graftee' ),
		'type'     => 'text',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_add_css',
		'default'  => '',
	) ) );

	$wp_customize->add_setting( 'graftee_advanced_settings_credit', array(
		'transport'	    => 'postMessage',
		'sanitize_callback' => 'graftee_advanced_settings_text_validate',
		'placeholder' => 'URL',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_credit', array(
		'label'	   => __( 'footerのクレジット表示', 'graftee' ),
		'type'     => 'text',
		'section'  => 'graftee_advanced_settings',
		'settings' => 'graftee_advanced_settings_credit',
		'default'  => '',
	) ) );

	$word_keys = array(
		'article-list',
		'n-comments',
		'older-comments',
		'newer-comments',
		'close-comments',
		'comment',
		'name',
		'email',
		'not-found',
		'search-article',
		'read-post',
		'category',
		'tag',
		'to-the-top',
		'skip-to-content',
		'primary-menu',
		'search-result',
		'n-posts',
		'404',
		'this-article',
		'not-found2',
		'n-pages',
		'change-font-size-button-05',
		'change-font-size-button-1',
		'change-font-size-button-2',
		'change-font-size-button-title',
	);

	foreach ($word_keys as $value) {
		$wp_customize->add_setting( 'graftee_advanced_settings_' . $value, array(
			'transport'	    => 'postMessage',
			'sanitize_callback' => 'graftee_advanced_settings_word_validate',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'graftee_advanced_settings_' . $value, array(
			'label'	   => "'".graftee_get_public_word( $value, false )."'",
			'description' => __( 'を次の文字に変更', 'graftee' ),
			'type'	   => 'text',
			'section'  => 'graftee_advanced_settings',
			'settings' => 'graftee_advanced_settings_' . $value,
		) ) );

		$wp_customize->get_setting( 'graftee_advanced_settings_' . $value )->transport = 'postMessage';
	}

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';
	$wp_customize->get_setting( 'header_backgroundcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
}

add_action( 'customize_register', 'graftee_customize_register' );

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses graftee_header_style()
 * @uses graftee_admin_header_style()
 * @uses graftee_admin_header_image()
 */
function graftee_after_setup_theme() {
	$wp_head_callback = 'graftee_header_style';
	if ( file_exists( get_stylesheet_directory().'/customizer.php' ) ) {
		require_once( get_stylesheet_directory().'/customizer.php' );
		$wp_head_callback = str_replace( '-', '_', get_stylesheet() ).'_header_style';
	} else {
		require_once( 'customizer.php' );
	}

	add_theme_support( 'custom-header', apply_filters( 'graftee_custom_header_args', array(
		'default-image'		 => '',
		'default-text-color'	 => 'ffffff',
		'width'			 => 1000,
		'height'		 => 250,
		'flex-height'		 => true,
		'wp-head-callback'	 => $wp_head_callback,
		'admin-head-callback'	 => 'graftee_admin_header_style',
		'admin-preview-callback' => 'graftee_admin_header_image',
		'header_textcolor' => true,
		'header_text' => true,
	) ) );
}

add_action( 'after_setup_theme', 'graftee_after_setup_theme' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function graftee_customize_preview_init() {
	$customizer_js_uri = get_stylesheet_directory().'/customizer.js';
	if ( file_exists( get_stylesheet_directory().'/customizer.js' ) ) {
		$customizer_js_uri = get_stylesheet_directory_uri().'/customizer.js';
	} else {
		$customizer_js_uri = get_template_directory_uri().'/customizer.js';
	}

	wp_enqueue_script(
		'graftee_customizer',
		$customizer_js_uri,
		array( 'jquery', 'customize-preview' )
	);
}

add_action( 'customize_preview_init', 'graftee_customize_preview_init' );

function graftee_get_multiple_header_images_animation_type1( $reverse = false ) {
	$uploaded_header_images = get_uploaded_header_images();
	$uploaded_header_image_count = count( $uploaded_header_images );

	$result = '';

	// background: url(...) center center no-repeat, url(...) 100vw center no-repeat, url(...) 100vw center no-repeat,,,,
	$i = 0;
	$background_style = 'background:';
	$background_size_style = 'background-size:';
	foreach ( $uploaded_header_images as $uploaded_header_image ) {
		$background_style .= 'url(' . $uploaded_header_image[ 'url' ] . ') ';
		if ( $i == 0 ) {
			$background_style .= '0';
		} elseif ( $i == $uploaded_header_image_count - 1 ) {
			if ( !$reverse ) $background_style .= '-';
			$background_style .= '100vw';
		} else {
			if ( $reverse ) $background_style .= '-';
			$background_style .= '100vw';
		}

		if ( in_array( $i, array( 0, 1 ) ) ) {
			$background_size_style .= '100%';
		} else {
			$background_size_style .= '0';
		}

		$background_style .= ' center no-repeat';

		if ( $i == $uploaded_header_image_count - 1 ) {
			$background_style .= ';';
			$background_size_style .= ';';
		} else {
			$background_style .= ',';
			$background_size_style .= ',';
		}

		$i ++;
	}

	$result .= 'body.use-header-image.use-header-image-animation > header::before {';
	$result .= $background_style;
	$result .= $background_size_style;

	$result .= 'animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-moz-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-webkit-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-o-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-ms-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '}';

	/*
		0% { background-position: center center, 100vw center, 100vw center,,,
		33% { background-position: -100vw center, center center, 100vw center,,,
		66% { background-position: -100vw center, -100vw center, center center,,,
	  ...
	*/
	$animations = array();

	$position_100per = null;
	$size_100per = null;

	$i = 0;
	foreach ( $uploaded_header_images as $uploaded_header_image ) {
		$position = '';
		$size = '';
		for ( $j = 0; $j < $uploaded_header_image_count; $j ++ ) {
			if ( $j == $i ) {
				$position .= '0';
			} elseif ( $j == $i - 1
					   || $j == $i - 2
					   || ( $i == 1 && $j == $uploaded_header_image_count - 1 )
					   || ( $i == 0 && ( $j == $uploaded_header_image_count - 2 || $j == $uploaded_header_image_count - 1 ) )
			) {
				if ( !$reverse ) $position .= '-';
				$position .= '100vw';
			} else {
				if ( $reverse ) $position .= '-';
				$position .= '100vw';
			}

			$position .= ' center';

			if ( in_array( $j, array( $i + 1, $i, $i - 1 ) )
				 || ( $j == $uploaded_header_image_count - 1 && $i == 0 )
				 || ( $i == $uploaded_header_image_count - 1 && $j == 0 )
			) {
				$size .= '100%';
			} else {
				$size .= '0';
			}

			if ( $j == $uploaded_header_image_count - 1 ) {
				$position .= ';';
				$size .= ';';
			} else {
				$position .= ',';
				$size .= ',';
			}
		}

		$animations[ $i ] = '';

		$animations[ $i ] .= ( 100 / $uploaded_header_image_count * ( $i + 0 ) ) . '% {';
		$animations[ $i ] .= 'background-position: ';
		$animations[ $i ] .= $position;
		$animations[ $i ] .= 'background-size: ';
		$animations[ $i ] .= $size;
		$animations[ $i ] .= '}' . "\n";

		$animations[ $i ] .= ( 100 / $uploaded_header_image_count * ( $i + 0.7 ) ) . '%  {';
		$animations[ $i ] .= 'background-position: ';
		$animations[ $i ] .= $position;
		$animations[ $i ] .= 'background-size: ';
		$animations[ $i ] .= $size;
		$animations[ $i ] .= '}' . "\n";

		if ( $i == 0 ) {
			$position_100per = $position;
			$size_100per = $size;
		}

		$i ++;
	}

	$i ++;
	$animations[ $i ] = '';
	$animations[ $i ] .= '100%  {';
	$animations[ $i ] .= 'background-position: ';
	$animations[ $i ] .= $position_100per;
	$animations[ $i ] .= 'background-size: ';
	$animations[ $i ] .= $size_100per;
	$animations[ $i ] .= '}' . "\n";

	$result .= '@-webkit-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-moz-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-o-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-ms-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	return $result;
}

function graftee_get_multiple_header_images_animation_type2( $reverse = false ) {
	$uploaded_header_images = get_uploaded_header_images();
	$uploaded_header_image_count = count( $uploaded_header_images );

	$result = '';

	// background: url(...) center center no-repeat, url(...) center 100vh no-repeat, url(...) center 100vh no-repeat,,,,
	$i = 0;
	$background_style = 'background:';
	$background_size_style = 'background-size:';
	foreach ( $uploaded_header_images as $uploaded_header_image ) {
		$background_style .= 'url(' . $uploaded_header_image[ 'url' ] . ') center ';
		if ( $i == 0 ) {
			$background_style .= '0';
		} elseif ( $i == $uploaded_header_image_count - 1 ) {
			if ( $reverse ) $background_style .= '-';
			$background_style .= '100vh';
		} else {
			if ( !$reverse ) $background_style .= '-';
			$background_style .= '100vh';
		}

		$background_style .= ' no-repeat';

		if ( in_array( $i, array( 0, 1 ) ) ) {
			$background_size_style .= 'contain';
		} else {
			$background_size_style .= '0';
		}

		if ( $i == $uploaded_header_image_count - 1 ) {
			$background_style .= ';';
			$background_size_style .= ';';
		} else {
			$background_style .= ',';
			$background_size_style .= ',';
		}

		$i ++;
	}

	$result .= 'body.use-header-image.use-header-image-animation > header::before {';
	$result .= $background_style;
	$result .= $background_size_style;

	$result .= 'animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-moz-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-webkit-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-o-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '-ms-animation: header-image-slider ' . $uploaded_header_image_count * 6 . 's ease 0s infinite;';
	$result .= '}';

	/*
		0% { background-position: center center, center 100vh, center 100vh,,,
		33% { background-position: center -100vh, center center, center 100vh,,,
		66% { background-position: center -100vh, center -100vh, center center,,,
	  ...
	*/
	$animations = array();

	$position_100per = null;
	$size_100per = null;

	$i = 0;
	foreach ( $uploaded_header_images as $uploaded_header_image ) {
		$position = '';
		$size = '';
		for ( $j = 0; $j < $uploaded_header_image_count; $j ++ ) {
			$position .= 'center ';

			if ( $j == $i ) {
				$position .= 'center';
			} elseif ( $j == $i - 1
					   || $j == $i - 2
					   || ( $i == 1 && $j == $uploaded_header_image_count - 1 )
					   || ( $i == 0 && ( $j == $uploaded_header_image_count - 2 || $j == $uploaded_header_image_count - 1 ) )
			) {
				if ( $reverse ) $position .= '-';
				$position .= '100vh';
			} else {
				if ( !$reverse ) $position .= '-';
				$position .= '100vh';
			}

			if ( in_array( $j, array( $i + 1, $i, $i - 1 ) )
				 || ( $j == $uploaded_header_image_count - 1 && $i == 0 )
				 || ( $i == $uploaded_header_image_count - 1 && $j == 0 )
			) {
				$size .= 'contain';
			} else {
				$size .= '0';
			}

			if ( $j == $uploaded_header_image_count - 1 ) {
				$position .= ';';
				$size .= ';';
			} else {
				$position .= ',';
				$size .= ',';
			}
		}

		$animations[ $i ] = '';

		$animations[ $i ] .= ( 100 / $uploaded_header_image_count * ( $i + 0 ) ) . '% {';
		$animations[ $i ] .= 'background-position: ';
		$animations[ $i ] .= $position;
		$animations[ $i ] .= 'background-size: ';
		$animations[ $i ] .= $size;
		$animations[ $i ] .= '}' . "\n";

		$animations[ $i ] .= ( 100 / $uploaded_header_image_count * ( $i + 0.7 ) ) . '%  {';
		$animations[ $i ] .= 'background-position: ';
		$animations[ $i ] .= $position;
		$animations[ $i ] .= 'background-size: ';
		$animations[ $i ] .= $size;
		$animations[ $i ] .= '}' . "\n";

		if ( $i == 0 ) {
			$position_100per = $position;
			$size_100per = $size;
		}

		$i ++;
	}

	$i ++;
	$animations[ $i ] = '';
	$animations[ $i ] .= '100%  {';
	$animations[ $i ] .= 'background-position: ';
	$animations[ $i ] .= $position_100per;
	$animations[ $i ] .= 'background-size: ';
	$animations[ $i ] .= $size_100per;
	$animations[ $i ] .= '}' . "\n";

	$result .= '@-webkit-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-moz-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-o-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	$result .= '@-ms-keyframes header-image-slider {';
	foreach ( $animations as $animation ) $result .= $animation;
	$result .= '}';

	return $result;
}

function graftee_get_header_image_style() {
	if ( !has_header_image() ) {
		return null;
	}

	get_theme_mod( 'multiple_header_images' );
	$uploaded_header_images = get_uploaded_header_images();
	$uploaded_header_image_count = count( $uploaded_header_images );

	if ( !get_theme_mod( 'multiple_header_images' ) || $uploaded_header_image_count < 5 ) {
		$result = 'body.use-header-image.use-header-image-animation > header::before {background-image: url(' . get_header_image() . ');}';
		return $result;
	}

	switch ( get_theme_mod( 'multiple_header_images_animation_type' ) ) {
		case 1:
			return graftee_get_multiple_header_images_animation_type1();
			break;
		case 2:
			return graftee_get_multiple_header_images_animation_type1( true );
			break;
		case 3:
			return graftee_get_multiple_header_images_animation_type2();
			break;
		case 4:
			return graftee_get_multiple_header_images_animation_type2( true );
			break;
	}

	return graftee_get_multiple_header_images_animation_type1();
}

if ( is_admin() ) {
	function graftee_wp_loaded() {
		$options = get_option( 'graftee_theme_options' );

		if ( ! is_array( $options) ) {
			return;
		}

		if ( ! array_key_exists( 'show_breadcrumb', $options ) ) {
			return;
		}

		if ( ! is_null( get_theme_mod( 'graftee_advanced_settings_breadcrumbs', null ) ) ) {
			return;
		}

		set_theme_mod( 'graftee_advanced_settings_breadcrumbs', ( $options[ 'show_breadcrumb' ] == 1 ? true : false ) );
	}

	add_action( 'wp_loaded', 'graftee_wp_loaded' );

	function graftee_switch_theme() {
		remove_theme_mod( 'background_color' );
		remove_theme_mod( 'header_backgroundcolor' );
		remove_theme_mod( 'header_textcolor' );
	}

	add_action( 'switch_theme', 'graftee_switch_theme' );

	/**
	 * Flush out the transients used in graftee_categorized_blog.
	 */
	function graftee_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'graftee_categories' );
	}
	add_action( 'edit_category', 'graftee_category_transient_flusher' );
	add_action( 'save_post',	 'graftee_category_transient_flusher' );

	if ( file_exists( get_stylesheet_directory().'/editor-style.css' ) ) {
		add_editor_style( get_stylesheet_directory_uri().'/editor-style.css' );
	} else {
		add_editor_style('editor-style.css' );
	}

	function graftee_get_news_directory() {
		$news_dir = '';
		if ( file_exists( get_stylesheet_directory().'/news.php' ) ) {
			$news_dir = get_stylesheet_directory().'/news.php';
		} else if ( file_exists( get_template_directory().'/news.php' ) ) {
			$news_dir = get_template_directory().'/news.php';
		}

		return $news_dir;
	}

	$news_dir = graftee_get_news_directory();

	if ( $news_dir != '' && filesize( $news_dir ) > 0 ) {
		add_action( 'wp_dashboard_setup', 'graftee_add_dashboard_widgets' );

		function graftee_add_dashboard_widgets() {
			wp_add_dashboard_widget( 'graftee_dashboard_widget', wp_get_theme() . ' ' . __( 'ニュース', 'graftee' ), 'graftee_dashboard_widget_callback' );
		}

		function graftee_dashboard_widget_callback() {
			$news_dir = graftee_get_news_directory();

			require( $news_dir );
		}
	}

	function graftee_wp_ajax_dynamic_modal() {
		ob_start();
		header('Content-Type: text/html; charset=utf-8');
		include get_template_directory() . '/editor-plugin-event-editor.php';
		$string = ob_get_clean();
		exit($string);
	}

	add_action( 'wp_ajax_dynamic_modal', 'graftee_wp_ajax_dynamic_modal' );

	function graftee_admin_init_tinymce_button() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can('edit_pages') ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', 'graftee_mce_external_plugins' );
			add_filter( 'mce_buttons', 'graftee_mce_buttons' );
		}
	}

	function graftee_mce_buttons( $buttons ) {
		array_push( $buttons, 'event-editor' );
		return $buttons;
	}

	function graftee_mce_external_plugins( $plugin_array ) {
		$plugin_array[ 'eventEditor' ] = get_template_directory_uri().'/editor-plugin.js';
		return $plugin_array;
	}

	add_action( 'admin_init', 'graftee_admin_init_tinymce_button' );

	function graftee_tiny_mce_before_init( $initArray ) {
		$add_element_attribute = 'article[itemscope|itemtype|itemprop],h1[itemprop],time[itemprop|datetime],p[itemprop]';

		if ( empty( $initArray[ 'extended_valid_elements' ] ) ) {
			$initArray[ 'extended_valid_elements' ] = $add_element_attribute;
		} else {
			$initArray[ 'extended_valid_elements' ] .= ',' . $add_element_attribute;
		}

		return $initArray;
	}

	add_filter( 'tiny_mce_before_init', 'graftee_tiny_mce_before_init', 11 );


	function graftee_get_admin_word( $type, $use_settings = true ) {
		if ( $use_settings ) {
			$option = get_theme_mod( 'graftee_advanced_settings_' . $type );
			if ( !in_array( $option, array( '', false ) ) ) {
				return $option;
			}
		}

		if ( has_filter( 'graftee_get_admin_word_full' ) ) {
			return apply_filters( 'graftee_get_admin_word_full', '', $type );
		}

		$result = '';
		switch ( $type ) {
			case 'event-name':
				$result = __( 'イベント名', 'graftee' );
				break;
			case 'start-time':
				$result = __( '開始時間', 'graftee' );
				break;
			case 'end-time':
				$result = __( '終了時間', 'graftee' );
				break;
			case 'event-info':
				$result = __( 'イベント情報', 'graftee' );
				break;
			case 'event-message':
				$result = __( '書き出し後もエディタ側で編集可能です', 'graftee' );
				break;
			case 'export':
				$result = __( '書き出し', 'graftee' );
				break;
		}

		return apply_filters( 'graftee_get_admin_word', $result, $type );
	}
} else {
	if ( ! function_exists( 'wp_get_document_title' ) ) {
		function wp_get_document_title() {
			return wp_title( '|', false, 'right' );
		}
	}

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 320; /* pixels */
	}

	/**
	 * Enqueue scripts and styles.
	 */
	function graftee_wp_enqueue_scripts() {
		wp_enqueue_style( 'graftee-style', get_stylesheet_uri() );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( file_exists( get_stylesheet_directory().'/graftee.js' ) ) {
			wp_enqueue_script(
				'graftee_child_javascript',
				get_stylesheet_directory_uri().'/graftee.js'
			);
		}
	}

	add_action( 'wp_enqueue_scripts', 'graftee_wp_enqueue_scripts' );

	if ( ! function_exists( 'graftee_paging_nav' ) ) {
		/**
		 * Display navigation to next/previous set of posts when applicable.
		 */
		function graftee_paging_nav() {
			if ( is_singular() ) {
				return ;
			}

			// Don't print empty markup if there's only one page.
			if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
				return;
			}

			global $wp_query, $paged;
			$big = 999999999;

			$pages = $wp_query -> max_num_pages;
			if ( empty( $paged ) ) $paged = 1;

			echo paginate_links( array(
				'base'	    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'	    => $wp_query -> max_num_pages,
				'mid_size'  => 3,
				'prev_text' => __( '前へ', 'graftee' ),
				'next_text' => __( '次へ', 'graftee' ),
				'type'	    => 'list'
			) );
		}
	}

	if ( ! function_exists( 'graftee_post_nav' ) ) {
		/**
		 * Display navigation to next/previous post when applicable.
		 */
		function graftee_post_nav() {
			if ( !is_singular() ) {
				return ;
			}

			// Don't print empty markup if there's nowhere to navigate.
			$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
			$next	  = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}
			?>
			<ul class="nav-links navigation post-navigation">
				<?php
					previous_post_link( '<li class="nav-previous">%link</li>', '%title' );
					next_post_link( '<li class="nav-next">%link</li>', '%title' );
				?>
			</ul>
			<?php
		}
	}

	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @param array $args Configuration arguments.
	 * @return array
	 */
	function graftee_wp_page_menu_args() {
		$args['show_home'] = true;
		return $args;
	}

	add_filter( 'wp_page_menu_args', 'graftee_wp_page_menu_args' );

	if ( ! function_exists( 'graftee_category_ancetitles' ) ) {
		function graftee_category_ancetitles( $page ) {
			$cat = get_the_category();
			if ( count( $cat ) == 0 ) {
				return '';
			}

			$ancestors = array();

			$ancestors[] = '<li><a href="' . get_category_link($cat[0]->term_id) . '" itemprop="url">' . $cat[0]->cat_name . '</a></li>';
			$parent_cat_id = $cat[0]->parent;

			while ( $parent_cat_id != 0 ) {
				$cat = get_category( $parent_cat_id );
				$ancestors[] = '<li><a href="' . get_category_link($cat->term_id) . '" itemprop="url">' . $cat->cat_name . '</a></li>';
				$parent_cat_id = $cat->parent;
			}

			return join( '', array_reverse( $ancestors ) );
		}
	}

	if ( ! function_exists( 'graftee_make_excerpt' ) ) {
		function graftee_make_excerpt( $length = 100 ) {
			global $post;
			if ( post_password_required() ) {
				_e( 'このコンテンツはパスワードで保護されています。閲覧するには以下にパスワードを入力してください。', 'graftee' );
				return;
			}

			$excerpt = str_replace( array(' ', "\r\n", "\r", "\n"), ' ', strip_tags( $post->post_content ) );
			$excerpt = preg_replace( '/\[[^\]]*\]/', '', $excerpt );

			echo mb_substr( $excerpt, 0, $length );
		}
	}

	function graftee_body_class( $classes ) {
		switch ( get_option( 'start_of_week' ) ) {
			case 0:
				$classes[] = 'start-of-week-sun';
				break;
			case 1:
				$classes[] = 'start-of-week-mon';
				break;
			case 2:
				$classes[] = 'start-of-week-tue';
				break;
			case 3:
				$classes[] = 'start-of-week-wed';
				break;
			case 4:
				$classes[] = 'start-of-week-thurs';
				break;
			case 5:
				$classes[] = 'start-of-week-fri';
				break;
			case 6:
				$classes[] = 'start-of-week-sat';
		}

		if ( is_active_sidebar( 'sidebar-1' ) && ( ! array_key_exists('foriframe', $_GET) || $_GET['foriframe'] != 1 ) ) {
			$classes[] = 'use-widget';
		}

		if ( has_nav_menu( 'toppage' ) ) {
			$classes[] = 'use-toppage-nav-menu';
		}

		if (array_key_exists('foriframe', $_GET) && $_GET['foriframe'] == 1) {
			$classes[] = 'foriframe';
		}

		$current_date_str = date_i18n( 'n:j:w' );
		$new_classes = explode( ':', $current_date_str );

		$new_classes[ 0 ] = 'month' . $new_classes[ 0 ];
		$new_classes[ 1 ] = 'day' . $new_classes[ 1 ];
		$new_classes[ 2 ] = 'week' . $new_classes[ 2 ];

		$classes = array_merge( $classes, $new_classes );

		$graftee_advanced_settings_disabled_use_title = get_theme_mod( 'graftee_advanced_settings_disabled_use_title', null );
		if ( !is_null( $graftee_advanced_settings_disabled_use_title ) && $graftee_advanced_settings_disabled_use_title === true ) {
			$classes[] = 'disabled-use-title';
		}

		if ( has_header_image() ) {
			$classes[] = 'use-header-image';

			if ( get_theme_mod( 'multiple_header_images' ) && count( get_uploaded_header_images() ) > 1 ) {
				$classes[] = 'use-header-image-animation';
			}
		}

		return $classes;
	}
	add_filter( 'body_class', 'graftee_body_class' );

	function graftee_nav_menu_link_attributes( $atts, $item, $args ) {
		$atts['itemprop']= 'url';

		return $atts;
	}
	add_filter( 'nav_menu_link_attributes', 'graftee_nav_menu_link_attributes', 10, 3 );

	function graftee_blogname() {
		$output = '';

		if ( function_exists( 'get_custom_logo' ) ) {
			$output .= get_custom_logo();
		}

		$graftee_site_title_img = get_theme_mod( 'graftee_site_title_img', null );
		if ( is_null( $graftee_site_title_img ) || $graftee_site_title_img == '' ) {
			if ( display_header_text() ) {
				$output .= get_bloginfo( 'name' );
			}
		} else {
			$output .= '<img src="' . $graftee_site_title_img . '" alt="' . get_bloginfo( 'name' ) . '">';
		}

		if ( $output != '' ) {
			$output = '<p>' . $output . '</p>';
		}

		echo apply_filters( 'graftee_blogname', $output );
	}

	function graftee_get_header_h1_text() {
		$result = '';

		if ( is_404() ) {
			$result = __( '404 Not Found', 'graftee' );
		} else if ( has_excerpt() ) {
			$result = get_the_excerpt();
		} else if ( is_single() || is_page() ) {
			$result = get_the_title();
		} else if ( is_tag() || is_category() || is_tax() ) {
			$term_description = term_description();
			if ( $term_description != '' ) {
				$result = $term_description;
			} else {
				$result = sprintf( __( "%sに関する記事", 'graftee' ), single_term_title( '', false ) );
			}
		} else if ( is_year() ) {
			$result = get_the_time( __( 'Y年', 'graftee' ) );
		} else if ( is_month() ) {
			$result = get_the_time( __( 'Y年F', 'graftee' ) );
		} else if ( is_day() ) {
			$result = get_the_time( __( 'Y年Fj日', 'graftee' ) );
		} else if ( is_search() ) {
			$result = sprintf( __( "%sに関する記事", 'graftee' ), get_search_query() );
		}

		if ( trim( $result ) == '' ) {
			// is_front_page() || is_home() || other
			$blog_description = get_bloginfo( 'description' );

			if ( $blog_description != '' ) {
				$result = $blog_description;
			} else {
				$result = get_bloginfo( 'name' );
			}
		}

		return strip_tags( $result );
	}

	function graftee_get_footer_html() {
		$graftee_advanced_settings_credit = get_theme_mod( 'graftee_advanced_settings_credit', null );
		if ( !is_null( $graftee_advanced_settings_credit ) && $graftee_advanced_settings_credit != '' ) {
			return '<p><small role="copyright">' . $graftee_advanced_settings_credit . '</small></p>';
		}

		$output = '';

		$output .= '<p>';
		$output .= '<small>' . get_bloginfo( 'name' ) . '</small>';
		$output .= '<small role="copyright">' . sprintf( 'Proudly powered by %s and %s', 'WordPress', get_stylesheet() ) . '</small>';
		$output .= '</p>';

		return apply_filters( 'graftee_get_footer_html', $output );
	}

	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function graftee_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'graftee_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'	 => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'	 => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'graftee_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so graftee_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so graftee_categorized_blog should return false.
			return false;
		}
	}

	function graftee_breadcrumb() {
		$is_show_breadcrumbs = 0;

		if ( ! is_null( get_theme_mod( 'graftee_advanced_settings_breadcrumbs', null ) ) ) {
			$is_show_breadcrumbs = get_theme_mod( 'graftee_advanced_settings_breadcrumbs' );
		}

		if ( $is_show_breadcrumbs ) {
			global $wp_query, $post, $page, $paged;

			$taxonomy_slug = get_query_var( 'taxonomy' );
			$cpt = get_query_var( 'post_type' );

			if ( !is_front_page() && !is_home() && !is_admin() ) : ?>
				<ol itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></li>

				<?php if ( $taxonomy_slug && is_tax( $taxonomy_slug ) ) :
					$query_tax = get_queried_object();
					$query_tax_parent = $query_tax -> parent;
					$post_types = get_taxonomy( $taxonomy_slug ) -> object_type;
					$cpt = $post_types[0];
				?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_post_type_archive_link( $cpt ); ?>"><?php echo esc_html( get_post_type_object( $cpt ) -> label ); ?></a></li>
				<?php if ( ! empty( $query_tax_parent ) ) :
					$ancestors = array_reverse( get_ancestors( $query_tax -> term_id, $query_tax -> taxonomy ) );
					foreach( $ancestors as $ancestor ) : ?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_term_link( $ancestor, $query_tax -> taxonomy ); ?>"><?php echo esc_html( get_term( $ancestor, $query_tax -> taxonomy ) -> name ); ?></a></li>
					<?php endforeach; endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php echo esc_html( $query_tax -> name ); ?>

				<?php elseif ( $cpt && is_singular( $cpt ) ) :
					$cpt_taxes = get_object_taxonomies( $cpt );

					if ( ! empty( $cpt_taxes ) ) :
						$taxonomy_name = $cpt_taxes[0];
						?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_post_type_archive_link( $cpt ); ?>"><?php echo esc_html( get_post_type_object( $cpt ) -> label ); ?></a></li>
						<?php
						$taxes = get_the_terms( $post -> ID, $taxonomy_name );
						$count = 0;

						if ( ! empty( $taxes ) ) {
							foreach( $taxes as $tax ) {
								$children = get_term_children( $tax -> term_id, $taxonomy_name ); 

								if ( $children ) {
									if ( $count < count( $children ) ) {
										$count = count( $children );
										$lot_children = $children;
										foreach( $lot_children as $child ) {
											if( is_object_in_term( $post -> ID, $taxonomy_name ) ) {
												$child_tax = get_term( $child, $taxonomy_name );
											}
										}
									}
								} else {
									$child_tax = $tax;
								}
							}
						}

						if( ! empty( $child_tax -> parent ) ) :
							$ancestors = array_reverse( get_ancestors( $child_tax -> term_id, $taxonomy_name ) );

							foreach( $ancestors as $ancestor ) : ?>
								<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_term_link( $ancestor, $taxonomy_name ); ?>"><?php echo esc_html( get_term( $ancestor, $taxonomy_name ) -> name ); ?></a></li>
							<?php endforeach; ?>

							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_term_link( $child_tax, $taxonomy_name ); ?>"><?php echo esc_html( $child_tax -> name ); ?></a></li>
						<?php endif; ?>
					<?php endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_title_attribute(); ?>

				<?php elseif ( is_page() ) : ?>
				<?php $ancestors = get_post_ancestors( $post -> ID ); ?>
				<?php foreach ( array_reverse( $ancestors ) as $ancestor ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_page_link( $ancestor ); ?>"><?php echo get_the_title( $ancestor ); ?></a></li>
				<?php endforeach; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_title_attribute(); ?>

				<?php elseif ( is_search() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php echo sprintf( graftee_get_public_word( 'search-result' ), get_search_query() ); ?>&nbsp;(&nbsp;<?php echo sprintf( graftee_get_public_word( 'n-posts' ), esc_html( $wp_query -> found_posts ) ); ?>)

				<?php elseif ( is_404() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php echo graftee_get_public_word( '404' ); ?>

				<?php elseif ( is_attachment() ) : ?>
				<?php if ( $post -> post_parent != 0 ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_permalink( $post -> post_parent ); ?>"><?php echo get_the_title( $post -> post_parent ); ?></a></li>
				<?php endif; ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_title_attribute(); ?>

				<?php elseif ( is_single() ) : ?>
				<?php
				$cat = get_the_category();
				if ( ! empty( $cat ) && count( $cat ) > 0 ) {
					$cat = $cat[0];

					$breadcrumbs = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'.get_category_parents( $cat->term_id, true, '</li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' ).'</li>';
					$breadcrumbs = str_replace( '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"></li>', '', $breadcrumbs );
					$breadcrumbs = str_replace( 'href=', 'itemprop="item url" href=', $breadcrumbs );
					echo $breadcrumbs;
				} ?>
				<?php $title_attribute = the_title_attribute( array( 'echo' => false ) ); ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php if ( trim( $title_attribute ) != '' ): ?>
					<?php echo $title_attribute; ?>
				<?php else: ?>
					<?php echo graftee_get_public_word( 'this-article' ); ?>
				<?php endif; ?>

				<?php elseif ( is_year() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_time( __( 'Y年', 'graftee' ) ); ?>

				<?php elseif ( is_month() || is_day() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_year_link( get_the_time( 'Y' ) ); ?>"><?php the_time( __( 'Y年', 'graftee' ) ); ?></a></li>

				<?php if ( is_month() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_time( __( 'F', 'graftee' ) ); ?>

				<?php elseif ( is_day() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item url" href="<?php echo get_year_link( get_the_time( 'm' ) ); ?>"><?php the_time( __( 'F', 'graftee' ) ); ?></a></li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php the_time( __( 'j日', 'graftee' ) ); ?>
				<?php endif; ?>

				<?php elseif ( is_category() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php single_cat_title(); ?>

				<?php elseif ( is_tag() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php single_cat_title(); ?>

				<?php elseif ( is_author() ) : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php
					if ( get_the_author_meta( 'display_name' ) ) {
						the_author_meta( 'display_name', $post -> post_author );
					} else {
						echo graftee_get_public_word( 'not-found2' );
					} ?>
				<?php else : ?>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?php echo wp_get_document_title(); ?>

				<?php endif;
				if ( $paged >= 2 || $page >= 2 ) {
					$page_num = sprintf( graftee_get_public_word( 'n-pages' ), max( $paged, $page ) );
					echo ' '.$page_num;
				} ?></li>
			</ol>
		<?php endif;
		}
	}

	function graftee_get_comments_url() {
		if (count($_GET) == 0) {
			return get_the_permalink() . '?foriframe=1';
		} else {
			return get_the_permalink() . '&foriframe=1';
		}
	}

	function graftee_document_title_parts( $title ) {

		$add_title = array();

		if ( is_singular() && array_key_exists('foriframe', $_GET) && $_GET['foriframe'] == 1 ) {
			$add_title[] = graftee_get_public_word( 'comment' );
		}

		$title = array_merge( $add_title, $title );

		return $title;
	}

	add_filter( 'document_title_parts', 'graftee_document_title_parts', 10, 1 );

	$disabled_stylecss = get_theme_mod( 'graftee_advanced_settings_disabled_stylecss', null );
	if ( ! is_null( $disabled_stylecss ) && $disabled_stylecss === true ) {
		function graftee_style_loader_tag( $tag ) {
			return str_replace( '/>', 'disabled />', $tag );
		}

		add_filter( 'style_loader_tag', 'graftee_style_loader_tag' );
	}

	$add_css = get_theme_mod( 'graftee_advanced_settings_add_css', null );
	if ( ! is_null( $add_css ) && $add_css != '' ) {
		function graftee_wp_head() {
			echo '<link rel="stylesheet" id="graftee-add-css" href="' . get_theme_mod( 'graftee_advanced_settings_add_css' ) . '">';
		}

		add_action( 'wp_head', 'graftee_wp_head', 10 );
	}
}
