<?php
/**
 * HeaderModule::module_styles()
 *
 * @package MEE\Modules\HeaderModule
 * @since 1.0.0
 */
namespace MEE\Modules\HeaderModule\HeaderModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Layout\Components\StyleCommon\CommonStyle;
use ET\Builder\Packages\Module\Options\Css\CssStyle;
use MEE\Modules\HeaderModule\HeaderModule;

trait ModuleStylesTrait {
    use CustomCssTrait;
    
    /**
     * Header module's style components.
     *
     * @since 1.0.0
     *
     * @param array $args Function arguments.
     */
    public static function module_styles($args) {
        $attrs = $args['attrs'] ?? [];
        $elements = $args['elements'];
        $order_class = $args['orderClass'];
        $settings = $args['settings'] ?? [];
        
        Style::add([
            'id' => $args['id'],
            'name' => $args['name'],
            'orderIndex' => $args['orderIndex'],
            'storeInstance' => $args['storeInstance'],
            'styles' => [
                // Main header container
                $elements->style([
                    'attrName' => 'module',
                    'styleProps' => [
                        'disabledOn' => [
                            'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
                        ],
                        'advancedStyles' => [
                            // Text styles for the entire header
                            [
                                'componentName' => 'divi/text',
                                'props' => [
                                    'selector' => "{$order_class}",
                                    'attr' => $attrs['module']['advanced']['text'] ?? [],
                                ]
                            ],
                            // Sticky header behavior
                            [
                                'componentName' => 'divi/sticky',
                                'props' => [
                                    'selector' => "{$order_class}",
                                    'attr' => $attrs['module']['decoration']['sticky'] ?? [],
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Logo section
                $elements->style([
                    'attrName' => 'logo',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Logo sizing
                            [
                                'componentName' => 'divi/sizing',
                                'props' => [
                                    'selector' => "{$order_class} .header_logo img",
                                    'attr' => $attrs['logo']['decoration']['sizing'] ?? [],
                                ]
                            ],
                            // Logo spacing
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_logo",
                                    'attr' => $attrs['logo']['decoration']['spacing'] ?? [],
                                ]
                            ],
                            // Logo transitions
                            [
                                'componentName' => 'divi/transition',
                                'props' => [
                                    'selector' => "{$order_class} .header_logo img",
                                    'attr' => $attrs['logo']['decoration']['transition'] ?? [],
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Navigation menu container
                $elements->style([
                    'attrName' => 'navigation',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Menu container spacing
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation",
                                    'attr' => $attrs['navigation']['decoration']['spacing'] ?? [],
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Menu items styling
                $elements->style([
                    'attrName' => 'menuItems',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Font styles for menu items
                            [
                                'componentName' => 'divi/font',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .menu-item > a",
                                    'attr' => $attrs['menuItems']['decoration']['font'] ?? [],
                                ]
                            ],
                            // Spacing between menu items
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .menu-item",
                                    'attr' => $attrs['menuItems']['decoration']['spacing'] ?? [],
                                ]
                            ],
                            // Hover effects for menu items
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .menu-item > a:hover",
                                    'attr' => $attrs['menuItems']['states']['hover'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                            // Active menu item style
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .menu-item.current-menu-item > a",
                                    'attr' => $attrs['menuItems']['states']['active'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Dropdown/Mega menu styling
                $elements->style([
                    'attrName' => 'megaMenu',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Mega menu container background
                            [
                                'componentName' => 'divi/background',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu",
                                    'attr' => $attrs['megaMenu']['decoration']['background'] ?? [],
                                ]
                            ],
                            // Mega menu container border
                            [
                                'componentName' => 'divi/border',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu",
                                    'attr' => $attrs['megaMenu']['decoration']['border'] ?? [],
                                ]
                            ],
                            // Mega menu container shadow
                            [
                                'componentName' => 'divi/box-shadow',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu",
                                    'attr' => $attrs['megaMenu']['decoration']['boxShadow'] ?? [],
                                ]
                            ],
                            // Mega menu column title styles
                            [
                                'componentName' => 'divi/font',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu .column-title",
                                    'attr' => $attrs['megaMenu']['columnTitle']['decoration']['font'] ?? [],
                                ]
                            ],
                            // Mega menu link styles
                            [
                                'componentName' => 'divi/font',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu .menu-item > a",
                                    'attr' => $attrs['megaMenu']['menuItem']['decoration']['font'] ?? [],
                                ]
                            ],
                            // Mega menu link hover styles
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_navigation .mega-menu .menu-item > a:hover",
                                    'attr' => $attrs['megaMenu']['menuItem']['states']['hover'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // CTA buttons styling
                $elements->style([
                    'attrName' => 'buttons',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Button font
                            [
                                'componentName' => 'divi/font',
                                'props' => [
                                    'selector' => "{$order_class} .header_button",
                                    'attr' => $attrs['buttons']['decoration']['font'] ?? [],
                                ]
                            ],
                            // Button background
                            [
                                'componentName' => 'divi/background',
                                'props' => [
                                    'selector' => "{$order_class} .header_button",
                                    'attr' => $attrs['buttons']['decoration']['background'] ?? [],
                                ]
                            ],
                            // Button border
                            [
                                'componentName' => 'divi/border',
                                'props' => [
                                    'selector' => "{$order_class} .header_button",
                                    'attr' => $attrs['buttons']['decoration']['border'] ?? [],
                                ]
                            ],
                            // Button padding
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_button",
                                    'attr' => $attrs['buttons']['decoration']['spacing'] ?? [],
                                ]
                            ],
                            // Button hover state
                            [
                                'componentName' => 'divi/background',
                                'props' => [
                                    'selector' => "{$order_class} .header_button:hover",
                                    'attr' => $attrs['buttons']['states']['hover']['background'] ?? [],
                                ]
                            ],
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_button:hover",
                                    'attr' => $attrs['buttons']['states']['hover']['text'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                            [
                                'componentName' => 'divi/border',
                                'props' => [
                                    'selector' => "{$order_class} .header_button:hover",
                                    'attr' => $attrs['buttons']['states']['hover']['border'] ?? [],
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Profile icon styling
                $elements->style([
                    'attrName' => 'profile',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Icon size
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_profile_icon",
                                    'attr' => $attrs['profile']['decoration']['size'] ?? [],
                                    'property' => 'font-size',
                                ]
                            ],
                            // Icon color
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_profile_icon",
                                    'attr' => $attrs['profile']['decoration']['color'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                            // Icon spacing
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_profile_icon",
                                    'attr' => $attrs['profile']['decoration']['spacing'] ?? [],
                                ]
                            ],
                            // Hover color
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_profile_icon:hover",
                                    'attr' => $attrs['profile']['states']['hover'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Cart icon styling
                $elements->style([
                    'attrName' => 'cart',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Icon size
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_icon",
                                    'attr' => $attrs['cart']['decoration']['size'] ?? [],
                                    'property' => 'font-size',
                                ]
                            ],
                            // Icon color
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_icon",
                                    'attr' => $attrs['cart']['decoration']['color'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                            // Icon spacing
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_icon",
                                    'attr' => $attrs['cart']['decoration']['spacing'] ?? [],
                                ]
                            ],
                            // Cart count bubble styles
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_count",
                                    'attr' => $attrs['cart']['count']['decoration']['color'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                            [
                                'componentName' => 'divi/background',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_count",
                                    'attr' => $attrs['cart']['count']['decoration']['background'] ?? [],
                                ]
                            ],
                            // Hover color
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_cart_icon:hover",
                                    'attr' => $attrs['cart']['states']['hover'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Mobile menu toggle button
                $elements->style([
                    'attrName' => 'mobileToggle',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Button size
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_mobile_toggle",
                                    'attr' => $attrs['mobileToggle']['decoration']['size'] ?? [],
                                    'property' => 'font-size',
                                ]
                            ],
                            // Button color
                            [
                                'componentName' => 'divi/common',
                                'props' => [
                                    'selector' => "{$order_class} .header_mobile_toggle",
                                    'attr' => $attrs['mobileToggle']['decoration']['color'] ?? [],
                                    'property' => 'color',
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Mobile menu styling
                $elements->style([
                    'attrName' => 'mobileMenu',
                    'styleProps' => [
                        'advancedStyles' => [
                            // Menu background
                            [
                                'componentName' => 'divi/background',
                                'props' => [
                                    'selector' => "{$order_class} .header_mobile_menu",
                                    'attr' => $attrs['mobileMenu']['decoration']['background'] ?? [],
                                ]
                            ],
                            // Menu items font
                            [
                                'componentName' => 'divi/font',
                                'props' => [
                                    'selector' => "{$order_class} .header_mobile_menu .menu-item > a",
                                    'attr' => $attrs['mobileMenu']['menuItem']['decoration']['font'] ?? [],
                                ]
                            ],
                            // Menu items spacing
                            [
                                'componentName' => 'divi/spacing',
                                'props' => [
                                    'selector' => "{$order_class} .header_mobile_menu .menu-item",
                                    'attr' => $attrs['mobileMenu']['menuItem']['decoration']['spacing'] ?? [],
                                ]
                            ],
                        ]
                    ],
                ]),
                
                // Custom CSS
                CssStyle::style([
                    'selector' => $order_class,
                    'attr' => $attrs['css'] ?? [],
                    'cssFields' => self::custom_css(),
                ]),
            ],
        ]);
    }
}