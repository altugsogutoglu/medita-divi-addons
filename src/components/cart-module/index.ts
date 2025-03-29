// External dependencies.
import {
  type Metadata,
  type ModuleLibrary,
} from '@divi/types';

// Local dependencies.
import metadata from './module.json';
import { CartModuleEdit } from './edit';
import { CartModuleAttrs } from './types';
import { placeholderContent } from './placeholder-content';

// Styles.
import './style.scss';
import './module.scss';

/**
 * Cart Module registration definition.
 * 
 * @since 1.0.0
 */
export const cartModule: ModuleLibrary.Module.RegisterDefinition<CartModuleAttrs> = {
  // Imported json has no inferred type hence type-cast is necessary.
  metadata: metadata as Metadata.Values<CartModuleAttrs>,
  placeholderContent,
  renderers: {
    edit: CartModuleEdit,
  },
}; 