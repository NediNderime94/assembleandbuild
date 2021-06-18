<?php
/**
 * LaStudio Discography register metaboxes
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$metabox = array(
	'Release Details' => array(
		'title' => esc_html__( 'Release Details', 'lastudio-discography' ),
		'page' => array( 'ld_release' ),
		'metafields' => array(


			array(
				'label'	=> esc_html__( 'Title', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_title',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Release date', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_date',
				'type'	=> 'datepicker',
			),

			array(
				'label'	=> esc_html__( 'Catalog Number', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_catalog_number',
				'type'	=> 'text',
			),

			array(
				'label'	=> esc_html__( 'Type', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_type',
				'desc'   =>esc_html__( 'You can choose to not display the format in the plugin setting.' ),
				'type'	=> 'select',
				'choices' => array(
					esc_html__( 'CD', 'lastudio-discography' ),
					esc_html__( 'Digital Download', 'lastudio-discography' ),
					esc_html__( 'DVD', 'lastudio-discography' ),
					esc_html__( 'Vinyl', 'lastudio-discography' ),
					esc_html__( 'Tape', 'lastudio-discography' ),
				),
			),

			array(
				'label'	=> esc_html__( 'iTunes', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_itunes',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Google Play', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_google_play',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Amazon', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_amazon',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Buy (any link where the release can be purchased)', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_buy',
				'type'	=> 'url',
			),

			array(
				'label'	=> esc_html__( 'Free Download link', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_free',
				'type'	=> 'url',
			),

			'tracklist' => array(
				'label'	=> esc_html__( 'Tracklist', 'lastudio-discography' ),
				'id'	=> '_lastudio_release_tracklist',
				'type'	=> 'repeatable',
			),
		)
	),
);

new LD_Admin_Metabox( apply_filters( 'lastudio_discography_metaboxes', $metabox ) );