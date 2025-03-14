// Divi dependencies.
import {placeholderContent as placeholder} from '@divi/module-utils';

// Local dependencies.
import {CardModuleAttrs} from './types';

export const placeholderContent: CardModuleAttrs = {
  title: {
    innerContent: {
      desktop: {
        value: 'Card Title',
      },
    }
  },
  content: {
    innerContent: {
      desktop: {
        value: 'This is a sample card content. You can add description text, features, or any other information that belongs in this card.',
      },
    }
  },
  image: {
    innerContent: {
      desktop: {
        value: {
          src: placeholder.image.landscape,
        },
      },
    },
  },
};