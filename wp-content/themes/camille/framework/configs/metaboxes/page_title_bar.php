<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Page title bar settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function camille_metaboxes_section_page_title_bar( $sections ) {

    $sections['page_title_bar'] = array(
        'name'          => 'page_title_bar_panel',
        'title'         => esc_html_x('Page Title Bar', 'admin-view', 'camille'),
        'icon'          => 'laicon-page_title',
        'fields'        => array(
            array(
                'id'            => 'page_title_bar_layout',
                'type'          => 'select',
                'class'         => 'chosen',
                'title'         => esc_html_x('Select Layout', 'admin-view', 'camille'),
                'desc'          => esc_html_x('Choose to show or hide the page title bar.', 'admin-view', 'camille'),
                'options'       => Camille_Options::get_config_page_title_bar_opts(false,true)
            ),
            array(
                'id'            => 'hide_breadcrumb',
                'type'          => 'radio',
                'default'       => 'no',
                'class'         => 'la-radio-style',
                'title'         => esc_html_x('Hide Breadcrumbs', 'admin-view', 'camille'),
                'options'       => Camille_Options::get_config_radio_opts(false),
                'dependency'    => array( 'page_title_bar_layout', '!=', 'hide' )
            ),
            array(
                'id'            => 'enable_page_title_subtext',
                'type'          => 'radio',
                'default'       => 'no',
                'class'         => 'la-radio-style',
                'title'         => esc_html_x('Replace breadcrumb by custom text', 'admin-view', 'camille'),
                'options'       => Camille_Options::get_config_radio_opts(false),
                'dependency'    => array( 'page_title_bar_layout|hide_breadcrumb_no', '!=|==', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_custom_subtext',
                'type'          => 'text',
                'title'         => esc_html_x('Custom Text', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|hide_breadcrumb_no|enable_page_title_subtext_yes', '!=|==|==', 'hide|true|true' )
            ),
            array(
                'id'            => 'hide_page_title',
                'type'          => 'radio',
                'default'       => 'no',
                'class'         => 'la-radio-style',
                'title'         => esc_html_x('Hide Page Title', 'admin-view', 'camille'),
                'options'       => Camille_Options::get_config_radio_opts(false),
                'dependency'    => array( 'page_title_bar_layout', '!=', 'hide' )
            ),
            array(
                'id'            => 'page_title_custom',
                'type'          => 'text',
                'title'         => esc_html_x('Page Title Bar Custom','admin-view', 'camille'),
                'dependency'    => array( 'hide_page_title_no|page_title_bar_layout', '==|!=', 'true|hide' ),
            ),
            array(
                'id'            => 'page_title_font_size',
                'type'          => 'responsive',
                'title'         => esc_html_x('Page Title Font Size', 'admin-view', 'camille'),
                'desc'          => esc_html_x('Enter the font size (e.g: 20px )', 'admin-view', 'camille'),
                'dependency'    => array( 'hide_page_title_no|page_title_bar_layout', '==|!=', 'true|hide' ),
            ),
            array(
                'id'            => 'page_title_bar_style',
                'type'          => 'radio',
                'default'       => 'no',
                'class'         => 'la-radio-style',
                'title'         => esc_html_x('Enable Custom Style', 'admin-view', 'camille'),
                'options'       => Camille_Options::get_config_radio_opts(false),
                'dependency'    => array( 'page_title_bar_layout', '!=', 'hide' )
            ),

            array(
                'id'            => 'page_title_bar_background',
                'type'          => 'background',
                'title'         => esc_html_x('Background', 'admin-view', 'camille'),
                'desc'          => esc_html_x('For page title bar', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_bar_heading_color',
                'type'          => 'color_picker',
                'default'       => '',
                'title'         => esc_html_x('Heading Color', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_bar_text_color',
                'type'          => 'color_picker',
                'default'       => '',
                'title'         => esc_html_x('Text Color', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_bar_link_color',
                'type'          => 'color_picker',
                'default'       => '',
                'title'         => esc_html_x('Link Color', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_bar_link_hover_color',
                'type'          => 'color_picker',
                'default'       => '',
                'title'         => esc_html_x('Link Hover Color', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' )
            ),
            array(
                'id'            => 'page_title_bar_spacing',
                'type'          => 'spacing',
                'title'         => esc_html_x('Spacing', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' ),
                'unit' 	        => 'px',
                'default'       => array(
                    'top'       => '',
                    'bottom'    => ''
                )
            ),
            array(
                'id'            => 'page_title_bar_spacing_tablet',
                'type'          => 'spacing',
                'title'         => esc_html_x('Spacing', 'admin-view', 'camille'),
                'desc'          => esc_html_x('For page title bar on Tablet', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' ),
                'unit' 	        => 'px',
                'default'       => array(
                    'top'       => '',
                    'bottom'    => ''
                )
            ),
            array(
                'id'            => 'page_title_bar_spacing_mobile',
                'type'          => 'spacing',
                'title'         => esc_html_x('Spacing', 'admin-view', 'camille'),
                'desc'          => esc_html_x('For page title bar on Mobile', 'admin-view', 'camille'),
                'dependency'    => array( 'page_title_bar_layout|page_title_bar_style_no', '!=|!=', 'hide|true' ),
                'unit' 	        => 'px',
                'default'       => array(
                    'top'       => '',
                    'bottom'    => ''
                )
            )
        )
    );
    return $sections;
}