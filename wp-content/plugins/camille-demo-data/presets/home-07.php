<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_07()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),
        array(
            'key' => 'header_layout',
            'value' => '4'
        ),

        array(
            'key' => 'primary_color|header_link_hover_color|mm_lv_1_hover_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color',
            'value' => '#526df9'
        ),

        array(
            'key' => 'transparency_header_link_hover_color|transparency_mm_lv_1_hover_color',
            'value' => '#fff'
        ),

        array(
            'key' => 'footer_layout',
            'value' => '3col444'
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
.site-footer {
    font-size: 12px;
}
.site-footer .footer-column-1 {
    left: 33.33333%;
    text-align: center;
}
.site-footer .footer-column-2 {
    left: 33.33333%;
    text-align: right;
}
.site-footer .footer-column-3 {
    right: 66.66667%;
}
.site-footer .menu-inline-item .menu li {
    margin: 0 20px 10px;
}
@media(max-width: 1200px){
    .site-footer .footer-column-3 {
        width: 35%;
        right: 65%;
    }
    .site-footer .footer-column-1 {
        width: 45%;
        left: 35%;
    }
    .site-footer .footer-column-2 {
        width: 20%;
        left: 35%;
    }
    .site-footer .menu-inline-item .menu li {
        margin: 0 10px 10px;
    }
}
@media(max-width: 767px){
    .site-footer .footer-column{
        width: 100%;
        left: 0;
        right: 0;
        text-align: center;
    }
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-07-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'home-07-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'home-07-footer-3'
        )
    );
}