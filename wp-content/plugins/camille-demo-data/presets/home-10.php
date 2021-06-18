<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_10()
{
    return array(

        array(
            'key' => 'header_transparency',
            'value' => 'no'
        ),
        array(
            'key' => 'header_layout',
            'value' => '5'
        ),


        array(
            'key' => 'footer_layout',
            'value' => '4col3333'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => '#202020'
            )
        ),
        array(
            'key' => 'footer_copyright_background_color',
            'value' => '#202020'
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '70px',
                'padding_bottom'    => '20px',
                'border_bottom'     => '1px',
                'border_style'      => 'solid',
                'border_color'      => 'rgba(66,66,66,0.4)',
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
.header-v5 #masthead_aside .header-component-outer:not(.header-bottom){
    text-align: left;
}
.header-widget-bottom .social-media-link {
    border-bottom: 1px solid #e4e4e4;
    padding-bottom: 7px;
    margin-bottom: 15px;
    color: #232324;
}
.header-v5 #masthead_aside .header-left {
    margin-bottom: 15vh;
}
.header-v5 #masthead_aside .header-middle {
    display: none;
}
.header-v5 #masthead_aside .header-bottom {
    padding-top: 10vh;
}
@media(min-width: 1500px){
.header-v5 #masthead_aside .header-bottom {
    padding-top: 20vh;
}
}
.header-widget-bottom {
    color: #8a8a8a;
}
@media(min-width: 992px){
    .la-footer-4col3333 .footer-column-2 {
        padding-left: 8%;
    }
}
@media(max-width: 1200px) and (min-width: 769px){
    .la-footer-4col3333 .footer-column {
        width: 50%;
        padding-left: 15px;
    }
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'creative-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'creative-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'creative-footer-3'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_4',
            'value' => 'creative-footer-4'
        ),

        array(
            'filter_name' => 'camille/filter/header_sidebar_widget_bottom',
            'value' => 'home-10-header-area'
        ),

    );
}