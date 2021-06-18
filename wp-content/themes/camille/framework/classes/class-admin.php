<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

class Camille_Admin {

    public function __construct(){
        $this->init_page_options();
        $this->init_meta_box();
        $this->init_shortcode_manager();
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts') );
        add_action( 'customize_register', array( $this, 'override_customize_control') );
        new Camille_MegaMenu_Init();
        add_filter('lastudio/filter/framework/field/icon/json', array( $this, 'add_icon_to_fw'));
    }

    public function admin_scripts(){
        wp_enqueue_style('camille-admin-css', Camille::$template_dir_url. '/assets/admin/css/admin.css');
        wp_enqueue_script('camille-admin-theme', Camille::$template_dir_url . '/assets/admin/js/admin.js', array( 'jquery'), false, true );
        $asset_font_without_domain = apply_filters('camille/filter/assets_font_url', camille_get_relative_url(untrailingslashit(get_template_directory_uri())));
        wp_add_inline_style(
            "camille-admin-css",
            "@font-face{
                font-family: 'dl-icon';
                src: url('{$asset_font_without_domain}/assets/fonts/dl-icon.eot');
                src: url('{$asset_font_without_domain}/assets/fonts/dl-icon.eot') format('embedded-opentype'),
                     url('{$asset_font_without_domain}/assets/fonts/dl-icon.woff') format('woff'),
                     url('{$asset_font_without_domain}/assets/fonts/dl-icon.ttf') format('truetype'),
                     url('{$asset_font_without_domain}/assets/fonts/dl-icon.svg') format('svg');
                font-weight:normal;
                font-style:normal
            }"
        );
    }

    public function add_icon_to_fw( $icon_path ) {
        $icon_path[] = Camille::$template_dir_path . '/assets/fonts/dl-icon.json';
        return $icon_path;
    }

    private function init_page_options(){
        $options = !empty(Camille()->options()->sections) ? Camille()->options()->sections : array();
        if(class_exists('LaStudio_Theme_Options') && !empty($options)) {
            $settings = array(
                'menu_title' => esc_html_x('Theme Options', 'admin-view', 'camille'),
                'menu_type' => 'theme',
                'menu_slug' => 'theme_options',
                'ajax_save' => false,
                'show_reset_all' => true,
                'disable_header' => false,
                'framework_title' => esc_html_x('Camille', 'admin-view', 'camille')
            );
            LaStudio_Theme_Options::instance( $settings, $options, Camille::get_option_name());
        }
        if(class_exists('LaStudio_Theme_Customize') && function_exists('la_convert_option_to_customize')){
            if(!empty($options)){
                $customize_options = la_convert_option_to_customize($options);
                LaStudio_Theme_Customize::instance( $customize_options, Camille::get_option_name());
            }
        }
    }

    private function init_meta_box(){


        $default_metabox_opts = !empty(Camille()->options()->metabox_sections) ? Camille()->options()->metabox_sections : array();

        if(!class_exists('LaStudio_Metabox') || empty($default_metabox_opts)){
            return;
        }

        $metaboxes = array();
        $taxonomy_metaboxes = array();

        /**
         * Pages
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'camille'),
            'post_type' => 'page',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional',
                'fullpage'
            ))
        );

        /**
         * Post
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Post Options', 'admin-view', 'camille'),
            'post_type' => 'post',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'post',
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Product
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Product View Options', 'admin-view', 'camille'),
            'post_type' => 'product',
            'context'   => 'normal',
            'priority'  => 'default',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                //'product',
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Portfolio
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Portfolio Options', 'admin-view', 'camille'),
            'post_type' => 'la_portfolio',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Testimonial
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Testimonial Information', 'admin-view', 'camille'),
            'post_type' => 'la_testimonial',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'testimonial'
            ))
        );

        /**
         * Member
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'camille'),
            'post_type' => 'la_team_member',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'member',
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Product Category
         */
        $taxonomy_metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Product Category Options', 'admin-view', 'camille'),
            'taxonomy' => 'product_cat',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Category
         */
        $taxonomy_metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Category Options', 'admin-view', 'camille'),
            'taxonomy' => 'category',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        /**
         * Playlist
         */
        $metaboxes[] = array(
            'id'        => Camille::get_original_option_name(),
            'title'     => esc_html_x('Page Options', 'admin-view', 'camille'),
            'post_type' => 'lpm_playlist',
            'context'   => 'normal',
            'priority'  => 'high',
            'sections'  => Camille()->options()->get_metabox_by_sections(array(
                'layout',
                'header',
                'page_title_bar',
                'footer',
                'additional'
            ))
        );

        LaStudio_Metabox::instance($metaboxes);
        LaStudio_Taxonomy::instance($taxonomy_metaboxes);
    }

    private function init_shortcode_manager(){
        if(class_exists('LaStudio_Shortcode_Manager')){
            $options       = array();
            $options[]     = array(
                'title'      => esc_html_x('La Shortcodes', 'admin-view', 'camille'),
                'shortcodes' => array(
                    array(
                        'name'      => 'la_text',
                        'title'     => esc_html_x('Custom Text', 'admin-view', 'camille'),
                        'fields'    => array(
                            array(
                                'id'    => 'color',
                                'type'  => 'color_picker',
                                'title' => esc_html_x('Color', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'font_size',
                                'type'      => 'responsive',
                                'title'     => esc_html_x('Font Size', 'admin-view', 'camille'),
                                'desc'      => esc_html_x('Enter the font size (ie 20px )', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'line_height',
                                'type'      => 'responsive',
                                'title'     => esc_html_x('Line Height', 'admin-view', 'camille'),
                                'desc'      => esc_html_x('Enter the line height (ie 20px )', 'admin-view', 'camille')
                            ),
                            array(
                                'id'    => 'el_class',
                                'type'  => 'text',
                                'title' => esc_html_x('Extra Class Name', 'admin-view', 'camille')
                            ),
                            array(
                                'id'    => 'content',
                                'type'  => 'textarea',
                                'title' => esc_html_x('Content', 'admin-view', 'camille')
                            )
                        )
                    ),
                    array(
                        'name'      => 'la_btn',
                        'title'     => esc_html_x('Button', 'admin-view', 'camille'),
                        'fields'    => array(
                            array(
                                'id'    => 'title',
                                'type'  => 'text',
                                'title' => esc_html_x('Text', 'admin-view', 'camille'),
                                'default' => esc_html_x('Text on the button', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'link',
                                'type'      => 'fieldset',
                                'title'     => esc_html_x('URL (Link)', 'admin-view', 'camille'),
                                'desc'      => esc_html_x('Add link to button.', 'admin-view', 'camille'),
                                'before'    => '<div data-parent-atts="1" data-atts="link" data-atts-separator="|">',
                                'after'     => '</div>',
                                'fields'    => array(
                                    array(
                                        'id'    => 'url',
                                        'type'  => 'text',
                                        'title' => esc_html_x('URL', 'admin-view', 'camille'),
                                        'default' => '#',
                                        'attributes' => array(
                                            'data-child-atts' => 'url'
                                        )
                                    ),
                                    array(
                                        'id'    => 'title',
                                        'type'  => 'text',
                                        'title' => esc_html_x('Link Text', 'admin-view', 'camille'),
                                        'attributes' => array(
                                            'data-child-atts' => 'title'
                                        )
                                    ),
                                    array(
                                        'id'        => 'target',
                                        'type'      => 'radio',
                                        'default'   => '_self',
                                        'class'     => 'la-radio-style',
                                        'title'     => esc_html_x('Open link in a new tab', 'admin-view', 'camille'),
                                        'options'   => array(
                                            '_self' => esc_html_x('No', 'admin-view', 'camille'),
                                            '_blank' => esc_html_x('Yes', 'admin-view', 'camille')
                                        ),
                                        'attributes' => array(
                                            'data-child-atts' => 'target',
                                            'data-check' => 'yes'
                                        )
                                    ),
                                ),
                            ),

                            array(
                                'id'    => 'style',
                                'type'  => 'select',
                                'title' => esc_html_x('Style', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select button display style.', 'admin-view', 'camille'),
                                'options'        => array(
                                    'flat'          => esc_html_x('Flat', 'admin-view', 'camille'),
                                    'outline'       => esc_html_x('Outline', 'admin-view', 'camille'),
                                ),
                                'default' => 'flat'
                            ),
                            array(
                                'id'    => 'border_width',
                                'type'  => 'select',
                                'title' => esc_html_x('Border width', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select border width.', 'admin-view', 'camille'),
                                'options'        => array(
                                    '0'       => esc_html_x('None', 'admin-view', 'camille'),
                                    '1'       => esc_html_x('1px', 'admin-view', 'camille'),
                                    '2'       => esc_html_x('2px', 'admin-view', 'camille'),
                                    '3'       => esc_html_x('3px', 'admin-view', 'camille')
                                ),
                                'default' => 'square'
                            ),
                            array(
                                'id'    => 'shape',
                                'type'  => 'select',
                                'title' => esc_html_x('Shape', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select button shape.', 'admin-view', 'camille'),
                                'options'        => array(
                                    'rounded'   => esc_html_x('Rounded', 'admin-view', 'camille'),
                                    'square'    => esc_html_x('Square', 'admin-view', 'camille'),
                                    'round'     => esc_html_x('Round', 'admin-view', 'camille')
                                ),
                                'default' => 'square'
                            ),
                            array(
                                'id'    => 'color',
                                'type'  => 'select',
                                'title' => esc_html_x('Color', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select button color.', 'admin-view', 'camille'),
                                'options'        => array(
                                    'black'      => esc_html_x('Black', 'admin-view', 'camille'),
                                    'primary'    => esc_html_x('Primary', 'admin-view', 'camille'),
                                    'white'      => esc_html_x('White', 'admin-view', 'camille'),
                                    'white2'     => esc_html_x('White2', 'admin-view', 'camille'),
                                    'gray'       => esc_html_x('Gray', 'admin-view', 'camille'),
                                ),
                                'default' => 'black'
                            ),
                            array(
                                'id'    => 'size',
                                'type'  => 'select',
                                'title' => esc_html_x('Size', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select button display size.', 'admin-view', 'camille'),
                                'options'        => array(
                                    'md'    => esc_html_x('Normal', 'admin-view', 'camille'),
                                    'lg'    => esc_html_x('Large', 'admin-view', 'camille'),
                                    'sm'    => esc_html_x('Small', 'admin-view', 'camille'),
                                    'xs'    => esc_html_x('Mini', 'admin-view', 'camille')
                                ),
                                'default' => 'md'
                            ),
                            array(
                                'id'    => 'align',
                                'type'  => 'select',
                                'title' => esc_html_x('Alignment', 'admin-view', 'camille'),
                                'desc'  => esc_html_x('Select button alignment.', 'admin-view', 'camille'),
                                'options'        => array(
                                    'inline'    => esc_html_x('Inline', 'admin-view', 'camille'),
                                    'left'      => esc_html_x('Left', 'admin-view', 'camille'),
                                    'right'     => esc_html_x('Right', 'admin-view', 'camille'),
                                    'center'    => esc_html_x('Center', 'admin-view', 'camille')
                                ),
                                'default' => 'left'
                            ),
                            array(
                                'id'    => 'el_class',
                                'type'  => 'text',
                                'title' => esc_html_x('Extra Class Name', 'admin-view', 'camille'),
                                'desc' => esc_html_x('Style particular content element differently - add a class name and refer to it in custom CSS.', 'admin-view', 'camille')
                            )
                        )
                    ),
                    array(
                        'name'      => 'la_dropcap',
                        'title'     => esc_html_x('DropCap', 'admin-view', 'camille'),
                        'fields'    => array(
                            array(
                                'id'    => 'style',
                                'type'  => 'select',
                                'title' => esc_html_x('Design', 'admin-view', 'camille'),
                                'options'        => array(
                                    '1'          => esc_html_x('Style 1', 'admin-view', 'camille')
                                )
                            ),
                            array(
                                'id'    => 'color',
                                'type'  => 'color_picker',
                                'title' => esc_html_x('Text Color', 'admin-view', 'camille')
                            ),
                            array(
                                'id'    => 'content',
                                'type'  => 'text',
                                'title' => esc_html_x('Content', 'admin-view', 'camille')
                            )
                        )
                    ),
                    array(
                        'name'      => 'la_quote',
                        'title'     => esc_html_x('Custom Quote', 'admin-view', 'camille'),
                        'fields'    => array(
                            array(
                                'id'    => 'style',
                                'type'  => 'select',
                                'title' => esc_html_x('Design', 'admin-view', 'camille'),
                                'options'        => array(
                                    '1'          => esc_html_x('Style 1', 'admin-view', 'camille'),
                                    '2'          => esc_html_x('Style 2', 'admin-view', 'camille'),
                                    '3'          => esc_html_x('Style 3', 'admin-view', 'camille')
                                )
                            ),
                            array(
                                'id'    => 'author',
                                'type'  => 'text',
                                'title' => esc_html_x('Source Name', 'admin-view', 'camille')
                            ),
                            array(
                                'id'    => 'link',
                                'type'  => 'text',
                                'title' => esc_html_x('Source Link', 'admin-view', 'camille')
                            ),
                            array(
                                'id'    => 'content',
                                'type'  => 'textarea',
                                'title' => esc_html_x('Content', 'admin-view', 'camille')
                            )
                        )
                    ),
                    array(
                        'name'          => 'la_icon_list',
                        'title'         => esc_html_x('Icon List', 'admin-view', 'camille'),
                        'view'          => 'clone',
                        'clone_id'      => 'la_icon_list_item',
                        'clone_title'   => esc_html_x('Add New', 'admin-view', 'camille'),
                        'fields'        => array(
                            array(
                                'id'        => 'el_class',
                                'type'      => 'text',
                                'title'     => esc_html_x('Extra Class', 'admin-view', 'camille'),
                                'desc'      => esc_html_x('Style particular content element differently - add a class name and refer to it in custom CSS.', 'admin-view', 'camille'),
                            )
                        ),
                        'clone_fields'  => array(
                            array(
                                'id'        => 'icon',
                                'type'      => 'icon',
                                'default'   => 'fa fa-check',
                                'title'     => esc_html_x('Icon', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'icon_color',
                                'type'      => 'color_picker',
                                'title'     => esc_html_x('Icon Color', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'content',
                                'type'      => 'textarea',
                                'title'     => esc_html_x('Content', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'el_class',
                                'type'      => 'text',
                                'title'     => esc_html_x('Extra Class', 'admin-view', 'camille'),
                                'desc'     => esc_html_x('Style particular content element differently - add a class name and refer to it in custom CSS.', 'admin-view', 'camille'),
                            )
                        )
                    ),
                )
            );
            LaStudio_Shortcode_Manager::instance( $options );
        }
    }

    public function override_customize_control( $wp_customize ) {
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('header_image');
        $wp_customize->remove_section('background_image');
        $wp_customize->remove_control('display_header_text');
        $wp_customize->remove_control('site_icon');
    }

}