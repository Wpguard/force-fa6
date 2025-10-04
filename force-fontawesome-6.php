<?php
/**
 * Plugin Name: Force FA6
 * Plugin URI:  https://yourwebsite.com/force-fontawesome-6
 * Description: Always load Font Awesome 6 globally and reduce Elementor icon conflicts. Provides filters and settings to change CDN/version or subsets.
 * Version:     1.1.0
 * Author:      Sanjida Afrin
 * Author URI:  https://yourwebsite.com
 * Text Domain: force-fontawesome-6
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

final class FF6_Force_FontAwesome {
	const VERSION = '1.1.0';
	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->hooks();
		}
		return self::$instance;
	}

	private function setup_constants() {
		define( 'FF6_PLUGIN_FILE', __FILE__ );
		define( 'FF6_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'FF6_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	private function includes() {
		require_once FF6_PLUGIN_DIR . 'includes/class-ff6-settings.php';
	}

	private function hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fontawesome' ), 99 );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_fontawesome' ), 99 );
		add_action( 'after_switch_theme', array( $this, 'enqueue_fontawesome' ) );
		add_action( 'upgrader_process_complete', array( $this, 'enqueue_fontawesome' ) );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'force-fontawesome-6', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	private function get_cdn_base() {
		$version = get_option( 'ff6_fa_version', '6.5.1' );
		return apply_filters( 'ff6_fa_cdn_base', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/' . $version . '/' );
	}

	public function enqueue_fontawesome() {
		if ( is_admin() && ! ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) ) {
			return;
		}

		// Remove Elementor FA
		foreach ( array( 'elementor-icons-fa-solid', 'elementor-icons-fa-regular', 'elementor-icons-fa-brands' ) as $h ) {
			if ( wp_style_is( $h, 'enqueued' ) || wp_style_is( $h, 'registered' ) ) {
				wp_dequeue_style( $h );
				wp_deregister_style( $h );
			}
		}

		$version = get_option( 'ff6_fa_version', '6.5.1' );
		$base    = $this->get_cdn_base();

		// Core is always loaded
		wp_enqueue_style( 'ff6-fontawesome-core', $base . 'css/fontawesome.min.css', array(), $version );

		// Subsets based on settings
		$load_solid  = get_option( 'ff6_load_solid', 'yes' );
		$load_brands = get_option( 'ff6_load_brands', 'yes' );

		if ( 'yes' === $load_solid ) {
			wp_enqueue_style( 'ff6-fontawesome-solid', $base . 'css/solid.min.css', array('ff6-fontawesome-core'), $version );
		}
		if ( 'yes' === $load_brands ) {
			wp_enqueue_style( 'ff6-fontawesome-brands', $base . 'css/brands.min.css', array('ff6-fontawesome-core'), $version );
		}
	}
}

FF6_Force_FontAwesome::instance();