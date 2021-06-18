<?php if ( ! defined( 'ABSPATH' ) ) { die; }

if(!class_exists('Camille_MegaMenu_Init')){
    
    class Camille_MegaMenu_Init{

        protected $fields = array();

        protected $default_metakey = '';

        public function __construct() {

            $query_args = array(
                'post_type'         => 'la_block',
                'orderby'           => 'title',
                'order'             => 'ASC',
                'posts_per_page'    => 20
            );

            $this->default_metakey = '_mm_meta';
            $this->fields = array(
                'icon' => array(
                    'id'    => 'icon',
                    'type'  => 'icon',
                    'title' => esc_html__('Custom Icon','camille')
                ),
                'nolink' => array(
                    'id'    => 'nolink',
                    'type'  => 'switcher',
                    'title' => esc_html__("Don't link",'camille')
                ),
                'only_icon' => array(
                    'id'    => 'only_icon',
                    'type'  => 'switcher',
                    'title' => esc_html__("Show Only Icon",'camille')
                ),
                'hide' => array(
                    'id'    => 'hide',
                    'type'  => 'switcher',
                    'title' => esc_html__("Don't show a link",'camille')
                ),
                'menu_type' => array(
                    'id'    => 'menu_type',
                    'type'  => 'select',
                    'title' => esc_html__('Menu Type','camille'),
                    'options' => array(
                        'narrow'      => esc_html__('Narrow','camille'),
                        'wide'  => esc_html__('Wide','camille')
                    ),
                    'default' => 'narrow'
                ),
                'submenu_position' => array(
                    'id'    => 'submenu_position',
                    'type'  => 'select',
                    'title' => esc_html__('SubMenu Position','camille'),
                    'info' => esc_html__('Apply for parent with "Menu Type" is "narrow"','camille'),
                    'options' => array(
                        'right'     => esc_html__('Right','camille'),
                        'left'      => esc_html__('Left','camille'),
                    ),
                    'default'   => 'right'
                ),
                'force_full_width' => array(
                    'id'    => 'force_full_width',
                    'type'  => 'switcher',
                    'title' => esc_html__('Force Full Width','camille'),
                    'info' => esc_html__('Set 100% window width for popup','camille')
                ),
                'popup_max_width' => array(
                    'id'    => 'popup_max_width',
                    'type'  => 'number',
                    'title' => esc_html__('Popup Max Width','camille'),
                    'after' => 'px',
                    'wrap_class' => 'la-element-popup-max-width'
                ),
                'popup_column' => array(
                    'id'    => 'popup_column',
                    'type'  => 'select',
                    'title' => esc_html__('Popup Columns','camille'),
                    'options' => array(
                        '1'         => esc_html__('1 Column','camille'),
                        '2'         => esc_html__('2 Columns','camille'),
                        '3'         => esc_html__('3 Columns','camille'),
                        '4'         => esc_html__('4 Columns','camille'),
                        '5'         => esc_html__('5 Columns','camille'),
                        '6'         => esc_html__('6 Columns','camille')
                    ),
                    'default'   => '4'
                ),
                'item_column' => array(
                    'id'    => 'item_column',
                    'type'  => 'text',
                    'title' => esc_html__('Columns','camille'),
                    'desc' => esc_html__('will occupy x columns of parent popup columns', 'camille')
                ),
                'block' => array(
                    'id'            => 'block',
                    'type'           => 'select',
                    'title'         => esc_html__('Custom Block Before Menu Item','camille'),
                    'options'       => 'posts',
                    'query_args'    => $query_args,
                    'default_option' => esc_html__('Select a block','camille')
                ),
                'block2' => array(
                    'id'            => 'block2',
                    'type'          => 'select',
                    'title'         => esc_html__('Custom Block After Menu Item','camille'),
                    'options'       => 'posts',
                    'query_args'    => $query_args,
                    'default_option' => esc_html__('Select a block','camille')
                ),
                'popup_background' => array(
                    'id'           => 'popup_background',
                    'type'         => 'background',
                    'title' 	   => esc_html__('Popup Background','camille')
                ),
                'tip_label' => array(
                    'id'        => 'tip_label',
                    'type'      => 'text',
                    'title' 	=> esc_html__('Tip Label','camille')
                ),
                'tip_color' => array(
                    'id'        => 'tip_color',
                    'type'      => 'color_picker',
                    'title' 	=> esc_html__('Tip Color','camille')
                ),
                'tip_background_color' => array(
                    'id'        => 'tip_background_color',
                    'type'      => 'color_picker',
                    'title' 	=> esc_html__('Tip Background','camille')
                )
            );

            $this->load_hooks();
        }

        private function load_hooks(){
            add_action( 'wp_loaded',                        array( $this, 'load_walker_edit' ), 9);
            add_filter( 'wp_setup_nav_menu_item',           array( $this, 'setup_nav_menu_item' ));
            add_action( 'wp_nav_menu_item_custom_fields',   array( $this, 'add_megamu_field_to_menu_item' ), 10, 4);
            add_action( 'wp_update_nav_menu_item',          array( $this, 'update_nav_menu_item' ), 10, 3);
            add_filter( 'nav_menu_item_title',              array( $this, 'add_icon_to_menu_item' ),10, 4);
            add_filter( 'nav_menu_css_class',               array( $this, 'nav_menu_css_class' ),10, 4);
        }

        public function load_walker_edit() {
            add_filter( 'wp_edit_nav_menu_walker', array( $this, 'detect_edit_nav_menu_walker' ), 99 );
        }

        public function detect_edit_nav_menu_walker( $walker ) {
            $walker = 'Camille_MegaMenu_Walker_Edit';
            return $walker;
        }

        public function setup_nav_menu_item($menu_item){
            $meta_value = Camille()->settings()->get_post_meta($menu_item->ID, '', $this->default_metakey, true);
            foreach ( $this->fields as $key => $value ){
                $menu_item->$key = isset($meta_value[$key]) ? $meta_value[$key] : '';
            }
            return $menu_item;
        }

        public function update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_args ) {
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                return;
            }
            check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

            $key = $this->default_metakey;

            if ( ! empty( $_POST[$key][$menu_item_db_id] ) ) {
                $value = $_POST[$key][$menu_item_db_id];
            }
            else {
                $value = null;
            }

            if(!empty($value)){
                update_post_meta( $menu_item_db_id, $key, $value );
            }
            else {
                delete_post_meta( $menu_item_db_id, $key );
            }
        }

        public function add_megamu_field_to_menu_item( $id, $item, $depth, $args ) {
            if(function_exists('la_fw_add_element')){
                ?><div class="lastudio-megamenu-settings description-wide la-content">
                <h3><?php esc_html_e('MegaMenu Settings','camille');?></h3>
                <div class="lastudio-megamenu-custom-fields">
                    <?php
                    foreach ( $this->fields as $key => $field ) {
                        $unique     = $this->default_metakey . '['.$item->ID.']';
                        $default    = ( isset( $field['default'] ) ) ? $field['default'] : '';
                        $elem_id    = ( isset( $field['id'] ) ) ? $field['id'] : '';

                        $field['name'] = $unique. '[' . $elem_id . ']';
                        $field['id'] = $elem_id . '_' . $item->ID;
                        $elem_value =  isset($item->$key) ? $item->$key : $default;
                        echo la_fw_add_element( $field, $elem_value, $unique );
                    }
                    ?>
                </div>
                </div><?php
            }
        }

        public function add_icon_to_menu_item($output, $item, $args, $depth){
            if ( !is_a( $args->walker, 'Camille_MegaMenu_Walker' ) && $item->icon){
                $icon_class = 'mm-icon ' . $item->icon;
                $icon = "<i class=\"".esc_attr($icon_class)."\"></i>";
                $output = $icon . $output;
            }
            return $output;
        }

        public function nav_menu_css_class( $classes, $item, $args, $depth ){
            if(!is_a( $args->walker, 'Camille_MegaMenu_Walker' )){
                if ( $item->hide ) {
                    $classes[] = "mm-item-hide";
                }
                if ( $item->nolink ) {
                    $classes[] = "mm-item-nolink";
                }
                if ( $item->only_icon ) {
                    $classes[] = "mm-item-onlyicon";
                }
            }
            return $classes;
        }
    }
}