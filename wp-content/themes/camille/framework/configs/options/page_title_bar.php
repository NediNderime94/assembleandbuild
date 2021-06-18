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
function camille_options_section_page_title_bar( $sections ) {

    $page_title_layout = array(
        'hide' => esc_html_x("Don't show", 'admin-view', 'camille')
    );
    $page_title_layout = $page_title_layout + Camille_Options::get_config_page_title_bar_opts(false);

    $desc1 = esc_html_x('For page title bar', 'admin-view', 'camille');
    $desc2 = esc_html_x('For page title bar of WooCommerce', 'admin-view', 'camille');

    $sections['page_title_bar'] = array(
        'name'          => 'page_title_bar_panel',
        'title'         => esc_html_x('Page Title Bar', 'admin-view', 'camille'),
        'icon'          => 'fa fa-sliders',
        'sections' => array(
            array(
                'name'      => 'page_title_bar_sections',
                'title'     => esc_html_x('Global Page Title', 'admin-view', 'camille'),
                'icon'      => 'fa fa-plus',
                'fields'    => array(
                    array(
                        'id'            => 'page_title_bar_layout',
                        'type'          => 'select',
                        'class'         => 'chosen',
                        'title'         => esc_html_x('Select Layout', 'admin-view', 'camille'),
                        'desc'          => $desc1,
                        'options'       => $page_title_layout
                    ),
                    array(
                        'id'            => 'enable_page_title_subtext',
                        'type'          => 'radio',
                        'default'       => 'no',
                        'class'         => 'la-radio-style',
                        'title'         => esc_html_x('Replace breadcrumb by custom text', 'admin-view', 'camille'),
                        'desc'          => $desc1,
                        'options'       => Camille_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'            => 'page_title_custom_subtext',
                        'type'          => 'text',
                        'title'         => esc_html_x('Custom Text', 'admin-view', 'camille'),
                        'desc'          => $desc1
                    ),

                    array(
                        'id'      => 'page_title_font_size',
                        'type'      => 'responsive',
                        'title'     => esc_html_x('Page Title Font Size', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Enter the font size (e.g: 20px )', 'admin-view', 'camille')
                    ),

                    array(
                        'id'        => 'page_title_bar_background',
                        'type'      => 'background',
                        'title'     => esc_html_x('Background', 'admin-view', 'camille'),
                        'desc'      => $desc1
                    ),
                    array(
                        'id'        => 'page_title_bar_heading_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('heading_color'),
                        'title'     => esc_html_x('Heading Color', 'admin-view', 'camille'),
                        'desc'      => $desc1
                    ),
                    array(
                        'id'        => 'page_title_bar_text_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('body_color'),
                        'title'     => esc_html_x('Text Color', 'admin-view', 'camille'),
                        'desc'      => $desc1
                    ),
                    array(
                        'id'        => 'page_title_bar_link_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('body_color'),
                        'title'     => esc_html_x('Link Color', 'admin-view', 'camille'),
                        'desc'      => $desc1
                    ),
                    array(
                        'id'        => 'page_title_bar_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('primary_color'),
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'camille'),
                        'desc'      => $desc1
                    ),
                    array(
                        'id'        => 'page_title_bar_spacing',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'desc'      => $desc1,
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 40,
                            'bottom' => 40
                        )
                    ),
                    array(
                        'id'        => 'page_title_bar_spacing_tablet',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For page title bar on Tablet', 'admin-view', 'camille'),
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 25,
                            'bottom' => 25
                        )
                    ),
                    array(
                        'id'        => 'page_title_bar_spacing_mobile',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('For page title bar on Mobile', 'admin-view', 'camille'),
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 25,
                            'bottom' => 25
                        )
                    )
                )
            ),
            array(
                'name'      => 'page_title_bar_woo_sections',
                'title'     => esc_html_x('WooCommerce Page Title Bar', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'        => 'woo_override_page_title_bar',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'off',
                        'title'     => esc_html_x('Enable Override', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on to override all setting page title bar of WooCommerce Settings ( Shop page/Product details/Product Category/ Product tags and search page )', 'admin-view', 'camille'),
                        'info'      => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'camille'),
                        'options'   => Camille_Options::get_config_radio_onoff(false)
                    ),
                    array(
                        'id'            => 'woo_page_title_bar_layout',
                        'type'          => 'select',
                        'class'         => 'chosen',
                        'title'         => esc_html_x('WooCommerce Page Title Bar Layout', 'admin-view', 'camille'),
                        'options'       => $page_title_layout,
                        'dependency'    => array('woo_override_page_title_bar_on', '==', 'true')
                    ),
                    array(
                        'id'        => 'woo_page_title_font_size',
                        'type'      => 'responsive',
                        'title'     => esc_html_x('Page Title Font Size', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Enter the font size (e.g: 20px )', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_background',
                        'type'      => 'background',
                        'title'     => esc_html_x('Background', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_heading_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('header_color'),
                        'title'     => esc_html_x('Heading Color', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_text_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('body_color'),
                        'title'     => esc_html_x('Text Color', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_link_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('body_color'),
                        'title'     => esc_html_x('Link Color', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => Camille_Options::get_color_default('primary_color'),
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_spacing',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => $desc2,
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 40,
                            'bottom' => 40
                        )
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_spacing_tablet',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => esc_html_x('For page title bar of WooCommerce on Tablet', 'admin-view', 'camille'),
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 25,
                            'bottom' => 25
                        )
                    ),
                    array(
                        'id'        => 'woo_page_title_bar_spacing_mobile',
                        'type'      => 'spacing',
                        'title'     => esc_html_x('Spacing', 'admin-view', 'camille'),
                        'dependency'=> array('woo_override_page_title_bar_on|woo_page_title_bar_layout', '==|!=', 'true|hide'),
                        'desc'      => esc_html_x('For page title bar of WooCommerce on Mobile', 'admin-view', 'camille'),
                        'unit' 	    => 'px',
                        'default'   => array(
                            'top' => 25,
                            'bottom' => 25
                        )
                    )
                )
            )
        )
    );
    return $sections;
}