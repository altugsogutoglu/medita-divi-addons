<?php
/**
 * CartModule::custom_css().
 *
 * @package MEE\Modules\CartModule
 * @since ??
 */
namespace MEE\Modules\CartModule\CartModuleTrait;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

trait CustomCssTrait {
    /**
     * Custom CSS fields
     *
     * This function is equivalent of JS const cssFields located in
     * src/components/cart-module/custom-css.ts.
     *
     * A minor difference with the JS const cssFields, this function did not have `label` property on each array item.
     *
     * @since ??
     */
    public static function custom_css() {
        return \WP_Block_Type_Registry::get_instance()->get_registered( 'example/cart-module' )->customCssFields;
    }
}