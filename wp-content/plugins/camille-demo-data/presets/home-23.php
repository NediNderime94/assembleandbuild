<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_23()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),

        array(
            'key' => 'primary_color|header_link_hover_color|mm_lv_1_hover_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color|transparency_mm_lv_1_hover_color|transparency_header_link_hover_color|transparency_header_top_link_hover_color',
            'value' => '#f5b324'
        ),

        array(
            'key' => 'body_font_size',
            'value' => '16px'
        ),

        array(
            'key' => 'main_font|secondary_font',
            'value' => array(
                'family'    => 'Roboto Condensed',
                'font'      => 'google',
                'variant'   => array(
                    '300',
                    '300italic',
                    '400',
                    '400italic',
                    '700',
                    '700italic'
                )
            )
        ),

        array(
            'key'   => 'enable_header_top',
            'value' => 'custom'
        ),

        array(
            'key'   => 'use_custom_header_top',
            'value' => '
<div class="header_component header_component--linktext la_compt_iem la_com_action--linktext "><a rel="nofollow" class="component-target" href="tel:+45 254 254 254"><i class="fa fa-phone"></i><span class="component-target-text">+45.254.254.254</span></a></div>
<div class="header_component header_component--text la_compt_iem la_com_action--text"><span class="component-target"><i class="fa fa-clock-o"></i><span class="component-target-text">Mon - Sat: 7:00 - 18:00</span></span></div>
<div class="la_com_action--custom pull-right">
    <div class="header_component header_component--linktext la_compt_iem la_com_action--linktext"><a class="component-target" href="#"><span class="component-target-text">English</span></a></div>
    <div class="header_component header_component--linktext la_compt_iem la_com_action--linktext"><a class="component-target" href="#"><span class="component-target-text">France</span></a></div>
    <div class="header_component header_component--linktext la_compt_iem la_com_action--linktext"><a class="component-target" href="#"><span class="component-target-text">Germany</span></a></div>
</div>
            '
        ),

        array(
            'key' => 'transparency_header_top_background_color',
            'value' => '#fff'
        ),
        array(
            'key' => 'transparency_header_top_text_color|transparency_header_top_link_color',
            'value' => '#232324'
        ),

        array(
            'key'   => 'header_top_elements',
            'value' => array(
                array(
                    'type' => 'link_text',
                    'icon' => 'fa fa-phone',
                    'text'  => '+45.254.254.254',
                    'link'  => 'tel:+45 254 254 254'
                ),
                array(
                    'type' => 'text',
                    'icon' => 'fa fa-clock-o',
                    'text'  => 'Mon - Sat: 7:00 - 18:00'
                )
            )
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
.site-main-nav .main-menu > li > a {
    font-size: inherit;
}
.site-footer{
    font-size: 0.875em;
}
.footer-column-inner {
    max-width: 270px;
}
.la_com_action--custom .la_compt_iem{
    margin-left: 0;
}
.la_com_action--custom .la_compt_iem + .la_compt_iem:before {
    content: "/";
    display: inline-block;
    padding: 0 5px;
    font-size: 10px;
}
.site-header .site-header-top{
    padding-top: 10px;
    padding-bottom: 10px;
}
.la_com_action--custom .la_compt_iem .component-target {
    display: inline-block;
}
.site-header-top .component-target-text {
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