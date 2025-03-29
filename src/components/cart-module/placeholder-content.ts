// External dependencies.
import { placeholderContent as placeholder } from '@divi/module-utils';

// Local dependencies.
import { CartModuleAttrs } from './types';

/**
 * Placeholder content for Cart Module.
 *
 * @since 1.0.0
 */
export const placeholderContent: CartModuleAttrs = {
	module: {
		meta: {
			adminLabel: {
				desktop: {
					value: 'Cart Module',
				},
			},
		},
		scriptData: {
			cartUrl: '/cart',
			cartCount: 0,
		},
	},
}; 