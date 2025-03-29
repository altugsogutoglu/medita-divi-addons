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
import { HeaderModuleAttrs } from './types';
import { cssFields } from './custom-css';

/**
 * Header Module's style components.
 *
 * @since 1.0.0
 */
export const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}: StylesProps<HeaderModuleAttrs>): ReactElement => {
  const textSelector = `${orderClass} .header_inner`;
  
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
      
      {/* Logo */}
      {elements.style({
        attrName: 'logo',
      })}
      
      {/* Menu */}
      {elements.style({
        attrName: 'menu',
      })}
      
      {/* Buttons */}
      {elements.style({
        attrName: 'buttons',
      })}
      
      {/* Mega Menu */}
      {elements.style({
        attrName: 'megaMenu',
      })}
      
      {/**
       * We need to add CssStyle at the very bottom of other components
       * so that custom css can override module styles till we find a
       * more elegant solution.
       */}
      <CssStyle
        selector={orderClass}
        attr={attrs.css}
        cssFields={cssFields}
      />
    </StyleContainer>
  );
};