<?php
/**
 * LaStudio Events Shortcode.
 *
 * @class LE_Shortcode
 * @author LaStudio
 * @category Core
 * @package LaStudioPageBuilder/Shortcode
 * @version 1.0.0
 * @since 1.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LE_Shortcode class.
 */
class LE_Shortcode {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'lastudio_event_list', array( $this, 'shortcode' ) );
		add_shortcode( 'lastudio_events', array( $this, 'shortcode' ) );
	}

	/**
	 * Render shortcode
	 */
	public function shortcode( $atts = array() ) {
		$atts = shortcode_atts(
			array(
				'count' => -1,
				'timeline' => 'future',
				'link' => false,
				'artist' => false,
				'widget' => false,
				'el_class' => ''
			),
			$atts
		);

		$atts['count'] = intval( $atts['count'] );
		$atts['timeline'] = esc_attr( $atts['timeline'] );
		$atts['link'] = $this->shortcode_bool( $atts['link'] );
		$atts['artist'] = esc_attr( $atts['artist'] );
		$atts['widget'] = $this->shortcode_bool( $atts['widget'] );
		$atts['el_class'] = esc_attr( $atts['el_class'] );

		ob_start();
		lastudio_event_list( $atts );
		return ob_get_clean();
	}

	/**
	 * Helper method to determine if a shortcode attribute is true or false.
	 *
	 * @since 1.0.0
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	protected function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
	}
}

return new LE_Shortcode();