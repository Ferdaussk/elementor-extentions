<?php
namespace entextNamEelementorPlugiN;

use entextNamEelementorPlugiN\PageSettings\Page_Settings;
use Elementor\Controls_Manager;

define( "__ASS_PUBLIC__", plugin_dir_url( __FILE__ ) . "assets/public" );
define( "ENTEXT_ASFSK_ASSETS_ADMIN_DIR_FILE", plugin_dir_url( __FILE__ ) . "assets/admin" );

class ClassENTEXTElementorP {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function entext_all_assets_for_the_public(){
        $all_css_js_file = array(
            'entext-filterable-main-4script' => array('entext_path_define'=>__ASS_PUBLIC__ . '/wrapper-link.min.js'),
        );
        foreach($all_css_js_file as $handle => $fileinfo){
            wp_enqueue_script( $handle, $fileinfo['entext_path_define'], ['jquery'], '1.0', true);
        }
    }

    public function sk_before_render( $element ) {
        $test_here = $element->get_settings_for_display( 'entext_add_tooltip' );
        echo $test_here;
    }

    public function sk_register_controls( $element ) {
        $element->start_controls_section(
            'entext_extensions_section',
            [
                'label' => __( 'Test control', 'elementor-extention' ),
                'tab'   => Controls_Manager::TAB_ADVANCED
            ]
        );

        $element->add_control(
            'entext_add_tooltip',
            [
                'label'     => __( 'Text', 'elementor-extention' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Your Text Here', 'elementor-extention' ),
                'dynamic'   => [
                    'active' => true,
                ],
            ]
        );

        $element->end_controls_section();
    }

    public function __construct() {
        add_action( 'elementor/frontend/before_render', [ $this, 'sk_before_render' ], 1 );
        add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'sk_register_controls' ] );
        add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'sk_register_controls' ] );
        add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'sk_register_controls' ] );
        add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'sk_register_controls' ] );

        add_action('wp_enqueue_scripts', [$this, 'entext_all_assets_for_the_public']);
    }
}

// Instantiate Plugin Class
ClassENTEXTElementorP::instance();
