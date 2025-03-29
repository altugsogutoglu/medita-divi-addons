<?php

namespace MEE\Modules\HeaderModule;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;

class HeaderModule implements DependencyInterface {
	use HeaderModuleTrait\RenderCallbackTrait;
    use HeaderModuleTrait\ModuleClassnamesTrait;
    use HeaderModuleTrait\ModuleStylesTrait;
    use HeaderModuleTrait\ModuleScriptDataTrait;

	public function load() {
		$module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'header-module/';

		add_action(
			'init',
			function() use ( $module_json_folder_path ) {
				ModuleRegistration::register_module(
					$module_json_folder_path,
					[
						'render_callback' => [ HeaderModule::class, 'render_callback' ],
					]
				);
			}
		);
	}
}
