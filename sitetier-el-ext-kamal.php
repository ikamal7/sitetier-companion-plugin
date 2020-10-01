<?php
/**
 * Plugin Name: Sitetier Elementor Extension By Kamal
 * Description: Sitetier Elementor Extension By Kamal
 * Plugin URI:  https://kamal.pw/
 * Version:     1.0.0
 * Author:      Kamal H.
 * Author URI:  https://kamal.pw/
 * Text Domain: stel
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Sitetier_Extension {

    /**
     * Plugin Version
     *
     * @var string The plugin version.
     * @since 1.0.0
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @var string Minimum Elementor version required to run the plugin.
     * @since 1.0.0
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @var string Minimum PHP version required to run the plugin.
     * @since 1.0.0
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @access private
     * @static
     * @var Elementor_Test_Extension The single instance of the class.
     * @since 1.0.0
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @access public
     * @static
     * @since 1.0.0
     *
     * @return Elementor_Test_Extension An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    /**
     * Constructor
     *
     * @access public
     * @since 1.0.0
     */
    public function __construct() {

        $this->define_constant();
        add_action( 'init', [$this, 'i18n'] );
        add_action( 'plugins_loaded', [$this, 'init'] );
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @access public
     * @since 1.0.0
     */
    public function i18n() {

        load_plugin_textdomain( 'stel' );

    }

    public function widget_styles(){
        wp_register_style( 'owl-carousel', plugin_dir_url( __FILE__ ).'/assets/css/owl.carousel.min.css' );
        wp_register_style( 'stel-style', plugin_dir_url( __FILE__ ).'/assets/css/stel-style.css' );
    }
     public function widget_scripts(){
        wp_register_script( 'owl-carousel', plugin_dir_url( __FILE__ ).'/assets/js/owl.carousel.min.js',[], '1.0.0', true );
        wp_register_script( 'stel-script', plugin_dir_url( __FILE__ ).'/assets/js/stel-script.js',[], '1.0.0', true );

    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @access public
     * @since 1.0.0
     */
    public function init() {

        // Check if Elementor installed and activated
        if ( !did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [$this, 'admin_notice_missing_main_plugin'] );
            return;
        }

        // Check for required Elementor version
        if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [$this, 'admin_notice_minimum_elementor_version'] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [$this, 'admin_notice_minimum_php_version'] );
            return;
        }
		add_action( 'elementor/frontend/after_register_scripts', [$this, 'widget_scripts'] );
		add_action( 'elementor/frontend/after_register_styles', [$this, 'widget_styles'] );


        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [$this, 'init_widgets'] );
        // add_action( 'elementor/controls/controls_registered', [$this, 'init_controls'] );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @access public
     * @since 1.0.0
     */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'stel' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'stel' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'stel' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @access public
     * @since 1.0.0
     */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'stel' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'stel' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'stel' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @access public
     * @since 1.0.0
     */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'stel' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'stel' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'stel' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @access public
     * @since 1.0.0
     */
    public function init_widgets() {

        // Include Widget files
        require_once __DIR__ . '/widgets/slider-widget.php';

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Slider_Widget() );

    }

    public function define_constant() {
        define( 'WPSC_VERSION', '1.0' );
        define( 'WPSC_FILE', __FILE__ );
        define( 'WPSC_PATH', __DIR__ );
        define( 'WPSC_URL', plugins_url( '', WPSC_FILE ) );
        define( 'WPSC_ASSETS', WPSC_URL . '/assets' );
        define( 'WPSC_ADMIN', WPSC_URL . '/admin' );
    }


}

Sitetier_Extension::instance();