import { addFilter } from '@wordpress/hooks';
import {
  moduleDynamic,
  moduleParent,
  moduleStatic,
  moduleCard,
  moduleCart,
  moduleHeader,
} from './icons';

// Add example module icons
addFilter('divi.iconLibrary.icon.map', 'extensionExample', (icons) => {
  return {
    ...icons,
    [moduleParent.name]: moduleParent,
    [moduleStatic.name]: moduleStatic,
    [moduleDynamic.name]: moduleDynamic,
    [moduleCard.name]: moduleCard,
    [moduleCart.name]: moduleCart,
    [moduleHeader.name]: moduleHeader,
  };
});
