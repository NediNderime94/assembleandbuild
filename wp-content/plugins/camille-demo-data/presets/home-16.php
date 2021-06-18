<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_16()
{
    return array(

        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),
        
        array(
            'key' => 'transparency_header_link_hover_color|transparency_mm_lv_1_hover_color',
            'value' => '#fff'
        ),

        array(
            'key' => 'footer_full_width',
            'value' => 'yes'
        ),

        array(
            'key' => 'footer_layout',
            'value' => '3col363'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => '#fff'
            )
        ),
        array(
            'key' => 'enable_footer_copyright',
            'value' => 'yes'
        ),

        array(
            'key' => 'footer_copyright',
            'value' => 'Copyright © 2018 Camille. Created by LA-Studio.'
        ),

        array(
            'key' => 'footer_text_color|footer_link_color|footer_copyright_text_color|footer_copyright_link_color',
            'value' => '#8a8a8a'
        ),
        array(
            'key' => 'footer_heading_color',
            'value' => '#232324'
        ),
        array(
            'key' => 'footer_link_hover_color|footer_copyright_link_hover_color',
            'value' => '#526df9'
        ),


        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '40px',
                'padding_bottom'    => '10px'
            )
        ),

        array(
            'key' => 'footer_copyright_background_color',
            'value' => '#fff'
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
@media(min-width: 1200px){
    .footer-bottom .footer-bottom-inner {
        float: left;
        margin-top: -40px;
        padding: 0 0 30px;
    }
}
@media(max-width: 1199px){
    .footer-bottom .footer-bottom-inner{
        text-align: center;
    }
}
'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-09-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'home-09-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'home-09-footer-3'
        ),

    );
}