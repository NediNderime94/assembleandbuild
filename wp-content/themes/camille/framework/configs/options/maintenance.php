<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Blog settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function camille_options_section_maintenance( $sections )
{
    $sections['maintenance'] = array(
        'name' => 'maintenance_panel',
        'title' => esc_html_x('Maintenance', 'admin-view', 'camille'),
        'icon' => 'fa fa-lock',
        'fields' => array(
            array(
                'id'        => 'enable_maintenance',
                'type'      => 'radio',
                'default'   => 'no',
                'class'     => 'la-radio-style',
                'title'     => esc_html_x('Enable Maintenance Mode', 'admin-view', 'camille'),
                'desc'      => esc_html_x('Turn on to make your website to be private', 'admin-view', 'camille'),
                'options'   => array(
                    'no'    => esc_html_x('No', 'admin-view', 'camille'),
                    'yes'   => esc_html_x('Yes', 'admin-view', 'camille')
                )
            ),
            array(
                'id'        => 'maintenance_page',
                'type'      => 'select',
                'title'     => esc_html_x('Maintenance Page', 'admin-view', 'camille'),
                'options'   => 'pages',
                'desc'      => esc_html_x('If you do not select a page, it will be redirected to the login page', 'admin-view', 'camille'),
                'query_args'    => array(
                    'posts_per_page'  => -1
                ),
                'default_option' => esc_html_x('Select a page', 'admin-view', 'camille'),
                'dependency'   => array( 'enable_maintenance_yes', '==', 'true' )
            )
        )
    );
    return $sections;
}