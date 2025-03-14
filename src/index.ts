import { omit } from 'lodash';
import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { childModule } from './components/child-module';
import { dynamicModule } from './components/dynamic-module';
import { parentModule } from './components/parent-module';
import { staticModule } from './components/static-module';
import { cardModule } from './components/card-module'; // Add this import
import './module-icons';

// Register modules.
addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'extensionExample', () => {
  registerModule(staticModule.metadata, omit(staticModule, 'metadata'));
  registerModule(dynamicModule.metadata, omit(dynamicModule, 'metadata'));
  registerModule(childModule.metadata, omit(childModule, 'metadata'));
  registerModule(parentModule.metadata, omit(parentModule, 'metadata'));
  registerModule(cardModule.metadata, omit(cardModule, 'metadata')); // Add this line
});