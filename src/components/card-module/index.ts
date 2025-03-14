// Divi dependencies.
import {
    type Metadata,
    type ModuleLibrary,
  } from '@divi/types';
  
  // Local dependencies.
  import metadata from './module.json';
  import { CardModuleEdit } from './edit';
  import { CardModuleAttrs } from './types';
  import { placeholderContent } from './placeholder-content';
  
  // Styles.
  import './style.scss';
  import './module.scss';
  
  export const cardModule: ModuleLibrary.Module.RegisterDefinition<CardModuleAttrs> = {
    // Imported json has no inferred type hence type-cast is necessary.
    metadata: metadata as Metadata.Values<CardModuleAttrs>,
    placeholderContent,
    renderers: {
      edit: CardModuleEdit,
    },
  };