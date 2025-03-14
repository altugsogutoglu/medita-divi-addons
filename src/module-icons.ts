import { addFilter } from '@wordpress/hooks';
import {
  moduleDynamic,
  moduleParent,
  moduleStatic,
  moduleCard, // Add this import
} from './icons';

// Add module icons to the icon library.
addFilter('divi.iconLibrary.icon.map', 'extensionExample', (icons) => {
  return {
    ...icons, // This is important. Without this, all other icons will be overwritten.
    [moduleParent.name]:  moduleParent,
    [moduleStatic.name]:  moduleStatic,
    [moduleDynamic.name]: moduleDynamic,
    [moduleCard.name]:    moduleCard, // Add this line
  };
});