<?php
/**
 * LaStudio Events register metaboxes
 *
 * Register metaboxes for event posts
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$metabox = array(

	'Event Details' => array(

		'title' => esc_html__( 'Event Details', 'lastudio-events' ),
		'page' => array( 'event' ),
		'metafields' => array(

			array(
				'label'	=> esc_html__( 'Date', 'lastudio-events' ),
				'id'	=> '_lastudio_event_start_date',
				'type'	=> 'datepicker',
				'description' => esc_html__( 'Formatted like "dd-mm-yyyy"', 'lastudio-events' )
			),

			array(
				'label'	=> esc_html__( 'End Date', 'lastudio-events' ),
				'id'	=> '_lastudio_event_end_date',
				'type'	=> 'datepicker',
			),

			array(
				'label'	=> esc_html__( 'Venue', 'lastudio-events' ),
				'id'	=> '_lastudio_event_venue',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Location', 'lastudio-events' ),
				'id'	=> '_lastudio_event_location',
				'type'	=> 'text',
				'description' => esc_html__( 'How you want to display the location name in the list (e.g: "Bruges, Belgium" or "	New Orleans, LA")', 'lastudio-events' ),
			),

			array(
				'label'	=> esc_html__( 'City', 'lastudio-events' ),
				'id'	=> '_lastudio_event_city',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Country', 'lastudio-events' ),
				'id'	=> '_lastudio_event_country',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Country - short ( e.g : GER for Germany )', 'lastudio-events' ),
				'id'	=> '_lastudio_event_country_short',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'State', 'lastudio-events' ),
				'id'	=> '_lastudio_event_state',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Time', 'lastudio-events' ),
				'id'	=> '_lastudio_event_time',
				'type'	=> 'text',
				'description'	=> esc_html__( 'e.g: 20:30 or 8:30PM', 'lastudio-events' ),
			),

			array(
				'label'	=> esc_html__( 'Postal address', 'lastudio-events' ),
				'id'	=> '_lastudio_event_address',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Zip', 'lastudio-events' ),
				'id'	=> '_lastudio_event_zip',
				'type'	=> 'text',
			),


			array(
				'label'	=> esc_html__( 'Phone', 'lastudio-events' ),
				'id'	=> '_lastudio_event_phone',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Contact Email', 'lastudio-events' ),
				'id'	=> '_lastudio_event_email',
				'type'	=> 'text',
			),
			array(
				'label'	=> esc_html__( 'Contact Website', 'lastudio-events' ),
				'id'	=> '_lastudio_event_website',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Google map embed code', 'lastudio-events' ),
				'desc'   => sprintf( __( '<a class="lastudio-help-img" href="%s" target="_blank">Where to find it?</a>', 'lastudio-events' ), LE_URI . '/assets/img/admin/google-map.jpg' ),
				'id'	=> '_lastudio_event_map',
				'type'	=> 'textarea_html',
			),

			array(
				'label'	=> esc_html__( 'Facebook event page', 'lastudio-events' ),
				'id'	=> '_lastudio_event_fb',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Buy Ticket link', 'lastudio-events' ),
				'id'	=> '_lastudio_event_ticket',
				'desc'   => 'http://www.example.com',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Price (e.g : $15)', 'lastudio-events' ),
				'id'	=> '_lastudio_event_price',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Free', 'lastudio-events' ),
				'id'	=> '_lastudio_event_free',
				'type'	=> 'checkbox',
			),

			array(
				'label'	=> esc_html__( 'Sold Out', 'lastudio-events' ),
				'id'	=> '_lastudio_event_soldout',
				'type'	=> 'checkbox',
			),

			array(
				'label'	=> esc_html__( 'Cancelled', 'lastudio-events' ),
				'id'	=> '_lastudio_event_cancel',
				'type'	=> 'checkbox',
			),
		)
	),
);

new LE_Admin_Metabox( $metabox );