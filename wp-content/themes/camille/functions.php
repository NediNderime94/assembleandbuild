<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Require plugins vendor
 */

require_once get_template_directory() . '/plugins/tgm-plugin-activation/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/plugins/plugins.php';

/**
 * Include the main class.
 */

include_once get_template_directory() . '/framework/classes/class-core.php';


Camille::$template_dir_path   = get_template_directory();
Camille::$template_dir_url    = get_template_directory_uri();
Camille::$stylesheet_dir_path = get_stylesheet_directory();
Camille::$stylesheet_dir_url  = get_stylesheet_directory_uri();

/**
 * Include the autoloader.
 */
include_once Camille::$template_dir_path . '/framework/classes/class-autoload.php';

new Camille_Autoload();

/**
 * load functions for later usage
 */

require_once Camille::$template_dir_path . '/framework/functions/functions.php';

new Camille_Multilingual();

if(!function_exists('Camille')){
    function Camille(){
        return Camille::get_instance();
    }
}

new Camille_Scripts();

new Camille_Admin();

new Camille_WooCommerce();

new Camille_WooCommerce_Wishlist();

new Camille_WooCommerce_Compare();

new Camille_Visual_Composer();

/**
 * Set the $content_width global.
 */
global $content_width;
if ( ! is_admin() ) {
    if ( ! isset( $content_width ) || empty( $content_width ) ) {
        $content_width = (int) Camille()->layout()->get_content_width();
    }
}

require_once Camille::$template_dir_path . '/framework/functions/extra-functions.php';

require_once Camille::$template_dir_path . '/framework/functions/update.php';
