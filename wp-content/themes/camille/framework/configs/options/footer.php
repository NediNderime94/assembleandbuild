<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Footer settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function camille_options_section_footer( $sections )
{
    $sections['footer'] = array(
        'name'          => 'footer_panel',
        'title'         => esc_html_x('Footer', 'admin-view', 'camille'),
        'icon'          => 'fa fa-arrow-down',
        'sections' => array(
            array(
                'name'      => 'footer_layout_sections',
                'title'     => esc_html_x('Layout', 'admin-view', 'camille'),
                'icon'      => 'fa fa-cog fa-spin',
                'fields'    => array(
                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'image_select',
                        'default'   => '1col',
                        'title'     => esc_html_x('Footer Layout', 'admin-view', 'camille'),
                        'radio'     => true,
                        'options'   => Camille_Options::get_config_footer_layout_opts()
                    ),
                    array(
                        'id'        => 'footer_full_width',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('100% Footer Width', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on to have the footer area display at 100% width according to the window size. Turn off to follow site width.', 'admin-view', 'camille'),
                        'options'   => Camille_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'enable_footer_copyright',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'yes',
                        'title'     => esc_html_x('Enable Footer Copyright', 'admin-view', 'camille'),
                        'options'   => Camille_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'footer_copyright',
                        'type'      => 'code_editor',
                        'editor_setting'    => array(
                            'type' => 'text/html',
                            'codemirror' => array(
                                'indentUnit' => 2,
                                'tabSize' => 2
                            )
                        ),
                        'title'     => esc_html_x('Footer Copyright', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Paste your custom HTML code here.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'footer_styling_sections',
                'title'     => esc_html_x('Footer Styling', 'admin-view', 'camille'),
                'icon'      => 'fa fa-paint-brush',
                'fields'    => array(
                    array(
                        'id'        => 'footer_background',
                        'type'      => 'background',
                        'title'     => esc_html_x('Background', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_space',
                        'type'      => 'canvas',
                        'options'   => array(
                            'radius' => false
                        ),
                        'title'     => esc_html_x('Footer Space', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_text_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('text_color'),
                        'title'     => esc_html_x('Text Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_heading_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('heading_color'),
                        'title'     => esc_html_x('Heading Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_link_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('text_color'),
                        'title'     => esc_html_x('Link Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('primary_color'),
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'footer_copyright_sections',
                'title'     => esc_html_x('Footer Copyright Styling', 'admin-view', 'camille'),
                'icon'      => 'fa fa-paint-brush',
                'fields'    => array(
                    array(
                        'id'        => 'footer_copyright_background_color',
                        'type'      => 'color_picker',
                        'default'   => '#000',
                        'title'     => esc_html_x('Background Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_copyright_text_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Text Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_copyright_link_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Link Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'footer_copyright_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'camille')
                    )
                )
            )
        )
    );
    return $sections;
}