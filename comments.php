<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package graftee
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<meta itemprop="commentCount" content="<?php echo get_comments_number(); ?>" />
			<?php echo sprintf( graftee_get_public_word( 'n-comments' ), number_format_i18n( get_comments_number() ) ); ?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'li',
					'short_ping' => true,
				) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<ul>
				<li class="nav-previous"><?php previous_comments_link( graftee_get_public_word( 'older-comments' ) ); ?></li>
				<li class="nav-next"><?php next_comments_link( graftee_get_public_word( 'newer-comments' ) ); ?></li>
			</ul>
		</nav>
		<?php endif; // check for comment navigation ?>
	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php echo graftee_get_public_word( 'close-comments' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'comment_field' => '<label for="comment">' . graftee_get_public_word( 'comment' ) . '*<textarea id="comment" name="comment" aria-required="true" required></textarea></label>',
		'fields' => array(
			'author' => '<label for="author">' . graftee_get_public_word( 'name' ) . '*<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . ( $req ? ' aria-required=\'true\' required' : '' ) . ' /></label>',
			'email' => '<label for="email">' . graftee_get_public_word( 'email' ) . '*<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . ( $req ? ' aria-required=\'true\' required' : '' ) . ' /></label>',
		)
	) ); ?>
</div>
