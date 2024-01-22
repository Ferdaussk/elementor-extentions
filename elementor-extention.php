<?php
/**
 * Plugin Name: Elementor Extention
 * Description: Craft seamless, interactive elementor-extentions with Elementor using the versatile elementor-extention Forge plugin.
 * Plugin URI:  https://bestwpdeveloper.com/elementor-extention
 * Version:     1.0
 * Author:      Best WP Developer
 * Author URI:  https://bestwpdeveloper.com/
 * Text Domain: elementor-extention
 * Elementor tested up to: 3.13.4
 * Elementor Pro tested up to: 3.13.2
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define("entext_THE_PLUGIN_FILE", __FILE__);
require_once ( plugin_dir_path(entext_THE_PLUGIN_FILE) ) . '/includes/requires-check.php';
final class entextElementorPlugiN {
	const VERSION = '1.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	public function __construct() {
		add_action( 'entext_init', array( $this, 'entext_loaded_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'entext_init' ) );
	}

	public function entext_loaded_textdomain() {
		load_plugin_textdomain( 'elementor-extention', false, basename(dirname(__FILE__)).'/languages' );
	}

	public function entext_init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', 'entext_register_required_plugins');
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'entext_admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'entext_admin_notice_minimum_php_version' ) );
			return;
		}
		require_once( 'entext-boots.php' );
	}

	public function entext_admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-extention' ),
			'<strong>' . esc_html__( 'Elementor Extention', 'elementor-extention' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-extention' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>' . esc_html__('%1$s', 'elementor-extention') . '</p></div>', $message );
	}

	public function entext_admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-extention' ),
			'<strong>' . esc_html__( 'Elementor Extention', 'elementor-extention' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-extention' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>' . esc_html__('%1$s', 'elementor-extention') . '</p></div>', $message );
	}
}

// Instantiate elementor-extention.
new entextElementorPlugiN();
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );