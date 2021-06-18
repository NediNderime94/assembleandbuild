<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'tgmpa_register', 'camille_register_required_plugins' );

if(!function_exists('lasf_get_plugin_source')){
    function lasf_get_plugin_source( $new, $initial, $plugin_name, $type = 'source'){
        if(isset($new[$plugin_name], $new[$plugin_name][$type]) && version_compare($initial[$plugin_name]['version'], $new[$plugin_name]['version']) < 0 ){
            return $new[$plugin_name][$type];
        }
        else{
            return $initial[$plugin_name][$type];
        }
    }
}

if(!function_exists('camille_register_required_plugins')){

	function camille_register_required_plugins() {


        $initial_required = array(
            'lastudio' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/lastudio/1.0.8/lastudio.zip',
                'version'   => '1.0.8'
            ),
            'camille-demo-data' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/camille-demo-data/1.0.0/camille-demo-data.zip',
                'version'   => '1.0.0'
            ),
            'lastudio-discography' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/lastudio-discography/1.0.0/lastudio-discography.zip',
                'version'   => '1.0.0'
            ),
            'lastudio-events' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/lastudio-events/1.0.0/lastudio-events.zip',
                'version'   => '1.0.0'
            ),
            'lastudio-playlist-manager' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/lastudio-playlist-manager/1.0.0/lastudio-playlist-manager.zip',
                'version'   => '1.0.0'
            ),
            'lastudio-videos' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/camille/plugins/lastudio-videos/1.0.0/lastudio-videos.zip',
                'version'   => '1.0.0'
            ),
            'revslider' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/shared/plugins/revslider/6.2.2/revslider.zip',
                'version'   => '6.2.2'
            ),
            'js_composer' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/shared/plugins/js_composer/6.1/js_composer.zip',
                'version'   => '6.1'
            )
        );

        $from_option = get_option('camille_required_plugins_list', $initial_required);

		$plugins = array();

		$plugins['js_composer'] = array(
			'name'					=> esc_html_x('WPBakery Visual Composer', 'admin-view', 'camille'),
			'slug'					=> 'js_composer',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'js_composer'),
			'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'js_composer', 'version')
		);

		$plugins['lastudio'] = array(
			'name'					=> esc_html_x('LA-Studio Core', 'admin-view', 'camille'),
			'slug'					=> 'lastudio',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio'),
			'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio', 'version')
		);

		$plugins['camille-demo-data'] = array(
			'name'					=> esc_html_x('Camille Package Demo Data', 'admin-view', 'camille'),
			'slug'					=> 'camille-demo-data',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'camille-demo-data'),
			'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'camille-demo-data', 'version')
		);

		$plugins['woocommerce'] = array(
			'name'     				=> esc_html_x('WooCommerce', 'admin-view', 'camille'),
			'slug'     				=> 'woocommerce',
			'version'				=> '4.0.0',
			'required' 				=> false
		);

		$plugins['revslider'] = array(
			'name'					=> esc_html_x('Slider Revolution', 'admin-view', 'camille'),
			'slug'					=> 'revslider',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'revslider'),
			'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'revslider', 'version')
		);

		$plugins['contact-form-7'] = array(
			'name' 					=> esc_html_x('Contact Form 7', 'admin-view', 'camille'),
			'slug' 					=> 'contact-form-7',
			'required' 				=> false
		);

		$plugins['lastudio-discography'] = array(
			'name'					=> esc_html_x('LaStudio Discography', 'admin-view', 'camille'),
			'slug'					=> 'lastudio-discography',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-discography'),
			'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-discography', 'version')
		);

		$plugins['lastudio-events'] = array(
			'name'					=> esc_html_x('LaStudio Events', 'admin-view', 'camille'),
			'slug'					=> 'lastudio-events',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-events'),
			'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-events', 'version')
		);

		$plugins['lastudio-playlist-manager'] = array(
			'name'					=> esc_html_x('LaStudio Playlist', 'admin-view', 'camille'),
			'slug'					=> 'lastudio-playlist-manager',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-playlist-manager'),
			'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-playlist-manager', 'version')
		);
		$plugins['lastudio-videos'] = array(
			'name'					=> esc_html_x('LaStudio Video', 'admin-view', 'camille'),
			'slug'					=> 'lastudio-videos',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-videos'),
			'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-videos', 'version')
		);

		$config = array(
			'id'           				=> 'camille',
			'default_path' 				=> '',
			'menu'         				=> 'tgmpa-install-plugins',
			'has_notices'  				=> true,
			'dismissable'  				=> true,
			'dismiss_msg'  				=> '',
			'is_automatic' 				=> false,
			'message'      				=> ''
		);

		tgmpa( $plugins, $config );

	}

}
