// Divi dependencies.
import { ModuleEditProps } from '@divi/module-library';
import {
  FormatBreakpointStateAttr,
  InternalAttrs,
  type Element,
  type Module,
} from '@divi/types';

export interface HeaderModuleCssAttr extends Module.Css.AttributeValue {
  container?: string;
  logo?: string;
  navigation?: string;
  megaMenu?: string;
  actionButtons?: string;
  primaryButton?: string;
  profileLink?: string;
  cartLink?: string;
  mobileToggle?: string;
  mobileMenu?: string;
}

export type HeaderModuleCssGroupAttr = FormatBreakpointStateAttr<HeaderModuleCssAttr>;

export interface StringValue {
  value: string;
}

export interface BooleanValue {
  value: boolean;
}

export interface HeaderModuleAttrs extends InternalAttrs {
  // CSS options is used across multiple elements inside the module
  css?: HeaderModuleCssGroupAttr;
  
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
  };
  
  // Logo
  logo?: {
    image_id?: { desktop?: { value: string } };
    decoration?: Element.Decoration.PickedAttributes<
      'sizing' |
      'spacing'
    >;
  };
  
  // Menu
  menu?: {
    location?: { desktop?: { value: string } };
    decoration?: Element.Decoration.PickedAttributes<
      'font' |
      'spacing'
    >;
  };
  
  // Buttons
  buttons?: {
    show?: { desktop?: { value: boolean } };
    primary?: {
      text?: { desktop?: { value: string } };
      url?: { desktop?: { value: string } };
    };
    decoration?: Element.Decoration.PickedAttributes<
      'background' |
      'border' |
      'font' |
      'spacing'
    >;
  };
  
  // Mega Menu
  megaMenu?: {
    enabled?: { desktop?: { value: boolean } };
    decoration?: Element.Decoration.PickedAttributes<
      'background' |
      'border' |
      'boxShadow'
    >;
  };
}

export type HeaderModuleEditProps = ModuleEditProps<HeaderModuleAttrs>;