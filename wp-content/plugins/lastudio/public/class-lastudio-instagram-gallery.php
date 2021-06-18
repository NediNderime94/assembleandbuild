<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Instagram_Gallery Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class LaStudio_Instagram_Gallery{

    /**
     * Instagram API-server URL.
     *
     * @since 1.0.0
     * @var string
     */
    private $api_url = 'https://www.instagram.com/';

    /**
     * Official Instagram API-server URL.
     *
     * @var string
     */
    private $official_api_url = 'https://api.instagram.com/v1/';

    /**
     * Access token.
     *
     * @var string
     */
    private $access_token = null;

    /**
     * Request config
     *
     * @var array
     */
    public $config = array();

    public function __construct( $settings = array(), $access_token = null)
    {
        $this->access_token = $access_token;

        $endpoint = 'hashtag';

        if(!empty($settings['endpoint']) && in_array($settings['endpoint'], array( 'hashtag', 'self' )) ){
            $endpoint = $settings['endpoint'];
        }

        switch ( $settings['cache_timeout'] ) {
            case 'none':
                $cache_timeout = 1;
                break;

            case 'minute':
                $cache_timeout = MINUTE_IN_SECONDS;
                break;

            case 'hour':
                $cache_timeout = HOUR_IN_SECONDS;
                break;

            case 'day':
                $cache_timeout = DAY_IN_SECONDS;
                break;

            case 'week':
                $cache_timeout = WEEK_IN_SECONDS;
                break;

            default:
                $cache_timeout = HOUR_IN_SECONDS;
                break;
        }

        $this->config = array(
            'endpoint'            => $endpoint,
            'target'              => ( 'hashtag' === $endpoint ) ? sanitize_text_field( $settings[ $endpoint ] ) : 'users',
            'hashtag'             => sanitize_text_field($settings['hashtag']),
            'username'             => sanitize_text_field($settings['username']),
            'posts_counter'       => $settings['posts_counter'],
            'post_link'           => true,
            'photo_size'          => $settings['photo_size'],
            'post_caption'        => true,
            'post_caption_length' => 50,
            'post_comments_count' => true,
            'post_likes_count'    => true,
            'cache_timeout'       => $cache_timeout,
        );
    }


    /**
     * Render gallery html.
     *
     * @return string
     */
    public function render_gallery() {
        $settings = $this->config;

        if ( 'hashtag' === $settings['endpoint'] && empty( $settings['hashtag'] ) ) {
            return print esc_html__( 'Please, enter #hashtag.', 'la-studio' );
        }

        if('self' === $settings['endpoint']){
            $username = $settings['username'];
            if(!empty($this->get_access_token())){
                $username = $this->get_username_by_token();
            }
            if(empty($username)){
                return print esc_html__( 'Please, enter username.', 'la-studio' );
            }
        }

        $html = '';

        // Endpoint.
        $endpoint = $this->sanitize_endpoint();

        $posts = $this->get_posts( $settings );

        if ( ! empty( $posts ) ) {

            foreach ( $posts as $post_data ) {

                $link        = ( 'hashtag' === $endpoint ) ? sprintf( $this->get_post_url(), $post_data['link'] ) : $post_data['link'];
                $the_image   = $this->the_image( $post_data );

                $item_html = '<div class="grid-item">';
                $item_html .= '<div class="instagram-item">';
                $item_html .= sprintf(
                    '<a target="_blank" href="%1$s" title="%2$s" class="thumbnail la-lazyload-image" data-background-image="%3$s"><span class="item--overlay"><i class="fa fa-instagram"></i></span></a>',
                    esc_url($link),
                    (!empty($item['caption']) ? esc_html($item['caption']) : ''),
                    esc_url($the_image)
                );

                $item_html .= sprintf(
                    '<div class="instagram-info"><span class="instagram-like"><i class="fa fa-heart"></i>%1$s</span><span class="instagram-comments"><i class="fa fa-comments"></i>%2$s</span></div>',
                    (!empty($item['likes']) ? esc_html($item['likes']) : '0'),
                    (!empty($item['comments']) ? esc_html($item['comments']) : '0')
                );

                $item_html .= '</div>';
                $item_html .= '</div>';

                $html .= $item_html;
            }

        } else {
            $html .= sprintf(
                '<div class="lastudio-instagram-gallery__item">%s</div>',
                esc_html__( 'Posts not found', 'la-studio' )
            );
        }

        echo $html;
    }

    /**
     * Display a HTML link with image.
     *
     * @since  1.0.0
     * @param  array $item Item photo data.
     * @return string
     */
    public function the_image( $item ) {

        $size = $this->config['photo_size'];

        if( empty($size) ){
            $size = 'thumbnail';
        }

        $thumbnail_resources = $item['thumbnail_resources'];

        if ( array_key_exists( $size, $thumbnail_resources ) ) {
            $width = $thumbnail_resources[ $size ]['config_width'];
            $height = $thumbnail_resources[ $size ]['config_height'];
            $post_photo_url = $thumbnail_resources[ $size ]['src'];
        } 
        else {
            $width = isset( $item['dimensions']['width'] ) ? $item['dimensions']['width'] : '';
            $height = isset( $item['dimensions']['height'] ) ? $item['dimensions']['height'] : '';
            $post_photo_url = isset( $item['image'] ) ? $item['image'] : '';
        }

        if ( empty( $post_photo_url ) ) {
            return '';
        }

        return $post_photo_url;
    }

    /**
     * Retrieve a photos.
     *
     * @since  1.0.0
     * @param  array $config Set of configuration.
     * @return array
     */
    public function get_posts( $config ) {

        $this->get_username_by_token();

        $transient_key = md5( $this->get_transient_key() );

        $data = get_transient( $transient_key );

        if ( ! empty( $data ) && 1 !== $config['cache_timeout'] && array_key_exists( 'thumbnail_resources', $data[0] ) ) {
            return $data;
        }

        $response = $this->remote_get( $config );

        if ( is_wp_error( $response ) ) {
            return array();
        }

        if( 'hashtag' === $config['endpoint'] ){
            $data = $this->get_response_data( $response );
        }
        else{
            $data = $this->get_response_data( $response );
        }

        if ( empty( $data ) ) {
            return array();
        }

        set_transient( $transient_key, $data, $config['cache_timeout'] );

        return $data;
    }

    /**
     * Retrieve the raw response from the HTTP request using the GET method.
     *
     * @since  1.0.0
     * @return array|WP_Error
     */
    public function remote_get( $config ) {

        $url = $this->get_grab_url( $config );

        $response = wp_remote_get( $url, array(
            'timeout'   => 60,
            'sslverify' => false
        ) );

        $response_code = wp_remote_retrieve_response_code( $response );

        if ( '' === $response_code ) {
            return new \WP_Error;
        }

        $result = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( ! is_array( $result ) ) {
            return new \WP_Error;
        }

        return $result;
    }

    /**
     * Get prepared response data.
     *
     * @param $response
     *
     * @return array
     */
    public function get_response_data( $response ) {

        $key = 'hashtag' == $this->config['endpoint'] ? 'hashtag' : 'user';

        if ( 'hashtag' === $key ) {
            $response = isset( $response['graphql'] ) ? $response['graphql'] : $response;
        }

        $response_items = ( 'hashtag' === $key ) ? $response[ $key ]['edge_hashtag_to_media']['edges'] : $response['graphql'][ $key ]['edge_owner_to_timeline_media']['edges'];

        if ( empty( $response_items ) ) {
            return array();
        }

        $data  = array();
        $nodes = array_slice(
            $response_items,
            0,
            $this->config['posts_counter'],
            true
        );

        foreach ( $nodes as $post ) {

            $_post               = array();
            $_post['link']       = $post['node']['shortcode'];
            $_post['image']      = $post['node']['thumbnail_src'];
            $_post['caption']    = isset( $post['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ? wp_html_excerpt( $post['node']['edge_media_to_caption']['edges'][0]['node']['text'], $this->config['post_caption_length'], '&hellip;' ) : '';
            $_post['comments']   = $post['node']['edge_media_to_comment']['count'];
            $_post['likes']      = $post['node']['edge_liked_by']['count'];
            $_post['dimensions'] = $post['node']['dimensions'];
            $_post['thumbnail_resources'] = $this->_generate_thumbnail_resources( $post );

            array_push( $data, $_post );
        }

        return $data;
    }


    /**
     * Get prepared response data from official api.
     *
     * @param $response
     *
     * @return array
     */
    public function get_response_data_from_official_api( $response ) {

        $response_items = $response['data'];

        if ( empty( $response_items ) ) {
            return array();
        }

        $data  = array();
        $nodes = array_slice(
            $response_items,
            0,
            $this->config['posts_counter'],
            true
        );

        foreach ( $nodes as $post ) {
            $_post             = array();
            $_post['link']     = $post['link'];
            $_post['caption']  = ! empty( $post['caption']['text'] ) ? wp_html_excerpt( $post['caption']['text'], $this->config['post_caption_length'], '&hellip;' ) : '';
            $_post['comments'] = $post['comments']['count'];
            $_post['likes']    = $post['likes']['count'];
            $_post['thumbnail_resources'] = $this->_generate_thumbnail_resources_from_official_api( $post );

            array_push( $data, $_post );
        }

        return $data;
    }

    /**
     * Generate thumbnail resources.
     *
     * @param $post_data
     *
     * @return array
     */
    public function _generate_thumbnail_resources( $post_data ) {
        $post_data = $post_data['node'];

        $thumbnail_resources = array(
            'thumbnail' => false,
            'low'       => false,
            'standard'  => false,
            'high'      => false,
        );

        if ( is_array( $post_data['thumbnail_resources'] ) && ! empty( $post_data['thumbnail_resources'] ) ) {
            foreach ( $post_data['thumbnail_resources'] as $key => $resources_data ) {

                if ( 150 === $resources_data['config_width'] ) {
                    $thumbnail_resources['thumbnail'] = $resources_data;

                    continue;
                }

                if ( 320 === $resources_data['config_width'] ) {
                    $thumbnail_resources['low'] = $resources_data;

                    continue;
                }

                if ( 640 === $resources_data['config_width'] ) {
                    $thumbnail_resources['standard'] = $resources_data;

                    continue;
                }
            }
        }

        if ( ! empty( $post_data['display_url'] ) ) {
            $thumbnail_resources['high'] = array(
                'src'           => $post_data['display_url'],
                'config_width'  => $post_data['dimensions']['width'],
                'config_height' => $post_data['dimensions']['height'],
            ) ;
        }

        return $thumbnail_resources;
    }

    /**
     * Generate thumbnail resources from official api.
     *
     * @param $post_data
     *
     * @return array
     */
    public function _generate_thumbnail_resources_from_official_api( $post_data ) {
        $thumbnail_resources = array(
            'thumbnail' => false,
            'low'       => false,
            'standard'  => false,
            'high'      => false,
        );

        if ( is_array( $post_data['images'] ) && ! empty( $post_data['images'] ) ) {

            $thumbnails_data = $post_data['images'];

            $thumbnail_resources['thumbnail'] = array(
                'src'           => $thumbnails_data['thumbnail']['url'],
                'config_width'  => $thumbnails_data['thumbnail']['width'],
                'config_height' => $thumbnails_data['thumbnail']['height'],
            );

            $thumbnail_resources['low'] = array(
                'src'           => $thumbnails_data['low_resolution']['url'],
                'config_width'  => $thumbnails_data['low_resolution']['width'],
                'config_height' => $thumbnails_data['low_resolution']['height'],
            );

            $thumbnail_resources['standard'] = array(
                'src'           => $thumbnails_data['standard_resolution']['url'],
                'config_width'  => $thumbnails_data['standard_resolution']['width'],
                'config_height' => $thumbnails_data['standard_resolution']['height'],
            );

            $thumbnail_resources['high'] = $thumbnail_resources['standard'];
        }

        return $thumbnail_resources;
    }

    /**
     * Retrieve a grab URL.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_grab_url( $config ) {

        if ( 'hashtag' == $config['endpoint'] ) {
            $url = sprintf( $this->get_tags_url(), $config['target'] );
            $url = add_query_arg( array( '__a' => 1 ), $url );
        }
        elseif ( 'header' ==  $config['endpoint'] ){
            $url = 'https://api.instagram.com/v1/users/self/';
            $url = add_query_arg( array( 'access_token' => $this->get_access_token() ), $url );
        }
        else {
            $url = $this->api_url . $config['username'];
            $url = add_query_arg( array( '__a' => 1 ), $url );
        }

        return $url;
    }

    /**
     * Retrieve a URL for photos by hashtag.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_tags_url() {
        return $this->api_url . 'explore/tags/%s/';
    }

    /**
     * Retrieve a URL for self photos.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_self_url() {
        return $this->official_api_url . 'users/self/media/recent/';
    }

    /**
     * Retrieve a URL for post.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_post_url() {
        return $this->api_url . 'p/%s/';
    }

    /**
     * sanitize endpoint.
     *
     * @since  1.0.0
     * @return string
     */
    public function sanitize_endpoint() {
        $endpoint = $this->config['endpoint'];
        if(in_array($endpoint, array( 'hashtag', 'self' ))){
            return $endpoint;
        }
        else{
            return 'hashtag';
        }
    }

    /**
     * Retrieve a photo sizes (in px) by option name.
     *
     * @since  1.0.0
     * @param  string $photo_size Photo size.
     * @return array
     */
    public function _get_relation_photo_size( $photo_size ) {
        switch ( $photo_size ) {

            case 'high':
                $size = array();
                break;

            case 'standard':
                $size = array( 640, 640 );
                break;

            case 'low':
                $size = array( 320, 320 );
                break;

            default:
                $size = array( 150, 150 );
                break;
        }

        return $size;
    }

    /**
     * Get transient key.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_transient_key() {
        return sprintf( 'lastudio_instagram_%s_%s_posts_count_%s_caption_%s_token_%s',
            $this->config['endpoint'],
            $this->config['target'],
            $this->config['posts_counter'],
            $this->config['post_caption_length'],
            $this->get_access_token()
        );
    }

    /**
     * Get access token.
     *
     * @return string
     */
    public function get_access_token() {
        if ( ! $this->access_token ) {
            $this->access_token = '';
        }
        return $this->access_token;
    }

    public function get_username_by_token(){

        $user_name = '';

        if(!empty($this->get_access_token())){
            $transient_key = md5( 'lastudio_instagram_get_username_' . $this->get_access_token() );
            $data = get_transient( $transient_key );

            if(!empty($data)){
                return $data;
            }
            else{
                $config = array(
                    'endpoint' => 'header'
                );
                $response = $this->remote_get( $config );

                if ( is_wp_error( $response ) ) {
                    return '';
                }
                if(!empty($response['data']['username'])){
                    $user_name = $response['data']['username'];
                    set_transient( $transient_key, $user_name, DAY_IN_SECONDS );
                }
            }
        }
        return $user_name;
    }
}
