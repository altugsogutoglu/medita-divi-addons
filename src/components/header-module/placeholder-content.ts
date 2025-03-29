// Divi dependencies.
import { placeholderContent as placeholder } from '@divi/module-utils';
// Local dependencies.
import { HeaderModuleAttrs } from './types';

export const placeholderContent: HeaderModuleAttrs = {
  module: {
    meta: {
      adminLabel: {
        desktop: {
          value: 'Header Module',
        },
      }
    },
    advanced: {
      text: {
        text: {
          desktop: {
            value: {
              color: 'dark'
            }
          }
        }
      }
    }
  },
  logo: {
    image_id: '',
  },
  menu: {
    location: {
      value: 'primary-menu'
    }
  },
  buttons: {
    show: {
      value: true
    },
    primary: {
      text: {
        value: 'Get Started'
      },
      url: {
        value: '#'
      }
    }
  },
  megaMenu: {
    enabled: {
      value: true
    }
  }
};