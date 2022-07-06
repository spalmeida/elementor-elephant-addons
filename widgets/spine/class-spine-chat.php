<?php

/**
 * SpineChat class.
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

class SpineChat extends Widget_Base
{

	public function __construct($data = array(), $args = null)
	{
		parent::__construct($data, $args);

		/* css */
		wp_register_style('style-css', plugins_url('widgets/spine/assets/css/style.css', ELEPHANT_ADDONS));
		wp_register_style('animate-css', plugins_url('widgets/spine/assets/css/animate.min.css', ELEPHANT_ADDONS));

		/* js */
		wp_register_script('pixi-legacy-js', plugins_url('widgets/spine/assets/js/pixi-legacy.js', ELEPHANT_ADDONS));
		wp_register_script('pixi-spine-js', plugins_url('widgets/spine/assets/js/pixi-spine.js', ELEPHANT_ADDONS));
		wp_register_script('main-js', plugins_url('widgets/spine/assets/js/main.js', ELEPHANT_ADDONS));
	}

	public function get_script_depends()
	{
		return [
			'pixi-legacy-js',
			'pixi-spine-js',
			'main-js',
		];
	}

	public function get_style_depends()
	{
		return [
			'style-css',
			'animate-css'
		];
	}

	public function get_name()
	{
		return 'Elephant Spine';
	}

	public function get_title()
	{
		return __('Elephant Spine', ELEPHANT);
	}

	public function get_icon()
	{
		return 'eicon-testimonial';
	}

	public function get_categories()
	{
		return array('general');
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
				'label' => esc_html__('Spine Config', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* spine_url */
		$this->add_control(
			'spine_url',
			[
				'label' => esc_html__(
					'Spine URL JSON',
					ELEPHANT
				),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('/wp-content/plugins/elephant-chat-animated/spines/professor/Professor_Spine.json', ELEPHANT),
				'label_block' => true,
			]
		);

		/* spine_default_animation */
		$this->add_control(
			'spine_default_animation',
			[
				'label' => esc_html__('Animação Inicial', ELEPHANT),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'idle',
				'options' => [
					'Clic'  => esc_html__('Clic', ELEPHANT),
					'Clic_idle' => esc_html__('Clic_idle', ELEPHANT),
					'idle' => esc_html__('idle', ELEPHANT),
					'Volta' => esc_html__('Volta', ELEPHANT),
				],
				'description' => ' Clic | Clic_idle | idle | Volta ',
				'separator' => 'before',
			]
		);

		//============================== END SECTION
		$this->end_controls_section();

		/*
		|--------------------------------------------------------------------------
		| SECTION BOX
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'section_box',
			[
				'label' => esc_html__('Spine Box Links', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$repeater = new \Elementor\Repeater();

		/* icon */
		$repeater->add_control(
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

		/* list_title */
		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__('Title', ELEPHANT),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('List Title', ELEPHANT),
				'label_block' => true,
			]
		);

		/* list_url */
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

		/* list */
		$this->add_control(
			'list',
			[
				'label' => esc_html__('Box Links', ELEPHANT),
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
		| STYLE SECTION - Box Size
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'box_size',
			[
				'label' => esc_html__('Box Size ', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* spine_box_width */
		$this->add_responsive_control(
			'spine_box_width',
			[
				'label' => esc_html__(
					'Spine BOX WIDTH PX',
					ELEPHANT
				),
				'type' => Controls_Manager::NUMBER,
				'default' => 300,
				'label_block' => true,
				'separator' => 'before',
			]
		);

		/* spine_box_height */
		$this->add_responsive_control(
			'spine_box_height',
			[
				'label' => esc_html__(
					'Spine BOX HEIGHT PX',
					ELEPHANT
				),
				'type' => Controls_Manager::NUMBER,
				'default' => 300,
				'label_block' => true,
				'separator' => 'before',
			]
		);

		//============================== END SECTION
		$this->end_controls_section();


		/*
		|--------------------------------------------------------------------------
		| STYLE SECTION - Box Spine Position
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'box_spine_position',
			[
				'label' => esc_html__('Box Spine Position ', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* spine_position_x */
		$this->add_responsive_control(
			'spine_position_x',
			[
				'label' => esc_html__(
					'Spine POSITION X',
					ELEPHANT
				),
				'type' => Controls_Manager::NUMBER,
				'default' => 50,
				'label_block' => true,
				'separator' => 'before',
			]
		);

		/* spine_position_y */
		$this->add_responsive_control(
			'spine_position_y',
			[
				'label' => esc_html__(
					'Spine POSITION Y',
					ELEPHANT
				),
				'type' => Controls_Manager::NUMBER,
				'default' => 60,
				'label_block' => true,
				'separator' => 'before'
			]
		);

		//============================== END SECTION
		$this->end_controls_section();

		/*
        |--------------------------------------------------------------------------
        | STYLE SECTION - Box Spine Position
        |--------------------------------------------------------------------------
        */
		$this->start_controls_section(
			'box_spine_scale',
			[
				'label' => esc_html__('Box Spine Scale ', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		/* spine_scale */
		$this->add_responsive_control(
			'spine_scale',
			[
				'label' => esc_html__(
					'Spine Scale',
					ELEPHANT
				),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 0.1,
				'label_block' => true
			]
		);
		//============================== END SECTION
		$this->end_controls_section();


		/*
		|--------------------------------------------------------------------------
		| Card Spine Buttons
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'card_spine_buttons',
			[
				'label' => esc_html__('Card', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* card_spine_width */
		$this->add_responsive_control(
			'card_spine_width',
			[
				'label' => esc_html__('Card Width', ELEPHANT),
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
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .chat-spine-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/* card_spine_padding */
		$this->add_responsive_control(
			'card_spine_padding',
			array(
				'label'      => esc_html__('Card Padding', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors'  => array(
					'{{WRAPPER}} .chat-spine-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/* card_spine_border_radius */
		$this->add_responsive_control(
			'card_spine_border_radius',
			array(
				'label'      => esc_html__('Card Border Radius', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px'),
				'selectors'  => array(
					'{{WRAPPER}} .chat-spine-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/* card_spine_background */
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'card_spine_background',
				'label' => esc_html__('Card Background Color', ELEPHANT),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .chat-spine-button',
			]
		);


		//============================== END SECTION
		$this->end_controls_section();


		/*
		|--------------------------------------------------------------------------
		| Card List
		|--------------------------------------------------------------------------
		*/
		$this->start_controls_section(
			'card_spine_list',
			[
				'label' => esc_html__('Card List', ELEPHANT),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* card_list_padding */
		$this->add_responsive_control(
			'card_list_padding',
			array(
				'label'      => esc_html__('List Padding', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px'),
				'selectors'  => array(
					'{{WRAPPER}} .chat-spine-button .option' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/* card_list_border_radius */
		$this->add_responsive_control(
			'card_list_border_radius',
			array(
				'label'      => esc_html__('List Border Radius', ELEPHANT),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px'),
				'selectors'  => array(
					'{{WRAPPER}} .chat-spine-button .option' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		/* card_spine_list_background */
		$this->add_control(
			'card_spine_list_background',
			array(
				'label'     => esc_html__('List Background Color', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button .option' => 'background-color: {{VALUE}}',
				),
				'separator'  => 'before'
			)
		);

		/* card_spine_list_background_hover */
		$this->add_control(
			'card_spine_list_background_hover',
			array(
				'label' => esc_html__('List Background Hover',
					ELEPHANT
				),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button .option:hover' => 'background-color: {{VALUE}}',
				),
				'separator'  => 'after'
			)
		);


		/* card_list_font */
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('List Font', ELEPHANT),
				'name' => 'card_list_font',
				'selector' => '{{WRAPPER}} .chat-spine-button .option-text',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		/* card_list_font_color */
		$this->add_control(
			'card_list_font_color',
			array(
				'label'     => esc_html__('Font Color', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button .option-text' => 'color: {{VALUE}}',
				),
			)
		);

		/* card_list_font_color_hover */
		$this->add_control(
			'card_list_font_color_hover',
			array(
				'label'     => esc_html__('Font Hover', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button a.option:hover .option-text' => 'color: {{VALUE}} !important',
				),
				'separator'  => 'after'
			) 
		);

		/* card_list_box_shadow */
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_list_box_shadow',
				'label' => esc_html__('List Shadow', ELEPHANT),
				'selector' =>
				'{{WRAPPER}} .chat-spine-button .option',
			]
		);

		/* card_list_icon_size */
		$this->add_control(
			'card_list_icon_size',
			[
				'label' => esc_html__('Icon Size', ELEPHANT),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .chat-spine-button .option-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before'
			]
		);

		/* card_list_icon_color */
		$this->add_control(
			'card_list_icon_color',
			array(
				'label'     => esc_html__('Icon Color', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button .option-icon i' => 'color: {{VALUE}}',
				),
				'separator'  => 'before'
			)
		);

		/* card_list_icon_color_hover */
		$this->add_control(
			'card_list_icon_color_hover',
			array(
				'label'     => esc_html__('Icon Hover', ELEPHANT),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .chat-spine-button a.option:hover i' => 'color: {{VALUE}} !important',
				),
				'separator'  => 'after'
			)
		);

		//============================== END SECTION
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$data_spine = [
			"spine_default_animation" => $settings['spine_default_animation'],
			"spine_box_width" => $settings['spine_box_width'],
			"spine_box_height" => $settings['spine_box_height'],
			"spine_position_x" => $settings['spine_position_x'],
			"spine_position_y" => $settings['spine_position_y'],
			"spine_scale" => $settings['spine_scale'],
			"spine_url" => $settings['spine_url']
		];

?>
		<div class="chatSpine" id="chatSpine" data-spine='<?php _e(json_encode($data_spine, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)) ?>'>
			<div id="chat-spine-buttons" style="display:none">
				<div class="chat-spine-button animate__animated">
					<div class="options">

						<?php

						if ($settings['list']) {

							foreach ($settings['list'] as $key => $buttons) { ?>
								<a href="<?= $buttons['list_url']['url'] ?>" class="option">
									<div class="option-icon">
										<?php \Elementor\Icons_Manager::render_icon($buttons['icon'], ['aria-hidden' => 'true']); ?>
									</div>
									<div class="option-text">
										<span><?= $buttons['list_title'] ?></span>
									</div>
								</a>
						<?php
							}
						}

						?>

					</div>
				</div>
			</div>
		</div>


<?php

	}
}