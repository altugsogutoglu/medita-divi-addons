// External Dependencies.
import React, { ReactElement } from 'react';

// Divi Dependencies.
import { ModuleContainer } from '@divi/module';

// Local Dependencies.
import { CartModuleEditProps } from './types';
import { ModuleStyles } from './styles';
import { moduleClassnames } from './module-classnames';
import { ModuleScriptData } from './module-script-data';

/**
 * Cart Module edit component of visual builder.
 *
 * @since 1.0.0
 *
 * @param {CartModuleEditProps} props React component props.
 *
 * @returns {ReactElement}
 */
export const CartModuleEdit = (props: CartModuleEditProps): ReactElement => {
	const {
		attrs,
		elements,
		id,
		name,
	} = props;

	const scriptData = attrs.module?.scriptData;

	return (
		<ModuleContainer
			attrs={attrs}
			elements={elements}
			id={id}
			name={name}
			stylesComponent={ModuleStyles}
			classnamesFunction={moduleClassnames}
			scriptDataComponent={ModuleScriptData}
		>
			{elements.styleComponents({
				attrName: 'module',
			})}
			<div className="medita_cart_module__inner">
				<a href={scriptData?.cartUrl || '/cart'} className="medita_cart_module__link">
					<svg
						className="medita_cart_module__icon"
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						strokeWidth="2"
						strokeLinecap="round"
						strokeLinejoin="round"
					>
						<circle cx="9" cy="21" r="1"></circle>
						<circle cx="20" cy="21" r="1"></circle>
						<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
					</svg>
					<span className="medita_cart_module__count">
						{scriptData?.cartCount || 0}
					</span>
				</a>
			</div>
		</ModuleContainer>
	);
}; 