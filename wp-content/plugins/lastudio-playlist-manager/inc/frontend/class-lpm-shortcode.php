<?php
/**
 * LaStudio Playlist Shortcode.
 *
 * @class LPM_Shortcode
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Shortcode
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LPM_Shortcode class.
 */
class LPM_Shortcode {
	/**
	 * Constructor
	 */
	public function __construct() {

		add_shortcode( 'lastudio_playlist', array( $this, 'shortcode' ) );
	}

	/**
	 * Render shortcode
	 */
	public function shortcode( $atts = array() ) {
		$atts = shortcode_atts(
			array(
				'id' => 0, // playlist post ID
				'theme' => get_lpm_default_theme(),
				'show_tracklist' => true,
				'is_sticky_player' => false,
				'el_class'	=> ''
			),
			$atts
		);

		$id = absint( $atts['id'] );
		unset( $atts['id'] ); // remove ID from extratced attributes

		$atts['show_tracklist'] = $this->shortcode_bool( $atts['show_tracklist'] );

		ob_start();
		lpm_playlist( $id, $atts );
		return ob_get_clean();
	}

	/**
	 * Helper method to determine if a shortcode attribute is true or false.
	 *
	 * @since 1.0.2
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	protected function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
	}

} // end class

return new LPM_Shortcode();