<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_21()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),

        array(
            'key' => 'primary_color|header_link_hover_color|mm_lv_1_hover_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color|transparency_header_link_hover_color|transparency_mm_lv_1_hover_color',
            'value' => '#f3498d'
        ),

        array(
            'key' => 'footer_layout',
            'value' => '3col444'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => '#212121'
            )
        ),
        array(
            'key' => 'footer_copyright_background_color',
            'value' => '#212121'
        ),

        array(
            'key' => 'footer_copyright',
            'value' => '<div class="text-center">© Camille Theme by LaStudio. All Right Reserved 2018.</div>'
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '70px',
                'padding_bottom'    => '20px'
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
.header-custom-btn a.component-target {
    background: #d8242b;
    color: #fff;
    margin-right: 30px;
}
.header-custom-btn a.component-target:hover{
    background: #bb070e;
    color: #fff;
}
.footer-column-inner {
    max-width: 270px;
}
.site-main-nav .main-menu > li > a {
    font-size: 14px;
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-15-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'home-15-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'home-15-footer-3'
        )
    );
}