// External dependencies.
import React, {
	Fragment,
	ReactElement,
} from 'react';

// Divi dependencies.
import {
	ModuleScriptDataProps,
} from '@divi/module';

// Local dependencies.
import { CartModuleAttrs } from './types';

/**
 * Cart module's script data component.
 *
 * @since 1.0.0
 *
 * @param {ModuleScriptDataProps<CartModuleAttrs>} props React component props.
 *
 * @returns {ReactElement}
 */
export const ModuleScriptData = ({
	elements,
}: ModuleScriptDataProps<CartModuleAttrs>): ReactElement => (
	<Fragment>
		{elements.scriptData({
			attrName: 'module',
		})}
	</Fragment>
); 