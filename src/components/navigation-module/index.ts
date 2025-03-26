import {
  type Metadata,
  type ModuleLibrary,
} from '@divi/types';
import { NavigationModuleEdit } from './edit';
import metadata from './module.json';
import { NavigationModuleAttrs } from './types';
import { placeholderContent } from './placeholder-content';

import './module.scss';


export const navigationModule: ModuleLibrary.Module.RegisterDefinition<NavigationModuleAttrs> = {
  // Imported json has no inferred type hence type-cast is necessary.
  metadata: metadata as Metadata.Values<NavigationModuleAttrs>,
  placeholderContent,
  renderers: {
    edit: NavigationModuleEdit,
  },
};
