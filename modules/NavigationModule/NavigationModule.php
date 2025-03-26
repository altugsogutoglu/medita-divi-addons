<?php
/**
 * Module: Dynamic Module class.
 *
 * @package MEE\Modules\DynamicModule
 * @since ??
 */

namespace MEE\Modules\NavigationModule;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
use MEE\Modules\NavigationModule\NavigationModuleTrait;

/**
 * `DynamicModule` is consisted of functions used for Dynamic Module such as Front-End rendering, REST API Endpoints etc.
 *
 * This is a dependency class and can be used as a dependency for `DependencyTree`.
 *
 * @since ??
 */
class NavigationModule implements DependencyInterface {
	use NavigationModuleTrait\RenderCallbackTrait;

	/**
	 * Loads `DynamicModule` and registers Front-End render callback and REST API Endpoints.
	 *
	 * @since ??
	 *
	 * @return void
	 */
	public function load() {
		$module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'navigation-module/';

		add_action(
			'init',
			function() use ( $module_json_folder_path ) {
				ModuleRegistration::register_module(
					$module_json_folder_path,
					[
						'render_callback' => [ NavigationModule::class, 'render_callback' ],
					]
				);
			}
		);
	}
}
