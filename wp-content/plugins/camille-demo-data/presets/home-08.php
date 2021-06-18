<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_08()
{
    return array(

        array(
            'key' => 'logo_transparency',
            'value' => '2935'
        ),

        array(
            'key' => 'logo_transparency_2x',
            'value' => '2936'
        ),

        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),
        array(
            'key' => 'header_layout',
            'value' => '4'
        ),

        array(
            'key' => 'transparency_header_link_color|transparency_header_text_color',
            'value' => '#232324'
        ),

        array(
            'key' => 'transparency_header_link_hover_color',
            'value' => '#6b56e2'
        ),

        array(
            'key' => 'footer_full_width',
            'value' => 'yes'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => '#fff'
            )
        ),
        array(
            'key' => 'enable_footer_copyright',
            'value' => 'no'
        ),

        array(
            'key' => 'footer_text_color|footer_link_color',
            'value' => '#8a8a8a'
        ),
        array(
            'key' => 'footer_heading_color',
            'value' => '#232324'
        ),
        array(
            'key' => 'footer_link_hover_color',
            'value' => '#526df9'
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '50px',
                'padding_bottom'    => '10px'
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
@media(min-width: 767px){
    .footer-top .widget.widget_nav_menu .widget-title {
        display: none;
    }
}
.footer-top .widget.widget_nav_menu {
    text-align: left;
}
@media(max-width: 767px){
    .site-footer .widget {
        margin-bottom: 50px;
    }
}
'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-08-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_5',
            'value' => 'home-08-footer-5'
        ),
    );
}