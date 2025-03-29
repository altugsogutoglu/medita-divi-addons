import React, {
    Fragment,
    ReactElement,
  } from 'react';
  import {
    ModuleScriptDataProps,
  } from '@divi/module';
  import { HeaderModuleAttrs } from './types';
  

  export const ModuleScriptData = ({
    elements,
  }: ModuleScriptDataProps<HeaderModuleAttrs>): ReactElement => (
    <Fragment>
      {elements.scriptData({
        attrName: 'module',
      })}
    </Fragment>
  );