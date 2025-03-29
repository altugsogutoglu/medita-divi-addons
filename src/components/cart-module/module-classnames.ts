// External Dependencies.
import { ModuleClassnamesParams, textOptionsClassnames } from '@divi/module';

// Local Dependencies.
import { CartModuleAttrs } from './types';

/**
 * Module classnames function for Cart Module.
 *
 * @since 1.0.0
 *
 * @param {ModuleClassnamesParams<CartModuleAttrs>} params Function parameters.
 */
export const moduleClassnames = ({
	classnamesInstance,
	attrs,
}: ModuleClassnamesParams<CartModuleAttrs>): void => {
	const textOptionsClasses = textOptionsClassnames(attrs?.module?.advanced?.text);
	
	// Text Options.
	if (textOptionsClasses) {
		classnamesInstance.add(textOptionsClasses, true);
	}
}; 