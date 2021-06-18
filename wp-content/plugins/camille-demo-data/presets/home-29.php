<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_29()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'no'
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
                'padding_top'       => '80px',
                'padding_bottom'    => '20px',
                'border_bottom'     => '1px',
                'border_style'      => 'solid',
                'border_color'      => 'rgba(66,66,66,0.4)',
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
@media(min-width: 992px){
    .la-footer-4col3333 .footer-column-2 {
        padding-left: 8%;
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
    );
}