<?php
/**
 * CartModule::module_styles().
 *
 * @package MEE\Modules\CartModule
 * @since ??
 */

namespace MEE\Modules\CartModule\CartModuleTrait;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Options\Text\TextStyle;
use ET\Builder\Packages\Module\Options\Css\CssStyle;
use MEE\Modules\CartModule\CartModule;

trait ModuleStylesTrait {

	use CustomCssTrait;

	/**
	 * Cart Module's style components.
	 *
	 * This function is equivalent of JS function ModuleStyles located in
	 * src/components/cart-module/styles.tsx.
	 *
	 * @since ??
	 *
	 * @param array $args {
	 *     An array of arguments.
	 *
	 *      @type string $id                Module ID. In VB, the ID of module is UUIDV4. In FE, the ID is order index.
	 *      @type string $name              Module name.
	 *      @type string $attrs             Module attributes.
	 *      @type string $parentAttrs       Parent attrs.
	 *      @type string $orderClass        Selector class name.
	 *      @type string $parentOrderClass  Parent selector class name.
	 *      @type string $wrapperOrderClass Wrapper selector class name.
	 *      @type string $settings          Custom settings.
	 *      @type string $state             Attributes state.
	 *      @type string $mode              Style mode.
	 *      @type ModuleElements $elements  ModuleElements instance.
	 * }
	 */
	public static function module_styles( $args ) {
		$attrs    = $args['attrs'] ?? [];
		$elements = $args['elements'];
		$settings = $args['settings'] ?? [];

		Style::add(
			[
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => [
					// Module.
					$elements->style(
						[
							'attrName'   => 'module',
							'styleProps' => [
								'disabledOn'     => [
									'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
								],
								'advancedStyles' => [
									[
										'componentName' => 'divi/text',
										'props'         => [
											'selector' => "{$args['orderClass']} .medita_cart_module__inner",
											'attr'     => $attrs['module']['advanced']['text'] ?? [],
										]
									]
								]
							],
						]
					),

					/*
					 * We need to add CssStyle at the very bottom of other
					 * components so that custom css can override module styles
					 * till we find a more elegant solution.
					 */
					CssStyle::style(
						[
							'selector'  => $args['orderClass'],
							'attr'      => $attrs['css'] ?? [],
							'cssFields' => CartModule::custom_css(),
						]
					)
				],
			]
		);
	}
} 