<?php
/**
 * LaStudio Discography register taxonomy
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$labels = array(
	'name' => esc_html__( 'Artists', 'lastudio-discography' ),
	'singular_name' => esc_html__( 'Artist', 'lastudio-discography' ),
	'search_items' => esc_html__( 'Search Artists', 'lastudio-discography' ),
	'popular_items' => esc_html__( 'Popular Artists', 'lastudio-discography' ),
	'all_items' => esc_html__( 'All Artists', 'lastudio-discography' ),
	'parent_item' => esc_html__( 'Parent Artist', 'lastudio-discography' ),
	'parent_item_colon' => esc_html__( 'Parent Artist:', 'lastudio-discography' ),
	'edit_item' => esc_html__( 'Edit Artist', 'lastudio-discography' ),
	'update_item' => esc_html__( 'Update Artist', 'lastudio-discography' ),
	'add_new_item' => esc_html__( 'Add New Artist', 'lastudio-discography' ),
	'new_item_name' => esc_html__( 'New Artist', 'lastudio-discography' ),
	'separate_items_with_commas' => esc_html__( 'Separate artists with commas', 'lastudio-discography' ),
	'add_or_remove_items' => esc_html__( 'Add or remove artists', 'lastudio-discography' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used artists', 'lastudio-discography' ),
	'not_found' => esc_html__( 'No artists found', 'lastudio-discography' ),
	'menu_name' => esc_html__( 'Artists', 'lastudio-discography' ),
);

$args = array(
	'labels' => $labels,
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'update_count_callback' => '_update_post_term_count',
	'rewrite' => array( 'slug' => 'band', 'with_front' => false),
);

register_taxonomy( 'ld_band', array( 'ld_release' ), $args );

$labels = array(
	'name' => esc_html__( 'Labels', 'lastudio-discography' ),
	'singular_name' => esc_html__( 'Label', 'lastudio-discography' ),
	'search_items' => esc_html__( 'Search Labels', 'lastudio-discography' ),
	'popular_items' => esc_html__( 'Popular Labels', 'lastudio-discography' ),
	'all_items' => esc_html__( 'All Labels', 'lastudio-discography' ),
	'parent_item' => esc_html__( 'Parent Label', 'lastudio-discography' ),
	'parent_item_colon' => esc_html__( 'Parent Label:', 'lastudio-discography' ),
	'edit_item' => esc_html__( 'Edit Label', 'lastudio-discography' ),
	'update_item' => esc_html__( 'Update Label', 'lastudio-discography' ),
	'add_new_item' => esc_html__( 'Add New Label', 'lastudio-discography' ),
	'new_item_name' => esc_html__( 'New Label', 'lastudio-discography' ),
	'separate_items_with_commas' => esc_html__( 'Separate labels with commas', 'lastudio-discography' ),
	'add_or_remove_items' => esc_html__( 'Add or remove labels', 'lastudio-discography' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used labels', 'lastudio-discography' ),
	'menu_name' => esc_html__( 'Labels', 'lastudio-discography' ),
);

$args = array(
	'labels' => $labels,
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'update_count_callback' => '_update_post_term_count',
	'rewrite' => array( 'slug' => 'label', 'with_front' => false),
);

register_taxonomy( 'ld_label', array( 'ld_release' ), $args );