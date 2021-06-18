<?php
/**
 * LaStudio Discography register post type
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioDiscography/Admin
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$admin_skin = get_user_option('admin_color');

if ( $admin_skin == 'light' ) {
	$icon_url = LD_URI . '/assets/img/admin/vynil-dark.png';
}
else {
	$icon_url = LD_URI . '/assets/img/admin/vynil.png';
}

$labels = array(
	'name' => esc_html__( 'Releases', 'lastudio-discography' ),
	'singular_name' => esc_html__( 'Release', 'lastudio-discography' ),
	'add_new' => esc_html__( 'Add New', 'lastudio-discography' ),
	'add_new_item' => esc_html__( 'Add New Release', 'lastudio-discography' ),
	'all_items'  =>  esc_html__( 'All Releases', 'lastudio-discography' ),
	'edit_item' => esc_html__( 'Edit Release', 'lastudio-discography' ),
	'new_item' => esc_html__( 'New Release', 'lastudio-discography' ),
	'view_item' => esc_html__( 'View Release', 'lastudio-discography' ),
	'search_items' => esc_html__( 'Search Releases', 'lastudio-discography' ),
	'not_found' => esc_html__( 'No releases found', 'lastudio-discography' ),
	'not_found_in_trash' => esc_html__( 'No releases found in Trash', 'lastudio-discography' ),
	'parent_item_colon' => '',
	'menu_name' => esc_html__( 'Releases', 'lastudio-discography' ),
);

$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'release' ),
	'capability_type' => 'post',
	'has_archive' => false,
	'hierarchical' => false,
	'menu_position' => 5,
	'taxonomies' => array(),
	'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
	'exclude_from_search' => false,
	'menu_icon' => $icon_url
);

register_post_type( 'ld_release', $args );