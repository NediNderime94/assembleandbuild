<?php
/**
 * LaStudio Playlist frontend functions
 *
 * General functions available on frontend
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Frontend
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue CSS
 *
 * @since LaStudio Playlist 1.0
 */
function lpm_enqueue_styles() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : LPM_VERSION;
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_register_style( 'lpm-app', LPM_CSS . '/lpm' . $suffix . '.css', array('wp-mediaelement'), $version );
}
add_action( 'wp_enqueue_scripts', 'lpm_enqueue_styles' );

/**
 * Enqueue JS
 *
 * @since LaStudio Playlist 1.0
 */
function lpm_enqueue_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : LPM_VERSION;
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '': '.min';
	wp_register_script( 'jquery-cue', LPM_JS . '/lib/jquery.cue' . $suffix . '.js', array( 'jquery', 'wp-mediaelement' ), '1.2.1', true );
	wp_register_script( 'lpm-mejs', LPM_JS . '/lpm-mejs' . $suffix . '.js', array( 'jquery-cue' ), $version, true );
	wp_register_script( 'lpm-app', LPM_JS . '/app' . $suffix . '.js', array( 'lpm-mejs' ), $version, true );

}
add_action( 'wp_enqueue_scripts', 'lpm_enqueue_scripts' );


/**
 * Get tracklist in array format from post
 *
 * @since LaStudio Playlist 1.0
 * @param object $post
 * @return array
 */
function get_lpm_playlist_tracks( $post_id ) {

	$tracks = array();
	$tracklist = get_post_meta( $post_id, '_lpm_tracklist', true );

	if ( is_array( $tracklist ) ) {
		foreach ( $tracklist as $attachment_id ) {

			if ( get_post_status( $post_id ) ) {
				$tracks[] = get_lpm_track_data( $attachment_id );
			}
		}
	}

	return apply_filters( 'lpm_playlist_tracks', $tracks, $post_id );
}

/**
 * Retrieve the default theme.
 *
 * Will be use for customizer option
 *
 * @return string
 */
function get_lpm_default_theme() {
	return lpm_get_option( 'theme', 'dark' );
}

/**
 * Display playlist
 *
 * Template tag to dipsplay the playlist
 *
 * @since LaStudio Playlist 1.0
 * @param object $post
 * @return array
 */
function lpm_playlist( $post_id, $args = array() ) {

	$post_id = absint( $post_id );

	if ( ! $post_id || ( 'lpm_playlist' !== get_post_type( $post_id ) && ! lpm_is_streaming_player( $post_id ) ) ) {
		return;
	}

	wp_enqueue_style('lpm-app');
	wp_enqueue_script('lpm-app');

	$tracks = get_lpm_playlist_tracks( $post_id );

	$args = wp_parse_args( $args, array(
		'post_id' => $post_id,
		'container' => true,
		'show_tracklist' => true,
		'player' => '',
		'theme' => get_lpm_default_theme(),
		'template' => '',
		'is_sticky_player' => false,
		'pause_other_players' => true,
		'el_class'	=> ''
	) );

	$classes   = array( 'lpm-playlist' );
	$classes[] = $args['show_tracklist'] ? '' : 'is-playlist-hidden';
	$classes[] = sprintf( 'lpm-theme-%s', sanitize_html_class( $args['theme'] ) );

	if ( has_post_thumbnail( $post_id ) ) {
		$classes[] = 'lpm-has-background';
	}

	if ( $args['is_sticky_player'] ) {
		$classes[] = 'lpm-sticky-playlist';
	} else {
		$classes[] = 'lpm-regular-playlist';
	}

	if(!empty($args['el_class'])){
		$classes[] = $args['el_class'];
	}

	$classes   = implode( ' ', array_filter( $classes ) );

	$container_class = 'lpm-playlist-container';

	// is sticky player
	if ( $args['is_sticky_player'] ) {
		$container_class .= ' lpm-sticky-playlist-container';
	}

	$args = apply_filters( 'lpm_playlist_args', $args, $post_id );

	echo '<div class="' . esc_attr( $container_class ) . '">';

	do_action( 'lpm_before_playlist', $post_id, $tracks, $args );

	include( LPM_DIR . '/templates/playlist.php' );

	do_action( 'lpm_after_playlist', $post_id, $tracks, $args );

	echo '</div>';
}

/**
 * Print playlist settings as a JSON script tag
 *
 * @since 1.1.5
 * @return  array
 */
function lpm_get_cue_features() {
	return array(
		'cuebackground',
		'cuehistory',
		'cueartwork',
		'cuecurrentdetails',
		'cueprevioustrack',
		'playpause',
		'cuenexttrack',
		'progress',
		'volume',
		'current',
		'duration',
		'cueplaylist',
		'cueplaylisttoggle'
	);
}

/**
 * Print playlist settings as a JSON script tag
 *
 * @since 1.0.0
 * @param int $post_id Post ID.
 * @param array   $tracks   List of tracks.
 * @param array   $args     Playlist arguments.
 */
function lpm_print_playlist_settings( $post_id, $tracks, $args ) {

	$settings = array();
	//$post_id = $post->ID;
	$tracks = get_lpm_playlist_tracks( $post_id );
	$formatted_tracks = lpm_format_tracks_for_script( $tracks );
	$theme = sanitize_title( $args['theme'] );
	$pause_other_players = boolval( $args['pause_other_players'] );

	// background from fetatured image
	$background = ( has_post_thumbnail( $post_id ) ) ? get_the_post_thumbnail_url( $post_id, 'medium' ) : '';
	$background = apply_filters( 'lpm_playlist_background', $background );

	$features = apply_filters( 'lpm_cue_features', lpm_get_cue_features(), $post_id );

	$settings = array(
		'skin' => 'lpm-theme-' . $theme,
		'tracks' => $formatted_tracks,
		'thumbnail' => $background,
		'pauseOtherPlayers' => $pause_other_players,
		'cueFeatures' => $features,
	);
	?>
	<script type="application/json" class="lpm-playlist-data"><?php echo wp_json_encode( $settings ); ?></script>
	<?php
}
add_filter( 'lpm_after_playlist', 'lpm_print_playlist_settings', 10, 3 );

