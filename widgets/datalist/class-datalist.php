<?php

/**
 * Datalist class.
 *
 * @category   Class
 * @package    ElephantAddons
 * @subpackage WordPress
 * @author     Samuel Prado Almeida <samuelprado.a@gmail.com>
 * @copyright  2022 Samuel Prado Almeida
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://github.com/worldvisual/elementor-elephant-addons,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace ElephantAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined('ABSPATH') || die();

class Datalist extends Widget_Base
{
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct($data = array(), $args = null)
	{
		parent::__construct($data, $args);

		wp_register_style('datalist-css', plugins_url('assets/css/datalist/bootstrap.min.css', ELEPHANT_ADDONS));
		wp_register_style('datalist-custom', plugins_url('assets/css/datalist/datalist.css', ELEPHANT_ADDONS));
		wp_register_script('datalist-js', plugins_url('assets/js/datalist/datalist.js', ELEPHANT_ADDONS));
	}

	/**
	 * Enqueue scripts.
	 */
	public function get_script_depends()
	{
		return [
			'datalist-js'
		];
	}

	/**
	 * Enqueue styles.
	 */
	public function get_style_depends()
	{
		return [
			'datalist-css',
			'datalist-custom'
		];
	}

	public function get_name()
	{
		return 'Elephant Datalist';
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
	public function get_title()
	{
		return __('Elephant Datalist', ELEPHANT);
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
	public function get_icon()
	{
		return 'eicon-editor-list-ol';
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
	public function get_categories()
	{
		return array('general');
	}

	public function get_elementor_page_list()
	{

		$pagelist = get_posts(
			array(
				'post_type' => 'elementor_library',
				'showposts' => 999,
			)
		);

		if (!empty($pagelist) && !is_wp_error($pagelist)) {

			foreach ($pagelist as $post) {
				$options[$post->post_title] = $post->post_title;
			}

			update_option('temp_count', $options);

			return $options;
		}
	}

	protected function register_controls()
	{


		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - LIST
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'width',
			[
				'label' => esc_html__('Width', ELEPHANT),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - INPUT
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'list_input_placeholder',
			[
				'label' => esc_html__('Input Placeholder', ELEPHANT),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Procurar organização...', ELEPHANT),
				'label_block' => true,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - ICON
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'icon',
			[
				'label' => esc_html__('Icon', ELEPHANT),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - TEXT
		|--------------------------------------------------------------------------
		*/

		$repeater->add_control(
			'carousel',
			array(
				'label'       => __('OR Select Existing Template', ELEPHANT),
				'type'        => Controls_Manager::SELECT2,
				'classes'     => 'premium-live-temp-label',
				'label_block' => true,
				'separator'   => 'after',
				'options'     => ['teste', 'teste1'],
			)
		);

		$repeater->add_control(
			'width',
			[
				'label' => esc_html__('Width', ELEPHANT),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);



		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__('Title', ELEPHANT),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('List Title', ELEPHANT),
				'label_block' => true,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - URL
		|--------------------------------------------------------------------------
		*/
		$repeater->add_control(
			'list_url',
			[
				'label' => esc_html__('Link', ELEPHANT),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', ELEPHANT),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
					'custom_attributes' => '',
				],
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| CONTENT SECTION - REPEATER
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'list',
			[
				'label' => esc_html__('Data List Itens', ELEPHANT),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__('Title #1 ', ELEPHANT),
						'list_url' => esc_html__('#', ELEPHANT)
					],
					[
						'list_title' => esc_html__('Title #2', ELEPHANT),
						'list_url' => esc_html__('#', ELEPHANT)
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		//============================== END SECTION
		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - List
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'list_style',
			[
				'label' => esc_html__('Lista', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - COLOR
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'list_color',
			[
				'label' => esc_html__('Cor do Texto', ELEPHANT),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-color' => 'color: {{VALUE}}',
				],
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - FONT
		|--------------------------------------------------------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Fonte', ELEPHANT),
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .heading-class',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BORDER
		|--------------------------------------------------------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__('Border', ELEPHANT),
				'selector' => '{{WRAPPER}} .datalist-border',
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BORDER RADIUS
		|--------------------------------------------------------------------------
		*/
		$this->add_responsive_control(
			'list_border_radius',
			array(
				'label'      => esc_html__('Border Radius', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .datalist-border' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		//============================== END SECTION
		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - INPUT
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'input_style',
			[
				'label' => esc_html__('Input', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BACKGROUND COLOR
		|--------------------------------------------------------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__('Background', ELEPHANT),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .datalist-input-background',
			]
		);

		//============================== END SECTION
		$this->end_controls_section();

		$this->start_controls_section(
			'box_list_style',
			[
				'label' => esc_html__('Box', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BACKGROUND COLOR
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'box_bg',
			array(
				'label'     => esc_html__('Box Background Color', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .datalist-box-bg' => 'background-color: {{VALUE}}',
				),
			)
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BORDER
		|--------------------------------------------------------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'box-border',
				'label' => esc_html__('Box Border', ELEPHANT),
				'selector' => '{{WRAPPER}} .datalist-box-border',
				'separator'  => 'before'
			)
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BORDER RADIUS
		|--------------------------------------------------------------------------
		*/
		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__('Box Border Radius', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .datalist-box-border-rd' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - PADDING
		|--------------------------------------------------------------------------
		*/
		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__('Box Padding', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors'  => array(
					'{{WRAPPER}} .datalist-box-padding' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - MIN-HEIGHT
		|--------------------------------------------------------------------------
		*/
		$this->add_responsive_control(
			'box-max_height',
			array(
				'label'       => esc_html__('Box Min Heigth - PX', ELEPHANT),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} .datalist-box' => 'min-height: {{VALUE}}px;',
				),
				'separator'  => 'before'
			)
		);

		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - BACKGROUND COLOR
		|--------------------------------------------------------------------------
		*/
		$this->add_control(
			'box_scroll_bg',
			array(
				'label'     => esc_html__('Box Scroll Color', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .box-scroll::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}',
				),
				'separator'  => 'before'
			)
		);

		//============================== END SECTION
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if ($settings['list']) { ?>

			<?php
			echo '<pre>';
			print_r($settings['carousel']);
			echo '</pre>';
			?>

			<div class="input-group mb-2">
				<div class="my-icon-wrapper d-flex align-items-center">
					<div class="col-1"><?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?></div>
					<input type="text" class="col-11 datalist-input-background border-0" id="datalist" onkeyup="myFunction()" placeholder="<?php _e($settings['list_input_placeholder']) ?>">
				</div>
			</div>

			<div class="datalist-box-bg datalist-box-border datalist-box-border-rd datalist-box-padding">
				<div class="datalist-box-bg datalist-box-padding">
					<ul id="myUL" class="list-group box-scroll datalist-box">

						<?php

						foreach ($settings['list'] as $key => $item) { ?>

							<a href="<?php _e($item['list_url']['url']); ?>">
								<li class="list-group-item my-2 container title-color heading-class datalist-border">
									<div class="row">

										<div class="col-sm-1 col-xs-12 text-center">
											<?php _e($key + 1) ?>
										</div>

										<div class="col-sm-11 col-xs-12 text-center" id="list_title">
											<?php _e($item['list_title']) ?>
										</div>

									</div>
								</li>
							</a>

						<?php  } ?>

					</ul>
				</div>

	<?php
		}
	}
}
