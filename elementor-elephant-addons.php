<?php

/**
 * Elementor Elephant Addons
 *
 * @package ElementorElephantAddons
 *
 * Plugin Name: Elementor Elephant Addons
 * Description: Addons for elementor
 * Plugin URI:  https://github.com/worldvisual/elementor-addons
 * Version:     1.0.0
 * Author:      Samuel Prado Almeida
 * Author URI:  https://samuelalmeida.dev.br
 * Text Domain: elementor-elephant-addons
 */

define( 'ELEPHANT_ADDONS', __FILE__ );
define( 'ELEPHANT', 'Elementor Elephant Addons' );

/*
|--------------------------------------------------------------------------
| Class elementor elephant addons
|--------------------------------------------------------------------------
*/

require plugin_dir_path( ELEPHANT_ADDONS ) . 'class-elephant-addons.php';