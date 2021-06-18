<?php
/**
 * LaStudio Videos register post type
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
	'name' => esc_html__( 'Videos', 'lastudio-videos' ),
	'singular_name' => esc_html__( 'Video', 'lastudio-videos' ),
	'add_new' => esc_html__( 'Add New', 'lastudio-videos' ),
	'add_new_item' => esc_html__( 'Add New Video', 'lastudio-videos' ),
	'all_items'  => esc_html__( 'All Videos', 'lastudio-videos' ),
	'edit_item' => esc_html__( 'Edit Video', 'lastudio-videos' ),
	'new_item' => esc_html__( 'New Video', 'lastudio-videos' ),
	'view_item' => esc_html__( 'View Video', 'lastudio-videos' ),
	'search_items' => esc_html__( 'Search Videos', 'lastudio-videos' ),
	'not_found' => esc_html__( 'No Videos found', 'lastudio-videos' ),
	'not_found_in_trash' => esc_html__( 'No Videos found in Trash', 'lastudio-videos' ),
	'parent_item_colon' => '',
	'menu_name' => esc_html__( 'Videos', 'lastudio-videos' ),
);

$args = array(

	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'video' ),
	'capability_type' => 'post',
	'has_archive' => false,
	'hierarchical' => false,
	'menu_position' => 5,
	'taxonomies' => array(),
	'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'comments' ),
	'exclude_from_search' => false,

	'description' => esc_html__( 'Present your video', 'lastudio-videos' ),
	'menu_icon' => 'dashicons-format-video',
);

register_post_type( 'la_video', $args );