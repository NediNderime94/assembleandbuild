<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_get_demo_array($dir_url, $dir_path){

    $demo_items = array(
        array(
            'image'     => 'images/home-04.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-04/',
            'title'     => 'Creative Agency 01',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-02.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-02/',
            'title'     => 'Modern Agency',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-03.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-03/',
            'title'     => 'Creative Agency 02',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-01.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-01/',
            'title'     => 'Creative Agency 03',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-05.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-05/',
            'title'     => 'Business 01',
            'category'  => 'Business'
        ),
        array(
            'image'     => 'images/home-06.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-06/',
            'title'     => 'Interactive Business',
            'category'  => 'Business'
        ),
        array(
            'image'     => 'images/home-07.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-07/',
            'title'     => 'App Landing',
            'category'  => 'Business'
        ),
        array(
            'image'     => 'images/home-08.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-08/',
            'title'     => 'Minimal Agency 01',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-09.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-09/',
            'title'     => 'Minimal Agency 02',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-10.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-10/',
            'title'     => 'Minimal Agency Sidebar',
            'category'  => 'Agency'
        ),
        array(
            'image'     => 'images/home-11.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-11/',
            'title'     => 'Center/Slider Portfolio',
            'category'  => 'Portfolio'
        ),
        array(
            'image'     => 'images/home-12.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-12/',
            'title'     => 'Portfolio Full Screen',
            'category'  => 'Portfolio'
        ),
        array(
            'image'     => 'images/home-13.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-13/',
            'title'     => 'Split Slider',
            'category'  => 'Portfolio'
        ),
        array(
            'image'     => 'images/home-14.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-14/',
            'title'     => 'Freelancer 01',
            'category'  => 'Portfolio'
        ),
        array(
            'image'     => 'images/home-15.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-15/',
            'title'     => 'Business 02',
            'category'  => 'Business'
        ),
        array(
            'image'     => 'images/home-16.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-16/',
            'title'     => 'Shop Minimal',
            'category'  => 'Shop'
        ),
        array(
            'image'     => 'images/home-17.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-17/',
            'title'     => 'Shop Mordern',
            'category'  => 'Shop'
        ),
        array(
            'image'     => 'images/home-18.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-18/',
            'title'     => 'Shop Sidebar',
            'category'  => 'Shop'
        ),
        array(
            'image'     => 'images/home-19.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-19/',
            'title'     => 'Shop Parallax',
            'category'  => 'Shop'
        ),
        array(
            'image'     => 'images/home-20.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-20/',
            'title'     => 'Freelancer 02',
            'category'  => 'Portfolio'
        ),
        array(
            'image'     => 'images/home-21.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-21/',
            'title'     => 'Gym & Fitness',
            'category'  => 'Corporate'
        ),
        array(
            'image'     => 'images/home-22.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-22/',
            'title'     => 'Dentits',
            'category'  => 'Corporate'
        ),
        array(
            'image'     => 'images/home-23.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-23/',
            'title'     => 'Construction',
            'category'  => 'Corporate'
        ),
        array(
            'image'     => 'images/home-24.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-24/',
            'title'     => 'Music',
            'category'  => 'Corporate'
        ),
        array(
            'image'     => 'images/home-25.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-25/',
            'title'     => 'Car Services',
            'category'  => 'Services'
        ),
        array(
            'image'     => 'images/home-26.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-26/',
            'title'     => 'Barber',
            'category'  => 'Services'
        ),
        array(
            'image'     => 'images/home-27.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-27/',
            'title'     => 'Restaurant',
            'category'  => 'Services'
        ),
        array(
            'image'     => 'images/home-28.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-28/',
            'title'     => 'Spa & Beauty',
            'category'  => 'Services'
        ),
        array(
            'image'     => 'images/home-29.jpg',
            'link'      => 'https://camille.la-studioweb.com/home-29/',
            'title'     => 'Blog',
            'category'  => 'Services'
        ),
    );

    $default_image_setting = array(
        'woocommerce_single_image_width' => 600,
        'woocommerce_thumbnail_image_width' => 420,
        'woocommerce_thumbnail_cropping' => 'custom',
        'woocommerce_thumbnail_cropping_custom_width' => 10,
        'woocommerce_thumbnail_cropping_custom_height' => 14,
        'thumbnail_size_w' => 0,
        'thumbnail_size_h' => 0,
        'medium_size_w' => 0,
        'medium_size_h' => 0,
        'medium_large_size_w' => 0,
        'medium_large_size_h' => 0,
        'large_size_w' => 0,
        'large_size_h' => 0
    );

    $default_menu = array(
        'main-nav'              => 'Primary Menu',
        'mobile-nav'            => 'Primary Menu',
        'aside-nav'             => 'Primary Menu'
    );

    $default_page = array(
        'page_for_posts' 	            => 'Blog',
        'woocommerce_shop_page_id'      => 'Shop',
        'woocommerce_cart_page_id'      => 'Cart',
        'woocommerce_checkout_page_id'  => 'Checkout',
        'woocommerce_myaccount_page_id' => 'My account'
    );

    $slider = $dir_path . 'Slider/';
    $content = $dir_path . 'Content/';
    $widget = $dir_path . 'Widget/';
    $setting = $dir_path . 'Setting/';
    $preview = $dir_url;


    $demo_data = array();

    for( $i = 1; $i <= 29; $i ++ ){
        $id = $i;
        if( $i < 10 ) {
            $id = '0'. $i;
        }

        $demo_item_name = !empty($demo_items[$i - 1]['title']) ? $demo_items[$i - 1]['title'] : 'Demo ' . $id;

        $value = array();
        $value['title']             = $demo_item_name;
        $value['category']          = 'demo';
        $value['demo_preset']       = 'home-' . $id;
        $value['demo_url']          = 'https://camille.la-studioweb.com/home-' . $id . '/';
        $value['preview']           = $preview  .   'home-' . $id . '.jpg';
        $value['option']            = $setting  .   'option-' . $id . '.json';
        $value['content']           = $content  .   'data-sample.xml';

        $value['widget']            = $widget   .   'widget-' . $id . '.json';

        $value['pages']             = array_merge(
            $default_page,
            array(
                'page_on_front' => 'Home ' . $id
            )
        );

        $value['menu-locations']    = array_merge(
            $default_menu,
            array(

            )
        );
        $value['other_setting']    = array_merge(
            $default_image_setting,
            array(

            )
        );

        if(!in_array($i, array(8,9,10,11,13,14,19,29))){
            $value['slider']            = $slider   .   'home-'. $id .'.zip';
        }

        $demo_data['home-'. $id] = $value;
    }

    return $demo_data;
}