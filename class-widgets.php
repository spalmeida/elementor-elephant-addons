<?php

/**
 * Widgets class.
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

namespace ElephantAddons;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

class Widgets
{

	private static $instance = null;

	/*
	|--------------------------------------------------------------------------
	| instance
	|--------------------------------------------------------------------------
	*/
	
	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/*
	|--------------------------------------------------------------------------
	| include_widgets_files
	|--------------------------------------------------------------------------
	*/
	private function include_widgets_files()
	{
		require_once 'widgets/datalist/class-datalist.php';
		require_once 'widgets/spine/class-spine-chat.php';
	}

	/*
	|--------------------------------------------------------------------------
	| register_widgets
	|--------------------------------------------------------------------------
	*/
	public function register_widgets()
	{
		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Datalist());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SpineChat());
	}

	/*
	|--------------------------------------------------------------------------
	| __construct Register the widgets
	|--------------------------------------------------------------------------
	*/
	public function __construct()
	{
		add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
	}
}

// Instantiate the Widgets class.
Widgets::instance();
