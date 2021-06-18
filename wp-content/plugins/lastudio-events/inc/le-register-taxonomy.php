<?php
/**
 * LaStudio Events register taxonomy
 *
 * Register event taxonomy
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$labels = array(
	'name' => esc_html__( 'Artists', 'lastudio-events' ),
	'singular_name' => esc_html__( 'Artist', 'lastudio-events' ),
	'search_items' => esc_html__( 'Search Artists', 'lastudio-events' ),
	'popular_items' => esc_html__( 'Popular Artists', 'lastudio-events' ),
	'all_items' => esc_html__( 'All Artists', 'lastudio-events' ),
	'parent_item' => esc_html__( 'Parent Artist', 'lastudio-events' ),
	'parent_item_colon' => esc_html__( 'Parent Artist:', 'lastudio-events' ),
	'edit_item' => esc_html__( 'Edit Artist', 'lastudio-events' ),
	'update_item' => esc_html__( 'Update Artist', 'lastudio-events' ),
	'add_new_item' => esc_html__( 'Add New Artist', 'lastudio-events' ),
	'new_item_name' => esc_html__( 'New Artist', 'lastudio-events' ),
	'separate_items_with_commas' => esc_html__( 'Separate artists with commas', 'lastudio-events' ),
	'add_or_remove_items' => esc_html__( 'Add or remove artists', 'lastudio-events' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used artists', 'lastudio-events' ),
	'not_found' => esc_html__( 'No artists found', 'lastudio-events' ),
	'menu_name' => esc_html__( 'Artists', 'lastudio-events' ),
);

$args = array(
	'labels' => $labels,
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'update_count_callback' => '_update_post_term_count',
	'rewrite' => array( 'slug' => 'event-artist', 'with_front' => false),
);

register_taxonomy( 'le_artist', array( 'event' ), $args );