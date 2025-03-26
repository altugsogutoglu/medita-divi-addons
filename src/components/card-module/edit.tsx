// External Dependencies.
import React, { ReactElement } from 'react';
import classnames from 'classnames';

// Divi Dependencies.
import { ModuleContainer } from '@divi/module';

// Local Dependencies.
import { CardModuleEditProps } from './types';
import { ModuleStyles } from './styles';
import { moduleClassnames } from './module-classnames';
import { ModuleScriptData } from './module-script-data';

/**
 * Card Module edit component of visual builder.
 *
 * @since ??
 *
 * @param {CardModuleEditProps} props React component props.
 *
 * @returns {ReactElement}
 */
// In your edit.tsx file
export const CardModuleEdit = (props: CardModuleEditProps): ReactElement => {
  const {
    attrs,
    elements,
    id,
    name,
  } = props;

  // Get image attributes
  const imageSrc = attrs?.image?.innerContent?.desktop?.value?.src ?? '';
  const imageAlt = attrs?.image?.innerContent?.desktop?.value?.alt ?? '';
  const linkUrl = attrs?.module?.advanced?.link?.desktop?.value?.url ?? '';

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
      <div className="example_card_module__inner">
        <div className="example_card_module__image">
          <img src={imageSrc} alt={imageAlt} />
        </div>
        <div className="example_card_module__content-container">
          {elements.render({
            attrName: 'title',
          })}
          <div className="example_card_module__content">
            {elements.render({
              attrName: 'content',
            })}
          </div>
          <div className="example_card_module__link">
            <a href={linkUrl} target="_blank" rel="noopener noreferrer">
              Learn More
            </a>
          </div>
        </div>
      </div>
    </ModuleContainer>
  );
};