<?php

/**
 * Plugin Name: Mykd Core
 * Description: Mykd elementor core plugin.
 * Plugin URI:  https://themedox.com/
 * Version:     1.2
 * Author:      ThemeDox
 * Author URI:  https://themedox.com/
 * Text Domain: genixcore
 * Elementor tested up to: 3.50.2
 * Elementor Pro tested up to: 3.50.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Controls_Manager;

/**
 * Define
*/
define('GENIXCORE_ADDONS_URL', plugins_url('/', __FILE__));
define('GENIXCORE_ADDONS_DIR', dirname(__FILE__));
define('GENIXCORE_ADDONS_PATH', plugin_dir_path(__FILE__));
define('GENIXCORE_ELEMENTS_PATH', GENIXCORE_ADDONS_DIR . '/include/elementor');
define('GENIXCORE_WIDGET_PATH', GENIXCORE_ADDONS_DIR . '/include/widgets');
define('GENIXCORE_INCLUDE_PATH', GENIXCORE_ADDONS_DIR . '/include');


/**
 * Include all files
*/
include_once(GENIXCORE_ADDONS_DIR . '/include/custom-post-services.php');
include_once(GENIXCORE_ADDONS_DIR . '/include/common-functions.php');
include_once(GENIXCORE_ADDONS_DIR . '/include/class-ocdi-importer.php');
include_once(GENIXCORE_ADDONS_DIR . '/include/allow-svg.php');


/**
 * Genix Custom Widget
*/
include_once(GENIXCORE_WIDGET_PATH . '/genix-blog-post-sidebar.php');
include_once(GENIXCORE_WIDGET_PATH . '/genix-info-widget.php');

if ( class_exists('Charitable_Campaign' ) ) {
	include_once(GENIXCORE_WIDGET_PATH . '/genix-donation-post.php');
}



/**
 * shortCode supports for removing extra p, span etc
 *
 */
add_filter( 'the_content', 'mykd_shortcode_extra_content_remove' );
/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortCode.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */
function mykd_shortcode_extra_content_remove( $content ) {

    $array = [
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']',
    ];
    return strtr( $content, $array );

}

/**
 * Plugin Textdomain
 *
 */
function mykd_plugin_textdomain() {
    load_plugin_textdomain('genixcore', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'mykd_plugin_textdomain');


/**
 * Main Genix Core Class
 *
 * The init class that runs the Hello World plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Genix_Core {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}


		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'genixcore' ),
			'<strong>' . esc_html__( 'Mykd Core', 'genixcore' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'genixcore' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'genixcore' ),
			'<strong>' . esc_html__( 'Mykd Core', 'genixcore' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'genixcore' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'genixcore' ),
			'<strong>' . esc_html__( 'Mykd Core', 'genixcore' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'genixcore' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Genix_Core.
new Genix_Core();