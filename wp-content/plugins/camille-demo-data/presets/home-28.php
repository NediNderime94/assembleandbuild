<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_28()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),

        array(
            'key' => 'primary_color|header_link_hover_color|mm_lv_1_hover_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color|transparency_mm_lv_1_hover_color|transparency_header_link_hover_color',
            'value' => '#b9afa1'
        ),


        array(
            'key' => 'footer_layout',
            'value' => '3col363'
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
            'key' => 'footer_text_color|footer_heading_color|footer_link_color',
            'value' => '#656565'
        ),
        array(
            'key' => 'footer_link_hover_color',
            'value' => '#b9afa1'
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
.footer-column-3 {
    text-align: right;
}
.footer-column-2 {
    text-align: center;
}
.site-footer .la-contact-info .la-contact-item:before {
    color: #b9afa1;
}
@media(max-width: 767px){
    .footer-column-3 {
        text-align: center;
    }
    .footer-column-1 {
        text-align: center;
    }
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-28-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'home-28-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'home-28-footer-3'
        )
    );
}