// Divi dependencies.
import {placeholderContent as placeholder} from '@divi/module-utils';

// Local dependencies.
import { NavigationModuleAttrs } from './types';


export const placeholderContent: NavigationModuleAttrs = {
  title: {
    innerContent: {
      desktop: {
        value: placeholder.title,
      }
    }
  },
};
