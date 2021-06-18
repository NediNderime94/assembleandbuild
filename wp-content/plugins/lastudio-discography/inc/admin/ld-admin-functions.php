<?php
/**
 * LaStudio Discography admin functions
 *
 * Functions available on admin
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display archive page state
 *
 * @param array $states
 * @param object $post
 * @return array $states
 */
function ld_custom_post_states( $states, $post ) { 

	if ( 'page' == get_post_type( $post->ID ) && absint( $post->ID ) === lastudio_discography_get_page_id() ) {

		$states[] = esc_html__( 'Discography Page' );
	} 

	return $states;
}
add_filter( 'display_post_states', 'ld_custom_post_states', 10, 2 );