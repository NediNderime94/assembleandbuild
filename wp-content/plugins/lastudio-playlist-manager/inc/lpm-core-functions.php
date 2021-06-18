<?php
/**
 * LaStudio Playlist core functions
 *
 * General core functions available on admin and frontend
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hack for old php versions to use boolval()
if ( ! function_exists( 'boolval' ) ) {
	function boolval( $val ) {
		return (bool) $val;
	}
}

/**
 * Return a markup of track for the admin from the file ids list
 *
 * @since 1.0.0
 */
function lpm_get_track_markup( $tracklist ) {

	if ( ! $tracklist ) {
		return;
	}

	if ( is_array( $tracklist ) ) {
		$tracks = $tracklist;
	} else {
		$tracks = lpm_list_to_array( $tracklist );
	}

	// var_dump($tracks);

	foreach ( $tracks as $attachment_id ) :

		$id = $attachment_id;
		$track = get_lpm_track_data( $id );
		$has_artwork = $track['artworkUrl'];
		$artwork_bg = ( $has_artwork ) ? 'background-image:url( ' . esc_url( $track['artworkUrl'] ) . ' );' : '';

		// var_dump( $track );
	?>
	<div class="lpm-track-container lpm-track-item" data-track-id="<?php echo absint( $id ); ?>">
		<div class="lpm-track menu-item-bar">
			<div class="menu-item-handle">
				<span class="item-title">
					<span class="menu-item-title lpm-track-title-label"><?php echo $track['title']; ?></span>
				</span>
				<span class="item-controls">
					<span class="item-order">
						<span class="lpm-toggle"><span>
					</span>
				</span>

			</div>
		</div><!-- .lpm-track -->
		<div class="lpm-track-content">
			<div class="lpm-track-loader"></div>
			<div class="lpm-track-column-group">
				<div class="lpm-track-column lpm-track-column-artwork">
					<input type="hidden" data-track-id="<?php echo absint( $id ); ?>" value="<?php echo absint( $track['artworkId'] ); ?>">
					<span style="<?php echo lpm_esc_style_attr( $artwork_bg ); ?>" class="lpm-track-artwork <?php echo ( $has_artwork ) ? 'lpm-track-has-artwork' : ''; ?>"></span>

					<a style="<?php echo ( $has_artwork ) ? 'display:inline-block;' : '' ;?>" data-track-id="<?php echo absint( $id ); ?>" class="lpm-remove-artwork"><?php esc_html_e( 'Remove artwork', 'lastudio-playlist-manager' ); ?></a>
				</div><!-- .lpm-track-column-artwork -->

				<div class="lpm-track-column">
					<p>
						<label>
							<?php esc_html_e( 'Title', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-title regular-text" type="text" name="artist" placeholder="<?php esc_html_e( 'Title', 'lastudio-playlist-manager' ); ?>" value="<?php echo esc_attr( $track['title'] ); ?>">
						</label>
					</p>
					<p>
						<label>
							<?php esc_html_e( 'Artist', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-artist regular-text" type="text" name="track" placeholder="<?php esc_html_e( 'Artist', 'lastudio-playlist-manager' ); ?>" value="<?php echo esc_attr( $track['artist'] ); ?>">
						</label>
					</p>
					<p>
						<label>
							<?php esc_html_e( 'Lenght', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-length regular-text" type="text" name="track" placeholder="00:00" value="<?php echo esc_attr( $track['length'] ); ?>">
						</label>
					</p>
					<?php if ( class_exists( 'WooCommerce' ) ) :

						if ( class_exists( 'WooCommerce' ) ) {
						$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

						$product_options = array();
						if ( $product_posts ) {
							$products[ esc_html__( 'Not linked', 'lastudio-playlist-manager' ) ] = '';
							foreach ( $product_posts as $product ) {
								$product_options[ $product->ID ] = $product->post_title;
							}
						} else {
							$product_options[ esc_html__( 'No product yet', 'lastudio-playlist-manager' ) ] = 0;
						}
					}
					?>
						<p>
							<label>
								<?php esc_html_e( 'WooCommerce Product ID', 'lastudio-playlist-manager' ); ?>:<br>
								<select style="width:100%;" class="lpm-track-wc_product_id" name="wc_product_id">
									<option value=""><?php esc_html_e( 'None', 'lastudio-playlist-manager' ); ?></option>
								<?php foreach ( $product_options as $id => $title ) : ?>
									<option <?php selected( $id, $track['wcProductId'] ); ?> value="<?php echo absint( $id ) ?>"><?php echo esc_attr( $title ); ?></option>
								<?php endforeach; ?>
								</select>
							</label>
						</p>
					<?php endif; ?>
				</div><!-- .lpm-track-column -->

				<div class="lpm-track-column">
					<p>
						<label>
							<?php esc_html_e( 'iTunes', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-itunes_url regular-text" type="text" name="itunes" placeholder="http://" value="<?php echo esc_url( $track['itunesUrl'] ); ?>">
						</label>
					</p>

					<p>
						<label>
							<?php esc_html_e( 'amazon', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-amazon_url regular-text" type="text" name="amazon" placeholder="http://" value="<?php echo esc_url( $track['amazonUrl'] ); ?>">
						</label>
					</p>

					<p>
						<label>
							<?php esc_html_e( 'googleplay', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-googleplay_url regular-text" type="text" name="googleplay" placeholder="http://" value="<?php echo esc_url( $track['googleplayUrl'] ); ?>">
						</label>
					</p>

					<p>
						<label>
							<?php esc_html_e( 'Other buy URL', 'lastudio-playlist-manager' ); ?>:<br>
							<input class="lpm-track-buy_url regular-text" type="text" name="buy_url" placeholder="http://" value="<?php echo esc_url( $track['buyUrl'] ); ?>">
						</label>
					</p>

				</div><!-- .lpm-track-column -->
			</div><!-- .lpm-track-column-group -->
			<div class="lpm-track-actions">
				<a class="lpm-track-remove"><?php esc_html_e( 'Remove', 'lastudio-playlist-manager' ); ?></a> |
				<a class="lpm-toggle"><?php esc_html_e( 'Close', 'lastudio-playlist-manager' ); ?></a>
			</div>
		</div><!-- .lpm-track-content -->
	</div><!-- .lpm-track-container -->
	<?php endforeach;
}

/**
 * Retreve all track infos and data as an nice array:
 *
 * @since 1.0.0
 * @param int $post_id
 * @return array
 */
function get_lpm_track_data( $post_id ) {

	$track = get_lpm_default_track(); // set default track args

	$post = get_post( $post_id );

	if(is_wp_error($post) || empty($post)){
		return lpm_sanitize_track($track);
	}

	$meta = wp_get_attachment_metadata( $post_id );

	$title = ( $post->post_title ) ? $post->post_title : $post->post_name;
	$file_url = $post->guid;
	$artwork_id = absint( get_post_meta( $post_id, '_lpm_track_artwork', true ) );
	$artwork_url = esc_url( lpm_get_url_from_attachment_id( $artwork_id, 'thumbnail' ) );

	// buy URL
	$itunes_url = esc_url( get_post_meta( $post_id, '_lpm_track_itunes_url', true ) );
	$amazon_url = esc_url( get_post_meta( $post_id, '_lpm_track_amazon_url', true ) );
	$googleplay_url = esc_url( get_post_meta( $post_id, '_lpm_track_googleplay_url', true ) );
	$buy_url = esc_url( get_post_meta( $post_id, '_lpm_track_buy_url', true ) );
	$wc_product_id = absint( get_post_meta( $post_id, '_lpm_track_wc_product_id', true ) );

	$track['artist'] = ( isset( $meta['artist'] ) ) ? $meta['artist'] : '';
	$track['title'] = $title;
	$track['length'] = ( isset( $meta['length_formatted'] ) ) ? $meta['length_formatted'] : '';
	$track['format'] = ( isset( $meta['fileformat'] ) ) ? $meta['fileformat'] : '';
	$track['audioId'] = $post_id;
	$track['audioUrl'] = $file_url;
	$track['mp3'] = $file_url;
	$track['artworkId'] = $artwork_id;
	$track['artworkUrl'] = $artwork_url;
	$track['itunesUrl'] = $itunes_url;
	$track['amazonUrl'] = $amazon_url;
	$track['googleplayUrl'] = $googleplay_url;
	$track['buyUrl'] = $buy_url;
	$track['wcProductId'] = $wc_product_id;

	// var_dump( $track );

	return lpm_sanitize_track( $track );
}

/**
 * Retrieve a default track.
 *
 * Useful for whitelisting allowed keys.
 *
 * @since 1.0.0
 * @return array
 */
function get_lpm_default_track() {
	$args = array(
		'artist'     => '',
		'artworkId'  => '',
		'artworkUrl' => '',
		'audioId'    => '',
		'audioUrl'   => '',
		'length'     => '',
		'format'     => '',
		'order'      => '',
		'mp3'		 => '',
		'title'      => '',
		'itunesUrl' => '',
		'amazonUrl' => '',
		'googleplayUrl' => '',
		'buyUrl' => '',
		'wcProductId' => '',
	);

	return apply_filters( 'lpm_default_track_properties', $args );
}

/**
 * Sanitize track arguments array
 *
 * @since 1.0.0
 * @param array $track Track data.
 * @return array
 */
function lpm_sanitize_track( $track ) {

	// Sanitize valid properties.
	$track['artist']     = sanitize_text_field( $track['artist'] );
	$track['artworkId']  = absint( $track['artworkId'] );
	$track['artworkUrl'] = esc_url_raw( $track['artworkUrl'] );
	$track['audioId']    = absint( $track['audioId'] );
	$track['audioUrl']   = esc_url_raw( $track['audioUrl'] );
	$track['length']     = sanitize_text_field( $track['length'] );
	$track['format']     = sanitize_text_field( $track['format'] );
	$track['title']      = sanitize_text_field( $track['title'] );
	$track['order']      = absint( $track['order'] );

	return apply_filters( 'lpm_sanitize_track', $track );
}

/**
 * Sanitize html style attribute
 *
 * @since 1.0.0
 * @param string $style
 * @return string
 */
function lpm_esc_style_attr( $style ) {
	return esc_attr( trim( lpm_clean_spaces( $style ) ) );
}

/**
 * Convert list of IDs to array
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function lpm_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( $separator, trim( lpm_clean_spaces( lpm_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @since 1.0.0
 * @param string $list
 * @return array
 */
function lpm_array_to_list( $array ) {

	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( ',',  $array ), ',' );
	}

	return lpm_clean_list( $list );
}

/**
 * Clean list of numbers
 *
 * Used to clean the list of IDs
 *
 * @since 1.0.0
 * @param string $list
 * @return string
 */
function lpm_clean_list( $list ) {
	$list = lpm_clean_spaces( trim( rtrim( $list, ',' ) ) );
	$list = preg_replace( "/[^0-9,]/", '', $list );
	return $list;
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @since 1.0.0
 * @param string $css
 * @return string
 */
function lpm_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Get the URL of an attachment from its id
 *
 * @since 1.0.0
 * @param int $id
 * @param string $size
 * @return string
 */
function lpm_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {
	if ( is_numeric( $id ) ) {
		$src = wp_get_attachment_image_src( absint( $id ), $size );

		if ( isset( $src[0] ) ) {
			return esc_url( $src[0] );
		}
	}
}

/**
 * Get options
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function lpm_get_option( $key, $default = null ) {

	$lpm_settings = get_option( 'lastudio_playlist_manager_settings' );

	if ( isset( $lpm_settings[ $key ] ) && '' != $lpm_settings[ $key ] ) {

		return $lpm_settings[ $key ];

	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Get current page URL
 */
function lpm_get_current_url() {
	global $wp;
	return esc_url( home_url( add_query_arg( array(),$wp->request ) ) );
}

/**
 * Add to cart tag
 *
 * @param int $product_id
 * @param string $text link text content
 * @param string $class button class
 * @return string
 */
function lpm_add_to_cart( $product_id, $classes = '', $text = '' ) {

	$wc_url = untrailingslashit( lpm_get_current_url() ) . '/?add-to-cart=' . absint( $product_id );

	$classes .= ' product_type_simple add_to_cart_button ajax_add_to_cart';

	return '<a
		href="' . esc_url( $wc_url ) . '"
		rel="nofollow"
		data-quantity="1" data-product_id="' . absint( $product_id ) . '"
		class="' . esc_attr( $classes ) . '">' . $text . '</a>';
}