/**
 * Format the tracks array to fit the script
 *
 * @since 1.0.0
 * @param array $tracks
 * @return array
 */
function lpm_format_tracks_for_script( $tracks ) {

	$formatted_tracks = array();

	if ( is_array( $tracks ) ) {

		$formatted_tracks = array();

		foreach( $tracks as $key => $track ) {

			if ( $track['artist'] ) {
				$formatted_tracks[ $key ][ 'meta' ]['artist'] = $track['artist'];
			}

			$formatted_tracks[ $key ]['src'] = $track['mp3'];

			if ( $track['artworkUrl'] ) {
				$formatted_tracks[ $key ]['thumb']['src'] = $track['artworkUrl'];
			}

			$formatted_tracks[ $key ]['title'] = $track['title'];
		}
	}

	return $formatted_tracks;
}

/**
 * Check if playlist is streaming player
 *
 * @since 1.1.5
 * @return bool
 */
function lpm_is_streaming_player( $post_id ) {
	return current_theme_supports( 'lpm_bar' ) && lpm_get_option( 'streaming_url' ) && 9999999 == $post_id;
}

/**
 * Output sticky player if theme allows it and a player is set
 *
 * @since 1.0.0
 */
function lpm_output_sticky_player() {

	// Check that the theme supports sticky player
	if ( false == current_theme_supports( 'lpm_bar' ) ) {
		return;
	}

	/*
	 * Disable sticky player if we're on a playlist single page and the playlist set as the sticky player is the current one.
	 * It avoids having the same playlist twice on the same page
	 */
	if ( is_singular( 'lpm_playlist' ) && get_the_ID() == get_option( '_lpm_bar' ) ) {
		return;
	}

	// If a playlist is set as sticky player
	if ( get_option( '_lpm_bar' ) ) {

		lpm_playlist(
			get_option( '_lpm_bar' ),
			array(
				'show_tracklist' => false,
				'is_sticky_player' => true,
			)
		);

	// If a streaming URL is set in the option
	} elseif ( lpm_get_option( 'streaming_url' ) ) {
		lpm_playlist(
			9999999, // arbitrary ID
			array(
				'show_tracklist' => false,
				'is_sticky_player' => true,
			)
		);
	}
}
add_action( 'lastudio_body_start', 'lpm_output_sticky_player' );

/**
 * Output sticky player holder to be sure to add space at the bottom
 *
 * @since 1.0.5
 * @deprecated for new themes
 */
function lpm_output_sticky_player_holder() {

	if ( current_theme_supports( 'lpm_bar' ) && ( get_option( '_lpm_bar' ) || lpm_get_option( 'streaming_url' ) ) ) {

		/*
		 * Disable sticky player if we're on a playlist single page and the playlist set as the sticky player is the current one.
		 * It avoids having the same playlist twice on the same page
		 */
		if ( is_singular( 'lpm_playlist' ) && get_the_ID() == get_option( '_lpm_bar' ) ) {
			return;
		}

		echo '<div class="lpm-bar-holder"></div>';
	}
}
add_action( 'lastudio_body_end', 'lpm_output_sticky_player_holder' );

/**
 * Overwrite sticky player tracklist to play audio streaming
 *
 * @since 1.1.5
 * @param array $tracklist
 * @param int $post_id
 * @return array $tracklist
 */
function lpm_stream( $tracklist, $post_id ) {

	if ( lpm_is_streaming_player( $post_id ) ) {

		$tracklist[0] = get_lpm_default_track();
		$tracklist[0]['audioUrl'] = esc_url( lpm_get_option( 'streaming_url' ) );
		$tracklist[0]['mp3'] = esc_url( lpm_get_option( 'streaming_url' ) );
		$tracklist[0]['artist'] = esc_attr( lpm_get_option( 'streaming_name' ) );
		$tracklist[0]['title'] = esc_attr( lpm_get_option( 'streaming_description' ) );

		// Get header image to use as artwork
		$data = get_object_vars( get_theme_mod( 'header_image_data' ) );

		// Now check to see if there is an id
		$attachment_id = is_array( $data ) && isset( $data['attachment_id'] ) ? $data['attachment_id'] : false;

		if ( $attachment_id ) {
			$image = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

			if ( is_array( $image ) && isset( $image[0] ) ) {
				$tracklist[0]['artworkUrl'] = $image[0];
			}
		}
	}

	return $tracklist;
}
add_filter( 'lpm_playlist_tracks', 'lpm_stream', 10, 2 );

/**
 * Overwrite player features to disable "cuehistory"
 *
 * By default, the player will try to continue to play where it stops.
 * It causes a glitch when a live stream is played
 * Prevent lag when reloading the page
 *
 * @since 1.1.5
 * @param array $features
 * @return array $features
 */
function lpm_streaming_cue_features( $features, $post_id ) {

	if ( lpm_is_streaming_player( $post_id ) ) {
		$features = array(
			'cuebackground',
			//'cuehistory',
			'cueartwork',
			'cuecurrentdetails',
			'cueprevioustrack',
			'playpause',
			'cuenexttrack',
			'progress',
			'current',
			'duration',
			'cueplaylist',
			'cueplaylisttoggle',
		);
	}

	return $features;
}
add_filter( 'lpm_cue_features', 'lpm_streaming_cue_features', 10, 2 );
