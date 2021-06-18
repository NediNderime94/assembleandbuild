<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_26()
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
            'value' => '#dcb86c'
        ),


        array(
            'key' => 'footer_layout',
            'value' => '1col'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => '#fff'
            )
        ),
        
        array(
            'key' => 'footer_text_color|footer_heading_color|footer_link_color',
            'value' => '#8a8a8a'
        ),
        array(
            'key' => 'footer_link_hover_color|footer_copyright_link_hover_color',
            'value' => '#dcb86c'
        ),
        
        array(
            'key' => 'footer_copyright_background_color',
            'value' => '#fff'
        ),
		array(
            'key' => 'footer_copyright_text_color|footer_copyright_link_color',
            'value' => '#8a8a8a'
        ),
        array(
            'key' => 'footer_copyright',
            'value' => '<div class="text-center">© Camille Theme by LaStudio</div>'
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '35px',
                'padding_bottom'    => '0px'
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
.site-footer {
    font-size: 12px;
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-26-footer'
        )
    );
}