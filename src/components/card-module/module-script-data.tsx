import React, {
    Fragment,
    ReactElement,
  } from 'react';
  import {
    ModuleScriptDataProps,
  } from '@divi/module';
  import { CardModuleAttrs } from './types';
  
  /**
   * Card module's script data component.
   *
   * @since ??
   *
   * @param {ModuleScriptDataProps<CardModuleAttrs>} props React component props.
   *
   * @returns {ReactElement}
   */
  export const ModuleScriptData = ({
    elements,
  }: ModuleScriptDataProps<CardModuleAttrs>): ReactElement => (
    <Fragment>
      {elements.scriptData({
        attrName: 'module',
      })}
    </Fragment>
  );