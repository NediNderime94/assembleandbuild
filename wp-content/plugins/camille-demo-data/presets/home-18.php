<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_18()
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
            'key' => 'la_custom_css',
            'value' => '
.header-widget-bottom .social-media-link {
    border-bottom: 1px solid #e4e4e4;
    padding-bottom: 7px;
    margin-bottom: 15px;
    color: #232324;
}
.header-v5 #masthead_aside .header-middle {
    margin-bottom: 15vh;
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
    text-align: center;
}
'
        ),


        array(
            'filter_name' => 'camille/filter/header_sidebar_widget_bottom',
            'value' => 'home-10-header-area'
        ),

    );
}