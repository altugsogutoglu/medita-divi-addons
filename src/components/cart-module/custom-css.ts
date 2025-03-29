// External dependencies.
import { __ } from '@wordpress/i18n';

// Local dependencies.
import { CartModuleAttrs } from './types';
import metadata from './module.json';

/**
 * Custom CSS fields for Cart Module.
 * 
 * @since 1.0.0
 */
const customCssFields = metadata.customCssFields as Record<
	'link' | 'icon' | 'count', 
	{ subName: string, selector?: string, selectorSuffix: string, label: string }
>;

// Add translatable labels
customCssFields.link.label = __('Cart Link', 'medita-divi-addons');
customCssFields.icon.label = __('Cart Icon', 'medita-divi-addons');
customCssFields.count.label = __('Cart Count', 'medita-divi-addons');

/**
 * Export CSS fields for use in styles component.
 */
export const cssFields = { ...customCssFields };

/**
 * Custom CSS for Cart Module.
 *
 * @since 1.0.0
 *
 * @param {CartModuleAttrs} attrs Module attributes.
 *
 * @returns {Object} Custom CSS selectors.
 */
export const customCss = (attrs: CartModuleAttrs) => {
	return {
		module: {
			selector: '.medita_cart_module',
		},
	};
}; 