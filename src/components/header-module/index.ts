// Divi dependencies.
import {
  type Metadata,
  type ModuleLibrary,
} from '@divi/types';

// Local dependencies.
import metadata from './module.json';
import { HeaderModuleEdit } from './edit';
import { HeaderModuleAttrs } from './types';
import { placeholderContent } from './placeholder-content';

// Styles.
import './style.scss';
import './module.scss';

export const headerModule: ModuleLibrary.Module.RegisterDefinition<HeaderModuleAttrs> = {
  // Imported json has no inferred type hence type-cast is necessary.
  metadata: metadata as Metadata.Values<HeaderModuleAttrs>,
  placeholderContent,
  renderers: {
    edit: HeaderModuleEdit,
  },
};