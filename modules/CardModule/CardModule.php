<?php

/**
 * Module: Static Module class.
 *
 * @package MEE\Modules\StaticModule
 * @since ??
 */

namespace MEE\Modules\CardModule;

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;


/**
 * `StaticModule` is consisted of functions used for Static Module such as Front-End rendering, REST API Endpoints etc.
 *
 * This is a dependency class and can be used as a dependency for `DependencyTree`.
 *
 * @since ??
 */
class CardModule implements DependencyInterface
{
    use CardModuleTrait\RenderCallbackTrait;
    use CardModuleTrait\ModuleClassnamesTrait;
    use CardModuleTrait\ModuleStylesTrait;
    use CardModuleTrait\ModuleScriptDataTrait;
    /**
     * Loads `StaticModule` and registers Front-End render callback and REST API Endpoints.
     *
     * @since ??
     *
     * @return void
     */
    public function load()
    {
        $module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'card-module/';

        add_action(
            'init',
            function () use ($module_json_folder_path) {
                ModuleRegistration::register_module(
                    $module_json_folder_path,
                    [
                        'render_callback' => [CardModule::class, 'render_callback'],
                    ]
                );
            }
        );
    }
}
