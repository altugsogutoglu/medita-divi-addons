// External dependencies.
import React, {ReactElement} from 'react';

// Divi dependencies.
import {
  StyleContainer,
  StylesProps,
  CssStyle,
  TextStyle,
} from '@divi/module';

// Local dependencies.
import {CardModuleAttrs} from './types';
import {cssFields} from './custom-css';

/**
 * Card Module's style components.
 *
 * @since ??
 */
export const ModuleStyles = ({
    attrs,
    elements,
    settings,
    orderClass,
    mode,
    state,
    noStyleTag,
  }: StylesProps<CardModuleAttrs>): ReactElement => {
  const textSelector = `${orderClass} .example_card_module__content-container`;
  
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
      
      {/* Image */}
      {elements.style({
        attrName: 'image',
      })}
      
      {/* Title */}
      {elements.style({
        attrName: 'title',
      })}
      
      {/* Content */}
      {elements.style({
        attrName: 'content',
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