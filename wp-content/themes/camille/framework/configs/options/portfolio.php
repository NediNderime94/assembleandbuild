<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Portfolio settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function camille_options_section_portfolio( $sections )
{
    $sections['portfolio'] = array(
        'name' => 'portfolio_panel',
        'title' => esc_html_x('Portfolio', 'admin-view', 'camille'),
        'icon' => 'fa fa-th',
        'sections' => array(
            array(
                'name'      => 'portfolio_general_section',
                'title'     => esc_html_x('General Setting', 'admin-view', 'camille'),
                'icon'      => 'fa fa-check',
                'fields'    => array(
                    array(
                        'id'        => 'layout_archive_portfolio',
                        'type'      => 'image_select',
                        'title'     => esc_html_x('Archive Portfolio Layout', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Controls the layout of archive portfolio page', 'admin-view', 'camille'),
                        'default'   => 'col-1c',
                        'radio'     => true,
                        'options'   => Camille_Options::get_config_main_layout_opts(true, false)
                    ),
                    array(
                        'id'        => 'main_full_width_archive_portfolio',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'inherit',
                        'title'     => esc_html_x('100% Main Width', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('[Portfolio] Turn on to have the main area display at 100% width according to the window size. Turn off to follow site width.', 'admin-view', 'camille'),
                        'options'   => Camille_Options::get_config_radio_opts()
                    ),
                    array(
                        'id'            => 'main_space_archive_portfolio',
                        'type'          => 'spacing',
                        'title'         => esc_html_x('Custom Main Space', 'admin-view', 'camille'),
                        'desc'          => esc_html_x('[Portfolio]Leave empty if you not need', 'admin-view', 'camille'),
                        'unit' 	        => 'px'
                    ),
                    array(
                        'id'        => 'portfolio_display_type',
                        'default'   => 'grid',
                        'title'     => esc_html_x('Display Type as', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Controls the type display of portfolio for the archive page', 'admin-view', 'camille'),
                        'type'      => 'select',
                        'options'   => array(
                            'grid'           => esc_html_x('Grid', 'admin-view', 'camille'),
                            'masonry'        => esc_html_x('Masonry', 'admin-view', 'camille')
                        )
                    ),
                    array(
                        'id'        => 'portfolio_item_space',
                        'default'   => '0',
                        'title'     => esc_html_x('Item Padding', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Select gap between item in grids', 'admin-view', 'camille'),
                        'type'      => 'select',
                        'options'   => array(
                            '0'         => esc_html_x('0px', 'admin-view', 'camille'),
                            '5'          => esc_html_x('5px', 'admin-view', 'camille'),
                            '10'         => esc_html_x('10px', 'admin-view', 'camille'),
                            '15'         => esc_html_x('15px', 'admin-view', 'camille'),
                            '20'         => esc_html_x('20px', 'admin-view', 'camille'),
                            '25'         => esc_html_x('25px', 'admin-view', 'camille'),
                            '30'         => esc_html_x('30px', 'admin-view', 'camille'),
                            '35'         => esc_html_x('35px', 'admin-view', 'camille'),
                            '40'         => esc_html_x('40px', 'admin-view', 'camille'),
                            '45'         => esc_html_x('45px', 'admin-view', 'camille'),
                            '50'         => esc_html_x('50px', 'admin-view', 'camille'),
                            '55'         => esc_html_x('55px', 'admin-view', 'camille'),
                            '60'         => esc_html_x('60px', 'admin-view', 'camille'),
                            '65'         => esc_html_x('65px', 'admin-view', 'camille'),
                            '70'         => esc_html_x('70px', 'admin-view', 'camille'),
                            '75'         => esc_html_x('75px', 'admin-view', 'camille'),
                            '80'         => esc_html_x('80px', 'admin-view', 'camille'),
                        )
                    ),
                    array(
                        'id'        => 'portfolio_display_style',
                        'default'   => '1',
                        'title'     => esc_html_x('Select Style', 'admin-view', 'camille'),
                        'type'      => 'select',
                        'options'   => array(
                            '1'           => esc_html_x('Style 01', 'admin-view', 'camille'),
                            '2'           => esc_html_x('Style 02', 'admin-view', 'camille'),
                            '3'           => esc_html_x('Style 03', 'admin-view', 'camille'),
                            '4'           => esc_html_x('Style 04', 'admin-view', 'camille'),
                            '5'           => esc_html_x('Style 05', 'admin-view', 'camille'),
                            '6'           => esc_html_x('Style 06', 'admin-view', 'camille'),
                            '7'           => esc_html_x('Style 07', 'admin-view', 'camille'),
                            '8'           => esc_html_x('Style 08', 'admin-view', 'camille')
                        )
                    ),
                    array(
                        'id'        => 'portfolio_column',
                        'type'      => 'column_responsive',
                        'title'     => esc_html_x('Portfolio Column', 'admin-view', 'camille'),
                        'default'   => array(
                            'xlg' => 3,
                            'lg' => 3,
                            'md' => 2,
                            'sm' => 2,
                            'xs' => 1,
                            'mb' => 1
                        )
                    ),
                    array(
                        'id'        => 'portfolio_per_page',
                        'type'      => 'number',
                        'default'   => 10,
                        'attributes'=> array(
                            'min' => 1,
                            'max' => 100
                        ),
                        'title'     => esc_html_x('Total Portfolio will be display in a page', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'portfolio_thumbnail_size',
                        'type'      => 'text',
                        'default'   => 'full',
                        'title'     => esc_html_x('Portfolio Thumbnail size', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'single_portfolio_general_section',
                'title'     => esc_html_x('Portfolio Single', 'admin-view', 'camille'),
                'icon'      => 'fa fa-check',
                'fields'    => array(
                    array(
                        'id'        => 'layout_single_portfolio',
                        'type'      => 'image_select',
                        'title'     => esc_html_x('Single Portfolio Layout', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Controls the layout of portfolio detail page', 'admin-view', 'camille'),
                        'default'   => 'col-1c',
                        'radio'     => true,
                        'options'   => Camille_Options::get_config_main_layout_opts(true, false)
                    ),
                    array(
                        'id'        => 'single_portfolio_nextprev',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'on',
                        'title'     => esc_html_x('Show Next / Previous Portfolio', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on to display next/previous portfolio', 'admin-view', 'camille'),
                        'options'   => Camille_Options::get_config_radio_onoff(false)
                    )
                )
            )
        )
    );
    return $sections;
}