// External dependencies.
import {
	FormatBreakpointStateAttr,
	InternalAttrs,
	type Element,
	type Module,
} from '@divi/types';// Divi dependencies.
import { ModuleEditProps } from '@divi/module-library';

/**
 * Cart Module CSS Attribute interface.
 *
 * @since 1.0.0
 */
export interface CartModuleCssAttr extends Module.Css.AttributeValue {
	link?: string;
	icon?: string;
	count?: string;
}

/**
 * Cart Module CSS Group Attribute type.
 *
 * @since 1.0.0
 */
export type CartModuleCssGroupAttr = FormatBreakpointStateAttr<CartModuleCssAttr>;

/**
 * Cart Module Attributes interface.
 *
 * @since 1.0.0
 */
export interface CartModuleAttrs extends InternalAttrs {
	// CSS options is used across multiple elements inside the module thus it deserves its own top property.
	css?: CartModuleCssGroupAttr;

	// Module
	module?: {
		meta?: Element.Meta.Attributes;
		advanced?: {
			link?: Element.Advanced.Link.Attributes;
			htmlAttributes?: Element.Advanced.IdClasses.Attributes;
			text?: Element.Advanced.Text.Attributes;
		};
		decoration?: Element.Decoration.PickedAttributes<
			'animation' |
			'background' |
			'border' |
			'boxShadow' |
			'disabledOn' |
			'filters' |
			'overflow' |
			'position' |
			'scroll' |
			'sizing' |
			'spacing' |
			'sticky' |
			'transform' |
			'transition' |
			'zIndex'
		>;
		scriptData?: {
			cartUrl: string;
			cartCount: number;
		};
	};
}

/**
 * Cart Module Edit Props type.
 *
 * @since 1.0.0
 */
export type CartModuleEditProps = ModuleEditProps<CartModuleAttrs>;

/**
 * Cart Module Script Data interface.
 *
 * @since 1.0.0
 */
export interface CartModuleScriptData {
	module: {
		cartCount: number;
		cartUrl: string;
	};
}

/**
 * Cart Module Classnames interface.
 *
 * @since 1.0.0
 */
export interface CartModuleClassnames {
	module: string[];
} 