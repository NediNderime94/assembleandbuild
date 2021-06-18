<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_header_black()
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
            'key' => 'transparency_header_link_color|transparency_header_text_color|transparency_mm_lv_1_color',
            'value' => '#232324'
        ),

        array(
            'key' => 'transparency_header_link_hover_color',
            'value' => '#6b56e2'
        )
    );
}