<?php

/**
 * Module: Cart Module class.
 *
 * @package MEE\Modules\CartModule
 * @since ??
 */

namespace MEE\Modules\CartModule;

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;


/**
 * `CartModule` is consisted of functions used for Cart Module such as Front-End rendering, REST API Endpoints etc.
 *
 * This is a dependency class and can be used as a dependency for `DependencyTree`.
 *
 * @since ??
 */
class CartModule implements DependencyInterface
{
    use CartModuleTrait\RenderCallbackTrait;
    use CartModuleTrait\ModuleClassnamesTrait;
    use CartModuleTrait\ModuleStylesTrait;
    use CartModuleTrait\ModuleScriptDataTrait;
    /**
     * Loads `CartModule` and registers Front-End render callback and REST API Endpoints.
     *
     * @since ??
     *
     * @return void
     */
    public function load()
    {
        $module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'cart-module/';

        add_action(
            'init',
            function () use ($module_json_folder_path) {
                ModuleRegistration::register_module(
                    $module_json_folder_path,
                    [
                        'render_callback' => [CartModule::class, 'render_callback'],
                    ]
                );
            }
        );
    }
}
