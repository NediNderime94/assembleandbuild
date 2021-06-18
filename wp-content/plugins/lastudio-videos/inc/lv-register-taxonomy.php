<?php
/**
 * LaStudio Videos register taxonomy
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioVideos/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$labels = array(
	'name' => esc_html__( 'Videos Categories', 'lastudio-videos' ),
	'singular_name' => esc_html__( 'Videos Type', 'lastudio-videos' ),
	'search_items' => esc_html__( 'Search Videos Categories', 'lastudio-videos' ),
	'popular_items' => esc_html__( 'Popular Videos Categories', 'lastudio-videos' ),
	'all_items' => esc_html__( 'All Videos Categories', 'lastudio-videos' ),
	'parent_item' => esc_html__( 'Parent Videos Type', 'lastudio-videos' ),
	'parent_item_colon' => esc_html__( 'Parent Videos Type:', 'lastudio-videos' ),
	'edit_item' => esc_html__( 'Edit Videos Type', 'lastudio-videos' ),
	'update_item' => esc_html__( 'Update Videos Type', 'lastudio-videos' ),
	'add_new_item' => esc_html__( 'Add New Videos Type', 'lastudio-videos' ),
	'new_item_name' => esc_html__( 'New Videos Type', 'lastudio-videos' ),
	'separate_items_with_commas' => esc_html__( 'Separate videos categories with commas', 'lastudio-videos' ),
	'add_or_remove_items' => esc_html__( 'Add or remove videos categories', 'lastudio-videos' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used videos categories', 'lastudio-videos' ),
	'menu_name' => esc_html__( 'Categories', 'lastudio-videos' ),
);

$args = array(

	'labels' => $labels,
	'hierarchical' => true,
	'public' => true,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'video-type', 'with_front' => false ),
);

register_taxonomy( 'video_type', array( 'la_video' ), $args );

$labels = array(
	'name' => esc_html__( 'Tags', 'lastudio-videos' ),
	'singular_name' => esc_html__( 'Tag', 'lastudio-videos' ),
	'search_items' => esc_html__( 'Search Tags', 'lastudio-videos' ),
	'popular_items' => esc_html__( 'Popular Tags', 'lastudio-videos' ),
	'all_items' => esc_html__( 'All Tags', 'lastudio-videos' ),
	'parent_item' => esc_html__( 'Parent Tag', 'lastudio-videos' ),
	'parent_item_colon' => esc_html__( 'Parent Tag:', 'lastudio-videos' ),
	'edit_item' => esc_html__( 'Edit Tag', 'lastudio-videos' ),
	'update_item' => esc_html__( 'Update Tag', 'lastudio-videos' ),
	'add_new_item' => esc_html__( 'Add New Tag', 'lastudio-videos' ),
	'new_item_name' => esc_html__( 'New Tag', 'lastudio-videos' ),
	'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'lastudio-videos' ),
	'add_or_remove_items' => esc_html__( 'Add or remove tags', 'lastudio-videos' ),
	'choose_from_most_used' => esc_html__( 'Choose from the most used tags', 'lastudio-videos' ),
	'menu_name' => esc_html__( 'Tags', 'lastudio-videos' ),
);

$args = array(
	'hierarchical' => false,
	'labels' => $labels,
	'show_ui' => true,
	'update_count_callback' => '_update_post_term_count',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'video-tag', 'with_front' => false),
);

register_taxonomy( 'video_tag', array( 'la_video' ), $args );