<?php
/**
 * Hooks and functions for blog and other content types
 *
 * @package Deux
 */


/**
 * Change more string at the end of the excerpt
 *
 * @since  1.0
 *
 * @param string $more
 *
 * @return string
 */
function deux_excerpt_more( $more ) {
	return $more && is_admin() ? $more : '&hellip;';
}

add_filter( 'excerpt_more', 'deux_excerpt_more' );

/**
 * Change length of the excerpt
 *
 * @since  1.0
 *
 * @param string $length
 *
 * @return string
 */
function deux_excerpt_length( $length ) {

	if ( is_admin() ) {
        return $length;
    }

	$excerpt_length = absint( deux_get_option( 'excerpt_length' ) );

	if ( $excerpt_length > 0 ) {
		return $excerpt_length;
	}

	return $length;
}

add_filter( 'excerpt_length', 'deux_excerpt_length' );

/**
 * Print HTML for single post header
 */
function deux_single_post_header() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$post_id = get_queried_object_id();
	$post_author_id = get_post_field( 'post_author', $post_id );

 	if (deux_get_option( 'single_post_layout' )): 
 		$imgUrl = get_the_post_thumbnail_url( get_the_ID() , 'full');

 		?>
		<div class="background-image" style="background-image: url(<?php echo esc_url($imgUrl)?>);">
			<div class="single-overlay"></div>
			<div class="entry-header">
				<div class="entry-meta">
					<?php deux_entry_meta(); ?>
				</div>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</div>

	<?php else: ?>
		<div class="entry-header row">
			<div class="entry-meta-container col-md-10 col-md-offset-1">

				<div class="entry-author-image">
					<?php
					printf(
						'<a class="vcard" href="%1$s">%2$s</a>',
						esc_url( get_author_posts_url( $post_author_id ) ),
						get_avatar( get_the_author_meta( $post_author_id ), 40 )
					);
					?>
				</div>
				<div class="entry-author-meta">
					<div class="entry-meta">
							<?php
							printf(
								esc_html__( '%s', 'deux' ),
								sprintf(
									'<span class="author-meta-name"><a class="vcard fn" href="%1$s">%2$s</a></span>',
									esc_url( get_author_posts_url( $post_author_id )),
									esc_html( get_the_author_meta( 'display_name' , $post_author_id) )
								)
							);
							?>
						<?php deux_entry_meta();?>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>

			<div class="col-md-10 col-md-offset-1 text-left">
				<?php the_title( '<h1 class="entry-title">', '</h1>' );?>
			</div>

			<div class="entry-excerpt-container intro lead col-md-10 col-md-offset-1 text-left">
				<?php the_excerpt(); ?>
			</div>
			<div class="clearfix"></div>
			<div class="entry-thumbnail">
				<?php deux_entry_thumbnail( 'full' );?>
			</div><!-- .entry-meta -->

			 
		</div>
	<?php endif ?>

	<?php
}

add_action( 'deux_content_before', 'deux_single_post_header' );

/**
 * Hooks search form
 * @param  string $form
 * @return string
 */
function deux_search_form( $form ) {
	$form = '
		<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '" >
		<div class="search-fields">
			<label class="screen-reader-text">' . esc_attr_x( 'Search for:', 'label', 'deux' ) . '</label>
			<input type="text" value="' . trim( get_search_query() ) . '" name="s" class="field" placeholder="'. esc_attr_x( 'Search', 'label', 'deux' ) .'"/>
			<button type="submit" class="search-submit">'.
				deux_get_svg_icon_html( 'search' )
			.'</button>
		</div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'deux_search_form' );