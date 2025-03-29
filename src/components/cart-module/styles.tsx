// External dependencies.
import React, { ReactElement } from 'react';

// Divi dependencies.
import {
	StyleContainer,
	StylesProps,
	CssStyle,
	TextStyle,
} from '@divi/module';

// Local dependencies.
import { CartModuleAttrs } from './types';
import { cssFields } from './custom-css';

/**
 * Cart Module's style components.
 *
 * @since 1.0.0
 *
 * @param {StylesProps<CartModuleAttrs>} props React component props.
 *
 * @returns {ReactElement}
 */
export const ModuleStyles = ({
	attrs,
	elements,
	settings,
	orderClass,
	mode,
	state,
	noStyleTag,
}: StylesProps<CartModuleAttrs>): ReactElement => {
	const textSelector = `${orderClass} .medita_cart_module__inner`;

	return (
		<StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
			{/* Module */}
			{elements.style({
				attrName: 'module',
				styleProps: {
					disabledOn: {
						disabledModuleVisibility: settings?.disabledModuleVisibility,
					},
					advancedStyles: [
						{
							componentName: "divi/text",
							props: {
								selector: textSelector,
								attr: attrs?.module?.advanced?.text,
							}
						}
					]
				},
			})}

			{/* Link */}
			{elements.style({
				attrName: 'link',
			})}

			{/* Icon */}
			{elements.style({
				attrName: 'icon',
			})}

			{/* Count */}
			{elements.style({
				attrName: 'count',
			})}

			{/* Custom CSS */}
			<CssStyle
				selector={orderClass}
				attr={attrs.css}
				cssFields={cssFields}
			/>
		</StyleContainer>
	);
}; 