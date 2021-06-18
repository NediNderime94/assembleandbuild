<?php
/**
 * LaStudio Playlist register post type
 *
 * Register playlist post type
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$labels = array(
	'name' => esc_html__( 'Playlists', 'lastudio-playlist-manager' ),
	'singular_name' => esc_html__( 'Playlist', 'lastudio-playlist-manager' ),
	'add_new' => esc_html__( 'Add New', 'lastudio-playlist-manager' ),
	'add_new_item' => esc_html__( 'Add New Playlist', 'lastudio-playlist-manager' ),
	'all_items'  => esc_html__( 'All Playlists', 'lastudio-playlist-manager' ),
	'edit_item' => esc_html__( 'Edit Playlist', 'lastudio-playlist-manager' ),
	'new_item' => esc_html__( 'New Playlist', 'lastudio-playlist-manager' ),
	'view_item' => esc_html__( 'View Playlist', 'lastudio-playlist-manager' ),
	'search_items' => esc_html__( 'Search Playlists', 'lastudio-playlist-manager' ),
	'not_found' => esc_html__( 'No playlist found', 'lastudio-playlist-manager' ),
	'not_found_in_trash' => esc_html__( 'No playlist found in Trash', 'lastudio-playlist-manager' ),
	'parent_item_colon' => '',
	'menu_name' => esc_html__( 'Playlists', 'lastudio-playlist-manager' ),
);

$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'playlist' ),
	'capability_type' => 'post',
	'has_archive' => false,
	'hierarchical' => false,
	'menu_position' => 5,
	'taxonomies' => array(),
	'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
	'exclude_from_search' => false,
	'menu_icon' => 'dashicons-playlist-audio',
);

register_post_type( 'lpm_playlist', $args );