<?php
/**
 * Awesomesauce class.
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

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();


class CerTable extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'awesomesauce', plugins_url( '/assets/css/awesomesauce.css', CER_PLUGIN_PATH ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'جدول نرخ ارز گمرکی';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return 'جدول نرخ ارز گمرکی';
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'cer' );
	}
	
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'awesomesauce' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'setting', 'elementor-awesomesauce' ),
			)
		);

		$this->add_control(
			'copyRight',
			array(
				'label'   => __( 'Copyright', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'اطلاعات زیر به صورت خودکار از <a href="https://irica.ir/web_directory/54345-%D9%86%D8%B1%D8%AE-%D8%A7%D8%B1%D8%B2.html">سایت گمرک جمهوری اسلامی</a> ایران گردآوری شده است', 'elementor-awesomesauce' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'copyRight', 'none' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'copyRight' ); ?>><?php echo wp_kses( $settings['copyRight'], array() ); ?></div>
		<table>
		<tr>
			<th>واحد پولی</th>
			<th>نرخ ارز</th>
		</tr>
		<?php
			$cache = \Mhmmdq\Wordpress\Cer\Scraper::getCache()['data'];
			
			for($i=3;$i <= count($cache);$i++):
		?>
			<tr>
				<td><?=$cache[$i++]?></td>
				<td><?=$cache[$i]?></td>
			</tr>
		<?php
			endfor;
		?>
		</table>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes( 'copyRight', 'none' );
		#>
		<div {{{ view.getRenderAttributeString( 'copyRight' ) }}}>{{{ settings.title }}}</div>
		<?php
	}
}
