<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    customs exchange rate
 * @subpackage WordPress
 * @author     Mhmmdq <mhmmdq@mhmmdq.ir>
 * @copyright  2020 Mhmmmdqasemi
 * @license    MIT
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace Mhmmdq\Wordpress\Cer\Widgets;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once 'CerTable.php';
		require_once 'CerItem.php';
	}

	public function add_elementor_widget_categories($elements_manager) {
		$elements_manager->add_category(
			'cer',
			[
				'title' => __( 'customs exchange rate', 'customs-exchange-rate' ),
				'icon' => 'fa fa-plug',
			]
		);
	}
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CerTable() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CerItem() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', array($this , 'add_elementor_widget_categories') );

		// Register the widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

	}
}

// Instantiate the Widgets class.
Widgets::instance();
