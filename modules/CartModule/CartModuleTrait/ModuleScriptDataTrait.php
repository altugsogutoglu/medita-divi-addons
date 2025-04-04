<?php

/**
 * CartModule::module_script_data()
 *
 * @package MEE\Modules\CartModule
 * @since ??
 */

namespace MEE\Modules\CartModule\CartModuleTrait;

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Layout\Components\MultiView\MultiViewScriptData;
use ET\Builder\Packages\Module\Options\Element\ElementScriptData;

trait ModuleScriptDataTrait
{
    /**
     * Set script data of used module options.
     *
     * @since ??
     *
     * @param array $args {
     *   Array of arguments.
     *
     *   @type string $id       Module id.
     *   @type string $selector Module selector.
     *   @type array  $attrs    Module attributes.
     * }
     */
    public static function module_script_data($args)
    {
        // Assign variables.
        $id             = $args['id'] ?? '';
        $name           = $args['name'] ?? '';
        $selector       = $args['selector'] ?? '';
        $attrs          = $args['attrs'] ?? [];
        $store_instance = $args['storeInstance'] ?? null;
        // Module decoration attributes.
        $module_decoration_attrs = $attrs['module']['decoration'] ?? [];

        // Element Script Data Options.
        ElementScriptData::set(
            [
                'id'            => $id,
                'selector'      => $selector,
                'attrs'         => array_merge(
                    $module_decoration_attrs,
                    [
                        'link' => $args['attrs']['module']['advanced']['link'] ?? [],
                    ]
                ),
                'storeInstance' => $store_instance,
            ]
        );

        

        MultiViewScriptData::set(
            [
                'id'            => $id,
                'name'          => $name,
                'hoverSelector' => $selector,
                'setContent'    => [
                    [
                        'selector'      => $selector . ' .medita_cart_module__count',
                        'data'          => [
                            'desktop' => [
                                'value' => function_exists('WC') && WC()->cart ? (string)WC()->cart->get_cart_contents_count() : '0',
                            ],
                        ],
                        'valueResolver' => function ($value) {
                            return (string)($value ?? '0');
                        },
                    ],
                ],
                'setAttrs'      => [
                    [
                        'selector'      => $selector . ' .medita_cart_module__link',
                        'data'          => [
                            'href' => [
                                'desktop' => [
                                    'value' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#',
                                ],
                            ],
                        ],
                        'valueResolver' => function ($value) {
                            return $value ?? '#';
                        },
                        'tag'           => 'a',
                    ],
                ],
            ]
        );
    }
}
