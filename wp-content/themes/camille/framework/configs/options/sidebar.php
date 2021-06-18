<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Sidebar settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function camille_options_section_sidebar( $sections )
{
    $sections['sidebar'] = array(
        'name'          => 'sidebar_panel',
        'title'         => esc_html_x('Sidebars', 'admin-view', 'camille'),
        'icon'          => 'fa fa-exchange',
        'sections' => array(
            array(
                'name'      => 'sidebar_add_section',
                'title'     => esc_html_x('Add Sidebar', 'admin-view', 'camille'),
                'icon'      => 'fa fa-plus',
                'fields'    => array(
                    array(
                        'id'        => 'add_sidebars',
                        'type'      => 'group',
                        'title'     => esc_html_x('Add New Sidebar', 'admin-view', 'camille'),
                        'button_title'    => esc_html_x('Add','admin-view', 'camille'),
                        'accordion_title' => 'sidebar_id',
                        'fields'    => array(
                            array(
                                'id'        => 'sidebar_id',
                                'type'      => 'text',
                                'default'   => esc_html_x('Sidebar ID', 'admin-view', 'camille'),
                                'title'     => esc_html_x('Title', 'admin-view', 'camille')
                            ),
                            array(
                                'id'        => 'sidebar_desc',
                                'type'      => 'text',
                                'title'     => esc_html_x('Description', 'admin-view', 'camille')
                            )
                        )
                    )
                )
            ),
            array(
                'name'      => 'sidebar_page_panel',
                'title'     => esc_html_x('Pages', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'pages_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global Page Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all pages.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'pages_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Pages', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all pages. This option overrides the page options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_portfolio_posts_panel',
                'title'     => esc_html_x('Portfolio Posts', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'portfolio_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global Portfolio Post Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all portfolio posts.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'portfolio_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Portfolio Posts', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all portfolio posts. This option overrides the portfolio post options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_portfolio_archive_panel',
                'title'     => esc_html_x('Portfolio Archive', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'portfolio_archive_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global Portfolio Archive Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all portfolio archive & taxonomy.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'portfolio_archive_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Portfolio Archive', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all portfolio archive & taxonomy. This option overrides the portfolio options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_posts_panel',
                'title'     => esc_html_x('Blog Posts', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'posts_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global Blog Post Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all blog posts.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'posts_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Blog Posts', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all blog posts. This option overrides the blog post options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_blog_post_panel',
                'title'     => esc_html_x('Blog Archive', 'admin-view', 'camille'),
                'fields'    => array(

                    array(
                        'id'             => 'blog_archive_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global Blog Archive Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all post category & tag.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'blog_archive_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Blog Archive', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all post category & tag. This option overrides the posts options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_search_panel',
                'title'     => esc_html_x('Search Page', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'search_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Search Page Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on the search results page.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_products_panel',
                'title'     => esc_html_x('WooCommerce Products', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'products_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global WooCommerce Product Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all WooCommerce products.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'products_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For WooCommerce Products', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all WooCommerce products. This option overrides the WooCommerce post options.', 'admin-view', 'camille')
                    )
                )
            ),
            array(
                'name'      => 'sidebar_shop_panel',
                'title'     => esc_html_x('WooCommerce Archive', 'admin-view', 'camille'),
                'fields'    => array(
                    array(
                        'id'             => 'shop_sidebar',
                        'type'           => 'select',
                        'title'          => esc_html_x('Global WooCommerce Archive Sidebar', 'admin-view', 'camille'),
                        'desc'           => esc_html_x('Select sidebar that will display on all WooCommerce taxonomy.', 'admin-view', 'camille'),
                        'class'          => 'chosen',
                        'options'        => 'sidebars',
                        'default_option' => esc_html_x('None', 'admin-view', 'camille')
                    ),
                    array(
                        'id'        => 'shop_global_sidebar',
                        'type'      => 'switcher',
                        'default'   => false,
                        'title'     => esc_html_x('Activate Global Sidebar For Woocommerce Archive', 'admin-view', 'camille'),
                        'desc'      => esc_html_x('Turn on if you want to use the same sidebars on all WooCommerce archive( shop,category,tag,search ). This option overrides the WooCommerce taxonomy options.', 'admin-view', 'camille')
                    )
                )
            )
        )
    );
    return $sections;
}