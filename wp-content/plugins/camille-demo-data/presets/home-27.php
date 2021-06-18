<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_27()
{
    return array(

        array(
            'key' => 'logo',
            'value' => 2591
        ),
        array(
            'key' => 'logo_2x',
            'value' => 2592
        ),

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),

        array(
            'key' => 'header_layout',
            'value' => '5'
        ),

        array(
            'key' => 'header_access_icon_1',
            'value' => array()
        ),

        array(
            'key' => 'primary_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color',
            'value' => '#dcb86c'
        ),

        array(
            'key' => 'header_background',
            'value' => array(
                'color' => '#313236'
            )
        ),

        array(
            'key' => 'header_text_color|header_link_color|mm_lv_1_color',
            'value' => '#919297'
        ),

        array(
            'key' => 'header_link_hover_color|mm_lv_1_hover_color|offcanvas_heading_color|offcanvas_link_hover_color',
            'value' => '#fff'
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
            'value' => '<div class="text-center">© Camille Theme by LaStudio</div>'
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
#masthead_aside .header-widget-bottom .widget:last-child {
    margin-bottom: 0;
}
#masthead_aside .header-widget-bottom .widget-title {
    font-weight: normal;
    margin-bottom: 15px;
    margin-top: 0;
}
#masthead_aside .la-contact-info .la-contact-item{
    padding-left: 0;
}
#masthead_aside .la-contact-info .la-contact-item:before{
    display: block;
    color: #b58113;
    position: static;
    line-height: 1;
}
.site-footer {
    font-size: 12px;
    display: none;
}
.footer-column-inner {
    max-width: 270px;
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
        ),

        array(
            'filter_name' => 'camille/filter/header_sidebar_widget_bottom',
            'value' => 'home-27-header-aside'
        ),
    );
}