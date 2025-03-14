<?php
/*
Plugin Name: Medita Divi Addons
Plugin URI:
Description: A collection of modules developed and maintained by Medita Design.
Version:     1.0.0
Author:      Medita Design
Author URI:  https://medita.nl/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: medita-divi-addons
Domain Path: /languages

*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

define( 'MEDITA_ADDONS_MODULES_PATH', plugin_dir_path( __FILE__ ) );
define( 'MEDITA_ADDONS_MODULES_JSON_PATH', MEDITA_ADDONS_MODULES_PATH . 'modules-json/' );

/**
 * Requires Autoloader.
 */
require MEDITA_ADDONS_MODULES_PATH . 'vendor/autoload.php';
require MEDITA_ADDONS_MODULES_PATH . 'modules/Modules.php';

/**
 * Enqueue style and scripts of Module Extension Example for Visual Builder.
 *
 * @since ??
 */
function medita_addons_enqueue_vb_scripts() {
	if ( et_builder_d5_enabled() && et_core_is_fb_enabled() ) {
		$plugin_dir_url = plugin_dir_url( __FILE__ );

		\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
			[
				'name'   => 'medita-addons-modules-builder-bundle-script',
				'version' => '1.0.0',
				'script' => [
					'src' => "{$plugin_dir_url}scripts/bundle.js",
					'deps'               => [
						'divi-module-library',
						'divi-vendor-wp-hooks',
					],
					'enqueue_top_window' => false,
					'enqueue_app_window' => true,
				],
			]
		);

		\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
			[
				'name'   => 'medita-addons-builder-vb-bundle-style',
				'version' => '1.0.0',
				'style' => [
					'src' => "{$plugin_dir_url}styles/vb-bundle.css",
					'deps'               => [],
					'enqueue_top_window' => false,
					'enqueue_app_window' => true,
				],
			]
		);
	}
}
add_action('divi_visual_builder_assets_before_enqueue_scripts', 'medita_addons_enqueue_vb_scripts');
/**
 * Enqueue style and scripts of Module Extension Example
 *
 * @since ??
 */
function medita_addons_enqueue_frontend_scripts() {
	$plugin_dir_url = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'medita-addons-builder-bundle-style', "{$plugin_dir_url}styles/bundle.css", array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'medita_addons_enqueue_frontend_scripts' );
